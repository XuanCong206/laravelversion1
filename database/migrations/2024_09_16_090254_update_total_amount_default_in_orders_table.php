<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Thêm giá trị mặc định cho cột total_amount
            $table->decimal('total_amount', 10, 2)->default(0.00)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa giá trị mặc định nếu rollback
            $table->decimal('total_amount', 10, 2)->change();
        });
    }
};
