<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $vehicles = Vehicle::where('user_id', $user->id)->get()->map([$this, 'formattedVehicleDetails']);
        } else {
            $vehicles = [];
        }
        return response()->json($vehicles);
    }

    public function formattedVehicleDetails($vehicle)
    {
        return [
            'id' => $vehicle->id,
            'user_id' => $vehicle->user_id,
            'vehicle_type' => $vehicle->vehicle_type,
            'brand' => $vehicle->brand,
            'model' => $vehicle->model,
            'manufacture_year' => $vehicle->manufacture_year,
            'registration_number' => $vehicle->registration_number,
            'color' => $vehicle->color,
            'seats' => $vehicle->seats,
            'fuel_type' => $vehicle->fuel_type,
            'rc_number' => $vehicle->rc_number,
            'rc_expiry_date' => $vehicle->rc_expiry_date,
            'insurance_provider' => $vehicle->insurance_provider,
            'policy_number' => $vehicle->policy_number,
            'insurance_expiry' => $vehicle->insurance_expiry,
            'available_seats' => $vehicle->available_seats,
            'rc_file' => $vehicle->rc_file ? asset('uploads/vehicle/' . $vehicle->rc_file) : '',
            'insurance_file' => $vehicle->insurance_file ? asset('uploads/vehicle/' . $vehicle->insurance_file) : '',
            'front_image' => $vehicle->front_image ? asset('uploads/vehicle/' . $vehicle->front_image) : '',
            'back_image' => $vehicle->back_image ? asset('uploads/vehicle/' . $vehicle->back_image) : '',
            'side_image' => $vehicle->side_image ? asset('uploads/vehicle/' . $vehicle->side_image) : '',
            'number_plate_image' => $vehicle->number_plate_image ? asset('uploads/vehicle/' . $vehicle->number_plate_image) : '',
            'status' => $vehicle->status,
            'created_at' => Carbon::parse($vehicle->created_at)->format('Y-m-d H:i:s'),
        ];
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
            'user_id' => 'required|exists:users,id',
            // 'vehicle_type' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'manufacture_year' => 'required|string',
            'registration_number' => 'required|string|unique:vehicles,registration_number',
            'color' => 'required|string',
            'seats' => 'required|string',
            'available_seats' => 'nullable|string',
            'rc_file' => 'required',
            'insurance_file' => 'required',
            'insurance_expiry' => 'required',
            'fuel_type' => 'required',
            'rc_number' => 'required|unique:vehicles,rc_number',
            'rc_expiry_date' => 'required',
            'insurance_provider' => 'required',
            'policy_number' => 'required',
            'front_image' => 'required|image',
            'back_image' => 'required|image',
            'side_image' => 'required|image',
            'number_plate_image' => 'required|image',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $vehicle = new Vehicle();
            $vehicle->user_id = $request->user_id;
            $vehicle->vehicle_type = $request->vehicle_type ?? 'Car';
            $vehicle->brand = $request->brand;
            $vehicle->model = $request->model;
            $vehicle->manufacture_year = $request->manufacture_year;
            $vehicle->registration_number = $request->registration_number;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->rc_number = $request->rc_number;
            $vehicle->rc_expiry_date = Carbon::parse($request->rc_expiry_date)->format('Y-m-d');
            $vehicle->insurance_provider = $request->insurance_provider;
            $vehicle->policy_number = $request->policy_number;
            $vehicle->insurance_expiry = Carbon::parse($request->insurance_expiry)->format('Y-m-d');
            $vehicle->available_seats = $request->available_seats;

            $destinationPath = public_path('uploads/vehicle/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // RC File
            if ($request->hasFile('rc_file')) {
                $file = $request->file('rc_file');
                $filename = 'rc_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $vehicle->rc_file = $filename;
            }

            // Insurance File
            if ($request->hasFile('insurance_file')) {
                $file = $request->file('insurance_file');
                $filename = 'insurance_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $vehicle->insurance_file = $filename;
            }

            // Front Image
            if ($request->hasFile('front_image')) {
                $file = $request->file('front_image');
                $filename = 'front_view_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $vehicle->front_image = $filename;
            }

            // Back Image
            if ($request->hasFile('back_image')) {
                $file = $request->file('back_image');
                $filename = 'back_view_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $vehicle->back_image = $filename;
            }

            // Side Image
            if ($request->hasFile('side_image')) {
                $file = $request->file('side_image');
                $filename = 'side_view_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $vehicle->side_image = $filename;
            }

            // Number Plate Image
            if ($request->hasFile('number_plate_image')) {
                $file = $request->file('number_plate_image');
                $filename = 'number_plate_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $vehicle->number_plate_image = $filename;
            }

            $vehicle->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle data stored successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store vehicle data: ' . $th->getMessage(),
            ], 500);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            // 'vehicle_type' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'manufacture_year' => 'required|string',
            'registration_number' => 'required|string|unique:vehicles,registration_number' . $id,
            'color' => 'required|string',
            'seats' => 'required|string',
            'available_seats' => 'nullable|string',
            'rc_file' => 'required',
            'insurance_file' => 'required',
            'insurance_expiry' => 'required',
            'fuel_type' => 'required',
            'rc_number' => 'required|unique:vehicles,rc_number' . $id,
            'rc_expiry_date' => 'required',
            'insurance_provider' => 'required',
            'policy_number' => 'required',
            'front_image' => 'required|image',
            'back_image' => 'required|image',
            'side_image' => 'required|image',
            'number_plate_image' => 'required|image',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $vehicle =  Vehicle::find($id);
            $vehicle->user_id = $request->user_id;
            $vehicle->vehicle_type = $request->vehicle_type ?? 'Car';
            $vehicle->brand = $request->brand;
            $vehicle->model = $request->model;
            $vehicle->manufacture_year = $request->manufacture_year;
            $vehicle->registration_number = $request->registration_number;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->rc_number = $request->rc_number;
            $vehicle->rc_expiry_date = Carbon::parse($request->rc_expiry_date)->format('Y-m-d');
            $vehicle->insurance_provider = $request->insurance_provider;
            $vehicle->policy_number = $request->policy_number;
            $vehicle->insurance_expiry = Carbon::parse($request->insurance_expiry)->format('Y-m-d');
            $vehicle->available_seats = $request->available_seats;

            $destinationPath = public_path('uploads/vehicle/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // RC File
            if ($request->hasFile('rc_file')) {
                $file = $request->file('rc_file');
                $filename = 'rc_' . time() . '_' . $file->getClientOriginalName();
                if (file_exists($vehicle->rc_file)) {
                    unlink($vehicle->rc_file); // Delete the old file
                }
                $file->move($destinationPath, $filename);
                $vehicle->rc_file = $filename;
            }

            // Insurance File
            if ($request->hasFile('insurance_file')) {
                $file = $request->file('insurance_file');
                $filename = 'insurance_' . time() . '_' . $file->getClientOriginalName();
                if (file_exists($vehicle->insurance_file)) {
                    unlink($vehicle->insurance_file); // Delete the old file
                }
                $file->move($destinationPath, $filename);
                $vehicle->insurance_file = $filename;
            }

            // Front Image
            if ($request->hasFile('front_image')) {
                $file = $request->file('front_image');
                $filename = 'front_view_' . time() . '_' . $file->getClientOriginalName();
                if (file_exists($vehicle->front_image)) {
                    unlink($vehicle->front_image); // Delete the old file
                }
                $file->move($destinationPath, $filename);
                $vehicle->front_image = $filename;
            }

            // Back Image
            if ($request->hasFile('back_image')) {
                $file = $request->file('back_image');
                $filename = 'back_view_' . time() . '_' . $file->getClientOriginalName();
                if (file_exists($vehicle->back_image)) {
                    unlink($vehicle->back_image); // Delete the old file
                }
                $file->move($destinationPath, $filename);
                $vehicle->back_image = $filename;
            }

            // Side Image
            if ($request->hasFile('side_image')) {
                $file = $request->file('side_image');
                $filename = 'side_view_' . time() . '_' . $file->getClientOriginalName();
                if (file_exists($vehicle->side_image)) {
                    unlink($vehicle->side_image); // Delete the old file
                }
                $file->move($destinationPath, $filename);
                $vehicle->side_image = $filename;
            }

            // Number Plate Image
            if ($request->hasFile('number_plate_image')) {
                $file = $request->file('number_plate_image');
                $filename = 'number_plate_' . time() . '_' . $file->getClientOriginalName();
                if (file_exists($vehicle->number_plate_image)) {
                    unlink($vehicle->number_plate_image); // Delete the old file
                }
                $file->move($destinationPath, $filename);
                $vehicle->number_plate_image = $filename;
            }

            $vehicle->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle data updated successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update vehicle data: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
