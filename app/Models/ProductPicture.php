<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    use HasFactory;
    protected $fillable =[
        'image',
        'product_id',
        'display_order',
        'is_active',
    ];
}
