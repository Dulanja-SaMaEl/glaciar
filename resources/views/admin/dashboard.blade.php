@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
    <!-- Dashboard Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-admin.stat-card
            title="Net Profit This Month"
            value="LKR {{ number_format($netProfitThisMonth ?? 0, 0) }}"
            icon="currency-dollar"
            :trendDirection="($netProfitThisMonth ?? 0) >= 0 ? 'up' : 'down'"
            :trendValue="($netProfitThisMonth ?? 0) >= 0 ? 'Profitable' : 'Capex Phase'"
        />

        <x-admin.stat-card
            title="Total Salaries (Month)"
            value="LKR {{ number_format($totalSalariesThisMonth ?? 0, 0) }}"
            icon="truck"
            trendDirection="up"
            trendValue="Dispatched"
        />

        <x-admin.stat-card
            title="Reps Hit Bonus Target"
            value="{{ $repsHitBonusTarget ?? 0 }} / {{ $totalReps ?? 0 }}"
            icon="exclamation-circle"
            :trendDirection="($repsHitBonusTarget ?? 0) > 0 ? 'up' : 'down'"
            :trendValue="($totalReps ?? 0) > 0 ? round((($repsHitBonusTarget ?? 0) / ($totalReps ?? 1)) * 100) : 0"
        />

        <x-admin.stat-card
            title="Total Company Sales"
            value="LKR {{ number_format($totalCompanySalesThisMonth ?? 0, 0) }}"
            icon="shopping-cart"
            trendDirection="up"
            trendValue="Current MTD"
        />
    </div>

    <!-- Analytics & Leaderboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Company Revenue Chart (30 days) -->
        <div class="lg:col-span-2 bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-glaciar-gray-100/80 dark:border-white/10 p-6 lg:p-8 hover:shadow-lg transition-all duration-300">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Revenue Stream (Last 30 Days)</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-400 font-mono mt-0.5">DAILY REVENUE TELEMETRY & TIER TARGETS</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-mono font-bold bg-cyan-500/10 text-cyan-500 dark:text-cyan-300 border border-cyan-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                        <span>LIVE AUDIT</span>
                    </span>
                </div>
            </div>

            <div class="h-80 w-full relative">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Rep Sales Leaderboard -->
        <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-glaciar-gray-100/80 dark:border-white/10 p-6 lg:p-8 flex flex-col h-full hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Rep Leaderboard</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-400 font-mono mt-0.5">MONTHLY TARGET ATTAINMENT</p>
                </div>
                <a href="{{ route('admin.reps.index') }}" class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400 hover:underline">
                    View Fleet &rarr;
                </a>
            </div>

            <div class="flex-1 overflow-y-auto pr-1 space-y-3.5 custom-scrollbar">
                @forelse($leaderboard ?? [] as $i => $row)
                    @php
                        $rep = $row['rep'];
                        $progress = (float) ($row['progress_pct'] ?? 0);
                        $bonusEarned = !empty($row['bonus_earned']);
                        $rankBg = match($i) {
                            0 => 'bg-amber-400/20 text-amber-500 border border-amber-400/40',
                            1 => 'bg-slate-300/20 text-slate-400 border border-slate-300/40',
                            2 => 'bg-amber-700/20 text-amber-600 border border-amber-700/40',
                            default => 'bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-slate-400 border border-transparent'
                        };
                    @endphp
                    <div class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/[0.02] hover:border-cyan-400/30 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-mono font-bold text-xs {{ $rankBg }}">
                                #{{ $i + 1 }}
                            </div>
                            <div>
                                <a href="{{ route('admin.sales.salary.detail', ['repId' => $rep->id, 'year' => now()->year, 'month' => now()->month]) }}" 
                                   class="font-bold text-slate-900 dark:text-white text-sm hover:text-cyan-400 transition-colors block">
                                    {{ $rep->name }}
                                </a>
                                <div class="text-[11px] text-slate-400 dark:text-slate-400 font-mono">{{ $rep->zone->name ?? 'Unassigned' }}</div>
                            </div>
                        </div>
                        <div class="text-right flex flex-col items-end">
                            <div class="font-mono font-bold text-slate-900 dark:text-white text-xs">
                                LKR {{ number_format($row['sales'] ?? 0, 0) }}
                            </div>
                            <div class="mt-1.5 flex items-center gap-2">
                                <div class="w-24 h-1.5 rounded-full bg-slate-200 dark:bg-white/10 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $bonusEarned ? 'bg-emerald-500' : 'bg-cyan-400' }}" style="width: {{ min(100, $progress) }}%;"></div>
                                </div>
                                <span class="text-[10px] font-mono {{ $bonusEarned ? 'text-emerald-500 font-bold' : 'text-slate-400' }}">
                                    {{ number_format($progress, 0) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-xs text-slate-400 dark:text-slate-500 font-mono">
                        No sales submissions recorded yet for this billing cycle.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Today's Activity & Submissions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        <!-- Today's Sales Submissions -->
        <div class="lg:col-span-2 bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-glaciar-gray-100/80 dark:border-white/10 p-6 lg:p-8 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Today's Sales Records</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-400 font-mono mt-0.5">{{ \Carbon\Carbon::today()->format('F d, Y') }}</p>
                </div>
                <a href="{{ route('admin.sales.index') }}" class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400 hover:underline">
                    All Sales &rarr;
                </a>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-white/10">
                    <thead class="bg-slate-50/80 dark:bg-white/[0.02]">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Field Rep</th>
                            <th class="px-6 py-3.5 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Gross Sales</th>
                            <th class="px-6 py-3.5 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Audit Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3.5 text-right text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($todaySubmissions ?? [] as $row)
                            @php $rep = $row['rep']; @endphp
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white">{{ $rep->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-semibold text-slate-900 dark:text-white">LKR {{ number_format($row['total_sales'] ?? 0, 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <x-admin.status-badge :status="$row['status']" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-slate-400">{{ $row['submitted_time'] ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.sales.salary.detail', ['repId' => $rep->id, 'year' => now()->year, 'month' => now()->month]) }}"
                                       class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400 hover:text-cyan-300">
                                        Audit &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-xs text-slate-400 dark:text-slate-500 font-mono">
                                    Zero field submissions clocked in today yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Today's Attendance Quick Widget -->
        <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-glaciar-gray-100/80 dark:border-white/10 p-6 lg:p-8 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Today's Muster Roll</h3>
                        <p class="text-xs text-slate-400 dark:text-slate-400 font-mono mt-0.5">STAFF ATTENDANCE LOG</p>
                    </div>
                    <a href="{{ route('admin.attendance.index') }}" class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400 hover:underline">
                        Manage &rarr;
                    </a>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 dark:bg-white/[0.02] border border-slate-100 dark:border-white/5">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Total Headcount</span>
                        <span class="text-base font-black font-mono text-slate-900 dark:text-white">{{ $todayAttendanceStats['total'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/20">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_6px_#10b981]"></span>
                            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400">Present On-Duty</span>
                        </div>
                        <span class="text-base font-black font-mono text-emerald-600 dark:text-emerald-400">{{ $todayAttendanceStats['present'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 rounded-xl bg-amber-500/5 border border-amber-500/20">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-[0_0_6px_#f59e0b]"></span>
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400">Late Arrival</span>
                        </div>
                        <span class="text-base font-black font-mono text-amber-600 dark:text-amber-400">{{ $todayAttendanceStats['late'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 rounded-xl bg-rose-500/5 border border-rose-500/20">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-[0_0_6px_#f43f5e]"></span>
                            <span class="text-xs font-bold text-rose-700 dark:text-rose-400">Absent / On Leave</span>
                        </div>
                        <span class="text-base font-black font-mono text-rose-600 dark:text-rose-400">{{ $todayAttendanceStats['absent'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.attendance.create') }}" class="mt-6 w-full py-3 bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 text-slate-900 dark:text-white text-xs font-mono font-bold uppercase tracking-wider rounded-xl border border-slate-200 dark:border-white/10 transition-colors text-center block">
                + Mark Field Attendance
            </a>
        </div>
    </div>

    <!-- Chart Configuration Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;

            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.04)';
            const textColor = isDark ? '#94a3b8' : '#64748b';

            // Area Gradient
            const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 320);
            gradient.addColorStop(0, isDark ? 'rgba(56, 189, 248, 0.35)' : 'rgba(56, 189, 248, 0.25)');
            gradient.addColorStop(1, 'rgba(56, 189, 248, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels ?? []),
                    datasets: [{
                        label: 'Company Revenue',
                        data: @json($chartValues ?? []),
                        borderColor: '#38bdf8',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.38,
                        pointBackgroundColor: '#070b12',
                        pointBorderColor: '#38bdf8',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDark ? '#0d1522' : '#ffffff',
                            titleColor: isDark ? '#ffffff' : '#0f172a',
                            bodyColor: '#38bdf8',
                            borderColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: LKR ' + Number(context.parsed.y).toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: {
                                color: textColor,
                                font: { family: 'monospace', size: 10 },
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M';
                                    if (value >= 1000) return (value / 1000).toFixed(0) + 'k';
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: textColor,
                                font: { family: 'monospace', size: 10 }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
