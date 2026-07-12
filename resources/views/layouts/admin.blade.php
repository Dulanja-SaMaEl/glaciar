<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Glaciar Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS/JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Required CDNs for Admin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</head>
<body class="font-sans antialiased text-glaciar-gray-700 bg-glaciar-gray-50 h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-glaciar-black to-glaciar-dark text-white flex flex-col flex-shrink-0 shadow-2xl z-20 transition-all duration-300">
        <div class="h-20 flex items-center justify-center border-b border-white/10 relative overflow-hidden">
            <div class="absolute inset-0 bg-glaciar-accent/10 backdrop-blur-sm"></div>
            <span class="text-2xl font-bold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-200 relative z-10 drop-shadow-md">GLACIAR</span>
            <span class="text-xs font-semibold uppercase tracking-wider text-glaciar-accent-light absolute bottom-2 right-4 z-10">Admin</span>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1.5 custom-scrollbar">
            <x-admin.sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="chart-bar">Dashboard</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.reps.index')" :active="request()->routeIs('admin.reps.*')" icon="user-group">Sales Reps</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.delivery-routes.index')" :active="request()->routeIs('admin.delivery-routes.*')" icon="truck">Delivery Routes</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.map')" :active="request()->routeIs('admin.map')" icon="map">Live Map</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" icon="shopping-bag" :badge="\App\Models\Order::where('status', 'pending')->count()">Orders</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')" icon="users">Customers</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')" icon="credit-card">Payments</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.inventory.index')" :active="request()->routeIs('admin.inventory.*')" icon="cube">Inventory</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.complaints.index')" :active="request()->routeIs('admin.complaints.*')" icon="flag" :badge="\App\Models\Complaint::where('status', 'Open')->count()">Complaints</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.attendance.index')" :active="request()->routeIs('admin.attendance.*')" icon="calendar">Attendance</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.sales.index')" :active="request()->routeIs('admin.sales.*')" icon="currency-dollar">Sales & Salary</x-admin.sidebar-link>
            
            <!-- Reports - Expandable -->
            <div x-data="{ expanded: true }" class="mt-2">
                <button @click="expanded = !expanded" class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-glaciar-gray-300 hover:text-white hover:bg-white/5 rounded-xl transition-all duration-200 group">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-glaciar-gray-400 group-hover:text-glaciar-accent-light transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="font-medium tracking-wide">Reports</span>
                    </div>
                    <svg :class="{'rotate-180': expanded}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="expanded" x-collapse class="ml-4 mt-2 space-y-1 border-l border-white/10 pl-2">
                    <div class="px-3 py-1 mt-1 text-[10px] font-bold text-glaciar-gray-500 uppercase tracking-widest">Sales Reports</div>
                    <a href="{{ route('admin.reports.index') }}" class="block px-3 py-2 text-sm text-glaciar-gray-300 hover:text-white hover:translate-x-1 transition-all duration-200">Sales Overview</a>
                    
                    <div class="px-3 py-1 mt-3 text-[10px] font-bold text-glaciar-gray-500 uppercase tracking-widest">Quality Reports</div>
                    <a href="{{ route('admin.pest-control.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.pest-control.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">Pest Control</a>
                    <a href="{{ route('admin.training-attendance.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.training-attendance.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">Training Attendance</a>
                    <a href="{{ route('admin.tank-cleaning.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.tank-cleaning.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">Tank Cleaning</a>
                    <a href="{{ route('admin.raw-water-testing.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.raw-water-testing.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">Raw Water Testing</a>
                    <a href="{{ route('admin.raw-material-inspection.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.raw-material-inspection.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">Material Inspection</a>
                    <a href="{{ route('admin.treated-water-testing.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.treated-water-testing.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">Treated Water</a>
                    <a href="{{ route('admin.daily-cleaning.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.daily-cleaning.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">Daily Cleaning</a>
                    <a href="{{ route('admin.uv-bulb-monitoring.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.uv-bulb-monitoring.*') ? 'text-white font-semibold flex items-center before:content-[\'\'] before:w-1.5 before:h-1.5 before:bg-glaciar-accent-light before:rounded-full before:-ml-2 before:mr-2' : 'text-glaciar-gray-300 hover:text-white hover:translate-x-1' }} transition-all duration-200">UV Bulb</a>
                </div>
            </div>

            <x-admin.sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')" icon="cog">Settings</x-admin.sidebar-link>
        </nav>

        <div class="p-4 border-t border-white/10 bg-white/5 backdrop-blur-md">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm font-medium text-glaciar-gray-300 hover:text-white hover:bg-red-500/10 hover:text-red-400 rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden bg-glaciar-gray-50/50 relative">
        <!-- Top header - Glassmorphic -->
        <header class="h-20 bg-white/70 backdrop-blur-lg border-b border-glaciar-gray-100/50 flex items-center justify-between px-8 flex-shrink-0 z-10 shadow-sm transition-all duration-300">
            <h1 class="text-2xl font-bold text-glaciar-black tracking-tight drop-shadow-sm">@yield('header', 'Admin Panel')</h1>
            
            <div class="flex items-center gap-6">
                <!-- Notifications Bell (mock) -->
                <button class="relative p-2 text-glaciar-gray-500 hover:text-glaciar-accent transition-colors rounded-full hover:bg-glaciar-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                <div class="h-8 w-px bg-glaciar-gray-200"></div>

                <div class="flex items-center gap-3 cursor-pointer group">
                    <div class="flex flex-col items-end">
                        <span class="text-sm font-bold text-glaciar-black group-hover:text-glaciar-accent transition-colors">{{ Auth::user()?->name ?? 'Administrator' }}</span>
                        <span class="text-xs text-glaciar-gray-500 font-medium">Super Admin</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-glaciar-accent to-glaciar-accent-dark flex items-center justify-center text-sm font-bold text-white shadow-md shadow-glaciar-accent/30 group-hover:shadow-glow transition-all duration-300 border-2 border-white">
                        {{ substr(Auth::user()?->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content wrapper -->
        <main class="flex-1 overflow-y-auto p-8 animate-fade-in custom-scrollbar">
            <div class="max-w-7xl mx-auto pb-12">
                @yield('content')
            </div>
        </main>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.2);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.4);
        }
    </style>
</body>
</html>
