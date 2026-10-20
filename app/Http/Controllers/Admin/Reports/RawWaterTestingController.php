<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreRawWaterTestRequest;
use App\Models\Reports\RawWaterTest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RawWaterTestingController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = RawWaterTest::query();

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
                  ->orWhere('checked_by', 'like', "%{$search}%");
            });
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'desc')->orderBy('test_time', 'desc')->paginate(15)->withQueryString();
        
        $stats = [
            'avgTds' => RawWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->avg('tds'),
            'avgPh' => RawWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->avg('ph'),
            'abnormalTaste' => RawWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->get()->filter(fn($r) => $r->taste === 'Abnormal')->count(),
            'abnormalOdor' => RawWaterTest::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->get()->filter(fn($r) => $r->odor === 'Abnormal')->count(),
        ];

        $lastEntry = RawWaterTest::orderBy('date', 'desc')->first();
        $thisMonth = RawWaterTest::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.raw-water-testing.index', compact('records', 'stats', 'lastEntry', 'thisMonth'));
    }

    public function store(StoreRawWaterTestRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;
        RawWaterTest::create($data);
        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id) { return response()->json(RawWaterTest::findOrFail($id)); }

    public function update(StoreRawWaterTestRequest $request, $id)
    {
        RawWaterTest::findOrFail($id)->update($request->validated());
        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        RawWaterTest::findOrFail($id)->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->orderBy('test_time', 'asc')->get();
        
        $pdf = Pdf::loadView('admin.reports.raw-water-testing.pdf', [
            'records' => $records, 'year' => $request->year ?? now()->year, 'month' => $request->month ?? now()->month,
            'monthLabel' => \Carbon\Carbon::create($request->year ?? now()->year, $request->month ?? now()->month)->format('F Y'),
        ]);
        return $pdf->download("raw-water-testing-export.pdf");
    }

    public function exportCsv(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->orderBy('test_time', 'asc')->get();

        $csv = "Date,Time,TDS,pH,Taste,Odor,Appearance,Result,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->test_time},{$r->tds},{$r->ph},{$r->taste},{$r->odor},{$r->appearance},{$r->result},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=raw-water-testing-export.csv"]);
    }
}