@extends('layouts.admin')

@section('header', 'Customers')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-glaciar-black">All Customers</h2>
        <div class="flex bg-glaciar-gray-100 rounded-lg p-1">
            <button class="px-4 py-1.5 rounded-md text-sm font-medium bg-white text-glaciar-black shadow-sm">All</button>
            <button class="px-4 py-1.5 rounded-md text-sm font-medium text-glaciar-gray-500">Web</button>
            <button class="px-4 py-1.5 rounded-md text-sm font-medium text-glaciar-gray-500">App</button>
        </div>
    </div>

    <!-- Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <p class="text-sm font-medium text-glaciar-gray-500">Total Customers</p>
            <p class="text-3xl font-bold text-glaciar-black">1,420</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <p class="text-sm font-medium text-glaciar-gray-500">Business Customers</p>
            <p class="text-3xl font-bold text-glaciar-black">342</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <p class="text-sm font-medium text-glaciar-gray-500">Active Subscriptions</p>
            <p class="text-3xl font-bold text-glaciar-black">890</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="p-4 border-b border-glaciar-gray-100">
            <h3 class="text-lg font-bold text-glaciar-black">Customer List</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-glaciar-gray-100">
                <thead class="bg-glaciar-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-glaciar-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-glaciar-gray-100">
                    @foreach([
                        ['name' => 'John Doe', 'type' => 'Web', 'phone' => '+94 77 123 4567', 'joined' => 'Oct 12, 2023'],
                        ['name' => 'Jane Smith', 'type' => 'App', 'phone' => '+94 71 987 6543', 'joined' => 'Nov 05, 2023'],
                        ['name' => 'Sampath Bank HQ', 'type' => 'Corporate', 'phone' => '+94 11 234 5678', 'joined' => 'Dec 01, 2023'],
                    ] as $c)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $c['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $c['type'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $c['phone'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $c['joined'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900">View Account</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
