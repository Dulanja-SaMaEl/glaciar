@extends('layouts.admin')
@section('header', 'Stock Transactions')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-glaciar-black">Stock History & Adjustments</h2>
        <p class="text-sm text-gray-500 mt-1">Track all stock movements or manually adjust inventory levels.</p>
    </div>
    <button onclick="document.getElementById('adjustmentModal').classList.remove('hidden')" class="px-4 py-2 bg-glaciar-black text-white font-bold rounded-lg text-sm hover:bg-gray-900 transition-colors shadow-sm">
        + Manual Stock Adjustment
    </button>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
    <form method="GET" action="{{ route('admin.inventory.transactions.index') }}" class="flex flex-wrap gap-4 items-end">
        <div class="w-64">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Product</label>
            <select name="product_id" class="w-full border-gray-200 rounded-lg text-sm">
                <option value="">All Products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected($productId == $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-48">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Transaction Type</label>
            <select name="type" class="w-full border-gray-200 rounded-lg text-sm">
                <option value="">All Types</option>
                <option value="stock_in" @selected($type === 'stock_in')>Stock In (Purchases)</option>
                <option value="sale" @selected($type === 'sale')>Sales</option>
                <option value="adjustment" @selected($type === 'adjustment')>Manual Adjustment</option>
                <option value="damaged" @selected($type === 'damaged')>Damaged Items</option>
                <option value="return" @selected($type === 'return')>Returns</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-gray-100 text-glaciar-black font-bold rounded-lg text-sm hover:bg-gray-200 transition-colors">
            Filter
        </button>
        @if($type || $productId)
            <a href="{{ route('admin.inventory.transactions.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-glaciar-black font-bold">Clear</a>
        @endif
    </form>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Product</th>
                    <th class="px-6 py-4 text-center">Type</th>
                    <th class="px-6 py-4 text-right">Quantity</th>
                    <th class="px-6 py-4">Reason / Reference</th>
                    <th class="px-6 py-4">User</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $trx->date->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.inventory.products.show', $trx->product_id) }}" class="font-bold text-glaciar-black hover:underline">
                                {{ $trx->product->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold">
                            @if($trx->quantity > 0)
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-[10px] uppercase">{{ str_replace('_', ' ', $trx->type) }}</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-[10px] uppercase">{{ str_replace('_', ' ', $trx->type) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold {{ $trx->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trx->quantity > 0 ? '+' : '' }}{{ $trx->quantity }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $trx->reason ?? '-' }}
                            @if($trx->notes)
                                <div class="text-[10px] text-gray-400 mt-1">{{ Str::limit($trx->notes, 40) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $trx->user->name ?? 'System' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No transactions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $transactions->links() }}
        </div>
    @endif
</div>

<!-- Manual Adjustment Modal -->
<div id="adjustmentModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl border w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-glaciar-black">Manual Stock Adjustment</h3>
            <button onclick="document.getElementById('adjustmentModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        
        <form action="{{ route('admin.inventory.transactions.adjust') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Product</label>
                    <select name="product_id" class="w-full rounded-lg border-gray-300" required>
                        <option value="">Select Product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Current: {{ $product->stock }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Adjustment Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-300" required>
                            <option value="adjustment">General Adjustment</option>
                            <option value="damaged">Damaged Goods (Deduct)</option>
                            <option value="return">Customer Return (Add)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Quantity <span class="text-xs font-normal text-gray-500">(Use - for deduction)</span></label>
                        <input type="number" name="quantity" class="w-full rounded-lg border-gray-300" required placeholder="e.g. -5 or 10">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Reason</label>
                    <input type="text" name="reason" class="w-full rounded-lg border-gray-300" required placeholder="e.g. Stock check discrepancy">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Additional Notes</label>
                    <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300"></textarea>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('adjustmentModal').classList.add('hidden')" class="px-4 py-2 bg-white border rounded-lg text-gray-600 font-bold hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-glaciar-black text-white rounded-lg font-bold hover:bg-gray-900">Record Adjustment</button>
            </div>
        </form>
    </div>
</div>
@endsection
