<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // -----------------------------------------
    // Public Website - All Categories
    // -----------------------------------------
    public function index()
    {
        $categories = cache()->remember(
            'categories.all',
            now()->addMinutes(30),
            function () {
                return Category::orderBy('id')->get();
            }
        );

        return response()->json([
            'categories' => $categories,
        ]);
    }


    // -----------------------------------------
    // Admin - Paginated Categories
    // -----------------------------------------
    public function adminIndex(Request $request)
    {
        $search = trim($request->input('search', ''));

        $categories = Category::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json([
            'categories' => $categories,
        ]);
    }


    // -----------------------------------------
    // Store
    // -----------------------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'slug' => 'nullable|string|max:120|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['name']);

        $category = Category::create($validated);

        // Clear public cache
        cache()->forget('categories.all');

        return response()->json([
            'message' => 'Category created successfully.',
            'category' => $category,
        ], 201);
    }


    // -----------------------------------------
    // Update
    // -----------------------------------------
    public function update(
        Request $request,
        Category $category
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name,' . $category->id,
            ],
            'slug' => [
                'nullable',
                'string',
                'max:120',
                'unique:categories,slug,' . $category->id,
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['name']);

        $category->update($validated);

        // Clear public cache
        cache()->forget('categories.all');

        return response()->json([
            'message' => 'Category updated successfully.',
            'category' => $category->fresh(),
        ]);
    }


    // -----------------------------------------
    // Delete
    // -----------------------------------------
    public function destroy(Category $category)
    {
        $category->delete();

        // Clear public cache
        cache()->forget('categories.all');

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
