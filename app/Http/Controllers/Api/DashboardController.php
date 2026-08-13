<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $user = $request->user();
        $rep_id = $user->rep->id;

        // Today's delivery stats
        $today = Carbon::today();

        $totalAssigned = Delivery::where('rep_id', $rep_id)
            ->whereDate('created_at', $today)
            ->count();

        $completed = Delivery::where('rep_id', $rep_id)
            ->whereDate('created_at', $today)
            ->where('status', 'delivered')
            ->count();

        $pending = Delivery::where('rep_id', $rep_id)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['pending'])
            ->count();
            
        // Calculate current month's salary, revenue and profit
        $calculator = new \App\Services\SalaryCalculatorService();
        $salaryData = $calculator->calculateForMonth((int) $rep_id, $today->year, $today->month);

        return response()->json([
            'success' => true,
            'data' => [
                'deliveries' => [
                    'total_assigned' => $totalAssigned,
                    'completed' => $completed,
                    'pending' => $pending,
                    'progress_percentage' => $totalAssigned > 0 ? round(($completed / $totalAssigned) * 100) : 0,
                ],
                'performance' => [
                    'monthly_revenue' => $salaryData['total_sales'],
                    'estimated_salary' => $salaryData['total_salary'],
                    'net_profit' => $salaryData['net_profit'],
                    'target_status' => $salaryData['bonus_earned'],
                    'commission_earned' => $salaryData['commission'],
                ]
            ]
        ]);
    }

    public function routeToday(Request $request)
    {
        $user = $request->user();
        $rep_id = $user->rep->id;

        $deliveries = Delivery::with(['order.customer', 'order.items.product'])
            ->where('rep_id', $rep_id)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('id', 'asc') // Could be reordered based on routing algorithm
            ->get()
            ->map(function ($delivery, $index) {
                // Calculate bottles
                $bottles = 0;
                if ($delivery->order) {
                    foreach ($delivery->order->items as $item) {
                        if ($item->product && str_contains(strtolower($item->product->name), 'bottle')) {
                            $bottles += $item->quantity;
                        } else if (!$item->product) {
                            $bottles += $item->quantity;
                        }
                    }
                }
                
                return [
                    'stop_number' => $index + 1,
                    'customer_name' => $delivery->order->customer->name ?? 'Unknown',
                    'address' => $delivery->order->customer->address ?? '',
                    'status' => $delivery->status,
                    'distance' => '0 km', // Placeholder, calculate if needed
                    'bottles' => $bottles > 0 ? $bottles : $delivery->bottles_delivered ?? 0,
                    'time_window' => 'Anytime'
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $deliveries
        ]);
    }
}
