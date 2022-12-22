<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'is_active',
        'qty'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function carts()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
