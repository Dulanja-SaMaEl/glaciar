@extends('layouts.admin')

@section('header', 'Mark Attendance')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.attendance.index') }}" class="text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-accent transition-colors flex items-center gap-1 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to attendance
        </a>
    </div>

    <div class="max-w-3xl bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
        <div class="flex items-center gap-2 text-xl font-bold text-glaciar-black mb-6 tracking-tight">
            <svg class="w-6 h-6 text-glaciar-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Create Attendance Record
        </div>

        <form method="POST" action="{{ route('admin.attendance.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Employee / Rep</label>
                    <select name="rep_id" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" required>
                        <option value="">-- Select Employee --</option>
                        @foreach($reps as $rep)
                            <option value="{{ $rep->id }}" {{ old('rep_id') == $rep->id ? 'selected' : '' }}>{{ $rep->name }} (ID: {{ $rep->id }})</option>
                        @endforeach
                    </select>
                    @error('rep_id') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Date</label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" required>
                    @error('date') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" required>
                        @foreach(['Present', 'Absent', 'Late', 'Half Day', 'Leave', 'Holiday', 'Weekend'] as $s)
                            <option value="{{ $s }}" {{ old('status', 'Present') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('status') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Check In Time</label>
                    <input type="datetime-local" name="check_in" value="{{ old('check_in') }}" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all">
                    @error('check_in') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Check Out Time</label>
                    <input type="datetime-local" name="check_out" value="{{ old('check_out') }}" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all">
                    @error('check_out') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Remarks / Notes</label>
                    <textarea name="remarks" rows="3" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" placeholder="Optional context about this attendance record...">{{ old('remarks') }}</textarea>
                    @error('remarks') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-glaciar-gray-100/60 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-glaciar-accent to-glaciar-accent-dark hover:from-glaciar-accent-light hover:to-glaciar-accent shadow-md shadow-glaciar-accent/30 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none">
                    Save Record
                </button>
            </div>
        </form>
    </div>
@endsection
