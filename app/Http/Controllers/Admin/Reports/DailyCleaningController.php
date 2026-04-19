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
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = DailyCleaningRecord::forMonth($year, $month)->orderBy('date', 'desc')->get();
        
        $stats = [
            'total' => $records->count(),
            'complete' => $records->filter(fn($r) => $r->overall_status === 'Complete')->count(),
            'incomplete' => $records->filter(fn($r) => str_contains($r->overall_status, 'Incomplete'))->count(),
        ];

        $lastEntry = DailyCleaningRecord::orderBy('date', 'desc')->first();
        $thisMonth = DailyCleaningRecord::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.daily-cleaning.index', compact('records', 'stats', 'year', 'month', 'lastEntry', 'thisMonth'));
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
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $records = DailyCleaningRecord::forMonth($year, $month)->orderBy('date', 'asc')->get();
        
        $pdf = Pdf::loadView('admin.reports.daily-cleaning.pdf', [
            'records' => $records, 'year' => $year, 'month' => $month,
            'monthLabel' => \Carbon\Carbon::create($year, $month)->format('F Y'),
        ]);
        return $pdf->download("daily-cleaning-{$month}-{$year}.pdf");
    }

    public function exportCsv(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $records = DailyCleaningRecord::forMonth($year, $month)->orderBy('date', 'asc')->get();

        $csv = "Date,Shift,Status,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->shift},{$r->overall_status},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=daily-cleaning-{$month}-{$year}.csv"]);
    }
}