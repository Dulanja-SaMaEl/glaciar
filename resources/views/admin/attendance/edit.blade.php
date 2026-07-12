@extends('layouts.admin')

@section('header', 'Edit Attendance')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <a href="{{ route('admin.attendance.index') }}" class="text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-accent transition-colors flex items-center gap-1 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to attendance
        </a>
        
        <form method="POST" action="{{ route('admin.attendance.destroy', $attendance->id) }}" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm font-semibold text-rose-500 hover:text-rose-700 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Delete Record
            </button>
        </form>
    </div>

    <div class="max-w-3xl bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
        <div class="flex items-center gap-2 text-xl font-bold text-glaciar-black mb-6 tracking-tight">
            <svg class="w-6 h-6 text-glaciar-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Attendance Record
        </div>

        <form method="POST" action="{{ route('admin.attendance.update', $attendance->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Employee / Rep</label>
                    <select name="rep_id" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" required>
                        @foreach($reps as $rep)
                            <option value="{{ $rep->id }}" {{ old('rep_id', $attendance->rep_id) == $rep->id ? 'selected' : '' }}>{{ $rep->name }} (ID: {{ $rep->id }})</option>
                        @endforeach
                    </select>
                    @error('rep_id') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Date</label>
                    <input type="date" name="date" value="{{ old('date', $attendance->date->format('Y-m-d')) }}" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" required>
                    @error('date') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" required>
                        @foreach(['Present', 'Absent', 'Late', 'Half Day', 'Leave', 'Holiday', 'Weekend'] as $s)
                            <option value="{{ $s }}" {{ old('status', $attendance->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('status') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Check In Time</label>
                    <input type="datetime-local" name="check_in" value="{{ old('check_in', $checkInFormatted) }}" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all">
                    @error('check_in') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Check Out Time</label>
                    <input type="datetime-local" name="check_out" value="{{ old('check_out', $checkOutFormatted) }}" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all">
                    @error('check_out') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Remarks / Notes</label>
                    <textarea name="remarks" rows="3" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" placeholder="Optional context about this attendance record...">{{ old('remarks', $attendance->remarks) }}</textarea>
                    @error('remarks') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-glaciar-gray-100/60 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-glaciar-accent to-glaciar-accent-dark hover:from-glaciar-accent-light hover:to-glaciar-accent shadow-md shadow-glaciar-accent/30 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none">
                    Update Record
                </button>
            </div>
        </form>
    </div>
@endsection
