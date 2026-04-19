<?php

namespace Database\Seeders;

use App\Models\Reports\PestControlRecord;
use App\Models\Reports\TrainingAttendance;
use App\Models\Reports\TrainingAttendanceEntry;
use App\Models\Reports\TankCleaningRecord;
use App\Models\Reports\RawWaterTest;
use App\Models\Reports\RawMaterialInspection;
use App\Models\Reports\TreatedWaterTest;
use App\Models\Reports\DailyCleaningRecord;
use App\Models\Reports\UvBulbRecord;
use Illuminate\Database\Seeder;

class QualityReportsSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = 1;
        
        // 1. Pest Control - 30 days mostly Clear, 3-4 days with Issues
        for ($day = 1; $day <= 30; $day++) {
            $date = now()->startOfMonth()->addDays($day - 1);
            $hasIssue = in_array($day, [5, 12, 20, 28]);
            
            PestControlRecord::create([
                'date' => $date,
                'tube_well' => $hasIssue ? 'Issue' : 'Clear',
                'storage_tank_area' => 'Clear',
                'filter_room' => $hasIssue ? 'Clear' : ($day % 7 === 0 ? 'N/A' : 'Clear'),
                'filling_room' => 'Clear',
                'raw_material_store' => 'Clear',
                'finish_product_store' => 'Clear',
                'washing_area_19l' => 'Clear',
                'office_area' => 'Clear',
                'factory_entrance' => $day % 3 === 0 ? 'N/A' : 'Clear',
                'lunch_room' => 'Clear',
                'comments' => $hasIssue ? 'Minor pest activity observed near entrance' : null,
                'checked_by' => 'Admin',
                'admin_id' => $adminId,
            ]);
        }

        // 2. Training Attendance - 10 sessions with 5-15 attendees each
        $topics = ['Safety Procedures', 'Hygiene Standards', 'Equipment Handling', 'Quality Control', 'Emergency Response', 'Customer Service', 'Production Process', 'Maintenance', 'Packaging', 'Inventory'];
        for ($i = 0; $i < 10; $i++) {
            $date = now()->startOfMonth()->addDays(rand(1, 28));
            $session = TrainingAttendance::create([
                'session_date' => $date,
                'session_title' => $topics[$i],
                'session_duration' => rand(1, 3) . ' hour' . (rand(1, 3) > 1 ? 's' : ''),
                'trainer_name' => ['John Smith', 'Sarah Johnson', 'Mike Wilson', 'Lisa Brown'][rand(0, 3)],
                'admin_id' => $adminId,
            ]);

            $attendeeCount = rand(5, 15);
            for ($j = 1; $j <= $attendeeCount; $j++) {
                TrainingAttendanceEntry::create([
                    'training_attendance_id' => $session->id,
                    'number' => $j,
                    'name' => "Employee $j",
                    'designation' => ['Operator', 'Supervisor', 'Technician', 'Helper'][rand(0, 3)],
                    'signature_present' => rand(0, 1) === 1,
                ]);
            }
        }

        // 3. Tank Cleaning - 20 records for 2 tanks
        for ($i = 0; $i < 20; $i++) {
            $date = now()->startOfMonth()->addDays(rand(1, 28));
            TankCleaningRecord::create([
                'date' => $date,
                'tank_number' => $i % 2 === 0 ? 'T-01' : 'T-02',
                'frequency' => 'Daily',
                'cleaned' => rand(0, 10) > 1 ? 'Yes' : 'Partial',
                'cleaning_method' => 'High pressure wash',
                'chemical_used' => 'Sanitizer solution',
                'comments' => null,
                'checked_by' => 'Admin',
                'admin_id' => $adminId,
            ]);
        }

        // 4. Raw Water Testing - 30 records (2 per day)
        for ($day = 1; $day <= 15; $day++) {
            foreach (['08:00', '16:00'] as $time) {
                $date = now()->startOfMonth()->addDays($day);
                RawWaterTest::create([
                    'date' => $date,
                    'test_time' => $time,
                    'tds' => rand(150, 450),
                    'ph' => rand(65, 80) / 10,
                    'taste' => 'Normal',
                    'odor' => 'Normal',
                    'appearance' => 'Clear',
                    'comments' => null,
                    'checked_by' => 'Admin',
                    'admin_id' => $adminId,
                ]);
            }
        }

        // 5. Raw Material Inspection - 15 records
        $suppliers = ['ABC Supplies', 'XYZ Corp', 'Global Materials', 'Prime Packaging'];
        $materials = ['Caps', 'Bottles', 'Labels', 'Packaging'];
        for ($i = 0; $i < 15; $i++) {
            $date = now()->startOfMonth()->addDays(rand(1, 28));
            $result = rand(1, 10) > 2 ? 'Accepted' : (rand(0, 1) ? 'Rejected' : 'Accepted with condition');
            
            RawMaterialInspection::create([
                'date' => $date,
                'supplier' => $suppliers[rand(0, 3)],
                'material_type' => $materials[rand(0, 3)],
                'quantity_received' => rand(50, 500),
                'unit' => 'cartons',
                'clearness' => $result === 'Rejected' ? 'Fail' : 'Pass',
                'odor' => 'Normal',
                'without_damages' => $result === 'Rejected' ? 'No' : 'Yes',
                'free_from_particles' => 'Yes',
                'comments' => null,
                'checked_by' => 'Admin',
                'overall_result' => $result,
                'admin_id' => $adminId,
            ]);
        }

        // 6. Treated Water Testing - 30 records
        for ($day = 1; $day <= 15; $day++) {
            foreach (['08:00', '16:00'] as $time) {
                $date = now()->startOfMonth()->addDays($day);
                TreatedWaterTest::create([
                    'date' => $date,
                    'test_time' => $time,
                    'tds' => rand(50, 200),
                    'ph' => rand(68, 75) / 10,
                    'taste' => 'Normal',
                    'odor' => 'Normal',
                    'appearance' => 'Clear',
                    'foreign_impurities' => 'None',
                    'sealing_quality' => 'Good',
                    'comments' => null,
                    'checked_by' => 'Admin',
                    'admin_id' => $adminId,
                ]);
            }
        }

        // 7. Daily Cleaning - 30 records mostly complete
        for ($day = 1; $day <= 30; $day++) {
            $date = now()->startOfMonth()->addDays($day - 1);
            $hasIncomplete = in_array($day, [3, 8, 15, 22, 27]);
            
            DailyCleaningRecord::create([
                'date' => $date,
                'shift' => 'Morning',
                'fe_floor' => $hasIncomplete ? 'Not Done' : 'Done',
                'fe_windows' => 'Done',
                'fe_door' => 'Done',
                'fe_cupboard' => 'Done',
                'fe_foot_bath' => 'Done',
                'fa_wall' => 'Done',
                'fa_floor' => $hasIncomplete ? 'Not Done' : 'Done',
                'fa_roof' => 'Done',
                'st_wall' => 'Done',
                'fill_wall' => 'Done',
                'fill_floor' => 'Done',
                'fill_roof' => 'Done',
                'fill_table' => 'Done',
                'fill_taps' => 'Done',
                'fill_pipes' => 'Done',
                'general_comments' => null,
                'checked_by' => 'Admin',
                'admin_id' => $adminId,
            ]);
        }

        // 8. UV Bulb - 60 records for UV-01 and UV-02
        // UV-01 at 85% life - Replace Soon
        $uv01Cumulative = 7650; // 85% of 9000
        for ($day = 1; $day <= 30; $day++) {
            $date = now()->startOfMonth()->addDays($day - 1);
            $hours = rand(8, 12);
            $uv01Cumulative += $hours;
            
            UvBulbRecord::create([
                'date' => $date,
                'bulb_id' => 'UV-01',
                'bulb_location' => 'Treatment Room A',
                'start_time' => '08:00',
                'finish_time' => sprintf('%02d:00', 8 + $hours),
                'running_hours' => $hours,
                'cumulative_hours' => $uv01Cumulative,
                'max_life_hours' => 9000,
                'remaining_hours' => 9000 - $uv01Cumulative,
                'remaining_percentage' => round((9000 - $uv01Cumulative) / 9000 * 100, 2),
                'status' => $uv01Cumulative >= 8550 ? 'Replace Now' : ($uv01Cumulative >= 7200 ? 'Replace Soon' : 'Good'),
                'comments' => null,
                'checked_by' => 'Admin',
                'admin_id' => $adminId,
            ]);
        }

        // UV-02 at normal levels - Good
        $uv02Cumulative = 2000;
        for ($day = 1; $day <= 30; $day++) {
            $date = now()->startOfMonth()->addDays($day - 1);
            $hours = rand(8, 12);
            $uv02Cumulative += $hours;
            
            UvBulbRecord::create([
                'date' => $date,
                'bulb_id' => 'UV-02',
                'bulb_location' => 'Treatment Room B',
                'start_time' => '08:00',
                'finish_time' => sprintf('%02d:00', 8 + $hours),
                'running_hours' => $hours,
                'cumulative_hours' => $uv02Cumulative,
                'max_life_hours' => 9000,
                'remaining_hours' => 9000 - $uv02Cumulative,
                'remaining_percentage' => round((9000 - $uv02Cumulative) / 9000 * 100, 2),
                'status' => 'Good',
                'comments' => null,
                'checked_by' => 'Admin',
                'admin_id' => $adminId,
            ]);
        }
    }
}