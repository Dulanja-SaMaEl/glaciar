@extends('layouts.admin')

@section('header', 'Customer')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">← Back to customers</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-glaciar-gray-100 flex items-center justify-center font-bold text-glaciar-gray-600">
                        {{ substr($customer->name ?? 'C', 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <div class="text-lg font-bold text-glaciar-black">{{ $customer->name }}</div>
                        <div class="text-sm text-glaciar-gray-500">{{ $customer->email }}</div>
                    </div>
                </div>

                <div class="mt-5 space-y-2 text-sm">
                    <div><span class="text-glaciar-gray-500">Phone:</span> <span class="font-medium text-glaciar-black">{{ $customer->phone ?? '—' }}</span></div>
                    <div><span class="text-glaciar-gray-500">Source:</span> <span class="font-medium text-glaciar-black">{{ $customer->type === 'app' ? 'App' : 'Web' }}</span></div>
                    <div><span class="text-glaciar-gray-500">Business Type:</span> <span class="font-medium text-glaciar-black">{{ $customer->business_type ?? '—' }}</span></div>
                    <div><span class="text-glaciar-gray-500">Status:</span> <span class="font-medium text-glaciar-black">{{ $customer->status ?? 'active' }}</span></div>
                </div>

                <div class="mt-5 pt-5 border-t border-glaciar-gray-100 text-sm">
                    <div class="text-glaciar-gray-500 mb-1">Address</div>
                    <div class="text-glaciar-black">{{ $customer->address ?? '—' }}</div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-6 border-b border-glaciar-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-glaciar-black">Recent Orders</h3>
                    <div class="text-sm text-glaciar-gray-500">{{ $customer->orders->count() }} total</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-glaciar-gray-100">
                        <thead class="bg-[#FAFAFA]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-glaciar-gray-100">
                        @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">
                                    <a class="hover:text-blue-600" href="{{ route('admin.orders.show', $order->id) }}">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                                    {{ $order->created_at?->format('M d, Y') }}
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
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-glaciar-gray-500">No orders yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

