<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkin(Request $request)
    {
        $rep = $request->user()->rep;
        if (!$rep) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $rep_id = $rep->id;
        $today = Carbon::today();

        $attendance = Attendance::where('rep_id', $rep_id)->where('date', $today)->first();

        if ($attendance && $attendance->check_in) {
            return response()->json(['success' => false, 'message' => 'Already checked in today'], 400);
        }

        if (!$attendance) {
            $attendance = new Attendance([
                'rep_id' => $rep_id,
                'date' => $today,
            ]);
        }

        $attendance->check_in = now();
        $attendance->check_in_location = $request->input('location');
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Checked in successfully at ' . $attendance->check_in->format('H:i'),
            'data' => $attendance
        ]);
    }

    public function checkout(Request $request)
    {
        $rep = $request->user()->rep;
        if (!$rep) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $rep_id = $rep->id;
        $today = Carbon::today();

        $attendance = Attendance::where('rep_id', $rep_id)->where('date', $today)->first();

        if (!$attendance || !$attendance->check_in) {
            return response()->json(['success' => false, 'message' => 'You have not checked in today'], 400);
        }

        if ($attendance->check_out) {
             return response()->json(['success' => false, 'message' => 'Already checked out today'], 400);
        }

        $attendance->check_out = now();
        $attendance->check_out_location = $request->input('location');
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Checked out successfully at ' . $attendance->check_out->format('H:i'),
            'data' => $attendance
        ]);
    }
}
