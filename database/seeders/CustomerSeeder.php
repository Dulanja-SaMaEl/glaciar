<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // 20 Web Customers (B2C)
        for ($i = 0; $i < 20; $i++) {
            $email = "web_cust{$i}@example.com";
            $name = $faker->name;

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                    'type' => 'individual',
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'status' => true,
                ]
            );

            Customer::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'business_type' => 'Individual',
                    'type' => 'web',
                    'password' => $user->password,
                    'user_id' => $user->id,
                ]
            );
        }

        // 15 App Customers (B2B)
        for ($i = 0; $i < 15; $i++) {
            $email = "app_cust{$i}@example.com";
            $name = $faker->company;

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                    'type' => 'business',
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'status' => true,
                ]
            );

            Customer::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'business_type' => $faker->randomElement(['Restaurant', 'Store', 'Office']),
                    'type' => 'app',
                    'password' => $user->password,
                    'user_id' => $user->id,
                ]
            );
        }
    }
}
