<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::pluck('id')->toArray();
        $users = User::where('role', 'user')->pluck('id')->toArray();

        if (empty($products) || empty($users)) {
            $this->command->error(
                'Products aur Users pehle seed karo — RatingSeeder ke liye zaroori hain.'
            );
            return;
        }

        /* ---------- review templates ---------- */
        $positiveReviews = [
            'Absolutely love this piece! Fabric is soft and my daughter adores it.',
            'Great quality for the price. Fits perfectly and washes well.',
            'Beautiful design and excellent stitching. Highly recommend.',
            'Fast delivery and lovely packaging. Would buy again.',
            'Exactly as pictured. My son loves wearing it every day.',
        ];

        $neutralReviews = [
            'Good quality but slightly bigger than expected. Still happy overall.',
            'Nice fabric, colour is a bit different from the photos but still lovely.',
            'Decent purchase. Delivery took a couple of extra days.',
        ];

        $negativeReviews = [
            'Fabric felt thinner than expected. Stitching is fine though.',
            'Sizing runs small — recommend ordering one size up.',
            'Colour faded slightly after the first wash.',
        ];

        /* ---------- seed ratings ---------- */
        $created = 0;

        foreach ($products as $productId) {
            // har product pe 3-8 random users review karenge
            $reviewerCount = rand(3, 8);
            $reviewerIds = collect($users)->shuffle()->take($reviewerCount);

            foreach ($reviewerIds as $userId) {
                // rating distribution: mostly 4-5, few 3s, rare 2s
                $rating = $this->randomRating();

                $review = match (true) {
                    $rating >= 4 => $positiveReviews[array_rand($positiveReviews)],
                    $rating === 3 => $neutralReviews[array_rand($neutralReviews)],
                    default       => $negativeReviews[array_rand($negativeReviews)],
                };

                Rating::create([
                    'product_id' => $productId,
                    'user_id'    => $userId,
                    'rating'     => $rating,
                    'review'     => $review,
                ]);

                $created++;
            }
        }

        $this->command->info('Ratings seeded: ' . $created);
    }

    /**
     * Weighted random rating:
     * 5 stars → 45%
     * 4 stars → 35%
     * 3 stars → 12%
     * 2 stars → 5%
     * 1 star  → 3%
     */
    private function randomRating(): int
    {
        $roll = rand(1, 100);

        return match (true) {
            $roll <= 45 => 5,
            $roll <= 80 => 4,
            $roll <= 92 => 3,
            $roll <= 97 => 2,
            default     => 1,
        };
    }
}
