<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    private const CACHE_KEY = 'brands.all';

    // Website - All brands
    public function index()
    {
        $brands = Cache::remember(
            self::CACHE_KEY,
            600,
            fn () => Brand::withCount('products')->latest()->get()
        );

        return response()->json([
            'brands' => $brands,
        ]);
    }

    // Admin - List + Pagination
    public function adminIndex()
    {
        $brands = Brand::query()
            ->withCount('products')
            ->latest()
            ->paginate(10);

        return response()->json($brands);
    }


    // Admin - Single brand
public function show(Brand $brand)
{
    return response()->json([
        'brand' => $brand->loadCount('products'),
    ]);
}

    // Admin - Search
    public function search(Request $request)
    {
        $search = $request->input('search');

        $brands = Brand::query()
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
            'brands' => $brands,
        ]);
    }

    // Admin - Create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:brands,slug',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('brands', 'public');
        }

        $brand = Brand::create($validated);

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message' => 'Brand created successfully.',
            'brand'   => $brand,
        ], 201);
    }

    // Admin - Update
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'removeImage' => 'nullable|boolean',
        ]);

        unset($validated['removeImage']);

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $validated['image'] = $request->file('image')->store('brands', 'public');
        } elseif ($request->boolean('removeImage')) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        $brand->update($validated);

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message' => 'Brand updated successfully.',
            'brand'   => $brand->fresh(),
        ]);
    }

    // Admin - Delete
    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message' => 'Brand deleted successfully.',
        ]);
    }
}
