@extends('layouts.customer')

@section('content')
    <div class="bg-white border-b border-glaciar-gray-100 pt-6 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-glaciar-black mt-2">Your Cart</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(count($cartItems ?? []) > 0)
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Cart Items -->
                <div class="flex-1">
                    <ul class="divide-y divide-glaciar-gray-100 border-t border-b border-glaciar-gray-100">
                        @foreach($cartItems as $item)
                        <li class="py-6 flex items-center">
                            <!-- Placeholder image based on size -->
                            <div class="w-24 h-24 bg-blue-50 rounded-lg border border-blue-100 flex-shrink-0 flex items-center justify-center p-2">
                                <div class="w-full h-full bg-white/60 rounded-md shadow-sm flex items-center justify-center relative">
                                    <span class="text-sm font-bold text-glaciar-black/30">{{ ($item->product->size_ml ?? 500) >= 1000 ? (($item->product->size_ml ?? 500) / 1000) . 'L' : ($item->product->size_ml ?? 500) . 'ml' }}</span>
                                </div>
                            </div>

                            <div class="ml-6 flex-1 flex flex-col justify-center">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-glaciar-black">
                                            <a href="{{ route('products.show', $item->product_id) }}">{{ $item->product->name ?? 'Glaciar Standard' }}</a>
                                        </h3>
                                        <p class="mt-1 text-sm text-glaciar-gray-500">LKR {{ number_format($item->product->price ?? 80, 0) }}</p>
                                    </div>
                                    <p class="text-lg font-bold text-glaciar-black">LKR {{ number_format(($item->product->price ?? 80) * $item->qty, 0) }}</p>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center border border-glaciar-gray-200 rounded-md">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ $item->qty - 1 }}">
                                            <button type="submit" class="px-3 py-1 text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-50" @disabled($item->qty <= 1)>-</button>
                                        </form>
                                        <span class="px-3 py-1 text-sm font-medium w-12 text-center">{{ $item->qty }}</span>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                            <button type="submit" class="px-3 py-1 text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-50">+</button>
                                        </form>
                                    </div>
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-96 flex-shrink-0">
                    <div class="bg-glaciar-gray-50 rounded-2xl p-8 border border-glaciar-gray-100 sticky top-28">
                        <h2 class="text-xl font-bold text-glaciar-black mb-6">Order Summary</h2>
                        
                        <dl class="space-y-4 text-sm text-glaciar-gray-600">
                            <div class="flex items-center justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-glaciar-black">LKR {{ number_format($cartTotal ?? 0, 0) }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt>Delivery estimate</dt>
                                <dd class="font-medium text-green-600">Free</dd>
                            </div>
                        </dl>
                        
                        <div class="border-t border-glaciar-gray-200 pt-4 mt-4 flex items-center justify-between">
                            <dt class="text-base font-bold text-glaciar-black">Order total</dt>
                            <dd class="text-xl font-bold text-glaciar-black">LKR {{ number_format($cartTotal ?? 0, 0) }}</dd>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="mt-8 w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-glaciar-black hover:bg-glaciar-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black transition-colors">
                            Proceed to Checkout
                        </a>
                        
                        <div class="mt-6 text-center text-sm text-glaciar-gray-500">
                            <p>
                                or
                                <a href="{{ route('products.index') }}" class="text-glaciar-black font-semibold hover:underline">Continue Shopping<span aria-hidden="true"> &rarr;</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart Dummy Data -->
            <div class="text-center py-24 bg-glaciar-gray-50 rounded-2xl border border-glaciar-gray-100">
                <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-sm border border-glaciar-gray-100">
                    <svg class="w-12 h-12 text-glaciar-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-glaciar-black mb-4">Your cart is empty</h2>
                <p class="text-glaciar-gray-500 mb-8 max-w-sm mx-auto">Looks like you haven't added any water to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center py-4 px-8 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-glaciar-black hover:bg-glaciar-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black transition-colors">
                    Start Shopping
                </a>
            </div>
            
            <!-- Adding a dummy item for visualization purposes during dev if cart is empty -->
            <div class="mt-16 pt-8 border-t border-gray-200">
                <p class="text-xs text-gray-400 mb-4 text-center">Development/Demo View Below (What it looks like with items)</p>
                <!-- Include the cart layout from above here if needed to show to user in review, skipped for brevity -->
                 <div class="flex flex-col lg:flex-row gap-12 opacity-50 pointer-events-none filter grayscale">
                    <div class="flex-1">
                        <ul class="divide-y divide-glaciar-gray-100 border-t border-b border-glaciar-gray-100">
                            <li class="py-6 flex items-center">
                                <div class="w-24 h-24 bg-blue-50 rounded-lg border border-blue-100 flex-shrink-0 flex items-center justify-center p-2">
                                    <div class="w-full h-full bg-white/60 rounded-md shadow-sm flex items-center justify-center relative">
                                        <span class="text-sm font-bold text-glaciar-black/30">19L</span>
                                    </div>
                                </div>
                                <div class="ml-6 flex-1 flex flex-col justify-center">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-glaciar-black">Glaciar Dispenser Bottle</h3>
                                            <p class="mt-1 text-sm text-glaciar-gray-500">LKR 350</p>
                                        </div>
                                        <p class="text-lg font-bold text-glaciar-black">LKR 700</p>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center border border-glaciar-gray-200 rounded-md">
                                            <button class="px-3 py-1 text-glaciar-gray-500">-</button>
                                            <span class="px-3 py-1 text-sm font-medium w-12 text-center">2</span>
                                            <button class="px-3 py-1 text-glaciar-gray-500">+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="w-full lg:w-96 flex-shrink-0">
                        <div class="bg-glaciar-gray-50 rounded-2xl p-8 border border-glaciar-gray-100">
                            <h2 class="text-xl font-bold text-glaciar-black mb-6">Order Summary</h2>
                            <div class="border-t border-glaciar-gray-200 pt-4 mt-4 flex items-center justify-between">
                                <dt class="text-base font-bold text-glaciar-black">Order total</dt>
                                <dd class="text-xl font-bold text-glaciar-black">LKR 700</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
