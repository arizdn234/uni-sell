<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipping;
use App\Models\Order;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ShippingsTableSeeder extends Seeder
{
    private function generateUniqueTrackingNumber()
    {
        $uuid = Str::uuid()->toString();

        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $chars[rand(0, strlen($chars) - 1)];
        }

        return 'TRK-' . now()->timestamp . '-' . $randomString;
    }

    public function run()
    {
        $faker = Faker::create();
        $orders = Order::where('status', 'completed')->get();

        foreach ($orders as $order) {
            Shipping::create([
                'order_id' => $order->id,
                'shipping_method' => $faker->randomElement(['standard', 'express']),
                'tracking_number' => $this->generateUniqueTrackingNumber(),
                'status' => $faker->randomElement(['shipped', 'arrived', 'processed']),
            ]);
        }
    }
}
