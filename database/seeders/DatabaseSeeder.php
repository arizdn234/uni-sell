<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            OrdersTableSeeder::class,
            ReviewsTableSeeder::class,
            CartsTableSeeder::class,
            CartItemsTableSeeder::class,
            PaymentsTableSeeder::class,
            ShippingsTableSeeder::class,
        ]);
    }
}
