<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with('driver.userdetails')->get()->map(function ($v) {
            $v->rc_file = $v->rc_file ? assert('uploads/vehicle/' . $v->rc_file) : '';
            $v->insurance_file = $v->insurance_file ? assert('uploads/vehicle/' . $v->insurance_file) : '';
            $v->number_plate_image = $v->number_plate_image ? assert('uploads/vehicle/' . $v->number_plate_image) : '';
            $v->side_image = $v->side_image ? assert('uploads/vehicle/' . $v->side_image) : '';
            $v->back_image = $v->back_image ? assert('uploads/vehicle/' . $v->back_image) : '';
            $v->front_image = $v->front_image ? assert('uploads/vehicle/' . $v->front_image) : '';
            $v->driver->userdetails->profile_picture = $v->driver->userdetails->profile_picture ? assert('uploads/user/' . $v->driver->userdetails->profile_picture) : '';
            return $v;
        });
        // dd($vehicles);
        return view('admin.vehicles.list', compact('vehicles'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::with('driver.userdetails')->find($id);
        if ($vehicle) {
            $vehicle->rc_file = $vehicle->rc_file ? asset('uploads/vehicle/' . $vehicle->rc_file) : '';
            $vehicle->insurance_file = $vehicle->insurance_file ? asset('uploads/vehicle/' . $vehicle->insurance_file) : '';
            $vehicle->number_plate_image = $vehicle->number_plate_image ? asset('uploads/vehicle/' . $vehicle->number_plate_image) : '';
            $vehicle->side_image = $vehicle->side_image ? asset('uploads/vehicle/' . $vehicle->side_image) : '';
            $vehicle->back_image = $vehicle->back_image ? asset('uploads/vehicle/' . $vehicle->back_image) : '';
            $vehicle->front_image = $vehicle->front_image ? asset('uploads/vehicle/' . $vehicle->front_image) : '';
        }
        if ($vehicle->driver->userdetails) {
            $vehicle->driver->userdetails->profile_picture = $vehicle->driver->userdetails->profile_picture ? asset('uploads/user/' . $vehicle->driver->userdetails->profile_picture) : '';
        }

        // dd($vehicle);
        return view('admin.vehicles.show', compact('vehicle'));
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
            'status' => 'required',
            'type_of_document' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => $validate->errors()->first()], 422);
        }
        // return response()->json($request->all());
        $status = $request->status;
        $docType = $request->type_of_document;

        DB::beginTransaction();
        try {
            $vehicle = Vehicle::find($id);
            $map = [
                'rc'            => 'is_rc_verified',
                'insurance'     => 'is_insurance_verified',
                'number_plate'  => 'is_number_plate_verified',
                'front_image'   => 'is_front_image_verified',
                'back_image'    => 'is_back_image_verified',
                'side_image'    => 'is_side_image_verified',
            ];

            if (!isset($map[$docType])) {

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid document type.'
                ], 422);
            }

            $field = $map[$docType];
            $vehicle->$field = $status;

            $statuses = [
                $vehicle->is_rc_verified,
                $vehicle->is_insurance_verified,
                $vehicle->is_number_plate_verified,
                $vehicle->is_front_image_verified,
                $vehicle->is_back_image_verified,
                $vehicle->is_side_image_verified,
            ];

            if (
                count(array_unique($statuses)) === 1 &&
                $statuses[0] === 'approved'
            ) {
                $vehicle->status = 'active';
            } elseif (in_array('rejected', $statuses)) {

                $vehicle->status = 'blocked';
            } else {

                $vehicle->status = 'pending';
            }

            $vehicle->save();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Documnet Status Updated'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $th->getMessage()
            ]);
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
