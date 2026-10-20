@extends('customer.account.layout')

@section('account_content')
<div class="space-y-6">
    
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('account.orders') }}" class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-slate-400 hover:text-white transition-colors uppercase min-h-[44px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to Orders</span>
        </a>

        @if(isset($order) && $order->invoice)
            <a href="{{ route('account.orders.invoice', $order->id) }}" target="_blank" class="px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-mono font-bold uppercase rounded-lg border border-white/15 transition-colors flex items-center gap-1.5 min-h-[44px]">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Invoice PDF</span>
            </a>
        @endif
    </div>

    <!-- Order Manifest Card -->
    <div class="bg-[#0b1226]/85 backdrop-blur-xl rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden">
        <div class="p-6 border-b border-white/10 flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block mb-1">MANIFEST ID</span>
                <h2 class="text-xl font-black text-white font-mono">
                    #ORD-{{ str_pad($order->id ?? 1, 5, '0', STR_PAD_LEFT) }}
                </h2>
                <span class="text-xs text-slate-400 font-mono">
                    Placed {{ $order->created_at->format('F d, Y \a\t H:i') }}
                </span>
            </div>

            <div>
                @php
                    $status = strtolower($order->status ?? 'pending');
                    $badge = match ($status) {
                        'delivered', 'completed' => 'bg-emerald-500/10 text-emerald-300 border-emerald-400/30',
                        'pending', 'processing', 'out_for_delivery' => 'bg-cyan-500/10 text-cyan-300 border-cyan-400/30',
                        default => 'bg-white/5 text-slate-300 border-white/15',
                    };
                @endphp
                <span class="px-3 py-1.5 rounded-lg border text-xs font-mono font-bold uppercase tracking-wider {{ $badge }}">
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </span>
            </div>
        </div>

        <!-- Items Table -->
        <div class="p-6">
            <h3 class="text-xs font-mono uppercase tracking-widest font-bold text-slate-400 mb-4">
                ITEMS DISPATCHED
            </h3>

            <div class="divide-y divide-white/10">
                @foreach($order->items ?? [] as $item)
                    @php
                        $p = $item->product;
                        $size = $p ? ($p->size_ml >= 1000 ? ($p->size_ml / 1000) . 'L' : $p->size_ml . 'ml') : 'Format';
                        $img = $p->image_url ?? asset('images/products/' . ($p->size_ml ?? 500) . '.jpg');
                    @endphp
                    <div class="py-4 flex items-center justify-between gap-4 text-xs font-mono">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-14 bg-white/5 rounded-lg border border-white/10 p-1 flex-shrink-0 flex items-center justify-center">
                                <img src="{{ $img }}" alt="{{ $p->name ?? 'Product' }}" class="w-full h-full object-contain" />
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm">{{ $p->name ?? 'Glaciar Vessel' }}</p>
                                <p class="text-slate-400 text-xs">Qty: {{ $item->quantity ?? $item->qty }} · {{ $size }}</p>
                            </div>
                        </div>
                        <span class="font-bold text-cyan-300 whitespace-nowrap">
                            LKR {{ number_format($item->price * ($item->quantity ?? $item->qty), 0) }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Financial Recap -->
            <div class="mt-8 pt-6 border-t border-white/10 space-y-3 font-mono text-xs">
                <div class="flex items-center justify-between text-slate-400">
                    <span>SUBTOTAL</span>
                    <span class="text-white font-bold">LKR {{ number_format($order->subtotal ?? $order->total, 0) }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-400">
                    <span>COLD-CHAIN DISPATCH</span>
                    <span class="text-cyan-400 font-bold">COMPLIMENTARY</span>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-white/10 text-sm">
                    <span class="font-bold text-white uppercase tracking-wider">TOTAL PAID</span>
                    <span class="text-xl font-black text-cyan-300">
                        LKR {{ number_format($order->total, 0) }}
                    </span>
                </div>
            </div>

            <!-- Delivery Telemetry -->
            <div class="mt-8 pt-6 border-t border-white/10 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                <div class="p-4 rounded-xl bg-white/[0.02] border border-white/10">
                    <span class="text-slate-400 block text-[10px] uppercase mb-1">DISPATCH COORDINATES</span>
                    <p class="text-white font-medium">{{ $order->address }}</p>
                    <p class="text-slate-400 text-[11px] mt-0.5">Zone: {{ $order->zone->name ?? 'Designated Sector' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-white/[0.02] border border-white/10">
                    <span class="text-slate-400 block text-[10px] uppercase mb-1">SETTLEMENT METHOD</span>
                    <p class="text-white font-medium uppercase">{{ str_replace('_', ' ', $order->payment_method ?? 'Cash on Delivery') }}</p>
                    <p class="text-slate-400 text-[11px] mt-0.5">Status: {{ ucfirst($order->payment_status ?? 'Pending') }}</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between">
                <a href="{{ route('orders.track', $order->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-cyan-400 text-slate-950 font-bold text-xs font-mono uppercase tracking-wider hover:bg-cyan-300 transition-colors min-h-[44px]">
                    <span>Open Live Telemetry Tracker</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
