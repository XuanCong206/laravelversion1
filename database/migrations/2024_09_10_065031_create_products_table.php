<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();// Tạo cột ID tự động tăng
            $table->string('name');// Tạo cột tên sản phẩm
            $table->string('slug')->unique();// Đường dẫn.
            $table->decimal('price',10,3); // Giá sản phẩm.
            $table->decimal('price_motion',10,3)->nullable(); //Giá khuyến mãi.
            $table->text('short_desc')->nullable(); //Mô tả ngắn.
            $table->text('desc')->nullable(); //Mô tả chi tiết.
            $table->string('feature_image')->nullable(); //hình ảnh chính.
            $table->json('galery')->nullable(); //Thư viện ảnh (( lưu dưới dạng JSON))
            $table->boolean('status')->default(1); // trạng thái sản phẩm.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
