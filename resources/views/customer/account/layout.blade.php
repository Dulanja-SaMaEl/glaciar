@extends('layouts.customer')

@section('content')
    <div class="bg-glaciar-gray-50 flex-grow py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-glaciar-black mb-8">My Account</h1>
            
            <div class="flex flex-col md:flex-row gap-8">
                
                <!-- Account Sidebar -->
                <div class="w-full md:w-64 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-glaciar-gray-100 flex items-center">
                            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg mr-4 border border-blue-100">
                                {{ substr(Auth::user()->name ?? 'User', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-glaciar-black">{{ Auth::user()->name ?? 'Customer Name' }}</p>
                                <p class="text-sm text-glaciar-gray-500">{{ Auth::user()->type ?? 'b2c' === 'b2b' ? 'Corporate Account' : 'Personal Account' }}</p>
                            </div>
                        </div>
                        <nav class="flex flex-col p-2">
                            <a href="{{ route('account.index') }}" class="px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('account.index') ? 'bg-glaciar-gray-50 text-glaciar-black' : 'text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black transition-colors' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('account.orders') }}" class="px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('account.orders') ? 'bg-glaciar-gray-50 text-glaciar-black' : 'text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black transition-colors' }}">
                                Order History
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-glaciar-gray-100 pt-2">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    Log Out
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
                
                <!-- Account Content -->
                <div class="flex-1 space-y-8">
                    @yield('account_content')
                </div>
                
            </div>
        </div>
    </div>
@endsection
