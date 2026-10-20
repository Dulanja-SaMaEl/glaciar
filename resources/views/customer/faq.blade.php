@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO: CONCIERGE KNOWLEDGE BASE & FAQS
     ═══════════════════════════════════════════════════════════════════ -->
<section class="relative bg-glaciar-obsidian text-white pt-28 pb-20 border-b border-white/10 overflow-hidden select-none min-h-[70vh] flex items-center gl-section-reveal"
         style="background-image: url('{{ asset('images/hero/glaciar-aurora-bg.jpg') }}'); background-size: cover; background-position: center 25%;">
    
    <div class="absolute inset-0 bg-gradient-to-r from-glaciar-obsidian/95 via-glaciar-obsidian/85 to-glaciar-obsidian/75 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-glaciar-obsidian via-transparent to-glaciar-obsidian/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-3xl space-y-5 gl-section-header">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                    CLIENT KNOWLEDGE BASE & DISPATCH PROTOCOLS
                </span>
            </div>

            <h1 class="text-[clamp(2.4rem,5.5vw,4.8rem)] font-black tracking-tight leading-[0.95] text-white">
                FREQUENTLY ASKED<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300 drop-shadow-[0_0_35px_rgba(56,189,248,0.4)]">
                    QUESTIONS.
                </span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                Clear answers regarding our 1,890m Arctic sanctuary, closed-loop doorstep flint glass replenishment, cold-chain courier dispatch, and private cellar allocations.
            </p>

            <div class="pt-4 flex flex-wrap items-center gap-6 text-xs font-mono text-slate-300 uppercase gl-reveal-item">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>24/7 CONCIERGE SUPPORT AVAILABLE</span>
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>WHITE-GLOVE DISPATCH PROTOCOLS</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     2. ACCORDION FAQ CONTENT (ALPINE.JS DRIVEN)
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal" 
         x-data="{ activeCategory: 'provenance', activeItem: 'item-1' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Category Navigation (Columns 1-4) -->
            <div class="lg:col-span-4 lg:sticky lg:top-28 space-y-4 gl-reveal-item">
                <div class="p-6 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-4">
                        TOPIC CATEGORIES
                    </span>
                    <div class="space-y-2">
                        <button @click="activeCategory = 'provenance'" 
                                :class="activeCategory === 'provenance' ? 'bg-cyan-400/20 border-cyan-400/50 text-white font-bold' : 'text-slate-400 hover:text-white border-transparent'"
                                class="w-full text-left px-4 py-3 rounded-xl border text-xs font-mono uppercase tracking-wider transition-all flex items-center justify-between min-h-[44px]">
                            <span>01. Harvest & Purity</span>
                            <span class="text-[10px] text-cyan-400 font-mono">3 ITEMS</span>
                        </button>

                        <button @click="activeCategory = 'circularity'" 
                                :class="activeCategory === 'circularity' ? 'bg-cyan-400/20 border-cyan-400/50 text-white font-bold' : 'text-slate-400 hover:text-white border-transparent'"
                                class="w-full text-left px-4 py-3 rounded-xl border text-xs font-mono uppercase tracking-wider transition-all flex items-center justify-between min-h-[44px]">
                            <span>02. Doorstep Replenishment</span>
                            <span class="text-[10px] text-cyan-400 font-mono">3 ITEMS</span>
                        </button>

                        <button @click="activeCategory = 'coldchain'" 
                                :class="activeCategory === 'coldchain' ? 'bg-cyan-400/20 border-cyan-400/50 text-white font-bold' : 'text-slate-400 hover:text-white border-transparent'"
                                class="w-full text-left px-4 py-3 rounded-xl border text-xs font-mono uppercase tracking-wider transition-all flex items-center justify-between min-h-[44px]">
                            <span>03. Logistics & Storage</span>
                            <span class="text-[10px] text-cyan-400 font-mono">3 ITEMS</span>
                        </button>

                        <button @click="activeCategory = 'subscriptions'" 
                                :class="activeCategory === 'subscriptions' ? 'bg-cyan-400/20 border-cyan-400/50 text-white font-bold' : 'text-slate-400 hover:text-white border-transparent'"
                                class="w-full text-left px-4 py-3 rounded-xl border text-xs font-mono uppercase tracking-wider transition-all flex items-center justify-between min-h-[44px]">
                            <span>04. Allocations & Cellar</span>
                            <span class="text-[10px] text-cyan-400 font-mono">2 ITEMS</span>
                        </button>
                    </div>
                </div>

                <!-- Direct Concierge Helpdesk Box -->
                <div class="p-6 rounded-3xl bg-white/[0.02] border border-white/10">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-slate-400 font-bold block mb-1">
                        NEED IMMEDIATE ASSISTANCE?
                    </span>
                    <p class="text-xs text-slate-400 font-light leading-relaxed mt-1">
                        Our concierge desk can customize bespoke delivery schedules or tasting allocations:
                    </p>
                    <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-xs font-mono">
                        <span class="text-white">+94 11 234 5678</span>
                        <a href="{{ route('contact') }}" class="text-cyan-400 underline hover:text-white min-h-[44px] flex items-center">Message Concierge</a>
                    </div>
                </div>
            </div>

            <!-- FAQ Accordion Items (Columns 5-12) -->
            <div class="lg:col-span-8 space-y-6 gl-reveal-item">
                
                <!-- Category 1: Harvest & Purity -->
                <div x-show="activeCategory === 'provenance'" class="space-y-4">
                    
                    <!-- Q1 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-1' ? '' : 'item-1')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">Where is Glaciar harvested and what makes it unique?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-1' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-1'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            Glaciar is collected directly at 1,890 meters altitude from protected high-latitude Arctic glacial ice strata formed during the Pleistocene epoch over 10,000 years ago. Before modern industrial pollution existed, pristine snow fell and compressed into deep crystalline ice. We harvest pure sub-zero meltwater right at the glacier’s natural bedrock terminus, bypassing municipal groundwater entirely.
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-2' ? '' : 'item-2')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">Is Glaciar treated with ozone, chlorine, or reverse osmosis?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-2' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-2'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            No. Glaciar is never subjected to artificial reverse osmosis (which strips water of all living mineral value), chemical chlorination, or harsh ozone sterilization. The water is naturally sterile upon emergence and flows through enclosed surgical-grade stainless steel conduits directly into heavy flint glass under sterile vacuum seal.
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-3' ? '' : 'item-3')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">What is the significance of the 7.4 pH and 42 mg/L TDS profile?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-3' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-3'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            A pH of 7.4 exactly mirrors human arterial blood equilibrium for instantaneous cellular absorption. An exceptionally light Total Dissolved Solids reading of 42 mg/L ensures a featherweight, crisp sensory mouthfeel enriched with 14.2 mg/L bio-available colloidal silica that cleanses the palate without drying tannins or chalky residues.
                        </div>
                    </div>

                </div>

                <!-- Category 2: Circularity & Doorstep Replenishment -->
                <div x-show="activeCategory === 'circularity'" class="space-y-4">
                    
                    <!-- Q4 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-4' ? '' : 'item-4')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">How does the doorstep bottle return program work?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-4' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-4'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            When your white-glove courier delivers fresh chilled carafes, simply place your emptied vessels in the provided thermal storage crate outside your door. The courier collects the crate, and a 100% deposit credit is instantly applied back to your customer account ledger.
                        </div>
                    </div>

                    <!-- Q5 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-5' ? '' : 'item-5')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">Do I need to sterilize the vessels before courier pickup?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-5' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-5'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            A simple water rinse is appreciated, but full medical sanitization is handled entirely at our regional facility. Every returned vessel undergoes a multi-stage 140°C pressurized pure glacial steam sterilization cycle in an ISO Class 5 cleanroom before being refilled.
                        </div>
                    </div>

                    <!-- Q6 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-6' ? '' : 'item-6')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">What happens if a flint glass bottle accidentally breaks?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-6' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-6'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            Our heavy flint glass is engineered with reinforced base thickness and resists ordinary impact. However, if accidental breakage occurs, simply notify the concierge desk. We replace broken bottles with zero penalty fee.
                        </div>
                    </div>

                </div>

                <!-- Category 3: Logistics & Storage -->
                <div x-show="activeCategory === 'coldchain'" class="space-y-4">
                    
                    <!-- Q7 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-7' ? '' : 'item-7')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">Why is Glaciar transported under cold-chain refrigeration?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-7' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-7'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            Glacial water possesses high dissolved oxygen content and delicate crystalline structures that thrive in sub-zero and chilled environments. Transporting our vessels in climate-controlled refrigerated vehicles (≤ 4°C) prevents mineral precipitation and thermal shock.
                        </div>
                    </div>

                    <!-- Q8 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-8' ? '' : 'item-8')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">What is the optimal serving temperature?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-8' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-8'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            Our master water sommeliers recommend serving Glaciar chilled between 4°C and 8°C. At this temperature, the colloidal silica provides its signature silky texture while preserving the crisp, refreshing bite of pure Arctic ice.
                        </div>
                    </div>

                    <!-- Q9 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-9' ? '' : 'item-9')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">What is the shelf life of an unopened Glaciar vessel?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-9' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-9'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            Sealed under hermetic vacuum closure in non-reactive flint glass, an unopened bottle maintains absolute purity indefinitely. We guarantee peak organoleptic freshness for up to 36 months when stored away from direct sunlight.
                        </div>
                    </div>

                </div>

                <!-- Category 4: Subscriptions & Allocations -->
                <div x-show="activeCategory === 'subscriptions'" class="space-y-4">
                    
                    <!-- Q10 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-10' ? '' : 'item-10')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">Can I pause, reschedule, or adjust my recurring allocation?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-10' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-10'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            Yes. Through your authenticated <a href="{{ route('account.index') }}" class="text-cyan-400 underline hover:text-white">Customer Account Portal</a>, you can adjust your delivery cadence, change vessel quantities, or pause service during travel with a single click and zero penalty fees.
                        </div>
                    </div>

                    <!-- Q11 -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-xl transition-all">
                        <button @click="activeItem = (activeItem === 'item-11' ? '' : 'item-11')" class="w-full text-left flex items-center justify-between gap-4 min-h-[44px]">
                            <h3 class="text-lg font-bold text-white tracking-tight">Do you provide bespoke allocations for fine dining or corporate galas?</h3>
                            <span class="w-8 h-8 rounded-full bg-cyan-400/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 flex-shrink-0 font-mono text-sm" x-text="activeItem === 'item-11' ? '−' : '+'"></span>
                        </button>
                        <div x-show="activeItem === 'item-11'" x-collapse class="mt-4 pt-4 border-t border-white/10 text-xs sm:text-sm text-slate-300 font-light leading-relaxed">
                            Yes. We offer customized private cellar reserves and sommelier event allocations with bespoke laser-etched vessel insignias. Contact our <a href="{{ route('contact') }}" class="text-cyan-400 underline hover:text-white">Concierge Desk</a> directly to coordinate high-volume allocations.
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
