@extends('layouts.customer')

@section('content')

<!-- Header Banner -->
<div class="bg-glaciar-obsidian text-white py-14 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-2">
            STAGE 01 / ORDER MANIFEST
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
            YOUR CART.
        </h1>
    </div>
</div>

<section class="py-16 bg-[#020617] text-white flex-grow min-h-[70vh] border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(count($cartItems ?? []) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Items Table / List (Columns 1-8) -->
                <div class="lg:col-span-8 bg-[#0b1226]/85 backdrop-blur-xl rounded-2xl border border-white/15 shadow-2xl overflow-hidden gl-section-header">
                    <div class="p-6 border-b border-white/10 flex items-center justify-between">
                        <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-400">ITEM SPECIFICATION</span>
                        <span class="text-xs font-mono font-bold uppercase tracking-wider text-slate-400">TOTAL</span>
                    </div>

                    <div class="divide-y divide-white/10">
                        @foreach($cartItems as $item)
                            @php
                                $p = $item->product;
                                $size = $p->size_ml >= 1000 ? ($p->size_ml / 1000) . 'L' : $p->size_ml . 'ml';
                                $img = $p->image_url ?? asset('images/products/' . ($p->size_ml ?? 500) . '.jpg');
                            @endphp
                            <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:bg-white/[0.02] transition-colors gl-reveal-item">
                                
                                <div class="flex items-center gap-5">
                                    <!-- Image Thumbnail -->
                                    <a href="{{ route('products.show', $p->id) }}" class="w-20 h-24 bg-white/5 rounded-xl border border-white/10 p-2 flex items-center justify-center flex-shrink-0 group overflow-hidden">
                                        <img src="{{ $img }}" alt="{{ $p->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform" />
                                    </a>

                                    <div>
                                        <span class="text-[10px] font-mono tracking-widest text-cyan-300 uppercase font-bold block mb-1">
                                            {{ strtoupper($size) }} SPEC
                                        </span>
                                        <h3 class="text-base font-bold text-white tracking-tight">
                                            <a href="{{ route('products.show', $p->id) }}" class="hover:text-cyan-300 transition-colors">
                                                {{ $p->name }}
                                            </a>
                                        </h3>
                                        <p class="text-xs font-mono text-slate-400 mt-1">
                                            LKR {{ number_format($p->price, 0) }} per unit
                                        </p>

                                        <!-- Mobile Item Total -->
                                        <div class="sm:hidden mt-2 font-bold font-mono text-sm text-cyan-300">
                                            LKR {{ number_format($p->price * $item->qty, 0) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions & Quantity Adjuster -->
                                <div class="flex items-center justify-between sm:justify-end gap-6 pt-3 sm:pt-0 border-t sm:border-t-0 border-white/10">
                                    
                                    <!-- Quantity Stepper -->
                                    <div class="inline-flex items-center bg-white/5 border border-white/15 rounded-lg overflow-hidden">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ $item->qty - 1 }}">
                                            <button type="submit" 
                                                    class="px-3 py-1.5 text-slate-400 hover:text-white hover:bg-white/10 transition-colors min-h-[38px] {{ $item->qty <= 1 ? 'opacity-40 cursor-not-allowed' : '' }}" 
                                                    @disabled($item->qty <= 1)
                                                    aria-label="Decrease quantity">
                                                −
                                            </button>
                                        </form>
                                        
                                        <span class="px-3 py-1 text-xs font-mono font-bold text-white min-w-[2.5rem] text-center">
                                            {{ $item->qty }}
                                        </span>

                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                            <button type="submit" 
                                                    class="px-3 py-1.5 text-slate-400 hover:text-white hover:bg-white/10 transition-colors min-h-[38px]"
                                                    aria-label="Increase quantity">
                                                +
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Desktop Item Total -->
                                    <div class="hidden sm:block text-right min-w-[6rem]">
                                        <span class="font-mono font-bold text-base text-cyan-300">
                                            LKR {{ number_format($p->price * $item->qty, 0) }}
                                        </span>
                                    </div>

                                    <!-- Delete Item -->
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-slate-400 hover:text-red-400 transition-colors rounded-lg hover:bg-red-500/10 min-h-[38px] min-w-[38px] flex items-center justify-center"
                                                title="Remove Item"
                                                aria-label="Remove {{ $p->name }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-white/[0.02] border-t border-white/10 flex items-center justify-between text-xs">
                        <a href="{{ route('products.index') }}" class="font-mono font-bold text-cyan-300 hover:text-white flex items-center gap-1.5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            <span>ADD MORE FORMATS</span>
                        </a>
                        <span class="font-mono text-slate-400 uppercase">COLD-CHAIN DISPATCH ACTIVE</span>
                    </div>
                </div>

                <!-- Order Summary (Columns 9-12) -->
                <div class="lg:col-span-4 sticky top-28 space-y-6 gl-reveal-item">
                    <div class="bg-[#0b1226]/85 backdrop-blur-xl rounded-2xl border border-white/15 shadow-2xl p-6 sm:p-8">
                        <h2 class="text-xs font-mono uppercase tracking-ultra font-bold text-white mb-6 pb-3 border-b border-white/10">
                            ORDER RECAP
                        </h2>

                        <div class="space-y-4 text-xs font-mono text-slate-300 pb-6 border-b border-white/10">
                            <div class="flex items-center justify-between">
                                <span>SUBTOTAL</span>
                                <span class="font-bold text-white">LKR {{ number_format($cartTotal ?? 0, 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>ZONE DISPATCH</span>
                                <span class="font-bold text-emerald-400">COMPLIMENTARY</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>VAT & PACKAGING</span>
                                <span class="font-bold text-slate-400">INCLUDED</span>
                            </div>
                        </div>

                        <div class="pt-4 flex items-baseline justify-between mb-8">
                            <span class="text-xs font-mono font-bold uppercase text-white tracking-wider">TOTAL DUE</span>
                            <span class="text-2xl font-black text-cyan-300 font-mono tracking-tight">
                                LKR {{ number_format($cartTotal ?? 0, 0) }}
                            </span>
                        </div>

                        <a href="{{ route('checkout.index') }}" 
                           class="gl-magnetic w-full py-4 px-6 bg-cyan-400 hover:bg-cyan-300 text-slate-950 text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300 shadow-[0_0_25px_rgba(56,189,248,0.4)] flex items-center justify-center gap-2 transform hover:-translate-y-0.5 min-h-[44px]">
                            <span>Proceed to Checkout</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        <div class="mt-6 pt-4 border-t border-white/10 space-y-2 text-[10px] text-slate-400 font-mono">
                            <div class="flex items-center gap-2">
                                <span class="text-cyan-400 font-bold">✓</span>
                                <span>Doorstep settlement upon allocation arrival</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-cyan-400 font-bold">✓</span>
                                <span>Sterile high-altitude glacial bottling guarantee</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <!-- Zero State (Empty Cart) -->
            <div class="max-w-xl mx-auto py-24 text-center bg-[#0b1226]/85 backdrop-blur-xl rounded-3xl border border-white/15 p-8 sm:p-12 shadow-2xl">
                <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-6 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-black tracking-tight text-white mb-2">
                    YOUR CART IS EMPTY.
                </h2>
                
                <p class="text-xs sm:text-sm text-slate-300 max-w-sm mx-auto mb-8 font-light leading-relaxed">
                    You haven't reserved any Glaciar vessels yet. Explore our collection to select your ideal hydration format.
                </p>
                
                <a href="{{ route('products.index') }}" 
                   class="gl-magnetic inline-flex items-center justify-center px-8 py-4 bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-[0_0_25px_rgba(56,189,248,0.5)] min-h-[44px]">
                    <span>Explore Collection</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        @endif

    </div>
</section>

@endsection
