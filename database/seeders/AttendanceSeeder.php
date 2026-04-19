<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Rep;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $reps = Rep::all();
        $today = Carbon::today();

        // 30 days of attendance
        for ($i = 30; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            
            // Skip Sundays
            if ($date->isSunday()) continue;

            foreach ($reps as $rep) {
                // 90% chance to be present
                if (rand(1, 100) > 10) {
                    $checkIn = $date->copy()->setHour(8)->setMinute(rand(0, 45));
                    $checkOut = $date->copy()->setHour(17)->setMinute(rand(0, 60));

                    Attendance::create([
                        'rep_id' => $rep->id,
                        'date' => $date,
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'check_in_location' => '6.9271, 79.8612', // Colombo approx
                        'check_out_location' => '6.9271, 79.8612',
                    ]);
                }
            }
        }
    }
}
