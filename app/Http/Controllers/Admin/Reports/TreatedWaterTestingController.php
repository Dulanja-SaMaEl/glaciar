<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreTreatedWaterTestRequest;
use App\Models\Reports\TreatedWaterTest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TreatedWaterTestingController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = TreatedWaterTest::forMonth($year, $month)->orderBy('date', 'desc')->orderBy('test_time', 'desc')->get();
        
        $stats = [
            'avgTds' => $records->avg('tds'),
            'avgPh' => $records->avg('ph'),
            'abnormalTaste' => $records->filter(fn($r) => $r->taste === 'Abnormal')->count(),
            'abnormalOdor' => $records->filter(fn($r) => $r->odor === 'Abnormal')->count(),
        ];

        $lastEntry = TreatedWaterTest::orderBy('date', 'desc')->first();
        $thisMonth = TreatedWaterTest::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.treated-water-testing.index', compact('records', 'stats', 'year', 'month', 'lastEntry', 'thisMonth'));
    }

    public function store(StoreTreatedWaterTestRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;
        TreatedWaterTest::create($data);
        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id) { return response()->json(TreatedWaterTest::findOrFail($id)); }

    public function update(StoreTreatedWaterTestRequest $request, $id)
    {
        TreatedWaterTest::findOrFail($id)->update($request->validated());
        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        TreatedWaterTest::findOrFail($id)->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $records = TreatedWaterTest::forMonth($year, $month)->orderBy('date', 'asc')->orderBy('test_time', 'asc')->get();
        
        $pdf = Pdf::loadView('admin.reports.treated-water-testing.pdf', [
            'records' => $records, 'year' => $year, 'month' => $month,
            'monthLabel' => \Carbon\Carbon::create($year, $month)->format('F Y'),
        ]);
        return $pdf->download("treated-water-testing-{$month}-{$year}.pdf");
    }

    public function exportCsv(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $records = TreatedWaterTest::forMonth($year, $month)->orderBy('date', 'asc')->get();

        $csv = "Date,Time,TDS,pH,Taste,Odor,Appearance,Foreign Impurities,Sealing,Result,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->test_time},{$r->tds},{$r->ph},{$r->taste},{$r->odor},{$r->appearance},{$r->foreign_impurities},{$r->sealing_quality},{$r->result},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=treated-water-testing-{$month}-{$year}.csv"]);
    }
}