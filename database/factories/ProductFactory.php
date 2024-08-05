<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'price' => round($this->faker->randomFloat(2, 10, 100) * 1000, -2), 
            'stock' => $this->faker->numberBetween(1, 100),
            'category_id' => function () {
                return \App\Models\Category::inRandomOrder()->first()->id;
            },
            'image_url' => $this->faker->imageUrl(640, 480, 'product'),
        ];
    }
}
