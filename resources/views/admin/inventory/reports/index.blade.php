@extends('layouts.admin')
@section('header', 'Inventory Reports')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-glaciar-black">Inventory Reports</h2>
    <p class="text-sm text-gray-500 mt-1">Generate and export comprehensive reports for your stock and purchases.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Current Stock Report -->
    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
            <h3 class="text-lg font-bold text-glaciar-black mb-2">Current Stock Valuation</h3>
            <p class="text-sm text-gray-500 mb-6">Detailed report of all products currently in stock, their quantities, and total purchase/selling valuation.</p>
        </div>
        <button class="w-full py-2 bg-gray-100 text-glaciar-black font-bold rounded-lg hover:bg-gray-200 transition-colors">Generate Report</button>
    </div>

    <!-- Low Stock Report -->
    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-glaciar-black mb-2">Low/Out of Stock Items</h3>
            <p class="text-sm text-gray-500 mb-6">Identify products that need immediate reordering to prevent stockouts.</p>
        </div>
        <a href="{{ route('admin.inventory.products.index', ['status' => 'low_stock']) }}" class="block text-center w-full py-2 bg-gray-100 text-glaciar-black font-bold rounded-lg hover:bg-gray-200 transition-colors">View Products</a>
    </div>

    <!-- Stock Movement Report -->
    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
            </div>
            <h3 class="text-lg font-bold text-glaciar-black mb-2">Stock Movement History</h3>
            <p class="text-sm text-gray-500 mb-6">Comprehensive audit trail of all stock ins, outs, sales, and manual adjustments.</p>
        </div>
        <a href="{{ route('admin.inventory.transactions.index') }}" class="block text-center w-full py-2 bg-gray-100 text-glaciar-black font-bold rounded-lg hover:bg-gray-200 transition-colors">View Transactions</a>
    </div>

    <!-- Supplier Purchase Report -->
    <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-glaciar-black mb-2">Supplier Purchases</h3>
            <p class="text-sm text-gray-500 mb-6">Analyze stock intake volume and spending grouped by supplier over a specific time period.</p>
        </div>
        <button class="w-full py-2 bg-gray-100 text-glaciar-black font-bold rounded-lg hover:bg-gray-200 transition-colors">Generate Report</button>
    </div>
</div>
@endsection
