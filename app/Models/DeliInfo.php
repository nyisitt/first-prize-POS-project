<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'deli_id',
        'order_id',
        'expired_date',
        'status'
    ];
}
