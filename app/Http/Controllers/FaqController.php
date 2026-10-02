<?php
// app/Http/Controllers/FaqController.php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /* ---------- public: get faq content ---------- */
    public function index()
    {
        $faq = Faq::first();

        return response()->json(['faq' => $faq]);
    }

    /* ---------- admin: update faq content ---------- */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'eyebrow'     => 'required|string|max:100',
            'heading'     => 'required|string|max:255',
            'description' => 'required|string',

            'items'                 => 'required|array|min:1',
            'items.*.question'      => 'required|string|max:255',
            'items.*.answer'        => 'required|string',
        ]);

        $faq = Faq::firstOrNew();
        $faq->fill($validated);
        $faq->save();

        return response()->json([
            'message' => 'FAQ updated successfully.',
            'faq'     => $faq->fresh(),
        ]);
    }
}
