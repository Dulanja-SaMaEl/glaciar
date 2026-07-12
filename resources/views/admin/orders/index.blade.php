@extends('layouts.admin')

@section('header', 'Orders Management')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-glaciar-black tracking-tight">All Orders</h2>
            <div class="h-1 w-12 bg-glaciar-accent mt-2 rounded-full"></div>
        </div>
        <div class="flex flex-wrap gap-2 p-1.5 bg-white rounded-xl shadow-soft border border-glaciar-gray-100/60">
            <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-glaciar-accent text-white shadow-md shadow-glaciar-accent/30 transition-all">All</button>
            <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black transition-all">Pending</button>
            <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black transition-all">Processing</button>
            <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black transition-all">Delivered</button>
        </div>
    </div>

    <x-admin.data-table :columns="['Order ID', 'Date', 'Customer', 'Zone', 'Total', 'Status', 'Actions']" :items="$orders ?? []">
        @forelse($orders ?? [] as $order)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black">{{ $order->customer->name ?? '—' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">—</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">LKR {{ number_format($order->total, 0) }}</td>
                <td class="px-6 py-4 whitespace-nowrap"><x-admin.status-badge :status="$order->status" /></td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">View Details</a>
                </td>
            </tr>
        @empty
            @foreach([
                ['id' => '1025', 'customer' => 'Sampath Bank HQ', 'zone' => 'Colombo 01-15', 'total' => 15500, 'status' => 'Pending'],
                ['id' => '1024', 'customer' => 'Nilantha Wijesinghe', 'zone' => 'Gampaha', 'total' => 2400, 'status' => 'Out For Delivery'],
                ['id' => '1023', 'customer' => 'Cafe Veda', 'zone' => 'Colombo Suburbs', 'total' => 8400, 'status' => 'Delivered'],
            ] as $o)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">#ORD-0{{ $o['id'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">Today, 10:25 AM</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black">{{ $o['customer'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $o['zone'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">LKR {{ number_format($o['total'], 0) }}</td>
                <td class="px-6 py-4 whitespace-nowrap"><x-admin.status-badge :status="$o['status']" /></td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="#" class="text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">View Details</a>
                </td>
            </tr>
            @endforeach
        @endforelse
    </x-admin.data-table>
@endsection
