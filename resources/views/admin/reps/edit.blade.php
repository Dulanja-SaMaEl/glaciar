@extends('layouts.admin')

@section('header', 'Edit Sales Rep')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.reps.index') }}" class="inline-flex items-center text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Sales Reps
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 max-w-3xl mx-auto">
        <h2 class="text-xl font-bold text-glaciar-black mb-6">Edit Representative: {{ $rep->name }}</h2>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reps.update', $rep->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $rep->name) }}" required
                           class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Employee ID *</label>
                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $rep->employee_id) }}" required
                           class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $rep->email) }}" required
                           class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $rep->phone) }}"
                           class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="zone_id" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Assigned Zone</label>
                    <select name="zone_id" id="zone_id" class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select a zone...</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id', $rep->zone_id) == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Status *</label>
                    <select name="status" id="status" required class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="active" {{ old('status', $rep->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $rep->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <h3 class="text-lg font-bold text-glaciar-black mb-4 border-t border-glaciar-gray-100 pt-6">Security (Leave blank to keep current password)</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-glaciar-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-between pt-6 border-t border-glaciar-gray-100">
                <button type="button" class="px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-300 rounded-md hover:bg-red-50" onclick="if(confirm('Are you sure you want to delete this sales rep?')) document.getElementById('delete-form').submit();">
                    Delete Rep
                </button>

                <div>
                    <a href="{{ route('admin.reps.index') }}" class="mr-4 px-4 py-2 text-sm font-medium text-glaciar-gray-700 bg-white border border-glaciar-gray-300 rounded-md hover:bg-glaciar-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Update Rep
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('admin.reps.destroy', $rep->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
