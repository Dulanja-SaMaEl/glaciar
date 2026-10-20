@extends('layouts.customer')

@section('content')
<div class="bg-[#020617] text-white pt-28 pb-12 border-b border-white/10 relative overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient pointer-events-none opacity-40"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-[10px] font-mono tracking-ultra uppercase text-cyan-400 font-bold block mb-1">
            CLIENT PORTAL
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white font-mono">MY ACCOUNT</h1>
    </div>
</div>

<div class="bg-[#020617] flex-grow py-12 text-white border-b border-white/10 min-h-[70vh] gl-section-reveal relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Sidebar (Columns 1-4) -->
            <div class="md:col-span-4 lg:col-span-3 gl-reveal-item">
                <div class="bg-[#0b1226]/85 backdrop-blur-xl rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)] p-6 overflow-hidden">
                    <div class="flex items-center gap-3.5 pb-6 border-b border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-cyan-400/20 border border-cyan-400/30 text-cyan-300 flex items-center justify-center font-bold text-base shadow-sm font-mono">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-white truncate text-sm font-mono">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 font-mono truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <nav class="pt-4 space-y-1.5 font-mono text-xs">
                        <a href="{{ route('account.index') }}" 
                           class="flex items-center gap-2.5 px-3.5 py-3 rounded-lg font-semibold uppercase tracking-wider transition-colors min-h-[44px] {{ request()->routeIs('account.index') ? 'bg-cyan-400/20 text-cyan-300 border border-cyan-400/40' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('account.orders') }}" 
                           class="flex items-center gap-2.5 px-3.5 py-3 rounded-lg font-semibold uppercase tracking-wider transition-colors min-h-[44px] {{ request()->routeIs('account.orders*') ? 'bg-cyan-400/20 text-cyan-300 border border-cyan-400/40' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span>Order History</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="pt-3 border-t border-white/10">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center gap-2.5 px-3.5 py-3 rounded-lg font-semibold uppercase tracking-wider text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors text-left min-h-[44px]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Content Area (Columns 5-12) -->
            <div class="md:col-span-8 lg:col-span-9 gl-reveal-item">
                @yield('account_content')
            </div>

        </div>
    </div>
</div>
@endsection
