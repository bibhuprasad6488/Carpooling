<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $table = 'rides';
    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'source_address',
        'destination_address',
        'source_lat',
        'source_lng',
        'destination_lat',
        'destination_lng',
        'route_points',
        'ride_date',
        'departure_time',
        'estimated_reach_time',
        'distance_meters',
        'duration_seconds',
        'price_per_seat',
        'total_seats',
        'pet_allowed',
        'smoking_allowed',
        'instant_booking',
        'max_two_in_back',
        'status',
        'created_at',
        'updated_at',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
