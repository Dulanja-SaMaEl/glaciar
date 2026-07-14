@extends('layouts.admin')

@section('header', 'Rep Salary Detail')

@section('content')
    @php
        $monthLabel = \Carbon\Carbon::create($year, $month, 1)->format('F Y');
    @endphp

    <div class="flex flex-col gap-4 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-glaciar-black">{{ $rep->name }} — {{ $monthLabel }} Salary Statement</h2>
                <p class="text-sm text-glaciar-gray-500 mt-1">
                    Employee ID: <span class="font-semibold">{{ $rep->employee_id ?? ('REP-' . $rep->id) }}</span>
                </p>
            </div>

            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.sales.salary.detail', ['repId' => $rep->id]) }}" class="flex items-center gap-3">
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
                    <button type="submit" class="mt-5 px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-glaciar-gray-900 transition-colors">
                        Apply
                    </button>
                </form>

                <a
                    href="{{ route('admin.sales.salary.pdf', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-sm font-semibold text-glaciar-black hover:bg-glaciar-gray-50"
                >
                    Export as PDF
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Rep Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-blue-50 border border-blue-100 overflow-hidden flex items-center justify-center">
                        @if(!empty($rep->avatar))
                            <img src="{{ $rep->avatar }}" alt="rep avatar" class="w-full h-full object-cover">
                        @else
                            <span class="text-blue-600 font-bold text-xl">{{ substr($rep->name ?? 'R', 0, 1) }}</span>
                        @endif
                    </div>
                    <div>
                        <div class="text-xl font-bold text-glaciar-black">{{ $rep->name }}</div>
                        <div class="text-sm text-glaciar-gray-500 mt-1">{{ $rep->zone->name ?? '—' }}</div>
                        <div class="text-sm text-glaciar-gray-500 mt-1">{{ $rep->phone ?? '' }}</div>
                    </div>
                </div>
            </div>

            <!-- Monthly Summary Card -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <h3 class="text-lg font-bold text-glaciar-black mb-4">Monthly Summary</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-glaciar-gray-600">Total Sales</span>
                        <span class="font-semibold text-glaciar-black" data-sort="{{ (float)($monthly['total_sales'] ?? 0) }}">
                            LKR {{ number_format($monthly['total_sales'] ?? 0, 0) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-glaciar-gray-600">Total Cost (60%)</span>
                        <span class="font-semibold text-glaciar-black">
                            LKR {{ number_format($monthly['total_cost'] ?? 0, 0) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-glaciar-gray-600">Gross Profit</span>
                        <span class="font-semibold text-glaciar-black">
                            LKR {{ number_format($monthly['gross_profit'] ?? 0, 0) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Detailed Salary Breakdown Card -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-glaciar-black">Detailed Salary Breakdown</h3>
                    <a href="{{ route('admin.payroll.generate', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">
                        Generate Paysheet
                    </a>
                </div>

                @php
                    $basic = (float) ($monthly['basic_salary'] ?? 0);
                    $allow = (float) ($monthly['allowance'] ?? 0);
                    $break = $monthly['commission_breakdown'] ?? [];
                    $comm = (float) ($monthly['commission'] ?? 0);
                    $bonus = (float) ($monthly['bonus'] ?? 0);
                    $totEarn = (float) ($monthly['total_earnings'] ?? 0);

                    $absentDed = (float) ($monthly['absent_deduction'] ?? 0);
                    $lateDed = (float) ($monthly['late_deduction'] ?? 0);
                    $epfDed = (float) ($monthly['epf_deduction'] ?? 0);
                    $totDed = (float) ($monthly['total_deductions'] ?? 0);
                    
                    $net = (float) ($monthly['net_salary'] ?? 0);
                @endphp

                <div class="font-mono text-sm text-glaciar-black bg-glaciar-gray-50/40 border border-glaciar-gray-200 rounded-lg p-4 space-y-4">
                    
                    <!-- Earnings Section -->
                    <div>
                        <div class="font-bold text-green-700 uppercase tracking-wider text-xs border-b border-gray-300 pb-1 mb-2">Earnings</div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Basic Salary</span>
                            <span>LKR {{ number_format($basic, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Fixed Allowance</span>
                            <span>LKR {{ number_format($allow, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Sales Commission</span>
                            <span>LKR {{ number_format($comm, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Performance Bonus</span>
                            <span>LKR {{ number_format($bonus, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-dashed border-gray-300 font-bold">
                            <span>Total Earnings</span>
                            <span class="text-green-700">LKR {{ number_format($totEarn, 2) }}</span>
                        </div>
                    </div>

                    <!-- Deductions Section -->
                    <div>
                        <div class="font-bold text-red-700 uppercase tracking-wider text-xs border-b border-gray-300 pb-1 mb-2">Deductions</div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Absent Days ({{ $monthly['absent_days'] ?? 0 }})</span>
                            <span>LKR {{ number_format($absentDed, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">Late Arrivals ({{ $monthly['late_days'] ?? 0 }})</span>
                            <span>LKR {{ number_format($lateDed, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-600">EPF/ETF (Estimated)</span>
                            <span>LKR {{ number_format($epfDed, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-dashed border-gray-300 font-bold">
                            <span>Total Deductions</span>
                            <span class="text-red-700">LKR {{ number_format($totDed, 2) }}</span>
                        </div>
                    </div>

                    <!-- Net Salary -->
                    <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg flex justify-between items-center text-lg font-extrabold mt-2">
                        <span>NET SALARY</span>
                        <span class="text-blue-700">LKR {{ number_format($net, 2) }}</span>
                    </div>

                </div>
            </div>

            <!-- Net Profit Card -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <h3 class="text-lg font-bold text-glaciar-black mb-2">Net Profit</h3>
                <p class="text-sm text-glaciar-gray-500 mb-4">Gross Profit - Total Salary</p>
                <div class="text-3xl font-extrabold text-glaciar-black">
                    LKR {{ number_format($monthly['net_profit'] ?? 0, 0) }}
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Threshold Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-glaciar-black">Daily Sales (Rep) — {{ $monthLabel }}</h3>
                </div>
                <div class="h-80 w-full relative">
                    <canvas id="repDailySalesChart"></canvas>
                </div>
            </div>

            <!-- Daily Sales Records Table -->
            <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-glaciar-black">Daily Sales Records</h3>
                </div>

                <x-admin.data-table
                    :columns="['Date', '500ml', '1L', '1.5L', '5L', 'Total Sales', 'Status', '']"
                    :items="collect($records)"
                >
                    @foreach($records as $record)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int)$record->cases_500ml }}">{{ (int)$record->cases_500ml }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int)$record->cases_1000ml }}">{{ (int)$record->cases_1000ml }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int)$record->cases_1500ml }}">{{ (int)$record->cases_1500ml }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ (int)$record->cases_5000ml }}">{{ (int)$record->cases_5000ml }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black" data-sort="{{ (float)$record->total_sales }}">
                                LKR {{ number_format($record->total_sales, 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <x-admin.status-badge :status="$record->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if($record->status === 'submitted')
                                    <form method="POST" action="{{ route('admin.sales.verify.record', ['sale' => $record->id]) }}">
                                        @csrf
                                        <button type="submit" class="text-xs px-3 py-1.5 rounded-md bg-amber-500 text-black hover:bg-amber-400 font-semibold">
                                            Verify
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-glaciar-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-admin.data-table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const repCtx = document.getElementById('repDailySalesChart');
            if (!repCtx) return;

            const labels = @json(range(1, $daysInMonth));
            const values = @json(array_values($dailySales));

            new Chart(repCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Sales',
                        data: values,
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
                                    label: { enabled: true, content: 'Tier Change (1,200,000)', position: 'end' }
                                },
                                bonusTarget: {
                                    type: 'line',
                                    yMin: @json($bonusThreshold),
                                    yMax: @json($bonusThreshold),
                                    borderColor: 'rgba(34, 197, 94, 1)',
                                    borderWidth: 2,
                                    borderDash: [6, 6],
                                    label: { enabled: true, content: 'Bonus Target (1,500,000)', position: 'end' }
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

