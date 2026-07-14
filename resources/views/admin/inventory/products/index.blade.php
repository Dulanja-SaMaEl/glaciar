@extends('layouts.admin')
@section('header', 'Products')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-glaciar-black">Product Management</h2>
        <p class="text-sm text-gray-500 mt-1">Manage your inventory products and stock levels.</p>
    </div>
    <a href="{{ route('admin.inventory.products.create') }}" class="px-4 py-2 bg-glaciar-black text-white font-bold rounded-lg text-sm hover:bg-gray-900 transition-colors shadow-sm">
        + Add New Product
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
    <form method="GET" action="{{ route('admin.inventory.products.index') }}" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Search</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Name, SKU, Barcode..." class="w-full border-gray-200 rounded-lg text-sm">
        </div>
        <div class="w-48">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Category</label>
            <select name="category_id" class="w-full border-gray-200 rounded-lg text-sm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected($categoryId == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-48">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
            <select name="status" class="w-full border-gray-200 rounded-lg text-sm">
                <option value="">All Statuses</option>
                <option value="active" @selected($status === 'active')>Active</option>
                <option value="inactive" @selected($status === 'inactive')>Inactive</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-gray-100 text-glaciar-black font-bold rounded-lg text-sm hover:bg-gray-200 transition-colors">
            Filter
        </button>
        @if($search || $categoryId || $status)
            <a href="{{ route('admin.inventory.products.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-glaciar-black font-bold">Clear</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">Product</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4 text-right">Price</th>
                    <th class="px-6 py-4 text-right">Stock</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-glaciar-black">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500 mt-1">SKU: {{ $product->sku ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">
                            LKR {{ number_format($product->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="font-bold {{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= $product->low_stock_threshold ? 'text-amber-600' : 'text-green-600') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($product->status === 'active')
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold uppercase">Active</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-[10px] font-bold uppercase">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.inventory.products.show', $product->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                            <a href="{{ route('admin.inventory.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
