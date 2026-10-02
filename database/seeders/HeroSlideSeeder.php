<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'label'               => 'New Season',
                'heading'             => "LITTLE\nLOOKS.\nBIG\nPERSONALITY.",
                'description'         => 'Discover stylish everyday clothing designed for little personalities — thoughtfully made for the Pakistani family.',
                'primary_cta_label'   => 'Shop New Arrivals',
                'primary_cta_href'    => '/shop/new-arrivals',
                'secondary_cta_label' => 'Explore Collection',
                'secondary_cta_href'  => '/collections',
                'image'               => 'hero/01.png',
            ],
            [
                'label'               => 'Festive Edit',
                'heading'             => "TRADITION\nMEETS\nTINY\nSTYLE.",
                'description'         => 'Celebrate every occasion with festive outfits crafted for comfort, colour, and all-day play.',
                'primary_cta_label'   => 'Shop Festive',
                'primary_cta_href'    => '/shop/festive',
                'secondary_cta_label' => 'View Lookbook',
                'secondary_cta_href'  => '/collections/festive',
                'image'               => 'hero/02.png',
            ],
            [
                'label'               => 'Everyday Basics',
                'heading'             => "SOFT.\nSIMPLE.\nMADE FOR\nEVERY DAY.",
                'description'         => 'From playdates to school runs — durable, gentle fabrics that keep up with every little adventure.',
                'primary_cta_label'   => 'Shop Everyday',
                'primary_cta_href'    => '/shop/everyday',
                'secondary_cta_label' => 'See Collection',
                'secondary_cta_href'  => '/collections/everyday',
                'image'               => 'hero/03.png',
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }
    }
}
