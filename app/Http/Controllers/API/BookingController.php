<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Models\RideBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ride = Ride::findOrFail($request->ride_id);

        if ($ride->driver_id == Auth::user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver cannot book own ride'
            ], 400);
        }

        if ($ride->available_seats < $request->seats) {
            return response()->json([
                'status' => 'error',
                'message' => 'Seats not available'
            ], 400);
        }

        $booking = new RideBooking();
        $booking->booking_code = 'BK' . time();
        $booking->ride_id = $ride->id;
        $booking->passenger_id = Auth::user()->id;
        $booking->seats = $request->seats;
        $booking->ride_source = $ride->source;
        $booking->ride_destination = $ride->destination;
        $booking->ride_date = $ride->departure_date;
        $booking->ride_time = $ride->departure_time;
        $booking->price_per_seat = $ride->price_per_seat;
        $booking->total_price = $ride->price_per_seat * $request->seats;
        $booking->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Booking request sent',
            'data' => $booking
        ]);
    }

    public function accept($id)
    {
        $booking = RideBooking::findOrFail($id);

        $ride = Ride::findOrFail($booking->ride_id);

        // only ride owner
        if ($ride->driver_id != Auth::user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($ride->available_seats < $booking->seats) {
            return response()->json([
                'status' => 'error',
                'message' => 'Seats unavailable'
            ], 400);
        }

        DB::transaction(function () use ($booking, $ride) {

            $ride->decrement(
                'available_seats',
                $booking->seats
            );

            $booking->update([
                'status' => 'payment_pending',
                'accepted_at' => now()
            ]);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Booking accepted'
        ]);
    }
    public function reject($id)
{
    $booking = RideBooking::findOrFail($id);

    $booking->update([
        'status'=>'rejected'
    ]);

    return response()->json([
        'message'=>'Booking rejected'
    ]);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
