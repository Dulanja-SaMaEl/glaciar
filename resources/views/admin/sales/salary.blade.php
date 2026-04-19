@extends('layouts.admin')

@section('header', 'Salary Breakdown')

@section('content')
    <div class="flex flex-col gap-4 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <form method="GET" action="{{ route('admin.sales.salary.index') }}" class="flex items-center gap-3">
                <div>
                    <label class="block text-xs font-semibold text-glaciar-gray-500 uppercase mb-1">Month</label>
                    <select name="month" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected($m === (int)$month)>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
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

            <a
                href="{{ route('admin.sales.index', ['year' => $year, 'month' => $month]) }}"
                class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-white border border-glaciar-gray-200 text-sm font-semibold text-glaciar-black hover:bg-glaciar-gray-50"
            >
                Back to Sales
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden p-6">
        <h3 class="text-lg font-bold text-glaciar-black mb-4">Per-Rep Salary ({{
            \Carbon\Carbon::create($year, $month, 1)->format('F Y')
        }})</h3>

        <x-admin.data-table
            :columns="['Rep Name', 'Zone', 'Sales', 'Basic', 'Allow', 'Comm', 'Bonus', 'Total Salary', 'Net Profit', '']"
            :items="collect($rows)"
        >
            @php $count = count($rows); @endphp

            @foreach($rows as $row)
                @php
                    $rep = $row['rep'];
                    $result = $row['result'];
                @endphp
                <tr class="{{ $row['tint'] }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black" data-sort="{{ (int)$rep->id }}">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center overflow-hidden">
                                @if(!empty($rep->avatar))
                                    <img src="{{ $rep->avatar }}" alt="avatar" class="w-full h-full object-cover">
                                @else
                                    <span class="text-blue-600 font-bold text-sm">{{ substr($rep->name ?? 'R', 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="font-semibold">{{ $rep->name }}</div>
                                <div class="text-xs text-glaciar-gray-500">#REP-{{ str_pad($rep->employee_id ? preg_replace('/\D+/', '', $rep->employee_id) : (string)$rep->id, 3, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500" data-sort="{{ $rep->zone->name ?? '' }}">
                        {{ $rep->zone->name ?? '—' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black" data-sort="{{ (float)$row['sales'] }}">
                        LKR {{ number_format($row['sales'], 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['basic'] }}">
                        LKR {{ number_format($row['basic'], 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['allowance'] }}">
                        LKR {{ number_format($row['allowance'], 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['commission'] }}">
                        LKR {{ number_format($row['commission'], 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600" data-sort="{{ (float)$row['bonus'] }}">
                        LKR {{ number_format($row['bonus'], 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-glaciar-black" data-sort="{{ (float)$row['total_salary'] }}">
                        LKR {{ number_format($row['total_salary'], 0) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black" data-sort="{{ (float)$row['net_profit'] }}">
                        LKR {{ number_format($row['net_profit'], 0) }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <div class="flex flex-col items-end gap-2">
                            <a
                                href="{{ route('admin.sales.salary.detail', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}"
                                class="text-blue-600 hover:text-blue-900 font-semibold"
                            >
                                View Detail
                            </a>

                            <form method="POST" action="{{ route('admin.sales.salary.verify', ['repId' => $rep->id]) }}">
                                @csrf
                                <input type="hidden" name="year" value="{{ $year }}">
                                <input type="hidden" name="month" value="{{ $month }}">
                                <button
                                    type="submit"
                                    class="text-xs px-3 py-1.5 rounded-md bg-glaciar-black text-white hover:bg-glaciar-gray-900"
                                >
                                    Verify
                                </button>
                            </form>

                            <a
                                href="{{ route('admin.sales.salary.pdf', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}"
                                class="text-xs px-3 py-1.5 rounded-md border border-glaciar-gray-200 text-glaciar-black hover:bg-glaciar-gray-50"
                            >
                                Export PDF
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.data-table>
    </div>

    <!-- Company totals row -->
    <div class="mt-4 bg-white border border-glaciar-gray-100 rounded-xl shadow-sm p-4 sticky bottom-0">
        @php
            $n = count($rows);
            $basicTotal = (float) config('salary.basic_salary') * $n;
            $allowTotal = (float) config('salary.allowance') * $n;
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-9 gap-3 text-sm font-semibold text-glaciar-black">
            <div class="text-glaciar-gray-500">—</div>
            <div class="text-glaciar-gray-500">—</div>
            <div class="text-right">Total Sales: LKR {{ number_format($companyTotals['total_sales'] ?? 0, 0) }}</div>
            <div class="text-right">Basic: LKR {{ number_format($basicTotal, 0) }}</div>
            <div class="text-right">Allow: LKR {{ number_format($allowTotal, 0) }}</div>
            <div class="text-right">Total Comm: LKR {{ number_format($companyTotals['commission'] ?? 0, 0) }}</div>
            <div class="text-right">Total Bonus: LKR {{ number_format($companyTotals['bonus'] ?? 0, 0) }}</div>
            <div class="text-right">Total Salaries: LKR {{ number_format($companyTotals['total_salary'] ?? 0, 0) }}</div>
            <div class="text-right">Net Profit: LKR {{ number_format($companyTotals['net_profit'] ?? 0, 0) }}</div>
        </div>
    </div>
@endsection

