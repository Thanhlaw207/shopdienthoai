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
        // Sử dụng Schema::table để bổ sung cột vào bảng đã tồn tại
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->after('name');        // Hãng sản xuất
            $table->string('ram')->nullable()->after('brand');    // Bộ nhớ RAM
            $table->string('storage')->nullable()->after('ram');  // Bộ nhớ trong
            $table->string('color')->nullable()->after('storage'); // Màu sắc
            $table->string('status')->default('active')->after('quantity'); // Trạng thái máy
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Xóa các cột đã thêm nếu muốn quay lại trạng thái cũ
            $table->dropColumn(['brand', 'ram', 'storage', 'color', 'status']);
        });
    }
};