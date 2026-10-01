<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /* ---------- public: list reviews for a product ---------- */
    public function index(string $slug)
{
    $product = Product::query()
        ->select('id')
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    $ratings = Rating::query()
        ->with('user:id,first_name,last_name')   // ✅ FIX
        ->where('product_id', $product->id)
        ->orderByDesc('id')
        ->paginate(10);

    $stats = [
        'average' => round(
            Rating::where('product_id', $product->id)->avg('rating') ?? 0,
            1
        ),
        'count' => Rating::where('product_id', $product->id)->count(),
    ];

    $breakdown = Rating::query()
        ->where('product_id', $product->id)
        ->selectRaw('rating, COUNT(*) as total')
        ->groupBy('rating')
        ->pluck('total', 'rating')
        ->toArray();

    return response()->json([
        'ratings'   => $ratings,
        'stats'     => $stats,
        'breakdown' => $breakdown,
    ]);
}

    /* ---------- auth: create / update review ---------- */
    public function store(Request $request, string $slug)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:2000',
        ]);

        $product = Product::query()
            ->select('id')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $userId = $request->user()->id;

        // Ek user ek product pe sirf ek review de sakta hai — update if exists
        $rating = Rating::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id'    => $userId,
            ],
            [
                'rating' => $validated['rating'],
                'review' => $validated['review'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Review submitted successfully.',
            'rating'  => $rating->load('user:id,first_name,last_name'),
        ], 201);
    }
}
