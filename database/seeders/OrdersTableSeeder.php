<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'status' => $faker->randomElement(['pending', 'completed', 'canceled']),
                    'payment_method' => $faker->randomElement(['credit_card', 'paypal']),
                    'shipping_address' => $faker->address,
                ]);

                $totalAmount = 0;
                $products = Product::inRandomOrder()->take(rand(1, 3))->get();

                foreach ($products as $product) {
                    $quantity = rand(1, 5);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);

                    $totalAmount += $product->price * $quantity;
                }

                $order->update(['total_amount' => $totalAmount]);
            }
        }
    }
}
