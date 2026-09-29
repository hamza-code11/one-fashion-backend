<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Dresses',
                'slug' => 'dresses',
                'description' => 'Beautiful dresses for girls of all ages.',
                'image' => 'https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=800&q=80',
            ],
            [
                'name' => 'T-Shirts',
                'slug' => 't-shirts',
                'description' => 'Comfortable everyday t-shirts for kids.',
                'image' => 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?w=800&q=80',
            ],
            [
                'name' => 'Shirts',
                'slug' => 'shirts',
                'description' => 'Smart and comfortable shirts for boys.',
                'image' => 'https://images.unsplash.com/photo-1503944583220-79d8926ad5e2?w=800&q=80',
            ],
            [
                'name' => 'Trousers',
                'slug' => 'trousers',
                'description' => 'Comfortable trousers for everyday wear.',
                'image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=800&q=80',
            ],
            [
                'name' => 'Jeans',
                'slug' => 'jeans',
                'description' => 'Durable and stylish denim for kids.',
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80',
            ],
            [
                'name' => 'Co-Ord Sets',
                'slug' => 'co-ord-sets',
                'description' => 'Matching sets designed for effortless style.',
                'image' => 'https://images.unsplash.com/photo-1596870230751-ebdfce98ec42?w=800&q=80',
            ],
            [
                'name' => 'Jackets',
                'slug' => 'jackets',
                'description' => 'Warm and stylish jackets for little ones.',
                'image' => 'https://images.unsplash.com/photo-1522771930-78848d9293e8?w=800&q=80',
            ],
            [
                'name' => 'Baby Wear',
                'slug' => 'baby-wear',
                'description' => 'Soft and gentle clothing for babies.',
                'image' => 'https://images.unsplash.com/photo-1522771930-78848d9293e8?w=800&q=80',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
