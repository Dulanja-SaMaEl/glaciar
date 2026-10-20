<footer class="bg-glaciar-obsidian text-white pt-24 pb-12 border-t border-white/10 relative overflow-hidden">
    <!-- Subtle ambient glow -->
    <div class="absolute -top-40 right-1/4 w-96 h-96 bg-glaciar-ice/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16 pb-20 border-b border-white/10">
            
            <!-- Brand Column -->
            <div class="md:col-span-4">
                <div class="flex items-center gap-2.5 mb-6">
                    <svg class="w-6 h-6 text-white filter drop-shadow-[0_0_8px_rgba(56,189,248,0.5)]" viewBox="0 0 32 22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 20L11 5L19 20" />
                        <path d="M15 20L21 9L29 20" />
                    </svg>
                    <span class="text-2xl font-serif font-black tracking-[0.2em] text-white uppercase">GLACIAR</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm mb-8 font-light">
                    Pure mountain spring water encased in high-performance thermal vessels. Designed for modern life, engineered for eternity.
                </p>
                <div class="text-xs uppercase tracking-widest text-slate-500 font-mono">
                    ORIGIN: 07°18'N 80°45'E · 1,890M ALTITUDE
                </div>
            </div>
            
            <!-- Links Column 1: The Boutique & Collection -->
            <div class="md:col-span-2 col-span-6">
                <h4 class="text-[11px] font-bold text-glaciar-ice uppercase tracking-ultra mb-6">The Boutique</h4>
                <ul class="space-y-3.5 text-xs uppercase tracking-wider font-medium text-slate-400">
                    <li><a href="{{ route('shop') }}" class="hover:text-white transition-colors text-cyan-300 font-bold">Shop All Formats</a></li>
                    <li><a href="{{ route('collection') }}" class="hover:text-white transition-colors">Vessel Collection</a></li>
                    <li><a href="{{ route('products.index', ['size' => 500]) }}" class="hover:text-white transition-colors">500ml Standard</a></li>
                    <li><a href="{{ route('products.index', ['size' => 1000]) }}" class="hover:text-white transition-colors">1000ml Hydration</a></li>
                    <li><a href="{{ route('products.index', ['size' => 5000]) }}" class="hover:text-white transition-colors">5L Table Jug</a></li>
                    <li><a href="{{ route('products.index', ['size' => 19000]) }}" class="hover:text-white transition-colors">19L Dispenser</a></li>
                </ul>
            </div>
            
            <!-- Links Column 2: Company & Science -->
            <div class="md:col-span-2 col-span-6">
                <h4 class="text-[11px] font-bold text-glaciar-ice uppercase tracking-ultra mb-6">Company</h4>
                <ul class="space-y-3.5 text-xs uppercase tracking-wider font-medium text-slate-400">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Glaciar</a></li>
                    <li><a href="{{ route('analysis') }}" class="hover:text-white transition-colors">Purity Analysis</a></li>
                    <li><a href="{{ route('sustainability') }}" class="hover:text-white transition-colors">Sustainability</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">Concierge FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Concierge</a></li>
                    <li><a href="{{ route('account.index') }}" class="hover:text-white transition-colors">Customer Portal</a></li>
                </ul>
            </div>
            
            <!-- Newsletter Column -->
            <div class="md:col-span-4">
                <h4 class="text-[11px] font-bold text-glaciar-ice uppercase tracking-ultra mb-6">Stay Informed</h4>
                <p class="text-xs text-slate-400 mb-4 font-light leading-relaxed">
                    Receive announcements on new vessel releases, technical whitepapers, and seasonal reserves.
                </p>
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Glaciar.');" class="flex gap-2">
                    @csrf
                    <input type="email" placeholder="ENTER YOUR EMAIL" required class="bg-white/5 border border-white/15 text-white placeholder-slate-500 text-xs px-4 py-3 rounded-lg flex-grow focus:outline-none focus:border-glaciar-ice font-mono tracking-wider">
                    <div class="gl-magnetic"><button type="submit" class="bg-white text-glaciar-obsidian px-5 py-3 text-xs uppercase tracking-widest font-bold rounded-lg hover:bg-glaciar-ice transition-colors flex-shrink-0">
                        Join
                    </button></div>
                </form>
                <p class="text-[10px] text-slate-500 mt-2.5 font-light">Zero marketing noise. Unsubscribe at any time.</p>
            </div>

        </div>

        <!-- Oversized Architectural Wordmark -->
        <div class="py-12 select-none pointer-events-none opacity-[0.07] text-center overflow-hidden gl-reveal-up">
            <span class="text-[clamp(4.5rem,14vw,12rem)] font-black tracking-widest text-white leading-none block">
                GLACIAR
            </span>
        </div>
        
        <!-- Bottom Row -->
        <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
            <p>&copy; {{ date('Y') }} GLACIAR WATER CO. ALL RIGHTS RESERVED.</p>
            <div class="flex items-center space-x-6 text-xs uppercase tracking-wider">
                <a href="{{ route('collection') }}" class="hover:text-slate-300 transition-colors">The Collection</a>
                <a href="{{ route('shop') }}" class="hover:text-slate-300 transition-colors">The Boutique</a>
                <a href="{{ route('privacy') }}" class="hover:text-slate-300 transition-colors">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:text-slate-300 transition-colors">Terms of Service</a>
                <a href="{{ route('faq') }}" class="hover:text-slate-300 transition-colors">FAQ</a>
            </div>
        </div>
    </div>
</footer>
