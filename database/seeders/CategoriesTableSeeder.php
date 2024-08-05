<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Root Categories
        $electronics = Category::create(['name' => 'Electronics']);
        $homeAppliances = Category::create(['name' => 'Home Appliances']);
        $fashion = Category::create(['name' => 'Fashion']);
        $books = Category::create(['name' => 'Books']);
        $sports = Category::create(['name' => 'Sports & Outdoors']);

        // Subcategories for Electronics
        Category::create(['name' => 'Phones', 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Laptops', 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Tablets', 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Cameras', 'parent_id' => $electronics->id]);

        // Subcategories for Home Appliances
        Category::create(['name' => 'Refrigerators', 'parent_id' => $homeAppliances->id]);
        Category::create(['name' => 'Washing Machines', 'parent_id' => $homeAppliances->id]);
        Category::create(['name' => 'Microwaves', 'parent_id' => $homeAppliances->id]);
        Category::create(['name' => 'Air Conditioners', 'parent_id' => $homeAppliances->id]);

        // Subcategories for Fashion
        Category::create(['name' => 'Men\'s Clothing', 'parent_id' => $fashion->id]);
        Category::create(['name' => 'Women\'s Clothing', 'parent_id' => $fashion->id]);
        Category::create(['name' => 'Shoes', 'parent_id' => $fashion->id]);
        Category::create(['name' => 'Accessories', 'parent_id' => $fashion->id]);

        // Subcategories for Books
        Category::create(['name' => 'Fiction', 'parent_id' => $books->id]);
        Category::create(['name' => 'Non-Fiction', 'parent_id' => $books->id]);
        Category::create(['name' => 'Comics', 'parent_id' => $books->id]);
        Category::create(['name' => 'Children\'s Books', 'parent_id' => $books->id]);

        // Subcategories for Sports & Outdoors
        Category::create(['name' => 'Outdoor Gear', 'parent_id' => $sports->id]);
        Category::create(['name' => 'Exercise & Fitness', 'parent_id' => $sports->id]);
        Category::create(['name' => 'Team Sports', 'parent_id' => $sports->id]);
        Category::create(['name' => 'Cycling', 'parent_id' => $sports->id]);
    }
}
