<?php

namespace App\Models\Reports;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyCleaningRecord extends Model
{
    use SoftDeletes;

    protected $table = 'daily_cleaning_records';

    protected $fillable = [
        'date',
        'shift',
        'fe_floor',
        'fe_windows',
        'fe_door',
        'fe_cupboard',
        'fe_foot_bath',
        'fa_wall',
        'fa_floor',
        'fa_roof',
        'st_wall',
        'fill_wall',
        'fill_floor',
        'fill_roof',
        'fill_table',
        'fill_taps',
        'fill_pipes',
        'general_comments',
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

    public function getCompletionCountAttribute()
    {
        $items = $this->getCleaningItems();
        return count(array_filter($items, fn($v) => $v === 'Done'));
    }

    public function getTotalItemsAttribute()
    {
        return 15;
    }

    public function getNotDoneItemsAttribute()
    {
        $itemLabels = [
            'fe_floor' => 'Factory Entrance - Floor',
            'fe_windows' => 'Factory Entrance - Windows',
            'fe_door' => 'Factory Entrance - Door',
            'fe_cupboard' => 'Factory Entrance - Cupboard',
            'fe_foot_bath' => 'Factory Entrance - Foot Bath',
            'fa_wall' => 'Filter Area - Wall',
            'fa_floor' => 'Filter Area - Floor',
            'fa_roof' => 'Filter Area - Roof',
            'st_wall' => 'Semi Treated Tank - Wall',
            'fill_wall' => 'Filling Area - Wall',
            'fill_floor' => 'Filling Area - Floor',
            'fill_roof' => 'Filling Area - Roof',
            'fill_table' => 'Filling Area - Table',
            'fill_taps' => 'Filling Area - Taps',
            'fill_pipes' => 'Filling Area - Pipes',
        ];

        $notDone = [];
        foreach ($itemLabels as $key => $label) {
            if ($this->$key === 'Not Done') {
                $notDone[] = $label;
            }
        }
        return $notDone;
    }

    public function getOverallStatusAttribute()
    {
        $done = $this->completion_count;
        $notDone = $this->total_items - $done;

        if ($notDone === 0) {
            return 'Complete';
        }
        if ($notDone > 0) {
            return 'Incomplete (' . $notDone . ' items)';
        }
        return 'Partial';
    }

    protected function getCleaningItems()
    {
        return [
            $this->fe_floor,
            $this->fe_windows,
            $this->fe_door,
            $this->fe_cupboard,
            $this->fe_foot_bath,
            $this->fa_wall,
            $this->fa_floor,
            $this->fa_roof,
            $this->st_wall,
            $this->fill_wall,
            $this->fill_floor,
            $this->fill_roof,
            $this->fill_table,
            $this->fill_taps,
            $this->fill_pipes,
        ];
    }
}