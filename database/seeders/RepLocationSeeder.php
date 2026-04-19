<?php

namespace Database\Seeders;

use App\Models\Rep;
use App\Models\RepLocation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class RepLocationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $reps = Rep::all();
        $now = Carbon::now();

        // 100 locations (simulate today's movement)
        foreach ($reps as $rep) {
            $baseLat = 6.9271; // Colombo
            $baseLng = 79.8612;

            for ($i = 20; $i >= 0; $i--) {
                RepLocation::create([
                    'rep_id' => $rep->id,
                    'lat' => $baseLat + $faker->randomFloat(4, -0.05, 0.05),
                    'lng' => $baseLng + $faker->randomFloat(4, -0.05, 0.05),
                    'recorded_at' => $now->copy()->subMinutes($i * 15), // Every 15 mins
                ]);
            }
        }
    }
}
