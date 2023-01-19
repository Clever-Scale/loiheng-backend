<?php

namespace App\Models;

use App\Mail\ContactMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'subject',
        'description',
    ];

    public static function boot() {

        parent::boot();

        static::created(function ($item) {

            $adminEmail = "stawhat124@gmail.com";
            Mail::to($adminEmail)->send(new ContactMail($item));
        });
    }
}
