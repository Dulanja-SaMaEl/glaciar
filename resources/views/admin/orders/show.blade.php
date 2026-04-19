@extends('layouts.admin')

@section('header', 'Order Details')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center">
            <a href="{{ route('admin.orders.index') }}" class="mr-4 p-2 rounded-full hover:bg-glaciar-gray-100 transition-colors">
                <svg class="w-5 h-5 text-glaciar-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-glaciar-black">Order #ORD-{{ str_pad($order->id ?? '1025', 5, '0', STR_PAD_LEFT) }}</h1>
                <p class="text-sm text-glaciar-gray-500 mt-1">Placed on {{ isset($order) ? $order->created_at->format('M d, Y \A\T h:i A') : 'Oct 15, 2024 AT 10:30 AM' }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <x-admin.status-badge :status="$order->status ?? 'pending'" />
            <button class="px-4 py-2 bg-glaciar-black text-white text-sm font-medium rounded-md hover:bg-glaciar-gray-900 transition-colors shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Invoice PDF
            </button>
        </div>
    </div>

    <!-- Order Actions / Status Updates -->
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4 mb-8 flex flex-wrap gap-4 items-center">
        <span class="text-sm font-bold text-glaciar-black mr-2">Update Status:</span>
        <form method="POST" action="#" class="inline-block">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="processing">
            <button type="submit" class="px-3 py-1.5 rounded-full text-xs font-medium border border-blue-200 text-blue-700 hover:bg-blue-50 transition-colors {{ ($order->status ?? '') === 'processing' ? 'bg-blue-50 ring-1 ring-blue-500' : '' }}">Mark Processing</button>
        </form>
        <form method="POST" action="#" class="inline-block">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="out_for_delivery">
            <button type="submit" class="px-3 py-1.5 rounded-full text-xs font-medium border border-amber-200 text-amber-700 hover:bg-amber-50 transition-colors {{ ($order->status ?? '') === 'out_for_delivery' ? 'bg-amber-50 ring-1 ring-amber-500' : '' }}">Out For Delivery</button>
        </form>
        <form method="POST" action="#" class="inline-block">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="delivered">
            <button type="submit" class="px-3 py-1.5 rounded-full text-xs font-medium border border-green-200 text-green-700 hover:bg-green-50 transition-colors {{ ($order->status ?? '') === 'delivered' ? 'bg-green-50 ring-1 ring-green-500' : '' }}">Mark Delivered</button>
        </form>
        <form method="POST" action="#" class="inline-block ml-auto">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="px-3 py-1.5 rounded-full text-xs font-medium border border-red-200 text-red-700 hover:bg-red-50 transition-colors" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (Items & Payment) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-4 border-b border-glaciar-gray-100 bg-glaciar-gray-50">
                    <h3 class="font-bold text-glaciar-black">Order Items</h3>
                </div>
                <table class="min-w-full divide-y divide-glaciar-gray-100">
                    <thead class="bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Unit Price</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-glaciar-gray-100 bg-white">
                        @forelse($order->items ?? [] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-blue-50 rounded border border-blue-100 flex items-center justify-center">
                                            <span class="text-[10px] font-bold text-glaciar-black/40">{{ ($item->product->size_ml ?? 500) >= 1000 ? (($item->product->size_ml ?? 500) / 1000) . 'L' : ($item->product->size_ml ?? 500) . 'ml' }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-glaciar-black">{{ $item->product_name }}</div>
                                            <div class="text-xs text-glaciar-gray-500">SKU: PRD-{{ str_pad($item->product_id, 3, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-glaciar-black font-medium">{{ (int) $item->qty }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-glaciar-black">LKR {{ number_format($item->unit_price, 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-glaciar-black">LKR {{ number_format(((int) $item->qty) * ((float) $item->unit_price), 0) }}</td>
                            </tr>
                        @empty
                            <!-- Dummy Data -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-blue-50 rounded border border-blue-100 flex items-center justify-center">
                                            <span class="text-[10px] font-bold text-glaciar-black/40">19L</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-glaciar-black">Glaciar Dispenser Bottle</div>
                                            <div class="text-xs text-glaciar-gray-500">SKU: PRD-004</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-glaciar-black font-medium">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-glaciar-black">LKR 350</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-glaciar-black">LKR 3,500</td>
                            </tr>
                             <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-blue-50 rounded border border-blue-100 flex items-center justify-center">
                                            <span class="text-[10px] font-bold text-glaciar-black/40">500ml</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-glaciar-black">Glaciar Standard (Pack of 24)</div>
                                            <div class="text-xs text-glaciar-gray-500">SKU: PRD-001</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-glaciar-black font-medium">5</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-glaciar-black">LKR 2,400</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-glaciar-black">LKR 12,000</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-glaciar-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-glaciar-gray-500">Subtotal</td>
                            <td class="px-6 py-3 text-right text-sm font-bold text-glaciar-black">LKR {{ number_format($order->total ?? 15500, 0) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-glaciar-gray-500">Delivery Fee</td>
                            <td class="px-6 py-3 text-right text-sm font-bold text-green-600">Free</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-base font-bold text-glaciar-black border-t border-glaciar-gray-200">Total</td>
                            <td class="px-6 py-4 text-right text-lg font-black text-glaciar-black border-t border-glaciar-gray-200">LKR {{ number_format($order->total ?? 15500, 0) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-glaciar-black">Payment Details</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit Payment</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500 mb-1">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ optional($order->payment)->status === 'verified' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ optional($order->payment)->status === 'verified' ? 'Paid' : 'Pending' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500 mb-1">Method</p>
                        <p class="text-sm font-bold text-glaciar-black capitalize">{{ str_replace('_', ' ', $order->payment_method ?? 'invoice') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500 mb-1">Payment Date</p>
                        <p class="text-sm font-bold text-glaciar-black">{{ ($order->payment && optional($order->payment)->status === 'verified') ? $order->payment->created_at->format('M d, Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (Customer & Delivery) -->
        <div class="lg:col-span-1 space-y-8">
            
            <!-- Customer Details -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <h3 class="text-lg font-bold text-glaciar-black mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Customer
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold mr-3">
                            {{ substr($order->customer->name ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-glaciar-black text-sm">{{ $order->customer->name ?? 'Customer' }}</p>
                            <p class="text-xs text-glaciar-gray-500">{{ $order->type === 'app' ? 'App Order' : 'Web Order' }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-glaciar-gray-100">
                        <div class="flex items-start mb-3">
                            <svg class="w-4 h-4 mr-2 text-glaciar-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p class="text-sm text-glaciar-black">{{ $order->customer->email ?? '—' }}</p>
                        </div>
                        <div class="flex items-start mb-3">
                            <svg class="w-4 h-4 mr-2 text-glaciar-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <p class="text-sm text-glaciar-black">{{ $order->customer->phone ?? '—' }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-2">
                        <a href="{{ isset($order) ? route('admin.customers.show', $order->customer->id) : '#' }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">View Full Profile</a>
                    </div>
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-glaciar-black flex items-center">
                        <svg class="w-5 h-5 mr-2 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        Delivery
                    </h3>
                    <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-glaciar-gray-500 mb-1">Address</p>
                        <p class="text-sm text-glaciar-black font-medium">{{ $order->customer->address ?? '—' }}</p>
                    </div>
                    
                    <div class="pt-4 border-t border-glaciar-gray-100">
                        <p class="text-xs font-medium text-glaciar-gray-500 mb-2">Assignment</p>
                        @if(isset($order) && $order->delivery && $order->delivery->rep)
                            <div class="flex items-center p-2 rounded-md bg-glaciar-gray-50 border border-glaciar-gray-200">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs mr-2">
                                    {{ substr($order->delivery->rep->name ?? 'R', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-glaciar-black">{{ $order->delivery->rep->name ?? 'Rep' }}</p>
                                    <p class="text-xs text-glaciar-gray-500">{{ $order->delivery->rep->employee_id ?? '' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center p-3 rounded-md bg-amber-50 border border-amber-200 text-amber-800 text-sm">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Awaiting automatic assignment based on zone.
                            </div>
                            <button class="mt-2 w-full py-2 px-4 border border-glaciar-gray-300 rounded-md text-sm font-medium text-glaciar-black hover:bg-glaciar-gray-50 transition-colors">Assign Manually</button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-bold text-glaciar-gray-500 uppercase">Notes / Instructions</h3>
                </div>
                <p class="text-sm text-glaciar-black bg-glaciar-gray-50 p-3 rounded border border-glaciar-gray-100 italic">
                    "Please deliver to the rear entrance near loading bay B. Security will check."
                </p>
            </div>
            
        </div>
    </div>
@endsection
