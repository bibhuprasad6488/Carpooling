<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Services\GoogleMapService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RideController extends Controller
{

    protected $googleMapService;

    public function __construct(GoogleMapService $googleMapService)
    {
        $this->googleMapService = $googleMapService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rides = Ride::with('driver', 'vehicle');
        if ($request->has('travel_date')) {
            $rides->where('ride_date', $request->travel_date);
        }

        return response()->json($rides->get());
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
        $validate = Validator::make($request->all(), [
            'driver_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'source_address' => 'required',
            'destination_address' => 'required',
            'source_lat' => 'required',
            'source_lng' => 'required',
            'destination_lat' => 'required',

            'destination_lng' => 'required',
            'ride_date' => 'required',
            'departure_time' => 'required',
            'price_per_seat' => 'required',
            'total_seats' => 'required',
            'pet_allowed' => 'nullable|in:yes,no',
            'smoking_allowed' => 'nullable|in:yes,no',
            'instant_booking' => 'nullable|in:yes,no',
            'max_two_in_back' => 'nullable|in:yes,no',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {

            // Calculate ETA
            $departureDateTime = Carbon::parse(
                $request->ride_date . ' ' . $request->departure_time
            );

            // Fetch route from Google Maps
            $route = $this->googleMapService->getRouteDetails(
                $request->source_lat,
                $request->source_lng,
                $request->destination_lat,
                $request->destination_lng,
                $departureDateTime->timestamp
            );
            Log::info("route", ['resp' => $route]);

            // Decode polyline to route points
            $routePoints = $this->googleMapService->decodePolyline($route['polyline']);
            Log::info("polyline", ['resp' => $routePoints]);


            $estimatedArrival = $departureDateTime
                ->copy()
                ->addSeconds($route['duration_in_traffic']);

            $ride = new Ride();
            $ride->driver_id = $request->driver_id;
            $ride->vehicle_id = $request->vehicle_id;
            $ride->source_address = $request->source_address;
            $ride->destination_address = $request->destination_address;
            $ride->source_lat = $request->source_lat;
            $ride->source_lng = $request->source_lng;
            $ride->destination_lat = $request->destination_lat;
            $ride->destination_lng = $request->destination_lng;
            $ride->route_points = json_encode($routePoints);
            $ride->ride_date = $request->ride_date;
            $ride->departure_time = $request->departure_time;
            $ride->estimated_reach_time = $estimatedArrival->format('H:i:s');
            $ride->polyline = $route['polyline'];
            $ride->distance_meters = $route['distance'];
            $ride->duration_seconds = $route['duration_in_traffic'];
            $ride->price_per_seat = $request->price_per_seat;
            $ride->total_seats = $request->total_seats;
            $ride->available_seats = $request->total_seats;
            $ride->pet_allowed = $request->pet_allowed;
            $ride->smoking_allowed = $request->smoking_allowed;
            $ride->instant_booking = $request->instant_booking;
            $ride->max_two_in_back = $request->max_two_in_back;

            $ride->save();
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Ride Published successfully'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $th->getMessage()], 500);
        }
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
        $ride = Ride::with('driver', 'vehicle')->find($id);
        return response()->json($ride);
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
