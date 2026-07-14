<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paysheet extends Model
{
    protected $guarded = [];

    protected $casts = [
        'other_earnings' => 'array',
        'other_deductions' => 'array',
        'payment_date' => 'date',
    ];

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }
}
