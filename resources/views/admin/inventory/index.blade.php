@extends('layouts.admin')

@section('header', 'Inventory')

@section('content')
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="p-6 border-b border-glaciar-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-glaciar-black">Products</h3>
            <div class="text-sm text-glaciar-gray-500">
                {{ method_exists($products, 'total') ? $products->total() : 0 }} total
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-glaciar-gray-100">
                <thead class="bg-[#FAFAFA]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Size</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Adjust</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-glaciar-gray-100">
                @forelse($products as $product)
                    @php
                        $isLow = (int) $product->stock <= (int) ($product->low_stock_threshold ?? 0);
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ (int) $product->size_ml }} ml</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">LKR {{ number_format((float) $product->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $isLow ? 'text-red-600 font-semibold' : 'text-glaciar-gray-700' }}">
                            {{ (int) $product->stock }}
                            @if($isLow)
                                <span class="ml-2 text-xs text-red-600">(Low)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <form method="POST" action="{{ route('admin.inventory.adjust') }}" class="flex items-center justify-end gap-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input
                                    type="number"
                                    name="adjustment"
                                    class="w-28 border border-glaciar-gray-200 rounded px-2 py-1 text-sm"
                                    value="0"
                                />
                                <button class="px-3 py-1.5 rounded bg-glaciar-black text-white text-xs font-semibold hover:bg-[#111]">
                                    Apply
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-glaciar-gray-500">
                            No products found yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($products, 'links'))
            <div class="p-6 border-t border-glaciar-gray-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection

