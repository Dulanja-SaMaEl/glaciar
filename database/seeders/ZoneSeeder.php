<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['name' => 'Colombo North', 'description' => 'Serves Colombo 1-15'],
            ['name' => 'Colombo South', 'description' => 'Serves Mount Lavinia, Dehiwala'],
            ['name' => 'Kotte Area', 'description' => 'Serves Rajagiriya, Nugegoda'],
            ['name' => 'Gampaha', 'description' => 'Serves Gampaha District limits'],
            ['name' => 'Kandy Central', 'description' => 'Serves Kandy municipal limits'],
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }
    }
}
