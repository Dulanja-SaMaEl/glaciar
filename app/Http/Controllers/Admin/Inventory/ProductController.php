<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');

        $products = Product::with(['category', 'supplier'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('name')
            ->paginate(15);

        $categories = ProductCategory::orderBy('name')->get();

        return view('admin.inventory.products.index', compact('products', 'categories', 'search', 'categoryId', 'status'));
    }

    public function create()
    {
        $categories = ProductCategory::where('status', 'active')->orderBy('name')->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('company_name')->get();
        
        return view('admin.inventory.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'barcode' => 'nullable|string|max:255|unique:products,barcode',
            'category_id' => 'nullable|exists:product_categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string|max:255',
            'unit_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            
            'size_ml' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0', // Selling Price
            
            'low_stock_threshold' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'maximum_stock_capacity' => 'nullable|integer|min:0',
            
            'status' => 'required|in:active,inactive',
        ]);

        Product::create($validated);

        return redirect()->route('admin.inventory.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier', 'stockTransactions' => function($q) {
            $q->orderBy('date', 'desc')->take(20);
        }]);
        
        return view('admin.inventory.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('status', 'active')->orderBy('name')->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('company_name')->get();
        
        return view('admin.inventory.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $product->id,
            'category_id' => 'nullable|exists:product_categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string|max:255',
            'unit_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            
            'size_ml' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0', // Selling Price
            
            'low_stock_threshold' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'maximum_stock_capacity' => 'nullable|integer|min:0',
            
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($validated);

        return redirect()->route('admin.inventory.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->stockTransactions()->count() > 0 || $product->orderItems()->count() > 0) {
            return back()->with('error', 'Cannot delete product with existing stock history or sales.');
        }
        
        $product->delete();
        return redirect()->route('admin.inventory.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
