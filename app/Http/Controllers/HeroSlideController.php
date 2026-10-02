<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller  
{
    /* ---------- public: list all slides ---------- */
    public function index()
    {
        $slides = HeroSlide::query()
            ->orderBy('id')
            ->get();

        return response()->json(['slides' => $slides]);
    }

    /* ---------- admin: single slide ---------- */
    public function show(HeroSlide $heroSlide)
    {
        return response()->json(['slide' => $heroSlide]);
    }

    /* ---------- admin: create ---------- */
    public function store(Request $request)
    {
        $validated = $this->validateSlide($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('hero', 'public');
        }

        $slide = HeroSlide::create($validated);

        return response()->json([
            'message' => 'Hero slide created successfully.',
            'slide'   => $slide,
        ], 201);
    }

    /* ---------- admin: update ---------- */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $this->validateSlide($request, $heroSlide->id);

        if ($request->hasFile('image')) {
            // delete old image
            if ($heroSlide->image) {
                Storage::disk('public')->delete($heroSlide->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('hero', 'public');
        }

        $heroSlide->update($validated);

        return response()->json([
            'message' => 'Hero slide updated successfully.',
            'slide'   => $heroSlide->fresh(),
        ]);
    }

    /* ---------- admin: delete ---------- */
    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image) {
            Storage::disk('public')->delete($heroSlide->image);
        }

        $heroSlide->delete();

        return response()->json([
            'message' => 'Hero slide deleted successfully.',
        ]);
    }

    /* ---------- shared validation ---------- */
    private function validateSlide(Request $request, ?int $ignoreId = null): array
    {
        $imageRule = $ignoreId
            ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
            : 'required|image|mimes:jpg,jpeg,png,webp|max:5120';

        return $request->validate([
            'label'                 => 'required|string|max:100',
            'heading'               => 'required|string',
            'description'           => 'required|string',
            'primary_cta_label'     => 'required|string|max:100',
            'primary_cta_href'      => 'required|string|max:255',
            'secondary_cta_label'   => 'required|string|max:100',
            'secondary_cta_href'    => 'required|string|max:255',
            'image'                 => $imageRule,
        ]);
    }
}