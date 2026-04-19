<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('rep');

        // Default to recent attendance / leave requests
        $attendances = $query->orderBy('date', 'desc')->paginate(20);

        return view('admin.attendance.index', compact('attendances'));
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('rep');
        
        // return view('admin.attendance.show', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        abort(404);
    }
}
