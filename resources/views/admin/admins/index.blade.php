@extends('layouts.admin')
@section('header', 'Administrators')
@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-bold text-glaciar-black">Manage Administrators</h2>
            <p class="text-sm text-glaciar-gray-500 mt-1">Add, edit, or remove system administrators.</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="bg-glaciar-black text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-glaciar-dark transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Administrator
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-glaciar-black">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($admins as $admin)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 flex items-center justify-center font-bold text-xs border border-blue-300">
                                    {{ substr($admin->name, 0, 1) }}
                                </div>
                                {{ $admin->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $admin->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if(strtolower($admin->role) === 'super admin' || strtolower($admin->role) === 'super_admin')
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">Super Admin</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">{{ $admin->role }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors">Edit</a>
                                @if($admin->user_id !== auth()->id())
                                    <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this administrator?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors font-medium">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $admins->links() }}
        </div>
    </div>
@endsection
