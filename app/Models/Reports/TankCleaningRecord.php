<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TankCleaningRecord extends Model
{
    use SoftDeletes;

    protected $table = 'tank_cleaning_records';

    protected $fillable = [
        'date',
        'tank_number',
        'frequency',
        'cleaned',
        'cleaning_method',
        'chemical_used',
        'comments',
        'checked_by',
        'admin_id',
    ];

    protected $casts = [
        'date' => 'date',
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

    public function scopeForTank($query, $tankNumber)
    {
        return $query->where('tank_number', $tankNumber);
    }
}