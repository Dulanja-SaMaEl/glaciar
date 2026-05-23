@extends('layouts.admin')

@section('header', 'Customer Details')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Customers
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="px-4 py-2 bg-glaciar-black text-white text-sm font-medium rounded-lg hover:bg-glaciar-gray-900 transition-colors">
                Edit Customer
            </a>
            <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Change status to {{ $customer->status === 'active' ? 'inactive' : 'active' }}?')">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg border transition-colors
                    {{ $customer->status === 'active' ? 'border-amber-300 text-amber-700 hover:bg-amber-50' : 'border-green-300 text-green-700 hover:bg-green-50' }}">
                    {{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Customer Profile --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Profile Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mb-4
                        {{ $customer->status === 'active' ? 'bg-blue-50 text-blue-600 border-2 border-blue-100' : 'bg-glaciar-gray-100 text-glaciar-gray-500 border-2 border-glaciar-gray-200' }}">
                        {{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-glaciar-black">{{ $customer->name }}</h2>
                    <p class="text-sm text-glaciar-gray-500 mt-1">{{ $customer->email }}</p>
                    <div class="mt-3">
                        <x-admin.status-badge :status="$customer->status ?? 'active'" />
                    </div>
                </div>

                <div class="mt-6 space-y-3 text-sm border-t border-glaciar-gray-100 pt-6">
                    <div class="flex justify-between">
                        <span class="text-glaciar-gray-500">Phone</span>
                        <span class="font-medium text-glaciar-black">{{ $customer->phone ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-glaciar-gray-500">Source</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold
                            {{ $customer->type === 'app' ? 'bg-purple-100 text-purple-700' : 'bg-sky-100 text-sky-700' }}">
                            {{ ucfirst($customer->type ?? 'web') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-glaciar-gray-500">Business Type</span>
                        <span class="font-medium text-glaciar-black">{{ $customer->business_type ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-glaciar-gray-500">Customer Since</span>
                        <span class="font-medium text-glaciar-black">{{ $customer->created_at?->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-glaciar-gray-100 text-sm">
                    <p class="text-glaciar-gray-500 mb-2 font-medium">Address</p>
                    <p class="text-glaciar-black leading-relaxed">{{ $customer->address ?? '—' }}</p>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4 text-center">
                    <p class="text-2xl font-bold text-glaciar-black">{{ $orderCount }}</p>
                    <p class="text-xs text-glaciar-gray-500 mt-1">Orders</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4 text-center">
                    <p class="text-lg font-bold text-glaciar-black">{{ number_format((float) $totalSpent, 0) }}</p>
                    <p class="text-xs text-glaciar-gray-500 mt-1">LKR Spent</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $activeSubscriptions }}</p>
                    <p class="text-xs text-glaciar-gray-500 mt-1">Active Subs</p>
                </div>
            </div>

            {{-- Delivery Routes --}}
            @if($customer->deliveryRoutes && $customer->deliveryRoutes->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                    <h3 class="text-sm font-bold text-glaciar-black mb-4">Assigned Routes</h3>
                    <div class="space-y-2">
                        @foreach($customer->deliveryRoutes as $route)
                            <a href="{{ route('admin.delivery-routes.show', $route) }}" class="flex items-center justify-between p-3 rounded-lg bg-glaciar-gray-50 hover:bg-glaciar-gray-100 transition-colors group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                    <span class="text-sm font-medium text-glaciar-black">{{ $route->name }}</span>
                                </div>
                                <svg class="w-4 h-4 text-glaciar-gray-400 group-hover:text-glaciar-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column: Orders & Subscriptions --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Recent Orders --}}
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-6 border-b border-glaciar-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-glaciar-black">Recent Orders</h3>
                    <span class="text-sm text-glaciar-gray-500 bg-glaciar-gray-100 px-3 py-1 rounded-full font-medium">{{ $orderCount }} total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-glaciar-gray-100">
                        <thead class="bg-[#FAFAFA]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-glaciar-gray-100">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-glaciar-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">
                                    <a class="hover:text-blue-600 transition-colors" href="{{ route('admin.orders.show', $order->id) }}">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                                    {{ $order->created_at?->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                                    {{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black">
                                    LKR {{ number_format((float) $order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-admin.status-badge :status="$order->status" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-glaciar-gray-500">No orders yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Subscriptions --}}
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-6 border-b border-glaciar-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-glaciar-black">Subscriptions</h3>
                    <span class="text-sm text-glaciar-gray-500 bg-glaciar-gray-100 px-3 py-1 rounded-full font-medium">{{ $customer->subscriptions->count() }} total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-glaciar-gray-100">
                        <thead class="bg-[#FAFAFA]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Frequency</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Next Delivery</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-glaciar-gray-100">
                        @forelse($customer->subscriptions as $sub)
                            <tr class="hover:bg-glaciar-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">
                                    {{ $sub->product->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                                    {{ $sub->qty }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                                    {{ ucfirst($sub->frequency ?? '—') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                                    {{ $sub->next_delivery?->format('M d, Y') ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-admin.status-badge :status="$sub->status ?? 'active'" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-glaciar-gray-500">No subscriptions yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Complaints --}}
            @if($customer->complaints && $customer->complaints->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-glaciar-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-glaciar-black">Complaints</h3>
                        <span class="text-sm text-glaciar-gray-500 bg-glaciar-gray-100 px-3 py-1 rounded-full font-medium">{{ $customer->complaints->count() }}</span>
                    </div>

                    <div class="divide-y divide-glaciar-gray-100">
                        @foreach($customer->complaints as $complaint)
                            <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="flex items-center justify-between p-4 hover:bg-glaciar-gray-50/50 transition-colors">
                                <div>
                                    <p class="text-sm font-medium text-glaciar-black">{{ $complaint->subject ?? 'Complaint #' . $complaint->id }}</p>
                                    <p class="text-xs text-glaciar-gray-500 mt-1">{{ $complaint->created_at?->format('M d, Y') }}</p>
                                </div>
                                <x-admin.status-badge :status="$complaint->status ?? 'pending'" />
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
