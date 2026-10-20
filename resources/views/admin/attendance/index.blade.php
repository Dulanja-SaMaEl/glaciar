@extends('layouts.admin')

@section('header', 'Attendance Management')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <x-admin.page-header title="Staff Attendance" buttonText="Mark Attendance" buttonRoute="{{ route('admin.attendance.create') }}" />
        
        <div class="flex gap-2">
            <a href="{{ route('admin.attendance.export.csv', request()->query()) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-semibold text-glaciar-gray-600 bg-white border border-glaciar-gray-200 hover:bg-glaciar-gray-50 hover:text-glaciar-black transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-soft border border-blue-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider relative z-10">Total Records Today</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['today_total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-emerald-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider relative z-10">Present Today</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['today_present'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-amber-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/5 rounded-full blur-xl group-hover:bg-amber-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-amber-600 uppercase tracking-wider relative z-10">Late Today</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['today_late'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-rose-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-rose-600 uppercase tracking-wider relative z-10">Absent / On Leave</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['today_absent'] }}</p>
        </div>
    </div>
    
    <!-- Search & Filters -->
    <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-4 mb-6">
        <form method="GET" action="{{ route('admin.attendance.index') }}" class="flex flex-col sm:flex-row gap-4 items-center">
            
            <div class="flex-1 w-full relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-glaciar-gray-200 rounded-xl leading-5 bg-glaciar-gray-50/50 placeholder-glaciar-gray-400 focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent sm:text-sm transition-all" placeholder="Search by rep name or ID...">
            </div>
            
            <div class="w-full sm:w-48">
                <input type="date" name="date" value="{{ request('date') }}" class="block w-full px-3 py-2.5 border border-glaciar-gray-200 rounded-xl leading-5 bg-glaciar-gray-50/50 focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent sm:text-sm transition-all" onchange="this.form.submit()">
            </div>
            
            <div class="w-full sm:w-48">
                <select name="zone_id" class="block w-full px-3 py-2.5 border border-glaciar-gray-200 rounded-xl leading-5 bg-glaciar-gray-50/50 focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent sm:text-sm transition-all" onchange="this.form.submit()">
                    <option value="">All Zones (Depts)</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full sm:w-48">
                <select name="status" class="block w-full px-3 py-2.5 border border-glaciar-gray-200 rounded-xl leading-5 bg-glaciar-gray-50/50 focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent sm:text-sm transition-all" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="Present" {{ request('status') == 'Present' ? 'selected' : '' }}>Present</option>
                    <option value="Late" {{ request('status') == 'Late' ? 'selected' : '' }}>Late</option>
                    <option value="Absent" {{ request('status') == 'Absent' ? 'selected' : '' }}>Absent</option>
                    <option value="Half Day" {{ request('status') == 'Half Day' ? 'selected' : '' }}>Half Day</option>
                    <option value="Leave" {{ request('status') == 'Leave' ? 'selected' : '' }}>Leave</option>
                    <option value="Holiday" {{ request('status') == 'Holiday' ? 'selected' : '' }}>Holiday</option>
                    <option value="Weekend" {{ request('status') == 'Weekend' ? 'selected' : '' }}>Weekend</option>
                </select>
            </div>
            
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-glaciar-black hover:bg-glaciar-gray-900 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black">
                Filter
            </button>
            @if(request()->hasAny(['search', 'date', 'status', 'zone_id']))
                <a href="{{ route('admin.attendance.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-100 transition-all">Clear</a>
            @endif
        </form>
    </div>

    <!-- Data Table -->
    <x-admin.data-table :columns="['Date', 'Employee', 'Zone', 'Check-In', 'Check-Out', 'Status', 'Actions']" :items="$attendances">
        @forelse($attendances as $record)
            <tr class="hover:bg-glaciar-gray-50/50 hover:scale-[1.002] transition-all duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">
                    {{ $record->date->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-glaciar-accent/10 text-glaciar-accent flex items-center justify-center font-bold text-xs">
                            {{ substr($record->rep->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-glaciar-black"><a href="{{ route('admin.reps.show', $record->rep_id) }}" class="hover:text-glaciar-accent">{{ $record->rep->name ?? 'Unknown' }}</a></div>
                            <div class="text-[10px] uppercase font-bold tracking-wider text-glaciar-gray-500 mt-0.5">ID: REP-{{ str_pad($record->rep_id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <span class="px-2.5 py-1 bg-glaciar-gray-100/80 text-glaciar-black rounded-lg text-xs font-semibold">{{ $record->rep->zone->name ?? 'No Zone' }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-gray-700">
                    @if($record->check_in)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            {{ $record->check_in->format('h:i A') }}
                        </div>
                    @else
                        <span class="text-glaciar-gray-400 italic">--</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-gray-700">
                    @if($record->check_out)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            {{ $record->check_out->format('h:i A') }}
                        </div>
                        @if($record->check_in)
                            <div class="text-[10px] text-glaciar-gray-400 mt-1 pl-5">
                                {{ round($record->check_in->diffInMinutes($record->check_out) / 60, 1) }} hrs
                            </div>
                        @endif
                    @else
                        <span class="text-glaciar-gray-400 italic">--</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusClass = match($record->status) {
                            'Present' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'Absent', 'Leave' => 'bg-rose-100 text-rose-700 border-rose-200',
                            'Late' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'Half Day' => 'bg-orange-100 text-orange-700 border-orange-200',
                            'Holiday', 'Weekend' => 'bg-glaciar-gray-100 text-glaciar-gray-700 border-glaciar-gray-200',
                            default => 'bg-glaciar-gray-100 text-glaciar-gray-700 border-glaciar-gray-200'
                        };
                    @endphp
                    <span class="px-3 py-1 text-xs font-bold rounded-lg border {{ $statusClass }}">
                        {{ $record->status }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.attendance.show', $record->id) }}" class="text-glaciar-accent hover:text-glaciar-accent-dark transition-colors font-semibold mr-3">View</a>
                    <a href="{{ route('admin.attendance.edit', $record->id) }}" class="text-glaciar-gray-500 hover:text-glaciar-black transition-colors font-semibold">Edit</a>
                </td>
            </tr>
        @empty
            <!-- Handled by x-admin.data-table emptyMessage -->
        @endforelse
    </x-admin.data-table>
    
    <div class="mt-4">
        {{ $attendances->links() }}
    </div>
@endsection
