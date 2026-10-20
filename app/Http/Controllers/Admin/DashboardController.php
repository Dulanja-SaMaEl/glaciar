<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Rep;
use App\Models\SalesRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\SalaryCalculatorService;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Existing order metrics (kept for the "Recent Orders" panel).
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $todayOrders = Order::whereDate('created_at', $today)->count();

        $activeDeliveries = Delivery::whereIn('status', ['pending', 'in_progress'])
            ->count();

        $openComplaints = Complaint::where('status', '!=', 'resolved')
            ->count();

        // =========================
        // Sales & Salary KPIs
        // =========================
        $year = $today->year;
        $month = $today->month;

        $service = new SalaryCalculatorService();
        $repIds = Rep::query()->pluck('id')->values();
        $totalReps = $repIds->count();

        $monthlyByRep = [];
        foreach ($repIds as $repId) {
            $monthlyByRep[$repId] = $service->calculateForMonth((int) $repId, $year, $month);
        }

        $netProfitThisMonth = array_sum(array_map(fn ($r) => (float) ($r['net_profit'] ?? 0), $monthlyByRep));
        $totalSalariesThisMonth = array_sum(array_map(fn ($r) => (float) ($r['total_salary'] ?? 0), $monthlyByRep));
        $totalCompanySalesThisMonth = array_sum(array_map(fn ($r) => (float) ($r['total_sales'] ?? 0), $monthlyByRep));

        $repsHitBonusTarget = count(array_filter(
            $monthlyByRep,
            fn ($r) => !empty($r['bonus_earned']) && (float) ($r['total_sales'] ?? 0) >= (float) config('salary.bonus_threshold')
        ));

        $activeReps = collect([]); // Keep existing blade demo "Live Rep Status" fallback

        // Leaderboard: Top 5 reps by monthly sales.
        $leaderboard = Rep::query()
            ->with('zone')
            ->whereIn('id', array_keys($monthlyByRep))
            ->get()
            ->map(function (Rep $rep) use ($monthlyByRep) {
                $m = $monthlyByRep[$rep->id] ?? [];
                $sales = (float) ($m['total_sales'] ?? 0);
                $progress = !empty($m['sales_vs_target_pct']) ? (float) $m['sales_vs_target_pct'] : 0.0;

                return [
                    'rep' => $rep,
                    'sales' => $sales,
                    'progress_pct' => min(100.0, max(0.0, $progress)),
                    'bonus_earned' => !empty($m['bonus_earned']),
                ];
            })
            ->sortByDesc('sales')
            ->values()
            ->take(5);

        // Today's submissions panel: show all reps (submitted today vs pending).
        $todayRecords = SalesRecord::query()
            ->whereDate('date', $today)
            ->whereIn('status', ['submitted', 'verified'])
            ->get()
            ->keyBy('rep_id');

        $todaySubmissions = Rep::query()
            ->with('zone')
            ->orderBy('id')
            ->get()
            ->map(function (Rep $rep) use ($todayRecords) {
                $sale = $todayRecords->get($rep->id);
                return [
                    'rep' => $rep,
                    'total_sales' => $sale ? (float) $sale->total_sales : 0.0,
                    'status' => $sale ? $sale->status : 'pending',
                    'submitted_time' => $sale?->submitted_at?->format('H:i') ?? null,
                ];
            });

        // 30-day daily sales chart (company total).
        $chartStart = (clone $today)->subDays(29)->startOfDay();
        $chartEnd = (clone $today)->endOfDay();

        $dailyMap = SalesRecord::query()
            ->whereBetween('date', [$chartStart->toDateString(), $chartEnd->toDateString()])
            ->whereIn('status', ['submitted', 'verified'])
            ->selectRaw('date, SUM(total_sales) as total_sales')
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartValues = [];
        for ($d = $chartStart->copy(); $d->lte($chartEnd); $d->addDay()) {
            $key = $d->toDateString();
            $chartLabels[] = $d->format('M d');
            $chartValues[] = (float) ($dailyMap[$key]->total_sales ?? 0);
        }

        // Recent Orders
        $recentOrders = Order::with(['customer', 'rep'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Recent Complaints
        $recentComplaints = Complaint::with(['customer', 'rep', 'assignee'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Today's Attendance Stats
        $todayAttendanceStats = [
            'total' => \App\Models\Attendance::whereDate('date', $today)->count(),
            'present' => \App\Models\Attendance::whereDate('date', $today)->where('status', 'Present')->count(),
            'late' => \App\Models\Attendance::whereDate('date', $today)->where('status', 'Late')->count(),
            'absent' => \App\Models\Attendance::whereDate('date', $today)->whereIn('status', ['Absent', 'Leave'])->count(),
        ];

        return view('admin.dashboard', compact(
            'todayRevenue',
            'todayOrders',
            'activeDeliveries',
            'openComplaints',
            'activeReps',
            'recentOrders',
            'recentComplaints',
            'todayAttendanceStats',

            // Sales KPIs
            'year',
            'month',
            'netProfitThisMonth',
            'totalSalariesThisMonth',
            'totalReps',
            'repsHitBonusTarget',
            'totalCompanySalesThisMonth',

            // Dashboard panels
            'leaderboard',
            'todaySubmissions',

            // Chart
            'chartLabels',
            'chartValues'
        ));
    }
}
