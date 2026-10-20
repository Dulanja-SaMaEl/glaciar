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
    private function buildQuery(Request $request)
    {
        $query = TankCleaningRecord::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month') && $request->filled('year')) {
            $query->forMonth($request->year, $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tank_number', 'like', "%{$search}%")
                  ->orWhere('cleaned', 'like', "%{$search}%")
                  ->orWhere('checked_by', 'like', "%{$search}%");
            });
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'desc')->paginate(15)->withQueryString();
        $lastEntry = TankCleaningRecord::orderBy('date', 'desc')->first();
        $thisMonth = TankCleaningRecord::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.tank-cleaning.index', compact('records', 'lastEntry', 'thisMonth'));
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
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();
        $stats = ['total' => $records->count(), 'notCleaned' => $records->filter(fn($r) => $r->cleaned === 'No')->count()];

        $pdf = Pdf::loadView('admin.reports.tank-cleaning.pdf', [
            'records' => $records, 'stats' => $stats, 'year' => $request->year ?? now()->year, 'month' => $request->month ?? now()->month,
            'monthLabel' => \Carbon\Carbon::create($request->year ?? now()->year, $request->month ?? now()->month)->format('F Y'),
        ]);
        return $pdf->download("tank-cleaning-export.pdf");
    }

    public function exportCsv(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();

        $csv = "Date,Tank No.,Frequency,Cleaned,Method,Chemical,Comments,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->tank_number},{$r->frequency},{$r->cleaned},{$r->cleaning_method},{$r->chemical_used},\"{$r->comments}\",{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=tank-cleaning-export.csv"]);
    }
}