<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            echo "No categories found. Please seed categories first.\n";
            return;
        }

        // Create 50 products
        Product::factory()->count(50)->create();

        // Alternatively, create specific products manually:
        // foreach ($categories as $category) {
        //     for ($i = 1; $i <= 10; $i++) {
        //         Product::create([
        //             'name' => "Product $i for Category {$category->name}",
        //             'description' => 'Sample description for the product.',
        //             'price' => mt_rand(10, 100),
        //             'stock' => mt_rand(1, 100),
        //             'category_id' => $category->id,
        //             'image_url' => 'https://via.placeholder.com/640x480.png/00aa66?text=product',
        //         ]);
        //     }
        // }
    }
}
