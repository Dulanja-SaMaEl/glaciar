@extends('layouts.admin')

@section('header', 'Customer Support')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <x-admin.page-header title="Complaints & Issues" />
        
        <!-- Filter Toggle -->
        <div class="flex bg-white rounded-xl shadow-soft border border-glaciar-gray-100/60 p-1.5 gap-1">
            <a href="{{ route('admin.complaints.index', ['search' => request('search'), 'priority' => request('priority')]) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ !request()->has('status') ? 'bg-glaciar-accent text-white shadow-md shadow-glaciar-accent/30' : 'bg-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black' }}">All Open</a>
            <a href="{{ route('admin.complaints.index', ['status' => 'Pending', 'search' => request('search'), 'priority' => request('priority')]) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all flex items-center gap-2 {{ request('status') === 'Pending' ? 'bg-glaciar-accent text-white shadow-md shadow-glaciar-accent/30' : 'bg-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black' }}">
                New 
                @if($stats['unassigned'] > 0)
                    <span class="bg-rose-500 text-white rounded-full px-2 py-0.5 text-[10px] font-bold shadow-[0_0_8px_rgba(244,63,94,0.6)]">{{ $stats['unassigned'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'Resolved', 'search' => request('search'), 'priority' => request('priority')]) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ request('status') === 'Resolved' ? 'bg-glaciar-accent text-white shadow-md shadow-glaciar-accent/30' : 'bg-transparent text-glaciar-gray-500 hover:bg-glaciar-gray-50 hover:text-glaciar-black' }}">Resolved</a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-soft border border-rose-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-rose-600 uppercase tracking-wider relative z-10">Unassigned</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['unassigned'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-amber-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/5 rounded-full blur-xl group-hover:bg-amber-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-amber-600 uppercase tracking-wider relative z-10">In Progress</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-blue-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider relative z-10">Total Active</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['total_open'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-emerald-100/60 p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors duration-500"></div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider relative z-10">Resolved Today</p>
            <p class="text-3xl font-black text-glaciar-black mt-2 tracking-tight relative z-10">{{ $stats['resolved_today'] }}</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-4 mb-6">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="flex flex-col sm:flex-row gap-4 items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="flex-1 w-full relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-glaciar-gray-200 rounded-xl leading-5 bg-glaciar-gray-50/50 placeholder-glaciar-gray-400 focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent sm:text-sm transition-all" placeholder="Search by ID, customer name, category or description...">
            </div>
            
            <div class="w-full sm:w-48">
                <select name="priority" class="block w-full pl-3 pr-10 py-2.5 border border-glaciar-gray-200 rounded-xl leading-5 bg-glaciar-gray-50/50 focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent sm:text-sm transition-all" onchange="this.form.submit()">
                    <option value="">All Priorities</option>
                    <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low Priority</option>
                    <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                    <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High Priority</option>
                    <option value="Critical" {{ request('priority') == 'Critical' ? 'selected' : '' }}>Critical Priority</option>
                </select>
            </div>
            
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-glaciar-black hover:bg-glaciar-gray-900 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black">
                Search
            </button>
            @if(request()->hasAny(['search', 'priority']))
                <a href="{{ route('admin.complaints.index', ['status' => request('status')]) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-100 transition-all">Clear</a>
            @endif
        </form>
    </div>

    <!-- Data Table -->
    <x-admin.data-table :columns="['Ticket ID', 'Customer', 'Category', 'Subject', 'Date Logged', 'Priority', 'Status', 'Actions']" :items="$complaints">
        @forelse($complaints as $complaint)
            <tr class="hover:bg-glaciar-gray-50/50 hover:scale-[1.002] transition-all duration-200 {{ $complaint->priority === 'Critical' ? 'bg-rose-50/20' : '' }}">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">
                    <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="hover:text-glaciar-accent transition-colors">#CMP-{{ str_pad($complaint->id, 5, '0', STR_PAD_LEFT) }}</a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-glaciar-black">{{ $complaint->customer->name ?? 'Unknown Customer' }}</div>
                    @if($complaint->assigned_to)
                        <div class="text-[10px] uppercase font-bold tracking-wider text-glaciar-accent mt-0.5">Assigned to: {{ $complaint->assignee->name ?? 'Admin' }}</div>
                    @else
                        <div class="text-[10px] uppercase font-bold tracking-wider text-rose-500 mt-0.5">Unassigned</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <span class="px-3 py-1 bg-glaciar-gray-100/80 text-glaciar-black rounded-lg text-xs font-semibold">{{ $complaint->category }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-glaciar-gray-600 max-w-xs truncate" title="{{ $complaint->description }}">
                    {{ Str::limit($complaint->description, 40) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-gray-500">
                    {{ $complaint->created_at->format('M d, Y h:i A') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @php
                        $priorityClass = match($complaint->priority) {
                            'Low' => 'text-slate-500',
                            'Medium' => 'text-amber-500',
                            'High' => 'text-orange-500',
                            'Critical' => 'text-rose-600 font-bold',
                            default => 'text-slate-500'
                        };
                    @endphp
                    <span class="{{ $priorityClass }} flex items-center gap-1">
                        @if($complaint->priority === 'Critical')
                            <svg class="w-3 h-3 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        @endif
                        {{ $complaint->priority }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-admin.status-badge :status="$complaint->status" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-glaciar-accent hover:text-glaciar-accent-dark transition-colors font-semibold">Manage</a>
                </td>
            </tr>
        @empty
            <!-- Fallback handled by data-table empty message -->
        @endforelse
    </x-admin.data-table>
@endsection
