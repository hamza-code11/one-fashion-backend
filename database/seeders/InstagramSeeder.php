<?php

namespace Database\Seeders;

use App\Models\Instagram;
use Illuminate\Database\Seeder;

class InstagramSeeder extends Seeder
{
    public function run(): void
    {
        /* ---------- SETTINGS (single row) ---------- */
        Instagram::create([
            'type'        => 'settings',
            'handle'      => '@oneplusone.fashion',
            'profile_url' => 'https://instagram.com/oneplusone.fashion',
        ]);

        /* ---------- POSTS ----------
           User "Share → Copy Link" se Instagram app se link copy karega
           aur woh yahan URL ke roop mein save hoga.
        ---------------------------- */

        $posts = [
            ['url' => 'https://www.instagram.com/p/abc123/',    'image' => null],
            ['url' => 'https://www.instagram.com/reel/def456/', 'image' => null],
            ['url' => 'https://www.instagram.com/p/ghi789/',    'image' => null],
            ['url' => 'https://www.instagram.com/reel/jkl012/', 'image' => null],
            ['url' => 'https://www.instagram.com/p/mno345/',    'image' => null],
            ['url' => 'https://www.instagram.com/p/pqr678/',    'image' => null],
        ];

        foreach ($posts as $post) {
            Instagram::create([
                'type'  => 'post',
                'url'   => $post['url'],
                'image' => $post['image'],
            ]);
        }
    }
}
