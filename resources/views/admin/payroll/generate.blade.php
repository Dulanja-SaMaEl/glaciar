@extends('layouts.admin')
@section('header', 'Generate Paysheet')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.sales.salary.detail', $rep->id) }}?year={{ $year }}&month={{ $month }}" class="text-sm font-semibold text-glaciar-gray-500 hover:text-glaciar-black transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Details
    </a>
</div>

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border p-8">
    <div class="flex items-center justify-between mb-8 pb-4 border-b">
        <div>
            <h2 class="text-2xl font-bold text-glaciar-black">Generate Paysheet</h2>
            <p class="text-sm text-gray-500 mt-1">For {{ $rep->name }} - {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</p>
        </div>
        @if($existing)
            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Paysheet Already Exists (Will be overwritten)</span>
        @endif
    </div>

    <form action="{{ route('admin.payroll.store', ['repId' => $rep->id, 'year' => $year, 'month' => $month]) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Earnings -->
            <div>
                <h3 class="text-lg font-bold text-green-700 mb-4 uppercase tracking-wide">Earnings</h3>
                <div class="space-y-4 bg-green-50/30 p-5 rounded-lg border border-green-100">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Basic Salary</label>
                        <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary', $existing->basic_salary ?? $monthly['basic_salary'] ?? 0) }}" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Fixed Allowance</label>
                        <input type="number" step="0.01" name="attendance_allowance" value="{{ old('attendance_allowance', $existing->attendance_allowance ?? $monthly['allowance'] ?? 0) }}" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Sales Commission</label>
                        <input type="number" step="0.01" name="sales_commission" value="{{ old('sales_commission', $existing->sales_commission ?? $monthly['commission'] ?? 0) }}" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Performance Bonus</label>
                        <input type="number" step="0.01" name="performance_bonus" value="{{ old('performance_bonus', $existing->performance_bonus ?? $monthly['bonus'] ?? 0) }}" class="w-full px-3 py-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Incentives</label>
                        <input type="number" step="0.01" name="incentives" value="{{ old('incentives', $existing->incentives ?? 0) }}" class="w-full px-3 py-2 border rounded-md">
                    </div>

                    <div class="pt-4 border-t border-green-200">
                        <h4 class="text-xs font-bold text-gray-700 mb-2">Other Earnings (Optional)</h4>
                        <div id="other-earnings-container">
                            <!-- Dynamic Rows -->
                            <div class="flex gap-2 mb-2">
                                <input type="text" name="other_earnings_name[]" placeholder="Description" class="flex-1 px-3 py-1.5 text-sm border rounded-md">
                                <input type="number" step="0.01" name="other_earnings_amount[]" placeholder="Amount" class="w-32 px-3 py-1.5 text-sm border rounded-md">
                            </div>
                        </div>
                        <button type="button" onclick="addEarningRow()" class="text-xs text-green-700 font-bold hover:underline">+ Add Earning</button>
                    </div>
                </div>
            </div>

            <!-- Deductions -->
            <div>
                <h3 class="text-lg font-bold text-red-700 mb-4 uppercase tracking-wide">Deductions</h3>
                <div class="space-y-4 bg-red-50/30 p-5 rounded-lg border border-red-100">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Absent Deduction ({{ $monthly['absent_days'] ?? 0 }} days)</label>
                        <input type="number" step="0.01" name="absent_deduction" value="{{ old('absent_deduction', $existing->absent_deduction ?? $monthly['absent_deduction'] ?? 0) }}" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Late Deduction ({{ $monthly['late_days'] ?? 0 }} days)</label>
                        <input type="number" step="0.01" name="late_deduction" value="{{ old('late_deduction', $existing->late_deduction ?? $monthly['late_deduction'] ?? 0) }}" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">EPF/ETF</label>
                        <input type="number" step="0.01" name="epf_deduction" value="{{ old('epf_deduction', $existing->epf_deduction ?? $monthly['epf_deduction'] ?? 0) }}" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Salary Advances / Loans</label>
                        <input type="number" step="0.01" name="salary_advances" value="{{ old('salary_advances', $existing->salary_advances ?? 0) }}" class="w-full px-3 py-2 border rounded-md">
                    </div>

                    <div class="pt-4 border-t border-red-200">
                        <h4 class="text-xs font-bold text-gray-700 mb-2">Other Deductions (Optional)</h4>
                        <div id="other-deductions-container">
                            <!-- Dynamic Rows -->
                            <div class="flex gap-2 mb-2">
                                <input type="text" name="other_deductions_name[]" placeholder="Description" class="flex-1 px-3 py-1.5 text-sm border rounded-md">
                                <input type="number" step="0.01" name="other_deductions_amount[]" placeholder="Amount" class="w-32 px-3 py-1.5 text-sm border rounded-md">
                            </div>
                        </div>
                        <button type="button" onclick="addDeductionRow()" class="text-xs text-red-700 font-bold hover:underline">+ Add Deduction</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-4 border-t pt-6">
            <a href="{{ route('admin.sales.salary.detail', $rep->id) }}?year={{ $year }}&month={{ $month }}" class="px-6 py-2.5 rounded-lg text-gray-600 font-bold hover:bg-gray-100 transition-colors">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition-colors shadow-sm">
                Save & Generate Paysheet
            </button>
        </div>
    </form>
</div>

<script>
    function addEarningRow() {
        const container = document.getElementById('other-earnings-container');
        const row = document.createElement('div');
        row.className = 'flex gap-2 mb-2';
        row.innerHTML = `
            <input type="text" name="other_earnings_name[]" placeholder="Description" class="flex-1 px-3 py-1.5 text-sm border rounded-md">
            <input type="number" step="0.01" name="other_earnings_amount[]" placeholder="Amount" class="w-32 px-3 py-1.5 text-sm border rounded-md">
        `;
        container.appendChild(row);
    }

    function addDeductionRow() {
        const container = document.getElementById('other-deductions-container');
        const row = document.createElement('div');
        row.className = 'flex gap-2 mb-2';
        row.innerHTML = `
            <input type="text" name="other_deductions_name[]" placeholder="Description" class="flex-1 px-3 py-1.5 text-sm border rounded-md">
            <input type="number" step="0.01" name="other_deductions_amount[]" placeholder="Amount" class="w-32 px-3 py-1.5 text-sm border rounded-md">
        `;
        container.appendChild(row);
    }
</script>
@endsection
