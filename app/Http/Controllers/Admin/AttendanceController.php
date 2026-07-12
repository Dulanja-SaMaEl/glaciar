<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Rep;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('rep.zone');

        // Search by rep name or ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('rep', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        
        // Filter by zone (department)
        if ($request->filled('zone_id')) {
            $query->whereHas('rep', function ($q) use ($request) {
                $q->where('zone_id', $request->zone_id);
            });
        }

        $attendances = $query->orderBy('date', 'desc')
                             ->orderBy('check_in', 'desc')
                             ->paginate(20)
                             ->withQueryString();
                             
        $zones = \App\Models\Zone::orderBy('name')->get();
                             
        // Statistics for the view
        $today = Carbon::today();
        $stats = [
            'today_total' => Attendance::whereDate('date', $today)->count(),
            'today_present' => Attendance::whereDate('date', $today)->where('status', 'Present')->count(),
            'today_late' => Attendance::whereDate('date', $today)->where('status', 'Late')->count(),
            'today_absent' => Attendance::whereDate('date', $today)->whereIn('status', ['Absent', 'Leave'])->count(),
        ];

        return view('admin.attendance.index', compact('attendances', 'stats', 'zones'));
    }

    public function create()
    {
        $reps = Rep::orderBy('name')->get();
        return view('admin.attendance.create', compact('reps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rep_id' => 'required|exists:reps,id',
            'date' => 'required|date',
            'status' => 'required|string',
            'check_in' => 'nullable|date_format:Y-m-d\TH:i',
            'check_out' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:check_in',
            'remarks' => 'nullable|string',
        ]);

        Attendance::create($validated);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance record created successfully.');
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('rep.zone');
        
        // Get attendance history for this rep
        $history = Attendance::where('rep_id', $attendance->rep_id)
            ->where('id', '!=', $attendance->id)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.attendance.show', compact('attendance', 'history'));
    }

    public function edit(Attendance $attendance)
    {
        $reps = Rep::orderBy('name')->get();
        
        // format check_in and check_out for datetime-local input
        $checkInFormatted = $attendance->check_in ? $attendance->check_in->format('Y-m-d\TH:i') : null;
        $checkOutFormatted = $attendance->check_out ? $attendance->check_out->format('Y-m-d\TH:i') : null;
        
        return view('admin.attendance.edit', compact('attendance', 'reps', 'checkInFormatted', 'checkOutFormatted'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'rep_id' => 'required|exists:reps,id',
            'date' => 'required|date',
            'status' => 'required|string',
            'check_in' => 'nullable|date_format:Y-m-d\TH:i',
            'check_out' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:check_in',
            'remarks' => 'nullable|string',
        ]);

        $attendance->update($validated);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance record updated successfully.');
    }
    
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance record deleted successfully.');
    }
    
    public function exportCsv(Request $request)
    {
        $query = Attendance::with('rep.zone');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('rep', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->filled('zone_id')) {
            $query->whereHas('rep', function ($q) use ($request) {
                $q->where('zone_id', $request->zone_id);
            });
        }

        $attendances = $query->orderBy('date', 'desc')->orderBy('check_in', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=attendance_export_" . date('Y_m_d_H_i') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Date', 'Employee ID', 'Employee Name', 'Zone', 'Status', 'Check In', 'Check Out', 'Working Hours', 'Remarks']);

            foreach ($attendances as $row) {
                $workingHours = '';
                if ($row->check_in && $row->check_out) {
                    $workingHours = round($row->check_in->diffInMinutes($row->check_out) / 60, 2);
                }
                
                fputcsv($file, [
                    $row->id,
                    $row->date->format('Y-m-d'),
                    'REP-' . str_pad($row->rep_id, 4, '0', STR_PAD_LEFT),
                    $row->rep->name ?? '',
                    $row->rep->zone->name ?? '',
                    $row->status,
                    $row->check_in ? $row->check_in->format('Y-m-d H:i:s') : '',
                    $row->check_out ? $row->check_out->format('Y-m-d H:i:s') : '',
                    $workingHours,
                    $row->remarks
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
