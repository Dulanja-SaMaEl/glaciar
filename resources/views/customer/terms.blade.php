@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO: TERMS OF SERVICE & CLIENT GOVERNANCE
     ═══════════════════════════════════════════════════════════════════ -->
<section class="relative bg-glaciar-obsidian text-white pt-28 pb-20 border-b border-white/10 overflow-hidden select-none min-h-[70vh] flex items-center gl-section-reveal"
         style="background-image: url('{{ asset('images/hero/glaciar-aurora-bg.jpg') }}'); background-size: cover; background-position: center 25%;">
    
    <div class="absolute inset-0 bg-gradient-to-r from-glaciar-obsidian/95 via-glaciar-obsidian/90 to-glaciar-obsidian/80 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-glaciar-obsidian via-transparent to-glaciar-obsidian/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-3xl space-y-5 gl-section-header">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                    CLIENT GOVERNANCE PROTOCOL · REVISED OCTOBER 2026
                </span>
            </div>

            <h1 class="text-[clamp(2.4rem,5.5vw,4.8rem)] font-black tracking-tight leading-[0.95] text-white">
                TERMS OF<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300 drop-shadow-[0_0_35px_rgba(56,189,248,0.4)]">
                    SERVICE.
                </span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                These Terms of Service govern your purchase, allocation reservations, doorstep flint glass replenishment subscriptions, and white-glove delivery services provided by Glaciar Water Co.
            </p>

            <div class="pt-4 flex flex-wrap items-center gap-6 text-xs font-mono text-slate-300 uppercase gl-reveal-item">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>EFFECTIVE DATE: OCTOBER 13, 2026</span>
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>JURISDICTION: ARCTIC GLOBAL COMMERCE</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     2. LEGAL ARTICLES & STICKY NAVIGATION
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Sticky Table of Contents (Columns 1-4) -->
            <div class="lg:col-span-4 lg:sticky lg:top-28 space-y-4 gl-reveal-item">
                <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-xl">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-4">
                        TABLE OF ARTICLES
                    </span>
                    <nav class="space-y-2 text-xs font-mono uppercase tracking-wider text-slate-400">
                        <a href="#article-1" class="block hover:text-white transition-colors py-1">01. Acceptance & Eligibility</a>
                        <a href="#article-2" class="block hover:text-white transition-colors py-1">02. Allocations & Pre-Orders</a>
                        <a href="#article-3" class="block hover:text-white transition-colors py-1">03. Flint Glass Vessel Deposit</a>
                        <a href="#article-4" class="block hover:text-white transition-colors py-1">04. Cold-Chain White-Glove Transit</a>
                        <a href="#article-5" class="block hover:text-white transition-colors py-1">05. Subscriptions & Billing</a>
                        <a href="#article-6" class="block hover:text-white transition-colors py-1">06. Freshness Guarantee & Returns</a>
                        <a href="#article-7" class="block hover:text-white transition-colors py-1">07. Intellectual Property</a>
                        <a href="#article-8" class="block hover:text-white transition-colors py-1">08. Liability & Arbitration</a>
                    </nav>
                </div>

                <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-slate-400 font-bold block mb-1">
                        LEGAL DESK INQUIRIES
                    </span>
                    <p class="text-xs text-slate-400 font-light leading-relaxed mt-1">
                        Direct all regulatory, diplomatic, or compliance inquiries to <span class="text-white font-mono">legal@glaciarwater.com</span>.
                    </p>
                </div>
            </div>

            <!-- Legal Articles Content (Columns 5-12) -->
            <div class="lg:col-span-8 space-y-16 gl-reveal-item text-slate-300 text-sm leading-relaxed font-light">
                
                <!-- Article 1 -->
                <article id="article-1" class="space-y-4 pt-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 01</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Scope, Acceptance & Eligibility</h2>
                    <p>
                        By visiting, accessing, reserving allocations, or purchasing products on <span class="text-white font-medium">Glaciar</span> (the "Service", operated by Glaciar Water Co.), you acknowledge that you have read, understood, and agreed to be bound by these Terms of Service.
                    </p>
                    <p>
                        Our services are exclusively intended for discerning consumers and corporate entities capable of forming legally binding agreements. If you are ordering on behalf of an institution, estate, or hospitality group, you represent that you possess the requisite authority to bind that entity.
                    </p>
                </article>

                <!-- Article 2 -->
                <article id="article-2" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 02</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Allocations & Pre-Order Reservations</h2>
                    <p>
                        Glaciar water is harvested directly from pristine high-altitude glacial strata under strict seasonal quotas to protect alpine ecological sustainability. Consequently, certain vessel volumes (specifically our Flagship 1000ml Carafe and 250ml Tasting Crystal Flutes) are offered under limited allocation.
                    </p>
                    <p>
                        Pre-order reservations grant you priority dispatch status upon batch bottling. In the rare event that extreme meteorological conditions at the Arctic sanctuary delay harvesting, our concierge will notify you with telemetry updates and offer immediate full restitution or rescheduled delivery.
                    </p>
                </article>

                <!-- Article 3 -->
                <article id="article-3" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 03</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Flint Glass Vessel Deposit & Closed-Loop Returns</h2>
                    <p>
                        In furtherance of our zero-waste ecological commitment, all Glaciar products are packaged exclusively in heavy diamond-faceted flint glass vessels. To incentivize infinite closed-loop recirculation:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-slate-300">
                        <li>Each vessel may incur a refundable container deposit at initial order checkout.</li>
                        <li>When our white-glove couriers arrive with your subsequent delivery, they retrieve empty rinsed vessels in the provided thermal storage crate.</li>
                        <li>Upon receipt at our regional sterilization facility, a 100% deposit credit is instantly applied to your client account ledger.</li>
                    </ul>
                </article>

                <!-- Article 4 -->
                <article id="article-4" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 04</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Cold-Chain White-Glove Transit & Temperature Guarantee</h2>
                    <p>
                        All Glaciar deliveries are conducted utilizing sub-zero cold-chain transport vehicles to preserve the dissolved oxygen and micro-mineral structure of the water. We guarantee that your water arrives at or below 4°C.
                    </p>
                    <p>
                        In the improbable event that any flint glass vessel suffers breakage or structural compromise during transit, our courier will issue an immediate replacement without requiring return of the damaged vessel.
                    </p>
                </article>

                <!-- Article 5 -->
                <article id="article-5" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 05</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Subscriptions, Billing & Payment Tokenization</h2>
                    <p>
                        Clients enrolled in automated doorstep replenishment plans are billed recurringly according to their chosen cycle (weekly, bi-weekly, or monthly). All payment details are processed through encrypted, PCI-DSS Level 1 compliant tokenized payment gateways; Glaciar never stores raw credit card numbers on its servers.
                    </p>
                    <p>
                        You may pause, modify delivery frequency, adjust vessel counts, or terminate recurring subscriptions at any time through your <a href="{{ route('account.index') }}" class="text-cyan-400 underline hover:text-white">Customer Account Dashboard</a> with zero penalty fees.
                    </p>
                </article>

                <!-- Article 6 -->
                <article id="article-6" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 06</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Freshness Assurance & Sensory Satisfaction</h2>
                    <p>
                        We stand unreservedly behind the sensory purity of Glaciar water. Because our product is naturally enriched and bottled without chemical preservatives, vessels should be stored away from direct thermal sunlight.
                    </p>
                    <p>
                        If an unopened vessel exhibits any seal breach or sensory divergence from our published mineral profile, notify our Concierge Desk within 14 days of delivery for immediate complimentary replacement or full refund.
                    </p>
                </article>

                <!-- Article 7 -->
                <article id="article-7" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 07</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Intellectual Property & Vessel Design Rights</h2>
                    <p>
                        The GLACIAR brand wordmark, twin-peak mountain crest, diamond-faceted flint glass vessel geometry, 3D caustic motion shaders, and telemetry documentation are the exclusive intellectual property of Glaciar Water Co.
                    </p>
                    <p>
                        Unauthorized replication of our vessel design, digital assets, or trademarked branding is strictly prohibited under international copyright and industrial design conventions.
                    </p>
                </article>

                <!-- Article 8 -->
                <article id="article-8" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 08</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Limitation of Liability & Dispute Arbitration</h2>
                    <p>
                        To the maximum extent permitted by applicable law, Glaciar Water Co. shall not be held liable for indirect, incidental, or consequential damages resulting from courier transit delays caused by extreme natural weather events.
                    </p>
                    <p>
                        Any disputes arising out of these terms shall first be addressed through good-faith mediation conducted by our Concierge Desk. If unresolved, claims shall be submitted to confidential, binding commercial arbitration under international dispute protocols.
                    </p>
                </article>

            </div>

        </div>

    </div>
</section>

@endsection
