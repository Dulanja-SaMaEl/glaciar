@extends('layouts.admin')
@section('header', isset($admin) ? 'Edit Administrator' : 'Add Administrator')
@section('content')

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.admins.index') }}" class="text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-black transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Administrators
        </a>
    </div>

    <div class="max-w-2xl bg-white rounded-xl shadow-sm border p-8">
        <h2 class="text-xl font-bold text-glaciar-black mb-6">{{ isset($admin) ? 'Update Administrator Details' : 'Create New Administrator' }}</h2>
        
        <form action="{{ isset($admin) ? route('admin.admins.update', $admin->id) : route('admin.admins.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($admin))
                @method('PUT')
            @endif

            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $admin->name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-glaciar-black focus:border-glaciar-black transition-colors" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $admin->email ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-glaciar-black focus:border-glaciar-black transition-colors" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-bold text-gray-700 mb-1">Access Role</label>
                <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-glaciar-black focus:border-glaciar-black transition-colors" required>
                    <option value="admin" {{ old('role', (isset($admin) && (strtolower($admin->role) === 'admin')) ? 'admin' : '') == 'admin' ? 'selected' : '' }}>Admin (Manager)</option>
                    <option value="super_admin" {{ old('role', (isset($admin) && (strtolower($admin->role) === 'super_admin' || strtolower($admin->role) === 'super admin')) ? 'super_admin' : '') == 'super_admin' ? 'selected' : '' }}>Super Admin (Full Access)</option>
                    <option value="staff" {{ old('role', (isset($admin) && (strtolower($admin->role) === 'staff')) ? 'staff' : '') == 'staff' ? 'selected' : '' }}>Staff (Limited Access)</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="border-t pt-6 mt-6">
                <h3 class="text-sm font-bold text-gray-700 mb-4">{{ isset($admin) ? 'Change Password (leave blank to keep current)' : 'Set Password' }}</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-600 mb-1">Password</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-glaciar-black focus:border-glaciar-black transition-colors" {{ isset($admin) ? '' : 'required' }}>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-600 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-glaciar-black focus:border-glaciar-black transition-colors" {{ isset($admin) ? '' : 'required' }}>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-glaciar-black text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-glaciar-dark transition-colors shadow-sm">
                    {{ isset($admin) ? 'Update Administrator' : 'Create Administrator' }}
                </button>
            </div>
        </form>
    </div>
@endsection
