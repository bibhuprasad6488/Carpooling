<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
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
        if ($user->id === 1) {
            $vehicles = Vehicle::all();
        } else {
            $vehicles = Vehicle::where('user_id', $user->id)->get();
        }
        return response()->json($vehicles);
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
            'vehicle_type' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'manufacture_year' => 'required|string',
            'registration_number' => 'required|string',
            'color' => 'required|string',
            'seats' => 'required|string',
            'available_seats' => 'nullable|string',
            'rc_file' => 'required|string',
            'insurance_file' => 'required|string',
            'insurance_expiry' => 'required|string',
            'vehicle_images' => 'nullable|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $vehicle = new Vehicle();
            $vehicle->vehicle_type = $request->vehicle_type;
            $vehicle->brand = $request->brand;
            $vehicle->model = $request->model;
            $vehicle->manufacture_year = $request->manufacture_year;
            $vehicle->registration_number = $request->registration_number;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
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
                $vehicle->rc_file = $destinationPath . $filename;
            }

            // Insurance File
            if ($request->hasFile('insurance_file')) {
                $file = $request->file('insurance_file');
                $filename = 'insurance_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $vehicle->insurance_file = $destinationPath . $filename;
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
            'vehicle_type' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'manufacture_year' => 'required|string',
            'registration_number' => 'required|string',
            'color' => 'required|string',
            'seats' => 'required|string',
            'available_seats' => 'nullable|string',
            'rc_file' => 'required|string',
            'insurance_file' => 'required|string',
            'insurance_expiry' => 'required|string',
            'vehicle_images' => 'nullable|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $vehicle =  Vehicle::find($id);
            $vehicle->vehicle_type = $request->vehicle_type;
            $vehicle->brand = $request->brand;
            $vehicle->model = $request->model;
            $vehicle->manufacture_year = $request->manufacture_year;
            $vehicle->registration_number = $request->registration_number;
            $vehicle->color = $request->color;
            $vehicle->seats = $request->seats;
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
                $vehicle->rc_file = $destinationPath . $filename;
            }

            // Insurance File
            if ($request->hasFile('insurance_file')) {
                $file = $request->file('insurance_file');
                $filename = 'insurance_' . time() . '_' . $file->getClientOriginalName();
                if (file_exists($vehicle->insurance_file)) {
                    unlink($vehicle->insurance_file); // Delete the old file
                }
                $file->move($destinationPath, $filename);
                $vehicle->insurance_file = $destinationPath . $filename;
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
