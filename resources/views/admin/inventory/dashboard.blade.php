@extends('layouts.admin')
@section('header', 'Inventory Dashboard')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-glaciar-black">Inventory Overview</h2>
        <p class="text-sm text-gray-500 mt-1">Real-time tracking of your stock levels and valuations.</p>
    </div>
    
    <div class="flex gap-3">
        <a href="{{ route('admin.inventory.purchases.create') }}" class="px-4 py-2 bg-white border border-gray-200 text-glaciar-black font-bold rounded-lg text-sm hover:bg-gray-50 transition-colors">
            + Receive Stock
        </a>
        <a href="{{ route('admin.inventory.products.create') }}" class="px-4 py-2 bg-glaciar-black text-white font-bold rounded-lg text-sm hover:bg-gray-900 transition-colors shadow-sm">
            + New Product
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col">
        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Total Products</span>
        <span class="text-3xl font-extrabold text-glaciar-black">{{ number_format($totalProducts) }}</span>
        <div class="mt-4 text-sm text-gray-600 flex justify-between">
            <span>In Stock: <b>{{ $inStockCount }}</b></span>
            <span>Out: <b class="text-red-600">{{ $outOfStockCount }}</b></span>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col">
        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Inventory Value</span>
        <span class="text-3xl font-extrabold text-green-700">LKR {{ number_format($stockValue, 0) }}</span>
        <span class="mt-4 text-xs text-gray-500">Based on purchase price</span>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col">
        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Low Stock Alerts</span>
        <span class="text-3xl font-extrabold text-amber-600">{{ number_format($lowStockCount) }}</span>
        <a href="{{ route('admin.inventory.products.index', ['status' => 'low_stock']) }}" class="mt-4 text-xs font-bold text-amber-700 hover:underline">View Items &rarr;</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col">
        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Suppliers / Categories</span>
        <span class="text-3xl font-extrabold text-glaciar-black">{{ number_format($totalSuppliers) }} <span class="text-gray-400 font-normal text-xl">/ {{ number_format($totalCategories) }}</span></span>
        <div class="mt-4 flex gap-4 text-xs font-bold text-blue-600">
            <a href="{{ route('admin.inventory.suppliers.index') }}" class="hover:underline">Suppliers</a>
            <a href="{{ route('admin.inventory.categories.index') }}" class="hover:underline">Categories</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Col -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Low Stock / Out of Stock Table -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-bold text-glaciar-black mb-4">Action Required: Critical Stock</h3>
            
            @if($outOfStockProducts->isEmpty() && $lowStockProducts->isEmpty())
                <div class="py-8 text-center bg-green-50 rounded-lg border border-green-100">
                    <span class="text-green-700 font-bold text-lg block">All Good!</span>
                    <span class="text-green-600 text-sm">No products are running low or out of stock.</span>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                <th class="pb-3 font-semibold">Product</th>
                                <th class="pb-3 font-semibold">SKU</th>
                                <th class="pb-3 font-semibold text-right">Current Stock</th>
                                <th class="pb-3 font-semibold text-right">Threshold</th>
                                <th class="pb-3 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($outOfStockProducts as $product)
                                <tr>
                                    <td class="py-3 text-sm font-bold text-glaciar-black">
                                        {{ $product->name }}
                                        <span class="ml-2 inline-flex px-2 py-0.5 rounded-full bg-red-100 text-red-800 text-[10px] font-bold">OUT OF STOCK</span>
                                    </td>
                                    <td class="py-3 text-sm text-gray-500">{{ $product->sku ?? '-' }}</td>
                                    <td class="py-3 text-sm font-bold text-red-600 text-right">{{ $product->stock }}</td>
                                    <td class="py-3 text-sm text-gray-500 text-right">{{ $product->low_stock_threshold }}</td>
                                    <td class="py-3 text-right">
                                        <a href="{{ route('admin.inventory.products.show', $product->id) }}" class="text-xs font-bold text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td class="py-3 text-sm font-bold text-glaciar-black">
                                        {{ $product->name }}
                                        <span class="ml-2 inline-flex px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">LOW</span>
                                    </td>
                                    <td class="py-3 text-sm text-gray-500">{{ $product->sku ?? '-' }}</td>
                                    <td class="py-3 text-sm font-bold text-amber-600 text-right">{{ $product->stock }}</td>
                                    <td class="py-3 text-sm text-gray-500 text-right">{{ $product->low_stock_threshold }}</td>
                                    <td class="py-3 text-right">
                                        <a href="{{ route('admin.inventory.products.show', $product->id) }}" class="text-xs font-bold text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Right Col -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-glaciar-black">Recent Activity</h3>
                <a href="{{ route('admin.inventory.transactions.index') }}" class="text-xs text-blue-600 font-bold hover:underline">View All</a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentTransactions as $trx)
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-8 h-8 rounded-full flex items-center justify-center shrink-0 
                            {{ $trx->quantity > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($trx->quantity > 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                @endif
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-glaciar-black">
                                {{ $trx->product->name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $trx->quantity > 0 ? '+' : '' }}{{ $trx->quantity }} {{ str_replace('_', ' ', Str::title($trx->type)) }}
                            </div>
                            <div class="text-[10px] text-gray-400 mt-1">
                                {{ $trx->date->diffForHumans() }} by {{ $trx->user->name ?? 'System' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-sm text-gray-500 py-4">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
