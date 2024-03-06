<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'card_code',
        'deli_code',
        'total_price',
        'deli_price',
        'status',
        'payment'
    ];
}
