@extends('layouts.admin')
@section('header', 'Purchase Details')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.inventory.purchases.index') }}" class="text-sm font-semibold text-gray-500 hover:text-glaciar-black flex items-center gap-2">
        &larr; Back to Purchases
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Purchase Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-start bg-gray-50">
                <div>
                    <h2 class="text-xl font-bold text-glaciar-black">Purchase Order #PO-{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Invoice: {{ $purchase->invoice_number ?? 'N/A' }}</p>
                </div>
                <div>
                    @if($purchase->status === 'completed')
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold uppercase">Received</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase">Pending</span>
                    @endif
                </div>
            </div>
            
            <div class="p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-bold text-gray-500 uppercase border-b-2 border-gray-200">
                            <th class="pb-2">Product</th>
                            <th class="pb-2 text-right">Quantity</th>
                            <th class="pb-2 text-right">Unit Cost</th>
                            <th class="pb-2 text-right">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($purchase->items as $item)
                            <tr>
                                <td class="py-4">
                                    <div class="font-bold text-glaciar-black">{{ $item->product->name }}</div>
                                    <div class="text-xs text-gray-500">SKU: {{ $item->product->sku ?? '-' }}</div>
                                </td>
                                <td class="py-4 text-right font-medium">{{ $item->quantity }}</td>
                                <td class="py-4 text-right text-sm">LKR {{ number_format($item->unit_cost, 2) }}</td>
                                <td class="py-4 text-right font-bold text-glaciar-black">LKR {{ number_format($item->total_cost, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-right text-sm font-bold text-gray-600">Subtotal:</td>
                            <td class="py-3 px-4 text-right font-bold text-glaciar-black">LKR {{ number_format($purchase->total_cost - $purchase->tax, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-right text-sm font-bold text-gray-600 border-t border-gray-200">Tax / Additional:</td>
                            <td class="py-3 px-4 text-right font-bold text-glaciar-black border-t border-gray-200">LKR {{ number_format($purchase->tax, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-4 px-4 text-right text-lg font-extrabold text-glaciar-black border-t border-gray-300">Grand Total:</td>
                            <td class="py-4 px-4 text-right text-lg font-extrabold text-green-700 border-t border-gray-300">LKR {{ number_format($purchase->total_cost, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Action Card -->
        @if($purchase->status === 'pending')
            <div class="bg-white rounded-xl shadow-sm border border-amber-200 p-6 bg-amber-50">
                <h3 class="text-lg font-bold text-amber-900 mb-2">Receive Stock</h3>
                <p class="text-sm text-amber-700 mb-4">
                    Receiving this purchase order will immediately add the quantities to your inventory and update the product's purchase prices to match this invoice.
                </p>
                <form method="POST" action="{{ route('admin.inventory.purchases.receive', $purchase->id) }}" onsubmit="return confirm('Are you sure you want to receive this stock? This cannot be easily undone.');">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-amber-600 text-white font-bold rounded-lg hover:bg-amber-700 shadow-sm">
                        Mark as Received & Update Stock
                    </button>
                </form>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-green-200 p-6 bg-green-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-200 text-green-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-900">Stock Received</h3>
                        <p class="text-xs text-green-700">Inventory was updated successfully.</p>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Info Card -->
        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase">Supplier</div>
                <div class="font-bold text-glaciar-black mt-1">{{ $purchase->supplier->company_name ?? 'Unknown' }}</div>
                @if($purchase->supplier)
                    <div class="text-sm text-gray-600 mt-1">{{ $purchase->supplier->contact_person }}</div>
                    <div class="text-sm text-gray-600">{{ $purchase->supplier->phone }}</div>
                @endif
            </div>
            
            <div class="pt-4 border-t border-gray-100">
                <div class="text-xs font-bold text-gray-500 uppercase">Purchase Date</div>
                <div class="font-bold text-glaciar-black mt-1">{{ $purchase->purchase_date->format('F d, Y') }}</div>
            </div>
            
            <div class="pt-4 border-t border-gray-100">
                <div class="text-xs font-bold text-gray-500 uppercase">Created By</div>
                <div class="font-bold text-glaciar-black mt-1">{{ $purchase->user->name ?? 'System' }}</div>
            </div>
            
            @if($purchase->notes)
            <div class="pt-4 border-t border-gray-100">
                <div class="text-xs font-bold text-gray-500 uppercase">Notes</div>
                <div class="text-sm text-gray-700 mt-1">{{ $purchase->notes }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
