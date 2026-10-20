@extends('layouts.customer')

@section('title', 'The Vessel Collection — GLACIAR Natural Glacier Water')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO HEADER BANNER
     ═══════════════════════════════════════════════════════════════════ -->
<section class="bg-glaciar-obsidian text-white pt-28 pb-24 border-b border-white/10 relative overflow-hidden min-h-[85vh] flex items-center gl-section-reveal">
    <!-- Atmospheric Glacier Glow -->
    <div class="absolute -top-32 right-1/4 w-[600px] h-[600px] bg-cyan-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-10 w-96 h-96 bg-sky-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs font-mono uppercase tracking-widest text-slate-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span>/</span>
            <span class="text-cyan-300 font-semibold">The Collection</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
            <div class="lg:col-span-8 gl-section-header">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md mb-4">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                        04 / ARCHITECTURAL VESSEL PORTFOLIO
                    </span>
                </div>
                <h1 class="text-[clamp(2.6rem,6vw,5.5rem)] font-black tracking-tight leading-[0.94] text-white">
                    THE VESSEL<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">COLLECTION.</span>
                </h1>
                <p class="mt-6 text-slate-300 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                    Engineered from heavy optical-grade flint glass with diamond-faceted base geometry. Every Glaciar vessel is a precision instrument designed to protect living 10,000-year glacial minerals and retain sub-zero temperatures from source to table.
                </p>
            </div>

            <!-- Telemetry Summary Card -->
            <div class="lg:col-span-4 bg-white/5 backdrop-blur-xl border border-white/15 p-6 rounded-2xl shadow-2xl gl-reveal-item">
                <div class="text-[10px] font-mono uppercase tracking-ultra text-slate-400 mb-3 font-semibold">VESSEL SPECIFICATION TELEMETRY</div>
                <div class="grid grid-cols-2 gap-4 text-xs font-mono">
                    <div class="p-3 rounded-lg bg-black/40 border border-white/5">
                        <span class="text-slate-400 block text-[10px]">MATERIAL</span>
                        <span class="text-white font-bold">Flint Glass</span>
                    </div>
                    <div class="p-3 rounded-lg bg-black/40 border border-white/5">
                        <span class="text-slate-400 block text-[10px]">FACETS</span>
                        <span class="text-cyan-300 font-bold">24 Prism Ribs</span>
                    </div>
                    <div class="p-3 rounded-lg bg-black/40 border border-white/5">
                        <span class="text-slate-400 block text-[10px]">CHILL HOLD</span>
                        <span class="text-white font-bold">90 Minutes</span>
                    </div>
                    <div class="p-3 rounded-lg bg-black/40 border border-white/5">
                        <span class="text-slate-400 block text-[10px]">LIFECYCLE</span>
                        <span class="text-cyan-300 font-bold">50x Closed-Loop</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     2. THE FORMAT SHOWCASE
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-glaciar-obsidian text-white relative border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gl-section-header">
            <div>
                <span class="text-xs font-mono uppercase tracking-ultra text-cyan-300 font-bold block mb-2">CURATED FORMATS</span>
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Five Sculptural Silhouettes</h2>
            </div>
            <p class="text-slate-400 text-sm max-w-md mt-4 md:mt-0 font-light">
                From personal pocket flasks to banquet-scale glass decanters, discover the vessels crafted for discerning palates.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Vessel 1: 500ml Standard -->
            <div class="bg-gradient-to-b from-white/10 to-white/5 rounded-2xl border border-white/15 p-8 flex flex-col justify-between hover:border-cyan-400/50 transition-all duration-500 group shadow-2xl relative gl-reveal-item">
                <div class="flex items-center justify-between text-xs font-mono uppercase">
                    <span class="px-3 py-1 rounded-full bg-cyan-400/20 text-cyan-300 font-bold border border-cyan-400/30">
                        500 ML
                    </span>
                    <span class="text-slate-400">SIGNATURE BOTTLE</span>
                </div>

                <div class="my-10 relative flex items-center justify-center h-72">
                    <img src="{{ asset('images/hero/glaciar-crystal-bottle.png') }}" 
                         alt="Glaciar Standard 500ml" 
                         class="max-h-full object-contain filter drop-shadow-[0_20px_40px_rgba(4,15,45,0.7)] group-hover:scale-105 transition-transform duration-500" />
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">The Personal Decanter</h3>
                        <p class="text-xs text-slate-300 font-light mt-1 leading-relaxed">
                            Single-portion flint glass vessel with 24 ice prism facets. Sized for luxury hospitality bedside placement and private dining.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10 flex items-center justify-between font-mono">
                        <span class="text-lg font-black text-white">LKR 1,200</span>
                        <a href="{{ route('shop') }}" class="px-4 py-2 rounded-lg bg-cyan-400/20 hover:bg-cyan-400 text-cyan-300 hover:text-slate-950 font-bold text-xs uppercase tracking-wider transition-all min-h-[44px] flex items-center justify-center">
                            Acquire Vessel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vessel 2: 750ml Wine Silhouette -->
            <div class="bg-gradient-to-b from-white/10 to-white/5 rounded-2xl border border-white/15 p-8 flex flex-col justify-between hover:border-cyan-400/50 transition-all duration-500 group shadow-2xl relative gl-reveal-item">
                <div class="flex items-center justify-between text-xs font-mono uppercase">
                    <span class="px-3 py-1 rounded-full bg-cyan-400/20 text-cyan-300 font-bold border border-cyan-400/30">
                        750 ML
                    </span>
                    <span class="text-slate-400">SOMMELIER CARAFE</span>
                </div>

                <div class="my-10 relative flex items-center justify-center h-72">
                    <img src="{{ asset('images/hero/glaciar-crystal-bottle.png') }}" 
                         alt="Glaciar Sommelier 750ml" 
                         class="max-h-full object-contain filter drop-shadow-[0_20px_40px_rgba(4,15,45,0.7)] group-hover:scale-105 transition-transform duration-500" />
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">The Sommelier Carafe</h3>
                        <p class="text-xs text-slate-300 font-light mt-1 leading-relaxed">
                            Bordeaux-inspired proportions engineered to stand alongside grand cru wines. Deep punt bottom for professional sommelier thumb pouring.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10 flex items-center justify-between font-mono">
                        <span class="text-lg font-black text-white">LKR 1,800</span>
                        <a href="{{ route('shop') }}" class="px-4 py-2 rounded-lg bg-cyan-400/20 hover:bg-cyan-400 text-cyan-300 hover:text-slate-950 font-bold text-xs uppercase tracking-wider transition-all min-h-[44px] flex items-center justify-center">
                            Acquire Vessel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vessel 3: 1000ml (1L) Grand Reserve -->
            <div class="bg-gradient-to-b from-white/10 to-white/5 rounded-2xl border border-white/15 p-8 flex flex-col justify-between hover:border-cyan-400/50 transition-all duration-500 group shadow-2xl relative gl-reveal-item">
                <div class="flex items-center justify-between text-xs font-mono uppercase">
                    <span class="px-3 py-1 rounded-full bg-cyan-400/20 text-cyan-300 font-bold border border-cyan-400/30">
                        1,000 ML
                    </span>
                    <span class="text-slate-400">GRAND RESERVE</span>
                </div>

                <div class="my-10 relative flex items-center justify-center h-72">
                    <img src="{{ asset('images/hero/glaciar-crystal-bottle.png') }}" 
                         alt="Glaciar Grand Reserve 1000ml" 
                         class="max-h-full object-contain filter drop-shadow-[0_20px_40px_rgba(4,15,45,0.7)] group-hover:scale-105 transition-transform duration-500" />
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">The Grand Reserve</h3>
                        <p class="text-xs text-slate-300 font-light mt-1 leading-relaxed">
                            Commanding 1-liter monolith. 18mm reinforced optical glass base providing over 90 minutes of passive chill retention at room temperature.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10 flex items-center justify-between font-mono">
                        <span class="text-lg font-black text-white">LKR 2,400</span>
                        <a href="{{ route('shop') }}" class="px-4 py-2 rounded-lg bg-cyan-400/20 hover:bg-cyan-400 text-cyan-300 hover:text-slate-950 font-bold text-xs uppercase tracking-wider transition-all min-h-[44px] flex items-center justify-center">
                            Acquire Vessel
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- High-Capacity Monoliths Row -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-8 rounded-2xl bg-white/5 border border-white/10 flex flex-col sm:flex-row items-center gap-8 gl-reveal-item">
                <div class="w-32 h-32 rounded-xl bg-cyan-500/10 flex items-center justify-center flex-shrink-0 border border-cyan-400/20">
                    <span class="text-3xl font-black text-cyan-300 font-mono">5L</span>
                </div>
                <div class="space-y-2 flex-grow">
                    <span class="text-[10px] font-mono text-cyan-300 uppercase tracking-widest font-bold">ESTATE BANQUET TABLE</span>
                    <h4 class="text-xl font-bold text-white font-mono">Glaciar 5-Liter Table Jug</h4>
                    <p class="text-xs text-slate-400 font-light leading-relaxed">
                        Sculpted heavy table jug designed for private residence dining rooms and executive boardrooms. Precision pour spout with zero droplet back-drip.
                    </p>
                    <div class="pt-2 flex items-center justify-between">
                        <span class="text-xl font-black text-white font-mono">LKR 6,500</span>
                        <a href="{{ route('shop') }}" class="text-xs font-mono font-bold text-cyan-300 hover:text-white uppercase tracking-wider min-h-[44px] flex items-center">
                            Order in Shop &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-8 rounded-2xl bg-white/5 border border-white/10 flex flex-col sm:flex-row items-center gap-8 gl-reveal-item">
                <div class="w-32 h-32 rounded-xl bg-cyan-500/10 flex items-center justify-center flex-shrink-0 border border-cyan-400/20">
                    <span class="text-3xl font-black text-cyan-300 font-mono">19L</span>
                </div>
                <div class="space-y-2 flex-grow">
                    <span class="text-[10px] font-mono text-cyan-300 uppercase tracking-widest font-bold">ARCHITECTURAL DISPENSER</span>
                    <h4 class="text-xl font-bold text-white font-mono">Glaciar 19-Liter Monolith</h4>
                    <p class="text-xs text-slate-400 font-light leading-relaxed">
                        High-capacity glass carboy for custom cold-chain dispenser monoliths. Includes weekly white-glove doorstep bottle collection and replenishment.
                    </p>
                    <div class="pt-2 flex items-center justify-between">
                        <span class="text-xl font-black text-white font-mono">LKR 12,000</span>
                        <a href="{{ route('shop') }}" class="text-xs font-mono font-bold text-cyan-300 hover:text-white uppercase tracking-wider min-h-[44px] flex items-center">
                            Order in Shop &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     3. FOUR PILLARS OF VESSEL CRAFT
     ═══════════════════════════════════════════════════════════════════ -->
<section id="craft" class="py-24 sm:py-28 bg-glaciar-obsidian text-white relative border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 gl-section-header">
            <span class="text-xs font-mono uppercase tracking-ultra text-cyan-300 font-bold block mb-3">MATERIAL ANATOMY</span>
            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">The Anatomy of Flint Glass</h2>
            <p class="mt-4 text-slate-300 text-sm sm:text-base font-light leading-relaxed">
                Ordinary plastics leach antimony, bisphenols, and micro-particles into water over time. Glaciar vessels are created strictly from high-density optical flint glass.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <div class="p-8 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between gl-reveal-item">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-cyan-400/20 text-cyan-300 flex items-center justify-center mb-6 font-mono font-bold">
                        01
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2 font-mono">Optical Purity</h4>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Ultra-dense amorphous silica network ensures zero chemical leeching, maintaining the natural 7.4 alkaline balance indefinitely.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono text-cyan-300 font-bold">
                    ZERO MICROPLASTICS
                </div>
            </div>

            <div id="facets" class="p-8 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between gl-reveal-item">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-cyan-400/20 text-cyan-300 flex items-center justify-center mb-6 font-mono font-bold">
                        02
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2 font-mono">24 Starburst Facets</h4>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Faceted diamond ridges cast prismatic light refractions across table linens, emulating sunlight filtering through glacial ice caves.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono text-cyan-300 font-bold">
                    PRISMATIC REFRACTION
                </div>
            </div>

            <div id="thermal" class="p-8 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between gl-reveal-item">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-cyan-400/20 text-cyan-300 flex items-center justify-center mb-6 font-mono font-bold">
                        03
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2 font-mono">Sub-Zero Thermal Mass</h4>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        An 18mm reinforced glass base acts as an insulating cold sink, keeping chilled water at 4–8°C for over an hour after table presentation.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono text-cyan-300 font-bold">
                    90-MIN THERMAL STABILITY
                </div>
            </div>

            <div class="p-8 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between gl-reveal-item">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-cyan-400/20 text-cyan-300 flex items-center justify-center mb-6 font-mono font-bold">
                        04
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2 font-mono">Closed-Loop Exchange</h4>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Returned via our white-glove courier network, hydro-sanitized at 85°C with zero chemical agents, and refilled up to 50 times.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono text-cyan-300 font-bold">
                    100% INFINITE CIRCULARITY
                </div>
            </div>

        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     4. CALL TO ACTION TO VISIT THE SHOP / BOUTIQUE
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gradient-to-b from-glaciar-obsidian to-black text-white relative gl-section-reveal">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 gl-section-header">
        
        <span class="text-xs font-mono uppercase tracking-ultra text-cyan-300 font-bold block mb-4">
            RESERVE YOUR ALLOCATION
        </span>
        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-6">
            Explore the Glaciar Boutique
        </h2>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto mb-10 font-light leading-relaxed">
            Ready to experience 10,000-year living glacial water? Visit our online boutique to configure delivery frequencies, select formats, and arrange doorstep bottle replenishment.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 gl-reveal-item">
            <a href="{{ route('shop') }}" class="gl-magnetic w-full sm:w-auto px-8 py-4 rounded-xl bg-white hover:bg-cyan-200 text-slate-950 font-bold text-xs font-mono uppercase tracking-widest transition-all shadow-[0_0_25px_rgba(255,255,255,0.45)] hover:shadow-[0_0_35px_rgba(56,189,248,0.7)] flex items-center justify-center gap-2 min-h-[48px]">
                <span>Enter The Boutique (Shop Now)</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="{{ route('contact') }}" class="gl-magnetic w-full sm:w-auto px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs font-mono uppercase tracking-widest transition-colors border border-white/20 min-h-[48px] flex items-center justify-center">
                Contact Concierge
            </a>
        </div>

    </div>
</section>

@endsection
