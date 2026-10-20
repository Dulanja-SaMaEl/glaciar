@extends('layouts.customer')

@section('content')

<!-- ═══════════════════════════════════════════════════════════════════
     1. HERO: PRIVACY POLICY & CLIENT DATA SOVEREIGNTY
     ═══════════════════════════════════════════════════════════════════ -->
<section class="relative bg-glaciar-obsidian text-white pt-28 pb-20 border-b border-white/10 overflow-hidden select-none min-h-[70vh] flex items-center gl-section-reveal"
         style="background-image: url('{{ asset('images/hero/glaciar-aurora-bg.jpg') }}'); background-size: cover; background-position: center 25%;">
    
    <div class="absolute inset-0 bg-gradient-to-r from-glaciar-obsidian/95 via-glaciar-obsidian/90 to-glaciar-obsidian/80 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-glaciar-obsidian via-transparent to-glaciar-obsidian/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-3xl space-y-5 gl-section-header">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">
                    DATA SOVEREIGNTY PROTOCOL · REVISED OCTOBER 2026
                </span>
            </div>

            <h1 class="text-[clamp(2.4rem,5.5vw,4.8rem)] font-black tracking-tight leading-[0.95] text-white">
                PRIVACY<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-white to-sky-300 drop-shadow-[0_0_35px_rgba(56,189,248,0.4)]">
                    POLICY.
                </span>
            </h1>

            <p class="text-slate-200 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                We believe personal privacy is a fundamental standard. Glaciar handles client records and delivery coordinates with the same uncompromising purity as our glacial spring water.
            </p>

            <div class="pt-4 flex flex-wrap items-center gap-6 text-xs font-mono text-slate-300 uppercase gl-reveal-item">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>ZERO THIRD-PARTY BROKER RESALE</span>
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="text-cyan-400 font-bold">//</span>
                    <span>TLS 1.3 / AES-256 ENCRYPTION</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════
     2. PRIVACY CLAUSES & STICKY NAVIGATION
     ═══════════════════════════════════════════════════════════════════ -->
<section class="py-24 bg-glaciar-obsidian text-white border-b border-white/10 relative overflow-hidden gl-section-reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Sticky Navigation (Columns 1-4) -->
            <div class="lg:col-span-4 lg:sticky lg:top-28 space-y-4 gl-reveal-item">
                <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-xl">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold block mb-4">
                        PRIVACY ARTICLES
                    </span>
                    <nav class="space-y-2 text-xs font-mono uppercase tracking-wider text-slate-400">
                        <a href="#privacy-1" class="block hover:text-white transition-colors py-1">01. Principles of Data Purity</a>
                        <a href="#privacy-2" class="block hover:text-white transition-colors py-1">02. Telemetry We Collect</a>
                        <a href="#privacy-3" class="block hover:text-white transition-colors py-1">03. Utilization of Information</a>
                        <a href="#privacy-4" class="block hover:text-white transition-colors py-1">04. Cryptographic Storage</a>
                        <a href="#privacy-5" class="block hover:text-white transition-colors py-1">05. Zero Monetization Guarantee</a>
                        <a href="#privacy-6" class="block hover:text-white transition-colors py-1">06. Essential Cookies & Telemetry</a>
                        <a href="#privacy-7" class="block hover:text-white transition-colors py-1">07. Client Sovereignty & Rights</a>
                        <a href="#privacy-8" class="block hover:text-white transition-colors py-1">08. Data Protection Officer</a>
                    </nav>
                </div>

                <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10">
                    <span class="text-[10px] font-mono tracking-ultra uppercase text-slate-400 font-bold block mb-1">
                        DPO DIRECT DESK
                    </span>
                    <p class="text-xs text-slate-400 font-light leading-relaxed mt-1">
                        Requests for data purge or export may be transmitted directly to <span class="text-white font-mono">privacy@glaciarwater.com</span>.
                    </p>
                </div>
            </div>

            <!-- Privacy Articles Content (Columns 5-12) -->
            <div class="lg:col-span-8 space-y-16 gl-reveal-item text-slate-300 text-sm leading-relaxed font-light">
                
                <!-- Clause 1 -->
                <article id="privacy-1" class="space-y-4 pt-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 01</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Principles of Data Purity</h2>
                    <p>
                        Glaciar operates under a strict principle of data minimization: we collect only the minimal telemetry necessary to fulfill cold-chain white-glove beverage distribution, maintain authenticated client access, and coordinate doorstep vessel retrieval.
                    </p>
                    <p>
                        We do not profile clients for third-party advertising networks, nor do we deploy surveillance behavioral tracking scripts across our web application.
                    </p>
                </article>

                <!-- Clause 2 -->
                <article id="privacy-2" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 02</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Telemetry We Collect</h2>
                    <p>
                        When creating an account or placing an order, we collect:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-slate-300">
                        <li><strong class="text-white font-medium">Identity & Communication:</strong> Full name, verified electronic mail address, and direct telephone line.</li>
                        <li><strong class="text-white font-medium">Fulfillment Coordinates:</strong> Residential address, corporate estate suite numbers, delivery instructions, and gate access codes for white-glove couriers.</li>
                        <li><strong class="text-white font-medium">Order History & Deposit Ledger:</strong> Vessel format preferences, subscription intervals, and flint glass bottle return deposit balances.</li>
                    </ul>
                </article>

                <!-- Clause 3 -->
                <article id="privacy-3" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 03</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Utilization of Client Information</h2>
                    <p>
                        Client telemetry is utilized strictly for the following purposes:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-slate-300">
                        <li>Dispatching temperature-controlled refrigerated couriers to your designated delivery coordinates.</li>
                        <li>Facilitating doorstep retrieval of emptied flint glass vessels and crediting container deposit balances.</li>
                        <li>Transmitting real-time order tracking telemetry and sub-zero dispatch notices via email or SMS.</li>
                        <li>Providing concierge customer service and customized Sommelier allocations.</li>
                    </ul>
                </article>

                <!-- Clause 4 -->
                <article id="privacy-4" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 04</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Cryptographic Storage & Tokenization</h2>
                    <p>
                        All data transmitted between your browser and our infrastructure is secured using Transport Layer Security (TLS 1.3). Passwords are encrypted utilizing modern Argon2id cryptographic hashing.
                    </p>
                    <p>
                        Financial details are tokenized directly with our PCI-DSS Level 1 certified payment processor. At no time does Glaciar receive, process, or store unencrypted credit card primary account numbers on our database servers.
                    </p>
                </article>

                <!-- Clause 5 -->
                <article id="privacy-5" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 05</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Zero Monetization Guarantee</h2>
                    <p>
                        Glaciar maintains an irrevocable commitment: <strong class="text-white font-medium">we never sell, rent, license, or barter client data to commercial data brokers, advertising agencies, or marketing networks.</strong>
                    </p>
                    <p>
                        Your delivery coordinates and consumption patterns remain confidential and are accessible only to authorized logistics personnel assigned to fulfill your allocation.
                    </p>
                </article>

                <!-- Clause 6 -->
                <article id="privacy-6" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 06</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Strictly Essential Cookies & Sessions</h2>
                    <p>
                        Our platform employs only strictly necessary cookies to authenticate your session, maintain cart state, and provide security protection against cross-site request forgery (CSRF).
                    </p>
                    <p>
                        We do not load third-party ad-tracking pixels, social network cross-site beacons, or finger-printing identifiers.
                    </p>
                </article>

                <!-- Clause 7 -->
                <article id="privacy-7" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 07</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Client Sovereignty & Regulatory Rights</h2>
                    <p>
                        In compliance with the General Data Protection Regulation (GDPR) and California Consumer Privacy Act (CCPA), you enjoy full sovereignty over your personal data:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-slate-300">
                        <li><strong class="text-white font-medium">Right of Access & Portability:</strong> You may request an export of all personal records and order histories linked to your account.</li>
                        <li><strong class="text-white font-medium">Right to Rectification:</strong> You may update profile telemetry at any time via the customer dashboard.</li>
                        <li><strong class="text-white font-medium">Right to Erasure ("Right to Be Forgotten"):</strong> Upon request, we will permanently purge all non-essential account records, subject only to mandatory legal tax retention statutes.</li>
                    </ul>
                </article>

                <!-- Clause 8 -->
                <article id="privacy-8" class="space-y-4 pt-6 border-t border-white/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-300 font-bold">ARTICLE 08</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Data Protection Officer Contact</h2>
                    <p>
                        If you have inquiries regarding our data handling protocols, wish to execute data subject rights, or require compliance documentation, please reach out to our dedicated Data Protection Officer:
                    </p>
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 font-mono text-xs text-slate-300 space-y-1">
                        <p class="font-bold text-white">GLACIAR DATA SOVEREIGNTY OFFICE</p>
                        <p>Attention: Data Protection Officer</p>
                        <p>Terminal 1890, Arctic Reserve Facility, 64° 08' N</p>
                        <p>Electronic Mail: <a href="mailto:privacy@glaciarwater.com" class="text-cyan-400 underline hover:text-white">privacy@glaciarwater.com</a></p>
                    </div>
                </article>

            </div>

        </div>

    </div>
</section>

@endsection
