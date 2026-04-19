<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterialInspection extends Model
{
    use SoftDeletes;

    protected $table = 'raw_material_inspections';

    protected $fillable = [
        'date',
        'supplier',
        'material_type',
        'quantity_received',
        'unit',
        'clearness',
        'odor',
        'without_damages',
        'free_from_particles',
        'comments',
        'checked_by',
        'overall_result',
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
}