<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->orderBy('name')
            ->paginate(20);

        return view('admin.inventory.index', [
            'products' => $products,
        ]);
    }

    public function adjust(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'adjustment' => ['required', 'integer'],
        ]);

        $product = Product::query()->findOrFail($data['product_id']);
        $product->stock = max(0, (int) $product->stock + (int) $data['adjustment']);
        $product->save();

        return back()->with('status', 'Inventory adjusted.');
    }
}

