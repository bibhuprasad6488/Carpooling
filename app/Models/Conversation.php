<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'booking_id',
        'ride_id',
        'driver_id',
        'passenger_id'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
