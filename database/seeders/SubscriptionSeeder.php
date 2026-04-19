<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $customers = Customer::all();
        $products = Product::where('size_ml', 19000)->get(); // Subscriptions usually for 19L

        if ($products->isEmpty()) return;

        // 5 Subscriptions
        for ($i = 0; $i < 5; $i++) {
            Subscription::create([
                'customer_id' => $customers->random()->id,
                'product_id' => $products->first()->id,
                'qty' => $faker->numberBetween(1, 4),
                'frequency' => $faker->randomElement(['Weekly', 'Bi-weekly', 'Monthly']),
                'next_delivery' => $faker->dateTimeBetween('now', '+1 month'),
                'status' => $faker->boolean(80) ? 'active' : 'paused',
            ]);
        }
    }
}
