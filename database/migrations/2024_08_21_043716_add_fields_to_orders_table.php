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
        Schema::table('orders', function (Blueprint $table) {
            // thêm các cột này vào bảng orders
            $table->string('name')->nullable(); // Tên người nhận
            $table->string('phone')->nullable(); // Số điện thoại người nhận
            $table->string('email')->nullable(); // Email người nhận
            $table->string('address')->nullable(); // Địa chỉ người nhận
        });
    }

    /**
     * Reverse the <migrations class=""></migrations>
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
          // thêm các cột này vào bảng orders
            $table->dropColumn(['name', 'phone', 'email', 'address']);
        });
    }
};
