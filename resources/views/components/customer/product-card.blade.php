@props(['product', 'compact' => false])

@php
    $sizeFormatted = $product->size_ml >= 1000 ? ($product->size_ml / 1000) . 'L' : $product->size_ml . 'ml';
    $img = $product->image_url ?? asset('images/products/' . ($product->size_ml ?? 500) . '.jpg');
@endphp

<div class="gl-card-3d group relative flex flex-col bg-[#0b1226]/85 backdrop-blur-xl border border-white/15 rounded-2xl overflow-hidden hover:border-cyan-400/60 transition-all duration-500 hover:shadow-[0_25px_50px_rgba(0,0,0,0.85)]">
    
    <!-- Image Stage with Hover Depth -->
    <a href="{{ route('products.show', $product->id) }}" class="relative block w-full aspect-[3/4] bg-gradient-to-b from-white/5 via-transparent to-black/30 overflow-hidden p-6 flex items-center justify-center">
        <!-- Top Badges -->
        <div class="absolute top-4 left-4 right-4 z-10 flex items-center justify-between pointer-events-none">
            <span class="text-[10px] font-mono font-semibold tracking-widest text-cyan-300 bg-white/5 border border-white/10 backdrop-blur-md px-2.5 py-1 rounded-md">
                {{ strtoupper($sizeFormatted) }}
            </span>
            @if($product->stock > 0)
                <span class="text-[10px] font-mono font-semibold tracking-wider text-emerald-300 bg-emerald-500/10 px-2 py-0.5 rounded-md border border-emerald-400/30">
                    IN ALLOCATION
                </span>
            @else
                <span class="text-[10px] font-mono font-semibold tracking-wider text-amber-300 bg-amber-500/10 px-2 py-0.5 rounded-md border border-amber-400/30">
                    RESERVED
                </span>
            @endif
        </div>

        <!-- Product Image -->
        <img src="{{ $img }}" 
             alt="{{ $product->name }}" 
             loading="lazy"
             class="product-card-image w-full h-full object-contain object-center filter drop-shadow-[0_20px_35px_rgba(0,0,0,0.7)] group-hover:scale-105 transition-transform duration-700 ease-out" />
        
        <!-- Subtle specular reflection overlay on hover -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
    </a>
    
    <!-- Content Section -->
    <div class="p-5 sm:p-6 flex flex-col flex-grow justify-between space-y-4">
        <div>
            <div class="flex items-baseline justify-between mb-1.5">
                <span class="text-[10px] uppercase tracking-ultra font-bold text-cyan-300 font-mono">
                    Glaciar Monolith
                </span>
                <span class="text-xs font-mono text-slate-400">
                    {{ $sizeFormatted }}
                </span>
            </div>

            <h3 class="text-base sm:text-lg font-bold text-white tracking-tight group-hover:text-cyan-200 transition-colors">
                <a href="{{ route('products.show', $product->id) }}" class="focus:outline-none">
                    {{ $product->name }}
                </a>
            </h3>

            <p class="text-xs text-slate-400 line-clamp-1 mt-1 font-light">
                {{ $product->description ?? 'Double-wall vacuum insulated alpine spring vessel.' }}
            </p>
        </div>

        <div class="pt-4 border-t border-white/10 flex items-center justify-between gap-3">
            <div>
                <span class="block text-[10px] uppercase font-mono tracking-widest text-slate-400">ALLOCATION</span>
                <span class="text-base sm:text-lg font-bold text-white font-mono tracking-tight">
                    LKR {{ number_format($product->price, 0) }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                <form action="{{ route('cart.store') }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="1">
                    <div class="gl-magnetic">
                        <button type="submit" 
                                class="inline-flex items-center justify-center p-2.5 bg-cyan-400 hover:bg-cyan-300 text-slate-950 rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(56,189,248,0.3)] min-h-[44px] min-w-[44px]"
                                title="Add to Cart">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="gl-magnetic">
                    <a href="{{ route('products.show', $product->id) }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-mono font-bold uppercase tracking-wider text-slate-200 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl transition-colors min-h-[44px]">
                        Specs
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>