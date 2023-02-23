<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponForCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_code_id',
        'customer_id'
    ];
}
