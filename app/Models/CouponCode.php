<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CouponCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'expired_date',
        'count',
        'value',
        'type',
        'is_customer',
        'note',
        'created_by'
    ];
}
