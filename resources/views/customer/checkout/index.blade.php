@extends('layouts.customer')

@section('content')
    <div class="bg-white border-b border-glaciar-gray-100 pt-6 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-glaciar-black mt-2">Checkout</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-24">
                
                <!-- Checkout Form -->
                <div class="flex-[1.5]">
                    
                    @if(!Auth::check())
                        <div class="bg-blue-50 border border-blue-100 text-blue-800 rounded-lg p-6 mb-8 flex items-center justify-between">
                            <div>
                                <p class="font-medium">Already have an account?</p>
                                <p class="text-sm mt-1 text-blue-600">Log in for faster checkout and to track your orders.</p>
                            </div>
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-white rounded shadow-sm text-sm font-semibold border border-blue-200 hover:bg-blue-50 transition-colors">Log In</a>
                        </div>
                    @endif

                    <div class="space-y-12">
                        <!-- Contact Information -->
                        <div>
                            <h2 class="text-2xl font-bold text-glaciar-black mb-6">Contact Information</h2>
                            
                            @if(Auth::check())
                                <div class="bg-glaciar-gray-50 p-4 rounded-lg border border-glaciar-gray-200 mb-6 flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center font-bold text-glaciar-black mr-4 border border-glaciar-gray-200">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-glaciar-black">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-glaciar-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-glaciar-gray-700">Full name</label>
                                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-glaciar-gray-700">Email address</label>
                                        <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-6">
                                <label for="phone" class="block text-sm font-medium text-glaciar-gray-700">Phone number</label>
                                <input type="tel" name="phone" id="phone" value="{{ Auth::user()->phone ?? '' }}" required class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                            </div>
                        </div>
                        
                        <!-- Delivery Address -->
                        <div>
                            <h2 class="text-2xl font-bold text-glaciar-black mb-6">Delivery Address</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="address" class="block text-sm font-medium text-glaciar-gray-700">Street address</label>
                                    <input type="text" name="address" id="address" value="{{ Auth::user()->address ?? '' }}" required class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black placeholder-glaciar-gray-300" placeholder="E.g. No 15, Galle Road">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="zone_id" class="block text-sm font-medium text-glaciar-gray-700">City / Delivery Zone</label>
                                        <select id="zone_id" name="zone_id" required class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                                            @foreach($zones ?? [] as $zone)
                                                <option value="{{ $zone->id }}" {{ (Auth::user()->zone_id ?? '') == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                                            @endforeach
                                            <!-- Dummy data if empty -->
                                            @if(empty($zones) || count($zones) == 0)
                                                <option value="1">Colombo 01-15</option>
                                                <option value="2">Colombo Suburbs</option>
                                                <option value="3">Gampaha</option>
                                                <option value="4">Kalutara</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Delivery (Optional Subscription) -->
                        <div class="bg-white border-2 border-glaciar-gray-200 rounded-xl p-6 relative" x-data="{ isSubscription: false }">
                            <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-glaciar-black flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Subscribe & Save
                            </div>
                            
                            <label class="flex items-center mb-6 cursor-pointer">
                                <input type="checkbox" name="is_subscription" x-model="isSubscription" class="w-5 h-5 rounded border-glaciar-gray-300 text-glaciar-black focus:ring-glaciar-black">
                                <span class="ml-3 font-medium text-glaciar-black">Set up repeating delivery (Save up to 15%)</span>
                            </label>
                            
                            <div x-show="isSubscription" x-transition class="space-y-4 pt-4 border-t border-glaciar-gray-100">
                                <div>
                                    <label for="frequency" class="block text-sm font-medium text-glaciar-gray-700">Delivery Frequency</label>
                                    <select id="frequency" name="frequency" class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                                        <option value="weekly">Weekly</option>
                                        <option value="biweekly">Every 2 Weeks</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                                <div class="bg-blue-50 text-sm text-blue-800 p-3 rounded-md">
                                    Your designated sales rep will contact you to confirm the exact delivery days based on your zone schedule.
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <h2 class="text-2xl font-bold text-glaciar-black mb-6">Payment</h2>
                            
                            <div class="space-y-4">
                                <!-- Cash on Delivery option -->
                                <label class="flex items-center justify-between p-4 border-2 border-glaciar-black rounded-lg cursor-pointer bg-glaciar-gray-50 relative">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="cash" checked class="w-5 h-5 text-glaciar-black focus:ring-glaciar-black border-glaciar-gray-300">
                                        <span class="ml-3 font-bold text-glaciar-black block">Cash on Delivery</span>
                                    </div>
                                    <svg class="w-6 h-6 text-glaciar-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </label>

                                <!-- Card Payment (Placeholder) -->
                                <label class="flex items-center justify-between p-4 border rounded-lg cursor-not-allowed bg-white opacity-60">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" value="card" disabled class="w-5 h-5 text-glaciar-gray-400 focus:ring-glaciar-gray-400 border-glaciar-gray-300 cursor-not-allowed">
                                        <div class="ml-3 w-full">
                                            <span class="font-medium text-glaciar-gray-600 block">Credit / Debit Card</span>
                                            <span class="text-xs text-glaciar-gray-500 mt-1 block">Coming soon</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="w-8 h-5 bg-glaciar-gray-200 rounded"></div>
                                        <div class="w-8 h-5 bg-glaciar-gray-200 rounded"></div>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="flex-1">
                    <div class="bg-white rounded-2xl p-8 border-2 border-glaciar-gray-100 shadow-sm sticky top-28">
                        <h2 class="text-xl font-bold text-glaciar-black mb-6">Order Summary</h2>
                        
                        <ul class="divide-y divide-glaciar-gray-100 mb-6">
                            @foreach($cartItems ?? [] as $item)
                                <li class="py-4 flex justify-between">
                                    <div class="flex">
                                        <div class="w-12 h-12 bg-glaciar-gray-50 rounded border border-glaciar-gray-100 flex items-center justify-center mr-4">
                                            <span class="text-xs font-bold text-glaciar-gray-400">{{ ($item->product->size_ml ?? 500) >= 1000 ? (($item->product->size_ml ?? 500) / 1000) . 'L' : ($item->product->size_ml ?? 500) . 'ml' }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-glaciar-black text-sm">{{ $item->product->name ?? 'Glaciar Product' }}</p>
                                            <p class="text-glaciar-gray-500 text-sm">Qty: {{ $item->qty }}</p>
                                        </div>
                                    </div>
                                    <p class="font-medium text-glaciar-black">LKR {{ number_format(($item->product->price ?? 100) * $item->qty, 0) }}</p>
                                </li>
                            @endforeach
                            <!-- Dummy Data for display preview -->
                            @if(empty($cartItems) || count($cartItems) == 0)
                                <li class="py-4 flex justify-between">
                                    <div class="flex">
                                        <div class="w-12 h-12 bg-glaciar-gray-50 rounded border border-glaciar-gray-100 flex items-center justify-center mr-4"><span class="text-xs">19L</span></div>
                                        <div><p class="font-semibold text-sm">Dispenser Bottle</p><p class="text-gray-500 text-sm">Qty: 2</p></div>
                                    </div>
                                    <p class="font-medium">LKR 700</p>
                                </li>
                            @endif
                        </ul>

                        <dl class="space-y-4 text-sm text-glaciar-gray-600 border-t border-glaciar-gray-100 pt-4">
                            <div class="flex items-center justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-glaciar-black">LKR {{ number_format($cartTotal ?? 700, 0) }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt>Delivery</dt>
                                <dd class="font-medium text-green-600">Free</dd>
                            </div>
                        </dl>
                        
                        <div class="border-t border-glaciar-gray-200 pt-4 mt-4 flex items-center justify-between mb-8">
                            <dt class="text-lg font-bold text-glaciar-black">Total</dt>
                            <dd class="text-2xl font-black text-glaciar-black">LKR {{ number_format($cartTotal ?? 700, 0) }}</dd>
                        </div>
                        
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-glaciar-black hover:bg-glaciar-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black transition-colors">
                            Complete Order
                        </button>
                        
                        <p class="text-xs text-center text-glaciar-gray-400 mt-4">
                            By placing this order, you agree to our Terms of Service and Privacy Policy. All payments are collected by our delivery representative.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
