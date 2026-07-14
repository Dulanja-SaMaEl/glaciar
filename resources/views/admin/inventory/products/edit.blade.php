@extends('layouts.admin')
@section('header', 'Edit Product')

@section('content')
<div class="mb-6 flex justify-between">
    <a href="{{ route('admin.inventory.products.index') }}" class="text-sm font-semibold text-gray-500 hover:text-glaciar-black flex items-center gap-2">
        &larr; Back to Products
    </a>
    <form action="{{ route('admin.inventory.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
        @csrf @method('DELETE')
        <button type="submit" class="text-sm text-red-600 font-bold hover:underline">Delete Product</button>
    </form>
</div>

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border p-8">
    <h2 class="text-2xl font-bold text-glaciar-black mb-8">Edit: {{ $product->name }}</h2>

    <form method="POST" action="{{ route('admin.inventory.products.update', $product->id) }}" class="space-y-6">
        @csrf @method('PUT')

        <!-- Identical to create form with $product values injected -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-lg border-gray-300 focus:border-glaciar-black focus:ring focus:ring-glaciar-black/20" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-lg border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Barcode / QR Code</label>
                <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" class="w-full rounded-lg border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                <select name="category_id" class="w-full rounded-lg border-gray-300">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Supplier</label>
                <select name="supplier_id" class="w-full rounded-lg border-gray-300">
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>{{ $supplier->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Brand</label>
                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full rounded-lg border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Unit Type <span class="text-red-500">*</span></label>
                <input type="text" name="unit_type" value="{{ old('unit_type', $product->unit_type) }}" class="w-full rounded-lg border-gray-300" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Size (ml) <span class="text-red-500">*</span></label>
                <input type="number" name="size_ml" value="{{ old('size_ml', $product->size_ml) }}" class="w-full rounded-lg border-gray-300" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Purchase Price (LKR) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" class="w-full rounded-lg border-gray-300" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Selling Price (LKR) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full rounded-lg border-gray-300" required>
            </div>

            <div class="md:col-span-2 pt-4 border-t">
                <h3 class="text-lg font-bold text-glaciar-black mb-4">Stock Levels & Alerts</h3>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Low Stock Threshold (Alert) <span class="text-red-500">*</span></label>
                <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" class="w-full rounded-lg border-gray-300" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Minimum Stock Level <span class="text-red-500">*</span></label>
                <input type="number" name="minimum_stock_level" value="{{ old('minimum_stock_level', $product->minimum_stock_level) }}" class="w-full rounded-lg border-gray-300" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Maximum Stock Capacity</label>
                <input type="number" name="maximum_stock_capacity" value="{{ old('maximum_stock_capacity', $product->maximum_stock_capacity) }}" class="w-full rounded-lg border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full rounded-lg border-gray-300" required>
                    <option value="active" @selected(old('status', $product->status) === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $product->status) === 'inactive')>Inactive</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
            <a href="{{ route('admin.inventory.products.index') }}" class="px-6 py-2 rounded-lg text-gray-600 font-bold hover:bg-gray-100">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-glaciar-black text-white font-bold rounded-lg hover:bg-gray-900 shadow-sm">Update Product</button>
        </div>
    </form>
</div>
@endsection
