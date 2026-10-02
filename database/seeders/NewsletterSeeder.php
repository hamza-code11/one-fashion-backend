<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    public function run(): void
    {
        $subscribers = [
            'ayesha.khan@example.com',
            'zain.ali@example.com',
            'hira.m@example.com',
            'ali.raza@example.com',
            'sara.n@example.com',
            'hamza98.dev@gmail.com',
            'maryam.t@example.com',
            'bilal.ahmed@example.com',
            'noor.f@example.com',
            'hassan.k@example.com',
            'fatima.s@example.com',
            'usman.j@example.com',
            'ayesha.malik@example.com',
            'zara.hussain@example.com',
            'omar.farooq@example.com',
            'mahnoor.iqbal@example.com',
            'saad.tariq@example.com',
            'areeba.noor@example.com',
            'danish.raza@example.com',
            'laiba.shah@example.com',
            'taha.javed@example.com',
            'insha.khalid@example.com',
        ];

        foreach ($subscribers as $email) {
            Newsletter::create(['email' => $email]);
        }
    }
}
