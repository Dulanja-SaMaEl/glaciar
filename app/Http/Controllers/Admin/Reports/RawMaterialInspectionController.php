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
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = RawMaterialInspection::forMonth($year, $month)->orderBy('date', 'desc')->get();
        $lastEntry = RawMaterialInspection::orderBy('date', 'desc')->first();
        $thisMonth = RawMaterialInspection::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.raw-material-inspection.index', compact('records', 'year', 'month', 'lastEntry', 'thisMonth'));
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
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $records = RawMaterialInspection::forMonth($year, $month)->orderBy('date', 'asc')->get();
        
        $pdf = Pdf::loadView('admin.reports.raw-material-inspection.pdf', [
            'records' => $records, 'year' => $year, 'month' => $month,
            'monthLabel' => \Carbon\Carbon::create($year, $month)->format('F Y'),
        ]);
        return $pdf->download("raw-material-inspection-{$month}-{$year}.pdf");
    }

    public function exportCsv(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $records = RawMaterialInspection::forMonth($year, $month)->orderBy('date', 'asc')->get();

        $csv = "Date,Supplier,Material,Qty,Unit,Clearness,Odor,Damages,Particles,Result,Checked By\n";
        foreach ($records as $r) {
            $csv .= "{$r->date->format('Y-m-d')},{$r->supplier},{$r->material_type},{$r->quantity_received},{$r->unit},{$r->clearness},{$r->odor},{$r->without_damages},{$r->free_from_particles},{$r->overall_result},{$r->checked_by}\n";
        }
        return Response::make($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=raw-material-inspection-{$month}-{$year}.csv"]);
    }
}