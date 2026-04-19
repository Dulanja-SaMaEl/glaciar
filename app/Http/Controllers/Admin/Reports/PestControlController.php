<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StorePestControlRequest;
use App\Models\Reports\PestControlRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PestControlController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = PestControlRecord::forMonth($year, $month)
            ->orderBy('date', 'desc')
            ->get();

        $stats = [
            'total' => $records->count(),
            'issues' => $records->filter(fn($r) => str_contains($r->overall_status, 'Issues'))->count(),
            'clear' => $records->filter(fn($r) => $r->overall_status === 'All Clear')->count(),
        ];

        $lastEntry = PestControlRecord::orderBy('date', 'desc')->first();
        $thisMonth = PestControlRecord::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.pest-control.index', compact('records', 'stats', 'year', 'month', 'lastEntry', 'thisMonth'));
    }

    public function store(StorePestControlRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;

        PestControlRecord::create($data);

        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id)
    {
        $record = PestControlRecord::findOrFail($id);
        return response()->json($record);
    }

    public function update(StorePestControlRequest $request, $id)
    {
        $record = PestControlRecord::findOrFail($id);
        $record->update($request->validated());

        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        $record = PestControlRecord::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = PestControlRecord::forMonth($year, $month)
            ->orderBy('date', 'asc')
            ->get();

        $stats = [
            'total' => $records->count(),
            'issues' => $records->filter(fn($r) => str_contains($r->overall_status, 'Issues'))->count(),
        ];

        $areaCounts = [];
        $areas = ['tube_well', 'storage_tank_area', 'filter_room', 'filling_room', 'raw_material_store', 'finish_product_store', 'washing_area_19l', 'office_area', 'factory_entrance', 'lunch_room'];
        foreach ($areas as $area) {
            $areaCounts[$area] = $records->filter(fn($r) => $r->$area === 'Issue')->count();
        }
        $mostProblematic = !empty($areaCounts) ? array_keys($areaCounts, max($areaCounts))[0] : null;

        $pdf = Pdf::loadView('admin.reports.pest-control.pdf', [
            'records' => $records,
            'stats' => $stats,
            'year' => $year,
            'month' => $month,
            'monthLabel' => \Carbon\Carbon::create($year, $month)->format('F Y'),
            'mostProblematic' => $mostProblematic,
        ]);

        return $pdf->download("pest-control-{$month}-{$year}.pdf");
    }

    public function exportCsv(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = PestControlRecord::forMonth($year, $month)
            ->orderBy('date', 'asc')
            ->get();

        $headers = ['Date', 'Tube Well', 'Storage Tank', 'Filter Room', 'Filling Room', 'Raw Material Store', 'Finish Product', '19L Washing', 'Office', 'Factory Entrance', 'Lunch Room', 'Status', 'Checked By', 'Comments'];

        $rows = $records->map(function ($r) {
            return [
                $r->date->format('Y-m-d'),
                $r->tube_well,
                $r->storage_tank_area,
                $r->filter_room,
                $r->filling_room,
                $r->raw_material_store,
                $r->finish_product_store,
                $r->washing_area_19l,
                $r->office_area,
                $r->factory_entrance,
                $r->lunch_room,
                $r->overall_status,
                $r->checked_by,
                $r->comments,
            ];
        });

        $csv = collect($headers)->implode(',') . "\n";
        foreach ($rows as $row) {
            $csv .= collect($row)->map(fn($v) => '"' . str_replace('"', '""', $v) . '"')->implode(',') . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=pest-control-{$month}-{$year}.csv",
        ]);
    }
}