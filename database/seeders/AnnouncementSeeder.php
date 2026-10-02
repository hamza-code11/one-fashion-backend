<?php
// database/seeders/AnnouncementSeeder.php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'FREE SHIPPING OVER PKR 10,000',
            'NEW SEASON — LITTLE LOOKS, BIG PERSONALITY',
            'EASY 7-DAY RETURNS ACROSS PAKISTAN',
            'CASH ON DELIVERY AVAILABLE',
        ];

        foreach ($items as $text) {
            Announcement::create(['text' => $text]);
        }
    }
}
