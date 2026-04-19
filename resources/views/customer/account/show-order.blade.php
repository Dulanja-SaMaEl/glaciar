@extends('customer.account.layout')

@section('account_content')
    <div class="mb-6">
        <a href="{{ route('account.orders') }}" class="inline-flex items-center text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black transition-colors mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Orders
        </a>
        
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-glaciar-black">Order #ORD-{{ str_pad($order->id ?? '123', 5, '0', STR_PAD_LEFT) }}</h2>
            
            @php
                $status = strtolower($order->status ?? 'pending');
                $classes = match ($status) {
                    'delivered', 'completed' => 'bg-green-100 text-green-800',
                    'pending', 'processing', 'out_for_delivery' => 'bg-amber-100 text-amber-800',
                    'cancelled', 'failed' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $classes }}">
                {{ ucfirst(str_replace('_', ' ', $status)) }}
            </span>
        </div>
        <p class="text-sm text-glaciar-gray-500 mt-1">Placed on {{ isset($order) ? $order->created_at->format('F d, Y \a\t h:i A') : 'October 12, 2024 at 10:30 AM' }}</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-glaciar-gray-100">
            <h3 class="text-lg font-bold text-glaciar-black mb-4">Items Ordered</h3>
            
            <ul class="divide-y divide-glaciar-gray-100">
                @forelse($order->items ?? [] as $item)
                    @php
                        $lineTotal = ((int) $item->qty) * ((float) $item->unit_price);
                    @endphp
                    <li class="py-4 flex justify-between">
                        <div class="flex">
                            <div class="w-16 h-16 bg-blue-50 rounded border border-blue-100 flex items-center justify-center mr-4">
                                <span class="text-xs font-bold text-glaciar-black/40">{{ ($item->product->size_ml ?? 500) >= 1000 ? (($item->product->size_ml ?? 500) / 1000) . 'L' : ($item->product->size_ml ?? 500) . 'ml' }}</span>
                            </div>
                            <div class="flex flex-col justify-center">
                                <p class="font-bold text-glaciar-black text-base">
                                    <a href="{{ route('products.show', $item->product_id) }}" class="hover:text-blue-600 transition-colors">{{ $item->product?->name ?? ('Product #' . $item->product_id) }}</a>
                                </p>
                                <p class="text-glaciar-gray-500 text-sm mt-1">LKR {{ number_format($item->unit_price, 0) }} &times; {{ (int) $item->qty }}</p>
                            </div>
                        </div>
                        <p class="font-bold text-glaciar-black flex items-center">LKR {{ number_format($lineTotal, 0) }}</p>
                    </li>
                @empty
                    <!-- Dummy items for fallback/demo -->
                    <li class="py-4 flex justify-between">
                        <div class="flex">
                            <div class="w-16 h-16 bg-blue-50 rounded border border-blue-100 flex items-center justify-center mr-4"><span class="text-xs font-bold text-glaciar-black/40">19L</span></div>
                            <div class="flex flex-col justify-center">
                                <p class="font-bold text-glaciar-black text-base">Glaciar Dispenser Bottle</p>
                                <p class="text-glaciar-gray-500 text-sm mt-1">LKR 350 &times; 2</p>
                            </div>
                        </div>
                        <p class="font-bold text-glaciar-black flex items-center">LKR 700</p>
                    </li>
                    <li class="py-4 flex justify-between">
                        <div class="flex">
                            <div class="w-16 h-16 bg-blue-50 rounded border border-blue-100 flex items-center justify-center mr-4"><span class="text-xs font-bold text-glaciar-black/40">500ml</span></div>
                            <div class="flex flex-col justify-center">
                                <p class="font-bold text-glaciar-black text-base">Glaciar Standard (Pack of 24)</p>
                                <p class="text-glaciar-gray-500 text-sm mt-1">LKR 1,920 &times; 1</p>
                            </div>
                        </div>
                        <p class="font-bold text-glaciar-black flex items-center">LKR 1,920</p>
                    </li>
                @endforelse
            </ul>
        </div>
        
        <div class="bg-glaciar-gray-50 p-6 flex flex-col items-end">
            <dl class="w-full max-w-sm space-y-3 text-sm text-glaciar-gray-600">
                <div class="flex justify-between">
                    <dt>Subtotal</dt>
                    <dd class="font-medium text-glaciar-black">LKR {{ number_format($order->total ?? 2620, 0) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt>Delivery</dt>
                    <dd class="font-medium text-green-600">Free</dd>
                </div>
                <div class="flex justify-between border-t border-glaciar-gray-200 pt-3 mt-3">
                    <dt class="text-base font-bold text-glaciar-black">Total</dt>
                    <dd class="text-xl font-bold text-glaciar-black">LKR {{ number_format($order->total ?? 2620, 0) }}</dd>
                </div>
            </dl>
        </div>
    </div>
    
    <!-- Order Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Delivery Info -->
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <h3 class="text-lg font-bold text-glaciar-black mb-4">Delivery Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-glaciar-gray-500">Address</p>
                    <p class="text-sm text-glaciar-black mt-1">{{ Auth::user()->address ?? 'Address not available' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-glaciar-gray-500">Delivery Status</p>
                    @if(isset($order) && $order->delivery)
                        <p class="text-sm text-glaciar-black mt-1 capitalize">{{ str_replace('_', ' ', $order->delivery->status) }}</p>
                        @if($order->delivery->rep)
                            <p class="text-sm text-glaciar-gray-500 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Delivered by {{ $order->delivery->rep->name ?? 'Rep' }}
                            </p>
                        @endif
                    @else
                        <p class="text-sm text-glaciar-black mt-1">Awaiting Schedule</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Payment Info -->
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <h3 class="text-lg font-bold text-glaciar-black mb-4">Payment Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-glaciar-gray-500">Payment Method</p>
                    <p class="text-sm text-glaciar-black mt-1 capitalize">{{ $order->payment_method ?? 'Cash on Delivery' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-glaciar-gray-500">Payment Status</p>
                    <p class="text-sm text-glaciar-black mt-1 flex items-center gap-2">
                        @if(optional($order->payment)->status === 'verified')
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            Paid
                        @else
                            <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                            Pending
                        @endif
                    </p>
                </div>
                @if(isset($order) && $order->invoice)
                    <div class="pt-2">
                        <a href="{{ route('account.orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Invoice PDF
                        </a>
                    </div>
                @else
                     <div class="pt-2">
                        <button disabled class="inline-flex items-center text-sm font-bold text-glaciar-gray-400 cursor-not-allowed">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Invoice processing...
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
    </div>
@endsection
