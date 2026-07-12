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
    private function buildQuery(Request $request)
    {
        $query = TreatedWaterTest::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month') && $request->filled('year')) {
            $query->forMonth($request->year, $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('taste', 'like', "%{$search}%")
                  ->orWhere('odor', 'like', "%{$search}%")
                  ->orWhere('appearance', 'like', "%{$search}%")
                  ->orWhere('foreign_impurities', 'like', "%{$search}%")
                  ->orWhere('sealing_quality', 'like', "%{$search}%")
                  ->orWhere('checked_by', 'like', "%{$search}%");
            });
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'desc')->orderBy('test_time', 'desc')->paginate(15)->withQueryString();
        
        $stats = [
            'avgTds' => TreatedWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->avg('tds'),
            'avgPh' => TreatedWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->avg('ph'),
            'abnormalTaste' => TreatedWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->get()->filter(fn($r) => $r->taste === 'Abnormal')->count(),
            'abnormalOdor' => TreatedWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->get()->filter(fn($r) => $r->odor === 'Abnormal')->count(),
        ];

        $lastEntry = TreatedWaterTest::orderBy('date', 'desc')->first();
        $thisMonth = TreatedWaterTest::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.treated-water-testing.index', compact('records', 'stats', 'lastEntry', 'thisMonth'));
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
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->orderBy('test_time', 'asc')->get();
        
        $pdf = Pdf::loadView('admin.reports.treated-water-testing.pdf', [
            'records' => $records, 'year' => $request->year ?? now()->year, 'month' => $request->month ?? now()->month,
            'monthLabel' => \Carbon\Carbon::create($request->year ?? now()->year, $request->month ?? now()->month)->format('F Y'),
        ]);
        return $pdf->download("treated-water-testing-export.pdf");
    }

    public function exportCsv(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->orderBy('test_time', 'asc')->get();

        $csv = "Date,Time,TDS,pH,Taste,Odor,Appearance,Foreign Impurities,Sealing,Result,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->test_time},{$r->tds},{$r->ph},{$r->taste},{$r->odor},{$r->appearance},{$r->foreign_impurities},{$r->sealing_quality},{$r->result},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=treated-water-testing-export.csv"]);
    }
}