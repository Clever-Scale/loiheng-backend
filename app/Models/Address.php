<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'city',
        'township',
        'region',
        'phone',
        'full_name',
        'is_default',
        'address_type',
        'street_address',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
