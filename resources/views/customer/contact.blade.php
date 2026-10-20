@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO: CONCIERGE & ALLOCATION SERVICES
     ═══════════════════════════════════════════════════════════════════ -->
<section class="relative bg-glaciar-obsidian text-white pt-28 pb-20 border-b border-white/10 overflow-hidden select-none min-h-[70vh] flex items-center gl-section-reveal"
         style="background-image: url('{{ asset('images/hero/glaciar-aurora-bg.jpg') }}'); background-size: cover; background-position: center 25%;">
    
    <!-- Atmospheric Contrast Overlays -->
    <div class="absolute inset-0 bg-gradient-to-r from-glaciar-obsidian/95 via-glaciar-obsidian/85 to-glaciar-obsidian/75 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-glaciar-obsidian via-transparent to-glaciar-obsidian/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-3xl space-y-5 gl-section-header">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                    GLACIAR CONCIERGE & ALLOCATIONS
                </span>
            </div>

            <h1 class="text-[clamp(2.4rem,5.5vw,4.8rem)] font-black tracking-tight leading-[0.95] text-white">
                CONNECT WITH THE<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300 drop-shadow-[0_0_35px_rgba(56,189,248,0.4)]">
                    CONCIERGE DESK.
                </span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                For private residence cellar subscriptions, Michelin restaurant partnerships, diplomatic logistics, or custom doorstep delivery scheduling, our client dispatch representatives are at your service.
            </p>

            <div class="pt-4 flex flex-wrap items-center gap-4 text-xs font-mono text-slate-300 uppercase gl-reveal-item">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>SLA: 4 BUSINESS HOURS</span>
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>WHITE-GLOVE COLD-CHAIN DISPATCH</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     2. INTERACTIVE CONCIERGE & INQUIRY FORM
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden flex-grow min-h-[70vh] gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Left Column: Concierge Directory & Logistics Telemetry (5 Cols) -->
            <div class="lg:col-span-5 space-y-6 gl-reveal-item">
                
                <div class="p-8 rounded-3xl bg-white/[0.03] border border-white/10 backdrop-blur-xl shadow-xl space-y-6">
                    <div>
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-1">DIRECT TELEPHONE</span>
                        <h3 class="text-xl font-bold text-white tracking-tight font-mono">+94 11 234 5678</h3>
                        <p class="text-xs text-slate-400 font-light mt-1">
                            Concierge representatives available Monday–Saturday, 07:00 – 21:00 IST.
                        </p>
                    </div>

                    <div class="pt-6 border-t border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-1">ELECTRONIC MAIL</span>
                        <h3 class="text-base font-bold text-white font-mono">concierge@glaciarwater.com</h3>
                        <p class="text-xs text-slate-400 font-light mt-1">
                            Private cellar and allocation correspondence answered within 4 hours.
                        </p>
                    </div>

                    <div class="pt-6 border-t border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-1">COMMERCIAL & FINE DINING</span>
                        <h3 class="text-base font-bold text-white font-mono">allocations@glaciarwater.com</h3>
                        <p class="text-xs text-slate-400 font-light mt-1">
                            Sommelier consultation and wholesale tasting allocations.
                        </p>
                    </div>

                    <div class="pt-6 border-t border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-1">SANCTUARY HEADQUARTERS</span>
                        <h4 class="text-sm font-bold text-white">Glaciar Arctic Operations & Logistics</h4>
                        <p class="text-xs text-slate-400 font-light leading-relaxed mt-1">
                            Terminal 1890, Arctic Latitude 64° 08' N<br>
                            Regional Logistics Hub: 123 Aqua Way, Cinnamon Gardens, Colombo 03, Sri Lanka
                        </p>
                    </div>
                </div>

                <!-- Cold Chain Delivery Assurance -->
                <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-cyan-400/10 border border-cyan-400/20 text-cyan-300 flex items-center justify-center flex-shrink-0 mt-0.5 font-mono font-bold text-xs">
                        COLD
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider font-mono">Sub-Zero Transit Guarantee</h4>
                        <p class="text-xs text-slate-400 font-light leading-relaxed mt-1">
                            All vessels travel inside insulated thermal lockers to prevent mineral thermal shock. Our couriers also retrieve your empty flint glass vessels on each delivery.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Right Column: Interactive Luxury Inquiry Form (7 Cols) -->
            <div class="lg:col-span-7 gl-reveal-item">
                
                <div class="p-8 sm:p-12 rounded-3xl bg-[#0b1226]/85 border border-white/15 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] relative">
                    
                    <div class="mb-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 mb-2">
                            <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">CLIENT INTAKE</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight font-mono">
                            Transmit an Inquiry
                        </h2>
                        <p class="text-xs text-slate-400 font-light mt-1.5">
                            Complete the telemetry below. A dedicated Glaciar concierge representative will respond promptly.
                        </p>
                    </div>

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-xl bg-red-950/60 border border-red-500/40 text-red-200 text-xs">
                            <div class="font-bold uppercase tracking-wider mb-1">Please correct the following:</div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-[11px] font-mono uppercase tracking-wider text-slate-300 mb-2 font-semibold">
                                    Full Name <span class="text-cyan-400">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', Auth::user()->name ?? '') }}" 
                                       required 
                                       placeholder="e.g. Lord Marcus Vance"
                                       class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors min-h-[44px]">
                            </div>

                            <div>
                                <label for="email" class="block text-[11px] font-mono uppercase tracking-wider text-slate-300 mb-2 font-semibold">
                                    Electronic Mail <span class="text-cyan-400">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::user()->email ?? '') }}" 
                                       required 
                                       placeholder="marcus@vance-holdings.com"
                                       class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors font-mono min-h-[44px]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-[11px] font-mono uppercase tracking-wider text-slate-300 mb-2 font-semibold">
                                    Direct Contact Number
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       placeholder="+94 77 123 4567"
                                       class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors font-mono min-h-[44px]">
                            </div>

                            <div>
                                <label for="subject" class="block text-[11px] font-mono uppercase tracking-wider text-slate-300 mb-2 font-semibold">
                                    Nature of Inquiry <span class="text-cyan-400">*</span>
                                </label>
                                <select id="subject" 
                                        name="subject" 
                                        required 
                                        class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors min-h-[44px]">
                                    <option value="Private Cellar Allocation" {{ old('subject') === 'Private Cellar Allocation' ? 'selected' : '' }}>Private Residence Cellar Allocation</option>
                                    <option value="Fine Dining & Hospitality Supply" {{ old('subject') === 'Fine Dining & Hospitality Supply' ? 'selected' : '' }}>Fine Dining & Michelin Hospitality Supply</option>
                                    <option value="Corporate Estate Subscription" {{ old('subject') === 'Corporate Estate Subscription' ? 'selected' : '' }}>Corporate Headquarters Estate Subscription</option>
                                    <option value="Doorstep Replenishment Scheduling" {{ old('subject') === 'Doorstep Replenishment Scheduling' ? 'selected' : '' }}>Doorstep Replenishment & Bottle Collection</option>
                                    <option value="General Concierge Inquiry" {{ old('subject') === 'General Concierge Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="format_interest" class="block text-[11px] font-mono uppercase tracking-wider text-slate-300 mb-2 font-semibold">
                                Primary Vessel Format of Interest
                            </label>
                            <select id="format_interest" 
                                    name="format_interest" 
                                    class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors min-h-[44px]">
                                <option value="All Formats / Sommelier Mix">Curated Sommelier Collection (All Formats)</option>
                                <option value="1000ml Hydration Vessel">1000ml Flagship Diamond Flint Carafe</option>
                                <option value="500ml Companion Vessel">500ml Companion Flask</option>
                                <option value="250ml Tasting Crystal">250ml Fine Dining Tasting Flute</option>
                                <option value="5L Table Jug & 19L Dispenser">5L Table Jug & 19L Executive Dispenser</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-[11px] font-mono uppercase tracking-wider text-slate-300 mb-2 font-semibold">
                                Dispatch Instructions / Message <span class="text-cyan-400">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required 
                                      placeholder="Please specify delivery geographic zone, allocation volume, or bespoke sommelier requests..."
                                      class="w-full bg-[#030712] border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors leading-relaxed">{{ old('message') }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" 
                                    class="gl-magnetic w-full py-4 px-8 rounded-xl bg-gradient-to-r from-cyan-400 via-sky-400 to-cyan-300 hover:brightness-110 text-slate-950 font-bold font-mono text-xs tracking-widest uppercase transition-all duration-300 shadow-[0_0_25px_rgba(56,189,248,0.35)] flex items-center justify-center min-h-[48px]">
                                <span>Transmit Inquiry to Concierge</span>
                                <svg class="w-4 h-4 ml-2.5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>

                        <p class="text-[10px] text-slate-400 text-center font-mono pt-1">
                            ENCRYPTED VIA TLS 1.3 · ZERO THIRD-PARTY DATA BROKERAGE · CONFIDENTIAL CLIENT DISPATCH
                        </p>

                    </form>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
