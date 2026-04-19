<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Rep;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $customers = Customer::all();
        $reps = Rep::all();
        $admins = Admin::all();

        $categories = ['Late Delivery', 'Damaged Bottle', 'Rude Staff', 'Wrong Item', 'Billing Issue'];

        // 10 Complaints
        for ($i = 0; $i < 10; $i++) {
            $status = $faker->randomElement(['Open', 'In Progress', 'Resolved', 'Closed']);
            
            Complaint::create([
                'customer_id' => $customers->random()->id,
                'rep_id' => $faker->boolean(70) ? $reps->random()->id : null,
                'category' => $faker->randomElement($categories),
                'priority' => $faker->randomElement(['Low', 'Medium', 'High']),
                'description' => $faker->paragraph,
                'status' => $status,
                'resolution' => in_array($status, ['Resolved', 'Closed']) ? $faker->sentence : null,
                'assigned_to' => in_array($status, ['In Progress', 'Resolved', 'Closed']) ? $admins->random()->id : null,
            ]);
        }
    }
}
