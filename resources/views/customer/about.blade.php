@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO: THE GLACIAR CHRONICLE
     ═══════════════════════════════════════════════════════════════════ -->
<section class="relative bg-glaciar-obsidian text-white pt-28 pb-24 border-b border-white/10 overflow-hidden select-none min-h-[85vh] flex items-center gl-section-reveal"
         style="background-image: url('{{ asset('images/hero/glaciar-aurora-bg.jpg') }}'); background-size: cover; background-position: center 20%;">
    
    <!-- Atmospheric Contrast Overlays -->
    <div class="absolute inset-0 bg-gradient-to-r from-glaciar-obsidian/95 via-glaciar-obsidian/85 to-glaciar-obsidian/70 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-glaciar-obsidian via-transparent to-glaciar-obsidian/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-3xl space-y-6 gl-section-header">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                    01 / THE GLACIAR CHRONICLE
                </span>
            </div>

            <h1 class="text-[clamp(2.4rem,6vw,5.2rem)] font-black tracking-tight leading-[0.94] text-white">
                BORN FROM 10,000 YEARS OF<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300 drop-shadow-[0_0_35px_rgba(56,189,248,0.4)]">
                    ARCTIC SANCTUARY.
                </span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg lg:text-xl font-light leading-relaxed max-w-2xl">
                Glaciar was founded on a singular conviction: that water should remain untouched by urban contamination, encased only in high-performance flint glass vessels engineered to preserve its primordial cold purity.
            </p>

            <!-- Key Telemetry Row -->
            <div class="pt-6 border-t border-white/15 grid grid-cols-2 sm:grid-cols-4 gap-6 font-mono text-xs gl-reveal-item">
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">ELEVATION</span>
                    <span class="font-bold text-white text-sm sm:text-base">1,890 METRES</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">PH PROFILE</span>
                    <span class="font-bold text-cyan-300 text-sm sm:text-base">7.4 ALKALINE</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">STRATA AGE</span>
                    <span class="font-bold text-white text-sm sm:text-base">10,000 YEARS</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">ADDITIVES</span>
                    <span class="font-bold text-cyan-400 text-sm sm:text-base">0.00% PURITY</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     2. THE PROVENANCE: UNTOUCHED ARCTIC ICE STRATA
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 sm:py-28 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <div class="lg:col-span-6 space-y-6 gl-section-header">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                        02 / NATURAL PROVENANCE
                    </span>
                </div>
                
                <h2 class="text-[clamp(2rem,4.5vw,3.6rem)] font-black tracking-tight leading-[0.98] text-white">
                    Centuries Before the Industrial Age.
                </h2>
                
                <p class="text-slate-300 text-sm sm:text-base font-light leading-relaxed">
                    Centuries before carbon emissions and modern industrial pollutants altered the global atmosphere, crystalline snowfall settled atop high-latitude alpine mountain peaks. Compressed under massive geological pressures, that snowfall transformed into dense, oxygen-rich glacial ice strata.
                </p>

                <p class="text-slate-300 text-sm sm:text-base font-light leading-relaxed">
                    Today, Glaciar accesses this primordial meltwater at its natural alpine terminus at 1,890 meters. Water flows directly from sub-zero glacier subterranean channels into our hermetically sealed bottling facility with zero mechanical pumps, zero chemical additives, and zero human contact.
                </p>

                <div class="pt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md gl-reveal-item">
                        <span class="text-[10px] font-mono uppercase text-cyan-300 block mb-1 font-semibold">GRAVITY-FED BOTTLING</span>
                        <p class="text-xs text-slate-300 leading-relaxed font-light">Natural atmospheric pressure propels the water through sterile stainless steel conduits, preserving dissolved oxygen.</p>
                    </div>
                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md gl-reveal-item">
                        <span class="text-[10px] font-mono uppercase text-cyan-300 block mb-1 font-semibold">SUB-ZERO PACKAGING</span>
                        <p class="text-xs text-slate-300 leading-relaxed font-light">Sealed at -12°C ambient temperatures to lock in micro-mineral structures before exposure to ambient thermal shifts.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 gl-reveal-item">
                <div class="relative rounded-3xl overflow-hidden border border-white/15 bg-slate-900 shadow-[0_25px_60px_rgba(0,0,0,0.7)] group">
                    <img src="{{ asset('images/hero/glaciar-crystal-bottle.png') }}" 
                         alt="Glaciar Crystal Diamond Vessel" 
                         class="w-full h-[440px] sm:h-[520px] object-contain p-8 select-none filter drop-shadow-[0_20px_40px_rgba(56,189,248,0.25)] group-hover:scale-105 transition-transform duration-700 ease-out" />
                    
                    <div class="absolute bottom-0 inset-x-0 p-6 bg-gradient-to-t from-glaciar-obsidian via-glaciar-obsidian/80 to-transparent backdrop-blur-md border-t border-white/10">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-mono uppercase tracking-widest text-cyan-300 block">VESSEL ARCHITECTURE</span>
                                <h4 class="text-sm font-bold text-white uppercase tracking-wider mt-0.5">Diamond-Faceted Heavy Flint Glass</h4>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-[10px] font-mono uppercase text-slate-300">
                                100% RECYCLABLE
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     3. THE THREE PILLARS OF GLACIAR
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 sm:py-28 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-20 gl-section-header">
            <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">
                03 / PHILOSOPHY & ENGINEERING
            </span>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                THREE FOUNDATIONAL<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">PRINCIPLES.</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Pillar 1 -->
            <div class="p-8 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl hover:border-cyan-400/40 transition-all duration-300 flex flex-col justify-between group gl-reveal-item">
                <div>
                    <div class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-cyan-400/10 border border-cyan-400/30 text-cyan-300 font-mono text-xs font-bold mb-6">
                        PILLAR // 01
                    </div>
                    <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block mb-2">GEOLOGICAL FILTRATION</span>
                    <h3 class="text-xl font-bold text-white mb-3 tracking-tight">Volcanic Basalt Stratum</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-light">
                        Glacial meltwater percolates through ancient volcanic basalt rock sediment. This natural underground filtration system imbues each drop with bioactive colloidal silica and vital electrolytes while maintaining pristine 7.4 pH living alkalinity.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-white/10 text-[10px] font-mono uppercase text-cyan-400 font-semibold flex items-center justify-between">
                    <span>BIO-AVAILABLE SILICA</span>
                    <span>14.2 MG/L</span>
                </div>
            </div>

            <!-- Pillar 2 -->
            <div class="p-8 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl hover:border-cyan-400/40 transition-all duration-300 flex flex-col justify-between group gl-reveal-item">
                <div>
                    <div class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-cyan-400/10 border border-cyan-400/30 text-cyan-300 font-mono text-xs font-bold mb-6">
                        PILLAR // 02
                    </div>
                    <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block mb-2">CONTAINER INTEGRITY</span>
                    <h3 class="text-xl font-bold text-white mb-3 tracking-tight">Flint Glass Architecture</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-light">
                        Never packaged in single-use plastics or porous containers. Every Glaciar vessel is formed from heavy flint glass, precision-machined with starburst ice facets that deflect ambient thermal energy and maintain sub-zero freshness for 24 hours.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-white/10 text-[10px] font-mono uppercase text-cyan-400 font-semibold flex items-center justify-between">
                    <span>THERMAL DISSIPATION</span>
                    <span>24H RETENTION</span>
                </div>
            </div>

            <!-- Pillar 3 -->
            <div class="p-8 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl hover:border-cyan-400/40 transition-all duration-300 flex flex-col justify-between group gl-reveal-item">
                <div>
                    <div class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-cyan-400/10 border border-cyan-400/30 text-cyan-300 font-mono text-xs font-bold mb-6">
                        PILLAR // 03
                    </div>
                    <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block mb-2">CIRCULAR STEWARDSHIP</span>
                    <h3 class="text-xl font-bold text-white mb-3 tracking-tight">Doorstep Closed-Loop Cycle</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-light">
                        Through our closed-loop concierge replenishment program, empties are collected from your doorstep in insulated thermal crates, sterilized with pure glacial steam, and reintroduced into circulation for up to 50 refill cycles.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-white/10 text-[10px] font-mono uppercase text-cyan-400 font-semibold flex items-center justify-between">
                    <span>INFINITE REUSE</span>
                    <span>100% CLOSED-LOOP</span>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     4. LABORATORY SENSORY & MINERAL ANALYSIS
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 sm:py-28 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <div class="lg:col-span-5 space-y-6 gl-section-header">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">
                    04 / SENSORY & SOMMELIER PROFILE
                </span>
                
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white leading-tight">
                    Cleanse the Palate Like Winter Dawn.
                </h2>
                
                <p class="text-slate-300 text-sm font-light leading-relaxed">
                    Celebrated by three-star Michelin culinary directors and certified international water sommeliers, Glaciar exhibits an exceptionally light total dissolved solids (TDS) reading of 42 mg/L.
                </p>

                <div class="space-y-4 pt-2">
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 gl-reveal-item">
                        <span class="text-xs font-bold text-white block uppercase tracking-wider mb-1 font-mono">Palate Entry</span>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">Weightless, ultra-crisp chill with zero metallic resonance or mineral harshness.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 gl-reveal-item">
                        <span class="text-xs font-bold text-white block uppercase tracking-wider mb-1 font-mono">Mid-Palate Texture</span>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">Velvety and round, supported by naturally balanced colloidal silica and magnesium electrolytes.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 gl-reveal-item">
                        <span class="text-xs font-bold text-white block uppercase tracking-wider mb-1 font-mono">Clean Finish</span>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">Immediate refreshing dryness without chalky lingering residues. Perfect companion for vintage wines.</p>
                    </div>
                </div>
            </div>

            <!-- Mineral Matrix Table -->
            <div class="lg:col-span-7 bg-white/[0.03] p-6 sm:p-10 rounded-3xl border border-white/10 backdrop-blur-xl shadow-2xl gl-reveal-item">
                <div class="flex items-center justify-between pb-6 border-b border-white/10 mb-6">
                    <div>
                        <span class="text-[10px] font-mono uppercase tracking-widest text-cyan-300 block">LABORATORY REPORT</span>
                        <h3 class="text-lg font-bold text-white tracking-tight">Certified Mineral Composition</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-cyan-400/10 border border-cyan-400/30 text-[10px] font-mono uppercase text-cyan-300 font-bold">
                        WHO COMPLIANT
                    </span>
                </div>

                <div class="divide-y divide-white/10 text-xs font-mono">
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Natural pH Balance</span>
                        <span class="font-bold text-cyan-300">7.4 pH</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Total Dissolved Solids (TDS)</span>
                        <span class="font-bold text-white">42 mg/L</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Bio-Available Colloidal Silica (SiO₂)</span>
                        <span class="font-bold text-cyan-300">14.2 mg/L</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Calcium (Ca²⁺)</span>
                        <span class="font-bold text-white">12.4 mg/L</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Magnesium (Mg²⁺)</span>
                        <span class="font-bold text-white">4.4 mg/L</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Natural Bicarbonates (HCO₃⁻)</span>
                        <span class="font-bold text-white">38.0 mg/L</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Sodium (Na⁺)</span>
                        <span class="font-bold text-white">2.1 mg/L</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Nitrates (NO₃⁻)</span>
                        <span class="font-bold text-cyan-400">0.00 mg/L</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center text-slate-300">
                        <span>Microplastics & Synthetic Compounds</span>
                        <span class="font-bold text-cyan-400">0.00% (Not Detected)</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono text-slate-400 flex flex-col sm:flex-row justify-between gap-2">
                    <span>TESTING METHOD: ICP-MS MASS SPECTROMETRY</span>
                    <span>SOURCE TERMINUS: ARCTIC LATITUDE 64° 08' N</span>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     5. CONCIERGE CALL TO ACTION
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gradient-to-b from-glaciar-obsidian to-black text-white relative text-center gl-section-reveal">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 gl-section-header">
        
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/15 backdrop-blur-md">
            <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">LIMITED SEASONAL ALLOCATION</span>
        </div>

        <h2 class="text-[clamp(2.2rem,5vw,4.2rem)] font-black tracking-tight leading-tight text-white">
            EXPERIENCE THE PURITY OF<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">ANCIENT GLACIERS.</span>
        </h2>

        <p class="text-slate-300 text-sm sm:text-base font-light max-w-xl mx-auto leading-relaxed">
            Reserve your allocation of Glaciar crystal diamond vessels today. Delivered under sub-zero cold-chain transport directly to your private residence or corporate estate.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 pt-4 gl-reveal-item">
            <a href="{{ route('shop') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white hover:bg-cyan-200 text-slate-950 font-bold text-xs font-mono tracking-wider uppercase whitespace-nowrap shadow-[0_0_25px_rgba(255,255,255,0.45)] hover:shadow-[0_0_35px_rgba(56,189,248,0.7)] transition-all duration-300 min-h-[48px]">
                <span>Enter The Boutique (Shop)</span>
                <svg class="w-4 h-4 ml-2.5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <a href="{{ route('collection') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs font-mono tracking-wider uppercase whitespace-nowrap border border-white/30 backdrop-blur-md transition-all duration-300 hover:border-white/60 min-h-[48px]">
                <span>The Vessel Collection</span>
            </a>
        </div>

    </div>
</section>

@endsection
