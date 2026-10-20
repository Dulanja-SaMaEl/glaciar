<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GLACIAR Admin Portal') }}</title>

    <!-- Theme Initialization (Zero FOUC) -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cinzel:wght@600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- CSS/JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Required CDNs for Admin Visualization & Mapping -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body x-data="{ darkMode: document.documentElement.classList.contains('dark') }" 
      class="font-sans antialiased text-slate-800 dark:text-slate-100 bg-[#f8fafc] dark:bg-[#070b12] h-screen flex overflow-hidden selection:bg-cyan-500 selection:text-white transition-colors duration-200">

    <!-- ═══════════════════════════════════════════════════════════════════
         1. SIDEBAR (MODERN OBSIDIAN COMMAND NAVIGATION)
         ═══════════════════════════════════════════════════════════════════ -->
    <aside class="w-64 bg-[#0a0f18] dark:bg-[#06090e] text-white flex flex-col flex-shrink-0 border-r border-white/10 z-20 shadow-2xl transition-all duration-300">
        
        <!-- Brand Header with Twin Peak Vector -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 relative overflow-hidden flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <svg class="w-6 h-6 text-cyan-400 group-hover:text-cyan-300 transition-colors drop-shadow-[0_0_8px_rgba(56,189,248,0.5)]" viewBox="0 0 32 22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 20L11 5L19 20" />
                    <path d="M15 20L21 9L29 20" />
                </svg>
                <div class="flex flex-col">
                    <span class="text-lg font-serif font-bold tracking-[0.2em] text-white group-hover:text-cyan-200 transition-colors">GLACIAR</span>
                    <span class="text-[9px] font-mono tracking-widest uppercase text-cyan-400/80 -mt-0.5">COMMAND CENTER</span>
                </div>
            </a>
        </div>

        <!-- Navigation Links Tree -->
        <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-1 custom-scrollbar">
            
            <div class="px-3 pb-1 text-[10px] font-mono font-bold uppercase tracking-wider text-slate-500">Overview</div>
            <x-admin.sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="chart-bar">Dashboard</x-admin.sidebar-link>
            
            @if(Auth::user()?->role === 'super_admin')
            <x-admin.sidebar-link :href="route('admin.admins.index')" :active="request()->routeIs('admin.admins.*')" icon="shield-check">Administrators</x-admin.sidebar-link>
            @endif

            <div class="pt-4 px-3 pb-1 text-[10px] font-mono font-bold uppercase tracking-wider text-slate-500">Operations & Fleet</div>
            <x-admin.sidebar-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" icon="shopping-bag" :badge="\App\Models\Order::where('status', 'pending')->count()">Orders</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')" icon="users">Customers</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')" icon="credit-card">Payments</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.reps.index')" :active="request()->routeIs('admin.reps.*')" icon="user-group">Sales Reps</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.delivery-routes.index')" :active="request()->routeIs('admin.delivery-routes.*')" icon="truck">Delivery Routes</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.map')" :active="request()->routeIs('admin.map')" icon="map">Live GPS Map</x-admin.sidebar-link>

            <div class="pt-4 px-3 pb-1 text-[10px] font-mono font-bold uppercase tracking-wider text-slate-500">Logistics & Supply</div>
            
            <!-- Stock & Inventory Dropdown -->
            <div x-data="{ expanded: {{ request()->routeIs('admin.inventory.*') ? 'true' : 'false' }} }" class="space-y-0.5">
                <button @click="expanded = !expanded" 
                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.inventory.*') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.inventory.*') ? 'text-cyan-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="tracking-wide">Inventory & ERP</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="expanded" x-collapse class="pl-11 pr-2 py-1 space-y-1">
                    <a href="{{ route('admin.inventory.dashboard') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.inventory.dashboard') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Inventory Dashboard</a>
                    <a href="{{ route('admin.inventory.products.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.inventory.products.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Products & Vessels</a>
                    <a href="{{ route('admin.inventory.categories.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.inventory.categories.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Categories</a>
                    <a href="{{ route('admin.inventory.suppliers.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.inventory.suppliers.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Suppliers</a>
                    <a href="{{ route('admin.inventory.purchases.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.inventory.purchases.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Stock Purchases</a>
                    <a href="{{ route('admin.inventory.transactions.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.inventory.transactions.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Stock Adjustments</a>
                </div>
            </div>

            <x-admin.sidebar-link :href="route('admin.complaints.index')" :active="request()->routeIs('admin.complaints.*')" icon="flag" :badge="\App\Models\Complaint::where('status', 'Open')->count()">Support Complaints</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.attendance.index')" :active="request()->routeIs('admin.attendance.*')" icon="calendar">Staff Attendance</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.sales.index')" :active="request()->routeIs('admin.sales.*')" icon="currency-dollar">Sales & Salary</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.payroll.history')" :active="request()->routeIs('admin.payroll.*')" icon="document-text">Payroll History</x-admin.sidebar-link>

            <div class="pt-4 px-3 pb-1 text-[10px] font-mono font-bold uppercase tracking-wider text-slate-500">Audits & Governance</div>

            <!-- Reports Dropdown (Clean, Collapsible Accordion) -->
            <div x-data="{ expanded: {{ request()->routeIs('admin.reports.*') || request()->routeIs('admin.pest-control.*') || request()->routeIs('admin.training-attendance.*') || request()->routeIs('admin.tank-cleaning.*') ? 'true' : 'false' }} }" class="space-y-0.5">
                <button @click="expanded = !expanded" 
                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.reports.*') || request()->routeIs('admin.pest-control.*') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.reports.*') ? 'text-cyan-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="tracking-wide">Quality Reports</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="expanded" x-collapse class="pl-11 pr-2 py-1 space-y-1">
                    <a href="{{ route('admin.reports.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.reports.index') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Compliance Hub</a>
                    <a href="{{ route('admin.pest-control.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.pest-control.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Pest Control</a>
                    <a href="{{ route('admin.tank-cleaning.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.tank-cleaning.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Tank Sanitation</a>
                    <a href="{{ route('admin.raw-water-testing.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.raw-water-testing.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Water Testing</a>
                    <a href="{{ route('admin.treated-water-testing.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.treated-water-testing.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">Treated Water</a>
                    <a href="{{ route('admin.uv-bulb-monitoring.index') }}" class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->routeIs('admin.uv-bulb-monitoring.*') ? 'text-cyan-300 font-bold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">UV Sterilization</a>
                </div>
            </div>

            <x-admin.sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')" icon="cog">System Settings</x-admin.sidebar-link>
        </nav>

        <!-- Bottom Session Bar -->
        <div class="p-4 border-t border-white/10 bg-white/[0.02]">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-all duration-200 group">
                    <svg class="w-4 h-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ═══════════════════════════════════════════════════════════════════
         2. MAIN VIEWPORT & GLASSMORPHIC EXECUTIVE HEADER
         ═══════════════════════════════════════════════════════════════════ -->
    <div class="flex-1 flex flex-col overflow-hidden relative">
        
        <!-- Header -->
        <header class="h-20 bg-white/80 dark:bg-[#0c121e]/90 backdrop-blur-xl border-b border-slate-200/80 dark:border-white/10 flex items-center justify-between px-6 sm:px-8 flex-shrink-0 z-10 shadow-sm transition-colors duration-200">
            
            <!-- Left Header Title & Breadcrumb -->
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight drop-shadow-sm">
                    @yield('header', 'Executive Command')
                </h1>
                <div class="text-[11px] font-mono uppercase tracking-wider text-slate-400 dark:text-slate-400 mt-0.5 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_6px_#10b981]"></span>
                    <span>SESSION ACTIVE · {{ date('D, M d Y') }}</span>
                </div>
            </div>

            <!-- Right Controls: View Storefront, Dark Mode Switch, Notifications, User Menu -->
            <div class="flex items-center gap-3 sm:gap-4">
                
                <!-- 1. View Client Storefront Pill -->
                <a href="{{ route('home') }}" target="_blank" 
                   class="hidden md:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:text-cyan-500 dark:hover:text-cyan-300 hover:border-cyan-400/40 text-xs font-semibold tracking-wider transition-all duration-200">
                    <span>View Boutique</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>

                <!-- 2. Dark Mode Switcher -->
                <button @click="darkMode = !darkMode; if (darkMode) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; }"
                        class="p-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/10 transition-all duration-200 focus:outline-none"
                        aria-label="Toggle Theme Mode">
                    <!-- Sun (when dark) -->
                    <template x-if="darkMode">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </template>
                    <!-- Moon (when light) -->
                    <template x-if="!darkMode">
                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </template>
                </button>

                <!-- 3. Notifications Flyout -->
                @php
                    $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                    $openComplaintsCount = \App\Models\Complaint::where('status', 'Open')->count();
                    $totalAlerts = $pendingOrdersCount + $openComplaintsCount;
                @endphp
                <div x-data="{ notifOpen: false }" class="relative">
                    <button @click="notifOpen = !notifOpen" 
                            class="relative p-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if($totalAlerts > 0)
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white dark:ring-[#0c121e]"></span>
                        @endif
                    </button>

                    <div x-show="notifOpen" 
                         @click.away="notifOpen = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 rounded-2xl bg-white dark:bg-[#0d1522] border border-slate-200 dark:border-white/10 shadow-2xl p-4 z-50">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-white/10 mb-3">
                            <h4 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-900 dark:text-white">Active Alerts</h4>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-cyan-500/10 text-cyan-500 font-bold">{{ $totalAlerts }} items</span>
                        </div>
                        <div class="space-y-2 text-xs">
                            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span class="text-slate-700 dark:text-slate-300">Pending Orders</span>
                                </div>
                                <span class="font-mono font-bold text-slate-900 dark:text-white">{{ $pendingOrdersCount }}</span>
                            </a>
                            <a href="{{ route('admin.complaints.index', ['status' => 'Pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    <span class="text-slate-700 dark:text-slate-300">Support Inquiries</span>
                                </div>
                                <span class="font-mono font-bold text-slate-900 dark:text-white">{{ $openComplaintsCount }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="h-8 w-px bg-slate-200 dark:bg-white/10"></div>

                <!-- 4. User Profile Menu -->
                <div x-data="{ profileOpen: false }" class="relative">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 cursor-pointer group focus:outline-none">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-cyan-400 transition-colors">
                                {{ Auth::user()?->name ?? 'Glaciar Admin' }}
                            </span>
                            <span class="text-[10px] font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                {{ Auth::user()?->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                            </span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-sky-600 flex items-center justify-center text-sm font-black text-slate-950 shadow-md shadow-cyan-500/20 group-hover:shadow-cyan-400/40 transition-all border border-white/20">
                            {{ substr(Auth::user()?->name ?? 'A', 0, 1) }}
                        </div>
                    </button>

                    <div x-show="profileOpen" 
                         @click.away="profileOpen = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 rounded-2xl bg-white dark:bg-[#0d1522] border border-slate-200 dark:border-white/10 shadow-2xl p-2 z-50 text-xs">
                        <div class="p-3 border-b border-slate-100 dark:border-white/10 mb-1">
                            <p class="font-bold text-slate-900 dark:text-white">{{ Auth::user()?->name }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-mono mt-0.5 truncate">{{ Auth::user()?->email }}</p>
                        </div>
                        <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">System Settings</a>
                        @if(Auth::user()?->role === 'super_admin')
                            <a href="{{ route('admin.admins.index') }}" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">Administrator Access</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="mt-1 pt-1 border-t border-slate-100 dark:border-white/10">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 font-semibold transition-colors">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </header>

        <!-- Main Page Content Body -->
        <main class="flex-1 overflow-y-auto p-6 sm:p-8 custom-scrollbar">
            <div class="max-w-7xl mx-auto pb-12">
                @yield('content')
            </div>
        </main>

    </div>

    <!-- Scrollbar Polish -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.25);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(56, 189, 248, 0.5);
        }
    </style>
</body>
</html>
