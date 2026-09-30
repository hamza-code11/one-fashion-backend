<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\SizeGuide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * |--------------------------------------------------------------------------
         * | Ensure parent data exists
         * |--------------------------------------------------------------------------
         * Brands, Categories, Collections, SizeGuides already seeded hain
         * toh yahan sirf references utha rahe hain.
         */

        $brands = Brand::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();
        $collections = Collection::pluck('id')->toArray();
        $sizes = SizeGuide::pluck('id')->toArray();

        if (empty($brands) || empty($categories)) {
            $this->command->warn(
                'Brands ya Categories empty hain. Pehle un ke seeders chalao.'
            );
            return;
        }

        /*
         * |--------------------------------------------------------------------------
         * | 12 Products — realistic catalog mix
         * |--------------------------------------------------------------------------
         */

        $products = [
            [
                'name'         => 'Classic Cotton T-Shirt',
                'description'  => 'Soft breathable cotton t-shirt with a relaxed fit. Perfect for everyday wear.',
                'price'        => 1499,
                'old_price'    => 1999,
                'gender'       => 'Men',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'White',  'value' => '#FFFFFF'],
                    ['name' => 'Black',  'value' => '#000000'],
                ],
            ],
            [
                'name'         => 'Slim Fit Denim Jeans',
                'description'  => 'Stretch denim with a modern slim cut. Comfortable all-day wear.',
                'price'        => 3499,
                'old_price'    => null,
                'gender'       => 'Men',
                'badge'        => 'NEW',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Indigo', 'value' => '#2E4057'],
                ],
            ],
            [
                'name'         => 'Floral Summer Dress',
                'description'  => 'Lightweight floral dress with a flattering silhouette.',
                'price'        => 2799,
                'old_price'    => 3499,
                'gender'       => 'Women',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Pink',   'value' => '#F4A6B8'],
                    ['name' => 'Yellow', 'value' => '#F4D35E'],
                ],
            ],
            [
                'name'         => 'Wool Blend Winter Coat',
                'description'  => 'Elegant wool-blend coat with a tailored fit for cold days.',
                'price'        => 8999,
                'old_price'    => null,
                'gender'       => 'Women',
                'badge'        => 'HOT',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Camel', 'value' => '#C19A6B'],
                    ['name' => 'Navy',  'value' => '#1B2A4E'],
                ],
            ],
            [
                'name'         => 'Kids Cartoon Hoodie',
                'description'  => 'Fun cartoon-print hoodie with a soft fleece lining.',
                'price'        => 1299,
                'old_price'    => 1599,
                'gender'       => 'Kids',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Blue',  'value' => '#4A90E2'],
                    ['name' => 'Green', 'value' => '#7ED321'],
                ],
            ],
            [
                'name'         => 'Kids Denim Dungaree',
                'description'  => 'Cute and durable denim dungaree for little ones.',
                'price'        => 1899,
                'old_price'    => null,
                'gender'       => 'Kids',
                'badge'        => null,
                'status'       => 'published',
                'stock_status' => 'out_of_stock',
                'colors'       => [
                    ['name' => 'Light Blue', 'value' => '#A2C8E8'],
                ],
            ],
            [
                'name'         => 'Unisex Oversized Sweatshirt',
                'description'  => 'Cozy oversized sweatshirt with a minimal design.',
                'price'        => 2299,
                'old_price'    => 2999,
                'gender'       => 'Unisex',
                'badge'        => 'SALE',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Grey',  'value' => '#B0B0B0'],
                    ['name' => 'Beige', 'value' => '#D9C7B8'],
                ],
            ],
            [
                'name'         => 'Unisex Baseball Cap',
                'description'  => 'Adjustable cotton cap with embroidered logo.',
                'price'        => 899,
                'old_price'    => null,
                'gender'       => 'Unisex',
                'badge'        => 'NEW',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Black', 'value' => '#000000'],
                    ['name' => 'Khaki', 'value' => '#C3B091'],
                ],
            ],
            [
                'name'         => 'Men Leather Jacket',
                'description'  => 'Classic leather jacket with zip closure and quilted lining.',
                'price'        => 12999,
                'old_price'    => 15999,
                'gender'       => 'Men',
                'badge'        => 'HOT',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Brown', 'value' => '#5C4033'],
                    ['name' => 'Black', 'value' => '#000000'],
                ],
            ],
            [
                'name'         => 'Women Silk Blouse',
                'description'  => 'Elegant silk blouse with a subtle sheen and relaxed fit.',
                'price'        => 3299,
                'old_price'    => null,
                'gender'       => 'Women',
                'badge'        => 'NEW',
                'status'       => 'published',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Cream', 'value' => '#F5F0E1'],
                    ['name' => 'Rose',  'value' => '#E8B4B8'],
                ],
            ],
            [
                'name'         => 'Kids Striped T-Shirt',
                'description'  => 'Soft cotton t-shirt with playful stripes.',
                'price'        => 799,
                'old_price'    => 1099,
                'gender'       => 'Kids',
                'badge'        => 'SALE',
                'status'       => 'draft',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Red', 'value' => '#E94B3C'],
                ],
            ],
            [
                'name'         => 'Unisex Sports Shorts',
                'description'  => 'Moisture-wicking shorts designed for active days.',
                'price'        => 1399,
                'old_price'    => null,
                'gender'       => 'Unisex',
                'badge'        => null,
                'status'       => 'draft',
                'stock_status' => 'in_stock',
                'colors'       => [
                    ['name' => 'Charcoal', 'value' => '#36454F'],
                ],
            ],
        ];

        /*
         * |--------------------------------------------------------------------------
         * | Insert with transaction
         * |--------------------------------------------------------------------------
         */

        DB::transaction(function () use (
            $products,
            $brands,
            $categories,
            $collections,
            $sizes
        ) {
            foreach ($products as $index => $data) {
                $product = Product::create([
                    'brand_id'     => $brands[array_rand($brands)],
                    'category_id'  => $categories[array_rand($categories)],
                    'name'         => $data['name'],
                    'slug'         => Str::slug($data['name']) . '-' . ($index + 1),
                    'description'  => $data['description'],
                    'price'        => $data['price'],
                    'old_price'    => $data['old_price'],
                    'gender'       => $data['gender'],
                    'badge'        => $data['badge'],
                    'status'       => $data['status'],
                    'stock_status' => $data['stock_status'],
                ]);

                /* colors */
                if (!empty($data['colors'])) {
                    $product->colors()->createMany($data['colors']);
                }

                /* sizes — random 2-4 */
                if (!empty($sizes)) {
                    $randomSizes = collect($sizes)
                        ->shuffle()
                        ->take(rand(2, min(4, count($sizes))))
                        ->toArray();
                    $product->sizes()->sync($randomSizes);
                }

                /* collections — random 1-2 */
                if (!empty($collections)) {
                    $randomCollections = collect($collections)
                        ->shuffle()
                        ->take(rand(1, min(2, count($collections))))
                        ->toArray();
                    $product->collections()->sync($randomCollections);
                }
            }
        });

        $this->command->info('12 products seeded successfully.');
    }
}
