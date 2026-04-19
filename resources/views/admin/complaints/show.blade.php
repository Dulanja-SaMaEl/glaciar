@extends('layouts.admin')

@section('header', 'Complaint')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.complaints.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">← Back to complaints</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-sm text-glaciar-gray-500">Ticket</div>
                        <div class="text-2xl font-bold text-glaciar-black">#CMP-{{ str_pad($complaint->id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="mt-2 text-sm text-glaciar-gray-600">
                            <span class="font-semibold text-glaciar-black">{{ $complaint->category }}</span>
                            <span class="mx-2 text-glaciar-gray-300">•</span>
                            Priority: <span class="font-semibold text-glaciar-black">{{ $complaint->priority }}</span>
                        </div>
                    </div>
                    <x-admin.status-badge :status="$complaint->status" />
                </div>

                <div class="mt-6">
                    <div class="text-sm font-semibold text-glaciar-black mb-2">Description</div>
                    <div class="text-sm text-glaciar-gray-700 whitespace-pre-line">{{ $complaint->description }}</div>
                </div>

                @if($complaint->photo_path)
                    <div class="mt-6">
                        <div class="text-sm font-semibold text-glaciar-black mb-2">Photo</div>
                        <a class="text-blue-600 hover:text-blue-800 text-sm" href="{{ url('/storage/'.$complaint->photo_path) }}" target="_blank">View uploaded photo</a>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="text-lg font-bold text-glaciar-black mb-4">Resolution / Status</div>
                <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-semibold text-glaciar-black mb-1">Status</label>
                        <select name="status" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            @foreach(['Open','In Progress','Resolved','Closed'] as $s)
                                <option value="{{ $s }}" {{ old('status', $complaint->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-glaciar-black mb-1">Resolution</label>
                        <textarea name="resolution" rows="5" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">{{ old('resolution', $complaint->resolution) }}</textarea>
                        @error('resolution') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <button class="px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-[#111]">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="text-sm font-bold text-glaciar-gray-500 uppercase">Customer</div>
                <div class="mt-2 text-lg font-bold text-glaciar-black">{{ $complaint->customer?->name ?? '—' }}</div>
                <div class="text-sm text-glaciar-gray-600">{{ $complaint->customer?->email ?? '' }}</div>
                <div class="text-sm text-glaciar-gray-600">{{ $complaint->customer?->phone ?? '' }}</div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="text-sm font-bold text-glaciar-gray-500 uppercase">Sales Rep</div>
                <div class="mt-2 text-lg font-bold text-glaciar-black">{{ $complaint->rep?->name ?? '—' }}</div>
                <div class="text-sm text-glaciar-gray-600">{{ $complaint->rep?->email ?? '' }}</div>
            </div>
        </div>
    </div>
@endsection

