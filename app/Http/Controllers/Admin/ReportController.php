<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Rep;
use App\Models\SalesRecord;
use App\Models\Reports\PestControlRecord;
use App\Models\Reports\TrainingAttendance;
use App\Models\Reports\TankCleaningRecord;
use App\Models\Reports\RawWaterTest;
use App\Models\Reports\RawMaterialInspection;
use App\Models\Reports\TreatedWaterTest;
use App\Models\Reports\DailyCleaningRecord;
use App\Models\Reports\UvBulbRecord;
use App\Services\SalaryCalculatorService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $year = (int) $request->query('year', $today->year);
        $month = (int) $request->query('month', $today->month);
        $start = Carbon::create($year, $month, 1)->startOfDay()->toDateString();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();

        $calculator = new SalaryCalculatorService();

        $repIds = SalesRecord::query()
            ->whereBetween('date', [$start, $end])
            ->whereIn('status', ['submitted', 'verified'])
            ->distinct()
            ->pluck('rep_id')
            ->values();

        if ($repIds->isEmpty()) {
            $repIds = Rep::query()->pluck('id')->take(5);
        }

        $reps = Rep::query()->with('zone')->whereIn('id', $repIds)->get()->keyBy('id');

        $salaryRows = [];
        foreach ($reps as $rep) {
            $m = $calculator->calculateForMonth((int) $rep->id, $year, $month);
            $salaryRows[] = [
                'rep' => $rep,
                'result' => $m,
            ];
        }

        $salaryTotals = [
            'basic' => 0.0,
            'allowance' => 0.0,
            'commission' => 0.0,
            'bonus' => 0.0,
            'total_salary' => 0.0,
            'net_profit' => 0.0,
        ];

        foreach ($salaryRows as $row) {
            $salaryTotals['basic'] += (float) ($row['result']['basic_salary'] ?? 0);
            $salaryTotals['allowance'] += (float) ($row['result']['allowance'] ?? 0);
            $salaryTotals['commission'] += (float) ($row['result']['commission'] ?? 0);
            $salaryTotals['bonus'] += (float) ($row['result']['bonus'] ?? 0);
            $salaryTotals['total_salary'] += (float) ($row['result']['total_salary'] ?? 0);
            $salaryTotals['net_profit'] += (float) ($row['result']['net_profit'] ?? 0);
        }

        $salesVsTargetRows = [];
        foreach ($salaryRows as $row) {
            $rep = $row['rep'];
            $m = $row['result'];
            $target = (float) ($rep->monthly_target ?? config('salary.bonus_threshold'));
            $actual = (float) ($m['total_sales'] ?? 0);
            $variance = $actual - $target;
            $pct = $target > 0 ? ($actual / $target) * 100 : 0.0;

            $salesVsTargetRows[] = [
                'rep' => $rep,
                'target' => $target,
                'actual' => $actual,
                'variance' => $variance,
                'pct_achieved' => $pct,
                'bonus_earned' => !empty($m['bonus_earned']),
            ];
        }

        // Commission Analysis: aggregate tier1 vs tier2.
        $commissionAnalysisRows = [];
        $tier1CommissionTotal = 0.0;
        $tier2CommissionTotal = 0.0;
        foreach ($salaryRows as $row) {
            $rep = $row['rep'];
            $m = $row['result'];
            $cb = $m['commission_breakdown'] ?? [];
            $tier1Sales = (float) ($cb['tier1_sales'] ?? 0);
            $tier2Sales = (float) ($cb['tier2_sales'] ?? 0);
            $tier1Comm = (float) ($cb['tier1_commission'] ?? 0);
            $tier2Comm = (float) ($cb['tier2_commission'] ?? 0);
            $totalComm = (float) ($m['commission'] ?? 0);

            $commissionAnalysisRows[] = [
                'rep' => $rep,
                'tier1_sales' => $tier1Sales,
                'tier1_comm' => $tier1Comm,
                'tier2_sales' => $tier2Sales,
                'tier2_comm' => $tier2Comm,
                'total_comm' => $totalComm,
            ];

            $tier1CommissionTotal += $tier1Comm;
            $tier2CommissionTotal += $tier2Comm;
        }

        $repNames = array_map(fn ($r) => $r['rep']->name, $salesVsTargetRows);
        $barActual = array_map(fn ($r) => $r['actual'], $salesVsTargetRows);
        $barTarget = array_map(fn ($r) => $r['target'], $salesVsTargetRows);

        $commissionPie = [
            'labels' => ['Tier 1', 'Tier 2'],
            'values' => [$tier1CommissionTotal, $tier2CommissionTotal],
        ];

        $stats = [
            'today_orders' => Order::whereDate('created_at', $today)->count(),
            'today_revenue' => (float) Order::whereDate('created_at', $today)
                ->where('status', '!=', 'cancelled')
                ->sum('total'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'open_complaints' => Complaint::where('status', '!=', 'resolved')->count(),
            'customers' => Customer::count(),
            'reps' => Rep::count(),
            'products' => Product::count(),
        ];

        return view('admin.reports.index', [
            'stats' => $stats,

            'year' => $year,
            'month' => $month,
            'monthLabel' => Carbon::create($year, $month, 1)->format('F Y'),

            'salaryRows' => $salaryRows,
            'salaryTotals' => $salaryTotals,

            'salesVsTargetRows' => $salesVsTargetRows,
            'commissionAnalysisRows' => $commissionAnalysisRows,
            'commissionPie' => $commissionPie,

            'repNames' => $repNames,
            'barActual' => $barActual,
            'barTarget' => $barTarget,

            // Quality & Compliance Reports Stats
            'qualityStats' => $this->getQualityStats(),
        ]);
    }

    private function getQualityStats(): array
    {
        $today = Carbon::today();
        
        $reports = [
            'pest_control' => ['model' => PestControlRecord::class, 'date_col' => 'date'],
            'training' => ['model' => TrainingAttendance::class, 'date_col' => 'session_date'],
            'tank_cleaning' => ['model' => TankCleaningRecord::class, 'date_col' => 'date'],
            'raw_water' => ['model' => RawWaterTest::class, 'date_col' => 'date'],
            'material_inspection' => ['model' => RawMaterialInspection::class, 'date_col' => 'date'],
            'treated_water' => ['model' => TreatedWaterTest::class, 'date_col' => 'date'],
            'daily_cleaning' => ['model' => DailyCleaningRecord::class, 'date_col' => 'date'],
            'uv_bulb' => ['model' => UvBulbRecord::class, 'date_col' => 'date'],
        ];

        $submittedToday = 0;
        $todayEntries = [];
        $lastEntries = [];
        $thisMonthCounts = [];
        $missingReports = [];

        foreach ($reports as $key => $config) {
            $model = $config['model'];
            $dateCol = $config['date_col'];
            
            // Today's entry
            $todayEntry = $model::whereDate($dateCol, $today)->first();
            if ($todayEntry) {
                $submittedToday++;
                $todayEntries[$key] = true;
            } else {
                $todayEntries[$key] = false;
                
                // Check if there's any entry this month
                $thisMonthCount = $model::forMonth(now()->year, now()->month)->count();
                if ($thisMonthCount === 0) {
                    $missingReports[] = ucwords(str_replace('_', ' ', $key));
                }
            }

            // Last entry
            $lastEntry = $model::orderBy($dateCol, 'desc')->first();
            $lastEntries[$key] = $lastEntry ? $lastEntry->$dateCol : null;

            // This month count
            $thisMonthCounts[$key] = $model::forMonth(now()->year, now()->month)->count();
        }

        return [
            'submitted_today' => $submittedToday,
            'today_entries' => $todayEntries,
            'last_entries' => $lastEntries,
            'this_month_counts' => $thisMonthCounts,
            'missing_reports' => $missingReports,
        ];
    }
}

