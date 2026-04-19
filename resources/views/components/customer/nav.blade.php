<nav x-data="{ open: false }" class="bg-white border-b border-glaciar-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <!-- Logo area -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center group">
                    <span class="text-3xl font-extrabold tracking-[0.2em] text-glaciar-black group-hover:opacity-80 transition-opacity">GLACIAR</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-glaciar-black font-semibold border-b-2 border-glaciar-black' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} px-1 pt-1 pb-1 inline-flex items-center text-sm font-medium transition-colors">
                    Home
                </a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-glaciar-black font-semibold border-b-2 border-glaciar-black' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} px-1 pt-1 pb-1 inline-flex items-center text-sm font-medium transition-colors">
                    Products
                </a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-glaciar-black font-semibold border-b-2 border-glaciar-black' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} px-1 pt-1 pb-1 inline-flex items-center text-sm font-medium transition-colors">
                    About
                </a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-glaciar-black font-semibold border-b-2 border-glaciar-black' : 'text-glaciar-gray-500 hover:text-glaciar-black' }} px-1 pt-1 pb-1 inline-flex items-center text-sm font-medium transition-colors">
                    Contact
                </a>
            </div>

            <!-- Right side (Auth/Cart) -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @auth('web')
                    <a href="{{ route('account.index') }}" class="text-glaciar-gray-500 hover:text-glaciar-black px-3 py-2 text-sm font-medium flex items-center gap-1 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Account
                    </a>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="text-glaciar-gray-500 hover:text-glaciar-black px-3 py-2 text-sm font-medium transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-glaciar-gray-500 hover:text-glaciar-black px-3 py-2 text-sm font-medium transition-colors">
                        Login
                    </a>
                @endauth

                <a href="{{ route('cart.index') }}" class="text-glaciar-black hover:opacity-80 px-3 py-2 flex items-center gap-2 transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <!-- Simulated cart count for mockup -->
                    <span class="bg-glaciar-black text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">2</span>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-50 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden border-t border-glaciar-gray-100 bg-white absolute w-full left-0 z-40 shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-glaciar-gray-50 text-glaciar-black border-l-4 border-glaciar-black' : 'border-l-4 border-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black' }} block pl-3 pr-4 py-2 text-base font-medium">Home</a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'bg-glaciar-gray-50 text-glaciar-black border-l-4 border-glaciar-black' : 'border-l-4 border-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black' }} block pl-3 pr-4 py-2 text-base font-medium">Products</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'bg-glaciar-gray-50 text-glaciar-black border-l-4 border-glaciar-black' : 'border-l-4 border-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black' }} block pl-3 pr-4 py-2 text-base font-medium">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-glaciar-gray-50 text-glaciar-black border-l-4 border-glaciar-black' : 'border-l-4 border-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black' }} block pl-3 pr-4 py-2 text-base font-medium">Contact</a>
        </div>
        
        <div class="pt-4 pb-3 border-t border-glaciar-gray-100">
            @auth('web')
                <div class="px-4">
                    <div class="font-medium text-base text-glaciar-black">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-glaciar-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('account.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-50">Account</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-50">Login</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
