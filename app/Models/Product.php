<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function getAvailableStockAttribute()
    {
        return max(0, $this->stock - $this->reserved_stock);
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        }
        if ($this->stock <= $this->minimum_stock_level || $this->stock <= $this->low_stock_threshold) {
            return 'low_stock';
        }
        if ($this->maximum_stock_capacity && $this->stock >= $this->maximum_stock_capacity) {
            return 'overstock';
        }
        return 'in_stock';
    }
}
