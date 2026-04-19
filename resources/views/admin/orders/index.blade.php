@extends('layouts.admin')

@section('header', 'Orders Management')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-glaciar-black">All Orders</h2>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 rounded-full text-sm font-medium bg-glaciar-black text-white">All</button>
            <button class="px-3 py-1.5 rounded-full text-sm font-medium bg-glaciar-gray-100 text-glaciar-gray-600">Pending</button>
            <button class="px-3 py-1.5 rounded-full text-sm font-medium bg-glaciar-gray-100 text-glaciar-gray-600">Processing</button>
            <button class="px-3 py-1.5 rounded-full text-sm font-medium bg-glaciar-gray-100 text-glaciar-gray-600">Delivered</button>
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
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
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
                    <a href="#" class="text-blue-600 hover:text-blue-900">View</a>
                </td>
            </tr>
            @endforeach
        @endforelse
    </x-admin.data-table>
@endsection
