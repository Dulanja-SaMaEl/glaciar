@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-admin.stat-card
            title="Net Profit This Month"
            value="LKR {{ number_format($netProfitThisMonth ?? 0, 0) }}"
            icon="currency-dollar"
        />

        <x-admin.stat-card
            title="Total Salaries This Month"
            value="LKR {{ number_format($totalSalariesThisMonth ?? 0, 0) }}"
            icon="truck"
        />

        <x-admin.stat-card
            title="Reps Hit Bonus Target"
            value="{{ $repsHitBonusTarget ?? 0 }} / {{ $totalReps ?? 0 }}"
            icon="exclamation-circle"
        />

        <x-admin.stat-card
            title="Total Company Sales (Month)"
            value="LKR {{ number_format($totalCompanySalesThisMonth ?? 0, 0) }}"
            icon="shopping-cart"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Company Revenue Chart (30 days) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <h3 class="text-lg font-bold text-glaciar-black mb-6">Revenue Overview (Last 30 Days)</h3>
            <div class="h-80 w-full relative">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Rep Sales Leaderboard -->
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 flex flex-col h-full">
            <h3 class="text-lg font-bold text-glaciar-black mb-6">Rep Sales Leaderboard</h3>

            <div class="flex-1 overflow-y-auto pr-2 space-y-4">
                @foreach($leaderboard ?? [] as $i => $row)
                    @php
                        $rep = $row['rep'];
                        $progress = (float) ($row['progress_pct'] ?? 0);
                        $bonusEarned = !empty($row['bonus_earned']);
                    @endphp
                    <div class="flex items-center justify-between p-3 border border-glaciar-gray-100 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-glaciar-gray-100 flex items-center justify-center font-bold text-glaciar-black">
                                {{ $i + 1 }}
                            </div>
                            <div>
                                <div class="font-semibold text-glaciar-black text-sm">{{ $rep->name }}</div>
                                <div class="text-xs text-glaciar-gray-500">{{ $rep->zone->name ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-glaciar-black text-sm">
                                LKR {{ number_format($row['sales'] ?? 0, 0) }}
                            </div>
                            <div class="mt-2">
                                <div class="w-32 h-2 rounded-full bg-glaciar-gray-100 overflow-hidden">
                                    <div class="h-2 rounded-full {{ $bonusEarned ? 'bg-green-500' : 'bg-amber-500' }}" style="width: {{ $progress }}%;"></div>
                                </div>
                                <div class="mt-1 text-xs text-glaciar-gray-500">
                                    {{ number_format($progress, 1) }}% vs target
                                </div>
                            </div>
                            <div class="mt-2">
                                @if($bonusEarned)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Earned</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Not yet</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if(empty($leaderboard))
                    <div class="text-sm text-glaciar-gray-500">No sales data yet for this month.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Today's Sales Submissions -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-glaciar-black">Today's Sales Submissions</h3>
            <span class="text-sm text-glaciar-gray-500">{{ \Carbon\Carbon::today()->format('Y-m-d') }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-glaciar-gray-100">
                <thead class="bg-glaciar-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Rep</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Total Sales</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Time</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-glaciar-gray-500 uppercase"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-glaciar-gray-100">
                    @foreach($todaySubmissions ?? [] as $row)
                        @php $rep = $row['rep']; @endphp
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $rep->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-glaciar-gray-500">LKR {{ number_format($row['total_sales'] ?? 0, 0) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <x-admin.status-badge :status="$row['status']" />
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $row['submitted_time'] ?? '—' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <a
                                    href="{{ route('admin.sales.salary.detail', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}"
                                    class="text-blue-600 hover:text-blue-900 font-semibold text-sm"
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="p-6 border-b border-glaciar-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-glaciar-black">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">View All</a>
        </div>
        
        <x-admin.data-table :columns="['Order ID', 'Customer', 'Zone', 'Total', 'Status', '']" :items="$recentOrders ?? collect([])">
            @forelse($recentOrders ?? [] as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black">{{ $order->customer->name ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">—</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">LKR {{ number_format($order->total, 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-admin.status-badge :status="$order->status" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                    </td>
                </tr>
            @empty
                @foreach([
                    ['id' => '1025', 'customer' => 'Sampath Bank HQ', 'zone' => 'Colombo 01-15', 'total' => 15500, 'status' => 'Pending'],
                    ['id' => '1024', 'customer' => 'Nilantha Wijesinghe', 'zone' => 'Gampaha', 'total' => 2400, 'status' => 'Out For Delivery'],
                    ['id' => '1023', 'customer' => 'Cafe Veda', 'zone' => 'Colombo Suburbs', 'total' => 8400, 'status' => 'Delivered'],
                ] as $o)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">#ORD-0{{ $o['id'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black">{{ $o['customer'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">{{ $o['zone'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">LKR {{ number_format($o['total'], 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-admin.status-badge :status="$o['status']" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-900">View</a>
                    </td>
                </tr>
                @endforeach
            @endforelse
        </x-admin.data-table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>
    <!-- Script for chart generation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels ?? []),
                    datasets: [{
                        label: 'Company Revenue (LKR)',
                        data: @json($chartValues ?? []),
                        borderColor: '#000000',
                        backgroundColor: 'rgba(0, 0, 0, 0.05)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 2,
                        pointHoverRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        annotation: {
                            annotations: {
                                tierChange: {
                                    type: 'line',
                                    yMin: @json((float) config('salary.tier1_cap')),
                                    yMax: @json((float) config('salary.tier1_cap')),
                                    borderColor: 'rgba(245, 158, 11, 1)',
                                    borderWidth: 2,
                                    borderDash: [6, 6],
                                    label: {
                                        enabled: true,
                                        content: 'Tier Change (1,200,000)',
                                        position: 'end'
                                    }
                                },
                                bonusTarget: {
                                    type: 'line',
                                    yMin: @json((float) config('salary.bonus_threshold')),
                                    yMax: @json((float) config('salary.bonus_threshold')),
                                    borderColor: 'rgba(34, 197, 94, 1)',
                                    borderWidth: 2,
                                    borderDash: [6, 6],
                                    label: {
                                        enabled: true,
                                        content: 'Bonus Target (1,500,000)',
                                        position: 'end'
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F3F4F6' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endsection
