@props(['title', 'buttonText' => null, 'buttonRoute' => null])

<div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold text-glaciar-black tracking-tight">{{ $title }}</h2>
        <div class="h-1 w-12 bg-glaciar-accent mt-2 rounded-full"></div>
    </div>
    
    @if($buttonText && $buttonRoute)
        <a href="{{ $buttonRoute }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-glaciar-accent to-glaciar-accent-dark hover:from-glaciar-accent-light hover:to-glaciar-accent shadow-md shadow-glaciar-accent/30 hover:shadow-glow hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-accent group">
            <span>{{ $buttonText }}</span>
            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </a>
    @endif
    
    {{ $slot }}
</div>
