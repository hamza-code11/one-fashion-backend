<?php
// app/Http/Controllers/AnnouncementController.php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /* ---------- public: list all announcements ---------- */
    public function index()
    {
        $announcements = Announcement::query()
            ->orderBy('id')
            ->get();

        return response()->json(['announcements' => $announcements]);
    }

    /* ---------- admin: single ---------- */
    public function show(Announcement $announcement)
    {
        return response()->json(['announcement' => $announcement]);
    }

    /* ---------- admin: create ---------- */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $announcement = Announcement::create($validated);

        return response()->json([
            'message'      => 'Announcement created successfully.',
            'announcement' => $announcement,
        ], 201);
    }

    /* ---------- admin: update ---------- */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $announcement->update($validated);

        return response()->json([
            'message'      => 'Announcement updated successfully.',
            'announcement' => $announcement->fresh(),
        ]);
    }

    /* ---------- admin: delete ---------- */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return response()->json([
            'message' => 'Announcement deleted successfully.',
        ]);
    }
}
