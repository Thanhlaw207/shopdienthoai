<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Danh sách các cột được phép lưu vào database
    protected $fillable = [
        'name', 
        'brand', 
        'price', 
        'quantity', 
        'image', 
        'description',
        'ram',      // Thêm cột này
        'storage',  // Thêm cột này
        'color'     // Thêm cột này
    ];
}