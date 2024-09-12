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
        'status'
    ];

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


    protected $appends = ['formatted_total_amount'];

    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->total_amount, 0, ',', '.');
    }
}
