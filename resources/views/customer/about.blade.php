@extends('layouts.customer')

@section('content')
    <!-- Hero Section -->
    <div class="bg-glaciar-gray-50 py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-glaciar-black mb-6">Our Story</h1>
                <p class="text-xl text-glaciar-gray-600 leading-relaxed">
                    We believe everyone deserves access to pure, refreshing water. Starting as a small local delivery service, Glaciar has grown to become a trusted hydration partner for thousands of homes and businesses.
                </p>
            </div>
        </div>
        <!-- BG Elements -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-50 opacity-50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-cyan-50 opacity-50 blur-3xl"></div>
    </div>

    <!-- Content Sections -->
    <div class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
                <div>
                    <h2 class="text-3xl font-bold text-glaciar-black mb-6">Sourced from Nature</h2>
                    <p class="text-lg text-glaciar-gray-600 mb-6 leading-relaxed">
                        Our water is sourced from pristine, protected high-altitude springs. Far from urban pollution and agricultural runoff, the water undergoes natural filtration through layers of ancient rock before it ever sees the light of day.
                    </p>
                    <p class="text-lg text-glaciar-gray-600 leading-relaxed">
                        We simply collect this natural gift and bottle it at the source under strict quality controls to ensure perfectly balanced pH and crisp, clean taste in every drop.
                    </p>
                </div>
                <!-- Abstract Image representation -->
                <div class="h-96 bg-gray-100 rounded-2xl overflow-hidden relative group">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1542382257-8024cb638b9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');"></div>
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center flex-col-reverse lg:flex-row-reverse">
                <div>
                    <h2 class="text-3xl font-bold text-glaciar-black mb-6">Commitment to Sustainability</h2>
                    <p class="text-lg text-glaciar-gray-600 mb-6 leading-relaxed">
                        Pure water requires a pure environment. We are committed to minimizing our ecological footprint through every stage of our operation.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-lg text-glaciar-gray-700">100% recyclable bottles across all sizes</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-lg text-glaciar-gray-700">Closed-loop bottle exchange for our 19L jugs</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-lg text-glaciar-gray-700">Optimized delivery routes to reduce emissions</span>
                        </li>
                    </ul>
                </div>
                <!-- Abstract Image representation -->
                <div class="h-96 bg-gray-100 rounded-2xl overflow-hidden relative group">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');"></div>
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                </div>
            </div>

        </div>
    </div>
@endsection
