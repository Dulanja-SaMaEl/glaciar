<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreRawMaterialInspectionRequest;
use App\Models\Reports\RawMaterialInspection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RawMaterialInspectionController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = RawMaterialInspection::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month') && $request->filled('year')) {
            $query->forMonth($request->year, $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('supplier', 'like', "%{$search}%")
                  ->orWhere('material_type', 'like', "%{$search}%")
                  ->orWhere('checked_by', 'like', "%{$search}%");
            });
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'desc')->paginate(15)->withQueryString();
        $lastEntry = RawMaterialInspection::orderBy('date', 'desc')->first();
        $thisMonth = RawMaterialInspection::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.raw-material-inspection.index', compact('records', 'lastEntry', 'thisMonth'));
    }

    public function store(StoreRawMaterialInspectionRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;
        RawMaterialInspection::create($data);
        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id) { return response()->json(RawMaterialInspection::findOrFail($id)); }

    public function update(StoreRawMaterialInspectionRequest $request, $id)
    {
        RawMaterialInspection::findOrFail($id)->update($request->validated());
        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        RawMaterialInspection::findOrFail($id)->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();
        
        $pdf = Pdf::loadView('admin.reports.raw-material-inspection.pdf', [
            'records' => $records, 'year' => $request->year ?? now()->year, 'month' => $request->month ?? now()->month,
            'monthLabel' => \Carbon\Carbon::create($request->year ?? now()->year, $request->month ?? now()->month)->format('F Y'),
        ]);
        return $pdf->download("raw-material-inspection-export.pdf");
    }

    public function exportCsv(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('date', 'asc')->get();

        $csv = "Date,Supplier,Material,Qty,Unit,Clearness,Odor,Damages,Particles,Result,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->supplier},{$r->material_type},{$r->quantity_received},{$r->unit},{$r->clearness},{$r->odor},{$r->without_damages},{$r->free_from_particles},{$r->overall_result},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=raw-material-inspection-export.csv"]);
    }
}