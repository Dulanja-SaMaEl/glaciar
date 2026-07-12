@extends('layouts.admin')

@section('header', 'Attendance Details')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.attendance.index') }}" class="text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-accent transition-colors flex items-center gap-1 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to attendance
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8 relative overflow-hidden">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4 border-b border-glaciar-gray-100/60 pb-6 mb-6">
                    <div>
                        <div class="text-sm font-bold text-glaciar-gray-400 uppercase tracking-wider mb-1">Attendance Record</div>
                        <div class="text-3xl font-black text-glaciar-black tracking-tight">{{ $attendance->date->format('l, F j, Y') }}</div>
                        <div class="mt-3 flex items-center gap-3 text-sm text-glaciar-gray-600">
                            <span class="px-3 py-1 bg-glaciar-gray-50 text-glaciar-black rounded-lg font-semibold">{{ $attendance->rep->zone->name ?? 'No Zone' }}</span>
                            <span class="text-glaciar-gray-300">•</span>
                            <span class="font-medium flex items-center gap-1">
                                Rep: <a href="{{ route('admin.reps.show', $attendance->rep_id) }}" class="font-bold text-glaciar-accent hover:text-glaciar-accent-dark">{{ $attendance->rep->name }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        @php
                            $statusClass = match($attendance->status) {
                                'Present' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'Absent', 'Leave' => 'bg-rose-100 text-rose-700 border-rose-200',
                                'Late' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'Half Day' => 'bg-orange-100 text-orange-700 border-orange-200',
                                'Holiday', 'Weekend' => 'bg-glaciar-gray-100 text-glaciar-gray-700 border-glaciar-gray-200',
                                default => 'bg-glaciar-gray-100 text-glaciar-gray-700 border-glaciar-gray-200'
                            };
                        @endphp
                        <span class="px-4 py-1.5 text-sm font-bold rounded-lg border shadow-sm {{ $statusClass }}">
                            {{ $attendance->status }}
                        </span>
                        
                        <a href="{{ route('admin.attendance.edit', $attendance->id) }}" class="mt-2 text-xs font-bold text-glaciar-gray-500 hover:text-glaciar-black flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Record
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-glaciar-gray-50/50 rounded-xl p-5 border border-glaciar-gray-100">
                        <div class="text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Check In
                        </div>
                        @if($attendance->check_in)
                            <div class="text-2xl font-black text-glaciar-black mb-1">{{ $attendance->check_in->format('h:i A') }}</div>
                            @if($attendance->check_in_location)
                                <div class="text-xs text-glaciar-gray-500 flex items-center gap-1 mt-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $attendance->check_in_location }}
                                </div>
                            @endif
                        @else
                            <div class="text-lg font-medium text-glaciar-gray-400 italic">No check in recorded</div>
                        @endif
                    </div>
                    
                    <div class="bg-glaciar-gray-50/50 rounded-xl p-5 border border-glaciar-gray-100">
                        <div class="text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Check Out
                        </div>
                        @if($attendance->check_out)
                            <div class="text-2xl font-black text-glaciar-black mb-1">{{ $attendance->check_out->format('h:i A') }}</div>
                            @if($attendance->check_out_location)
                                <div class="text-xs text-glaciar-gray-500 flex items-center gap-1 mt-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $attendance->check_out_location }}
                                </div>
                            @endif
                        @else
                            <div class="text-lg font-medium text-glaciar-gray-400 italic">No check out recorded</div>
                        @endif
                    </div>
                </div>

                @if($attendance->check_in && $attendance->check_out)
                    <div class="mt-6 pt-6 border-t border-glaciar-gray-100/60 flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-glaciar-gray-500 uppercase">Total Working Hours</div>
                            <div class="text-xl font-black text-glaciar-black">{{ round($attendance->check_in->diffInMinutes($attendance->check_out) / 60, 2) }} Hours</div>
                        </div>
                    </div>
                @endif
                
                @if($attendance->remarks)
                    <div class="mt-8 pt-6 border-t border-glaciar-gray-100/60">
                        <div class="text-sm font-bold text-glaciar-gray-500 uppercase tracking-wider mb-3">Remarks / Notes</div>
                        <div class="text-base text-glaciar-gray-700 whitespace-pre-line leading-relaxed bg-amber-50/50 p-6 rounded-xl border border-amber-100/50">{{ $attendance->remarks }}</div>
                    </div>
                @endif
            </div>
            
            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
                <div class="text-xs font-bold text-glaciar-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-glaciar-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Recent Attendance History
                </div>
                
                @if($history->count() > 0)
                    <div class="space-y-4">
                        @foreach($history as $hist)
                            <div class="flex justify-between items-center pb-3 border-b border-glaciar-gray-100/60 last:border-0 last:pb-0">
                                <div>
                                    <div class="text-sm font-bold text-glaciar-black">
                                        <a href="{{ route('admin.attendance.show', $hist->id) }}" class="hover:text-glaciar-accent">{{ $hist->date->format('M d, Y') }}</a>
                                    </div>
                                    <div class="text-xs text-glaciar-gray-500 mt-0.5">
                                        @if($hist->check_in)
                                            {{ $hist->check_in->format('h:i A') }} - 
                                            {{ $hist->check_out ? $hist->check_out->format('h:i A') : '?' }}
                                        @else
                                            No times recorded
                                        @endif
                                    </div>
                                </div>
                                
                                @php
                                    $histStatusClass = match($hist->status) {
                                        'Present' => 'bg-emerald-100 text-emerald-700',
                                        'Absent', 'Leave' => 'bg-rose-100 text-rose-700',
                                        'Late' => 'bg-amber-100 text-amber-700',
                                        'Half Day' => 'bg-orange-100 text-orange-700',
                                        default => 'bg-glaciar-gray-100 text-glaciar-gray-700'
                                    };
                                @endphp
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $histStatusClass }}">
                                    {{ $hist->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-glaciar-gray-500 italic text-sm">No recent attendance history found.</div>
                @endif
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="xl:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
                <div class="text-xs font-bold text-glaciar-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-glaciar-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Employee Profile
                </div>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-lg">
                        {{ substr($attendance->rep->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-lg font-bold text-glaciar-black">{{ $attendance->rep->name }}</div>
                        <div class="text-sm text-glaciar-gray-500">ID: REP-{{ str_pad($attendance->rep_id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-glaciar-gray-600">
                        <svg class="w-4 h-4 text-glaciar-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="truncate">{{ $attendance->rep->email ?? 'No email provided' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-glaciar-gray-600">
                        <svg class="w-4 h-4 text-glaciar-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>{{ $attendance->rep->phone ?? 'No phone provided' }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-glaciar-gray-100/60 text-right">
                    <a href="{{ route('admin.reps.show', $attendance->rep->id) }}" class="text-sm font-semibold text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">View Full Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection
