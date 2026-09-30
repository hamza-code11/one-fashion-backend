<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    // Website listing
    public function index()
    {
        $products = Product::query()
            ->with([
                'brand:id,name',
                'category:id,name',
                'images' => function ($query) {
                    $query->where('is_main', true)
                        ->select('id', 'product_id', 'image');
                },
            ])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->where('status', 'published')
            ->paginate(10);

        return response()->json($products);
    }


    // Admin listing
    public function adminIndex()
    {
        $products = Product::query()
            ->with([
                'brand:id,name',
                'category:id,name',
                'images' => function ($query) {
                    $query
                        ->where('is_main', true)
                        ->select('id', 'product_id', 'image');
                },
            ])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json($products);
    }


    // Search products - Admin
    public function search(Request $request)
    {
        $search = trim($request->input('search', ''));

        $products = Product::query()
            ->with([
                'brand:id,name',
                'category:id,name',
                'images' => function ($query) {
                    $query
                        ->where('is_main', true)
                        ->select('id', 'product_id', 'image');
                },
            ])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('gender', 'like', "%{$search}%")
                        ->orWhereHas('brand', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        return response()->json($products);
    }


    // Admin - Single product (id se, koi status filter nahi)
    public function adminShow(Product $product)
    {
        return response()->json([
            'product' => $product->load([
                'brand',
                'category',
                'images',
                'colors',
                'sizes',
                'collections',
            ]),
        ]);
    }


    // Product details
    public function show(string $slug)
    {
        $product = Product::query()
            ->with([
                'brand',
                'category',
                'images',
                'colors',
                'sizes',
                'collections',
                'ratings.user',
            ])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json([
            'product' => $product,
        ]);
    }




    // Store (create)
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        $product = DB::transaction(function () use ($validated, $request) {

            $product = Product::create([
                'brand_id'     => $validated['brand_id'],
                'category_id'  => $validated['category_id'],
                'name'         => $validated['name'],
                'slug'         => $validated['slug'],
                'description'  => $validated['description'],
                'price'        => $validated['price'],
                'old_price'    => $validated['old_price'] ?? null,
                'gender'       => $validated['gender'],
                'badge'        => $validated['badge'] ?? null,
                'status'       => $validated['status'],
                'stock_status' => $validated['stock_status'],
            ]);

            if (!empty($validated['colors'])) {
                $product->colors()->createMany($validated['colors']);
            }

            $this->storeImages($product, $request);

            $product->sizes()->sync($validated['size_ids'] ?? []);
            $product->collections()->sync($validated['collection_ids'] ?? []);

            return $product;
        });

        $product->load(['brand', 'category', 'images', 'colors', 'sizes', 'collections']);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }

    // Update
    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);

        DB::transaction(function () use ($validated, $product, $request) {

            $product->update([
                'brand_id'     => $validated['brand_id'],
                'category_id'  => $validated['category_id'],
                'name'         => $validated['name'],
                'slug'         => $validated['slug'],
                'description'  => $validated['description'],
                'price'        => $validated['price'],
                'old_price'    => $validated['old_price'] ?? null,
                'gender'       => $validated['gender'],
                'badge'        => $validated['badge'] ?? null,
                'status'       => $validated['status'],
                'stock_status' => $validated['stock_status'],
            ]);

            // ---- Colors ----
            if (array_key_exists('colors', $validated)) {
                $product->colors()->delete();

                if (!empty($validated['colors'])) {
                    $product->colors()->createMany($validated['colors']);
                }
            }

            // ---- Images ----
            // Frontend sends:
            //   new images in 'images'    → upload them
            //   removeImages = 1          → delete all old images (no new ones provided)
            //   keep existing             → don't touch
            if (!empty($validated['images'])) {
                // Upload new first, then delete old (safer)
                $newPaths = $this->uploadFiles($request);

                foreach ($product->images as $old) {
                    Storage::disk('public')->delete($old->image);
                }
                $product->images()->delete();

                foreach ($validated['images'] as $index => $imageData) {
                    $product->images()->create([
                        'image'   => $newPaths[$index],
                        'is_main' => (bool) $imageData['is_main'],
                    ]);
                }
            } elseif ($request->boolean('removeImages')) {
                foreach ($product->images as $old) {
                    Storage::disk('public')->delete($old->image);
                }
                $product->images()->delete();
            }

            // ---- Sizes / Collections ----
            $product->sizes()->sync($validated['size_ids'] ?? []);
            $product->collections()->sync($validated['collection_ids'] ?? []);
        });

        $product->load(['brand', 'category', 'images', 'colors', 'sizes', 'collections']);

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product,
        ]);
    }

    // Shared validation
    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:255|unique:products,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }

        $validated = $request->validate([
            'brand_id'     => 'required|exists:brands,id',
            'category_id'  => 'required|exists:categories,id',

            'name'         => 'required|string|max:255',
            'slug'         => $slugRule,
            'description'  => 'required|string',

            'price'        => 'required|numeric|min:0',
            'old_price'    => 'nullable|numeric|min:0',

            'gender'       => 'required|string|max:50',
            'badge'        => 'nullable|in:NEW,SALE,HOT',
            'status'       => 'required|in:draft,published',
            'stock_status' => 'required|in:in_stock,out_of_stock',

            'colors'                => 'nullable|array',
            'colors.*.name'         => 'required|string|max:100',
            'colors.*.value'        => 'required|string|max:100',

            'images'                => 'nullable|array',
            'images.*.image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'images.*.is_main'      => 'required|in:0,1',

            'size_ids'              => 'nullable|array',
            'size_ids.*'            => 'integer|exists:size_guides,id',

            'collection_ids'        => 'nullable|array',
            'collection_ids.*'      => 'integer|exists:collections,id',
        ]);

        // Business rule: only ONE main image allowed
        if (!empty($validated['images'])) {
            $mainCount = collect($validated['images'])
                ->where('is_main', '1')
                ->count();

            if ($mainCount > 1) {
                throw ValidationException::withMessages([
                    'images' => 'Only one image can be marked as main.',
                ]);
            }
        }

        return $validated;
    }

    // Store single product's images (used in store)
    private function storeImages(Product $product, Request $request): void
    {
        if (empty($request->file('images'))) {
            return;
        }

        foreach ($request->file('images') as $index => $file) {
            if (!$file || !isset($file['image'])) {
                continue;
            }

            $path = $file['image']->store('products', 'public');

            $product->images()->create([
                'image'   => $path,
                'is_main' => (bool) ($request->input("images.$index.is_main") === '1'),
            ]);
        }
    }

    // Upload all files, return array of paths keyed by index
    private function uploadFiles(Request $request): array
    {
        $paths = [];

        foreach ($request->file('images', []) as $index => $file) {
            if (!$file || !isset($file['image'])) {
                continue;
            }

            $paths[$index] = $file['image']->store('products', 'public');
        }

        return $paths;
    }





    // Delete product
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {

            // Delete product images from storage
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image);
            }

            // Remove related records
            $product->images()->delete();
            $product->colors()->delete();
            $product->ratings()->delete();

            // Remove many-to-many relationships
            $product->sizes()->detach();
            $product->collections()->detach();

            // Delete product
            $product->delete();
        });

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}

