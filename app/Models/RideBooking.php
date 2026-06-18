<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RideBooking extends Model
{
    protected $fillable = [
        'booking_code',
        'ride_id',
        'passenger_id',
        'seats',
        'ride_source',
        'ride_destination',
        'ride_source_lat',
        'ride_source_lng',
        'ride_destination_lat',
        'ride_destination_lng',
        'ride_date',
        'ride_time',
        'price_per_seat',
        'total_price',
        'status',
        'accepted_at',
        'confirmed_at',
        'cancelled_at',
        'completed_at',
        'cancel_reason',
        'payment_status',
        'payment_type',
        'created_at',
        'updated_at',
    ];

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }
}
