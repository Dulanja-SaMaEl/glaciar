<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PestControlRecord extends Model
{
    use SoftDeletes;

    protected $table = 'pest_control_records';

    protected $fillable = [
        'date',
        'tube_well',
        'storage_tank_area',
        'filter_room',
        'filling_room',
        'raw_material_store',
        'finish_product_store',
        'washing_area_19l',
        'office_area',
        'factory_entrance',
        'lunch_room',
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

    public function getOverallStatusAttribute()
    {
        $areas = [
            $this->tube_well,
            $this->storage_tank_area,
            $this->filter_room,
            $this->filling_room,
            $this->raw_material_store,
            $this->finish_product_store,
            $this->washing_area_19l,
            $this->office_area,
            $this->factory_entrance,
            $this->lunch_room,
        ];

        $hasIssue = in_array('Issue', $areas);
        $hasNA = in_array('N/A', $areas);

        if ($hasIssue) {
            return 'Issues Found (' . $this->issue_count . ')';
        }
        if ($hasNA) {
            return 'Partial';
        }
        return 'All Clear';
    }

    public function getIssueCountAttribute()
    {
        $areas = [
            $this->tube_well,
            $this->storage_tank_area,
            $this->filter_room,
            $this->filling_room,
            $this->raw_material_store,
            $this->finish_product_store,
            $this->washing_area_19l,
            $this->office_area,
            $this->factory_entrance,
            $this->lunch_room,
        ];

        return count(array_filter($areas, fn($a) => $a === 'Issue'));
    }
}