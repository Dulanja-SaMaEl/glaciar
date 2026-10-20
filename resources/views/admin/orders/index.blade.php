@extends('layouts.admin')

@section('header', 'Orders Management')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Client Orders Hub</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">DISPATCH TELEMETRY & COLD-CHAIN ALLOCATIONS</p>
        </div>

        <!-- Working Filter Tabs -->
        @php
            $currentStatus = request('status', 'all');
        @endphp
        <div class="flex flex-wrap gap-1.5 p-1.5 bg-slate-100 dark:bg-white/5 rounded-xl border border-slate-200/80 dark:border-white/10 text-xs font-mono">
            <a href="{{ route('admin.orders.index', array_merge(request()->only('search'), ['status' => 'all'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'all' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                All ({{ $statusCounts['all'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', array_merge(request()->only('search'), ['status' => 'pending'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'pending' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                Pending ({{ $statusCounts['pending'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', array_merge(request()->only('search'), ['status' => 'in_progress'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'in_progress' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                In Progress ({{ $statusCounts['in_progress'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', array_merge(request()->only('search'), ['status' => 'delivered'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'delivered' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                Delivered ({{ $statusCounts['delivered'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', array_merge(request()->only('search'), ['status' => 'cancelled'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'cancelled' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                Cancelled ({{ $statusCounts['cancelled'] ?? 0 }})
            </a>
        </div>
    </div>

    <!-- Search & Command Filter Bar -->
    <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 p-4 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row gap-3 items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="relative flex-1 w-full">
                <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by Order ID (e.g. 94), Client Name, or Email..." 
                       class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-cyan-400 font-sans transition-colors">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-cyan-400 hover:bg-slate-800 dark:hover:bg-cyan-300 text-white dark:text-slate-950 text-xs font-mono font-bold uppercase tracking-wider transition-colors w-full sm:w-auto text-center">
                    Filter Orders
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 text-xs font-mono font-bold text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Data Table -->
    <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-white/10">
                <thead class="bg-slate-50/80 dark:bg-white/[0.02]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Client & Account</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Zone / Logistics</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Gross Total</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($orders as $order)
                        @php
                            $zoneName = $order->customer?->deliveryRoutes?->first()?->name 
                                ?? $order->customer?->address 
                                ?? 'Sub-Zero Courier';
                        @endphp
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-cyan-600 dark:text-cyan-400">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline">
                                    #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400 font-mono">
                                {{ $order->created_at->format('M d, Y · H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $order->customer->name ?? 'Direct Client' }}</div>
                                <div class="text-[11px] font-mono text-slate-400 truncate max-w-[180px]">{{ $order->customer->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-slate-500 dark:text-slate-400">
                                <span class="max-w-[180px] truncate inline-block align-middle px-2.5 py-1 rounded-md bg-slate-100 dark:bg-white/5 border border-slate-200/60 dark:border-white/10" title="{{ $zoneName }}">
                                    {{ $zoneName }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-900 dark:text-white">
                                LKR {{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-admin.status-badge :status="$order->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-white/10 hover:bg-cyan-400 hover:text-slate-950 text-slate-700 dark:text-slate-300 text-xs font-mono font-bold uppercase tracking-wider transition-colors">
                                        Inspect
                                    </a>
                                    <a href="{{ route('admin.orders.invoice', $order->id) }}" 
                                       title="Download Invoice PDF"
                                       class="p-1.5 rounded-lg border border-slate-200 dark:border-white/10 text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">No Matching Orders Found</h4>
                                <p class="text-xs text-slate-400 font-mono mt-1">Try adjusting your status filter or search parameters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-6 border-t border-slate-100 dark:border-white/10">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
