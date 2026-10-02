<?php
// database/seeders/AboutSeeder.php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        About::create([
            /* ---------- HERO ---------- */
            'hero_eyebrow'    => 'Our Story',
            'hero_heading'    => 'About One + One',
            'hero_subheading' => "Modern children's fashion, made with love in Pakistan.",

            /* ---------- STORY ---------- */
            'story_eyebrow'    => 'Since Day One',
            'story_heading'    => 'Childhood, Dressed Beautifully',
            'story_paragraphs' => "one + one FASHION is a children’s clothing brand created for little personalities, big adventures and every beautiful moment in between. We believe children’s clothing should be more than just beautiful — it should feel comfortable, look effortless and let kids move, play and express themselves freely. From everyday essentials to charming outfits for special occasions, our collections bring together comfortable fabrics, thoughtful details and modern designs made for growing little ones.\n\nDesigned in Pakistan for families everywhere, one + one FASHION brings together contemporary style and the comfort children need. Every piece is thoughtfully selected with quality, practicality and timeless appeal in mind, making it easy for parents to dress their little ones with confidence. From playful days at home and family outings to celebrations and memorable occasions, we create children's fashion that fits naturally into every chapter of childhood.\n\nAt one + one FASHION, we believe the little details matter — the softness of a fabric, the freedom to move, the confidence of wearing something special and the joy of simply being a child. Our goal is to make children’s fashion beautiful, comfortable and meaningful, one little outfit at a time.",
            'story_image'      => 'about/story.jpg',

            /* ---------- PHILOSOPHY ---------- */
            'philosophy_eyebrow'     => 'What We Believe',
            'philosophy_heading'     => 'Our Philosophy',
            'philosophy_description' => 'Fashion should keep up with childhood — never the other way around. We design for movement, comfort and the little moments that become big memories.',
            'philosophy_values'      => [
                [
                    'title'       => 'Comfort First',
                    'description' => 'Breathable cottons and soft finishes, gentle on the most sensitive little skin.',
                ],
                [
                    'title'       => 'Thoughtful Detail',
                    'description' => 'From hidden snaps to reinforced knees, the small things make a big difference.',
                ],
                [
                    'title'       => 'Made To Last',
                    'description' => 'Quality construction that survives hand-me-downs, washes and wild playdays.',
                ],
            ],

            /* ---------- QUALITY ---------- */
            'quality_eyebrow'     => 'Crafted With Care',
            'quality_heading'     => 'Quality & Comfort',
            'quality_description' => "Every garment is tested for softness, durability and fit. We work closely with makers across Pakistan to ensure fair practices and finishes we're proud of — so each piece feels as good as it looks.",
            'quality_image'       => 'about/quality.jpg',

            /* ---------- QUALITY STATS ---------- */
            'quality_stats'       => [
                ['value' => '100%',     'label' => 'Cotton-rich fabrics'],
                ['value' => '7-Day',    'label' => 'Easy returns'],
                ['value' => 'Fair',     'label' => 'Made practices'],
                ['value' => 'PKR 10K+', 'label' => 'Free delivery'],
            ],
        ]);
    }
}
