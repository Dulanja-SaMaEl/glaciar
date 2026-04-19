<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }

    public function assignee()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }
}
