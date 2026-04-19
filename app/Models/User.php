<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// Import these models so the relationships work
use App\Models\Order; 
use App\Models\Zone;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'type',
        'phone',
        'address',
        'avatar',
        'status',
        'employee_id',
        'zone_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    // ==========================================
    // ADD THESE RELATIONSHIPS BELOW
    // ==========================================

    /**
     * Relationship: A User (Customer) has many Orders.
     * This assumes the 'orders' table has a 'customer_id' column.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Relationship: A User (Customer or Rep) belongs to a Zone.
     * This looks at the 'zone_id' column on the users table.
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function rep()
    {
        return $this->hasOne(Rep::class);
    }

    public function adminProfile()
    {
        return $this->hasOne(Admin::class);
    }
}