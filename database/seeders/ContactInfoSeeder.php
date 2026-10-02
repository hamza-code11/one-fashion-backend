<?php
// database/seeders/ContactInfoSeeder.php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    public function run(): void
    {
        ContactInfo::create([
            'email'   => 'hello@oneplusone.pk',
            'phone'   => '+92 300 1234567',
            'address' => 'Lahore, Pakistan',

            'days' => 'Monday – Saturday',
            'time' => '10:00am – 7:00pm',

            'facebook_url'  => 'https://facebook.com/oneplusone.fashion',
            'instagram_url' => 'https://instagram.com/oneplusone.fashion',
            'twitter_url'   => 'https://twitter.com/oneplusone_pk',
            'youtube_url'   => 'https://youtube.com/@oneplusone.fashion',
        ]);
    }
}
