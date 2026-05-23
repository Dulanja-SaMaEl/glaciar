@extends('layouts.admin')

@section('header', 'Customers')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-glaciar-black">All Customers</h2>
        <div class="flex bg-glaciar-gray-100 rounded-lg p-1">
            <a href="{{ route('admin.customers.index') }}"
               class="px-4 py-1.5 rounded-md text-sm font-medium {{ !request('type') && !request('status') ? 'bg-white text-glaciar-black shadow-sm' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} transition-colors">All</a>
            <a href="{{ route('admin.customers.index', ['type' => 'web'] + request()->except('type', 'page')) }}"
               class="px-4 py-1.5 rounded-md text-sm font-medium {{ request('type') === 'web' ? 'bg-white text-glaciar-black shadow-sm' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} transition-colors">Web</a>
            <a href="{{ route('admin.customers.index', ['type' => 'app'] + request()->except('type', 'page')) }}"
               class="px-4 py-1.5 rounded-md text-sm font-medium {{ request('type') === 'app' ? 'bg-white text-glaciar-black shadow-sm' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} transition-colors">App</a>
            <a href="{{ route('admin.customers.index', ['status' => 'inactive'] + request()->except('status', 'page')) }}"
               class="px-4 py-1.5 rounded-md text-sm font-medium {{ request('status') === 'inactive' ? 'bg-white text-glaciar-black shadow-sm' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} transition-colors">Inactive</a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Metrics --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <p class="text-sm font-medium text-glaciar-gray-500">Total Customers</p>
            <p class="text-3xl font-bold text-glaciar-black mt-1">{{ number_format($totalCustomers) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <p class="text-sm font-medium text-glaciar-gray-500">Active Customers</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ number_format($activeCustomers) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <p class="text-sm font-medium text-glaciar-gray-500">Business Customers</p>
            <p class="text-3xl font-bold text-glaciar-black mt-1">{{ number_format($businessCustomers) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <p class="text-sm font-medium text-glaciar-gray-500">Active Subscriptions</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($activeSubscriptions) }}</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="mb-6">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            {{-- Preserve existing filters --}}
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name, email, phone, or business type..."
                       class="w-full pl-10 pr-4 py-2.5 border border-glaciar-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-glaciar-black text-white rounded-lg text-sm font-medium hover:bg-glaciar-gray-900 transition-colors">
                Search
            </button>
            @if(request('search') || request('type') || request('status'))
                <a href="{{ route('admin.customers.index') }}" class="px-6 py-2.5 bg-glaciar-gray-100 text-glaciar-gray-600 rounded-lg text-sm font-medium hover:bg-glaciar-gray-200 transition-colors text-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Customer Table --}}
    <x-admin.data-table :columns="['Customer', 'Type', 'Contact', 'Orders', 'Total Spent', 'Status', 'Joined', 'Actions']" :items="$customers">
        @forelse($customers as $customer)
            <tr class="hover:bg-glaciar-gray-50/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0
                            {{ $customer->status === 'active' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-glaciar-gray-100 text-glaciar-gray-500' }}">
                            {{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-sm font-bold text-glaciar-black hover:text-blue-600 transition-colors">
                                {{ $customer->name }}
                            </a>
                            <div class="text-xs text-glaciar-gray-500">{{ $customer->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold
                        {{ $customer->type === 'app' ? 'bg-purple-100 text-purple-700' : 'bg-sky-100 text-sky-700' }}">
                        {{ ucfirst($customer->type ?? 'web') }}
                    </span>
                    @if($customer->business_type)
                        <div class="text-[10px] text-glaciar-gray-500 mt-0.5 uppercase tracking-wider">{{ $customer->business_type }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                    {{ $customer->phone ?? '—' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ $customer->orders_count }}">
                    {{ $customer->orders_count }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ $customer->orders_sum_total ?? 0 }}">
                    LKR {{ number_format((float) ($customer->orders_sum_total ?? 0), 0) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-admin.status-badge :status="$customer->status ?? 'active'" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">
                    {{ $customer->created_at?->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="text-glaciar-gray-500 hover:text-glaciar-black transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Change status to {{ $customer->status === 'active' ? 'inactive' : 'active' }}?')">
                            @csrf
                            <button type="submit" class="{{ $customer->status === 'active' ? 'text-amber-500 hover:text-amber-700' : 'text-green-500 hover:text-green-700' }} transition-colors" title="{{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                @if($customer->status === 'active')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-glaciar-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-sm text-glaciar-gray-500 font-medium">No customers found.</p>
                        @if(request('search'))
                            <p class="text-xs text-glaciar-gray-400 mt-1">Try adjusting your search query.</p>
                        @endif
                    </div>
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>

    {{-- Pagination Info --}}
    @if($customers->hasPages())
        <div class="mt-4 text-sm text-glaciar-gray-500 text-center">
            Showing {{ $customers->firstItem() }} – {{ $customers->lastItem() }} of {{ $customers->total() }} customers
        </div>
    @endif
@endsection
