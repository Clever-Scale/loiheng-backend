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
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }
}
