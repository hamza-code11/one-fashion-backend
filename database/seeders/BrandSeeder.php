<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::insert([
            [
                'name' => 'One + One Fashion',
                'slug' => 'one-plus-one',
                'description' => 'Our signature in-house label — thoughtfully designed in Pakistan.',
                'image' => 'https://images.unsplash.com/photo-1522771930-78848d9293e8?w=400&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Little Threads',
                'slug' => 'little-threads',
                'description' => 'Soft everyday basics for curious little ones.',
                'image' => 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?w=400&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Bloom & Co.',
                'slug' => 'bloom-and-co',
                'description' => 'Flirty florals and breezy summer pieces.',
                'image' => 'https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=400&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Denim Kids',
                'slug' => 'denim-kids',
                'description' => 'Rugged denim staples built to last.',
                'image' => 'https://images.unsplash.com/photo-1503944583220-79d8926ad5e2?w=400&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Tiny Explorer',
                'slug' => 'tiny-explorer',
                'description' => 'Outdoor-ready outfits for every adventure.',
                'image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=400&q=80',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

