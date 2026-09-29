<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CollectionController extends Controller
{
    // Website - All collections
    public function index()
    {
        $collections = Cache::remember(
            'collections.all',
            600,
            fn () => Collection::latest()->get()
        );

        return response()->json([
            'collections' => $collections,
        ]);
    }

    // Admin - List + Search + Pagination
    public function adminIndex(Request $request)
    {
        $search = $request->input('search');

        $collections = Collection::query()
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

    // Admin - Create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:collections,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
        ]);

        $collection = Collection::create($validated);

        Cache::forget('collections.all');

        return response()->json([
            'message' => 'Collection created successfully.',
            'collection' => $collection,
        ], 201);
    }

    // Admin - Update
    public function update(
        Request $request,
        Collection $collection
    ) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:collections,slug,' . $collection->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
        ]);

        $collection->update($validated);

        Cache::forget('collections.all');

        return response()->json([
            'message' => 'Collection updated successfully.',
            'collection' => $collection->fresh(),
        ]);
    }

    // Admin - Delete
    public function destroy(Collection $collection)
    {
        $collection->delete();

        Cache::forget('collections.all');

        return response()->json([
            'message' => 'Collection deleted successfully.',
        ]);
    }
}