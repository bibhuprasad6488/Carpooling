<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Models\RideBooking;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $drivers = User::where('role', 2)->get();
        $passegners = User::where('role', 3)->get();

        $vehicles = Vehicle::where('status', 'active')->get();
        // $rides = Ride::where('status', 'completed')->get();
        $rides = Ride::all();
        $bookings = RideBooking::where('status', 'confirmed')->get();

        $totalBookingAmount = $bookings->sum('total_price');

        return view('admin.dashboard', compact(
            'drivers',
            'passegners',
            'vehicles',
            'rides',
            'bookings',
            'totalBookingAmount'
        ));
    }
}
