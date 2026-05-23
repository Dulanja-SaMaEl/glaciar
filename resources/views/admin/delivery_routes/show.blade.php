@extends('layouts.admin')

@section('header', 'Manage Delivery Route')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.delivery-routes.index') }}" class="inline-flex items-center text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Routes
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Route Info -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <h2 class="text-2xl font-bold text-glaciar-black mb-2">{{ $delivery_route->name }}</h2>
                <p class="text-glaciar-gray-500 mb-6 text-sm">#RT-{{ str_pad($delivery_route->id, 3, '0', STR_PAD_LEFT) }}</p>
                
                <div class="mb-6">
                    <h3 class="text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider mb-2">Description</h3>
                    <p class="text-sm text-glaciar-black">{{ $delivery_route->description ?? 'No description provided.' }}</p>
                </div>

                <div class="border-t border-glaciar-gray-100 pt-6">
                    <a href="{{ route('admin.delivery-routes.edit', $delivery_route->id) }}" class="w-full flex justify-center py-2 px-4 border border-glaciar-gray-300 rounded-md shadow-sm text-sm font-medium text-glaciar-black bg-white hover:bg-glaciar-gray-50 transition-colors">
                        Edit Route Info
                    </a>
                </div>
            </div>
        </div>

        <!-- Assignments -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Assign Reps -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-4 border-b border-glaciar-gray-100 bg-glaciar-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-glaciar-black">Assigned Sales Representatives ({{ $delivery_route->reps->count() }})</h3>
                </div>
                
                <div class="p-4">
                    <form action="{{ route('admin.delivery-routes.sync-reps', $delivery_route->id) }}" method="POST">
                        @csrf
                        <div class="max-h-60 overflow-y-auto border border-glaciar-gray-200 rounded-md mb-4 p-2">
                            @foreach($all_reps as $rep)
                                <label class="flex items-center p-2 hover:bg-glaciar-gray-50 rounded cursor-pointer">
                                    <input type="checkbox" name="rep_ids[]" value="{{ $rep->id }}" 
                                        {{ $delivery_route->reps->contains($rep->id) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-3 text-sm text-glaciar-black font-medium">{{ $rep->name }} <span class="text-glaciar-gray-500 font-normal">({{ $rep->employee_id }})</span></span>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Save Rep Assignments
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Assign Customers -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-4 border-b border-glaciar-gray-100 bg-glaciar-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-glaciar-black">Assigned Customers ({{ $delivery_route->customers->count() }})</h3>
                </div>
                
                <div class="p-4">
                    <form action="{{ route('admin.delivery-routes.sync-customers', $delivery_route->id) }}" method="POST">
                        @csrf
                        <div class="max-h-96 overflow-y-auto border border-glaciar-gray-200 rounded-md mb-4 p-2 grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($all_customers as $customer)
                                <label class="flex items-start p-2 hover:bg-glaciar-gray-50 rounded cursor-pointer">
                                    <input type="checkbox" name="customer_ids[]" value="{{ $customer->id }}" 
                                        {{ $delivery_route->customers->contains($customer->id) ? 'checked' : '' }}
                                        class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <div class="ml-3">
                                        <span class="block text-sm text-glaciar-black font-medium">{{ $customer->name }}</span>
                                        <span class="block text-xs text-glaciar-gray-500">{{ $customer->business_name ?? 'Individual' }} • {{ $customer->city ?? 'No City' }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Save Customer Assignments
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
