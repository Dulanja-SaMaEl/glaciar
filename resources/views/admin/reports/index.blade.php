@extends('layouts.admin')

@section('header', 'Reports')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-admin.stat-card title="Orders (Today)" value="{{ $stats['today_orders'] ?? 0 }}" icon="shopping-cart" />
        <x-admin.stat-card title="Revenue (Today)" value="LKR {{ number_format($stats['today_revenue'] ?? 0, 0) }}" icon="currency-dollar" />
        <x-admin.stat-card title="Pending Payments" value="{{ $stats['pending_payments'] ?? 0 }}" icon="credit-card" />
        <x-admin.stat-card title="Open Complaints" value="{{ $stats['open_complaints'] ?? 0 }}" icon="flag" />
    </div>

    <div class="mt-8 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
        <h3 class="text-lg font-bold text-glaciar-black mb-4">Totals</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="flex items-center justify-between border border-glaciar-gray-100 rounded-lg px-4 py-3">
                <span class="text-glaciar-gray-600">Customers</span>
                <span class="font-semibold text-glaciar-black">{{ $stats['customers'] ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between border border-glaciar-gray-100 rounded-lg px-4 py-3">
                <span class="text-glaciar-gray-600">Sales Reps</span>
                <span class="font-semibold text-glaciar-black">{{ $stats['reps'] ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between border border-glaciar-gray-100 rounded-lg px-4 py-3">
                <span class="text-glaciar-gray-600">Products</span>
                <span class="font-semibold text-glaciar-black">{{ $stats['products'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Reports Month Selector -->
    <div class="mt-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-glaciar-black">Reporting Period</h3>
            <p class="text-sm text-glaciar-gray-500 mt-1">Sales & salary calculations are based on submitted/verified records.</p>
        </div>

        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-center gap-3">
            <div>
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Month</label>
                <select name="month" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected($m === (int)$month)>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Year</label>
                <select name="year" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                    @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" @selected($y === (int)$year)>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="mt-5 inline-flex items-center justify-center px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-glaciar-gray-900 transition-colors">
                Apply
            </button>
        </form>
    </div>

    <!-- 1) Salary Report -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
        <div class="flex items-center justify-between mb-4 gap-3">
            <h3 class="text-lg font-bold text-glaciar-black">Salary Report ({{ $monthLabel }})</h3>
            <a
                href="#"
                class="px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-sm font-semibold text-glaciar-black hover:bg-glaciar-gray-50"
                onclick="return false;"
            >
                Export PDF
            </a>
        </div>

        <x-admin.data-table
            :columns="['Rep', 'Basic', 'Allow', 'Comm', 'Bonus', 'Total', 'Net Profit', '']"
            :items="collect($salaryRows)"
        >
            @foreach($salaryRows as $row)
                @php
                    $rep = $row['rep'];
                    $r = $row['result'];
                @endphp
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $rep->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$r['basic_salary'] }}">{{ number_format($r['basic_salary'], 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$r['allowance'] }}">{{ number_format($r['allowance'], 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$r['commission'] }}">{{ number_format($r['commission'], 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$r['bonus'] }}">{{ number_format($r['bonus'], 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ (float)$r['total_salary'] }}">{{ number_format($r['total_salary'], 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black" data-sort="{{ (float)$r['net_profit'] }}">{{ number_format($r['net_profit'], 0) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <a
                            href="{{ route('admin.sales.salary.detail', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}"
                            class="text-blue-600 hover:text-blue-900 font-semibold"
                        >
                            View
                        </a>
                    </td>
                </tr>
            @endforeach

            <tr class="font-bold bg-glaciar-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black">TOTAL</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$salaryTotals['basic'] }}">{{ number_format($salaryTotals['basic'], 0) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$salaryTotals['allowance'] }}">{{ number_format($salaryTotals['allowance'], 0) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$salaryTotals['commission'] }}">{{ number_format($salaryTotals['commission'], 0) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$salaryTotals['bonus'] }}">{{ number_format($salaryTotals['bonus'], 0) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ (float)$salaryTotals['total_salary'] }}">{{ number_format($salaryTotals['total_salary'], 0) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ (float)$salaryTotals['net_profit'] }}">{{ number_format($salaryTotals['net_profit'], 0) }}</td>
                <td></td>
            </tr>
        </x-admin.data-table>
    </div>

    <!-- 2) Sales vs Target Report -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
        <h3 class="text-lg font-bold text-glaciar-black mb-4">Sales vs Target Report ({{ $monthLabel }})</h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            <div>
                <x-admin.data-table
                    :columns="['Rep', 'Target', 'Actual', 'Variance', '% Achieved', 'Bonus Status', '']"
                    :items="collect($salesVsTargetRows)"
                >
                    @foreach($salesVsTargetRows as $row)
                        @php
                            $rep = $row['rep'];
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $rep->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['target'] }}">{{ number_format($row['target'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ (float)$row['actual'] }}">{{ number_format($row['actual'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['variance'] }}">{{ number_format($row['variance'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['pct_achieved'] }}">{{ number_format($row['pct_achieved'], 1) }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($row['bonus_earned'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Earned</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Not yet</span>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </x-admin.data-table>
            </div>

            <div class="bg-white rounded-xl border border-glaciar-gray-100 p-4">
                <div class="h-80">
                    <canvas id="salesVsTargetChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 3) Commission Analysis -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
        <h3 class="text-lg font-bold text-glaciar-black mb-4">Commission Analysis ({{ $monthLabel }})</h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            <div class="bg-white rounded-xl border border-glaciar-gray-100 p-4">
                <div class="h-80">
                    <canvas id="commissionPieChart"></canvas>
                </div>
            </div>

            <div>
                <x-admin.data-table
                    :columns="['Rep', 'Tier1 Sales', 'Tier1 Comm', 'Tier2 Sales', 'Tier2 Comm', 'Total Comm', '']"
                    :items="collect($commissionAnalysisRows)"
                >
                    @foreach($commissionAnalysisRows as $row)
                        @php $rep = $row['rep']; @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $rep->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['tier1_sales'] }}">{{ number_format($row['tier1_sales'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['tier1_comm'] }}">{{ number_format($row['tier1_comm'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['tier2_sales'] }}">{{ number_format($row['tier2_sales'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['tier2_comm'] }}">{{ number_format($row['tier2_comm'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ (float)$row['total_comm'] }}">{{ number_format($row['total_comm'], 0) }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </x-admin.data-table>
            </div>
        </div>
    </div>

    <!-- Quality & Compliance Reports -->
    <div class="mt-12">
        <h2 class="text-xl font-bold text-glaciar-black mb-2">Quality & Compliance Reports</h2>
        <p class="text-sm text-glaciar-gray-500 mb-6">Factory monitoring, testing, and hygiene records</p>

        <!-- Compliance Summary Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-4 mb-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-glaciar-black">Today: {{ $qualityStats['submitted_today'] ?? 0 }} / 8 reports submitted</span>
                @if(($qualityStats['submitted_today'] ?? 0) === 8)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">All reports up to date</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">{{ 8 - ($qualityStats['submitted_today'] ?? 0) }} reports pending today</span>
                @endif
            </div>
            <div class="w-full bg-glaciar-gray-100 rounded-full h-3 mb-3">
                <div class="bg-glaciar-black h-3 rounded-full transition-all" style="width: {{ (($qualityStats['submitted_today'] ?? 0) / 8) * 100 }}%"></div>
            </div>
            @if(!empty($qualityStats['missing_reports']))
                <div class="flex flex-wrap gap-2">
                    @foreach($qualityStats['missing_reports'] as $missing)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">{{ $missing }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Report Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $reportCards = [
                ['title' => 'Pest Control Monitoring', 'icon' => 'shield-check', 'desc' => 'Daily zone monitoring record', 'route' => 'admin.pest-control.index', 'key' => 'pest_control'],
                ['title' => 'Training Attendance', 'icon' => 'academic-cap', 'desc' => 'Daily staff training log', 'route' => 'admin.training-attendance.index', 'key' => 'training'],
                ['title' => 'Tank Cleaning Checklist', 'icon' => 'beaker', 'desc' => 'Per-tank cleaning verification', 'route' => 'admin.tank-cleaning.index', 'key' => 'tank_cleaning'],
                ['title' => 'Raw Water Testing', 'icon' => 'eye-dropper', 'desc' => 'Incoming water quality record', 'route' => 'admin.raw-water-testing.index', 'key' => 'raw_water'],
                ['title' => 'Raw Material Inspection', 'icon' => 'clipboard-document-check', 'desc' => 'Supplier material inspection', 'route' => 'admin.raw-material-inspection.index', 'key' => 'material_inspection'],
                ['title' => 'Treated Water Testing', 'icon' => 'sparkles', 'desc' => 'Post-treatment quality record', 'route' => 'admin.treated-water-testing.index', 'key' => 'treated_water'],
                ['title' => 'Daily Cleaning Checklist', 'icon' => 'home-modern', 'desc' => 'Factory area hygiene check', 'route' => 'admin.daily-cleaning.index', 'key' => 'daily_cleaning'],
                ['title' => 'UV Bulb Monitoring', 'icon' => 'sun', 'desc' => 'UV lamp usage tracking', 'route' => 'admin.uv-bulb-monitoring.index', 'key' => 'uv_bulb'],
            ];
            @endphp

            @foreach($reportCards as $card)
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-2 bg-glaciar-gray-100 rounded-lg">
                        @if($card['icon'] === 'shield-check')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        @elseif($card['icon'] === 'academic-cap')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        @elseif($card['icon'] === 'beaker')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        @elseif($card['icon'] === 'eye-dropper')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        @elseif($card['icon'] === 'clipboard-document-check')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        @elseif($card['icon'] === 'sparkles')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        @elseif($card['icon'] === 'home-modern')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        @elseif($card['icon'] === 'sun')
                            <svg class="w-6 h-6 text-glaciar-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        @endif
                    </div>
                    @php
                        $lastEntry = $qualityStats['last_entries'][$card['key']] ?? null;
                        $thisMonthCount = $qualityStats['this_month_counts'][$card['key']] ?? 0;
                        $hasToday = $qualityStats['today_entries'][$card['key']] ?? false;
                    @endphp
                    @if($hasToday)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Up to date</span>
                    @elseif($thisMonthCount > 0)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Missing today</span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-glaciar-gray-100 text-glaciar-gray-600">Not started</span>
                    @endif
                </div>
                
                <h3 class="font-bold text-glaciar-black mb-1">{{ $card['title'] }}</h3>
                <p class="text-xs text-glaciar-gray-500 mb-4">{{ $card['desc'] }}</p>
                
                <div class="text-xs text-glaciar-gray-500 mb-4">
                    @if($lastEntry)
                        Last entry: {{ $lastEntry->format('d M Y') }}
                    @else
                        <span class="text-red-500">No entries yet</span>
                    @endif
                    <br>
                    {{ $thisMonthCount }} entries this month
                </div>

                <div class="flex gap-2">
                    <a href="{{ route($card['route']) }}" class="flex-1 px-3 py-2 rounded-lg bg-glaciar-black text-white text-xs font-semibold text-center hover:bg-glaciar-gray-900 transition-colors">View & Add</a>
                    <a href="{{ route('admin.' . $card['key'] . '.export.pdf', ['month' => now()->month, 'year' => now()->year]) }}" class="flex-1 px-3 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-glaciar-black text-xs font-semibold text-center hover:bg-glaciar-gray-50 transition-colors">Export PDF</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const barCtx = document.getElementById('salesVsTargetChart');
            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($repNames ?? []),
                        datasets: [
                            {
                                label: 'Actual Sales',
                                data: @json($barActual ?? []),
                                backgroundColor: 'rgba(0,0,0,0.75)'
                            },
                            {
                                label: 'Target Sales',
                                data: @json($barTarget ?? []),
                                backgroundColor: 'rgba(245, 158, 11, 0.6)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: true } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#F3F4F6' } }
                        }
                    }
                });
            }

            const pieCtx = document.getElementById('commissionPieChart');
            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($commissionPie['labels'] ?? ['Tier 1','Tier 2']),
                        datasets: [{
                            data: @json($commissionPie['values'] ?? [0,0]),
                            backgroundColor: ['rgba(0,0,0,0.75)', 'rgba(34, 197, 94, 0.6)']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: true } }
                    }
                });
            }
        });
    </script>
@endsection

