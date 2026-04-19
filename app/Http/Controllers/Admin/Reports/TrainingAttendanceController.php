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
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = TrainingAttendance::with('entries')
            ->forMonth($year, $month)
            ->orderBy('session_date', 'desc')
            ->get();

        $lastEntry = TrainingAttendance::orderBy('session_date', 'desc')->first();
        $thisMonth = TrainingAttendance::forMonth(now()->year, now()->month)->count();

        return view('admin.reports.training-attendance.index', compact('records', 'year', 'month', 'lastEntry', 'thisMonth'));
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
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = TrainingAttendance::with('entries')
            ->forMonth($year, $month)
            ->orderBy('session_date', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.reports.training-attendance.pdf', [
            'records' => $records,
            'year' => $year,
            'month' => $month,
            'monthLabel' => \Carbon\Carbon::create($year, $month)->format('F Y'),
        ]);

        return $pdf->download("training-attendance-{$month}-{$year}.pdf");
    }

    public function exportCsv(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $records = TrainingAttendance::with('entries')
            ->forMonth($year, $month)
            ->orderBy('session_date', 'asc')
            ->get();

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
            'Content-Disposition' => "attachment; filename=training-attendance-{$month}-{$year}.csv",
        ]);
    }
}