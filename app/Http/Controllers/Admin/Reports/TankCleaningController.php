<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreTankCleaningRequest;
use App\Models\Reports\TankCleaningRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TankCleaningController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = TankCleaningRecord::forMonth($year, $month)
            ->orderBy('date', 'desc')
            ->get();

        $lastEntry = TankCleaningRecord::orderBy('date', 'desc')->first();
        $thisMonth = TankCleaningRecord::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.tank-cleaning.index', compact('records', 'year', 'month', 'lastEntry', 'thisMonth'));
    }

    public function store(StoreTankCleaningRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;
        TankCleaningRecord::create($data);
        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id)
    {
        $record = TankCleaningRecord::findOrFail($id);
        return response()->json($record);
    }

    public function update(StoreTankCleaningRequest $request, $id)
    {
        $record = TankCleaningRecord::findOrFail($id);
        $record->update($request->validated());
        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        $record = TankCleaningRecord::findOrFail($id);
        $record->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = TankCleaningRecord::forMonth($year, $month)->orderBy('date', 'asc')->get();
        $stats = ['total' => $records->count(), 'notCleaned' => $records->filter(fn($r) => $r->cleaned === 'No')->count()];

        $pdf = Pdf::loadView('admin.reports.tank-cleaning.pdf', [
            'records' => $records, 'stats' => $stats, 'year' => $year, 'month' => $month,
            'monthLabel' => \Carbon\Carbon::create($year, $month)->format('F Y'),
        ]);
        return $pdf->download("tank-cleaning-{$month}-{$year}.pdf");
    }

    public function exportCsv(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $records = TankCleaningRecord::forMonth($year, $month)->orderBy('date', 'asc')->get();

        $csv = "Date,Tank No.,Frequency,Cleaned,Method,Chemical,Comments,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->tank_number},{$r->frequency},{$r->cleaned},{$r->cleaning_method},{$r->chemical_used},\"{$r->comments}\",{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=tank-cleaning-{$month}-{$year}.csv"]);
    }
}