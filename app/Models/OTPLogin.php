<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPLogin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'otp',
        'expired_time'
    ];
}
