<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StoreTrainingAttendanceRequest;
use App\Models\Reports\TrainingAttendance;
use App\Models\Reports\TrainingAttendanceEntry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TrainingAttendanceController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = TrainingAttendance::with('entries');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('session_date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month') && $request->filled('year')) {
            $query->forMonth($request->year, $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('session_title', 'like', "%{$search}%")
                  ->orWhere('trainer_name', 'like', "%{$search}%")
                  ->orWhereHas('entries', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('designation', 'like', "%{$search}%");
                  });
            });
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('session_date', 'desc')->paginate(15)->withQueryString();
        $lastEntry = TrainingAttendance::orderBy('session_date', 'desc')->first();
        $thisMonth = TrainingAttendance::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.training-attendance.index', compact('records', 'lastEntry', 'thisMonth'));
    }

    public function store(StoreTrainingAttendanceRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = 1;

        $training = TrainingAttendance::create($data);

        foreach ($request->attendees as $index => $attendee) {
            TrainingAttendanceEntry::create([
                'training_attendance_id' => $training->id,
                'number' => $index + 1,
                'name' => $attendee['name'],
                'designation' => $attendee['designation'],
                'signature_present' => false,
            ]);
        }

        return response()->json(['message' => 'Record saved successfully']);
    }

    public function show($id)
    {
        $record = TrainingAttendance::with('entries')->findOrFail($id);
        return response()->json($record);
    }

    public function update(StoreTrainingAttendanceRequest $request, $id)
    {
        $training = TrainingAttendance::findOrFail($id);
        $training->update($request->validated());

        $training->entries()->delete();
        foreach ($request->attendees as $index => $attendee) {
            TrainingAttendanceEntry::create([
                'training_attendance_id' => $training->id,
                'number' => $index + 1,
                'name' => $attendee['name'],
                'designation' => $attendee['designation'],
                'signature_present' => false,
            ]);
        }

        return response()->json(['message' => 'Record updated successfully']);
    }

    public function destroy($id)
    {
        $record = TrainingAttendance::findOrFail($id);
        $record->entries()->delete();
        $record->delete();

        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function exportPdf(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('session_date', 'asc')->get();

        $pdf = Pdf::loadView('admin.reports.training-attendance.pdf', [
            'records' => $records,
            'year' => $request->year ?? now()->year,
            'month' => $request->month ?? now()->month,
            'monthLabel' => \Carbon\Carbon::create($request->year ?? now()->year, $request->month ?? now()->month)->format('F Y'),
        ]);

        return $pdf->download("training-attendance-export.pdf");
    }

    public function exportCsv(Request $request)
    {
        $records = $this->buildQuery($request)->orderBy('session_date', 'asc')->get();
        $headers = ['Date', 'Session Title', 'Trainer', 'Duration', 'Attendee Name', 'Designation'];

        $rows = [];
        foreach ($records as $record) {
            foreach ($record->entries as $entry) {
                $rows[] = [
                    $record->session_date->format('Y-m-d'),
                    $record->session_title,
                    $record->trainer_name,
                    $record->session_duration,
                    $entry->name,
                    $entry->designation,
                ];
            }
        }

        $csv = collect($headers)->implode(',') . "\n";
        foreach ($rows as $row) {
            $csv .= collect($row)->map(fn($v) => '"' . str_replace('"', '""', $v) . '"')->implode(',') . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=training-attendance-export.csv",
        ]);
    }
}