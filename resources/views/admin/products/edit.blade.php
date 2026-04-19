@extends('layouts.admin')

@section('header', 'Edit Product: ' . $product->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Products
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
            <div class="p-6 border-b border-glaciar-gray-100">
                <h3 class="text-lg font-bold text-glaciar-black">Product Information</h3>
            </div>

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Product Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                            class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black sm:text-sm">
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="size_ml" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Size (ml)</label>
                        <input type="number" name="size_ml" id="size_ml" value="{{ old('size_ml', $product->size_ml) }}" required
                            class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black sm:text-sm">
                        @error('size_ml') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Price (LKR)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" required
                            class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black sm:text-sm">
                        @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Stock Level</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required
                            class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black sm:text-sm">
                        @error('stock') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="low_stock_threshold" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Low Stock Threshold</label>
                        <input type="number" name="low_stock_threshold" id="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" required
                            class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black sm:text-sm">
                        @error('low_stock_threshold') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Status</label>
                        <select name="status" id="status" required
                            class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black sm:text-sm">
                            <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-glaciar-gray-100 flex justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}" 
                        class="px-4 py-2 border border-glaciar-gray-300 rounded-md text-sm font-medium text-glaciar-black hover:bg-glaciar-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-glaciar-black text-white rounded-md text-sm font-medium hover:bg-glaciar-gray-900 shadow-sm">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
