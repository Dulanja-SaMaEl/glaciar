<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = ProductCategory::count();
        $totalSuppliers = Supplier::count();

        $products = Product::all();
        
        $stockValue = 0;
        $inStockCount = 0;
        $outOfStockCount = 0;
        $lowStockCount = 0;
        
        foreach ($products as $product) {
            $stockValue += $product->stock * $product->purchase_price;
            
            if ($product->stock_status === 'out_of_stock') {
                $outOfStockCount++;
            } elseif ($product->stock_status === 'low_stock') {
                $lowStockCount++;
            }
            if ($product->stock > 0) {
                $inStockCount++;
            }
        }

        $recentTransactions = StockTransaction::with(['product', 'user'])
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        $lowStockProducts = Product::with('category', 'supplier')
            ->where('stock', '<=', \DB::raw('low_stock_threshold'))
            ->where('stock', '>', 0)
            ->get();
            
        $outOfStockProducts = Product::with('category', 'supplier')
            ->where('stock', '<=', 0)
            ->get();

        return view('admin.inventory.dashboard', compact(
            'totalProducts', 'totalCategories', 'totalSuppliers',
            'stockValue', 'inStockCount', 'outOfStockCount', 'lowStockCount',
            'recentTransactions', 'lowStockProducts', 'outOfStockProducts'
        ));
    }
}
