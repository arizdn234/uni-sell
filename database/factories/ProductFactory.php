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
            'description' => $this->faker->text(600),
            'price' => round($this->faker->randomFloat(2, 500, 5000) * 1000, -2), 
            'stock' => $this->faker->numberBetween(57, 168),
            'category_id' => function () {
                return \App\Models\Category::inRandomOrder()->first()->id;
            },
            'image_url' => $this->faker->imageUrl(640, 480, 'product'),
        ];
    }
}
