<?php
// database/seeders/PromoBannerSeeder.php

namespace Database\Seeders;

use App\Models\PromoBanner;
use Illuminate\Database\Seeder;

class PromoBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'eyebrow'     => 'Limited Time',
                'heading'     => 'Up to 40% Off Season Picks',
                'description' => 'Refresh their wardrobe with our favourite everyday essentials — soft fabrics, bright colours, and prices that make you smile.',
                'cta_label'   => 'Shop the Sale',
                'cta_href'    => '/shop/sale',
                'image'       => 'promo-banners/sale.jpg',
            ],
            [
                'eyebrow'     => 'New Arrivals',
                'heading'     => 'Little Looks, Big Personality',
                'description' => 'Discover the newest pieces from our latest collection — thoughtfully designed for everyday adventures and special moments.',
                'cta_label'   => 'Shop New Arrivals',
                'cta_href'    => '/shop/new-arrivals',
                'image'       => 'promo-banners/new-arrivals.jpg',
            ],
        ];

        foreach ($banners as $banner) {
            PromoBanner::create($banner);
        }
    }
}
