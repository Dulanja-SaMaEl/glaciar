<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UvBulbRecord extends Model
{
    use SoftDeletes;

    protected $table = 'uv_bulb_records';

    protected $fillable = [
        'date',
        'bulb_id',
        'bulb_location',
        'start_time',
        'finish_time',
        'running_hours',
        'cumulative_hours',
        'max_life_hours',
        'remaining_hours',
        'remaining_percentage',
        'status',
        'comments',
        'checked_by',
        'admin_id',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'finish_time' => 'datetime:H:i',
        'running_hours' => 'decimal:2',
        'cumulative_hours' => 'decimal:2',
        'remaining_hours' => 'decimal:2',
        'remaining_percentage' => 'decimal:2',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)
                     ->whereMonth('date', $month);
    }

    public function getRunningHoursAttribute()
    {
        if (!$this->start_time || !$this->finish_time) {
            return 0;
        }
        $start = strtotime($this->start_time);
        $finish = strtotime($this->finish_time);
        return round(($finish - $start) / 3600, 2);
    }

    public function getStatusAttribute()
    {
        $remaining = $this->remaining_percentage ?? 0;
        
        if ($remaining > 20) {
            return 'Good';
        }
        if ($remaining >= 5) {
            return 'Replace Soon';
        }
        return 'Replace Now';
    }

    public static function latestForBulb($bulbId)
    {
        return static::where('bulb_id', $bulbId)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->first();
    }

    public static function allBulbsSummary()
    {
        $bulbs = static::select('bulb_id')
            ->distinct()
            ->pluck('bulb_id');

        $summary = [];
        foreach ($bulbs as $bulbId) {
            $latest = static::latestForBulb($bulbId);
            if ($latest) {
                $summary[] = [
                    'bulb_id' => $bulbId,
                    'location' => $latest->bulb_location,
                    'cumulative_hours' => $latest->cumulative_hours,
                    'remaining_hours' => $latest->remaining_hours,
                    'remaining_percentage' => $latest->remaining_percentage,
                    'status' => $latest->status,
                ];
            }
        }
        return $summary;
    }
}