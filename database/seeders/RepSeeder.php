<?php

namespace Database\Seeders;

use App\Models\Rep;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class RepSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $zones = Zone::all();

        // 5 Sales Reps
        for ($i = 1; $i <= 5; $i++) {
            $email = "rep{$i}@glaciarwater.com";
            $name = $faker->name;
            $zoneId = $zones->random()->id;

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'rep',
                    'type' => 'individual',
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'status' => true,
                    'zone_id' => $zoneId,
                    'employee_id' => 'REP-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                ]
            );

            Rep::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'employee_id' => $user->employee_id,
                    'phone' => $user->phone,
                    'zone_id' => $zoneId,
                    'password' => $user->password,
                    'status' => 'active',
                    'user_id' => $user->id,
                ]
            );
        }
    }
}
