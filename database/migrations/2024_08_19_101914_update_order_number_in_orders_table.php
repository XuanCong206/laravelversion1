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
            // Kiểm tra xem index có tồn tại không trước khi xóa
            if (Schema::hasColumn('orders', 'order_number')) {
                $table->dropUnique(['order_number']); // Xóa unique index nếu có
            }
            $table->string('order_number')->nullable()->change(); // Cho phép null để sau này tự động cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Khôi phục lại unique nếu cần
            $table->string('order_number')->unique()->change();
        });
    }
};
