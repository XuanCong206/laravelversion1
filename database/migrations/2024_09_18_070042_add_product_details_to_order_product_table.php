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
        Schema::table('order_product', function (Blueprint $table) {
            $table->text('product_name'); // Tên sản phẩm tại thời điểm đặt hàng
            $table->text('short_desc')->nullable();  // Mô tả ngắn của sản phẩm
            $table->text('desc')->nullable();  // Mô tả chi tiết của sản phẩm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropColumn('product_name');
            $table->dropColumn('short_desc');
            $table->dropColumn('desc');
        });
    }
};
