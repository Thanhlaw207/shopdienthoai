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
            $table->id();
            $table->string('name');          // Tên điện thoại (VD: iPhone 15 Pro Max)
            $table->string('image')->nullable(); // Ảnh sản phẩm
            $table->decimal('price', 15, 2);  // Giá bán (hỗ trợ số lớn và số thập phân)
            $table->integer('quantity');     // Số lượng máy còn trong kho
            $table->text('description')->nullable(); // Thông số kỹ thuật / Mô tả
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
