@props(['title', 'buttonText' => null, 'buttonRoute' => null])

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-glaciar-black">{{ $title }}</h2>
    
    @if($buttonText && $buttonRoute)
        <a href="{{ $buttonRoute }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-glaciar-black hover:bg-glaciar-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black">
            {{ $buttonText }}
        </a>
    @endif
    
    {{ $slot }}
</div>
