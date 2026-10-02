<?php
// app/Http/Controllers/ContactInfoController.php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    /* ---------- public: get contact info ---------- */
    public function index()
    {
        $info = ContactInfo::first();

        return response()->json(['contact_info' => $info]);
    }

    /* ---------- admin: update contact info (singleton) ---------- */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:50',
            'address' => 'required|string|max:255',

            'days' => 'required|string|max:100',
            'time' => 'required|string|max:100',

            'facebook_url'  => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'twitter_url'   => 'nullable|url|max:500',
            'youtube_url'   => 'nullable|url|max:500',
        ]);

        $info = ContactInfo::firstOrNew();
        $info->fill($validated);
        $info->save();

        return response()->json([
            'message'      => 'Contact info updated successfully.',
            'contact_info' => $info->fresh(),
        ]);
    }
}
