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

    <!-- Required CDNs for Admin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</head>
<body class="font-sans antialiased text-glaciar-black bg-[#F5F5F5] h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-glaciar-black text-glaciar-white flex flex-col flex-shrink-0">
        <div class="h-16 flex items-center justify-center border-b border-glaciar-gray-700">
            <span class="text-xl font-bold tracking-widest">GLACIAR ADMIN</span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 space-y-1">
            <x-admin.sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="chart-bar">Dashboard</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.reps.index')" :active="request()->routeIs('admin.reps.*')" icon="user-group">Sales Reps</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.map')" :active="request()->routeIs('admin.map')" icon="map">Live Map</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" icon="shopping-bag" :badge="\App\Models\Order::where('status', 'pending')->count()">Orders</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')" icon="users">Customers</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')" icon="credit-card">Payments</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.inventory.index')" :active="request()->routeIs('admin.inventory.*')" icon="cube">Inventory</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.complaints.index')" :active="request()->routeIs('admin.complaints.*')" icon="flag" :badge="\App\Models\Complaint::where('status', 'Open')->count()">Complaints</x-admin.sidebar-link>
            
            <x-admin.sidebar-link :href="route('admin.attendance.index')" :active="request()->routeIs('admin.attendance.*')" icon="calendar">Attendance</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.sales.index')" :active="request()->routeIs('admin.sales.*')" icon="currency-dollar">Sales & Salary</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" icon="document-chart-bar">Reports</x-admin.sidebar-link>
            <x-admin.sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')" icon="cog">Settings</x-admin.sidebar-link>
        </nav>

        <div class="p-4 border-t border-glaciar-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-glaciar-gray-300 hover:text-white hover:bg-[#1A1A1A] rounded transition-colors group">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top header -->
        <header class="h-16 bg-white border-b border-glaciar-gray-100 flex items-center justify-between px-6 flex-shrink-0">
            <h1 class="text-xl font-semibold text-glaciar-black">@yield('header', 'Admin Panel')</h1>
            
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium">{{ Auth::user()?->name ?? 'Admin User' }}</span>
                <div class="w-8 h-8 rounded-full bg-glaciar-gray-300 flex items-center justify-center text-sm font-bold">
                    {{ substr(Auth::user()?->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Page content wrapper -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
