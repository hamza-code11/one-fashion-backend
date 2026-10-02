<?php
// database/seeders/StatItemSeeder.php

namespace Database\Seeders;

use App\Models\StatItem;
use Illuminate\Database\Seeder;

class StatItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['value' => '10,000+', 'label' => 'Happy Customers'],
            ['value' => '5,000+',  'label' => 'Orders Delivered'],
            ['value' => '4.9 / 5', 'label' => 'Average Rating'],
            ['value' => '7 Days',  'label' => 'Easy Returns'],
        ];

        foreach ($items as $item) {
            StatItem::create($item);
        }
    }
}

