@props([
    'title',
    'value',
    'icon',
    'trendDirection' => null, 
    'trendValue' => null,
])

<div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 flex items-center justify-between hover:-translate-y-1 hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
    <!-- Decorative background glow -->
    <div class="absolute -right-8 -top-8 w-32 h-32 bg-glaciar-accent/5 rounded-full blur-2xl group-hover:bg-glaciar-accent/10 transition-colors duration-500 pointer-events-none"></div>

    <div class="relative z-10">
        <p class="text-sm font-semibold text-glaciar-gray-500 mb-2 uppercase tracking-wider">{{ $title }}</p>
        <h3 class="text-3xl font-bold text-glaciar-black tracking-tight">{{ $value }}</h3>
        
        @if($trendDirection && $trendValue)
            <div class="flex items-center mt-3 text-sm {{ $trendDirection === 'up' ? 'text-emerald-600' : 'text-rose-600' }} font-medium">
                @if($trendDirection === 'up')
                    <span class="flex items-center bg-emerald-50 px-2 py-0.5 rounded-full">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        {{ $trendValue }}%
                    </span>
                @else
                    <span class="flex items-center bg-rose-50 px-2 py-0.5 rounded-full">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                        {{ $trendValue }}%
                    </span>
                @endif
                <span class="text-glaciar-gray-400 ml-2 text-xs">vs yesterday</span>
            </div>
        @endif
    </div>
    
    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-glaciar-accent/10 to-glaciar-accent/5 flex items-center justify-center text-glaciar-accent shadow-[inset_0_0_10px_rgba(59,130,246,0.1)] group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 relative z-10">
        @if($icon === 'currency-dollar')
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        @elseif($icon === 'shopping-cart')
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        @elseif($icon === 'truck')
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
        @elseif($icon === 'exclamation-circle')
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        @else
            <!-- Fallback icon -->
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        @endif
    </div>
</div>
