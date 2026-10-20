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

        $locationsData = $latestLocations->map(function ($loc) {
            return [
                'rep_id' => $loc->rep_id,
                'name' => $loc->rep?->name ?? ('Rep #' . $loc->rep_id),
                'zone' => $loc->rep?->zone?->name ?? 'Unassigned',
                'lat' => (float) $loc->lat,
                'lng' => (float) $loc->lng,
                'recorded_at' => optional($loc->recorded_at)->toDateTimeString() ?? 'Recently',
            ];
        })->values();

        return view('admin.map', [
            'latestLocations' => $latestLocations,
            'locationsData' => $locationsData,
        ]);
    }
}

