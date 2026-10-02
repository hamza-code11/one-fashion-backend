<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\SizeGuide;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brandIds = Brand::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();
        $collectionIds = Collection::pluck('id')->toArray();
        $sizeIds = SizeGuide::pluck('id')->toArray();

        if (empty($brandIds) || empty($categoryIds)) {
            $this->command->error('Brands aur Categories pehle seed karo.');
            return;
        }

        $products = [
            [
                'name'         => 'Floral Cotton Frock',
                'slug'         => 'floral-cotton-frock',
                'description'  => 'A breezy floral frock in soft cotton, perfect for everyday summer adventures.',
                'price'        => 2899.00,
                'old_price'    => 3499.00,
                'gender'       => 'Girls',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Pink', 'value' => '#e3aab8'],
                    ['name' => 'Cream', 'value' => '#dacec4'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=600&q=80', 'is_main' => true],
                    ['image' => 'https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=600&q=80', 'is_main' => false],
                ],
            ],
            [
                'name'         => 'Denim Overalls',
                'slug'         => 'denim-overalls',
                'description'  => 'Durable denim overalls built for playground adventures and messy afternoons.',
                'price'        => 3599.00,
                'old_price'    => null,
                'gender'       => 'Kids',
                'badge'        => 'NEW',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Blue', 'value' => '#3b5998'],
                    ['name' => 'Black', 'value' => '#000000'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1503944583220-79d8926ad5e2?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Striped T-Shirt',
                'slug'         => 'striped-tshirt',
                'description'  => 'Classic stripes, breathable cotton — a wardrobe staple for every little one.',
                'price'        => 1299.00,
                'old_price'    => null,
                'gender'       => 'Unisex',
                'badge'        => null,
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Navy', 'value' => '#1e3a8a'],
                    ['name' => 'White', 'value' => '#ffffff'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1522771930-78848d9293e8?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Corduroy Pants',
                'slug'         => 'corduroy-pants',
                'description'  => 'Warm corduroy trousers with a comfortable elastic waist — ideal for cooler days.',
                'price'        => 2499.00,
                'old_price'    => 2999.00,
                'gender'       => 'Boys',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Brown', 'value' => '#6e3621'],
                    ['name' => 'Olive', 'value' => '#594f07'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Knitted Cardigan',
                'slug'         => 'knitted-cardigan',
                'description'  => 'Soft knitted cardigan with wooden buttons — cosy layers for cooler evenings.',
                'price'        => 3299.00,
                'old_price'    => null,
                'gender'       => 'Girls',
                'badge'        => 'HOT',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Cream', 'value' => '#dacec4'],
                    ['name' => 'Pink', 'value' => '#e3aab8'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1596870230751-ebdfce98ec42?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Printed Co-ord Set',
                'slug'         => 'printed-coord-set',
                'description'  => 'Matching top and shorts in a playful print — easy, breezy summer dressing.',
                'price'        => 2799.00,
                'old_price'    => null,
                'gender'       => 'Girls',
                'badge'        => 'NEW',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Yellow', 'value' => '#f4d35e'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Baby Bodysuit Pack',
                'slug'         => 'baby-bodysuit-pack',
                'description'  => 'Pack of three soft cotton bodysuits with snap closures — gentle on newborn skin.',
                'price'        => 1899.00,
                'old_price'    => 2299.00,
                'gender'       => 'Baby',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'White', 'value' => '#ffffff'],
                    ['name' => 'Grey', 'value' => '#a1a1aa'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Hooded Sweatshirt',
                'slug'         => 'hooded-sweatshirt',
                'description'  => 'Fleece-lined hooded sweatshirt with kangaroo pocket — winter favourite.',
                'price'        => 2999.00,
                'old_price'    => null,
                'gender'       => 'Boys',
                'badge'        => null,
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Charcoal', 'value' => '#374151'],
                    ['name' => 'Navy', 'value' => '#1e3a8a'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1503944583220-79d8926ad5e2?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Linen Summer Dress',
                'slug'         => 'linen-summer-dress',
                'description'  => 'Lightweight linen dress with smocked bodice — perfect for warm afternoons.',
                'price'        => 3899.00,
                'old_price'    => null,
                'gender'       => 'Girls',
                'badge'        => 'NEW',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Cream', 'value' => '#dacec4'],
                    ['name' => 'Sky', 'value' => '#87ceeb'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Twill Chino Shorts',
                'slug'         => 'twill-chino-shorts',
                'description'  => 'Smart-casual chino shorts with an adjustable waistband for growing kids.',
                'price'        => 1799.00,
                'old_price'    => null,
                'gender'       => 'Boys',
                'badge'        => null,
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Beige', 'value' => '#d4c5a9'],
                    ['name' => 'Olive', 'value' => '#594f07'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1522771930-78848d9293e8?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Ribbed Leggings',
                'slug'         => 'ribbed-leggings',
                'description'  => 'Stretchy ribbed leggings that move with every jump, skip and tumble.',
                'price'        => 999.00,
                'old_price'    => null,
                'gender'       => 'Girls',
                'badge'        => null,
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Black', 'value' => '#000000'],
                    ['name' => 'Grey', 'value' => '#a1a1aa'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?w=600&q=80', 'is_main' => true],
                ],
            ],
            [
                'name'         => 'Puffer Jacket',
                'slug'         => 'puffer-jacket',
                'description'  => 'Lightweight puffer jacket with a water-repellent shell — winter-ready.',
                'price'        => 4999.00,
                'old_price'    => 5999.00,
                'gender'       => 'Unisex',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Red', 'value' => '#dc2626'],
                    ['name' => 'Navy', 'value' => '#1e3a8a'],
                ],
                'images'       => [
                    ['image' => 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?w=600&q=80', 'is_main' => true],
                ],
            ],
        ];

        foreach ($products as $index => $data) {
            $colors = $data['colors'];
            $images = $data['images'];

            unset($data['colors'], $data['images']);

            $product = Product::create([
                ...$data,
                'brand_id'    => $brandIds[$index % count($brandIds)],
                'category_id' => $categoryIds[$index % count($categoryIds)],
            ]);

            foreach ($colors as $color) {
                $product->colors()->create($color);
            }

            foreach ($images as $image) {
                $product->images()->create($image);
            }

            if (!empty($sizeIds)) {
                $randomSizes = collect($sizeIds)->shuffle()->take(3)->toArray();
                $product->sizes()->sync($randomSizes);
            }

            if (!empty($collectionIds)) {
                $randomCollections = collect($collectionIds)
                    ->shuffle()
                    ->take(rand(1, 2))
                    ->toArray();
                $product->collections()->sync($randomCollections);
            }
        }

        $this->command->info('Products seeded: ' . count($products));
    }
}

