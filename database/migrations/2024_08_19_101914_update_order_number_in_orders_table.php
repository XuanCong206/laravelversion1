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


            // Xóa cột total_amount nếu tồn tại
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->dropColumn('total_amount');
            }

            // Đặt giá trị mặc định cho cột status là 'pending'
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending')->change();
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

             // Thêm lại cột total_amount khi rollback
             $table->decimal('total_amount', 10, 2);

             // Khôi phục lại giá trị status mà không có giá trị mặc định
             $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->change();
        });
    }
};
