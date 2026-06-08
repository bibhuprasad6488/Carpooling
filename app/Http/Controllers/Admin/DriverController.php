<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = User::with('userDetails')->where('role', 2)->orderByDesc('id')->get()->map(function ($d) {
            $d->userDetails->profile_picture = $d->userDetails->profile_picture ? asset('uploads/user/' . $d->userDetails->profile_picture) : '';
            return $d;
        });
        return view('admin.drivers.list', compact('drivers'));
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
        $driver = User::with('userDetails')->find($id);

        if ($driver->userDetails) {

            $driver->userDetails->driver_license =
                ($driver->userDetails &&
                    $driver->userDetails->driver_license)
                ? asset('uploads/user/' . $driver->userDetails->driver_license)
                : '';
            $driver->userDetails->adhhar_card =
                ($driver->userDetails &&
                    $driver->userDetails->adhhar_card)
                ? asset('uploads/user/' . $driver->userDetails->adhhar_card)
                : '';
            $driver->userDetails->pan_card =
                ($driver->userDetails &&
                    $driver->userDetails->pan_card)
                ? asset('uploads/user/' . $driver->userDetails->pan_card)
                : '';
            $driver->userDetails->bank_account =
                ($driver->userDetails &&
                    $driver->userDetails->bank_account)
                ? asset('uploads/user/' . $driver->userDetails->bank_account)
                : '';
            $driver->userDetails->profile_picture =
                ($driver->userDetails &&
                    $driver->userDetails->profile_picture)
                ? asset('uploads/user/' . $driver->userDetails->profile_picture)
                : '';
        }

        return view('admin.drivers.show', compact('driver'));
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
            $driverDetails = UserDetail::find($id);

            $map = [
                'dl'      => 'is_dl_verified',
                'adhhar'  => 'is_adhhar_verified',
                'pan'     => 'is_pan_verified',
                'account' => 'is_account_verified',
            ];

            if (!isset($map[$docType])) {

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid document type.'
                ], 422);
            }

            $field = $map[$docType];

            $driverDetails->$field = $status;

            $statuses = [
                $driverDetails->is_dl_verified,
                $driverDetails->is_adhhar_verified,
                $driverDetails->is_pan_verified,
                $driverDetails->is_account_verified,
            ];

            if (
                count(array_unique($statuses)) === 1 &&
                $statuses[0] === 'approved'
            ) {
                $driverDetails->status = 'verified';
                $driverDetails->is_verified = 1;
            } elseif (in_array('rejected', $statuses)) {
                $driverDetails->status = 'rejected';
                $driverDetails->is_verified = 0;
            } else {
                $driverDetails->status = 'pending';
                $driverDetails->is_verified = 0;
            }

            $driverDetails->save();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Document Status Changed'
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
