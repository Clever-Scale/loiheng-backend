<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'cart_id',
        'address_id',
        'delivery_id',
        'payment_method',
        'coupon_code',
        'coupon_price',
        'total_price',
        'discount_price',
        'status',
        'order_no',
        'delivery_fee',
        'is_active',
        'is_preorder',
    ];
}
