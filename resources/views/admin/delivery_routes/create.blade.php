@extends('layouts.admin')

@section('header', 'Create Delivery Route')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.delivery-routes.index') }}" class="inline-flex items-center text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Routes
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 max-w-3xl mx-auto">
        <h2 class="text-xl font-bold text-glaciar-black mb-6">Route Details</h2>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.delivery-routes.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Route Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-glaciar-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end pt-6 border-t border-glaciar-gray-100">
                <a href="{{ route('admin.delivery-routes.index') }}" class="mr-4 px-4 py-2 text-sm font-medium text-glaciar-gray-700 bg-white border border-glaciar-gray-300 rounded-md hover:bg-glaciar-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Create Route
                </button>
            </div>
        </form>
    </div>
@endsection
