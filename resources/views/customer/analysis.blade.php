@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO: INDEPENDENT LABORATORY CERTIFICATION
     ═══════════════════════════════════════════════════════════════════ -->
<section class="relative bg-glaciar-obsidian text-white pt-28 pb-24 border-b border-white/10 overflow-hidden select-none min-h-[85vh] flex items-center gl-section-reveal"
         style="background-image: url('{{ asset('images/hero/glaciar-aurora-bg.jpg') }}'); background-size: cover; background-position: center 20%;">
    
    <div class="absolute inset-0 bg-gradient-to-r from-glaciar-obsidian/95 via-glaciar-obsidian/85 to-glaciar-obsidian/75 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-glaciar-obsidian via-transparent to-glaciar-obsidian/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-3xl space-y-6 gl-section-header">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                    01 / INDEPENDENT LABORATORY TELEMETRY
                </span>
            </div>

            <h1 class="text-[clamp(2.4rem,6vw,5.2rem)] font-black tracking-tight leading-[0.94] text-white">
                PURITY VERIFIED TO<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300 drop-shadow-[0_0_35px_rgba(56,189,248,0.4)]">
                    0.00% ADDITIVES.
                </span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                Certified under ISO 17025 accredited mass spectrometry testing. Glaciar represents the gold standard of living mineral architecture, complete elemental transparency, and zero chemical interference.
            </p>

            <!-- Key Test Benchmarks -->
            <div class="pt-6 border-t border-white/15 grid grid-cols-2 sm:grid-cols-4 gap-6 font-mono text-xs gl-reveal-item">
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">TOTAL SOLIDS (TDS)</span>
                    <span class="font-bold text-cyan-300 text-sm sm:text-base">42 MG/L (ULTRA-LIGHT)</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">PH EQUILIBRIUM</span>
                    <span class="font-bold text-white text-sm sm:text-base">7.4 ALKALINE</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">COLLOIDAL SILICA</span>
                    <span class="font-bold text-cyan-300 text-sm sm:text-base">14.2 MG/L</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">PFAS / MICROPLASTICS</span>
                    <span class="font-bold text-cyan-400 text-sm sm:text-base">0.00% NOT DETECTED</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     2. ELEMENTAL LABORATORY MATRIX (MASS SPECTROMETRY)
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 sm:py-28 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-20 gl-section-header">
            <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">
                02 / COMPLETE CHEMICAL BREAKDOWN
            </span>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                CERTIFIED MINERAL<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">ARCHITECTURE.</span>
            </h2>
            <p class="text-slate-400 text-xs sm:text-sm font-light mt-3">
                Verified via Inductively Coupled Plasma Mass Spectrometry (ICP-MS) at an independent Nordic certified laboratory.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Table 1: Essential Cations -->
            <div class="p-8 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl space-y-6 gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase tracking-widest text-cyan-300 block mb-1">GROUP I</span>
                    <h3 class="text-xl font-bold text-white">Vital Cations & Electrolytes</h3>
                    <p class="text-xs text-slate-400 font-light mt-1">Naturally dissolved under volcanic subterranean pressure for cellular hydration.</p>
                </div>

                <div class="divide-y divide-white/10 text-xs font-mono">
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Calcium (Ca²⁺)</span>
                        <span class="font-bold text-white">12.4 mg/L</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Magnesium (Mg²⁺)</span>
                        <span class="font-bold text-white">4.4 mg/L</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Potassium (K⁺)</span>
                        <span class="font-bold text-white">1.1 mg/L</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Sodium (Na⁺)</span>
                        <span class="font-bold text-cyan-300">2.1 mg/L (Ultra-Low)</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-white/10 text-[10px] font-mono text-slate-400 uppercase">
                    OPTIMAL CALCIUM-MAGNESIUM 2.8:1 RATIO
                </div>
            </div>

            <!-- Table 2: Structural Anions -->
            <div class="p-8 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl space-y-6 gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase tracking-widest text-cyan-300 block mb-1">GROUP II</span>
                    <h3 class="text-xl font-bold text-white">Bio-Active Anions & Silica</h3>
                    <p class="text-xs text-slate-400 font-light mt-1">Colloidal structures promoting collagen regeneration and velvety mouthfeel.</p>
                </div>

                <div class="divide-y divide-white/10 text-xs font-mono">
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Colloidal Silica (SiO₂)</span>
                        <span class="font-bold text-cyan-300">14.2 mg/L</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Bicarbonates (HCO₃⁻)</span>
                        <span class="font-bold text-white">38.0 mg/L</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Sulfates (SO₄²⁻)</span>
                        <span class="font-bold text-white">4.8 mg/L</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Chlorides (Cl⁻)</span>
                        <span class="font-bold text-white">3.2 mg/L</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-white/10 text-[10px] font-mono text-slate-400 uppercase">
                    NATURAL ACID-BUFFERING CAPACITY
                </div>
            </div>

            <!-- Table 3: Purity & Zero Contaminants -->
            <div class="p-8 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl space-y-6 gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase tracking-widest text-cyan-300 block mb-1">GROUP III</span>
                    <h3 class="text-xl font-bold text-white">Contaminants & Synthetics</h3>
                    <p class="text-xs text-slate-400 font-light mt-1">Continuous laboratory screening for industrial runoff and micro-pollutants.</p>
                </div>

                <div class="divide-y divide-white/10 text-xs font-mono">
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Nitrates (NO₃⁻)</span>
                        <span class="font-bold text-cyan-400">0.00 mg/L (Zero Runoff)</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Heavy Metals (Pb, As, Cd)</span>
                        <span class="font-bold text-cyan-400">&lt; 0.001 mg/L (None)</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>Microplastics</span>
                        <span class="font-bold text-cyan-400">0.00 particles/L</span>
                    </div>
                    <div class="py-3 flex justify-between items-center text-slate-300">
                        <span>PFAS / "Forever Chemicals"</span>
                        <span class="font-bold text-cyan-400">0.00 ng/L (Undetected)</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-white/10 text-[10px] font-mono text-cyan-300 uppercase font-bold">
                    WHO & FDA ULTRA-PURE ACCREDITATION
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     3. SOMMELIER TASTING PROFILE & GASTRONOMIC PAIRING
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 sm:py-28 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <div class="lg:col-span-6 space-y-6 gl-section-header">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                        03 / SENSORY SCIENCE
                    </span>
                </div>
                
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white leading-tight">
                    Engineered to Complement Fine Gastronomy.
                </h2>
                
                <p class="text-slate-300 text-sm font-light leading-relaxed">
                    Unlike municipal tap or heavily mineralized waters (TDS &gt; 300 mg/L) that coat the tongue in chalky bicarbonates, Glaciar’s ultra-light TDS of 42 mg/L acts as an immaculate palate cleanser. It leaves olfactory and gustatory receptors completely unobstructed.
                </p>

                <div class="space-y-4 pt-2">
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 gl-reveal-item">
                        <span class="text-xs font-bold text-white block uppercase tracking-wider mb-1 font-mono">Fine Vintage Wine Pairing</span>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">Neutralizes high tannins without altering delicate terroir notes or fruit acidity.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 gl-reveal-item">
                        <span class="text-xs font-bold text-white block uppercase tracking-wider mb-1 font-mono">Grand Cru Caviar & Raw Seafood</span>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">Accentuates natural salinity and delicate umami textures without metallic interference.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 gl-reveal-item">
                <div class="p-8 sm:p-10 rounded-3xl bg-slate-900 border border-white/15 relative overflow-hidden shadow-2xl">
                    <span class="text-[10px] font-mono uppercase text-cyan-300 font-bold block mb-4">CRITICAL ENDORSEMENT</span>
                    <blockquote class="text-xl sm:text-2xl font-serif text-white italic leading-relaxed mb-6">
                        "Glaciar represents an entirely new standard in water architecture. The diamond faceted bottle commands any fine dining table, while the silky, light 42 mg/L TDS allows the terroir of our vintage wines to sing."
                    </blockquote>
                    <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                        <div class="w-10 h-10 rounded-full bg-cyan-400/20 text-cyan-300 flex items-center justify-center font-bold font-serif">
                            AL
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white uppercase tracking-wider">Chef Antoine Laurent</h4>
                            <p class="text-xs text-slate-400 font-mono">Three-Star Michelin Culinary Director, Lyon</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     4. CERTIFICATE OF ANALYSIS & BATCH LOOKUP
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gradient-to-b from-glaciar-obsidian to-black text-white relative text-center gl-section-reveal">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 gl-section-header">
        
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/15 backdrop-blur-md">
            <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">BATCH TELEMETRY AUTHENTICATION</span>
        </div>

        <h2 class="text-[clamp(2.2rem,5vw,4.2rem)] font-black tracking-tight leading-tight text-white">
            EVERY VESSEL TRACEABLE TO<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">ITS ARCTIC SOURCE.</span>
        </h2>

        <p class="text-slate-300 text-sm sm:text-base font-light max-w-xl mx-auto leading-relaxed">
            Every Glaciar flint glass bottle is laser-engraved with an immutable serial number on its metallic neck ring. Reserve your batch or speak directly with our sommelier concierge.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 pt-4 gl-reveal-item">
            <a href="{{ route('shop') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white hover:bg-cyan-200 text-slate-950 font-bold text-xs font-mono tracking-wider uppercase whitespace-nowrap shadow-[0_0_25px_rgba(255,255,255,0.45)] hover:shadow-[0_0_35px_rgba(56,189,248,0.7)] transition-all duration-300 min-h-[48px]">
                <span>Pre-Order Certified Allocation</span>
                <svg class="w-4 h-4 ml-2.5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <a href="{{ route('contact') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs font-mono tracking-wider uppercase whitespace-nowrap border border-white/30 backdrop-blur-md transition-all duration-300 hover:border-white/60 min-h-[48px]">
                <span>Request Lab Certificate (CoA)</span>
            </a>
        </div>

    </div>
</section>

@endsection
