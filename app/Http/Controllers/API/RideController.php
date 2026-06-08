<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Ride;
use App\Services\GoogleMapService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

    public function findRides(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'source_address' => 'required',
            'destination_address' => 'required',
            'ride_date' => 'required',
            'no_of_seats' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }

        try {

            $cacheKey = 'rides_' . md5(json_encode($request->all()));
            $rideSearch = Cache::remember(
                $cacheKey,
                now()->addMinutes(5),
                function () use ($request) {
                    return Ride::with('driver', 'driver.userDetails', 'vehicle')
                        ->where('source_address', $request->source_address)
                        ->where('destination_address', $request->destination_address)
                        ->whereDate('ride_date', $request->ride_date)
                        ->where(
                            'available_seats',
                            '>=',
                            $request->no_of_seats
                        )
                        ->where('status', 'scheduled')->get()->map(function ($ride) {
                            $driverDetails = $ride->driver->userDetails;
                            $vehicleDetails = $ride->vehicle;
                            // return $ride;
                            return [
                                "id" => $ride->id,
                                "source_address" => $ride->source_address,
                                "destination_address" => $ride->destination_address,
                                "source_lat" => $ride->source_lat,
                                "source_lng" => $ride->source_lng,
                                "destination_lat" => $ride->destination_lat,
                                "destination_lng" => $ride->destination_lng,
                                "ride_date" => $ride->ride_date,
                                "departure_time" => $ride->departure_time,
                                "distance_meters" => $ride->distance_meters,
                                "duration_seconds" => $ride->duration_seconds,
                                "estimated_reach_time" => $ride->estimated_reach_time,
                                "pet_allowed" => $ride->pet_allowed,
                                "smoking_allowed" => $ride->smoking_allowed,
                                "instant_booking" => $ride->instant_booking,
                                "max_two_in_back" => $ride->max_two_in_back,
                                "price_per_seat" => $ride->price_per_seat,
                                "total_seats" => $ride->total_seats,
                                "available_seats" => $ride->available_seats,
                                "status" => $ride->status,
                                "driver_id" => $ride->driver_id,
                                "driver_name" => $ride->driver->name,
                                "driver_email" => $ride->driver->email,
                                "driver_phone" => $ride->driver->phone,
                                "driver_profile_picture" => ($driverDetails && $driverDetails->profile_picture) ? asset('uploads/user/' . $driverDetails->profile_picture) : '',
                                "driver_is_verified" => $driverDetails->is_verified,
                                "vehicle_id" => $ride->vehicle_id,
                                "vehicle_type" => $vehicleDetails->vehicle_type,
                                "brand" => $vehicleDetails->brand,
                                "model" => $vehicleDetails->model,
                                "manufacture_year" => $vehicleDetails->manufacture_year,
                                "registration_number" => $vehicleDetails->registration_number,
                                "fuel_type" => $vehicleDetails->fuel_type,
                            ];
                        });
                }
            );

            return response()->json(['status' => 'success', 'rides' => $rideSearch]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'messsage' => 'Error: ' . $th->getMessage()
            ], 500);
        }
    }

    public function searchLocations(Request $request)
    {
        $keyword = trim($request->keyword);

        $cacheKey = 'locations_' . md5($keyword);

        $locations = Cache::remember(

            $cacheKey,

            now()->addHours(1),

            function () use ($keyword) {

                $sources = Ride::where(
                    'source_address',
                    'LIKE',
                    "%{$keyword}%"
                )
                    ->distinct()
                    ->pluck('source_address');

                $destinations = Ride::where(
                    'destination_address',
                    'LIKE',
                    "%{$keyword}%"
                )
                    ->distinct()
                    ->pluck('destination_address');

                return $sources
                    ->merge($destinations)
                    ->unique()
                    ->values();
            }
        );

        return response()->json($locations);
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
            // Log::info("route", ['resp' => $route]);

            // Decode polyline to route points
            $routePoints = $this->googleMapService->decodePolyline($route['polyline']);
            // Log::info("polyline", ['resp' => $routePoints]);


            $estimatedArrival = $departureDateTime
                ->copy()
                ->addSeconds($route['duration_in_traffic']);

            if ($request->source_place_id) {
                $checkLocation = Location::where(
                    'google_place_id',
                    $request->source_place_id
                )->first();
                if (!$checkLocation) {
                    $checkLocation = new Location();
                    $checkLocation->name = $request->source_address;
                    $checkLocation->latitude = $request->source_lat;
                    $checkLocation->longitude = $request->source_lng;
                    $checkLocation->google_place_id = $request->source_place_id;
                    $checkLocation->save();
                }
            }

            if ($request->destination_place_id) {
                $checkLocation = Location::where(
                    'google_place_id',
                    $request->destination_place_id
                )->first();
                if (!$checkLocation) {
                    $checkLocation = new Location();
                    $checkLocation->name = $request->destination_address;
                    $checkLocation->latitude = $request->destination_lat;
                    $checkLocation->longitude = $request->destination_lng;
                    $checkLocation->google_place_id = $request->destination_place_id;
                    $checkLocation->save();
                }
            }

            $ride = new Ride();
            $ride->driver_id = $request->driver_id;
            $ride->vehicle_id = $request->vehicle_id;
            $ride->source_address = $request->source_address;
            $ride->destination_address = $request->destination_address;
            $ride->source_place_id = $request->source_place_id;
            $ride->destination_place_id = $request->destination_place_id;
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
