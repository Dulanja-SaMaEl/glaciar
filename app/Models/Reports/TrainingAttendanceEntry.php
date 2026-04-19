<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingAttendanceEntry extends Model
{
    use SoftDeletes;

    protected $table = 'training_attendance_entries';

    protected $fillable = [
        'training_attendance_id',
        'number',
        'name',
        'designation',
        'signature_present',
    ];

    protected $casts = [
        'signature_present' => 'boolean',
    ];

    public function trainingAttendance()
    {
        return $this->belongsTo(TrainingAttendance::class, 'training_attendance_id');
    }
}