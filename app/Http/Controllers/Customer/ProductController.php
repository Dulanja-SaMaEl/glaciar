<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by size
        if ($request->has('size') && $request->size != '') {
            $query->where('size_ml', $request->size);
        }

        // Sort
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                default:
                    $query->orderBy('name', 'asc');
                    break;
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $products = $query->get();
        $sizes = Product::select('size_ml')->distinct()->orderBy('size_ml')->pluck('size_ml');

        return view('customer.products.index', compact('products', 'sizes'));
    }

    public function show(Product $product)
    {
        return view('customer.products.show', compact('product'));
    }

    public function collection()
    {
        $vessels = Product::where('status', 'active')
            ->orderBy('size_ml', 'asc')
            ->get();

        return view('customer.collection', compact('vessels'));
    }
}
