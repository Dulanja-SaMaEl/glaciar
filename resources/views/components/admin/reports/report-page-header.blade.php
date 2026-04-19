@props(['title', 'description' => '', 'routeKey' => ''])

<div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-glaciar-black">{{ $title }}</h3>
            @if($description)
                <p class="text-sm text-glaciar-gray-500 mt-1">{{ $description }}</p>
            @endif
        </div>

        <form method="GET" action="" class="flex items-end gap-3">
            <div>
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Month</label>
                <select name="month" class="w-32 border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-glaciar-black focus:border-glaciar-black">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected($m === (int)(request('month', now()->month)))>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Year</label>
                <select name="year" class="w-24 border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-glaciar-black focus:border-glaciar-black">
                    @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" @selected($y === (int)(request('year', now()->year)))>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-glaciar-gray-900 transition-colors">
                Apply
            </button>
        </form>
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
            href="{{ route('admin.' . $routeKey . '.export.pdf', ['month' => request('month', now()->month), 'year' => request('year', now()->year)]) }}"
            class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-glaciar-black text-sm font-semibold hover:bg-glaciar-gray-50 transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export PDF
        </a>

        <a
            href="{{ route('admin.' . $routeKey . '.export.csv', ['month' => request('month', now()->month), 'year' => request('year', now()->year)]) }}"
            class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-glaciar-black text-sm font-semibold hover:bg-glaciar-gray-50 transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Export CSV
        </a>
    </div>
</div>