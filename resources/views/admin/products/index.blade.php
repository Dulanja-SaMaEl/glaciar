@extends('layouts.admin')

@section('header', 'Products & Inventory')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-glaciar-black">Manage Products</h2>
        <button class="px-4 py-2 bg-glaciar-black text-white rounded-lg hover:bg-black transition-colors">Add New Product</button>
    </div>

    <!-- Inventory Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <span class="text-sm font-medium text-glaciar-gray-500">Total Product Lines</span>
            <div class="text-2xl font-bold text-glaciar-black">24</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <span class="text-sm font-medium text-glaciar-gray-500">Low Stock Alerts</span>
            <div class="text-2xl font-bold text-red-600">3</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <span class="text-sm font-medium text-glaciar-gray-500">Total Value (Est.)</span>
            <div class="text-2xl font-bold text-glaciar-black">LKR 1,240,500</div>
        </div>
    </div>

    <!-- Products Catalog -->
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="p-4 border-b border-glaciar-gray-100">
            <h3 class="text-lg font-bold text-glaciar-black">Product Catalog</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-glaciar-gray-100">
                <thead class="bg-glaciar-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">SKU / Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Pricing</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-glaciar-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-glaciar-gray-100">
                    @foreach([
                        ['name' => 'Premium 19L Bottle', 'size' => '19000ml', 'price' => 850, 'stock' => 124, 'status' => 'Active'],
                        ['name' => 'Premium 5L Bottle', 'size' => '5000ml', 'price' => 240, 'stock' => 18, 'status' => 'Active'],
                        ['name' => 'Premium 1.5L Bottle', 'size' => '1500ml', 'price' => 120, 'stock' => 450, 'status' => 'Active'],
                    ] as $p)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $p['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $p['size'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black">LKR {{ number_format($p['price'], 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black font-bold">{{ $p['stock'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">{{ $p['status'] }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
