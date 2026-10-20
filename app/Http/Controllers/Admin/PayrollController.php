<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rep;
use App\Models\Paysheet;
use App\Services\SalaryCalculatorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function history(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $paysheets = Paysheet::with('rep')
            ->where('year', $year)
            ->where('month', $month)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.payroll.history', compact('paysheets', 'year', 'month'));
    }

    public function generate(Request $request, $repId, $year, $month)
    {
        $rep = Rep::findOrFail($repId);
        $calculator = new SalaryCalculatorService();
        $monthly = $calculator->calculateForMonth($repId, $year, $month);

        // Check if paysheet already exists
        $existing = Paysheet::where('rep_id', $repId)->where('year', $year)->where('month', $month)->first();

        return view('admin.payroll.generate', compact('rep', 'year', 'month', 'monthly', 'existing'));
    }

    public function store(Request $request, $repId, $year, $month)
    {
        $validated = $request->validate([
            'basic_salary' => 'required|numeric',
            'attendance_allowance' => 'required|numeric',
            'sales_commission' => 'required|numeric',
            'incentives' => 'nullable|numeric',
            'performance_bonus' => 'nullable|numeric',
            'absent_deduction' => 'required|numeric',
            'late_deduction' => 'required|numeric',
            'epf_deduction' => 'required|numeric',
            'salary_advances' => 'nullable|numeric',
            'other_earnings_name' => 'nullable|array',
            'other_earnings_amount' => 'nullable|array',
            'other_deductions_name' => 'nullable|array',
            'other_deductions_amount' => 'nullable|array',
        ]);

        $otherEarnings = [];
        if (!empty($request->other_earnings_name)) {
            foreach ($request->other_earnings_name as $i => $name) {
                if (!empty($name) && !empty($request->other_earnings_amount[$i])) {
                    $otherEarnings[] = ['name' => $name, 'amount' => (float)$request->other_earnings_amount[$i]];
                }
            }
        }

        $otherDeductions = [];
        if (!empty($request->other_deductions_name)) {
            foreach ($request->other_deductions_name as $i => $name) {
                if (!empty($name) && !empty($request->other_deductions_amount[$i])) {
                    $otherDeductions[] = ['name' => $name, 'amount' => (float)$request->other_deductions_amount[$i]];
                }
            }
        }

        $totalEarnings = $validated['basic_salary'] + $validated['attendance_allowance'] + $validated['sales_commission'] + ($validated['incentives'] ?? 0) + ($validated['performance_bonus'] ?? 0);
        foreach ($otherEarnings as $oe) {
            $totalEarnings += $oe['amount'];
        }

        $totalDeductions = $validated['absent_deduction'] + $validated['late_deduction'] + $validated['epf_deduction'] + ($validated['salary_advances'] ?? 0);
        foreach ($otherDeductions as $od) {
            $totalDeductions += $od['amount'];
        }

        $netSalary = $totalEarnings - $totalDeductions;

        $paysheet = Paysheet::updateOrCreate(
            ['rep_id' => $repId, 'year' => $year, 'month' => $month],
            [
                'basic_salary' => $validated['basic_salary'],
                'attendance_allowance' => $validated['attendance_allowance'],
                'sales_commission' => $validated['sales_commission'],
                'incentives' => $validated['incentives'] ?? 0,
                'performance_bonus' => $validated['performance_bonus'] ?? 0,
                'other_earnings' => $otherEarnings,
                'total_earnings' => $totalEarnings,
                
                'absent_deduction' => $validated['absent_deduction'],
                'late_deduction' => $validated['late_deduction'],
                'epf_deduction' => $validated['epf_deduction'],
                'salary_advances' => $validated['salary_advances'] ?? 0,
                'other_deductions' => $otherDeductions,
                'total_deductions' => $totalDeductions,
                
                'net_salary' => $netSalary,
                'payment_status' => 'generated',
                'payment_date' => now(),
            ]
        );

        return redirect()->route('admin.payroll.history')->with('success', 'Paysheet generated successfully.');
    }

    public function downloadPdf($id)
    {
        $paysheet = Paysheet::with('rep')->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.payroll.pdf', compact('paysheet'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Paysheet-' . $paysheet->rep->name . '-' . $paysheet->year . '-' . $paysheet->month . '.pdf');
    }
}
