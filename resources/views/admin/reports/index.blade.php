@extends('layouts.admin')

@section('header', 'Reports')

@section('content')
    <style>
        /* Custom smooth entrance animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        /* Smooth progress bar growth */
        @keyframes growWidth {
            from {
                width: 0;
            }

            to {
                width: var(--target-width);
            }
        }

        .animate-grow {
            animation: growWidth 1s ease-out forwards;
        }

        /* Custom Table Row Hover */
        .table-row-hover:hover {
            background-color: rgba(0, 0, 0, 0.02);
            transition: background-color 0.2s ease;
        }
    </style>

    <div class="space-y-8 pb-12">
        <!-- Top Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $statData = [
                    ['title' => 'Orders (Today)', 'value' => $stats['today_orders'] ?? 0, 'icon' => 'shopping-cart'],
                    ['title' => 'Revenue (Today)', 'value' => 'LKR ' . number_format($stats['today_revenue'] ?? 0, 0), 'icon' => 'currency-dollar'],
                    ['title' => 'Pending Payments', 'value' => $stats['pending_payments'] ?? 0, 'icon' => 'credit-card'],
                    ['title' => 'Open Complaints', 'value' => $stats['open_complaints'] ?? 0, 'icon' => 'flag'],
                ];
            @endphp
            @foreach($statData as $index => $stat)
                <div class="animate-fade-in opacity-0" style="animation-delay: {{ $index * 0.1 }}s">
                    <x-admin.stat-card
                        class="hover:-translate-y-1 transition-transform duration-300 shadow-sm hover:shadow-md border border-glaciar-gray-100"
                        :title="$stat['title']" :value="$stat['value']" :icon="$stat['icon']" />
                </div>
            @endforeach
        </div>

        <!-- Totals Bar -->
        <div
            class="animate-fade-in opacity-0 delay-2 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-1 h-full bg-glaciar-black"></div>
            <h3 class="text-sm font-bold text-glaciar-black uppercase tracking-wider mb-5">Platform Overview</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach(['Customers' => $stats['customers'], 'Sales Reps' => $stats['reps'], 'Products' => $stats['products']] as $label => $val)
                    <div
                        class="flex flex-col border-l border-glaciar-gray-100 pl-4 hover:border-glaciar-black transition-colors duration-300">
                        <span class="text-xs font-semibold text-glaciar-gray-500 uppercase">{{ $label }}</span>
                        <span class="text-2xl font-bold text-glaciar-black">{{ $val ?? 0 }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Reporting Period & Filter -->
        <div
            class="animate-fade-in opacity-0 delay-3 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 bg-glaciar-gray-50/50 p-6 rounded-xl border border-dashed border-glaciar-gray-200">
            <div>
                <h3 class="text-lg font-bold text-glaciar-black">Reporting Period</h3>
                <p class="text-sm text-glaciar-gray-500">Analytics reflecting data for <span
                        class="font-bold text-glaciar-black underline decoration-glaciar-gray-300">{{ $monthLabel }}
                        {{ $year }}</span></p>
            </div>

            <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-end gap-3">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-glaciar-gray-500 uppercase tracking-widest">Month</label>
                    <select name="month"
                        class="bg-white border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-glaciar-black/5 outline-none transition-all">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected($m === (int) $month)>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-glaciar-gray-500 uppercase tracking-widest">Year</label>
                    <select name="year"
                        class="bg-white border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-glaciar-black/5 outline-none transition-all">
                        @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}" @selected($y === (int) $year)>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-glaciar-black text-white text-sm font-bold hover:shadow-lg hover:shadow-glaciar-black/20 active:scale-95 transition-all duration-200">
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- 1) Salary Report -->
        <div
            class="animate-fade-in opacity-0 delay-3 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-glaciar-gray-100 flex items-center justify-between bg-white">
                <h3 class="text-lg font-bold text-glaciar-black">Salary Breakdown</h3>
                <button
                    class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-glaciar-gray-200 text-xs font-bold hover:bg-glaciar-gray-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Export PDF
                </button>
            </div>

            <x-admin.data-table :columns="['Rep', 'Basic', 'Allow', 'Comm', 'Bonus', 'Total', 'Net Profit', '']"
                :items="collect($salaryRows)">
                @foreach($salaryRows as $row)
                    @php $rep = $row['rep'];
                    $r = $row['result']; @endphp
                    <tr class="table-row-hover transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $rep->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                            {{ number_format($r['basic_salary'], 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                            {{ number_format($r['allowance'], 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                            {{ number_format($r['commission'], 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                            {{ number_format($r['bonus'], 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">
                            {{ number_format($r['total_salary'], 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">
                            {{ number_format($r['net_profit'], 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <a href="{{ route('admin.sales.salary.detail', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}"
                                class="inline-flex items-center px-3 py-1 bg-glaciar-gray-100 text-glaciar-black rounded-md font-bold text-[11px] uppercase hover:bg-glaciar-black hover:text-white transition-all">Details</a>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-glaciar-black text-white font-bold">
                    <td class="px-6 py-4">TOTAL SUMMARY</td>
                    <td class="px-6 py-4">{{ number_format($salaryTotals['basic'], 0) }}</td>
                    <td class="px-6 py-4">{{ number_format($salaryTotals['allowance'], 0) }}</td>
                    <td class="px-6 py-4">{{ number_format($salaryTotals['commission'], 0) }}</td>
                    <td class="px-6 py-4">{{ number_format($salaryTotals['bonus'], 0) }}</td>
                    <td class="px-6 py-4">{{ number_format($salaryTotals['total_salary'], 0) }}</td>
                    <td class="px-6 py-4 text-emerald-400">{{ number_format($salaryTotals['net_profit'], 0) }}</td>
                    <td></td>
                </tr>
            </x-admin.data-table>
        </div>

        <!-- 2) Sales vs Target Section -->
        <div class="animate-fade-in opacity-0 delay-3 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <h3 class="text-lg font-bold text-glaciar-black mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    Sales vs Target
                </h3>
                <x-admin.data-table :columns="['Rep', 'Target', 'Actual', 'Variance', '%', 'Status']"
                    :items="collect($salesVsTargetRows)">
                    @foreach($salesVsTargetRows as $row)
                        <tr class="table-row-hover">
                            <td class="px-6 py-4 text-sm font-bold text-glaciar-black">{{ $row['rep']->name }}</td>
                            <td class="px-6 py-4 text-sm text-glaciar-gray-600">{{ number_format($row['target'], 0) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-glaciar-black">{{ number_format($row['actual'], 0) }}
                            </td>
                            <td class="px-6 py-4 text-sm {{ $row['variance'] >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ number_format($row['variance'], 0) }}</td>
                            <td class="px-6 py-4 text-sm font-mono">{{ number_format($row['pct_achieved'], 1) }}%</td>
                            <td class="px-6 py-4">
                                @if($row['bonus_earned'])
                                    <span
                                        class="px-2 py-1 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Achieved</span>
                                @else
                                    <span
                                        class="px-2 py-1 rounded text-[10px] font-bold bg-amber-50 text-amber-600 uppercase">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-admin.data-table>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 flex flex-col justify-center">
                <div class="h-72 w-full">
                    <canvas id="salesVsTargetChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Quality & Compliance Reports Section -->
        <div class="pt-8 border-t border-glaciar-gray-200">
            <div class="mb-8 animate-fade-in opacity-0">
                <h2 class="text-2xl font-black text-glaciar-black tracking-tight">Quality & Compliance</h2>
                <p class="text-sm text-glaciar-gray-500">Real-time factory audit and safety monitoring status</p>
            </div>

            <!-- Compliance Summary Bar -->
            @php
                $completionPct = (($qualityStats['submitted_today'] ?? 0) / 8) * 100;
            @endphp
            <div
                class="animate-fade-in opacity-0 delay-1 bg-glaciar-black rounded-2xl shadow-xl p-8 mb-10 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div>
                            <span class="text-glaciar-gray-400 text-xs font-bold uppercase tracking-widest">Daily Operations
                                Status</span>
                            <h4 class="text-3xl font-black mt-1">{{ $qualityStats['submitted_today'] ?? 0 }} <span
                                    class="text-lg font-light text-glaciar-gray-400">/ 8 Reports Submitted</span></h4>
                        </div>
                        @if($completionPct === 100)
                            <div
                                class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 px-4 py-2 rounded-xl text-sm font-bold">
                                ✓ Fully Compliant Today</div>
                        @else
                            <div
                                class="bg-amber-500/20 text-amber-400 border border-amber-500/50 px-4 py-2 rounded-xl text-sm font-bold">
                                Pending: {{ 8 - ($qualityStats['submitted_today'] ?? 0) }} Units</div>
                        @endif
                    </div>

                    <div class="w-full bg-white/10 rounded-full h-4 mb-6 p-1">
                        <div class="bg-white h-2 rounded-full animate-grow"
                            style="--target-width: {{ $completionPct }}%; width: {{ $completionPct }}%"></div>
                    </div>

                    @if(!empty($qualityStats['missing_reports']))
                        <div class="flex flex-wrap gap-2">
                            @foreach($qualityStats['missing_reports'] as $missing)
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-bold bg-white/5 border border-white/10 text-white/80 uppercase tracking-tighter">{{ $missing }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Report Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $reportCards = [
                        ['title' => 'Pest Control', 'icon' => 'shield-check', 'desc' => 'Zone monitoring', 'route' => 'admin.pest-control.index', 'key' => 'pest_control'],
                        ['title' => 'Training Log', 'icon' => 'academic-cap', 'desc' => 'Staff attendance', 'route' => 'admin.training-attendance.index', 'key' => 'training'],
                        ['title' => 'Tank Cleaning', 'icon' => 'beaker', 'desc' => 'Cleaning verification', 'route' => 'admin.tank-cleaning.index', 'key' => 'tank_cleaning'],
                        ['title' => 'Raw Water', 'icon' => 'eye-dropper', 'desc' => 'Quality record', 'route' => 'admin.raw-water-testing.index', 'key' => 'raw_water'],
                        ['title' => 'Material Inspection', 'icon' => 'clipboard-document-check', 'desc' => 'Supplier inspection', 'route' => 'admin.raw-material-inspection.index', 'key' => 'material_inspection'],
                        ['title' => 'Treated Water', 'icon' => 'sparkles', 'desc' => 'Post-treatment quality', 'route' => 'admin.treated-water-testing.index', 'key' => 'treated_water'],
                        ['title' => 'Daily Hygiene', 'icon' => 'home-modern', 'desc' => 'Area cleaning check', 'route' => 'admin.daily-cleaning.index', 'key' => 'daily_cleaning'],
                        ['title' => 'UV Monitoring', 'icon' => 'sun', 'desc' => 'Bulb usage tracking', 'route' => 'admin.uv-bulb-monitoring.index', 'key' => 'uv_bulb'],
                    ];
                @endphp

                @foreach($reportCards as $index => $card)
                    <div class="animate-fade-in opacity-0 group bg-white rounded-2xl shadow-sm border border-glaciar-gray-100 p-6 hover:shadow-xl hover:shadow-glaciar-gray-200/50 transition-all duration-300 transform hover:-translate-y-1"
                        style="animation-delay: {{ 0.1 + ($index * 0.05) }}s">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-12 h-12 bg-glaciar-gray-50 rounded-2xl flex items-center justify-center group-hover:bg-glaciar-black group-hover:text-white transition-colors duration-300">
                                {{-- Icon Logic Simplified for brevity --}}
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            @php $hasToday = $qualityStats['today_entries'][$card['key']] ?? false; @endphp
                            <div class="w-3 h-3 rounded-full {{ $hasToday ? 'bg-emerald-500' : 'bg-amber-400' }} shadow-lg">
                            </div>
                        </div>

                        <h3 class="font-bold text-glaciar-black group-hover:text-glaciar-black transition-colors">
                            {{ $card['title'] }}</h3>
                        <p class="text-[11px] text-glaciar-gray-500 mb-4 uppercase font-bold tracking-tighter">
                            {{ $card['desc'] }}</p>

                        <div class="flex flex-col gap-1 mb-6">
                            <div class="flex justify-between text-[10px] font-bold uppercase">
                                <span class="text-glaciar-gray-400">Last Entry</span>
                                <span
                                    class="text-glaciar-black">{{ $qualityStats['last_entries'][$card['key']] ? $qualityStats['last_entries'][$card['key']]->format('d M') : 'Never' }}</span>
                            </div>
                            <div class="flex justify-between text-[10px] font-bold uppercase">
                                <span class="text-glaciar-gray-400">Monthly total</span>
                                <span
                                    class="text-glaciar-black">{{ $qualityStats['this_month_counts'][$card['key']] ?? 0 }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route($card['route']) }}"
                                class="bg-glaciar-black text-white text-[10px] font-bold text-center py-2.5 rounded-lg hover:bg-opacity-90 transition-all uppercase tracking-widest">Logs</a>
                            <a href="{{ route('admin.' . $card['key'] . '.export.pdf', ['month' => $month, 'year' => $year]) }}"
                                class="bg-glaciar-gray-50 text-glaciar-black border border-glaciar-gray-200 text-[10px] font-bold text-center py-2.5 rounded-lg hover:bg-white transition-all uppercase tracking-widest">PDF</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart defaults for cleaner look
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#6B7280';

            const barCtx = document.getElementById('salesVsTargetChart');
            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($repNames ?? []),
                        datasets: [
                            {
                                label: 'Actual',
                                data: @json($barActual ?? []),
                                backgroundColor: '#000000',
                                borderRadius: 6,
                                barThickness: 20
                            },
                            {
                                label: 'Target',
                                data: @json($barTarget ?? []),
                                backgroundColor: '#F59E0B',
                                borderRadius: 6,
                                barThickness: 20
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true, padding: 20 } }
                        },
                        scales: {
                            y: { border: { display: false }, grid: { color: '#F3F4F6' } },
                            x: { border: { display: false }, grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
@endsection