<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_code',
        'booking_id',
        'payment_id',
        'order_id',
        'created_at',
        'updated_at',
    ];
}
