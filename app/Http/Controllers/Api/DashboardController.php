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

        // Today's stats
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

        return response()->json([
            'success' => true,
            'data' => [
                'total_assigned' => $totalAssigned,
                'completed' => $completed,
                'pending' => $pending,
                'progress_percentage' => $totalAssigned > 0 ? round(($completed / $totalAssigned) * 100) : 0,
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
            ->get();

        return response()->json([
            'success' => true,
            'data' => $deliveries
        ]);
    }
}
