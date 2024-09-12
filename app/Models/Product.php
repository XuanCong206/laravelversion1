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

        // Kiểm tra xem slug đã tồn tại hay chưa
        $originalSlug = $slug;

        // Nếu đang chỉnh sửa sản phẩm , không cần tạo slug mới trừ khi slug trùng.
        if($productId){
            // Lấy slug cũ của sản phẩm.
            $product = self::find($productId);
            if ($product && $product->slug == $slug) {
                // Giữ nguyên slug nếu nó không thay đổi
                return $slug;
            }
        }

        // Nếu là sản phẩm mới hoặc tên đã thay đổi, kiểm tra sự trùng lặp slug
        $i = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }



  
}
