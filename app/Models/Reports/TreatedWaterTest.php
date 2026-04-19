<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatedWaterTest extends Model
{
    use SoftDeletes;

    protected $table = 'treated_water_tests';

    protected $fillable = [
        'date',
        'test_time',
        'tds',
        'ph',
        'taste',
        'odor',
        'appearance',
        'appearance_note',
        'foreign_impurities',
        'sealing_quality',
        'sealing_notes',
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

    public function getResultAttribute()
    {
        $tdsInRange = $this->tds < 250;
        $phInRange = $this->ph >= 6.5 && $this->ph <= 8.0;
        $tasteNormal = $this->taste === 'Normal';
        $odorNormal = $this->odor === 'Normal';
        $noForeignImpurities = $this->foreign_impurities === 'None';
        $sealingGood = in_array($this->sealing_quality, ['Good', 'N/A']);

        if ($tdsInRange && $phInRange && $tasteNormal && $odorNormal && $noForeignImpurities && $sealingGood) {
            return 'Pass';
        }
        return 'Fail';
    }

    public function getTdsStatusAttribute()
    {
        if ($this->tds < 250) return 'Normal';
        if ($this->tds < 500) return 'High';
        return 'Very High';
    }

    public function getPhStatusAttribute()
    {
        if ($this->ph >= 6.5 && $this->ph <= 8.0) return 'Normal';
        return 'Out of Range';
    }
}