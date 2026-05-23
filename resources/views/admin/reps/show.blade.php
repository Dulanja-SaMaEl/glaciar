@extends('layouts.admin')

@section('header', 'Rep Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.reps.index') }}" class="inline-flex items-center text-sm font-medium text-glaciar-gray-500 hover:text-glaciar-black transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Sales Reps
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Rep Profile Info -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-3xl font-bold mb-4 border border-blue-100">
                        {{ substr($rep->name ?? 'John Silva', 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-bold text-glaciar-black">{{ $rep->name ?? 'John Silva' }}</h2>
                    <p class="text-glaciar-gray-500 mb-4">#REP-{{ str_pad($rep->id ?? 1, 3, '0', STR_PAD_LEFT) }}</p>
                    <x-admin.status-badge :status="$rep->status ?? 'active'" />
                </div>
                
                <div class="mt-8 space-y-4 border-t border-glaciar-gray-100 pt-6">
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500">Email Address</p>
                        <p class="text-sm font-semibold text-glaciar-black mt-1">{{ $rep->email ?? 'john.s@glaciar.com' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500">Phone Number</p>
                        <p class="text-sm font-semibold text-glaciar-black mt-1">{{ $rep->phone ?? '+94 77 123 4567' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500">Assigned Zone</p>
                        <p class="text-sm font-semibold text-glaciar-black mt-1">{{ $rep->zone->name ?? 'Colombo 01-15' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500">Employee ID</p>
                        <p class="text-sm font-semibold text-glaciar-black mt-1">{{ $rep->employee_id ?? 'REP-001' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-glaciar-gray-500">Joined Date</p>
                        <p class="text-sm font-semibold text-glaciar-black mt-1">{{ isset($rep) ? $rep->created_at->format('M d, Y') : 'Jan 15, 2024' }}</p>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-glaciar-gray-100 space-y-3">
                    <a href="{{ route('admin.reps.edit', $rep->id) }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-glaciar-black hover:bg-glaciar-gray-900">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Performance / Activity content -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4">
                    <p class="text-xs font-medium text-glaciar-gray-500 uppercase">Deliveries Today</p>
                    <p class="text-2xl font-bold text-glaciar-black mt-1">{{ $rep->deliveries_today ?? 12 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4">
                    <p class="text-xs font-medium text-glaciar-gray-500 uppercase">Deliveries This Week</p>
                    <p class="text-2xl font-bold text-glaciar-black mt-1">{{ $rep->deliveries_week ?? 68 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4">
                    <p class="text-xs font-medium text-glaciar-gray-500 uppercase">Cash Collected</p>
                    <p class="text-xl font-bold text-glaciar-black mt-1">LKR {{ number_format($rep->cash_collected ?? 45000, 0) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4">
                    <p class="text-xs font-medium text-glaciar-gray-500 uppercase">Attendance Rate</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">98%</p>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-4 border-b border-glaciar-gray-100 bg-glaciar-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-glaciar-black">Today's Route Schedule</h3>
                    <span class="text-sm text-glaciar-gray-500">{{ now()->format('M d, Y') }}</span>
                </div>
                
                <div class="divide-y divide-glaciar-gray-100">
                    <!-- Dummy Delivery Items -->
                    @foreach([
                        ['id'=>1, 'time' => '08:30 AM', 'customer' => 'Sampath Bank HQ', 'address' => 'Colombo 02', 'status' => 'Delivered'],
                        ['id'=>2, 'time' => '10:00 AM', 'customer' => 'Tech Solutions Ltd', 'address' => 'Colombo 03', 'status' => 'Delivered'],
                        ['id'=>3, 'time' => '11:45 AM', 'customer' => 'Cafe Veda', 'address' => 'Colombo 04', 'status' => 'Out For Delivery'],
                        ['id'=>4, 'time' => '02:00 PM', 'customer' => 'Residential Customer', 'address' => 'Colombo 05', 'status' => 'Pending'],
                    ] as $delivery)
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="w-16 flex-shrink-0 pt-1">
                                    <span class="text-xs font-bold text-glaciar-gray-500">{{ $delivery['time'] }}</span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-glaciar-black">{{ $delivery['customer'] }}</p>
                                    <p class="text-xs text-glaciar-gray-500 mt-1">{{ $delivery['address'] }}</p>
                                </div>
                            </div>
                            <div>
                                <x-admin.status-badge :status="$delivery['status']" />
                            </div>
                        </div>
                    @endforeach
                </div>
            <!-- Monthly Targets -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
                <div class="p-4 border-b border-glaciar-gray-100 bg-glaciar-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-glaciar-black">Monthly Targets</h3>
                </div>
                
                <div class="p-4">
                    <form action="{{ route('admin.reps.targets.store', $rep->id) }}" method="POST" class="flex flex-wrap gap-4 items-end mb-6 bg-glaciar-gray-50 p-4 rounded-lg border border-glaciar-gray-100">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-glaciar-gray-500 mb-1">Month</label>
                            <select name="month" class="rounded-md border-glaciar-gray-300 text-sm py-1.5 focus:border-blue-500 focus:ring-blue-500" required>
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-glaciar-gray-500 mb-1">Year</label>
                            <input type="number" name="year" value="{{ date('Y') }}" class="rounded-md border-glaciar-gray-300 text-sm py-1.5 w-24 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-glaciar-gray-500 mb-1">Target Amount (LKR)</label>
                            <input type="number" step="0.01" name="target_amount" class="rounded-md border-glaciar-gray-300 text-sm py-1.5 w-32 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-glaciar-gray-500 mb-1">Achieved Amount (LKR)</label>
                            <input type="number" step="0.01" name="achieved_amount" class="rounded-md border-glaciar-gray-300 text-sm py-1.5 w-32 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1.5 px-4 rounded-md transition-colors">
                                Save
                            </button>
                        </div>
                    </form>

                    @if($rep->targets && $rep->targets->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Target</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Achieved</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Progress</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($rep->targets as $target)
                                        @php
                                            $percent = $target->target_amount > 0 ? min(100, round(($target->achieved_amount / $target->target_amount) * 100)) : 0;
                                            $colorClass = $percent >= 100 ? 'bg-green-500' : ($percent >= 75 ? 'bg-blue-500' : ($percent >= 50 ? 'bg-yellow-500' : 'bg-red-500'));
                                        @endphp
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ date('F', mktime(0, 0, 0, $target->month, 1)) }} {{ $target->year }}
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-right">
                                                LKR {{ number_format($target->target_amount, 2) }}
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-right">
                                                LKR {{ number_format($target->achieved_amount, 2) }}
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-right">
                                                <div class="flex items-center justify-end">
                                                    <span class="mr-2 text-xs font-medium">{{ $percent }}%</span>
                                                    <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                                        <div class="{{ $colorClass }} h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 text-center py-4">No monthly targets recorded yet.</p>
                    @endif
                </div>
            </div>
            
            <!-- Map Placeholder / Link -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-glaciar-black">Current Location</h3>
                </div>
                <div class="bg-glaciar-gray-100 rounded-lg aspect-video flex flex-col items-center justify-center border border-glaciar-gray-200">
                    <svg class="w-12 h-12 text-glaciar-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    <p class="text-glaciar-gray-500 font-medium text-sm">Location tracking enabled on Flutter app</p>
                    <a href="{{ route('admin.map') }}?rep={{ $rep->id ?? 1 }}" class="mt-4 px-4 py-2 bg-glaciar-black text-white text-sm font-medium rounded-md hover:bg-glaciar-gray-900 transition-colors">Open Live Map</a>
                </div>
            </div>

        </div>
    </div>
@endsection
