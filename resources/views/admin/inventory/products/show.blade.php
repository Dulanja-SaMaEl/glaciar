@extends('layouts.admin')
@section('header', 'Product Details')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.inventory.products.index') }}" class="text-sm font-semibold text-gray-500 hover:text-glaciar-black flex items-center gap-2">
        &larr; Back to Products
    </a>
    <a href="{{ route('admin.inventory.products.edit', $product->id) }}" class="px-4 py-2 bg-glaciar-black text-white font-bold rounded-lg text-sm hover:bg-gray-900 transition-colors">
        Edit Product
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Product Info -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-xl font-bold text-glaciar-black mb-1">{{ $product->name }}</h2>
            <p class="text-sm text-gray-500 mb-6">SKU: {{ $product->sku ?? '-' }}</p>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 font-semibold">Category</span>
                    <span class="text-glaciar-black font-bold">{{ $product->category->name ?? 'None' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 font-semibold">Supplier</span>
                    <span class="text-glaciar-black font-bold">{{ $product->supplier->company_name ?? 'None' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 font-semibold">Brand</span>
                    <span class="text-glaciar-black font-bold">{{ $product->brand ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 font-semibold">Size</span>
                    <span class="text-glaciar-black font-bold">{{ $product->size_ml }} ml</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 font-semibold">Purchase Price</span>
                    <span class="text-glaciar-black font-bold">LKR {{ number_format($product->purchase_price, 2) }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 font-semibold">Selling Price</span>
                    <span class="text-glaciar-black font-bold">LKR {{ number_format($product->price, 2) }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500 font-semibold">Status</span>
                    <span class="text-glaciar-black font-bold">{{ ucfirst($product->status) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Status & Transactions -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Stock Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm border p-5">
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Current Stock</div>
                <div class="text-3xl font-extrabold 
                    {{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= $product->low_stock_threshold ? 'text-amber-600' : 'text-green-600') }}">
                    {{ $product->stock }}
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border p-5">
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Low Stock Alert At</div>
                <div class="text-3xl font-extrabold text-glaciar-black">{{ $product->low_stock_threshold }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border p-5">
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Stock Value</div>
                <div class="text-3xl font-extrabold text-blue-700">LKR {{ number_format($product->stock * $product->purchase_price, 0) }}</div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-glaciar-black">Recent Stock Activity</h3>
                <a href="{{ route('admin.inventory.transactions.index', ['product_id' => $product->id]) }}" class="text-sm font-bold text-blue-600 hover:underline">View All</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3 text-right">Quantity</th>
                            <th class="px-6 py-3">Reason/Notes</th>
                            <th class="px-6 py-3">User</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($product->stockTransactions as $trx)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $trx->date->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="font-bold {{ $trx->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ str_replace('_', ' ', Str::title($trx->type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold {{ $trx->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trx->quantity > 0 ? '+' : '' }}{{ $trx->quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $trx->reason ?? '-' }}
                                    @if($trx->notes)
                                        <div class="text-[10px] text-gray-400 mt-1">{{ Str::limit($trx->notes, 30) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $trx->user->name ?? 'System' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">No stock history recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
