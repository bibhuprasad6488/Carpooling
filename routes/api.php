<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\RideController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/get-roles', [UserController::class, 'getRoles']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'paswordReset']);
    Route::post('/send-otp', [AuthController::class, 'sendOTP']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);

    Route::post('/find-rides', [RideController::class, 'findRides']);
    Route::post('/search-locaton', [RideController::class, 'searchLocations']);
    Route::get('/get-website-data', [UserController::class, 'getSiteData']);

    Route::middleware('auth:sanctum')->group(function () {
        // Fetch the authenticated user along with their userDetails if they exist
        // Route::get('/user', function (Request $request) {
        //     return $request->user()->userDetails
        //         ? $request->user()->load('userDetails')
        //         : $request->user();
        // });
        Route::get('/user', [UserController::class, 'getUser']);

        Route::post('/logout', [AuthController::class, 'logout']);

        // Vehicle Data Management
        Route::get('/vehicles', [VehicleController::class, 'index']);
        Route::post('/store-vehicle-data', [VehicleController::class, 'store']);
        Route::get('/edit-vehicle-data/{id}', [VehicleController::class, 'edit']);
        Route::put('/update-vehicle-data/{id}', [VehicleController::class, 'update']);
        Route::delete('/destroy-vehicle-data/{id}', [VehicleController::class, 'destroy']);

        // Ride Management
        Route::get('/rides', [RideController::class, 'index']);
        Route::post('/store-ride-data', [RideController::class, 'store']);

        // Booking Management
        Route::get('/driver/booking-requests', [BookingController::class, 'index']);
        Route::post('/create-booking', [BookingController::class, 'store']);
        Route::post('/payment-success', [BookingController::class, 'paymentSuccess']);
        Route::post('/payment-failed', [BookingController::class, 'paymentFailed']);

        Route::post('/bookings/{id}/accept', [BookingController::class, 'acceptUserBooking']);
        Route::post('/bookings/{id}/reject', [BookingController::class, 'rejectUserBooking']);
        Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancelUserBooking']);
    });
});
