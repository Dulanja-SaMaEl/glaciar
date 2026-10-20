@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO: CIRCULAR ECOLOGY & ARCTIC STEWARDSHIP
     ═══════════════════════════════════════════════════════════════════ -->
<section class="relative bg-glaciar-obsidian text-white pt-28 pb-24 border-b border-white/10 overflow-hidden select-none min-h-[85vh] flex items-center gl-section-reveal"
         style="background-image: url('{{ asset('images/hero/glaciar-aurora-bg.jpg') }}'); background-size: cover; background-position: center 30%;">
    
    <div class="absolute inset-0 bg-gradient-to-r from-glaciar-obsidian/95 via-glaciar-obsidian/85 to-glaciar-obsidian/75 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-glaciar-obsidian via-transparent to-glaciar-obsidian/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-3xl space-y-6 gl-section-header">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                    01 / CIRCULAR ECOLOGY & ARCTIC STEWARDSHIP
                </span>
            </div>

            <h1 class="text-[clamp(2.4rem,6vw,5.2rem)] font-black tracking-tight leading-[0.94] text-white">
                CIRCULAR BY DESIGN.<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300 drop-shadow-[0_0_35px_rgba(56,189,248,0.4)]">
                    PROTECTING THE ICE.
                </span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                We believe water consumption must never compromise the ecosystems that produce it. Glaciar operates an uncompromising closed-loop lifecycle, 100% alpine renewable bottling, and active permafrost restoration.
            </p>

            <!-- Key Impact Metrics -->
            <div class="pt-6 border-t border-white/15 grid grid-cols-2 sm:grid-cols-4 gap-6 font-mono text-xs gl-reveal-item">
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">REFILL CYCLES</span>
                    <span class="font-bold text-cyan-300 text-sm sm:text-base">50X PER VESSEL</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">PLASTIC CONTENT</span>
                    <span class="font-bold text-white text-sm sm:text-base">0.00% ZERO</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">FACILITY ENERGY</span>
                    <span class="font-bold text-cyan-300 text-sm sm:text-base">100% HYDROELECTRIC</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] tracking-wider uppercase mb-1">PLASTIC OFFSET</span>
                    <span class="font-bold text-white text-sm sm:text-base">50:1 RATIO</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     2. THE 5-STAGE CLOSED-LOOP VESSEL LIFECYCLE
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 sm:py-28 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-20 gl-section-header">
            <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-3">
                02 / THE CLOSED-LOOP PROTOCOL
            </span>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                HOW DOORSTEP<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">RECIRCULATION WORKS.</span>
            </h2>
            <p class="text-slate-400 text-xs sm:text-sm font-light mt-3">
                From sub-zero bottling to doorstep courier exchange, every diamond-faceted vessel is designed for infinite stewardship.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6">
            
            <!-- Step 1 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-xl flex flex-col justify-between gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase text-cyan-400 font-bold block mb-2">STAGE 01</span>
                    <h3 class="text-base font-bold text-white mb-2">Cold-Chain Dispatch</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Flint glass vessels arrive at your estate inside thermal insulated storage crates at ≤ 4°C.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-white/10 text-[10px] font-mono text-slate-400 uppercase">
                    THERMAL LOCKERS
                </div>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-xl flex flex-col justify-between gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase text-cyan-400 font-bold block mb-2">STAGE 02</span>
                    <h3 class="text-base font-bold text-white mb-2">In-Home Decanting</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Enjoy living alkaline glacier water. Starburst facets keep the carafe frosty for hours at your dining table.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-white/10 text-[10px] font-mono text-slate-400 uppercase">
                    SUB-ZERO CHILL
                </div>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-xl flex flex-col justify-between gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase text-cyan-400 font-bold block mb-2">STAGE 03</span>
                    <h3 class="text-base font-bold text-white mb-2">Doorstep Retrieval</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Place empties back in the thermal crate. Our couriers collect them seamlessly during your next scheduled run.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-white/10 text-[10px] font-mono text-slate-400 uppercase">
                    100% ZERO HASSLE
                </div>
            </div>

            <!-- Step 4 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-xl flex flex-col justify-between gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase text-cyan-400 font-bold block mb-2">STAGE 04</span>
                    <h3 class="text-base font-bold text-white mb-2">Glacial Steam Sterilization</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Vessels undergo 140°C pressurized pure glacial steam sanitization in Class 5 cleanrooms with zero synthetic detergents.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-white/10 text-[10px] font-mono text-slate-400 uppercase">
                    ISO CLASS 5 FACILITY
                </div>
            </div>

            <!-- Step 5 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-xl flex flex-col justify-between gl-reveal-item">
                <div>
                    <span class="text-[10px] font-mono uppercase text-cyan-400 font-bold block mb-2">STAGE 05</span>
                    <h3 class="text-base font-bold text-white mb-2">Gravity Refill & Seal</h3>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">
                        Refilled at source under vacuum closure, verified via laser inspection, and re-dispatched into circulation.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-white/10 text-[10px] font-mono text-slate-400 uppercase">
                    UP TO 50 CYCLES
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     3. CARBON-NEGATIVE BOTTLING & ARCTIC TRUST
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 sm:py-28 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <div class="lg:col-span-6 space-y-6 gl-section-header">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                        03 / ZERO EMISSIONS
                    </span>
                </div>
                
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white leading-tight">
                    Alpine Hydroelectricity & Zero Municipal Strain.
                </h2>
                
                <p class="text-slate-300 text-sm font-light leading-relaxed">
                    Our high-altitude bottling sanctuary operates completely off-grid. Mechanical power is generated exclusively by natural alpine gravity-fed run-of-the-river hydroelectric micro-turbines, which return 100% of diverted flow unharmed back to the mountain stream.
                </p>

                <div class="space-y-4 pt-2">
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 gl-reveal-item">
                        <span class="text-xs font-bold text-white block uppercase tracking-wider mb-1 font-mono">Ocean Bound Plastic Offset</span>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">
                            For every liter of Glaciar delivered, our foundation funds the removal of 50 single-use plastic bottles from global marine estuaries through certified coastal recovery partners.
                        </p>
                    </div>

                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 gl-reveal-item">
                        <span class="text-xs font-bold text-white block uppercase tracking-wider mb-1 font-mono">The Arctic Glacier Trust</span>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">
                            2% of our top-line proceeds are endowed directly into the Nordic Glaciological Institute to fund permanent satellite permafrost thickness monitoring and glacial preservation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 gl-reveal-item">
                <div class="p-6 sm:p-10 rounded-3xl bg-white/[0.04] border border-white/15 backdrop-blur-2xl shadow-2xl space-y-6">
                    <div class="flex items-center justify-between pb-6 border-b border-white/10">
                        <div>
                            <span class="text-[10px] font-mono uppercase tracking-widest text-cyan-300 block">ECOLOGICAL SCORECARD</span>
                            <h3 class="text-lg font-bold text-white">Annual Sustainability Audit</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-cyan-400/10 border border-cyan-400/30 text-[10px] font-mono uppercase text-cyan-300 font-bold">
                            CARBON NEGATIVE
                        </span>
                    </div>

                    <div class="divide-y divide-white/10 text-xs font-mono">
                        <div class="py-3 flex justify-between items-center text-slate-300">
                            <span>Primary Vessel Material</span>
                            <span class="font-bold text-white">Flint Glass (Type III)</span>
                        </div>
                        <div class="py-3 flex justify-between items-center text-slate-300">
                            <span>Vessel Recyclability</span>
                            <span class="font-bold text-cyan-300">100% Infinite Recirculation</span>
                        </div>
                        <div class="py-3 flex justify-between items-center text-slate-300">
                            <span>Cap & Closure Metallurgy</span>
                            <span class="font-bold text-white">Anodized Aerospace Aluminum</span>
                        </div>
                        <div class="py-3 flex justify-between items-center text-slate-300">
                            <span>Packaging Secondary Waste</span>
                            <span class="font-bold text-cyan-400">0.00% Single-Use Plastics</span>
                        </div>
                        <div class="py-3 flex justify-between items-center text-slate-300">
                            <span>Sanitization Medium</span>
                            <span class="font-bold text-white">Glacial Steam (Chemical-Free)</span>
                        </div>
                        <div class="py-3 flex justify-between items-center text-slate-300">
                            <span>Direct Courier Fleet</span>
                            <span class="font-bold text-cyan-300">100% Electric Cold-Chain</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/10 text-[10px] font-mono text-slate-400 flex flex-col sm:flex-row justify-between gap-2">
                        <span>CERTIFIED ISO 14001:2015</span>
                        <span>NET ZERO CO₂ ACCREDITED</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     4. CALL TO ACTION
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-gradient-to-b from-glaciar-obsidian to-black text-white relative text-center gl-section-reveal">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 gl-section-header">
        
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/15 backdrop-blur-md">
            <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">JOIN THE CLOSED-LOOP REVOLUTION</span>
        </div>

        <h2 class="text-[clamp(2.2rem,5vw,4.2rem)] font-black tracking-tight leading-tight text-white">
            DRINK PURE GLACIAL WATER.<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300">LEAVE ZERO TRACE.</span>
        </h2>

        <p class="text-slate-300 text-sm sm:text-base font-light max-w-xl mx-auto leading-relaxed">
            Begin your recurring doorstep replenishment allocation today. Insulated crates and empty vessel returns are handled effortlessly by our white-glove team.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 pt-4 gl-reveal-item">
            <a href="{{ route('shop') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white hover:bg-cyan-200 text-slate-950 font-bold text-xs font-mono tracking-wider uppercase whitespace-nowrap shadow-[0_0_25px_rgba(255,255,255,0.45)] hover:shadow-[0_0_35px_rgba(56,189,248,0.7)] transition-all duration-300 min-h-[48px]">
                <span>Start Closed-Loop Subscription</span>
                <svg class="w-4 h-4 ml-2.5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <a href="{{ route('contact') }}" 
               class="gl-magnetic inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs font-mono tracking-wider uppercase whitespace-nowrap border border-white/30 backdrop-blur-md transition-all duration-300 hover:border-white/60 min-h-[48px]">
                <span>Inquire with Concierge</span>
            </a>
        </div>

    </div>
</section>

@endsection
