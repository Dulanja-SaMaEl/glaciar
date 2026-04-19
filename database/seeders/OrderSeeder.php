<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Rep;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $customers = Customer::all();
        $reps = Rep::all();
        $products = Product::all();

        // 50 Orders
        for ($i = 0; $i < 50; $i++) {
            $customer = $customers->random();
            $status = $faker->randomElement(['pending', 'in_progress', 'delivered', 'cancelled']);
            
            $order = Order::create([
                'customer_id' => $customer->id,
                'rep_id' => $status !== 'pending' ? $reps->random()->id : null,
                'type' => $customer->type,
                'status' => $status,
                'total' => 0, // Calculated below
                'payment_method' => $faker->randomElement(['cash', 'bank_transfer', 'cheque']),
                'delivery_date' => $faker->dateTimeBetween('-1 month', '+1 week'),
                'notes' => $faker->optional()->sentence,
            ]);

            $total = 0;
            $itemsCount = $faker->numberBetween(1, 3);
            
            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                $qty = $faker->numberBetween(1, 5);
                $unitPrice = $product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                ]);
                
                $total += ($qty * $unitPrice);
            }

            // Update total
            $order->update(['total' => $total]);
        }
    }
}
