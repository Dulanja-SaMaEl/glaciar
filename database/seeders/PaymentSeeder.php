<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $orders = Order::where('status', '!=', 'cancelled')->get();

        foreach ($orders->take(40) as $order) { // 40 payments
            $status = $faker->randomElement(['pending', 'verified']);
            
            Payment::create([
                'order_id' => $order->id,
                'method' => $order->payment_method,
                'amount' => $order->total,
                'reference' => $order->payment_method !== 'cash' ? strtoupper($faker->bothify('REF-####??')) : null,
                'status' => $status,
                'verified_at' => $status === 'verified' ? now() : null,
            ]);

            // Create Invoice
            Invoice::create([
                'order_id' => $order->id,
                'invoice_number' => 'INV-' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
