@extends('layouts.customer')

@section('content')

<!-- Header Banner -->
<section class="bg-glaciar-obsidian text-white pt-20 pb-20 border-b border-white/10 relative overflow-hidden">
    <!-- Ambient glow -->
    <div class="absolute -top-20 right-1/3 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs font-mono uppercase tracking-widest text-slate-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span>/</span>
            <span class="text-cyan-300 font-semibold">The Boutique</span>
        </nav>

        <div class="max-w-3xl">
            <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">
                ARCTIC COMMERCE · DIRECT DISPATCH
            </span>
            <h1 class="text-[clamp(2.5rem,5.5vw,4.8rem)] font-black tracking-tight leading-[0.98] text-white">
                THE BOUTIQUE.
            </h1>
            <p class="mt-4 text-slate-300 text-sm sm:text-base font-light leading-relaxed max-w-2xl">
                Direct cellar allocations, high-capacity vessels, and cold-chain replenishment. Certified 10,000-year purity delivered under temperature-controlled logistics.
            </p>
        </div>
    </div>
</section>

<!-- Filter & Grid Section -->
<section class="py-16 bg-[#020617] text-white flex-grow min-h-[70vh] border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filter & Sorting Bar -->
        <div class="bg-[#0b1226]/85 backdrop-blur-xl p-4 sm:p-5 rounded-2xl border border-white/15 shadow-2xl mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4 gl-section-header">
            
            <!-- Size Pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 md:pb-0">
                <span class="text-[10px] uppercase font-mono tracking-wider text-slate-400 mr-2 flex-shrink-0">SIZE:</span>
                
                <a href="{{ route('products.index', request()->only('sort')) }}" 
                   class="px-3.5 py-1.5 rounded-lg text-xs font-mono font-semibold uppercase tracking-wider transition-all flex-shrink-0 min-h-[38px] flex items-center {{ !request('size') ? 'bg-cyan-400 text-slate-950 font-bold shadow-[0_0_15px_rgba(56,189,248,0.4)]' : 'bg-white/5 text-slate-300 hover:bg-white/10 border border-white/10' }}">
                    All
                </a>

                @foreach($sizes ?? [250, 500, 1000, 1500, 5000, 19000] as $s)
                    @php
                        $label = $s >= 1000 ? ($s / 1000) . 'L' : $s . 'ml';
                        $isActive = request('size') == $s;
                    @endphp
                    <a href="{{ route('products.index', array_merge(request()->only('sort'), ['size' => $s])) }}" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-mono font-semibold uppercase tracking-wider transition-all flex-shrink-0 min-h-[38px] flex items-center {{ $isActive ? 'bg-cyan-400 text-slate-950 font-bold shadow-[0_0_15px_rgba(56,189,248,0.4)]' : 'bg-white/5 text-slate-300 hover:bg-white/10 border border-white/10' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Sort Form -->
            <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-3 m-0 flex-shrink-0">
                @if(request('size'))
                    <input type="hidden" name="size" value="{{ request('size') }}">
                @endif
                <label for="sort" class="text-[10px] uppercase font-mono tracking-wider text-slate-400 flex-shrink-0">SORT BY:</label>
                <select id="sort" name="sort" onchange="this.form.submit()" 
                        class="bg-[#030712] border border-white/15 text-white text-xs font-mono font-medium rounded-lg px-3 py-2 focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 pr-8">
                    <option value="" {{ !request('sort') ? 'selected' : '' }}>Featured</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest Formats</option>
                </select>
            </form>

        </div>

        <!-- Product Count Indicator -->
        <div class="flex items-center justify-between mb-8 text-xs font-mono text-slate-400 uppercase tracking-wider">
            <span>Showing {{ count($products ?? []) }} Formats</span>
            @if(request('size') || request('sort'))
                <a href="{{ route('products.index') }}" class="text-cyan-300 hover:text-white transition-colors flex items-center gap-1 font-bold">
                    <span>Clear all filters</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($products ?? [] as $product)
                <div class="gl-reveal-item"><x-customer.product-card :product="$product" compact="false" /></div>
            @empty
                <div class="col-span-full py-24 text-center bg-white/[0.03] rounded-3xl border border-white/10 p-8">
                    <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">No matching formats</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mb-6">There are no vessels currently matching your selected size criteria.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-cyan-400 text-slate-950 text-xs uppercase tracking-widest font-bold rounded-xl hover:bg-cyan-300 transition-colors shadow-lg">
                        View Full Shop Catalog
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Technical Assurance Strip -->
        <div class="mt-20 pt-10 border-t border-white/10 grid grid-cols-1 md:grid-cols-3 gap-6 text-slate-300">
            <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-md gl-reveal-item">
                <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center flex-shrink-0 mt-0.5 font-mono text-xs font-bold">
                    01
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white">Springhead Direct</h4>
                    <p class="text-xs text-slate-400 font-light mt-1 leading-relaxed">Bottled immediately at high altitude without storage degradation.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-md gl-reveal-item">
                <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center flex-shrink-0 mt-0.5 font-mono text-xs font-bold">
                    02
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white">Daily Route Dispatch</h4>
                    <p class="text-xs text-slate-400 font-light mt-1 leading-relaxed">Prompt scheduled delivery across all supported local zones.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-md gl-reveal-item">
                <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center flex-shrink-0 mt-0.5 font-mono text-xs font-bold">
                    03
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white">Zero-Landfill Protocol</h4>
                    <p class="text-xs text-slate-400 font-light mt-1 leading-relaxed">100% recyclable materials with closed-loop exchange available.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
