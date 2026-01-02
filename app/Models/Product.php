<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Cho phép lưu dữ liệu vào các cột này
    protected $fillable = [
        'name', 
        'image', 
        'price', 
        'quantity', 
        'description'
    ];
}