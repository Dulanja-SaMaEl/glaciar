@extends('layouts.customer')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-glaciar-gray-100 pt-6 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-glaciar-gray-500">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-glaciar-black transition-colors">Home</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-glaciar-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="hover:text-glaciar-black transition-colors">Products</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-glaciar-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    </li>
                    <li>
                        <span class="text-glaciar-black font-medium" aria-current="page">{{ $product->name ?? 'Glaciar Standard' }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Details -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ qty: 1 }">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-24">
            
            <!-- Product Image -->
            <div class="bg-gradient-to-br from-blue-50 to-glaciar-gray-100 rounded-3xl p-12 flex items-center justify-center relative overflow-hidden aspect-square">
                <!-- Abstract Bottle Shape placeholder -->
                <div class="w-2/3 h-4/5 bg-white/80 backdrop-blur-sm rounded-t-full rounded-b-2xl border-2 border-white/50 shadow-xl flex flex-col items-center justify-center relative z-10 transition-transform duration-500 hover:scale-105">
                    <div class="absolute top-0 w-1/3 h-1/6 bg-blue-100/50 rounded-t-lg -mt-2"></div>
                    <span class="text-5xl font-black text-glaciar-black/20 tracking-tighter mb-4">{{ ($product->size_ml ?? 500) >= 1000 ? (($product->size_ml ?? 500) / 1000) . 'L' : ($product->size_ml ?? 500) . 'ml' }}</span>
                    <span class="text-xl font-bold text-blue-900/50 font-serif italic text-center px-4">{{ $product->name ?? 'Glaciar Standard' }}</span>
                </div>
                
                <!-- Water ripple effect -->
                <div class="absolute bottom-0 w-full h-1/3 bg-gradient-to-t from-blue-200/40 to-transparent"></div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-center">
                <div class="mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-glaciar-gray-50 text-glaciar-gray-600 border border-glaciar-gray-200">
                        {{ ($product->size_ml ?? 500) >= 1000 ? 'Large Format' : 'Personal Size' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100 ml-2">
                        Still Water
                    </span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl font-extrabold text-glaciar-black mb-4">{{ $product->name ?? 'Glaciar Standard' }}</h1>
                
                <p class="text-3xl font-bold text-glaciar-black mb-6">
                    LKR {{ number_format($product->price ?? 80, 0) }} <span class="text-lg text-glaciar-gray-500 font-normal">/ bottle</span>
                </p>
                
                <div class="prose prose-glaciar mb-8 text-glaciar-gray-600">
                    <p>{{ $product->description ?? 'Pure, refreshing spring water sourced from high altitude aquifers and strictly filtered for guaranteed purity and taste. The perfect size to keep you hydrated throughout your daily activities.' }}</p>
                    
                    <ul class="mt-4 space-y-2 text-sm">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Naturally balanced pH</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Zero calories, zero sweeteners</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 100% recyclable packaging</li>
                    </ul>
                </div>

                <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id ?? 1 }}">
                    
                    <div class="flex items-end gap-6 mb-8">
                        <div>
                            <label for="qty" class="block text-sm font-medium text-glaciar-gray-700 mb-2">Quantity</label>
                            <div class="flex items-center border border-glaciar-gray-300 rounded-lg overflow-hidden w-32">
                                <button type="button" @click="if(qty > 1) qty--" class="px-3 py-2 bg-glaciar-gray-50 text-glaciar-gray-600 hover:bg-glaciar-gray-100 transition-colors focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                <input type="number" id="qty" name="qty" x-model="qty" min="1" max="100" class="w-full text-center border-0 focus:ring-0 p-0 text-glaciar-black font-medium" />
                                <button type="button" @click="if(qty < 100) qty++" class="px-3 py-2 bg-glaciar-gray-50 text-glaciar-gray-600 hover:bg-glaciar-gray-100 transition-colors focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <button type="submit" class="w-full bg-glaciar-black hover:bg-glaciar-gray-900 text-white font-bold py-4 px-8 rounded-lg transition-colors flex items-center justify-center gap-2 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Stock Status & Delivery -->
                <div class="bg-glaciar-gray-50 rounded-xl p-4 flex flex-col gap-3">
                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium text-glaciar-black">In Stock</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 text-glaciar-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        <span class="text-glaciar-gray-600">Free delivery on orders over LKR 5,000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
