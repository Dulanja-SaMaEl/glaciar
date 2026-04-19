@extends('customer.account.layout')

@section('account_content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-glaciar-black">Order History</h2>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        @if(isset($orders) && count($orders) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-glaciar-gray-100">
                    <thead class="bg-glaciar-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Order</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-glaciar-gray-100 bg-white">
                        @foreach($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">
                                    #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $classes = match (strtolower($order->status)) {
                                            'delivered', 'completed' => 'bg-green-100 text-green-800',
                                            'pending', 'processing', 'out_for_delivery' => 'bg-amber-100 text-amber-800',
                                            'cancelled', 'failed' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black font-medium">
                                    LKR {{ number_format($order->total, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('account.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="px-6 py-3 border-t border-glaciar-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <!-- Empty State / Dummy Data for Demo -->
            <div class="text-center py-16 px-4">
                <div class="w-16 h-16 mx-auto bg-glaciar-gray-50 rounded-full flex items-center justify-center mb-4 border border-glaciar-gray-100">
                    <svg class="w-8 h-8 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-glaciar-black mb-2">No orders yet</h3>
                <p class="text-glaciar-gray-500 max-w-sm mx-auto mb-6">You haven't placed any orders with Glaciar Water yet.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-glaciar-black hover:bg-glaciar-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black">
                    Start Shopping
                </a>
            </div>
            
            <!-- Dummy Data Preview -->
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-8 mt-4 text-center">
                <p class="text-xs text-gray-400 mb-4">(Demo View When Populated)</p>
                <div class="bg-white rounded border border-gray-200 shadow-sm opacity-50 grayscale pointer-events-none text-left">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-00123</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oct 12, 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">LKR 1,500</td>
                            </tr>
                             <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-00098</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oct 05, 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">LKR 750</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
