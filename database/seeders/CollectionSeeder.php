<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        Collection::insert([
            [
                'name' => 'New Arrivals',
                'slug' => 'new-arrivals',
                'description' => 'The latest drops from our newest collection.',
                'image' => 'https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Winter Edit',
                'slug' => 'winter',
                'description' => 'Cosy layers and warm essentials for the season.',
                'image' => 'https://images.unsplash.com/photo-1522771930-78848d9293e8?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Summer Breeze',
                'slug' => 'summer',
                'description' => 'Breezy cottons and light fabrics for sunny days.',
                'image' => 'https://images.unsplash.com/photo-1596870230751-ebdfce98ec42?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Everyday Basics',
                'slug' => 'basics',
                'description' => 'Soft, simple essentials made for daily wear.',
                'image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Festive Favourites',
                'slug' => 'festive',
                'description' => 'Celebration-ready outfits for every special occasion.',
                'image' => 'https://images.unsplash.com/photo-1503944583220-79d8926ad5e2?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baby First',
                'slug' => 'baby',
                'description' => 'Gentle, thoughtful pieces for the tiniest members.',
                'image' => 'https://images.unsplash.com/photo-1522771930-78848d9293e8?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Girls Party',
                'slug' => 'girls-party',
                'description' => 'Twirl-worthy dresses for birthdays and beyond.',
                'image' => 'https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Boys Denim',
                'slug' => 'boys-denim',
                'description' => 'Rugged staples built for playground adventures.',
                'image' => 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?w=800&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}