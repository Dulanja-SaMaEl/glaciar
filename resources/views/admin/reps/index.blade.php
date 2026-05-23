@extends('layouts.admin')

@section('header', 'Sales Reps')

@section('content')
    <x-admin.page-header title="All Sales Representatives" buttonText="Register New Rep" buttonRoute="{{ route('admin.reps.create') }}" />

    <x-admin.data-table :columns="['ID', 'Name', 'Phone', 'Zone', 'Vehicle', 'Status', 'Actions']" :items="$reps ?? []" emptyMessage="No sales representatives found.">
        @forelse($reps ?? [] as $rep)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">#REP-{{ str_pad($rep->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            {{ substr($rep->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-glaciar-black">{{ $rep->name }}</div>
                            <div class="text-sm text-glaciar-gray-500">{{ $rep->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $rep->phone }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $rep->zone->name ?? 'Unassigned' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $rep->employee_id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-admin.status-badge :status="$rep->status ?? 'active'" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.reps.show', $rep->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                    <a href="{{ route('admin.reps.edit', $rep->id) }}" class="text-glaciar-gray-500 hover:text-glaciar-black">Edit</a>
                </td>
            </tr>
        @empty
            <!-- Demo placeholder data -->
            @foreach([
                ['id' => 1, 'name' => 'John Silva', 'email' => 'john.s@glaciar.com', 'phone' => '+94771234567', 'zone' => 'Colombo 01-15', 'vehicle' => 'WP LI-1234', 'status' => 'Active'],
                ['id' => 2, 'name' => 'Kamal Perera', 'email' => 'kamal.p@glaciar.com', 'phone' => '+94712345678', 'zone' => 'Colombo Suburbs', 'vehicle' => 'WP LI-5678', 'status' => 'Active'],
                ['id' => 3, 'name' => 'Sunil Fernando', 'email' => 'sunil.f@glaciar.com', 'phone' => '+94723456789', 'zone' => 'Gampaha', 'vehicle' => 'WP LI-9012', 'status' => 'On Leave'],
            ] as $r)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">#REP-00{{ $r['id'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                {{ substr($r['name'], 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-glaciar-black">{{ $r['name'] }}</div>
                                <div class="text-sm text-glaciar-gray-500">{{ $r['email'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $r['phone'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $r['zone'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $r['vehicle'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-admin.status-badge :status="$r['status']" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.reps.show', $r['id']) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <a href="{{ route('admin.reps.edit', $r['id']) }}" class="text-glaciar-gray-500 hover:text-glaciar-black">Edit</a>
                    </td>
                </tr>
            @endforeach
        @endforelse
    </x-admin.data-table>
@endsection
