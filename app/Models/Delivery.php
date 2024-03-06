<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'phone_number',
        'email_address',
        'region',
        'city',
        'address',
        'deli_code'
    ];
}
