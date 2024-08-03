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
        $category = Category::first(); // Pastikan kategori ada

        if ($category) {
            Product::create([
                'name' => 'Sample Product',
                'description' => 'Sample description for the product.',
                'price' => 99.99,
                'stock' => 100,
                'category_id' => $category->id, // Pastikan ID kategori ada
                'image_url' => 'https://via.placeholder.com/640x480.png/00aa66?text=product',
            ]);
        } else {
            echo "No categories found. Please seed categories first.\n";
        }
    }
}
