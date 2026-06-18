<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RideController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.auth.login');
});


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/optimize', function () {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:cache');
            return 'Command executed successfully!';
            // return what you want
        });


    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/change-password/{id}', [ProfileController::class, 'chnagePassword'])->name('chnage.password');


        Route::resource('/rides', RideController::class)->names('rides');
        Route::resource('/bookings', BookingController::class)->names('bookings');
        Route::resource('/drivers', DriverController::class)->names('driver');
        Route::resource('/vehicles', VehicleController::class)->names('vehicle');
        Route::resource('/website-setting', WebsiteSettingController::class)->names('website-setting');
    });
});
