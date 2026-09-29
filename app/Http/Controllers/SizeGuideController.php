<?php

namespace App\Http\Controllers;

use App\Models\SizeGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SizeGuideController extends Controller
{
    private string $cacheKey = 'size_guides';

    /**
     * Get all size guides
     */
    public function index()
    {
        $sizeGuides = Cache::remember(
            $this->cacheKey,
            now()->addHours(24),
            function () {
                return SizeGuide::orderBy('id')->get();
            }
        );

        return response()->json([
            'size_guides' => $sizeGuides,
        ]);
    }

    /**
     * Search size guides
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:50',
        ]);

        $search = trim($validated['search'] ?? '');

        // Empty search → cached complete list
        if ($search === '') {
            return $this->index();
        }

        $sizeGuides = SizeGuide::query()
            ->where('size', 'LIKE', "%{$search}%")
            ->orWhere('height', 'LIKE', "%{$search}%")
            ->orWhere('weight', 'LIKE', "%{$search}%")
            ->orWhere('chest', 'LIKE', "%{$search}%")
            ->orderBy('id')
            ->get();

        return response()->json([
            'size_guides' => $sizeGuides,
        ]);
    }

    /**
     * Store size guide
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'size' => 'required|string|max:20',
            'height' => 'required|string|max:30',
            'weight' => 'required|string|max:30',
            'chest' => 'required|string|max:20',
        ]);

        $sizeGuide = SizeGuide::create($validated);

        // Clear old cache
        Cache::forget($this->cacheKey);

        return response()->json([
            'message' => 'Size guide created successfully.',
            'size_guide' => $sizeGuide,
        ], 201);
    }

    /**
     * Update size guide
     */
    public function update(
        Request $request,
        SizeGuide $sizeGuide
    ) {
        $validated = $request->validate([
            'size' => 'required|string|max:20',
            'height' => 'required|string|max:30',
            'weight' => 'required|string|max:30',
            'chest' => 'required|string|max:20',
        ]);

        $sizeGuide->update($validated);

        // Clear old cache
        Cache::forget($this->cacheKey);

        return response()->json([
            'message' => 'Size guide updated successfully.',
            'size_guide' => $sizeGuide->fresh(),
        ]);
    }

    /**
     * Delete size guide
     */
    public function destroy(SizeGuide $sizeGuide)
    {
        $sizeGuide->delete();

        // Clear old cache
        Cache::forget($this->cacheKey);

        return response()->json([
            'message' => 'Size guide deleted successfully.',
        ]);
    }
}