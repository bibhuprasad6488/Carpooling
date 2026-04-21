<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\Clock\now;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users,email',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()], 422);
        }
        $user = User::where('email', trim($request->email))->first();

        if ($user) {
            return response()->json(['status' => false, 'message' => 'Email already exists'], 422);
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $userDetails = new UserDetail();
            $userDetails->user_id = $user->id;
            $userDetails->city = $request->city;
            $userDetails->state = $request->state;
            $userDetails->country = $request->country;
            $userDetails->postal_code = $request->postal_code;
            $userDetails->address = $request->address;
            $userDetails->bank_account_holder = $request->bank_account_holder;
            $userDetails->bank_account_number = $request->bank_account_number;
            $userDetails->bank_account_ifsc = $request->bank_account_ifsc;
            $userDetails->bank_branch_name = $request->bank_branch_name;
            $userDetails->bank_branch_code = $request->bank_branch_code;

            $destinationPath = public_path('uploads/user/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('driver_license')) {
                $file = $request->file('driver_license');
                $filename = 'dl_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $userDetails->driver_license = $destinationPath . $filename;
            }

            // Adhhar Card
            if ($request->hasFile('adhhar_card')) {
                $file = $request->file('adhhar_card');
                $filename = 'adhhar_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $userDetails->adhhar_card = $destinationPath . $filename;
            }

            // Pan Card
            if ($request->hasFile('pan_card')) {
                $file = $request->file('pan_card');
                $filename = 'pan_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $userDetails->pan_card = $destinationPath . $filename;
            }

            // Pass Photo
            if ($request->hasFile('pass_photo')) {
                $file = $request->file('pass_photo');
                $filename = 'passphoto_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $userDetails->pass_photo = $destinationPath . $filename;
            }

            // Bank account
            if ($request->hasFile('bank_account')) {
                $file = $request->file('bank_account');
                $filename = 'bankaccount_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $userDetails->bank_account = $destinationPath . $filename;
            }

            // Profile picture
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = 'profile_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $userDetails->profile_picture = $destinationPath . $filename;
            }


            $userDetails->save();

            DB::commit(); // ✅ IMPORTANT

            $user->userDetails;

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful',
                'token' => $user->createToken('api_token')->plainTextToken,
                'user' => $user
            ], 201);
        } catch (\Throwable $th) {

            DB::rollback(); // ✅ rollback on error

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong Error: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()], 422);
        }
        $user = User::where([
            'email' => trim($request->email),
        ])->first();

        if (!$user) {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }
        $user->userDetails;

        // $user->tokens()->delete();
        // $token = $user->createToken('auth_token')->plainTextToken;
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['status' => 'success', 'message' => 'Login successful', 'user' => $user, 'token' => $token,], 200);
    }
    public function paswordReset(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|exists:users,email'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()]);
        }

        // Generate OTP for to send through email or phone
    }
    
    public function logout()
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }

        $user = User::find($authUser->id);


        if ($user) {
            $user->tokens()->delete();
            return response()->json(['status' => 'success', 'message' => 'Logout successful'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }
    }
}
