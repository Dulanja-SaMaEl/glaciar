@extends('layouts.admin')

@section('header', 'Edit Customer')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.customers.show', $customer) }}" class="inline-flex items-center text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Customer
        </a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
            <div class="p-6 border-b border-glaciar-gray-100 bg-glaciar-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold bg-blue-50 text-blue-600 border border-blue-100">
                        {{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-glaciar-black">Edit Customer</h2>
                        <p class="text-sm text-glaciar-gray-500">{{ $customer->name }} — {{ $customer->email }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 text-red-800 text-sm font-medium mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Please fix the following errors:
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                           class="w-full rounded-lg border-glaciar-gray-300 text-sm py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('name') border-red-500 @enderror">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required
                           class="w-full rounded-lg border-glaciar-gray-300 text-sm py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('email') border-red-500 @enderror">
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}"
                           class="w-full rounded-lg border-glaciar-gray-300 text-sm py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('phone') border-red-500 @enderror">
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Address</label>
                    <textarea name="address" id="address" rows="3"
                              class="w-full rounded-lg border-glaciar-gray-300 text-sm py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('address') border-red-500 @enderror">{{ old('address', $customer->address) }}</textarea>
                </div>

                {{-- Type & Business Type --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Source</label>
                        <select name="type" id="type" class="w-full rounded-lg border-glaciar-gray-300 text-sm py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors">
                            <option value="web" {{ old('type', $customer->type) === 'web' ? 'selected' : '' }}>Web</option>
                            <option value="app" {{ old('type', $customer->type) === 'app' ? 'selected' : '' }}>App</option>
                        </select>
                    </div>
                    <div>
                        <label for="business_type" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Business Type</label>
                        <input type="text" name="business_type" id="business_type" value="{{ old('business_type', $customer->business_type) }}"
                               placeholder="e.g. Restaurant, Office, Residential"
                               class="w-full rounded-lg border-glaciar-gray-300 text-sm py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('business_type') border-red-500 @enderror">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required class="w-full rounded-lg border-glaciar-gray-300 text-sm py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors">
                        <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $customer->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ old('status', $customer->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-glaciar-gray-100">
                    <a href="{{ route('admin.customers.show', $customer) }}" class="px-5 py-2.5 bg-glaciar-gray-100 text-glaciar-gray-700 text-sm font-medium rounded-lg hover:bg-glaciar-gray-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-glaciar-black text-white text-sm font-medium rounded-lg hover:bg-glaciar-gray-900 transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
