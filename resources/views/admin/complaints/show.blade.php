@extends('layouts.admin')

@section('header', 'Complaint Management')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.complaints.index') }}" class="text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-accent transition-colors flex items-center gap-1 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to complaints
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8 relative overflow-hidden">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4 border-b border-glaciar-gray-100/60 pb-6 mb-6">
                    <div>
                        <div class="text-sm font-bold text-glaciar-gray-400 uppercase tracking-wider mb-1">Ticket ID</div>
                        <div class="text-3xl font-black text-glaciar-black tracking-tight">#CMP-{{ str_pad($complaint->id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="mt-3 flex items-center gap-3 text-sm text-glaciar-gray-600">
                            <span class="px-3 py-1 bg-glaciar-gray-50 text-glaciar-black rounded-lg font-semibold">{{ $complaint->category }}</span>
                            <span class="text-glaciar-gray-300">•</span>
                            <span class="font-medium flex items-center gap-1">
                                Priority: 
                                <span class="font-bold {{ $complaint->priority === 'Critical' ? 'text-rose-600' : ($complaint->priority === 'High' ? 'text-orange-500' : 'text-glaciar-black') }}">{{ $complaint->priority }}</span>
                            </span>
                            <span class="text-glaciar-gray-300">•</span>
                            <span class="font-medium">{{ $complaint->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <x-admin.status-badge :status="$complaint->status" />
                    </div>
                </div>

                <div>
                    <div class="text-sm font-bold text-glaciar-gray-500 uppercase tracking-wider mb-3">Customer Description</div>
                    <div class="text-base text-glaciar-gray-700 whitespace-pre-line leading-relaxed bg-glaciar-gray-50/50 p-6 rounded-xl border border-glaciar-gray-100/50">{{ $complaint->description }}</div>
                </div>

                @if($complaint->photo_path)
                    <div class="mt-8 pt-6 border-t border-glaciar-gray-100/60">
                        <div class="text-sm font-bold text-glaciar-gray-500 uppercase tracking-wider mb-3">Attachment</div>
                        <a href="{{ url('/storage/'.$complaint->photo_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-glaciar-gray-200 rounded-xl text-sm font-semibold text-glaciar-accent hover:bg-glaciar-gray-50 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            View Uploaded Photo
                        </a>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
                <div class="flex items-center gap-2 text-xl font-bold text-glaciar-black mb-6 tracking-tight">
                    <svg class="w-6 h-6 text-glaciar-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Manage Complaint
                </div>
                <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all">
                                @foreach(['Open','In Progress','Resolved','Closed'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $complaint->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('status') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Priority</label>
                            <select name="priority" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all">
                                @foreach(['Low','Medium','High','Critical'] as $p)
                                    <option value="{{ $p }}" {{ old('priority', $complaint->priority) === $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                            @error('priority') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Assigned To</label>
                            <select name="assigned_to" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all">
                                <option value="">-- Unassigned --</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ old('assigned_to', $complaint->assigned_to) == $admin->id ? 'selected' : '' }}>{{ $admin->name }} ({{ $admin->email }})</option>
                                @endforeach
                            </select>
                            @error('assigned_to') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-glaciar-gray-700 mb-2">Resolution <span class="text-glaciar-gray-400 font-normal">(Sent to customer if applicable)</span></label>
                        <textarea name="resolution" rows="4" class="w-full border border-glaciar-gray-200 rounded-xl px-4 py-3 bg-glaciar-gray-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-glaciar-accent/50 focus:border-glaciar-accent transition-all" placeholder="Enter resolution details...">{{ old('resolution', $complaint->resolution) }}</textarea>
                        @error('resolution') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-glaciar-gray-700 mb-2 flex justify-between">
                            <span>Admin Notes <span class="text-glaciar-gray-400 font-normal">(Internal only)</span></span>
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        </label>
                        <textarea name="admin_notes" rows="4" class="w-full border border-amber-200 rounded-xl px-4 py-3 bg-amber-50/30 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all placeholder-amber-900/30 text-amber-900" placeholder="Private internal notes... ">{{ old('admin_notes', $complaint->admin_notes) }}</textarea>
                        @error('admin_notes') <div class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</div> @enderror
                    </div>

                    <div class="pt-4 border-t border-glaciar-gray-100/60 flex justify-end">
                        <button class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-glaciar-accent to-glaciar-accent-dark hover:from-glaciar-accent-light hover:to-glaciar-accent shadow-md shadow-glaciar-accent/30 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="xl:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
                <div class="text-xs font-bold text-glaciar-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-glaciar-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Customer Info
                </div>
                
                @if($complaint->customer)
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-lg">
                            {{ substr($complaint->customer->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-lg font-bold text-glaciar-black">{{ $complaint->customer->name }}</div>
                            <div class="text-sm text-glaciar-gray-500">Since {{ $complaint->customer->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm text-glaciar-gray-600">
                            <svg class="w-4 h-4 text-glaciar-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="truncate">{{ $complaint->customer->email ?? 'No email provided' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-glaciar-gray-600">
                            <svg class="w-4 h-4 text-glaciar-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $complaint->customer->phone ?? 'No phone provided' }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-glaciar-gray-500 italic text-sm">Customer data unavailable</div>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
                <div class="text-xs font-bold text-glaciar-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-glaciar-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Related Sales Rep
                </div>
                
                @if($complaint->rep)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-glaciar-gray-100 rounded-full flex items-center justify-center text-glaciar-gray-600 font-bold">
                            {{ substr($complaint->rep->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-base font-bold text-glaciar-black">{{ $complaint->rep->name }}</div>
                            <div class="text-sm text-glaciar-gray-500">{{ $complaint->rep->email ?? 'No email' }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-glaciar-gray-100/60 text-right">
                        <a href="{{ route('admin.reps.show', $complaint->rep->id) }}" class="text-sm font-semibold text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">View Rep Profile</a>
                    </div>
                @else
                    <div class="text-glaciar-gray-500 italic text-sm">No sales rep associated.</div>
                @endif
            </div>
            
            <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8">
                <div class="text-xs font-bold text-glaciar-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-glaciar-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Assignment Info
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-glaciar-gray-500 font-medium mb-1">Currently Assigned To:</div>
                        <div class="text-sm font-bold text-glaciar-black">{{ $complaint->assignee->name ?? 'Unassigned' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-glaciar-gray-500 font-medium mb-1">Last Updated:</div>
                        <div class="text-sm font-bold text-glaciar-black">{{ $complaint->updated_at->diffForHumans() }}</div>
                        <div class="text-xs text-glaciar-gray-400">{{ $complaint->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

