<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreUvBulbRequest;
use App\Models\Reports\UvBulbRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UvBulbMonitoringController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = UvBulbRecord::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month') && $request->filled('year')) {
            $query->forMonth($request->year, $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('bulb_id', 'like', "%{$search}%")
                  ->orWhere('bulb_location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('checked_by', 'like', "%{$search}%");
            });
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'desc')->paginate(15)->withQueryString();
        $bulbSummary = UvBulbRecord::allBulbsSummary();

        $lastEntry = UvBulbRecord::orderBy('date', 'desc')->first();
        $thisMonth = UvBulbRecord::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.uv-bulb-monitoring.index', compact('records', 'bulbSummary', 'lastEntry', 'thisMonth'));
    }

    public function store(StoreUvBulbRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;
        
        $start = strtotime($data['start_time']);
        $finish = strtotime($data['finish_time']);
        $data['running_hours'] = round(($finish - $start) / 3600, 2);
        
        $latest = UvBulbRecord::latestForBulb($data['bulb_id']);
        $prevCumulative = $latest ? $latest->cumulative_hours : 0;
        $data['cumulative_hours'] = $prevCumulative + $data['running_hours'];
        $data['max_life_hours'] = 9000;
        $data['remaining_hours'] = $data['max_life_hours'] - $data['cumulative_hours'];
        $data['remaining_percentage'] = round(($data['remaining_hours'] / $data['max_life_hours']) * 100, 2);
        
        $remainingPct = $data['remaining_percentage'];
        if ($remainingPct > 20) {
            $data['status'] = 'Good';
        } elseif ($remainingPct >= 5) {
            $data['status'] = 'Replace Soon';
        } else {
            $data['status'] = 'Replace Now';
        }

        UvBulbRecord::create($data);
        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id) { return response()->json(UvBulbRecord::findOrFail($id)); }

    public function update(StoreUvBulbRequest $request, $id)
    {
        $record = UvBulbRecord::findOrFail($id);
        $data = $request->validated();
        
        $start = strtotime($data['start_time']);
        $finish = strtotime($data['finish_time']);
        $data['running_hours'] = round(($finish - $start) / 3600, 2);
        
        $latest = UvBulbRecord::latestForBulb($data['bulb_id']);
        $prevCumulative = ($latest && $latest->id !== $record->id) ? $latest->cumulative_hours : $record->cumulative_hours;
        $data['cumulative_hours'] = $prevCumulative + $data['running_hours'];
        $data['max_life_hours'] = 9000;
        $data['remaining_hours'] = $data['max_life_hours'] - $data['cumulative_hours'];
        $data['remaining_percentage'] = round(($data['remaining_hours'] / $data['max_life_hours']) * 100, 2);
        
        $remainingPct = $data['remaining_percentage'];
        if ($remainingPct > 20) {
            $data['status'] = 'Good';
        } elseif ($remainingPct >= 5) {
            $data['status'] = 'Replace Soon';
        } else {
            $data['status'] = 'Replace Now';
        }

        $record->update($data);
        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        UvBulbRecord::findOrFail($id)->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();
        $bulbSummary = UvBulbRecord::allBulbsSummary();
        
        $pdf = Pdf::loadView('admin.reports.uv-bulb-monitoring.pdf', [
            'records' => $records, 'bulbSummary' => $bulbSummary, 'year' => $request->year ?? now()->year, 'month' => $request->month ?? now()->month,
            'monthLabel' => \Carbon\Carbon::create($request->year ?? now()->year, $request->month ?? now()->month)->format('F Y'),
        ]);
        return $pdf->download("uv-bulb-monitoring-export.pdf");
    }

    public function exportCsv(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();

        $csv = "Date,Bulb ID,Location,Start,Finish,Hours Run,Cumulative,Remaining %,Status,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->bulb_id},{$r->bulb_location},{$r->start_time},{$r->finish_time},{$r->running_hours},{$r->cumulative_hours},{$r->remaining_percentage},{$r->status},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=uv-bulb-export.csv"]);
    }
}