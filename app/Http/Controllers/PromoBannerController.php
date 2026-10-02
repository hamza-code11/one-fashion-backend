<?php
// app/Http/Controllers/PromoBannerController.php

namespace App\Http\Controllers;

use App\Models\PromoBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoBannerController extends Controller
{
    /* ---------- public: list all banners ---------- */
    public function index()
    {
        $banners = PromoBanner::query()
            ->orderBy('id')
            ->get();

        return response()->json(['banners' => $banners]);
    }

    /* ---------- admin: single banner ---------- */
    public function show(PromoBanner $promoBanner)
    {
        return response()->json(['banner' => $promoBanner]);
    }

    /* ---------- admin: create ---------- */
    public function store(Request $request)
    {
        $validated = $this->validateBanner($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('promo-banners', 'public');
        }

        $banner = PromoBanner::create($validated);

        return response()->json([
            'message' => 'Promo banner created successfully.',
            'banner'  => $banner,
        ], 201);
    }

    /* ---------- admin: update ---------- */
    public function update(Request $request, PromoBanner $promoBanner)
    {
        $validated = $this->validateBanner($request, $promoBanner->id);

        if ($request->hasFile('image')) {
            if ($promoBanner->image) {
                Storage::disk('public')->delete($promoBanner->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('promo-banners', 'public');
        }

        $promoBanner->update($validated);

        return response()->json([
            'message' => 'Promo banner updated successfully.',
            'banner'  => $promoBanner->fresh(),
        ]);
    }

    /* ---------- admin: delete ---------- */
    public function destroy(PromoBanner $promoBanner)
    {
        if ($promoBanner->image) {
            Storage::disk('public')->delete($promoBanner->image);
        }

        $promoBanner->delete();

        return response()->json([
            'message' => 'Promo banner deleted successfully.',
        ]);
    }

    /* ---------- shared validation ---------- */
    private function validateBanner(Request $request, ?int $ignoreId = null): array
    {
        $imageRule = $ignoreId
            ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
            : 'required|image|mimes:jpg,jpeg,png,webp|max:5120';

        return $request->validate([
            'eyebrow'     => 'required|string|max:100',
            'heading'     => 'required|string|max:255',
            'description' => 'required|string',
            'cta_label'   => 'required|string|max:100',
            'cta_href'    => 'required|string|max:255',
            'image'       => $imageRule,
        ]);
    }
}
