<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_product';

    protected $fillable= [
        'order_id',
        'product_id',
        'price_at_order_time',
        'quantity',
        'product_name',
        'short_desc',
        'desc'
    ];

    // Mối quan hệ với Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
