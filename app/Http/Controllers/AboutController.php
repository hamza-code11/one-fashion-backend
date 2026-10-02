<?php
// app/Http/Controllers/AboutController.php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /* ---------- public: get about content ---------- */
    public function index()
    {
        $about = About::first();

        return response()->json(['about' => $about]);
    }

    /* ---------- admin: update about content ---------- */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // HERO
            'hero_eyebrow'     => 'required|string|max:100',
            'hero_heading'     => 'required|string|max:255',
            'hero_subheading'  => 'required|string|max:255',

            // STORY
            'story_eyebrow'    => 'required|string|max:100',
            'story_heading'    => 'required|string|max:255',
            'story_paragraphs' => 'required|string',
            'story_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            // PHILOSOPHY
            'philosophy_eyebrow'     => 'required|string|max:100',
            'philosophy_heading'     => 'required|string|max:255',
            'philosophy_description' => 'required|string',
            'philosophy_values'      => 'required|array|min:1',
            'philosophy_values.*.title'       => 'required|string|max:100',
            'philosophy_values.*.description' => 'required|string',

            // QUALITY
            'quality_eyebrow'     => 'required|string|max:100',
            'quality_heading'     => 'required|string|max:255',
            'quality_description' => 'required|string',
            'quality_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            // QUALITY STATS
            'quality_stats'              => 'required|array|min:1',
            'quality_stats.*.value'      => 'required|string|max:50',
            'quality_stats.*.label'      => 'required|string|max:100',
        ]);

        $about = About::firstOrNew();

        // ---- story image ----
        if ($request->hasFile('story_image')) {
            if ($about->story_image) {
                Storage::disk('public')->delete($about->story_image);
            }

            $validated['story_image'] = $request
                ->file('story_image')
                ->store('about', 'public');
        } else {
            unset($validated['story_image']);
        }

        // ---- quality image ----
        if ($request->hasFile('quality_image')) {
            if ($about->quality_image) {
                Storage::disk('public')->delete($about->quality_image);
            }

            $validated['quality_image'] = $request
                ->file('quality_image')
                ->store('about', 'public');
        } else {
            unset($validated['quality_image']);
        }

        $about->fill($validated);
        $about->save();

        return response()->json([
            'message' => 'About page updated successfully.',
            'about'   => $about->fresh(),
        ]);
    }
}
