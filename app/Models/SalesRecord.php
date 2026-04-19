<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesRecord extends Model
{
    protected $table = 'sales_records';

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',

        'cases_500ml' => 'integer',
        'cases_1000ml' => 'integer',
        'cases_1500ml' => 'integer',
        'cases_5000ml' => 'integer',

        'revenue_500ml' => 'decimal:2',
        'revenue_1000ml' => 'decimal:2',
        'revenue_1500ml' => 'decimal:2',
        'revenue_5000ml' => 'decimal:2',

        'total_sales' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'gross_profit' => 'decimal:2',
        'commission' => 'decimal:2',
        'bonus' => 'decimal:2',
        'total_salary' => 'decimal:2',
        'net_profit' => 'decimal:2',

        'status' => 'string',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function rep(): BelongsTo
    {
        return $this->belongsTo(Rep::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    public function scopeForRep(Builder $query, int $repId): Builder
    {
        return $query->where('rep_id', $repId);
    }

    public function scopeForMonth(Builder $query, int $year, int $month): Builder
    {
        return $query->whereYear('date', $year)->whereMonth('date', $month);
    }

    public function scopeSubmitted(Builder $query): Builder
    {
        return $query->whereIn('status', ['submitted', 'verified']);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function getCommissionTierBreakdownAttribute(): array
    {
        $totalSales = (float) $this->total_sales;

        $tier1Cap = (float) config('salary.tier1_cap');
        $tier1Rate = (float) config('salary.tier1_rate');
        $tier2Rate = (float) config('salary.tier2_rate');

        $tier1Sales = min($totalSales, $tier1Cap);
        $tier2Sales = max($totalSales - $tier1Cap, 0);

        $tier1Amount = $tier1Sales * $tier1Rate;
        $tier2Amount = $tier2Sales * $tier2Rate;

        return [
            'tier1_amount' => round($tier1Amount, 2),
            'tier2_amount' => round($tier2Amount, 2),
            'tier1_sales' => round($tier1Sales, 2),
            'tier2_sales' => round($tier2Sales, 2),
        ];
    }
}

