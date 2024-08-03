<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipping;
use App\Models\Order;
use Faker\Factory as Faker;

class ShippingsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $orders = Order::where('status', 'completed')->get();

        foreach ($orders as $order) {
            Shipping::create([
                'order_id' => $order->id,
                'shipping_method' => $faker->randomElement(['standard', 'express']),
                'tracking_number' => $faker->regexify('[A-Z0-9]{10}'),
                'status' => 'shipped',
            ]);
        }
    }
}
