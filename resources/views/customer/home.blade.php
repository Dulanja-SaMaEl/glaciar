@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     PINNED 3D ARCTIC SANCTUARY SCROLL JOURNEY STAGE
     Apple-grade 240-frame 3D camera flight into the subterranean glacier
     with synchronized glassmorphic storytelling beats & live HUD telemetry.
     ═══════════════════════════════════════════════════════════════════ -->
<section id="glaciar-3d-stage" class="relative w-full min-h-[100dvh] h-[100dvh] overflow-hidden bg-[#020617] select-none">
    
    <!-- 3D Canvas Viewport (Perspective-Tilted by Pointer Movement) -->
    <div id="glaciar-3d-canvas-wrap" class="absolute inset-0 w-full h-full will-change-transform pointer-events-none z-0">
        <canvas id="glaciar-3d-canvas" class="w-full h-full block"></canvas>
    </div>

    <!-- Atmospheric Contrast & Vignette Overlays -->
    <div class="absolute inset-0 pointer-events-none z-10"
         style="background: radial-gradient(circle at center, transparent 40%, rgba(2,6,23,0.85) 100%);"></div>
    <div class="absolute inset-x-0 top-0 h-36 bg-gradient-to-b from-[#020617]/95 via-[#020617]/50 to-transparent pointer-events-none z-10"></div>
    <div class="absolute inset-x-0 bottom-0 h-44 bg-gradient-to-t from-[#020617] via-[#020617]/70 to-transparent pointer-events-none z-10"></div>

    <!-- ─────────────────────────────────────────────────────────────
         STORY BEAT 0: THE PRIMORDIAL CORE (HERO ENTRANCE)
         Visible at top of page (0% scroll)
         ───────────────────────────────────────────────────────────── -->
    <div id="gl-beat-0" class="absolute inset-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center pointer-events-none z-30 pt-20 sm:pt-24 pb-10">
        <div class="max-w-2xl space-y-6 pointer-events-auto">
            
            <h1 class="text-[clamp(2.6rem,6.4vw,6rem)] font-black tracking-tight leading-[0.92] text-white">
                SIP THE<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-sky-300 to-cyan-400 drop-shadow-[0_0_40px_rgba(56,189,248,0.6)]">DARK MYSTERY.</span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg lg:text-xl font-light leading-relaxed max-w-xl">
                Harvested from deep subterranean glacial chambers untouched since the pre-industrial age. Pure, unfiltered, and enriched with primordial minerals.
            </p>

            <!-- Action CTAs -->
            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ route('products.index') }}" 
                   class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-full bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-sm tracking-wider uppercase whitespace-nowrap shadow-[0_0_30px_rgba(56,189,248,0.6)] hover:shadow-[0_0_45px_rgba(56,189,248,0.85)] transition-all duration-300 min-h-[44px]">
                    <span class="whitespace-nowrap">Acquire Vessel</span>
                    <svg class="w-4 h-4 ml-2.5 text-slate-950 flex-shrink-0 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>

                <a href="#the-source" 
                   class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-full bg-white/10 hover:bg-white/20 text-white font-semibold text-sm tracking-wider uppercase whitespace-nowrap border border-white/30 backdrop-blur-md transition-all duration-300 hover:border-white/60 min-h-[44px]">
                    <span class="whitespace-nowrap">Explore Provenance</span>
                </a>
            </div>

            <!-- Trust Points (Clean Editorial Typography, No Clip-Art AI SVGs) -->
            <div class="pt-6 border-t border-white/10 flex flex-wrap items-center gap-4 sm:gap-6 text-xs font-mono tracking-wider text-slate-300 uppercase">
                <div class="flex items-center gap-2">
                    <span class="text-cyan-400 font-bold">100%</span>
                    <span class="text-slate-400">Sustainable Gravity Harvest</span>
                </div>
                <span class="hidden sm:inline text-white/20">|</span>
                <div class="flex items-center gap-2">
                    <span class="text-cyan-400 font-bold">7.4 pH</span>
                    <span class="text-slate-400">Natural Alkaline Balance</span>
                </div>
                <span class="hidden sm:inline text-white/20">|</span>
                <div class="flex items-center gap-2">
                    <span class="text-cyan-400 font-bold">0.00%</span>
                    <span class="text-slate-400">Zero Microplastics</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────
         STORY BEAT 1: THE SUBTERRANEAN SANCTUARY (DIVE IN PORTAL)
         Reveals during cavern dive (22% - 40% scroll)
         ───────────────────────────────────────────────────────────── -->
    <div id="gl-beat-1" class="absolute bottom-6 sm:bottom-8 lg:bottom-12 inset-x-4 sm:inset-x-6 lg:inset-x-auto lg:left-8 xl:left-16 max-w-sm xl:max-w-md bg-[#020617]/90 backdrop-blur-2xl p-5 sm:p-7 rounded-3xl border border-cyan-500/30 shadow-[0_25px_60px_rgba(0,0,0,0.85)] pointer-events-auto z-30 opacity-0">
        <div class="mb-3">
            <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">01 / SUBTERRANEAN DESCENT</span>
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-bold text-white tracking-tight mb-3">10,000-Year Glacier Strata</h3>
        <p class="text-xs lg:text-sm text-slate-300 leading-relaxed font-light">
            Descend 340 meters beneath ancient volcanic basalt into the permanent sub-zero permafrost sanctuary. Completely sealed from industrial atmospheric contact, synthetic contaminants, and microplastics.
        </p>
        <div class="mt-6 pt-4 border-t border-white/10 grid grid-cols-2 gap-4 text-[10px] font-mono text-slate-400 uppercase">
            <div>
                <span class="block text-slate-500">SANCTUARY ELEVATION</span>
                <span class="text-white font-bold text-xs">-340 METERS</span>
            </div>
            <div>
                <span class="block text-slate-500">ATMOSPHERIC CONTACT</span>
                <span class="text-cyan-400 font-bold text-xs">0.00% ZERO EXPOSURE</span>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────
         STORY BEAT 2: THE LIVING STREAM (MINERAL RIVER)
         Reveals along crystal melt river (48% - 70% scroll)
         Pinned to the left flank to keep the central/right bottle 100% clear.
         ───────────────────────────────────────────────────────────── -->
    <div id="gl-beat-2" class="absolute bottom-6 sm:bottom-8 lg:bottom-12 inset-x-4 sm:inset-x-6 lg:inset-x-auto lg:left-8 xl:left-16 max-w-sm xl:max-w-md bg-[#020617]/90 backdrop-blur-2xl p-5 sm:p-7 rounded-3xl border border-cyan-500/30 shadow-[0_25px_60px_rgba(0,0,0,0.85)] pointer-events-auto z-30 opacity-0">
        <div class="mb-3">
            <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">02 / THE LIVING STREAM</span>
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-bold text-white tracking-tight mb-3">Naturally Alkaline 7.4 pH</h3>
        <p class="text-xs lg:text-sm text-slate-300 leading-relaxed font-light">
            Slow-percolating through centuries of porous obsidian and volcanic strata. Naturally pressurized and gravity-fed into heavy flint glass without mechanical pumps or reverse-osmosis stripping.
        </p>
        <div class="mt-6 pt-4 border-t border-white/10 grid grid-cols-2 gap-4 text-[10px] font-mono text-slate-400 uppercase">
            <div>
                <span class="block text-slate-500">MINERAL DENSITY</span>
                <span class="text-white font-bold text-xs">42 MG/L TDS</span>
            </div>
            <div>
                <span class="block text-slate-500">COLLOIDAL SILICA</span>
                <span class="text-cyan-400 font-bold text-xs">14.2 MG/L LIVING</span>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────
         STORY BEAT 3: THE MONOLITH REVEALED (CULMINATION)
         Reveals at bottle macro climax (76% - 100% scroll)
         Pinned exclusively to the left flank — the bottle on the right
         remains completely clear, unobstructed, and framed across all viewports.
         ───────────────────────────────────────────────────────────── -->
    <div id="gl-beat-3" class="absolute inset-0 pointer-events-none z-30 opacity-0">
        
        <div class="absolute bottom-5 sm:bottom-8 lg:bottom-12 inset-x-4 sm:inset-x-6 lg:inset-x-auto lg:left-8 xl:left-16 max-w-sm sm:max-w-md lg:max-w-[400px] bg-[#020617]/90 backdrop-blur-2xl p-5 sm:p-6 rounded-3xl border border-cyan-400/40 shadow-[0_25px_60px_rgba(0,0,0,0.85)] pointer-events-auto">
            <div class="mb-2 flex items-center justify-between">
                <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">03 / VESSEL REVEAL</span>
                <span class="text-[10px] font-mono tracking-wider text-slate-400 uppercase px-2 py-0.5 rounded-full bg-white/5 border border-white/10">ACTIVE ALLOCATION</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-serif font-bold text-white tracking-tight mb-2">The Monolith Vessel</h3>
            <p class="text-xs text-slate-300 leading-relaxed font-light mb-3">
                Sculpted from heavy frosted flint glass with precision starburst facets that protect living mineral purity for 24 hours without artificial refrigeration. Every vessel is individually numbered and thermal-cocooned.
            </p>
            <div class="pt-2.5 border-t border-white/10 flex items-center justify-between text-[10px] font-mono text-slate-400 uppercase mb-4">
                <span>HEAVY FLINT GLASS</span>
                <span class="text-cyan-400 font-bold">100% INFINITE CYCLE</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('shop') }}" class="gl-magnetic flex-1 py-3 px-5 rounded-full bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-xs uppercase tracking-wider text-center shadow-[0_0_25px_rgba(56,189,248,0.5)] transition-all min-h-[44px] flex items-center justify-center">
                    Order Glaciar Vessel
                </a>
                <a href="#the-source" class="py-3 px-4 rounded-full bg-white/10 hover:bg-white/20 text-white font-mono text-xs uppercase border border-white/20 transition-all min-h-[44px] flex items-center justify-center">
                    Explore ↓
                </a>
            </div>
        </div>

    </div>

</section>

<!-- ─────────────────────────────────────────────────────────────
     TECHNICAL MARQUEE / TICKER (Transition into Section 02)
     Continuous left-moving marquee ticker
     ───────────────────────────────────────────────────────────── -->
<div class="bg-glaciar-obsidian border-y border-white/10 py-4 overflow-hidden select-none relative z-30 w-full">
    <div class="animate-marquee-left flex gap-12 whitespace-nowrap">
        @php
            $tickerItems = [
                'NATURAL ARCTIC GLACIER WATER',
                '10,000-YEAR PRIMORDIAL STRATA',
                'DIAMOND-FACETED FLINT GLASS VESSEL',
                'NATURAL ALKALINE 7.4 PH BALANCE',
                'ZERO MICROPLASTICS GUARANTEE',
                'INFUSED WITH BIO-AVAILABLE SILICA',
                '100% INFINITE CLOSED-LOOP RECYCLE',
                'BOTTLED AT SOURCE · 1,890M ALTITUDE',
            ];
        @endphp
        @foreach(array_merge($tickerItems, $tickerItems, $tickerItems, $tickerItems) as $item)
            <span class="inline-flex items-center gap-4 text-[11px] font-mono font-semibold tracking-ultra text-slate-400 uppercase">
                <span class="text-cyan-400/60 font-mono text-[9px]">//</span>
                {{ $item }}
            </span>
        @endforeach
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════════════
     2. THE SOURCE SECTION ("THE SANCTUARY OF ETERNAL ICE")
     ═══════════════════════════════════════════════════════════════════ -->
<section id="the-source" class="py-32 bg-glaciar-obsidian text-white relative z-30 overflow-hidden border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            
            <!-- Left Statement -->
            <div class="lg:col-span-6 space-y-8 gl-section-header">
                <div class="mb-2">
                    <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">02 / PROVENANCE & HARVESTING</span>
                </div>

                <h2 class="text-[clamp(2.5rem,5vw,4.5rem)] font-black tracking-tight leading-[0.96] text-white">
                    HARVESTED AT<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">1,890 METERS.</span>
                </h2>

                <p class="text-slate-300 text-base sm:text-lg font-light leading-relaxed">
                    Centuries before the industrial era, pristine snowfall was compressed into crystalline ice layers high in the Arctic sanctuary. Today, Glaciar collects pure meltwater right at the glacier’s terminus before it ever contacts groundwater contamination.
                </p>

                <div class="space-y-4 pt-2">
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-md gl-reveal-item">
                        <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center flex-shrink-0 mt-0.5 font-mono text-xs font-bold">
                            01
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Gravity-Fed Bottling</h4>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Zero mechanical pumping. The water flows naturally through sterile stainless steel conduits directly into heavy flint glass.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-md gl-reveal-item">
                        <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center flex-shrink-0 mt-0.5 font-mono text-xs font-bold">
                            02
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Zero Chemical Treatment</h4>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">No chlorine, no ozone alteration, and no municipal reverse-osmosis stripping. The minerals remain in their living state.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Telemetry Grid -->
            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-2xl flex flex-col justify-between gl-reveal-item">
                    <div>
                        <span class="text-xs font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-4">ALTITUDE</span>
                        <div class="text-4xl font-black text-white tracking-tight mb-2">1,890m</div>
                        <p class="text-xs text-slate-300 leading-relaxed font-light">
                            High-altitude collection point surrounded by permanent permafrost.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono uppercase text-slate-400">
                        VOLCANIC STRATA
                    </div>
                </div>

                <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-2xl flex flex-col justify-between gl-reveal-item">
                    <div>
                        <span class="text-xs font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-4">PURITY RATING</span>
                        <div class="text-4xl font-black text-white tracking-tight mb-2">0.00%</div>
                        <p class="text-xs text-slate-300 leading-relaxed font-light">
                            Zero microplastics, zero heavy metals, and zero pesticide runoff.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono uppercase text-slate-400">
                        WHO COMPLIANT
                    </div>
                </div>

                <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-2xl flex flex-col justify-between gl-reveal-item">
                    <div>
                        <span class="text-xs font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-4">BOTTLING TEMP</span>
                        <div class="text-4xl font-black text-white tracking-tight mb-2">-12°C</div>
                        <p class="text-xs text-slate-300 leading-relaxed font-light">
                            Chilled naturally by glacial subterranean conduits at packaging.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono uppercase text-slate-400">
                        SUB-ZERO BOTTLING
                    </div>
                </div>

                <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-2xl flex flex-col justify-between gl-reveal-item">
                    <div>
                        <span class="text-xs font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-4">ICE STRATA AGE</span>
                        <div class="text-4xl font-black text-white tracking-tight mb-2">10,000 Y</div>
                        <p class="text-xs text-slate-300 leading-relaxed font-light">
                            Ancient Pleistocene epoch glacial core formations.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-white/10 text-[10px] font-mono uppercase text-slate-400">
                        PRE-INDUSTRIAL ICE
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     3. THE WATER SECTION ("MINERAL ARCHITECTURE & SENSORY PROFILE")
     ═══════════════════════════════════════════════════════════════════ -->
<section id="the-water" class="py-32 bg-glaciar-horizon text-white relative overflow-hidden border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-3xl mx-auto mb-20 gl-section-header">
            <div class="mb-3">
                <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">03 / MINERAL ARCHITECTURE</span>
            </div>
            <h2 class="text-[clamp(2.5rem,5.2vw,4.8rem)] font-black tracking-tight leading-[0.96] text-white">
                THE SENSORY<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">MOUTHFEEL.</span>
            </h2>
            <p class="mt-6 text-slate-200 text-base sm:text-lg font-light leading-relaxed">
                Light, crisp, and silk-smooth. Glaciar possesses a uniquely balanced mineral footprint that refreshes the palate without drying tannins or chalky residues.
            </p>
        </div>

        <!-- 4 Mineral Telemetry Pillars -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-xl hover:border-cyan-400/50 transition-all duration-500 gl-reveal-item">
                <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">ALKALINE BALANCE</span>
                <div class="text-4xl font-black text-white tracking-tight mb-2">pH 7.4</div>
                <p class="text-xs text-slate-300 leading-relaxed font-light">
                    Matches the natural biological equilibrium of human cellular fluid for rapid assimilation.
                </p>
            </div>

            <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-xl hover:border-cyan-400/50 transition-all duration-500 gl-reveal-item">
                <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">TOTAL DISSOLVED SOLIDS</span>
                <div class="text-4xl font-black text-white tracking-tight mb-2">42 mg/L</div>
                <p class="text-xs text-slate-300 leading-relaxed font-light">
                    Exceptionally low TDS creating a featherlight, silky viscosity on the tongue.
                </p>
            </div>

            <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-xl hover:border-cyan-400/50 transition-all duration-500 gl-reveal-item">
                <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">COLLOIDAL SILICA</span>
                <div class="text-4xl font-black text-white tracking-tight mb-2">14.2 mg/L</div>
                <p class="text-xs text-slate-300 leading-relaxed font-light">
                    Promotes collagen production, cellular renewal, and neurological vitality.
                </p>
            </div>

            <div class="bg-glaciar-obsidian/80 backdrop-blur-xl p-8 rounded-2xl border border-white/15 shadow-xl hover:border-cyan-400/50 transition-all duration-500 gl-reveal-item">
                <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">ELECTROLYTE RATIO</span>
                <div class="text-4xl font-black text-white tracking-tight mb-2">2.8 : 1</div>
                <p class="text-xs text-slate-300 leading-relaxed font-light">
                    Perfect elemental synergy between dissolved calcium and bio-available magnesium.
                </p>
            </div>

        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     4. THE COLLECTION SECTION ("CHOOSE YOUR VESSEL")
     ═══════════════════════════════════════════════════════════════════ -->
<section id="collection" class="py-32 bg-glaciar-obsidian text-white relative overflow-hidden border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gl-section-header">
            <div>
                <div class="mb-3">
                    <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">04 / THE COLLECTION</span>
                </div>
                <h2 class="text-[clamp(2.5rem,5vw,4.5rem)] font-black tracking-tight leading-[0.96] text-white">
                    CHOOSE YOUR<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">GLACIAR VESSEL.</span>
                </h2>
            </div>
            
            <div class="mt-6 md:mt-0 flex items-center gap-5">
                <a href="{{ route('collection') }}" class="inline-flex items-center gap-1.5 text-xs font-mono font-bold uppercase tracking-widest text-slate-300 hover:text-white transition-colors">
                    <span>Vessel Craft</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 text-xs font-mono font-bold uppercase tracking-widest text-cyan-300 hover:text-white transition-colors group">
                    <span>Shop All Formats</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <!-- Featured Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProducts as $product)
                <div class="gl-card-3d bg-glaciar-obsidian/90 rounded-2xl border border-white/15 p-6 flex flex-col justify-between hover:border-cyan-400/60 shadow-2xl transition-all duration-500 group relative gl-reveal-item">
                    
                    <!-- Volume Tag -->
                    <div class="flex items-center justify-between text-[11px] font-mono text-slate-400 uppercase mb-4">
                        <span class="px-2.5 py-1 rounded-full bg-white/5 border border-white/10 text-cyan-300 font-bold">
                            {{ $product->volume ?? $product->size_ml ?? '750' }} ML
                        </span>
                        <span class="text-slate-400">FLINT GLASS</span>
                    </div>

                    <!-- Product Image Stage with Shimmer -->
                    <div class="relative aspect-[3/4] flex items-center justify-center p-6 overflow-hidden rounded-xl bg-gradient-to-b from-white/5 to-transparent my-4">
                        <img src="{{ asset('images/hero/glaciar-crystal-bottle.png') }}" 
                             alt="{{ $product->name }}" 
                             class="product-card-image max-h-full object-contain filter drop-shadow-[0_20px_35px_rgba(4,15,45,0.6)] group-hover:scale-105 transition-transform duration-500" />
                    </div>

                    <!-- Info & Action -->
                    <div class="space-y-4 pt-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-white group-hover:text-cyan-300 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-slate-400 mt-1 line-clamp-2">
                                    {{ $product->description ?? 'Natural glacier water encased in heavy diamond-cut crystal glass.' }}
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0 ml-3">
                                <span class="text-xl font-black text-white">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Real Add-to-Cart Action -->
                        <div class="flex items-center gap-3 pt-2">
                            <form action="{{ route('cart.store') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" 
                                        class="gl-magnetic w-full py-3 px-4 rounded-xl bg-cyan-500/20 hover:bg-cyan-500 text-cyan-300 hover:text-glaciar-obsidian border border-cyan-400/40 text-xs font-bold uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-2 min-h-[44px]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>

                            <a href="{{ route('products.show', $product) }}" 
                               class="p-3 rounded-xl bg-white/5 hover:bg-white/10 text-white border border-white/10 transition-colors flex-shrink-0 min-h-[44px] min-w-[44px] flex items-center justify-center"
                               title="View Specifications">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    <p>No products available currently.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     5. OUR PHILOSOPHY & SUSTAINABILITY ("CLOSED-LOOP STEWARDSHIP")
     ═══════════════════════════════════════════════════════════════════ -->
<section id="sustainability" class="py-32 bg-glaciar-obsidian text-white relative overflow-hidden border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="max-w-3xl mb-20 gl-section-header">
            <div class="mb-3">
                <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">05 / PHILOSOPHY & STEWARDSHIP</span>
            </div>
            <h2 class="text-[clamp(2.5rem,5vw,4.5rem)] font-black tracking-tight leading-[0.96] text-white">
                CIRCULAR BY<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">DESIGN.</span>
            </h2>
            <p class="mt-6 text-slate-300 text-base sm:text-lg font-light leading-relaxed">
                We believe water should never come at the cost of the planet. Every Glaciar vessel is made of infinitely recyclable flint glass and supported by our doorstep replenishment program.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="p-8 rounded-2xl bg-white/[0.03] border border-white/10 space-y-4 backdrop-blur-md gl-reveal-item">
                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center font-mono text-sm font-bold">
                    01
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-wider">100% Closed Loop</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-light">
                    Return your empty bottles in our thermal transport crates. Each vessel is sterilized and refilled up to 50 times.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white/[0.03] border border-white/10 space-y-4 backdrop-blur-md gl-reveal-item">
                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center font-mono text-sm font-bold">
                    02
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-wider">Ocean Plastic Offset</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-light">
                    For every liter of Glaciar delivered, we remove 50 ocean-bound single-use plastic bottles through certified coastal recovery programs.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white/[0.03] border border-white/10 space-y-4 backdrop-blur-md gl-reveal-item">
                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center justify-center font-mono text-sm font-bold">
                    03
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-wider">Carbon-Negative Bottling</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-light">
                    Our bottling facility operates on 100% localized geothermal and hydroelectric energy with zero municipal grid drain.
                </p>
            </div>

        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     6. SOMMELIER ENDORSEMENTS & EDITORIAL REVIEWS
     ═══════════════════════════════════════════════════════════════════ -->
<section id="philosophy" class="py-32 bg-glaciar-horizon text-white relative overflow-hidden border-b border-white/10 gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-2xl mx-auto mb-16 gl-section-header">
            <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">CRITICAL ACCLAIM</span>
            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white tracking-tight">
                "Water that cleanses the palate like winter dawn."
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            
            <div class="p-8 rounded-2xl bg-glaciar-obsidian/85 backdrop-blur-xl border border-white/15 shadow-xl space-y-4 gl-reveal-item">
                <div class="text-xs font-mono uppercase tracking-widest text-cyan-400 font-bold">
                    TERROIR COMPATIBILITY · SCORE 99/100
                </div>
                <p class="text-sm text-slate-200 leading-relaxed font-light italic">
                    "Glaciar represents an entirely new standard in water architecture. The diamond faceted bottle commands any fine dining table, while the silky, light 42 mg/L TDS allows the terroir of our vintage wines to sing."
                </p>
                <div class="pt-3 border-t border-white/10">
                    <p class="text-xs font-bold text-white uppercase tracking-wider">Chef Antoine Laurent</p>
                    <p class="text-[11px] text-slate-400">Three-Star Michelin Culinary Director, Lyon</p>
                </div>
            </div>

            <div class="p-8 rounded-2xl bg-glaciar-obsidian/85 backdrop-blur-xl border border-white/15 shadow-xl space-y-4 gl-reveal-item">
                <div class="text-xs font-mono uppercase tracking-widest text-cyan-400 font-bold">
                    MINERAL EQUILIBRIUM · GOLD MEDAL
                </div>
                <p class="text-sm text-slate-200 leading-relaxed font-light italic">
                    "Finally, water that treats hydration as a high craft rather than an afterthought. The sub-zero temperature retention is astounding, and the natural alkaline pH feels extraordinarily crisp."
                </p>
                <div class="pt-3 border-t border-white/10">
                    <p class="text-xs font-bold text-white uppercase tracking-wider">Elena Rostova</p>
                    <p class="text-[11px] text-slate-400">Certified International Water Sommelier, Zurich</p>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════
     7. FINAL CALL TO ACTION ("TASTE PURE ARCTIC ICE")
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-28 bg-glaciar-obsidian text-white relative overflow-hidden text-center gl-section-reveal">
    <!-- Ambient Flare -->
    <div class="absolute inset-0 bg-radial-gradient from-cyan-500/15 via-transparent to-transparent blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8 gl-section-header">
        <span class="text-[11px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block">
            LIMITED SEASONAL ALLOCATION
        </span>

        <h2 class="text-[clamp(2.5rem,5.5vw,5rem)] font-black tracking-tight leading-[0.96] text-white">
            TASTE THE PURITY OF<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-sky-200 to-cyan-400">ANCIENT GLACIERS.</span>
        </h2>

        <p class="text-slate-300 text-base sm:text-lg font-light max-w-xl mx-auto">
            Reserve your Glaciar crystal vessel or subscribe to weekly doorstep replenishment.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
            <a href="{{ route('products.index') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-10 py-4 rounded-full bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-sm tracking-wider uppercase shadow-[0_0_30px_rgba(56,189,248,0.5)] hover:shadow-[0_0_40px_rgba(56,189,248,0.8)] transition-all duration-300 min-h-[44px]">
                <span>Explore The Collection</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <a href="{{ route('cart.index') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-full bg-white/10 hover:bg-white/15 text-white font-medium text-sm tracking-wider uppercase border border-white/20 backdrop-blur-md transition-all min-h-[44px]">
                <span>View Cart & Checkout</span>
            </a>
        </div>
    </div>
</section>

@endsection