@extends('layouts.admin')

@section('header', 'Payments')

@section('content')
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="p-6 border-b border-glaciar-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-glaciar-black">Recent Payments</h3>
            <div class="text-sm text-glaciar-gray-500">
                {{ method_exists($payments, 'total') ? $payments->total() : 0 }} total
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-glaciar-gray-100">
                <thead class="bg-[#FAFAFA]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-glaciar-gray-500 uppercase tracking-wider"></th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-glaciar-gray-100">
                @forelse($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">#{{ $payment->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                            {{ $payment->order_id ? '#ORD-' . str_pad($payment->order_id, 5, '0', STR_PAD_LEFT) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                            {{ $payment->order?->customer?->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $payment->method }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black">LKR {{ number_format((float) $payment->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-admin.status-badge :status="ucfirst($payment->status)" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            @if ($payment->status !== 'verified')
                                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded bg-glaciar-black text-white text-xs font-semibold hover:bg-[#111]">
                                        Verify
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-glaciar-gray-500">Verified</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-glaciar-gray-500">
                            No payments found yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($payments, 'links'))
            <div class="p-6 border-t border-glaciar-gray-100">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
@endsection

