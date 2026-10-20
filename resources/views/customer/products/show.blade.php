@extends('layouts.customer')

@section('content')

@php
    $sizeFormatted = ($product->size_ml ?? 500) >= 1000 ? (($product->size_ml ?? 500) / 1000) . 'L' : ($product->size_ml ?? 500) . 'ml';
    $img = $product->image_url ?? asset('images/products/' . ($product->size_ml ?? 500) . '.jpg');
@endphp

<!-- Breadcrumb Header -->
<div class="bg-glaciar-obsidian border-b border-white/10 py-5 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-xs font-mono uppercase tracking-widest text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Collection</a>
            <span>/</span>
            <span class="text-cyan-300 font-semibold">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<!-- Product Stage (Split Layout) -->
<section class="py-20 bg-[#020617] text-white flex-grow min-h-[85vh] border-b border-white/10 gl-section-reveal" x-data="{ qty: 1, activeTab: 'specs', currentImage: '{{ $img }}' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Left: Product Gallery & Stage (Columns 1-7) -->
            <div class="lg:col-span-7 sticky top-28 space-y-6 gl-section-header">
                <!-- Main Image Canvas -->
                <div class="relative w-full aspect-[4/5] bg-[#0b1226]/85 backdrop-blur-2xl rounded-3xl border border-white/15 overflow-hidden shadow-2xl flex items-center justify-center p-8 sm:p-12 group">
                    <img :src="currentImage" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-contain object-center transition-transform duration-700 ease-out group-hover:scale-105 filter drop-shadow-[0_25px_45px_rgba(0,0,0,0.8)]" />
                    
                    <!-- Ambient Glow underneath -->
                    <div class="absolute bottom-6 w-3/4 h-12 bg-cyan-500/10 rounded-full blur-xl pointer-events-none"></div>

                    <!-- Watermark Badges -->
                    <div class="absolute top-6 left-6 flex items-center gap-2">
                        <span class="text-[10px] font-mono font-bold tracking-widest text-cyan-300 bg-white/5 border border-white/10 backdrop-blur-md px-3 py-1.5 rounded-lg">
                            {{ strtoupper($sizeFormatted) }} SPEC
                        </span>
                    </div>

                    <div class="absolute top-6 right-6">
                        <span class="inline-flex items-center text-[10px] font-mono font-semibold tracking-wider text-emerald-300 bg-emerald-500/10 border border-emerald-400/30 px-3 py-1 rounded-lg">
                            AUTHENTIC GLACIAR
                        </span>
                    </div>
                </div>

                <!-- Secondary Gallery Thumbnails -->
                <div class="grid grid-cols-4 gap-3">
                    <button type="button" 
                            @click="currentImage = '{{ $img }}'"
                            :class="currentImage === '{{ $img }}' ? 'ring-2 ring-cyan-400 border-transparent' : 'border-white/10 hover:border-white/30'"
                            class="aspect-square bg-[#0b1226]/80 rounded-xl border p-2 flex items-center justify-center overflow-hidden transition-all">
                        <img src="{{ $img }}" alt="{{ $product->name }} Angle 1" class="w-full h-full object-contain" />
                    </button>
                    <button type="button" 
                            @click="currentImage = '{{ asset('images/hero/glaciar-crystal-bottle.png') }}'"
                            :class="currentImage === '{{ asset('images/hero/glaciar-crystal-bottle.png') }}' ? 'ring-2 ring-cyan-400 border-transparent' : 'border-white/10 hover:border-white/30'"
                            class="aspect-square bg-[#0b1226]/80 rounded-xl border p-2 flex items-center justify-center overflow-hidden transition-all">
                        <img src="{{ asset('images/hero/glaciar-crystal-bottle.png') }}" alt="{{ $product->name }} Studio" class="w-full h-full object-contain" />
                    </button>
                    <button type="button" 
                            @click="currentImage = '{{ asset('images/products/500.jpg') }}'"
                            :class="currentImage === '{{ asset('images/products/500.jpg') }}' ? 'ring-2 ring-cyan-400 border-transparent' : 'border-white/10 hover:border-white/30'"
                            class="aspect-square bg-[#0b1226]/80 rounded-xl border p-2 flex items-center justify-center overflow-hidden transition-all">
                        <img src="{{ asset('images/products/500.jpg') }}" alt="Standard Vessel" class="w-full h-full object-contain" />
                    </button>
                    <button type="button" 
                            @click="currentImage = '{{ asset('images/products/1000.jpg') }}'"
                            :class="currentImage === '{{ asset('images/products/1000.jpg') }}' ? 'ring-2 ring-cyan-400 border-transparent' : 'border-white/10 hover:border-white/30'"
                            class="aspect-square bg-[#0b1226]/80 rounded-xl border p-2 flex items-center justify-center overflow-hidden transition-all">
                        <img src="{{ asset('images/products/1000.jpg') }}" alt="Hydration Vessel" class="w-full h-full object-contain" />
                    </button>
                </div>
            </div>

            <!-- Right: Product Information & Purchase Flow (Columns 8-12) -->
            <div class="lg:col-span-5 space-y-8 gl-reveal-item">
                
                <div>
                    <!-- Small Label -->
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                            GLACIAR VESSEL ARCHITECTURE
                        </span>
                        <span class="text-white/20">·</span>
                        <span class="text-xs font-mono text-slate-400 uppercase">{{ $sizeFormatted }}</span>
                    </div>

                    <!-- Product Title -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-none mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <div class="flex items-baseline gap-3 mb-6">
                        <span class="text-2xl sm:text-3xl font-black text-white font-mono tracking-tight">
                            LKR {{ number_format($product->price, 0) }}
                        </span>
                        <span class="text-xs font-mono uppercase text-slate-400 tracking-wider">
                            / INCL. TAX & STERILE SEAL
                        </span>
                    </div>

                    <!-- Editorial Description -->
                    <p class="text-slate-300 text-sm leading-relaxed font-light mb-6">
                        {{ $product->description ?? 'Crafted from heavy optical-grade flint glass with double-wall thermal insulation. Sourced directly from untouched alpine springs, providing crisp alkaline hydration throughout the day.' }}
                    </p>

                    <!-- Fast Spec Matrix -->
                    <div class="grid grid-cols-2 gap-3 p-5 bg-white/[0.03] backdrop-blur-md rounded-2xl border border-white/10 mb-8 text-xs font-mono">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">CAPACITY</span>
                            <span class="font-bold text-white">{{ $sizeFormatted }} ({{ $product->size_ml }}ml)</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">TEMPERATURE</span>
                            <span class="font-bold text-cyan-300">24h Sub-Zero Hold</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">CORE MATERIAL</span>
                            <span class="font-bold text-white">Heavy Flint Glass</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">DISPATCH STATUS</span>
                            <span class="font-bold text-emerald-400">Immediate Allocation</span>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.store') }}" method="POST" class="space-y-6 pt-4 border-t border-white/10">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div>
                        <label for="qty-input" class="block text-xs uppercase font-mono tracking-wider font-semibold text-slate-400 mb-2">
                            Select Allocation Quantity
                        </label>
                        <div class="flex items-center gap-4">
                            <!-- Quantity Counter -->
                            <div class="inline-flex items-center bg-white/5 border border-white/15 rounded-xl overflow-hidden shadow-sm">
                                <button type="button" 
                                        @click="if(qty > 1) qty--" 
                                        class="px-4 py-3 text-slate-300 hover:text-white hover:bg-white/10 transition-colors focus:outline-none min-h-[44px]"
                                        aria-label="Decrease quantity">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </button>
                                <input type="number" 
                                       id="qty-input" 
                                       name="qty" 
                                       x-model="qty" 
                                       min="1" 
                                       max="100" 
                                       class="w-14 text-center bg-transparent border-0 focus:ring-0 p-0 text-sm font-mono font-bold text-white" />
                                <button type="button" 
                                        @click="if(qty < 100) qty++" 
                                        class="px-4 py-3 text-slate-300 hover:text-white hover:bg-white/10 transition-colors focus:outline-none min-h-[44px]"
                                        aria-label="Increase quantity">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>

                            <!-- Primary Add to Cart Button -->
                            <button type="submit" 
                                    class="gl-magnetic flex-1 py-4 px-6 bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-[0_0_25px_rgba(56,189,248,0.5)] flex items-center justify-center gap-2 transform hover:-translate-y-0.5 min-h-[44px]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Technical Expandable Accordion -->
                <div class="border-t border-white/10 pt-6 space-y-3" x-data="{ openSection: 1 }">
                    
                    <!-- Accordion Item 1 -->
                    <div class="border border-white/10 bg-white/[0.03] rounded-2xl overflow-hidden backdrop-blur-md">
                        <button type="button" 
                                @click="openSection = (openSection === 1 ? null : 1)" 
                                class="w-full p-4 sm:p-5 text-left flex items-center justify-between text-xs font-mono font-bold uppercase tracking-wider text-white hover:text-cyan-300 transition-colors">
                            <span>01 / Specifications & Sourcing</span>
                            <span x-text="openSection === 1 ? '−' : '+'" class="text-base font-mono"></span>
                        </button>
                        <div x-show="openSection === 1" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed font-light border-t border-white/10 pt-4">
                            <ul class="space-y-2 font-mono text-[11px]">
                                <li>• High Altitude Glacial Spring Source (1,890m elevation)</li>
                                <li>• Natural 7.4 pH balance with rich alkaline mineral electrolytes</li>
                                <li>• 100% BPA, BPS, and microplastic free</li>
                                <li>• Heavy optical flint glass with 24-facet light prism base</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Accordion Item 2 -->
                    <div class="border border-white/10 bg-white/[0.03] rounded-2xl overflow-hidden backdrop-blur-md">
                        <button type="button" 
                                @click="openSection = (openSection === 2 ? null : 2)" 
                                class="w-full p-4 sm:p-5 text-left flex items-center justify-between text-xs font-mono font-bold uppercase tracking-wider text-white hover:text-cyan-300 transition-colors">
                            <span>02 / Temperature & Thermodynamics</span>
                            <span x-text="openSection === 2 ? '−' : '+'" class="text-base font-mono"></span>
                        </button>
                        <div x-show="openSection === 2" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed font-light border-t border-white/10 pt-4">
                            Heavy flint glass density retains sub-zero temperatures naturally without condensation sweating on fine wood surfaces or executive desks.
                        </div>
                    </div>

                    <!-- Accordion Item 3 -->
                    <div class="border border-white/10 bg-white/[0.03] rounded-2xl overflow-hidden backdrop-blur-md">
                        <button type="button" 
                                @click="openSection = (openSection === 3 ? null : 3)" 
                                class="w-full p-4 sm:p-5 text-left flex items-center justify-between text-xs font-mono font-bold uppercase tracking-wider text-white hover:text-cyan-300 transition-colors">
                            <span>03 / Zone Delivery & Closed Loop</span>
                            <span x-text="openSection === 3 ? '−' : '+'" class="text-base font-mono"></span>
                        </button>
                        <div x-show="openSection === 3" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed font-light border-t border-white/10 pt-4">
                            Direct local delivery handled by dedicated Glaciar zone representatives in insulated transport cases. Eligible for our complimentary closed-loop return & refill exchange service.
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

@endsection
