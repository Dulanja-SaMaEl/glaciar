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
                        <span class="text-glaciar-black font-medium" aria-current="page">Products</span>
                    </li>
                </ol>
            </nav>
            
            <h1 class="text-4xl font-extrabold text-glaciar-black mt-6">All Products</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ mobileFiltersOpen: false }">
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Mobile filter dialog toggle -->
            <div class="md:hidden flex items-center justify-between mb-4">
                <button type="button" @click="mobileFiltersOpen = true" class="inline-flex items-center font-medium text-glaciar-black">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filters
                </button>
            </div>

            <!-- Sidebar Filters (Desktop) -->
            <aside class="hidden md:block w-64 flex-shrink-0">
                <form class="space-y-8 sticky top-28">
                    
                    <!-- Size Filter -->
                    <div>
                        <h3 class="font-bold text-glaciar-black mb-4">Size</h3>
                        <div class="space-y-3">
                            @foreach(['250ml', '500ml', '1L', '1.5L', '5L', '19L'] as $idx => $size)
                                <div class="flex items-center">
                                    <input id="size-{{ $idx }}" name="sizes[]" value="{{ $size }}" type="checkbox" class="h-4 w-4 text-glaciar-black border-glaciar-gray-300 rounded focus:ring-glaciar-black">
                                    <label for="size-{{ $idx }}" class="ml-3 text-sm text-glaciar-gray-700">
                                        {{ $size }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="pt-6 border-t border-glaciar-gray-100">
                        <h3 class="font-bold text-glaciar-black mb-4">Category</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input id="cat-still" name="category" value="Still" type="radio" class="h-4 w-4 text-glaciar-black border-glaciar-gray-300 focus:ring-glaciar-black" checked>
                                <label for="cat-still" class="ml-3 text-sm text-glaciar-gray-700">Still Water</label>
                            </div>
                            <div class="flex items-center">
                                <input id="cat-sparkling" name="category" value="Sparkling" type="radio" class="h-4 w-4 text-glaciar-black border-glaciar-gray-300 focus:ring-glaciar-black">
                                <label for="cat-sparkling" class="ml-3 text-sm text-glaciar-gray-700">Sparkling Water</label>
                            </div>
                        </div>
                    </div>

                    <!-- Sort Filter -->
                    <div class="pt-6 border-t border-glaciar-gray-100">
                        <h3 class="font-bold text-glaciar-black mb-4">Sort by</h3>
                        <select name="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-glaciar-gray-300 focus:outline-none focus:ring-glaciar-black focus:border-glaciar-black sm:text-sm rounded-md">
                            <option value="popular">Popularity</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                        </select>
                    </div>

                    <button type="button" class="w-full bg-glaciar-black border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-glaciar-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black">
                        Apply Filters
                    </button>
                    
                </form>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($products ?? [] as $product)
                        <x-customer.product-card :product="$product" compact="false" />
                    @empty
                        <!-- Dummy fallback -->
                        @foreach([
                            ['id' => 1, 'name' => 'Glaciar Mini', 'size_ml' => 250, 'price' => 50],
                            ['id' => 2, 'name' => 'Glaciar Standard', 'size_ml' => 500, 'price' => 80],
                            ['id' => 3, 'name' => 'Glaciar Hydration', 'size_ml' => 1000, 'price' => 150],
                            ['id' => 4, 'name' => 'Glaciar Family', 'size_ml' => 1500, 'price' => 200],
                            ['id' => 5, 'name' => 'Glaciar Jug', 'size_ml' => 5000, 'price' => 500],
                            ['id' => 6, 'name' => 'Glaciar Dispenser Bottle', 'size_ml' => 19000, 'price' => 350],
                        ] as $p)
                            <x-customer.product-card :product="(object)$p" compact="false" />
                        @endforeach
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
