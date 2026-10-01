<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private const CACHE_KEY = 'categories.all';

    // -----------------------------------------
    // Public Website - All Categories
    // -----------------------------------------
    public function index()
    {
        $categories = Cache::remember(
            self::CACHE_KEY,
            600,
            fn () => Category::withCount('products')->latest()->get()
        );

        return response()->json([
            'categories' => $categories,
        ]);
    }


    // Public - Single category with products
    public function showBySlug(string $slug)
    {
        $category = Category::query()
            ->withCount('products')
            ->where('slug', $slug)
            ->firstOrFail();

        $products = $category->products()
            ->with([
                'brand:id,name',
                'category:id,name',
                'collections:id,name', 
                'images' => fn ($q) => $q->where('is_main', true)
                    ->select('id', 'product_id', 'image'),
            ])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->where('status', 'published')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
    }



    // -----------------------------------------
    // Admin - Paginated Categories
    // -----------------------------------------
    public function adminIndex()
    {
        $categories = Category::query()
            ->withCount('products')
            ->latest()
            ->paginate(10);

        return response()->json($categories);
    }

    // -----------------------------------------
    // Admin - Search
    // -----------------------------------------
    public function search(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::query()
            ->withCount('products')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->limit(50)
            ->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    // -----------------------------------------
    // Admin - Single category
    // -----------------------------------------
    public function show(Category $category)
    {
        return response()->json([
            'category' => $category->loadCount('products'),
        ]);
    }

    // -----------------------------------------
    // Store
    // -----------------------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'slug'        => 'required|string|max:120|unique:categories,slug',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create($validated);

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message'  => 'Category created successfully.',
            'category' => $category,
        ], 201);
    }

    // -----------------------------------------
    // Update
    // -----------------------------------------
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name,' . $category->id,
            'slug'        => 'required|string|max:120|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'removeImage' => 'nullable|boolean',
        ]);

        unset($validated['removeImage']);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $validated['image'] = $request->file('image')->store('categories', 'public');
        } elseif ($request->boolean('removeImage')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        $category->update($validated);

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message'  => 'Category updated successfully.',
            'category' => $category->fresh(),
        ]);
    }

    // -----------------------------------------
    // Delete
    // -----------------------------------------
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return response()->json([
                'message' => 'Cannot delete category — it has products attached.',
            ], 422);
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
