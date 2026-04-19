@extends('layouts.admin')

@section('header', 'Sales & Salary')

@section('content')
    <div class="flex flex-col gap-4 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.sales.salary.index', ['year' => $year, 'month' => $month]) }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-glaciar-gray-900 transition-colors"
                >
                    Salary Breakdown
                </a>
            </div>

            <form method="GET" action="{{ route('admin.sales.index') }}" class="flex items-center gap-3">
                <div>
                    <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Month</label>
                    <select
                        name="month"
                        class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm"
                    >
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected($m === (int)$month)>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Year</label>
                    <select
                        name="year"
                        class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm"
                    >
                        @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}" @selected($y === (int)$year)>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mt-5 flex items-center gap-3">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-glaciar-gray-900 transition-colors"
                    >
                        Apply
                    </button>
                </div>
            </form>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.sales.index', ['year' => $year, 'month' => $month, 'format' => 'pdf']) }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-sm font-semibold text-glaciar-black hover:bg-glaciar-gray-50"
                >
                    Export PDF Report
                </a>
                <a
                    href="{{ route('admin.sales.index', ['year' => $year, 'month' => $month, 'format' => 'csv']) }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-sm font-semibold text-glaciar-black hover:bg-glaciar-gray-50"
                >
                    Export CSV
                </a>
            </div>
        </div>

        <!-- Summary Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-admin.stat-card
                title="Total Company Sales"
                value="LKR {{ number_format($companyTotals['total_sales'] ?? 0, 0) }}"
                icon="currency-dollar"
            />

            <x-admin.stat-card
                title="Total Cost (60%)"
                value="LKR {{ number_format($companyTotals['total_cost'] ?? 0, 0) }}"
                icon="credit-card"
            />

            <x-admin.stat-card
                title="Gross Profit"
                value="LKR {{ number_format($companyTotals['gross_profit'] ?? 0, 0) }}"
                icon="chart-bar"
            />

            <x-admin.stat-card
                title="Total Salaries Paid"
                value="LKR {{ number_format($companyTotals['total_salary'] ?? 0, 0) }}"
                icon="truck"
            />
        </div>

        <!-- Profit Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <p class="text-sm font-medium text-glaciar-gray-500 mb-1">Net Profit (after all salaries)</p>
                <h3 class="text-3xl font-bold text-glaciar-black">
                    LKR {{ number_format($companyTotals['net_profit'] ?? 0, 0) }}
                </h3>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <p class="text-sm font-medium text-glaciar-gray-500 mb-1">Profit Margin %</p>
                <h3 class="text-3xl font-bold text-glaciar-black">
                    {{ number_format($profitMarginPct ?? 0, 1) }}%
                </h3>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-glaciar-black">Daily Sales — {{ \Carbon\Carbon::create($year, $month, 1)->format('F') }}</h3>
            </div>
            <div class="h-80 w-full relative">
                <canvas id="dailySalesChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-glaciar-black">Sales by Product</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                <div class="h-80">
                    <canvas id="productSalesChart"></canvas>
                </div>
                <div class="space-y-3">
                    @php
                        $total = (float) ($companyTotals['total_sales'] ?? 0);
                        $legendColors = [
                            '500ml' => '#000000',
                            '1000ml' => '#1f2937',
                            '1500ml' => '#6b7280',
                            '5000ml' => '#9ca3af',
                        ];
                    @endphp
                    @foreach($productBreakdown as $row)
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full" style="background-color: {{ $legendColors[$row['size']] ?? '#000' }};"></span>
                                <span class="text-sm font-semibold text-glaciar-black">{{ $row['label'] }}</span>
                            </div>
                            <span class="text-sm text-glaciar-gray-600">
                                {{ number_format($row['pct'] ?? 0, 1) }}% • LKR {{ number_format($row['revenue'] ?? 0, 0) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Product Breakdown Table -->
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
        <h3 class="text-lg font-bold text-glaciar-black mb-4">Product Breakdown</h3>

        <x-admin.data-table
            :columns="['Product', 'Cases Sold', 'Bottles', 'Revenue', '% of Total', '']"
            :items="collect($productBreakdown)"
        >
            @foreach($productBreakdown as $row)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $row['label'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int) $row['cases'] }}">{{ $row['cases'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int) $row['bottles'] }}">{{ $row['bottles'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black" data-sort="{{ (float) $row['revenue'] }}">
                        LKR {{ number_format($row['revenue'], 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (float) $row['pct'] }}">
                        {{ number_format($row['pct'], 1) }}%
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-glaciar-gray-500"></td>
                </tr>
            @endforeach

            @php
                $totalCases = array_sum(array_map(fn($r) => (int)$r['cases'], $productBreakdown ?? []));
                $totalBottles = array_sum(array_map(fn($r) => (int)$r['bottles'], $productBreakdown ?? []));
            @endphp
            <tr class="font-bold bg-glaciar-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black">TOTAL</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int) $totalCases }}">{{ $totalCases }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int) $totalBottles }}">{{ $totalBottles }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-black" data-sort="{{ (float) $companyTotals['total_sales'] }}">
                    LKR {{ number_format($companyTotals['total_sales'] ?? 0, 0) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="100">100%</td>
                <td></td>
            </tr>
        </x-admin.data-table>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dailyCtx = document.getElementById('dailySalesChart');
            if (dailyCtx) {
                const dailyLabels = @json(range(1, $daysInMonth));
                const dailyValues = @json(array_values($dailySales));

                new Chart(dailyCtx, {
                    type: 'line',
                    data: {
                        labels: dailyLabels,
                        datasets: [{
                            label: 'Daily Sales',
                            data: dailyValues,
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
                                        yMin: @json($tier1Cap),
                                        yMax: @json($tier1Cap),
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
                                        yMin: @json($bonusThreshold),
                                        yMax: @json($bonusThreshold),
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
                            y: {
                                beginAtZero: true,
                                grid: { color: '#F3F4F6' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            const productCtx = document.getElementById('productSalesChart');
            if (productCtx) {
                const values = @json($chartValues);
                new Chart(productCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            data: values,
                            borderWidth: 0,
                            backgroundColor: ['#000000', '#1f2937', '#6b7280', '#9ca3af'],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                    }
                });
            }
        });
    </script>
@endsection

