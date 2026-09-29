<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    $query
                        ->where('is_main', true)
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
            ->paginate(10);

        return response()->json($products);
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


    // Create product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',

            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',

            'description' => 'required|string',

            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',

            'gender' => 'required|string|max:50',

            'badge' => 'nullable|in:NEW,SALE,HOT',

            'status' => 'required|in:draft,published',

            'stock_status' => 'required|in:in_stock,out_of_stock',

            'colors' => 'nullable|array',
            'colors.*.name' => 'required|string|max:100',
            'colors.*.value' => 'required|string|max:100',

            'images' => 'nullable|array',
            'images.*.image' => 'required|string',
            'images.*.is_main' => 'required|boolean',

            'size_ids' => 'nullable|array',
            'size_ids.*' => 'integer|exists:size_guides,id',

            'collection_ids' => 'nullable|array',
            'collection_ids.*' => 'integer|exists:collections,id',
        ]);

        $product = DB::transaction(function () use ($validated) {

            $product = Product::create([
                'brand_id' => $validated['brand_id'],
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'old_price' => $validated['old_price'] ?? null,
                'gender' => $validated['gender'],
                'badge' => $validated['badge'] ?? null,
                'status' => $validated['status'],
                'stock_status' => $validated['stock_status'],
            ]);

            if (!empty($validated['colors'])) {
                $product->colors()->createMany(
                    $validated['colors']
                );
            }

            if (!empty($validated['images'])) {
                $product->images()->createMany(
                    $validated['images']
                );
            }

            if (!empty($validated['size_ids'])) {
                $product->sizes()->sync(
                    $validated['size_ids']
                );
            }

            if (!empty($validated['collection_ids'])) {
                $product->collections()->sync(
                    $validated['collection_ids']
                );
            }

            return $product;
        });

        $product->load([
            'brand',
            'category',
            'images',
            'colors',
            'sizes',
            'collections',
        ]);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }


    // Update product
    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',

            'name' => 'required|string|max:255',

            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,

            'description' => 'required|string',

            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',

            'gender' => 'required|string|max:50',

            'badge' => 'nullable|in:NEW,SALE,HOT',

            'status' => 'required|in:draft,published',

            'stock_status' => 'required|in:in_stock,out_of_stock',

            'colors' => 'nullable|array',
            'colors.*.name' => 'required|string|max:100',
            'colors.*.value' => 'required|string|max:100',

            'images' => 'nullable|array',
            'images.*.image' => 'required|string',
            'images.*.is_main' => 'required|boolean',

            'size_ids' => 'nullable|array',
            'size_ids.*' => 'integer|exists:size_guides,id',

            'collection_ids' => 'nullable|array',
            'collection_ids.*' => 'integer|exists:collections,id',
        ]);

        DB::transaction(function () use ($validated, $product) {

            $product->update([
                'brand_id' => $validated['brand_id'],
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'old_price' => $validated['old_price'] ?? null,
                'gender' => $validated['gender'],
                'badge' => $validated['badge'] ?? null,
                'status' => $validated['status'],
                'stock_status' => $validated['stock_status'],
            ]);

            // Replace colors
            $product->colors()->delete();

            if (!empty($validated['colors'])) {
                $product->colors()->createMany(
                    $validated['colors']
                );
            }

            // Replace images
            $product->images()->delete();

            if (!empty($validated['images'])) {
                $product->images()->createMany(
                    $validated['images']
                );
            }

            // Replace size guides
            $product->sizes()->sync(
                $validated['size_ids'] ?? []
            );

            // Replace collections
            $product->collections()->sync(
                $validated['collection_ids'] ?? []
            );
        });

        $product->load([
            'brand',
            'category',
            'images',
            'colors',
            'sizes',
            'collections',
        ]);

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product,
        ]);
    }


    // Delete product
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {

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

