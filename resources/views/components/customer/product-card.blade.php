@props(['product', 'compact' => false])

<div class="bg-white rounded-2xl border border-glaciar-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col h-full">
    <!-- Image Area -->
    <div class="aspect-square bg-gradient-to-br from-blue-50 to-glaciar-gray-100 p-6 flex flex-col items-center justify-center relative overflow-hidden">
        <!-- Abstract Bottle Shape placeholder -->
        <div class="w-1/2 h-4/5 bg-white/80 backdrop-blur-sm rounded-t-full rounded-b-xl border-2 border-white/50 shadow-inner flex items-center justify-center relative z-10 group-hover:scale-105 transition-transform duration-500">
            <div class="absolute top-0 w-1/3 h-1/6 bg-blue-100/50 rounded-t-md -mt-1"></div>
            <span class="text-3xl font-black text-glaciar-black/20 tracking-tighter">{{ $product->size_ml >= 1000 ? ($product->size_ml / 1000) . 'L' : $product->size_ml . 'ml' }}</span>
        </div>
        
        <!-- Water ripple effect -->
        <div class="absolute bottom-0 w-full h-1/3 bg-gradient-to-t from-blue-100/30 to-transparent"></div>
    </div>
    
    <!-- Content Area -->
    <div class="p-6 flex flex-col flex-grow">
        @if(!$compact)
            <div class="mb-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-glaciar-gray-50 text-glaciar-gray-500">
                    {{ $product->size_ml >= 1000 ? 'Large Format' : 'Personal Size' }}
                </span>
            </div>
        @endif
        
        <h3 class="text-lg font-bold text-glaciar-black mb-1 group-hover:text-blue-900 transition-colors">
            <a href="{{ route('products.show', $product->id) }}" class="focus:outline-none">
                <span class="absolute inset-0" aria-hidden="true"></span>
                {{ $product->name }}
            </a>
        </h3>
        
        <p class="text-xl font-medium text-glaciar-black mb-4">
            LKR {{ number_format($product->price, 0) }} <span class="text-sm text-glaciar-gray-500 font-normal">/ bottle</span>
        </p>
        
        <div class="mt-auto pt-4 flex gap-3 relative z-20">
            <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="w-full bg-glaciar-black hover:bg-glaciar-gray-900 text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add to Cart
                </button>
            </form>
            
            @if(!$compact)
                <a href="{{ route('products.show', $product->id) }}" class="w-11 h-11 flex items-center justify-center border border-glaciar-gray-100 rounded-lg text-glaciar-gray-500 hover:text-glaciar-black hover:bg-glaciar-gray-50 transition-colors" title="View Details">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </a>
            @endif
        </div>
    </div>
</div>
