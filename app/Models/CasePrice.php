<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CasePrice extends Model
{
    protected $table = 'case_prices';

    protected $guarded = [];

    protected $casts = [
        'price_per_case' => 'decimal:2',
        'bottles_per_case' => 'integer',
        'effective_from' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        $today = now()->toDateString();

        return $query
            ->where('is_active', true)
            ->where(function (Builder $q) use ($today) {
                $q->whereNull('effective_from')
                    ->orWhere('effective_from', '<=', $today);
            });
    }

    public static function current(string $size): float
    {
        static $cache = [];

        if (isset($cache[$size])) {
            return (float) $cache[$size];
        }

        $row = self::query()
            ->active()
            ->where('product_size', $size)
            ->orderBy('effective_from', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if (!$row) {
            // Safe fallback so local dev still works even if case_prices table is empty.
            $fallback = [
                '500ml' => 750.00,
                '1000ml' => 960.00,
                '1500ml' => 960.00,
                '5000ml' => 1000.00,
            ];

            $cache[$size] = $fallback[$size] ?? 0.0;
            return (float) $cache[$size];
        }

        $cache[$size] = (float) $row->price_per_case;
        return (float) $cache[$size];
    }
}

