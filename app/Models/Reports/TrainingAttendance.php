<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingAttendance extends Model
{
    use SoftDeletes;

    protected $table = 'training_attendances';

    protected $fillable = [
        'session_date',
        'session_title',
        'session_duration',
        'trainer_name',
        'admin_id',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function entries()
    {
        return $this->hasMany(TrainingAttendanceEntry::class, 'training_attendance_id');
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('session_date', $year)
                     ->whereMonth('session_date', $month);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('session_date', $date);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('session_date', 'desc');
    }

    public function getAttendeesCountAttribute()
    {
        return $this->entries()->count();
    }
}