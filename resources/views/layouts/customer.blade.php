<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GLACIAR') }} — Pure Hydration. Redefined.</title>
    <meta name="description" content="GLACIAR delivers pristine glacial spring water in architectural, high-performance thermal vessels. Pure. Cold. Minimal.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2338bdf8'><path d='M12 2.69l5.66 5.66a8 8 0 11-11.31 0z'/></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Preload Critical Above-The-Fold 3D Hero Keyframe (0ms First Paint) -->
    <link rel="preload" as="image" href="{{ asset('images/hero/3d-frames/frame_000.webp') }}" type="image/webp" fetchpriority="high">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#020617] text-slate-100 selection:bg-cyan-400 selection:text-slate-950 min-h-[100dvh] flex flex-col overflow-x-clip">
    
    <!-- 1. Ultra-thin Top Scroll Progress Indicator -->
    <div class="gl-scroll-progress" aria-hidden="true"></div>

    <!-- 3. Fast Page Load Intro Veil (<600ms Snappy Entrance) -->
    <div class="gl-page-veil" aria-hidden="true">
        <div class="flex flex-col items-center gap-3">
            <svg class="w-7 h-7 text-cyan-400" viewBox="0 0 40 40" fill="none">
                <path d="M6 32L18 8L26 22L30 14L38 32H6Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
            <span class="text-xs font-mono font-bold tracking-ultra uppercase text-white">GLACIAR</span>
        </div>
    </div>

    <!-- Flash Messages / Toast Notification -->
    @if(session('success') || session('error'))
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 4500)" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300 transform" 
             x-transition:enter-start="opacity-0 -translate-y-4" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-200 transform" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="fixed top-24 right-6 z-50 max-w-md w-full shadow-2xl rounded-xl overflow-hidden border {{ session('success') ? 'bg-glaciar-obsidian text-white border-glaciar-ice/30' : 'bg-red-950 text-white border-red-500/30' }} p-4 backdrop-blur-md">
            <div class="flex items-center gap-3">
                @if(session('success'))
                    <div class="w-8 h-8 rounded-full bg-glaciar-ice/20 text-glaciar-ice flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-glaciar-ice font-semibold">Glaciar Update</p>
                        <p class="text-sm font-medium mt-0.5 text-slate-200">{{ session('success') }}</p>
                    </div>
                @else
                    <div class="w-8 h-8 rounded-full bg-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-red-400 font-semibold">Attention</p>
                        <p class="text-sm font-medium mt-0.5 text-slate-200">{{ session('error') }}</p>
                    </div>
                @endif
                <button @click="show = false" class="ml-auto text-slate-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    <x-customer.nav />

    <main class="flex-grow flex flex-col {{ request()->routeIs('home') ? '' : 'pt-20' }}">
        @yield('content')
    </main>

    <x-customer.footer />
</body>
</html>