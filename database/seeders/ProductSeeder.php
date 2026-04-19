<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Glaciar Mini', 'size_ml' => 250, 'price' => 50.00, 'stock' => 500],
            ['name' => 'Glaciar Standard', 'size_ml' => 500, 'price' => 80.00, 'stock' => 500],
            ['name' => 'Glaciar Hydration', 'size_ml' => 1000, 'price' => 150.00, 'stock' => 400],
            ['name' => 'Glaciar Family', 'size_ml' => 1500, 'price' => 200.00, 'stock' => 300],
            ['name' => 'Glaciar Jug', 'size_ml' => 5000, 'price' => 500.00, 'stock' => 150],
            ['name' => 'Glaciar Dispenser Bottle', 'size_ml' => 19000, 'price' => 350.00, 'stock' => 1000], // 19L
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
