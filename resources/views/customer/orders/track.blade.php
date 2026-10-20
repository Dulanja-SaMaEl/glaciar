@extends('layouts.customer')

@section('content')
<div class="bg-[#020617] text-white pt-28 pb-12 border-b border-white/10 relative overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient pointer-events-none opacity-40"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-400 font-bold block mb-2">
            TELEMETRY DISPATCH TRACKER
        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white font-mono">
            ORDER #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
        </h1>
    </div>
</div>

<section class="py-16 bg-[#020617] text-white flex-grow min-h-[65vh] border-b border-white/10 gl-section-reveal relative">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="bg-[#0b1226]/85 backdrop-blur-xl p-8 sm:p-12 rounded-3xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)] space-y-10 gl-reveal-item">
            
            <div class="flex items-center justify-between pb-6 border-b border-white/10">
                <div>
                    <span class="text-[10px] font-mono text-slate-400 uppercase tracking-widest block font-semibold">ORDER STATUS</span>
                    <span class="text-xl font-black text-cyan-300 uppercase font-mono mt-1 block">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-mono text-slate-400 uppercase tracking-widest block font-semibold">DESTINATION ZONE</span>
                    <span class="text-xs font-mono font-bold text-white block mt-1">
                        Active Delivery Route
                    </span>
                </div>
            </div>

            <!-- Progress Stepper -->
            <div class="relative py-4">
                <div class="absolute left-6 top-6 bottom-6 w-0.5 bg-white/10"></div>
                
                <div class="space-y-8 relative">
                    <!-- Step 1 -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-cyan-400/20 border border-cyan-400/40 text-cyan-300 flex items-center justify-center flex-shrink-0 z-10 font-mono font-bold text-sm shadow-[0_0_15px_rgba(56,189,248,0.25)]">
                            01
                        </div>
                        <div class="pt-1.5">
                            <h4 class="font-bold text-white text-sm font-mono">Order Manifest Confirmed</h4>
                            <p class="text-xs text-slate-400 font-light mt-0.5">Vessels reserved and sterile seal verified at the dispatch depot.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl {{ in_array(strtolower($order->status), ['processing', 'out_for_delivery', 'delivered', 'completed']) ? 'bg-cyan-400/20 border border-cyan-400/40 text-cyan-300 shadow-[0_0_15px_rgba(56,189,248,0.25)]' : 'bg-white/5 border border-white/10 text-slate-500' }} flex items-center justify-center flex-shrink-0 z-10 font-mono font-bold text-sm">
                            02
                        </div>
                        <div class="pt-1.5">
                            <h4 class="font-bold text-white text-sm font-mono">Packed & Assigned to Route</h4>
                            <p class="text-xs text-slate-400 font-light mt-0.5">Vessels placed in thermal logistics cargo for route assignment.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl {{ in_array(strtolower($order->status), ['out_for_delivery', 'delivered', 'completed']) ? 'bg-cyan-400/20 border border-cyan-400/40 text-cyan-300 shadow-[0_0_15px_rgba(56,189,248,0.25)]' : 'bg-white/5 border border-white/10 text-slate-500' }} flex items-center justify-center flex-shrink-0 z-10 font-mono font-bold text-sm">
                            03
                        </div>
                        <div class="pt-1.5">
                            <h4 class="font-bold text-white text-sm font-mono">Out for Delivery</h4>
                            <p class="text-xs text-slate-400 font-light mt-0.5">Glaciar zone representative is en route to your specified address.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl {{ in_array(strtolower($order->status), ['delivered', 'completed']) ? 'bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 shadow-[0_0_15px_rgba(16,185,129,0.25)]' : 'bg-white/5 border border-white/10 text-slate-500' }} flex items-center justify-center flex-shrink-0 z-10 font-mono font-bold text-sm">
                            04
                        </div>
                        <div class="pt-1.5">
                            <h4 class="font-bold text-white text-sm font-mono">Doorstep Delivery Completed</h4>
                            <p class="text-xs text-slate-400 font-light mt-0.5">Water received and closed-loop exchange processed.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/10 flex items-center justify-between">
                <a href="{{ route('account.orders') }}" class="text-xs font-mono font-bold text-slate-400 hover:text-white uppercase transition-colors min-h-[44px] flex items-center">
                    &larr; Return to Orders
                </a>
                <a href="{{ route('products.index') }}" class="text-xs font-mono font-bold text-cyan-400 hover:text-cyan-300 uppercase transition-colors min-h-[44px] flex items-center">
                    Shop More Formats &rarr;
                </a>
            </div>

        </div>

    </div>
</section>
@endsection
