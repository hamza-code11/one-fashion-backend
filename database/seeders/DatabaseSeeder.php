<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $this->call([
            // UserSeeder::class,
            // SizeGuideSeeder::class,
            // CollectionSeeder::class,
            // BrandSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
            // RatingSeeder::class,
            // HeroSlideSeeder::class,
            // PromoBannerSeeder::class,
            // StatItemSeeder::class,
            // AboutSeeder::class,
            // FaqSeeder::class,
            // AnnouncementSeeder::class,
            // InstagramSeeder::class,
            // NewsletterSeeder::class,
            // ContactSeeder::class,
            // ContactInfoSeeder::class,
        ]);
    }
}
