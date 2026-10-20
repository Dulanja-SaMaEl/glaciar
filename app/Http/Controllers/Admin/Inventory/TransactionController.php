<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $type = $request->input('type');
        $productId = $request->input('product_id');

        $transactions = StockTransaction::with(['product', 'user'])
            ->when($type, function($q) use ($type) {
                $q->where('type', $type);
            })
            ->when($productId, function($q) use ($productId) {
                $q->where('product_id', $productId);
            })
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);

        $products = Product::orderBy('name')->get();

        return view('admin.inventory.transactions.index', compact('transactions', 'products', 'type', 'productId'));
    }

    public function adjust(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:adjustment,damaged,return,stock_in,stock_out',
            'quantity' => 'required|integer|not_in:0',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity < 0 && $product->stock < abs($request->quantity)) {
            return back()->with('error', 'Insufficient stock for this deduction.');
        }

        $this->inventoryService->adjustStock(
            $product,
            $request->quantity,
            $request->type,
            $request->reason,
            $request->notes
        );

        return back()->with('success', 'Stock adjustment recorded successfully.');
    }
}
