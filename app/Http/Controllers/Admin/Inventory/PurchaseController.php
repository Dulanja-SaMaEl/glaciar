<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $purchases = Purchase::with(['supplier', 'user'])
            ->when($search, function($query) use ($search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            })
            ->orderBy('purchase_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);
            
        return view('admin.inventory.purchases.index', compact('purchases', 'search'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 'active')->orderBy('company_name')->get();
        $products = Product::where('status', 'active')->orderBy('name')->get();
        
        return view('admin.inventory.purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'nullable|string|max:255',
            'purchase_date' => 'required|date',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array|min:1',
            'unit_costs' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'invoice_number' => $request->invoice_number,
                'purchase_date' => $request->purchase_date,
                'tax' => $request->tax ?? 0,
                'notes' => $request->notes,
                'status' => 'pending', // Starts as pending until received
                'user_id' => auth()->id(),
            ]);

            $totalCost = 0;

            foreach ($request->products as $index => $productId) {
                $qty = (int) $request->quantities[$index];
                $unitCost = (float) $request->unit_costs[$index];
                
                if ($qty > 0 && $unitCost >= 0) {
                    $itemTotal = $qty * $unitCost;
                    $totalCost += $itemTotal;
                    
                    $purchase->items()->create([
                        'product_id' => $productId,
                        'quantity' => $qty,
                        'unit_cost' => $unitCost,
                        'total_cost' => $itemTotal,
                    ]);
                }
            }

            $purchase->update([
                'total_cost' => $totalCost + ($request->tax ?? 0)
            ]);
        });

        return redirect()->route('admin.inventory.purchases.index')
            ->with('success', 'Purchase order created successfully.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product', 'user']);
        return view('admin.inventory.purchases.show', compact('purchase'));
    }

    public function receive(Purchase $purchase)
    {
        if ($purchase->status === 'completed') {
            return back()->with('error', 'Purchase has already been received.');
        }

        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                $this->inventoryService->adjustStock(
                    $item->product,
                    $item->quantity,
                    'stock_in',
                    'Purchase Received',
                    'Invoice: ' . $purchase->invoice_number,
                    auth()->id(),
                    'Purchase',
                    $purchase->id
                );
                
                // Update purchase price to the latest unit cost
                $item->product->update(['purchase_price' => $item->unit_cost]);
            }

            $purchase->update(['status' => 'completed']);
        });

        return back()->with('success', 'Stock received successfully and inventory updated.');
    }
}
