<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'recorded_at' => 'datetime',
    ];

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }
}
