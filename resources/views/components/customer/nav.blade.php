@php
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'qty'));
@endphp

<header id="customer-nav" 
        x-data="{ open: false, scrolled: false }" 
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
        :class="scrolled ? 'shadow-2xl py-3.5 bg-[#020617]/95 backdrop-blur-xl border-white/10' : 'py-4 sm:py-5 bg-[#020617]/75 backdrop-blur-md border-white/5'"
        class="fixed top-0 inset-x-0 z-50 text-white border-b transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            
            <!-- Logo area with Mountain Peak Mark -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('home') }}" class="gl-magnetic flex items-center gap-2.5 group">
                    <!-- Elegant Twin Mountain Peak Vector from Reference -->
                    <svg class="w-6 h-6 text-white group-hover:text-cyan-300 transition-colors filter drop-shadow-[0_0_8px_rgba(56,189,248,0.5)]" viewBox="0 0 32 22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 20L11 5L19 20" />
                        <path d="M15 20L21 9L29 20" />
                    </svg>
                    <span class="text-xl sm:text-2xl font-serif tracking-[0.25em] text-white font-bold group-hover:text-cyan-200 transition-colors">GLACIAR</span>
                </a>
            </div>

            <!-- Desktop Menu (XL Displays) -->
            <nav class="hidden xl:flex items-center space-x-1">
                <a href="{{ route('home') }}#the-source" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium rounded-full hover:bg-white/5 transition-all">
                    The Source
                </a>
                <a href="{{ route('collection') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium rounded-full hover:bg-white/5 transition-all">
                    Collection
                </a>
                <a href="{{ route('about') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium rounded-full hover:bg-white/5 transition-all">
                    About
                </a>
                <a href="{{ route('analysis') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium rounded-full hover:bg-white/5 transition-all">
                    Analysis
                </a>
                <a href="{{ route('sustainability') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium rounded-full hover:bg-white/5 transition-all">
                    Sustainability
                </a>
                <a href="{{ route('faq') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium rounded-full hover:bg-white/5 transition-all">
                    FAQ
                </a>
                <a href="{{ route('contact') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium rounded-full hover:bg-white/5 transition-all">
                    Contact
                </a>
            </nav>

            <!-- Right Actions Cluster (Desktop XL) -->
            <div class="hidden xl:flex items-center space-x-3 flex-shrink-0">
                <a href="{{ route('shop') }}" class="gl-magnetic inline-flex items-center justify-center px-5 py-2 rounded-full border border-white/25 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold tracking-wider transition-all duration-300 backdrop-blur-md shadow-[0_0_15px_rgba(255,255,255,0.08)] hover:shadow-[0_0_20px_rgba(56,189,248,0.35)] hover:border-cyan-300/50">
                    Shop Now
                </a>

                @auth('web')
                    <a href="{{ route('account.index') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium flex items-center gap-1.5 transition-colors">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>{{ Str::words(Auth::user()->name, 1, '') }}</span>
                    </a>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-white text-xs uppercase tracking-widest font-medium transition-colors px-2 py-1">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white px-3 py-2 text-xs uppercase tracking-widest font-medium transition-colors">
                        Sign In
                    </a>
                @endauth

                <!-- Cart Button -->
                <div class="gl-magnetic">
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center p-2.5 rounded-full text-white hover:bg-white/10 transition-colors border border-white/10" aria-label="Cart">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @if($cartCount > 0)
                            <span id="nav-cart-badge" class="absolute -top-1 -right-1 bg-cyan-400 text-slate-950 text-[10px] font-black w-4 h-4 rounded-full flex items-center justify-center shadow-lg">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Mobile & Tablet Controls (< XL: 0px to 1279px) -->
            <div class="flex xl:hidden items-center gap-2 sm:gap-3 flex-shrink-0">
                <!-- Shop Now Pill -->
                <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-4 py-1.5 rounded-full border border-white/20 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold tracking-wider transition-all backdrop-blur-md">
                    Shop Now
                </a>

                <!-- Cart Button -->
                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center p-2 rounded-full text-white hover:bg-white/10 transition-colors border border-white/10" aria-label="Cart">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-cyan-400 text-slate-950 text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-md">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Hamburger Menu Trigger (ALWAYS present when desktop nav is hidden) -->
                <button @click="open = ! open" 
                        class="p-2 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 focus:outline-none transition-colors border border-white/10" 
                        aria-label="Toggle navigation menu">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile & Tablet Slide-Down / Full Glass Drawer (< XL) -->
    <div x-show="open" 
         x-cloak
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="opacity-0 -translate-y-4" 
         x-transition:enter-end="opacity-100 translate-y-0" 
         x-transition:leave="transition ease-in duration-150" 
         x-transition:leave-start="opacity-100 translate-y-0" 
         x-transition:leave-end="opacity-0 -translate-y-4" 
         class="xl:hidden border-t border-white/10 bg-[#020617]/98 backdrop-blur-2xl px-6 pt-4 pb-8 space-y-1 mt-3 shadow-2xl max-h-[calc(100dvh-5rem)] overflow-y-auto">
        
        <div class="text-[10px] font-mono uppercase tracking-ultra text-cyan-300/80 pt-2 pb-1">
            Navigation Menu
        </div>
        
        <a href="{{ route('home') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            Home
        </a>
        <a href="{{ route('home') }}#the-source" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            The Source (Provenance)
        </a>
        <a href="{{ route('collection') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            The Collection (Vessels)
        </a>
        <a href="{{ route('shop') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            The Boutique (Shop Catalog)
        </a>
        <a href="{{ route('about') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            About Glaciar
        </a>
        <a href="{{ route('analysis') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            Purity Analysis (ICP-MS)
        </a>
        <a href="{{ route('sustainability') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            Sustainability & Closed Loop
        </a>
        <a href="{{ route('faq') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            Concierge FAQ
        </a>
        <a href="{{ route('contact') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            Contact Concierge
        </a>
        <a href="{{ route('account.orders') }}" @click="open = false" class="block text-white hover:text-cyan-300 py-2.5 text-sm uppercase tracking-widest font-semibold border-b border-white/5 transition-colors">
            Track Orders
        </a>
        
        <div class="pt-6 flex flex-col gap-2.5">
            @auth('web')
                <a href="{{ route('account.index') }}" class="w-full text-center py-3 px-4 rounded-xl bg-white/10 hover:bg-white/15 text-white text-xs uppercase tracking-widest font-bold border border-white/10 transition-colors">
                    Client Portal ({{ Auth::user()->name }})
                </a>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="w-full text-center py-2 text-slate-400 hover:text-white text-xs uppercase tracking-widest font-bold transition-colors">
                        Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full text-center py-3 px-4 rounded-xl bg-cyan-400 hover:bg-cyan-300 text-slate-950 text-xs uppercase tracking-widest font-bold transition-colors shadow-[0_0_20px_rgba(56,189,248,0.3)]">
                    Sign In to Glaciar
                </a>
                <a href="{{ route('register') }}" class="w-full text-center py-3 px-4 rounded-xl border border-white/20 hover:border-white/40 text-white text-xs uppercase tracking-widest font-bold transition-colors">
                    Create Client Account
                </a>
            @endauth
        </div>
    </div>
</header>
