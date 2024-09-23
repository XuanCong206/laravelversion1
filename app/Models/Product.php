<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /*
        Hiện tại vì bảng products ko liên quan gì tới các bảng khác. 
        nên ko cần dùng hasMany,hasOne, belongsToMany, belongsTo.
    */

    // Tên bảng trong csdl
    protected $table = 'products';

    // Định nghĩa các thuộc tính có thể gán hàng loạt.
    protected $fillable = [
                'name',
                'slug',
                'price', 
                'price_motion', 
                'short_desc', 'desc', 
                'feature_image', 
                'galery', 
                'status',
    ];

    // Định nghĩa thuộc tính json
    protected $casts = [
        'galery' => 'json',
        'price' => 'decimal:3',
        'price_motion' => 'decimal:3',
        'status' => 'boolean',
    ];


    protected $appends = ['formatted_total_amount'];
    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

    // Tự động tạo slug từ tên sản phẩm
    public static function generateSlug($name, $productId = null)
        {
            // Chuyển tên sản phẩm thành slug
            $slug = Str::slug($name);

            // Nếu đang chỉnh sửa sản phẩm (tức là có productId)
            if ($productId) {
                // Lấy sản phẩm từ database
                $product = self::find($productId);
                
                // Nếu tên không thay đổi, giữ nguyên slug hiện tại
                if ($product && $product->name === $name) {
                    return $product->slug;
                }
            }

            // Nếu tạo mới hoặc tên sản phẩm đã thay đổi, kiểm tra trùng lặp slug
            $originalSlug = $slug;
            $i = 1;

            // Kiểm tra trùng lặp và thêm hậu tố nếu slug đã tồn tại
            while (self::where('slug', $slug)->where('id', '<>', $productId)->exists()) {
                $slug = $originalSlug . '-' . $i;
                $i++;
            }

            return $slug;
        }


        // Quan hệ many to many ( nhiều - nhiều ) tới bảng orders.
        // Hàm withPivot('quantity') giúp bạn truy cập được
        // cột quantity trong bảng trung gian order_product.
        public function orders()
        {
            return $this->belongsToMany(Order::class,'order_product')
            ->withPivot('price_at_order_time', 'quantity', 'product_name', 'short_desc', 'desc')
            ->withTimestamps();
        }

  
}
