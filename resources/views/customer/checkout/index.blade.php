@extends('layouts.customer')

@section('content')

<!-- Header Banner -->
<div class="bg-[#020617] text-white pt-28 pb-12 border-b border-white/10 relative overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient pointer-events-none opacity-40"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-400 font-bold block mb-2">
            STAGE 02 / SECURE CHECKOUT
        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white font-mono">
            DISPATCH MANIFEST.
        </h1>
    </div>
</div>

<section class="py-16 bg-[#020617] text-white flex-grow min-h-[70vh] border-b border-white/10 gl-section-reveal relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Form Inputs (Columns 1-7) -->
                <div class="lg:col-span-7 space-y-8 gl-reveal-item">
                    
                    @if(!Auth::check())
                        <!-- Guest Notice Card -->
                        <div class="p-5 rounded-2xl bg-[#0b1226]/85 backdrop-blur-xl border border-white/15 shadow-[0_10px_30px_rgba(0,0,0,0.4)] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-white font-mono">Existing Customer?</p>
                                <p class="text-xs text-slate-400 font-light mt-0.5">Sign in to sync your saved zone schedule and view past orders.</p>
                            </div>
                            <a href="{{ route('login') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white text-xs font-mono font-bold uppercase rounded-lg border border-white/20 transition-all text-center min-h-[44px] flex items-center justify-center">
                                Sign In
                            </a>
                        </div>
                    @endif

                    <!-- Step 1: Contact Information -->
                    <div class="bg-[#0b1226]/85 backdrop-blur-xl p-6 sm:p-8 rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                        <div class="flex items-center gap-3 mb-6 pb-3 border-b border-white/10">
                            <span class="w-6 h-6 rounded-full bg-cyan-400/20 text-cyan-300 border border-cyan-400/40 text-xs font-mono font-bold flex items-center justify-center">1</span>
                            <h2 class="text-xs font-mono uppercase tracking-widest font-bold text-white">Contact Details</h2>
                        </div>

                        @if(Auth::check())
                            <div class="flex items-center gap-4 p-4 rounded-xl bg-white/[0.04] border border-white/10 mb-6">
                                <div class="w-10 h-10 rounded-full bg-cyan-400/20 border border-cyan-400/30 text-cyan-300 flex items-center justify-center font-bold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-400 font-mono truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <span class="text-[10px] font-mono text-cyan-300 bg-cyan-950/60 px-2 py-1 rounded border border-cyan-400/30">
                                    AUTHENTICATED
                                </span>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="name" class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1.5 font-semibold">Full Name *</label>
                                    <input type="text" name="name" id="name" required value="{{ old('name') }}" 
                                           class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3 text-xs focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 text-white placeholder-slate-500 font-mono min-h-[44px]" placeholder="E.g. James Nonis">
                                    @error('name') <p class="text-rose-400 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1.5 font-semibold">Email Address *</label>
                                    <input type="email" name="email" id="email" required value="{{ old('email') }}" 
                                           class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3 text-xs focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 text-white placeholder-slate-500 font-mono min-h-[44px]" placeholder="E.g. james@example.com">
                                    @error('email') <p class="text-rose-400 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        @endif

                        <div>
                            <label for="phone" class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1.5 font-semibold">Direct Phone Number *</label>
                            <input type="tel" name="phone" id="phone" required value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                                   class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3 text-xs focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 text-white placeholder-slate-500 font-mono min-h-[44px]" placeholder="E.g. +94 77 123 4567">
                            @error('phone') <p class="text-rose-400 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Step 2: Delivery Destination -->
                    <div class="bg-[#0b1226]/85 backdrop-blur-xl p-6 sm:p-8 rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                        <div class="flex items-center gap-3 mb-6 pb-3 border-b border-white/10">
                            <span class="w-6 h-6 rounded-full bg-cyan-400/20 text-cyan-300 border border-cyan-400/40 text-xs font-mono font-bold flex items-center justify-center">2</span>
                            <h2 class="text-xs font-mono uppercase tracking-widest font-bold text-white">Delivery Location</h2>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="address" class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1.5 font-semibold">Street / Suite / Building Address *</label>
                                <input type="text" name="address" id="address" required value="{{ old('address', Auth::user()->address ?? '') }}" 
                                       class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3 text-xs focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 text-white placeholder-slate-500 font-mono min-h-[44px]" placeholder="E.g. No. 42, Barnes Place, Cinnamon Gardens">
                                @error('address') <p class="text-rose-400 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="zone_id" class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1.5 font-semibold">Delivery Zone *</label>
                                <select id="zone_id" name="zone_id" required 
                                        class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3 text-xs focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 text-white font-mono min-h-[44px]">
                                    <option value="" disabled {{ !old('zone_id') ? 'selected' : '' }} class="bg-slate-900 text-slate-400">Select your designated city / zone...</option>
                                    @foreach($zones ?? [] as $zone)
                                        <option value="{{ $zone->id }}" {{ old('zone_id', Auth::user()->zone_id ?? '') == $zone->id ? 'selected' : '' }} class="bg-slate-900 text-white">
                                            {{ $zone->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('zone_id') <p class="text-rose-400 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Optional Recurring Schedule -->
                    <div class="bg-[#0b1226]/85 backdrop-blur-xl p-6 sm:p-8 rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)]" x-data="{ isSubscription: false }">
                        <div class="flex items-center justify-between mb-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_subscription" value="1" x-model="isSubscription" class="w-4 h-4 rounded text-cyan-400 focus:ring-cyan-400 border-white/20 bg-slate-900">
                                <div>
                                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-white block">Automate Recurring Delivery</span>
                                    <span class="text-[11px] text-slate-400 font-light block">Get automatic weekly replenishment without manual reordering.</span>
                                </div>
                            </label>
                            <span class="text-[10px] font-mono text-cyan-300 bg-cyan-950/60 px-2.5 py-1 rounded border border-cyan-400/30 font-bold uppercase">Save 15%</span>
                        </div>

                        <div x-show="isSubscription" x-transition class="pt-4 mt-4 border-t border-white/10">
                            <label for="frequency" class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1.5 font-semibold">Delivery Cadence</label>
                            <select id="frequency" name="frequency" class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3 text-xs font-mono text-white min-h-[44px]">
                                <option value="weekly" selected class="bg-slate-900 text-white">Weekly (Every 7 days)</option>
                                <option value="biweekly" class="bg-slate-900 text-white">Bi-Weekly (Every 14 days)</option>
                                <option value="monthly" class="bg-slate-900 text-white">Monthly (Every 30 days)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Step 4: Settlement / Payment Method -->
                    <div class="bg-[#0b1226]/85 backdrop-blur-xl p-6 sm:p-8 rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                        <div class="flex items-center gap-3 mb-6 pb-3 border-b border-white/10">
                            <span class="w-6 h-6 rounded-full bg-cyan-400/20 text-cyan-300 border border-cyan-400/40 text-xs font-mono font-bold flex items-center justify-center">3</span>
                            <h2 class="text-xs font-mono uppercase tracking-widest font-bold text-white">Payment Method</h2>
                        </div>

                        <div class="space-y-3">
                            <!-- Option: Cash on Delivery -->
                            <label class="flex items-center justify-between p-4 rounded-xl border border-cyan-400/40 bg-cyan-400/[0.06] hover:bg-cyan-400/[0.1] cursor-pointer transition-all">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="cash" checked class="w-4 h-4 text-cyan-400 focus:ring-cyan-400 bg-slate-900 border-white/20">
                                    <div>
                                        <span class="text-xs font-mono font-bold uppercase tracking-wider text-white block">Cash on Delivery</span>
                                        <span class="text-[11px] text-slate-400 font-light block">Pay our driver upon physical doorstep delivery.</span>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </label>

                            <!-- Option: Card upon Delivery -->
                            <label class="flex items-center justify-between p-4 rounded-xl border border-white/15 bg-white/[0.02] hover:border-white/30 hover:bg-white/[0.05] cursor-pointer transition-all">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="card" class="w-4 h-4 text-cyan-400 focus:ring-cyan-400 bg-slate-900 border-white/20">
                                    <div>
                                        <span class="text-xs font-mono font-bold uppercase tracking-wider text-white block">Card POS on Delivery</span>
                                        <span class="text-[11px] text-slate-400 font-light block">Our representative brings a portable card terminal.</span>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </label>

                            <!-- Option: Bank Transfer -->
                            <label class="flex items-center justify-between p-4 rounded-xl border border-white/15 bg-white/[0.02] hover:border-white/30 hover:bg-white/[0.05] cursor-pointer transition-all">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="w-4 h-4 text-cyan-400 focus:ring-cyan-400 bg-slate-900 border-white/20">
                                    <div>
                                        <span class="text-xs font-mono font-bold uppercase tracking-wider text-white block">Direct Bank Transfer</span>
                                        <span class="text-[11px] text-slate-400 font-light block">Wire funds directly to Glaciar Water Co accounts.</span>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Sticky Order Summary Sidebar (Columns 8-12) -->
                <div class="lg:col-span-5 lg:sticky lg:top-28 space-y-6 gl-reveal-item">
                    <div class="bg-[#0b1226]/85 backdrop-blur-xl rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)] p-6 sm:p-8">
                        <h2 class="text-xs font-mono uppercase tracking-ultra font-bold text-white mb-6 pb-3 border-b border-white/10">
                            DISPATCH MANIFEST SUMMARY
                        </h2>

                        <!-- Line Items -->
                        <div class="divide-y divide-white/10 max-h-72 overflow-y-auto pr-1 mb-6">
                            @foreach($cartItems ?? [] as $item)
                                @php
                                    $p = $item->product;
                                    $size = $p->size_ml >= 1000 ? ($p->size_ml / 1000) . 'L' : $p->size_ml . 'ml';
                                    $img = $p->image_url ?? asset('images/products/' . ($p->size_ml ?? 500) . '.jpg');
                                @endphp
                                <div class="py-3.5 flex items-center justify-between gap-3 text-xs">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-10 h-12 bg-white/5 rounded border border-white/10 p-1 flex-shrink-0 flex items-center justify-center">
                                            <img src="{{ $img }}" alt="{{ $p->name }}" class="w-full h-full object-contain" />
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-white truncate font-mono">{{ $p->name }}</p>
                                            <p class="text-[11px] font-mono text-slate-400">Qty: {{ $item->qty }} · {{ $size }}</p>
                                        </div>
                                    </div>
                                    <span class="font-mono font-bold text-cyan-300 whitespace-nowrap">
                                        LKR {{ number_format($p->price * $item->qty, 0) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Calculations -->
                        <div class="space-y-3 pt-4 border-t border-white/10 text-xs font-mono text-slate-300 mb-6">
                            <div class="flex items-center justify-between">
                                <span>SUBTOTAL</span>
                                <span class="font-bold text-white">LKR {{ number_format($cartTotal ?? 0, 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>DELIVERY DISPATCH</span>
                                <span class="font-bold text-cyan-400">COMPLIMENTARY</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex items-baseline justify-between mb-8">
                            <span class="text-xs font-mono font-bold uppercase text-slate-400 tracking-wider">TOTAL DUE</span>
                            <span class="text-2xl font-black text-white font-mono tracking-tight">
                                LKR {{ number_format($cartTotal ?? 0, 0) }}
                            </span>
                        </div>

                        <button type="submit" 
                                class="w-full py-4 px-6 bg-gradient-to-r from-cyan-400 via-sky-400 to-cyan-300 hover:brightness-110 text-slate-950 text-xs font-bold font-mono uppercase tracking-widest rounded-xl transition-all shadow-[0_0_25px_rgba(56,189,248,0.35)] flex items-center justify-center gap-2 transform hover:-translate-y-0.5 min-h-[48px]">
                            <span>Place Dispatch Order</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/></svg>
                        </button>

                        <p class="text-[10px] text-center text-slate-400 font-mono mt-4">
                            By placing this order, you confirm acceptance of Glaciar delivery protocol.
                        </p>
                    </div>
                </div>

            </div>
        </form>

    </div>
</section>

@endsection
