<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $superUser = User::updateOrCreate(
            ['email' => 'admin@glaciarwater.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'type' => 'individual',
                'status' => true,
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'admin@glaciarwater.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'user_id' => $superUser->id,
            ]
        );
        
        $supportUser = User::updateOrCreate(
            ['email' => 'support@glaciarwater.com'],
            [
                'name' => 'Support Manager',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'type' => 'individual',
                'status' => true,
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'support@glaciarwater.com'],
            [
                'name' => 'Support Manager',
                'password' => Hash::make('password'),
                'role' => 'Manager',
                'user_id' => $supportUser->id,
            ]
        );
    }
}
