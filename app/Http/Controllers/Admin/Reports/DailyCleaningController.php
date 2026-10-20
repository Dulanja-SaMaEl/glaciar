<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreDailyCleaningRequest;
use App\Models\Reports\DailyCleaningRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DailyCleaningController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = DailyCleaningRecord::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month') && $request->filled('year')) {
            $query->forMonth($request->year, $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('shift', 'like', "%{$search}%")
                  ->orWhere('overall_status', 'like', "%{$search}%")
                  ->orWhere('checked_by', 'like', "%{$search}%");
            });
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'desc')->paginate(15)->withQueryString();
        
        $stats = [
            'total' => DailyCleaningRecord::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'complete' => DailyCleaningRecord::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->get()->filter(fn($r) => $r->overall_status === 'Complete')->count(),
            'incomplete' => DailyCleaningRecord::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->get()->filter(fn($r) => str_contains($r->overall_status, 'Incomplete'))->count(),
        ];

        $lastEntry = DailyCleaningRecord::orderBy('date', 'desc')->first();
        $thisMonth = DailyCleaningRecord::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.daily-cleaning.index', compact('records', 'stats', 'lastEntry', 'thisMonth'));
    }

    public function store(StoreDailyCleaningRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;
        DailyCleaningRecord::create($data);
        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id) { return response()->json(DailyCleaningRecord::findOrFail($id)); }

    public function update(StoreDailyCleaningRequest $request, $id)
    {
        DailyCleaningRecord::findOrFail($id)->update($request->validated());
        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        DailyCleaningRecord::findOrFail($id)->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();
        
        $pdf = Pdf::loadView('admin.reports.daily-cleaning.pdf', [
            'records' => $records, 'year' => $request->year ?? now()->year, 'month' => $request->month ?? now()->month,
            'monthLabel' => \Carbon\Carbon::create($request->year ?? now()->year, $request->month ?? now()->month)->format('F Y'),
        ]);
        return $pdf->download("daily-cleaning-export.pdf");
    }

    public function exportCsv(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();

        $csv = "Date,Shift,Status,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->shift},{$r->overall_status},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=daily-cleaning-export.csv"]);
    }
}