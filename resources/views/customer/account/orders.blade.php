@extends('customer.account.layout')

@section('account_content')
<div class="bg-[#0b1226]/85 backdrop-blur-xl rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden">
    <div class="p-6 border-b border-white/10 flex items-center justify-between">
        <h2 class="text-xs font-mono uppercase tracking-widest font-bold text-white">
            ORDER HISTORY MANIFEST
        </h2>
    </div>

    @if(isset($orders) && count($orders) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10 text-xs font-mono">
                <thead class="bg-white/[0.02] text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4 text-left">MANIFEST #</th>
                        <th class="px-6 py-4 text-left">TIMESTAMP</th>
                        <th class="px-6 py-4 text-left">STATUS</th>
                        <th class="px-6 py-4 text-left">TOTAL</th>
                        <th class="px-6 py-4 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach($orders as $order)
                        <tr class="hover:bg-white/[0.04] transition-colors">
                            <td class="px-6 py-4 font-bold text-white whitespace-nowrap">
                                #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 text-slate-400 whitespace-nowrap">
                                {{ $order->created_at->format('M d, Y · H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = strtolower($order->status);
                                    $badge = match ($status) {
                                        'delivered', 'completed' => 'bg-emerald-500/10 text-emerald-300 border-emerald-400/30',
                                        'pending', 'processing', 'out_for_delivery' => 'bg-cyan-500/10 text-cyan-300 border-cyan-400/30',
                                        default => 'bg-white/5 text-slate-300 border-white/15',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded border text-[10px] uppercase font-bold tracking-wider {{ $badge }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-cyan-300 whitespace-nowrap">
                                LKR {{ number_format($order->total, 0) }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('account.orders.show', $order->id) }}" class="text-xs font-bold text-cyan-400 hover:text-cyan-300 transition-colors underline min-h-[44px] inline-flex items-center">
                                    View Manifest
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="p-12 text-center font-mono">
            <p class="text-xs text-slate-400 uppercase tracking-widest mb-4">No dispatch records found in manifest ledger.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-wider min-h-[44px]">
                Browse The Boutique
            </a>
        </div>
    @endif
</div>
@endsection
