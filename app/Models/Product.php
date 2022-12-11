<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_code',
        'name',
        'price',
        'cover_img',
        'description',
        'short_description',
        'sku',
        'desc_file',
        'status',
        'approved_by',
        'approved_when',
        'is_active',
        'is_preorder',
        'is_feature_product',
        'is_new_arrival',
        'stock',
        'user_id',
        'category_id',
        'brand_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
