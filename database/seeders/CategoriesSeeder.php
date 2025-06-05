<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;
use App\Models\Product;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::insert([
            [
                'name' => 'Electronics', 
                'slug' => 'electronics',
                'description' => 'Electronic gadgets and devices',
                'image'=> 'https://placehold.co/300x300?text=Electronics'
            ],
            [
                'name' => 'Books', 
                'slug' => 'books',
                'description' => 'Various kinds of books',
                'image'=> 'https://placehold.co/300x300?text=Books'
            ],
            [
                'name' => 'Clothing', 
                'slug' => 'clothing',
                'description' => 'Men and women clothing',
                'image'=> 'https://placehold.co/300x300?text=Clothing'
            ],
            [
                'name' => 'Home & Kitchen', 
                'slug' => 'home-kitchen',
                'description' => 'Home appliances and kitchenware',
                'image'=> 'https://placehold.co/300x300?text=Home+%26+Kitchen'
            ],
            [
                'name' => 'Sports', 
                'slug' => 'sports',
                'description' => 'Sports equipment and accessories',
                'image'=> 'https://placehold.co/300x300?text=Sports'
            ],
        ]);

        // Generate 1000 dummy products for each category
        $categories = [
            ['id' => 1, 'name' => 'Electronics'],
            ['id' => 2, 'name' => 'Books'],
            ['id' => 3, 'name' => 'Clothing'],
            ['id' => 4, 'name' => 'Home & Kitchen'],
            ['id' => 5, 'name' => 'Sports'],
        ];

        $products = [];
        $faker = \Faker\Factory::create();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 200; $i++) { // 200 x 5 = 1000
                $products[] = [
                    'name' => $category['name'] . ' Product ' . $i,
                    'slug' => strtolower(str_replace(' ', '-', $category['name'])) . '-product-' . $i,
                    'description' => $faker->sentence(10),
                    'sku' => strtoupper($category['name'][0]) . '-' . $faker->unique()->numerify('#####'),
                    'stock' => $faker->numberBetween(1, 100),
                    'product_category_id' => $category['id'],
                    'price' => $faker->randomFloat(2, 10, 1000),
                    'is_active' => $faker->boolean(80), // 80% chance of being active
                    'image_url' => 'https://placehold.co/300x300?text=' . urlencode($category['name'] . ' ' . $i),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert into products table
        Product::insert($products);
        $this->command->info('Categories and products seeded successfully!');
    }
}
