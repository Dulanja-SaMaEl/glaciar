@extends('layouts.admin')
@section('header', 'Purchases & Stock In')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-glaciar-black">Purchases (Stock In)</h2>
        <p class="text-sm text-gray-500 mt-1">Manage supplier purchase orders and receive new inventory.</p>
    </div>
    <a href="{{ route('admin.inventory.purchases.create') }}" class="px-4 py-2 bg-glaciar-black text-white font-bold rounded-lg text-sm hover:bg-gray-900 transition-colors shadow-sm">
        + Create Purchase Order
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">PO # / Invoice</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Total Cost</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-glaciar-black">PO-{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-xs text-gray-500 mt-1">INV: {{ $purchase->invoice_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $purchase->supplier->company_name ?? 'Unknown Supplier' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $purchase->purchase_date->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-glaciar-black">
                            LKR {{ number_format($purchase->total_cost, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($purchase->status === 'completed')
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold uppercase">Received</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold uppercase">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.inventory.purchases.show', $purchase->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">View / Receive</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No purchases found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($purchases->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $purchases->links() }}
        </div>
    @endif
</div>
@endsection
