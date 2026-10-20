<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Rep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function locations()
    {
        return $this->hasMany(RepLocation::class);
    }

    public function targets()
    {
        return $this->hasMany(RepTarget::class);
    }

    public function deliveryRoutes()
    {
        return $this->belongsToMany(DeliveryRoute::class);
    }
}
