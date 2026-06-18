<?php

namespace App\Http\Controllers\API;

use App\Events\RideSeatUpdated;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Ride;
use App\Models\RideBooking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

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
        // return 123;
        $validate = Validator::make($request->all(), [
            'ride_id' => 'required|exists:rides,id',
            'seats' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }

        DB::beginTransaction();

        try {

            $ride = Ride::findOrFail($request->ride_id);

            // prevent self booking
            if ($ride->driver_id == Auth::id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Driver cannot book own ride'

                ], 400);
            }

            // check seats
            if ($ride->available_seats < $request->seats) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Seats not available'
                ], 400);
            }

            // // prevent duplicate pending booking
            // $existingBooking = RideBooking::where('ride_id', $ride->id)
            //     ->where(
            //         'passenger_id',
            //         Auth::id()
            //     )
            //     ->whereIn('status', [

            //         'pending',

            //         'confirmed'
            //     ])
            //     ->first();

            // if ($existingBooking) {

            //     return response()->json([

            //         'status' => 'error',

            //         'message' =>
            //         'Booking already exists.'
            //     ], 400);
            // }

            // create booking
            $booking = RideBooking::create([
                'booking_code' => 'BK' . time(),
                'ride_id' => $ride->id,
                'passenger_id' => Auth::id(),
                'seats' => $request->seats,
                'ride_source' => $ride->source_address,
                'ride_destination' => $ride->destination_address,
                'ride_date' => $ride->ride_date,
                'ride_time' => $ride->departure_time,
                'price_per_seat' => $ride->price_per_seat,
                'total_price' => $ride->price_per_seat * $request->seats,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // razorpay order
            $api = new Api(
                config('services.razorpay.key'),

                config('services.razorpay.secret')
            );

            $order = $api->order->create([
                'receipt' => 'booking_' . $booking->id,
                'amount' => $booking->total_price * 100,
                'currency' => 'INR',
            ]);

            Payment::create([
                'booking_code' => $booking->booking_code,
                'booking_id' => $booking->id,
                'order_id' => $order['id'],
                'payment_status' => 'unpaid',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'booking_id' => $booking->id,
                'order_id' => $order['id'],
                'amount' => $booking->total_price,
                'razorpay_key' =>
                config('services.razorpay.key'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        DB::beginTransaction();

        try {

            $booking = RideBooking::lockForUpdate()
                ->findOrFail($request->booking_id);

            // already paid
            if ($booking->payment_status == 'paid') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment already processed.'
                ]);
            }

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            // verify signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            // lock ride
            $ride = Ride::lockForUpdate()
                ->findOrFail($booking->ride_id);

            // recheck seats
            if (
                $ride->available_seats <
                $booking->seats
            ) {

                throw new Exception(
                    'Seats unavailable'
                );
            }

            // deduct seats
            $ride->decrement(
                'available_seats',
                $booking->seats
            );

            $ride->refresh();

            // confirm booking
            $booking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'confirmed_at' => now(),
            ]);

            Payment::where('booking_id', $booking->id)->update([
                'payment_id' =>
                $request->razorpay_payment_id,
                'payment_status' => 'paid',
            ]);

            // realtime sync
            broadcast(
                new RideSeatUpdated($ride)
            )->toOthers();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function paymentFailed(Request $request)
    {
        DB::beginTransaction();
        try {

            $booking = RideBooking::findOrFail(
                $request->booking_id
            );

            // prevent changing paid booking
            if ($booking->payment_status == 'paid') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment already completed.'
                ]);
            }

            // update booking
            $booking->update([
                'status' => 'cancelled',
                'payment_status' => 'failed',
            ]);

            // update payment table
            Payment::where(
                'booking_id',
                $booking->id
            )->update([
                'payment_status' => 'failed'
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Payment marked as failed.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }


    public function refund(Request $request, $bookingId)
    {
        DB::beginTransaction();

        try {

            $booking = RideBooking::lockForUpdate()
                ->findOrFail($bookingId);

            // only confirmed & paid booking can refund
            if (
                $booking->status != 'confirmed' ||
                $booking->payment_status != 'paid'
            ) {

                return response()->json([

                    'status' => 'error',

                    'message' =>
                    'Only paid bookings can be refunded.'
                ], 400);
            }

            // get payment details
            $payment = Payment::where(
                'booking_id',
                $booking->id
            )->first();

            if (!$payment || !$payment->payment_id) {

                return response()->json([

                    'status' => 'error',

                    'message' =>
                    'Payment record not found.'
                ], 404);
            }

            // initialize razorpay
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            // create refund
            $refund = $api->payment
                ->fetch($payment->payment_id)
                ->refund([

                    'amount' =>
                    $booking->total_price * 100,

                    'speed' => 'normal',
                ]);

            // restore seats
            $ride = Ride::lockForUpdate()
                ->findOrFail($booking->ride_id);

            $ride->increment(
                'available_seats',
                $booking->seats
            );

            $ride->refresh();

            // update booking
            $booking->update([

                'status' => 'cancelled',

                'payment_status' => 'refunded',

                'cancelled_at' => now(),
            ]);

            // update payment
            $payment->update([

                'refund_id' => $refund['id'],

                'payment_status' => 'refunded',

                'refunded_at' => now(),
            ]);

            // realtime seat sync
            broadcast(
                new RideSeatUpdated($ride)
            )->toOthers();

            DB::commit();

            return response()->json([

                'status' => 'success',

                'message' => 'Refund successful.',

                'refund_id' => $refund['id'],
            ]);
        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([

                'status' => 'error',

                'message' => $th->getMessage()

            ], 500);
        }
    }



    // public function accept($id)
    // {
    //     $booking = RideBooking::findOrFail($id);

    //     $ride = Ride::findOrFail($booking->ride_id);

    //     // only ride owner
    //     if ($ride->driver_id != Auth::user()->id) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Unauthorized'
    //         ], 403);
    //     }

    //     if ($ride->available_seats < $booking->seats) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Seats unavailable'
    //         ], 400);
    //     }

    //     DB::transaction(function () use ($booking, $ride) {

    //         $ride->decrement(
    //             'available_seats',
    //             $booking->seats
    //         );


    //         broadcast(
    //             new RideSeatUpdated($ride)
    //         )->toOthers();

    //         $booking->update([
    //             'status' => 'payment_pending',
    //             'accepted_at' => now()
    //         ]);
    //     });

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Booking accepted'
    //     ]);
    // }

    // public function reject($id)
    // {
    //     $booking = RideBooking::findOrFail($id);

    //     $booking->update([
    //         'status' => 'rejected'
    //     ]);

    //     return response()->json([
    //         'message' => 'Booking rejected'
    //     ]);
    // }

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
