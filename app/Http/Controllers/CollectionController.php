<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    private const CACHE_KEY = 'collections.all';

    // Website - All collections
    public function index()
    {
        $collections = Cache::remember(
            self::CACHE_KEY,
            600,
            fn () => Collection::withCount('products')->latest()->get()
        );

        return response()->json(['collections' => $collections]);
    }

    // Admin - List + Search + Pagination
    public function adminIndex(Request $request)
    {
        $search = $request->input('search');

        $collections = Collection::query()
            ->withCount('products')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return response()->json($collections);
    }

    // Single collection
    public function show(Collection $collection)
    {
        return response()->json([
            'collection' => $collection,
        ]);
    }

    // Admin - Create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:collections,slug',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('collections', 'public');
        }

        $collection = Collection::create($validated);

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message'    => 'Collection created successfully.',
            'collection' => $collection,
        ], 201);
    }

    // Admin - Update
    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:collections,slug,' . $collection->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'removeImage' => 'nullable|boolean',
        ]);

        unset($validated['removeImage']);

        if ($request->hasFile('image')) {
            if ($collection->image) {
                Storage::disk('public')->delete($collection->image);
            }

            $validated['image'] = $request->file('image')->store('collections', 'public');
        } elseif ($request->boolean('removeImage')) {
            if ($collection->image) {
                Storage::disk('public')->delete($collection->image);
            }

            $validated['image'] = null;
        } else {
            // Image touch hi na ho
            unset($validated['image']);
        }

        $collection->update($validated);

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message'    => 'Collection updated successfully.',
            'collection' => $collection->fresh(),
        ]);
    }

    // Admin - Delete
    public function destroy(Collection $collection)
    {
        if ($collection->image) {
            Storage::disk('public')->delete($collection->image);
        }

        $collection->delete();

        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message' => 'Collection deleted successfully.',
        ]);
    }
}
