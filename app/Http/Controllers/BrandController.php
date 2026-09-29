<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    // Website - All brands
    public function index()
    {
        $brands = Cache::remember(
            'brands.all',
            600,
            fn () => Brand::latest()->get()
        );

        return response()->json([
            'brands' => $brands,
        ]);
    }


    // Admin - List + Search + Pagination
    public function adminIndex(Request $request)
    {
        $search = $request->input('search');

        $brands = Brand::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return response()->json($brands);
    }


    // Admin - Create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
        ]);

        $brand = Brand::create($validated);

        // Website cache clear
        Cache::forget('brands.all');

        return response()->json([
            'message' => 'Brand created successfully.',
            'brand' => $brand,
        ], 201);
    }


    // Admin - Update
    public function update(
        Request $request,
        Brand $brand
    ) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
        ]);

        $brand->update($validated);

        // Website cache clear
        Cache::forget('brands.all');

        return response()->json([
            'message' => 'Brand updated successfully.',
            'brand' => $brand->fresh(),
        ]);
    }


    // Admin - Delete
    public function destroy(Brand $brand)
    {
        $brand->delete();

        // Website cache clear
        Cache::forget('brands.all');

        return response()->json([
            'message' => 'Brand deleted successfully.',
        ]);
    }
}