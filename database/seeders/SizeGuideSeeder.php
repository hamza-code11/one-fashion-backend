<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SizeGuide;

class SizeGuideSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            [
                'size' => '0-3M',
                'height' => '53–58 cm',
                'weight' => '4–6 kg',
                'chest' => '40 cm',
            ],
            [
                'size' => '3-6M',
                'height' => '58–65 cm',
                'weight' => '6–7.5 kg',
                'chest' => '44 cm',
            ],
            [
                'size' => '6-12M',
                'height' => '65–74 cm',
                'weight' => '7.5–9 kg',
                'chest' => '47 cm',
            ],
            [
                'size' => '12-18M',
                'height' => '74–80 cm',
                'weight' => '9–11 kg',
                'chest' => '50 cm',
            ],
            [
                'size' => '18-24M',
                'height' => '80–86 cm',
                'weight' => '11–12.5 kg',
                'chest' => '52 cm',
            ],
            [
                'size' => '2-3Y',
                'height' => '86–96 cm',
                'weight' => '12.5–14 kg',
                'chest' => '54 cm',
            ],
            [
                'size' => '3-4Y',
                'height' => '96–104 cm',
                'weight' => '14–16 kg',
                'chest' => '56 cm',
            ],
            [
                'size' => '4-5Y',
                'height' => '104–110 cm',
                'weight' => '16–18 kg',
                'chest' => '58 cm',
            ],
            [
                'size' => '5-6Y',
                'height' => '110–116 cm',
                'weight' => '18–20 kg',
                'chest' => '60 cm',
            ],
            [
                'size' => '6-7Y',
                'height' => '116–122 cm',
                'weight' => '20–22 kg',
                'chest' => '62 cm',
            ],
            [
                'size' => '7-8Y',
                'height' => '122–128 cm',
                'weight' => '22–25 kg',
                'chest' => '64 cm',
            ],
            [
                'size' => '8-9Y',
                'height' => '128–134 cm',
                'weight' => '25–28 kg',
                'chest' => '66 cm',
            ],
            [
                'size' => '9-10Y',
                'height' => '134–140 cm',
                'weight' => '28–31 kg',
                'chest' => '68 cm',
            ],
            [
                'size' => '10-11Y',
                'height' => '140–146 cm',
                'weight' => '31–34 kg',
                'chest' => '70 cm',
            ],
            [
                'size' => '11-12Y',
                'height' => '146–152 cm',
                'weight' => '34–37 kg',
                'chest' => '72 cm',
            ],
        ];

        SizeGuide::insert($sizes);
    }
}
