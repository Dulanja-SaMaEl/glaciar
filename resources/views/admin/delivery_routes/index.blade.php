@extends('layouts.admin')

@section('header', 'Delivery Routes')

@section('content')
    <x-admin.page-header title="All Delivery Routes" buttonText="Create New Route" buttonRoute="{{ route('admin.delivery-routes.create') }}" />

    <x-admin.data-table :columns="['ID', 'Name', 'Description', 'Assigned Customers', 'Assigned Reps', 'Actions']" :items="$routes" emptyMessage="No delivery routes found.">
        @foreach($routes as $route)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">#RT-{{ str_pad($route->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">
                    {{ $route->name }}
                </td>
                <td class="px-6 py-4 text-sm text-glaciar-gray-500 max-w-xs truncate">
                    {{ $route->description ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">
                    {{ $route->customers_count }} Customers
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">
                    {{ $route->reps_count }} Reps
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.delivery-routes.show', $route->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Manage</a>
                    <a href="{{ route('admin.delivery-routes.edit', $route->id) }}" class="text-glaciar-gray-500 hover:text-glaciar-black">Edit</a>
                </td>
            </tr>
        @endforeach
    </x-admin.data-table>
@endsection
