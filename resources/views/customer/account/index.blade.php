@extends('customer.account.layout')

@section('account_content')
    <h2 class="text-2xl font-bold text-glaciar-black mb-6">Overview</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-glaciar-gray-500 mb-1">Total Orders</p>
                <h3 class="text-3xl font-bold text-glaciar-black">{{ Auth::user()->orders()->count() ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        
        <!-- Next Delivery Estimate -->
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 flex flex-col justify-center">
            <h3 class="text-sm font-medium text-glaciar-gray-500 mb-2">Delivery Zone</h3>
            <p class="text-lg font-bold text-glaciar-black">{{ Auth::user()->zone->name ?? 'Zone not set' }}</p>
            <p class="text-sm text-green-600 mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Deliveries available all week
            </p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
        <h3 class="text-lg font-bold text-glaciar-black mb-4">Account Details</h3>
        
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-glaciar-gray-100 pb-4">
                <div class="text-sm font-medium text-glaciar-gray-500">Full name</div>
                <div class="md:col-span-2 text-sm text-glaciar-black">{{ Auth::user()->name }}</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-glaciar-gray-100 pb-4">
                <div class="text-sm font-medium text-glaciar-gray-500">Email address</div>
                <div class="md:col-span-2 text-sm text-glaciar-black">{{ Auth::user()->email }}</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-glaciar-gray-100 pb-4">
                <div class="text-sm font-medium text-glaciar-gray-500">Phone number</div>
                <div class="md:col-span-2 text-sm text-glaciar-black">{{ Auth::user()->phone ?? 'Not provided' }}</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-glaciar-gray-100 pb-4">
                <div class="text-sm font-medium text-glaciar-gray-500">Delivery address</div>
                <div class="md:col-span-2 text-sm text-glaciar-black">{{ Auth::user()->address ?? 'Not provided' }}</div>
            </div>
            <div class="pt-2 text-right">
                <button class="text-sm font-semibold text-blue-600 hover:text-blue-800">Edit Details (Disabled for Demo)</button>
            </div>
        </div>
    </div>
@endsection
