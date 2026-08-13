<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get a list of all active products with current stock.
     */
    public function index()
    {
        $products = Product::where('status', 'active')
            ->select('id', 'name', 'sku', 'barcode', 'size_ml', 'price', 'stock', 'unit_type', 'image')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }
}
