<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepLocation;
use Illuminate\Support\Facades\DB;

class LiveMapController extends Controller
{
    public function index()
    {
        // Latest location per rep (simple + DB portable enough for MySQL).
        $latestLocations = RepLocation::query()
            ->select('rep_locations.*')
            ->join(DB::raw('(select rep_id, max(recorded_at) as max_recorded_at from rep_locations group by rep_id) as latest'), function ($join) {
                $join->on('rep_locations.rep_id', '=', 'latest.rep_id')
                    ->on('rep_locations.recorded_at', '=', 'latest.max_recorded_at');
            })
            ->with(['rep.zone'])
            ->get();

        return view('admin.map', [
            'latestLocations' => $latestLocations,
        ]);
    }
}

