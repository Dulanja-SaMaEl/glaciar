<?php

namespace Database\Seeders;

use App\Models\CasePrice;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CasePriceSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today()->toDateString();

        $defaults = [
            '500ml' => ['bottles_per_case' => 24, 'price_per_case' => 750.00],
            '1000ml' => ['bottles_per_case' => 24, 'price_per_case' => 960.00],
            '1500ml' => ['bottles_per_case' => 24, 'price_per_case' => 960.00],
            '5000ml' => ['bottles_per_case' => 24, 'price_per_case' => 1000.00],
        ];

        foreach ($defaults as $size => $data) {
            CasePrice::updateOrCreate(
                ['product_size' => $size, 'effective_from' => $today],
                [
                    'bottles_per_case' => (int) $data['bottles_per_case'],
                    'price_per_case' => $data['price_per_case'],
                    'is_active' => true,
                ]
            );
        }
    }
}

