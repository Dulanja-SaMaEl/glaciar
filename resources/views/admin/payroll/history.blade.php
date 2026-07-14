@extends('layouts.admin')
@section('header', 'Payroll History')

@section('content')
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-glaciar-black">Payroll History</h2>
        <p class="text-sm text-glaciar-gray-500 mt-1">View and manage generated paysheets.</p>
    </div>

    <form method="GET" action="{{ route('admin.payroll.history') }}" class="flex items-end gap-3 bg-white p-3 rounded-xl border shadow-sm">
        <div>
            <label class="block text-[10px] font-bold text-glaciar-gray-500 uppercase tracking-widest mb-1">Month</label>
            <select name="month" class="w-full border-gray-200 rounded-lg text-sm font-medium">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" @selected($m === (int)$month)>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-bold text-glaciar-gray-500 uppercase tracking-widest mb-1">Year</label>
            <select name="year" class="w-full border-gray-200 rounded-lg text-sm font-medium">
                @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}" @selected($y === (int)$year)>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-glaciar-black text-white text-sm font-bold rounded-lg hover:bg-glaciar-dark transition-colors">
            Filter
        </button>
    </form>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative">
        <span class="block sm:inline font-bold">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-glaciar-black">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Employee</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Period</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Total Earnings</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Total Deductions</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Net Salary</th>
                <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            @forelse($paysheets as $sheet)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
                                {{ substr($sheet->rep->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-glaciar-black">{{ $sheet->rep->name }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $sheet->rep->employee_id ?? 'REP-'.$sheet->rep->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">
                        {{ \Carbon\Carbon::create($sheet->year, $sheet->month, 1)->format('M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-700">
                        LKR {{ number_format($sheet->total_earnings, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-700">
                        LKR {{ number_format($sheet->total_deductions, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            LKR {{ number_format($sheet->net_salary, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.payroll.generate', ['repId' => $sheet->rep_id, 'year' => $sheet->year, 'month' => $sheet->month]) }}" class="text-blue-600 hover:text-blue-900 transition-colors">Edit</a>
                            <a href="{{ route('admin.payroll.pdf', $sheet->id) }}" class="text-glaciar-black hover:text-glaciar-dark font-bold underline" target="_blank">Download PDF</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="block font-medium">No paysheets found for this period.</span>
                        <span class="block text-sm mt-1">Generate paysheets from the Sales & Salary detail page.</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $paysheets->links() }}
    </div>
</div>
@endsection
