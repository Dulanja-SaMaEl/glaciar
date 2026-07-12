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
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8 hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-xl font-bold text-glaciar-black mb-6 tracking-tight">Revenue Overview (Last 30 Days)</h3>
            <div class="h-80 w-full relative">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Rep Sales Leaderboard -->
        <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8 flex flex-col h-full hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-xl font-bold text-glaciar-black mb-6 tracking-tight">Rep Sales Leaderboard</h3>

            <div class="flex-1 overflow-y-auto pr-2 space-y-4 custom-scrollbar">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        <!-- Today's Sales Submissions -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-glaciar-black tracking-tight">Today's Sales Submissions</h3>
                <span class="px-3 py-1 bg-glaciar-gray-50 text-glaciar-gray-600 rounded-full text-sm font-semibold border border-glaciar-gray-100">{{ \Carbon\Carbon::today()->format('M d, Y') }}</span>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="min-w-full divide-y divide-glaciar-gray-100/60">
                    <thead class="bg-glaciar-gray-50/80 backdrop-blur-md">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider">Rep</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider">Total Sales</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-glaciar-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-glaciar-gray-100/60 bg-white">
                        @foreach($todaySubmissions ?? [] as $row)
                            @php $rep = $row['rep']; @endphp
                            <tr class="hover:bg-glaciar-gray-50/50 hover:scale-[1.002] transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $rep->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500 font-medium">LKR {{ number_format($row['total_sales'] ?? 0, 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <x-admin.status-badge :status="$row['status']" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500 font-medium">{{ $row['submitted_time'] ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a
                                        href="{{ route('admin.sales.salary.detail', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}"
                                        class="text-glaciar-accent hover:text-glaciar-accent-dark font-semibold text-sm transition-colors"
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

        <!-- Today's Attendance -->
        <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 p-6 lg:p-8 flex flex-col h-full hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-glaciar-black tracking-tight">Today's Attendance</h3>
                <a href="{{ route('admin.attendance.index') }}" class="text-sm font-semibold text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">Manage</a>
            </div>

            <div class="flex-1 flex flex-col justify-center space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-glaciar-gray-100">
                    <span class="text-sm font-bold text-glaciar-black">Total Records</span>
                    <span class="text-lg font-black text-blue-600">{{ $todayAttendanceStats['total'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-glaciar-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-sm font-bold text-glaciar-black">Present</span>
                    </div>
                    <span class="text-lg font-black text-emerald-600">{{ $todayAttendanceStats['present'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-glaciar-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="text-sm font-bold text-glaciar-black">Late</span>
                    </div>
                    <span class="text-lg font-black text-amber-600">{{ $todayAttendanceStats['late'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="text-sm font-bold text-glaciar-black">Absent / Leave</span>
                    </div>
                    <span class="text-lg font-black text-rose-600">{{ $todayAttendanceStats['absent'] ?? 0 }}</span>
                </div>
            </div>
            
            <a href="{{ route('admin.attendance.create') }}" class="mt-6 w-full py-3 bg-glaciar-gray-50 hover:bg-glaciar-gray-100 text-glaciar-black text-sm font-bold rounded-xl border border-glaciar-gray-200 transition-colors text-center">
                Log Manual Entry
            </a>
        </div>
    </div>

    <!-- Recent Activity Grid (Orders & Complaints) -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mt-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-6 lg:p-8 border-b border-glaciar-gray-100/60 flex justify-between items-center bg-white/50 backdrop-blur-sm">
                <h3 class="text-xl font-bold text-glaciar-black tracking-tight">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-glaciar-accent hover:text-glaciar-accent-dark transition-colors flex items-center gap-1 group">
                    View All 
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            
            <x-admin.data-table :columns="['Order ID', 'Customer', 'Total', 'Status', '']" :items="$recentOrders ?? collect([])">
                @foreach($recentOrders ?? [] as $order)
                <tr class="hover:bg-glaciar-gray-50/50 hover:scale-[1.002] transition-all duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-glaciar-accent transition-colors">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-glaciar-black">{{ $order->customer->name ?? 'Unknown' }}</div>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-glaciar-gray-500 mt-0.5">{{ $order->rep->name ?? 'No Rep' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">LKR {{ number_format($order->total, 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-admin.status-badge :status="$order->status" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">View</a>
                    </td>
                </tr>
                @endforeach
            </x-admin.data-table>
        </div>

        <!-- Recent Complaints -->
        <div class="bg-white rounded-2xl shadow-soft border border-glaciar-gray-100/60 overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-6 lg:p-8 border-b border-glaciar-gray-100/60 flex justify-between items-center bg-white/50 backdrop-blur-sm">
                <h3 class="text-xl font-bold text-glaciar-black tracking-tight">Recent Complaints</h3>
                <a href="{{ route('admin.complaints.index') }}" class="text-sm font-semibold text-glaciar-accent hover:text-glaciar-accent-dark transition-colors flex items-center gap-1 group">
                    View All 
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            
            <x-admin.data-table :columns="['Ticket ID', 'Customer', 'Priority', 'Status', '']" :items="$recentComplaints ?? collect([])">
                @foreach($recentComplaints ?? [] as $complaint)
                <tr class="hover:bg-glaciar-gray-50/50 hover:scale-[1.002] transition-all duration-200 {{ $complaint->priority === 'Critical' ? 'bg-rose-50/20' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">
                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="hover:text-glaciar-accent transition-colors">#CMP-{{ str_pad($complaint->id, 5, '0', STR_PAD_LEFT) }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-glaciar-black">{{ $complaint->customer->name ?? 'Unknown' }}</div>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-glaciar-gray-500 mt-0.5 truncate max-w-[150px]">{{ $complaint->category }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @php
                            $priorityClass = match($complaint->priority) {
                                'Low' => 'text-slate-500',
                                'Medium' => 'text-amber-500',
                                'High' => 'text-orange-500',
                                'Critical' => 'text-rose-600 font-bold',
                                default => 'text-slate-500'
                            };
                        @endphp
                        <span class="{{ $priorityClass }} flex items-center gap-1">
                            {{ $complaint->priority }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-admin.status-badge :status="$complaint->status" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">Manage</a>
                    </td>
                </tr>
                @endforeach
            </x-admin.data-table>
        </div>
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
