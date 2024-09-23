<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        // 'status',

        'name',
        'email',
        'phone',
        'address',

    ];

    /*
    Order thuộc về một User (Many-to-One):
    Trong model Order, có phương thức user() với quan hệ belongsTo(), 
    nghĩa là mỗi đơn hàng ( Order ) chỉ thuộc về một người dùng ( USER).

    Ví dụ : Một đơn hàng cụ thể được đặt bởi 1 người dùng duy nhất.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $lastOrder = Order::orderBy('id', 'desc')->first();
            $nextOrderNumber = $lastOrder ? intval($lastOrder->order_number) + 1 : 1;
            $order->order_number = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        });
    }

    protected $guarded = ['order_number']; // Đảm bảo order_number không thể nhập từ bên ngoài


    // protected $appends = ['formatted_total_amount'];

    // public function getFormattedTotalAmountAttribute()
    // {
    //     return number_format($this->total_amount, 0, ',', '.');
    // }

    // Quan hệ many to many ( nhiều - nhiều) tới bảng Product.
    public function products(){
        return $this->belongsToMany(Product::class,'order_product')
        ->withPivot('price_at_order_time', 'quantity', 'product_name', 'short_desc', 'desc')
        ->withTimestamps();
    }
}
