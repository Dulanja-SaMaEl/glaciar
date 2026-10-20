<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepTarget extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }
}
