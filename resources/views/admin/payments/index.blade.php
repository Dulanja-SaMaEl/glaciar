@extends('layouts.admin')

@section('header', 'Payments & Settlements')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Financial Settlements</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">GATEWAY INGESTION & BANK DEPOSIT AUDITING</p>
        </div>

        @php
            $currentStatus = request('status', 'all');
        @endphp
        <div class="flex flex-wrap gap-1.5 p-1.5 bg-slate-100 dark:bg-white/5 rounded-xl border border-slate-200/80 dark:border-white/10 text-xs font-mono">
            <a href="{{ route('admin.payments.index', array_merge(request()->only('search'), ['status' => 'all'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'all' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                All ({{ $metrics['all_count'] ?? 0 }})
            </a>
            <a href="{{ route('admin.payments.index', array_merge(request()->only('search'), ['status' => 'verified'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'verified' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                Verified ({{ $metrics['verified_count'] ?? 0 }})
            </a>
            <a href="{{ route('admin.payments.index', array_merge(request()->only('search'), ['status' => 'pending'])) }}" 
               class="px-3.5 py-2 rounded-lg font-bold transition-all {{ $currentStatus === 'pending' ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                Pending ({{ $metrics['pending_count'] ?? 0 }})
            </a>
        </div>
    </div>

    <!-- Metrics Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold mb-1">Total Settled Volume</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white font-mono">LKR {{ number_format($metrics['total_volume'] ?? 0, 2) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08-.402 2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold mb-1">Verified Receipts</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 font-mono">{{ $metrics['verified_count'] ?? 0 }} Transactions</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold mb-1">Awaiting Verification</p>
                <p class="text-2xl font-black text-amber-500 font-mono">{{ $metrics['pending_count'] ?? 0 }} Items</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 p-4 mb-6">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-col sm:flex-row gap-3 items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="relative flex-1 w-full">
                <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by Payment ID, Order ID, Client, or Method..." 
                       class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.02] text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-cyan-400 font-sans transition-colors">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-cyan-400 hover:bg-slate-800 dark:hover:bg-cyan-300 text-white dark:text-slate-950 text-xs font-mono font-bold uppercase tracking-wider transition-colors w-full sm:w-auto text-center">
                    Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.payments.index') }}" 
                       class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 text-xs font-mono font-bold text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-white/10">
                <thead class="bg-slate-50/80 dark:bg-white/[0.02]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Ref ID</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Target Order</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Client Account</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Settled Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Audit Status</th>
                        <th class="px-6 py-4 text-right text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-cyan-600 dark:text-cyan-400">
                                #PAY-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-slate-500 dark:text-slate-400">
                                @if($payment->order_id)
                                    <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="hover:underline font-bold text-slate-700 dark:text-slate-300">
                                        #ORD-{{ str_pad($payment->order_id, 5, '0', STR_PAD_LEFT) }}
                                    </a>
                                @else
                                    <span>Direct Deposit</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $payment->order?->customer?->name ?? 'Walk-in Client' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-mono font-semibold uppercase text-slate-600 dark:text-slate-300">
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 dark:bg-white/5 border border-slate-200/60 dark:border-white/10">
                                    {{ $payment->method }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-900 dark:text-white">
                                LKR {{ number_format((float) $payment->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-admin.status-badge :status="ucfirst($payment->status)" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if ($payment->status !== 'verified')
                                    <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                                        @csrf
                                        <button class="px-3.5 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-mono text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                                            Verify Receipt
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-mono text-emerald-600 dark:text-emerald-400 font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Audited
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">No Payment Records Found</h4>
                                <p class="text-xs text-slate-400 font-mono mt-1">Try clearing your filters or search keyword.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="p-6 border-t border-slate-100 dark:border-white/10">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
@endsection
