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

