<?php

namespace Database\Seeders;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $deliveredOrders = Order::where('status', 'delivered')->get();

        foreach ($deliveredOrders->take(30) as $order) { // 30 deliveries
            Delivery::create([
                'order_id' => $order->id,
                'rep_id' => $order->rep_id,
                'status' => 'completed',
                'delivered_at' => $order->delivery_date,
                'notes' => $faker->optional()->sentence,
            ]);
        }
    }
}
