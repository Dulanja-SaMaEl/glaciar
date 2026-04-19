<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 1. Create the SUPER ADMIN
        User::updateOrCreate(
            ['email' => 'admin@glaciar.com'],
            [
                'name' => 'Glaciar Admin',
                'password' => Hash::make('password'), // Easy password for testing
                'role' => 'admin',
                'type' => 'individual', // Placeholder
                'status' => true,
            ]
        );

        // 2. Create a TEST CUSTOMER
        User::updateOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'type' => 'individual',
                'status' => true,
            ]
        );

        $this->call([
            ZoneSeeder::class,
            AdminSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            RepSeeder::class,
            CasePriceSeeder::class,
            OrderSeeder::class,
            PaymentSeeder::class,
            DeliverySeeder::class,
            ComplaintSeeder::class,
            AttendanceSeeder::class,
            RepLocationSeeder::class,
            SubscriptionSeeder::class,
            SalesRecordSeeder::class,
        ]);
    }
}
