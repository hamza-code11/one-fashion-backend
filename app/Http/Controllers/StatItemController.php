<?php
// app/Http/Controllers/StatItemController.php

namespace App\Http\Controllers;

use App\Models\StatItem;
use Illuminate\Http\Request;

class StatItemController extends Controller
{
    /* ---------- public: list all stats ---------- */
    public function index()
    {
        $items = StatItem::query()
            ->orderBy('id')
            ->get();

        return response()->json(['items' => $items]);
    }

    /* ---------- admin: single item ---------- */
    public function show(StatItem $statItem)
    {
        return response()->json(['item' => $statItem]);
    }

    /* ---------- admin: create ---------- */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:100',
        ]);

        $item = StatItem::create($validated);

        return response()->json([
            'message' => 'Stat item created successfully.',
            'item'    => $item,
        ], 201);
    }

    /* ---------- admin: update ---------- */
    public function update(Request $request, StatItem $statItem)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:100',
        ]);

        $statItem->update($validated);

        return response()->json([
            'message' => 'Stat item updated successfully.',
            'item'    => $statItem->fresh(),
        ]);
    }

    /* ---------- admin: delete ---------- */
    public function destroy(StatItem $statItem)
    {
        $statItem->delete();

        return response()->json([
            'message' => 'Stat item deleted successfully.',
        ]);
    }
}

