<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CasePrice;
use App\Models\Rep;
use App\Models\SalesRecord;
use App\Services\SalaryCalculatorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    private function monthRange(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = (clone $start)->endOfMonth();
        return [$start->toDateString(), $end->toDateString()];
    }

    private function currentAdminId(): ?int
    {
        $userId = Auth::id();
        if (!$userId) {
            return Admin::query()->orderBy('id')->value('id');
        }

        $admin = Admin::query()->where('user_id', $userId)->first();
        return $admin?->id ?? Admin::query()->orderBy('id')->value('id');
    }

    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);
        [$from, $to] = $this->monthRange($year, $month);

        $calculator = new SalaryCalculatorService();

        $repIds = SalesRecord::query()
            ->whereBetween('date', [$from, $to])
            ->whereIn('status', ['submitted', 'verified'])
            ->distinct()
            ->pluck('rep_id')
            ->values();

        if ($repIds->isEmpty()) {
            // Show a still-valid page even if no sales exist yet.
            $repIds = Rep::query()->pluck('id')->take(5);
        }

        $companyTotals = [
            'total_sales' => 0.0,
            'total_cost' => 0.0,
            'gross_profit' => 0.0,
            'commission' => 0.0,
            'bonus' => 0.0,
            'total_salary' => 0.0,
            'net_profit' => 0.0,
        ];

        $companyRevenueByProduct = [
            '500ml' => ['cases' => 0, 'revenue' => 0.0],
            '1000ml' => ['cases' => 0, 'revenue' => 0.0],
            '1500ml' => ['cases' => 0, 'revenue' => 0.0],
            '5000ml' => ['cases' => 0, 'revenue' => 0.0],
        ];

        foreach ($repIds as $repId) {
            $result = $calculator->calculateForMonth((int) $repId, $year, $month);

            $companyTotals['total_sales'] += (float) $result['total_sales'];
            $companyTotals['total_cost'] += (float) $result['total_cost'];
            $companyTotals['gross_profit'] += (float) $result['gross_profit'];
            $companyTotals['commission'] += (float) $result['commission'];
            $companyTotals['bonus'] += (float) $result['bonus'];
            $companyTotals['total_salary'] += (float) $result['total_salary'];
            $companyTotals['net_profit'] += (float) $result['net_profit'];

            foreach (['500ml', '1000ml', '1500ml', '5000ml'] as $size) {
                $companyRevenueByProduct[$size]['cases'] += (int) $result['revenue_by_product'][$size]['cases'];
                $companyRevenueByProduct[$size]['revenue'] += (float) $result['revenue_by_product'][$size]['revenue'];
            }
        }

        $totalSales = (float) $companyTotals['total_sales'];
        $profitMarginPct = $totalSales > 0 ? (($companyTotals['net_profit'] / $totalSales) * 100) : 0.0;

        // Daily sales (company) for the line chart.
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $dailySales = array_fill(1, $daysInMonth, 0.0);

        $dailyRows = SalesRecord::query()
            ->whereBetween('date', [$from, $to])
            ->whereIn('status', ['submitted', 'verified'])
            ->selectRaw('date, SUM(total_sales) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        foreach ($dailyRows as $row) {
            $day = (int) Carbon::parse($row->date)->day;
            $dailySales[$day] = (float) $row->total_sales;
        }

        $tier1Cap = (float) config('salary.tier1_cap');
        $bonusThreshold = (float) config('salary.bonus_threshold');

        $productBreakdown = [];
        $chartLabels = ['500ml', '1L', '1.5L', '5L'];
        $chartValues = [];

        $sizeToChartIndex = [
            '500ml' => 0,
            '1000ml' => 1,
            '1500ml' => 2,
            '5000ml' => 3,
        ];

        foreach (['500ml', '1000ml', '1500ml', '5000ml'] as $size) {
            $cases = (int) $companyRevenueByProduct[$size]['cases'];
            $revenue = (float) $companyRevenueByProduct[$size]['revenue'];

            $caseRow = CasePrice::query()
                ->active()
                ->where('product_size', $size)
                ->orderBy('effective_from', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $bottlesPerCase = $caseRow?->bottles_per_case ?? 24;
            $bottles = $cases * (int) $bottlesPerCase;
            $pct = $totalSales > 0 ? ($revenue / $totalSales) * 100 : 0.0;

            $productBreakdown[] = [
                'size' => $size,
                'cases' => $cases,
                'bottles' => $bottles,
                'revenue' => $revenue,
                'pct' => $pct,
                'label' => match ($size) {
                    '500ml' => '500ml',
                    '1000ml' => '1L',
                    '1500ml' => '1.5L',
                    '5000ml' => '5L',
                    default => $size,
                },
            ];

            $chartValues[$sizeToChartIndex[$size]] = $revenue;
        }

        // Optional exports triggered by query params.
        $exportFormat = $request->query('format');
        if ($exportFormat === 'csv') {
            $csv = "Product,Cases Sold,Bottles,Revenue,Percent\n";
            foreach ($productBreakdown as $row) {
                $csv .= sprintf(
                    "%s,%d,%d,%.2f,%.2f%%\n",
                    $row['label'],
                    $row['cases'],
                    $row['bottles'],
                    $row['revenue'],
                    $row['pct']
                );
            }

            $response = response()->streamDownload(function () use ($csv) {
                echo $csv;
            }, 'sales-company-' . $year . '-' . $month . '.csv', [
                'Content-Type' => 'text/csv',
            ]);

            return $response;
        }

        if ($exportFormat === 'pdf') {
            // Lightweight PDF: company summary only.
            $html = '<h2 style="font-family: DejaVu Sans, Arial, sans-serif;">GLACIAR WATER - Sales & Salary Summary</h2>';
            $html .= '<p style="font-family: DejaVu Sans, Arial, sans-serif;">For: ' . e(Carbon::create($year, $month, 1)->format('F Y')) . '</p>';
            $html .= '<hr/>';
            $html .= '<p style="font-family: DejaVu Sans, Arial, sans-serif;"><b>Total Company Sales:</b> ' . number_format($companyTotals['total_sales'], 2) . '</p>';
            $html .= '<p style="font-family: DejaVu Sans, Arial, sans-serif;"><b>Total Cost (60%):</b> ' . number_format($companyTotals['total_cost'], 2) . '</p>';
            $html .= '<p style="font-family: DejaVu Sans, Arial, sans-serif;"><b>Gross Profit:</b> ' . number_format($companyTotals['gross_profit'], 2) . '</p>';
            $html .= '<p style="font-family: DejaVu Sans, Arial, sans-serif;"><b>Total Salaries Paid:</b> ' . number_format($companyTotals['total_salary'], 2) . '</p>';
            $html .= '<p style="font-family: DejaVu Sans, Arial, sans-serif;"><b>Net Profit:</b> ' . number_format($companyTotals['net_profit'], 2) . '</p>';
            $html .= '<hr/>';
            $html .= '<h3 style="font-family: DejaVu Sans, Arial, sans-serif;">Sales by Product</h3>';
            $html .= '<table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse; width:100%; font-family: DejaVu Sans, Arial, sans-serif;">';
            $html .= '<thead><tr><th>Product</th><th>Cases</th><th>Bottles</th><th>Revenue</th><th>%</th></tr></thead><tbody>';
            foreach ($productBreakdown as $row) {
                $html .= '<tr>'
                    . '<td>' . e($row['label']) . '</td>'
                    . '<td>' . (int) $row['cases'] . '</td>'
                    . '<td>' . (int) $row['bottles'] . '</td>'
                    . '<td>' . number_format($row['revenue'], 2) . '</td>'
                    . '<td>' . number_format($row['pct'], 2) . '%</td>'
                    . '</tr>';
            }
            $html .= '</tbody></table>';

            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
            return $pdf->download('sales-company-' . $year . '-' . $month . '.pdf');
        }

        return view('admin.sales.index', [
            'year' => $year,
            'month' => $month,

            'companyTotals' => $companyTotals,
            'profitMarginPct' => $profitMarginPct,

            'dailySales' => $dailySales,
            'daysInMonth' => $daysInMonth,

            'tier1Cap' => $tier1Cap,
            'bonusThreshold' => $bonusThreshold,

            'productBreakdown' => $productBreakdown,
            'chartLabels' => $chartLabels,
            'chartValues' => array_values($chartValues),
            'companyRevenueByProduct' => $companyRevenueByProduct,
        ]);
    }

    public function salary(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);
        [$from, $to] = $this->monthRange($year, $month);

        $calculator = new SalaryCalculatorService();

        $repIds = SalesRecord::query()
            ->whereBetween('date', [$from, $to])
            ->whereIn('status', ['submitted', 'verified'])
            ->distinct()
            ->pluck('rep_id')
            ->values();

        $tier1Cap = (float) config('salary.tier1_cap');

        $rows = [];
        $companyTotals = [
            'total_sales' => 0.0,
            'total_cost' => 0.0,
            'gross_profit' => 0.0,
            'commission' => 0.0,
            'bonus' => 0.0,
            'total_salary' => 0.0,
            'net_profit' => 0.0,
        ];

        $reps = Rep::query()->whereIn('id', $repIds)->with('zone')->get()->keyBy('id');

        foreach ($repIds as $repId) {
            $rep = $reps->get((int) $repId);
            if (!$rep) {
                continue;
            }

            $result = $calculator->calculateForMonth((int) $repId, $year, $month);
            $sales = (float) $result['total_sales'];

            $tint = 'bg-white';
            if (!empty($result['bonus_earned'])) {
                $tint = 'bg-green-50/60';
            } elseif ($sales >= $tier1Cap) {
                $tint = 'bg-amber-50/60';
            }

            $rows[] = [
                'rep' => $rep,
                'sales' => $result['total_sales'],
                'basic' => $result['basic_salary'],
                'allowance' => $result['allowance'],
                'commission' => $result['commission'],
                'bonus' => $result['bonus'],
                'total_salary' => $result['total_salary'],
                'net_profit' => $result['net_profit'],
                'bonus_earned' => $result['bonus_earned'],
                'tint' => $tint,
                'result' => $result,
            ];

            foreach (['total_sales', 'total_cost', 'gross_profit', 'commission', 'bonus', 'total_salary', 'net_profit'] as $key) {
                $companyTotals[$key] += (float) $result[$key === 'total_sales' ? 'total_sales' : $key];
            }
        }

        // Company totals totals row should match the computed values.
        $companyTotals['total_sales'] = (float) array_sum(array_map(fn ($r) => (float) $r['sales'], $rows));
        $companyTotals['total_cost'] = (float) array_sum(array_map(fn ($r) => (float) $r['result']['total_cost'], $rows));
        $companyTotals['gross_profit'] = (float) array_sum(array_map(fn ($r) => (float) $r['result']['gross_profit'], $rows));
        $companyTotals['commission'] = (float) array_sum(array_map(fn ($r) => (float) $r['commission'], $rows));
        $companyTotals['bonus'] = (float) array_sum(array_map(fn ($r) => (float) $r['bonus'], $rows));
        $companyTotals['total_salary'] = (float) array_sum(array_map(fn ($r) => (float) $r['total_salary'], $rows));
        $companyTotals['net_profit'] = (float) array_sum(array_map(fn ($r) => (float) $r['net_profit'], $rows));

        return view('admin.sales.salary', [
            'year' => $year,
            'month' => $month,
            'rows' => $rows,
            'companyTotals' => $companyTotals,
        ]);
    }

    public function repDetail(Request $request, int $repId)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);
        [$from, $to] = $this->monthRange($year, $month);

        $rep = Rep::query()->with('zone')->findOrFail($repId);
        $calculator = new SalaryCalculatorService();

        $monthly = $calculator->calculateForMonth($repId, $year, $month);

        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $dailySales = array_fill(1, $daysInMonth, 0.0);

        $dailyRows = SalesRecord::query()
            ->where('rep_id', $repId)
            ->whereBetween('date', [$from, $to])
            ->whereIn('status', ['submitted', 'verified'])
            ->selectRaw('date, SUM(total_sales) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        foreach ($dailyRows as $row) {
            $day = (int) Carbon::parse($row->date)->day;
            $dailySales[$day] = (float) $row->total_sales;
        }

        $records = SalesRecord::query()
            ->where('rep_id', $repId)
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.sales.rep-detail', [
            'year' => $year,
            'month' => $month,
            'rep' => $rep,
            'monthly' => $monthly,
            'dailySales' => $dailySales,
            'daysInMonth' => $daysInMonth,
            'tier1Cap' => (float) config('salary.tier1_cap'),
            'bonusThreshold' => (float) config('salary.bonus_threshold'),
            'records' => $records,
        ]);
    }

    public function verify(Request $request, SalesRecord $sale)
    {
        if ($sale->status !== 'submitted') {
            return back()->with('status', 'This record is not pending verification.');
        }

        $sale->update([
            'status' => 'verified',
            'verified_at' => Carbon::now(),
            'verified_by' => $this->currentAdminId(),
        ]);

        return back()->with('status', 'Sales record verified.');
    }

    public function verifyRepMonth(Request $request, int $repId)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);
        [$from, $to] = $this->monthRange($year, $month);

        SalesRecord::query()
            ->where('rep_id', $repId)
            ->whereBetween('date', [$from, $to])
            ->where('status', 'submitted')
            ->update([
                'status' => 'verified',
                'verified_at' => Carbon::now(),
                'verified_by' => $this->currentAdminId(),
            ]);

        return back()->with('status', 'Rep month verified.');
    }

    public function repSalaryPdf(Request $request, int $repId)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        $rep = Rep::query()->with('zone')->findOrFail($repId);
        $calculator = new SalaryCalculatorService();
        $monthly = $calculator->calculateForMonth($repId, $year, $month);

        $pdf = Pdf::loadView('admin.sales.pdf-statement', [
            'rep' => $rep,
            'year' => $year,
            'month' => $month,
            'monthly' => $monthly,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('salary-statement-rep-' . $repId . '-' . $year . '-' . $month . '.pdf');
    }
}

