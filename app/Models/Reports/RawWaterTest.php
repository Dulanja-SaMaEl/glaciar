<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawWaterTest extends Model
{
    use SoftDeletes;

    protected $table = 'raw_water_tests';

    protected $fillable = [
        'date',
        'test_time',
        'tds',
        'ph',
        'taste',
        'odor',
        'appearance',
        'appearance_note',
        'comments',
        'checked_by',
        'admin_id',
    ];

    protected $casts = [
        'date' => 'date',
        'test_time' => 'datetime:H:i',
        'tds' => 'decimal:2',
        'ph' => 'decimal:2',
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

    public function scopeFailedTests($query)
    {
        return $query->where(function ($q) {
            $q->where('taste', 'Abnormal')
              ->orWhere('odor', 'Abnormal')
              ->orWhere('tds', '>=', 500)
              ->orWhere(function ($q2) {
                  $q2->where('ph', '<', 6.5)
                     ->orWhere('ph', '>', 8.5);
              });
        });
    }

    public function getResultAttribute()
    {
        $tdsInRange = $this->tds < 500;
        $phInRange = $this->ph >= 6.5 && $this->ph <= 8.5;
        $tasteNormal = $this->taste === 'Normal';
        $odorNormal = $this->odor === 'Normal';

        if ($tdsInRange && $phInRange && $tasteNormal && $odorNormal) {
            return 'Pass';
        }
        return 'Fail';
    }

    public function getTdsStatusAttribute()
    {
        if ($this->tds < 500) return 'Normal';
        if ($this->tds < 1000) return 'High';
        return 'Very High';
    }

    public function getPhStatusAttribute()
    {
        if ($this->ph >= 6.5 && $this->ph <= 8.5) return 'Normal';
        return 'Out of Range';
    }
}