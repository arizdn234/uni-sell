<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Faker\Factory as Faker;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $products = Product::all();

        foreach ($products as $product) {
            for ($i = 0; $i < 5; $i++) {
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                    'rating' => rand(1, 5),
                    'comment' => $faker->sentence,
                ]);
            }
        }
    }
}
