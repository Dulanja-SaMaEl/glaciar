@props(['title', 'description' => '', 'routeKey' => '', 'searchable' => true, 'hasStatus' => false, 'statusOptions' => []])

<div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-glaciar-black">{{ $title }}</h3>
            @if($description)
                <p class="text-sm text-glaciar-gray-500 mt-1">{{ $description }}</p>
            @endif
        </div>

        <div class="flex flex-wrap gap-3">
            <button
                type="button"
                onclick="document.getElementById('entry-modal-{{ $routeKey }}').classList.remove('hidden')"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-glaciar-gray-900 transition-colors"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Entry
            </button>
            
            <a
                href="{{ route('admin.' . $routeKey . '.export.pdf', request()->query()) }}"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-glaciar-black text-sm font-semibold hover:bg-glaciar-gray-50 transition-colors"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </a>

            <a
                href="{{ route('admin.' . $routeKey . '.export.csv', request()->query()) }}"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-glaciar-black text-sm font-semibold hover:bg-glaciar-gray-50 transition-colors"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="pt-4 border-t border-glaciar-gray-100">
        <form method="GET" action="" class="flex flex-wrap items-end gap-3">
            @if($searchable)
            <div class="w-full sm:w-auto flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-glaciar-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search records..." class="block w-full pl-10 pr-3 py-2 border border-glaciar-gray-200 rounded-lg text-sm focus:ring-glaciar-black focus:border-glaciar-black bg-white transition-all">
                </div>
            </div>
            @endif

            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="block w-full px-3 py-2 border border-glaciar-gray-200 rounded-lg text-sm focus:ring-glaciar-black focus:border-glaciar-black bg-white transition-all">
            </div>

            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="block w-full px-3 py-2 border border-glaciar-gray-200 rounded-lg text-sm focus:ring-glaciar-black focus:border-glaciar-black bg-white transition-all">
            </div>

            @if($hasStatus)
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Status</label>
                <select name="status" class="block w-full px-3 py-2 border border-glaciar-gray-200 rounded-lg text-sm focus:ring-glaciar-black focus:border-glaciar-black bg-white transition-all">
                    <option value="">All</option>
                    @foreach($statusOptions as $val => $label)
                        <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="w-full sm:w-auto flex items-center gap-2">
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-glaciar-gray-900 transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'start_date', 'end_date', 'status']))
                    <a href="{{ request()->url() }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-glaciar-gray-100 text-glaciar-gray-600 text-sm font-semibold hover:bg-glaciar-gray-200 transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>