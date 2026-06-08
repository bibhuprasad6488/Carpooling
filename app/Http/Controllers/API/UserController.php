<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUser(Request $request)
    {
        $user = $request->user()->load('userDetails');
        return response()->json($user);
    }

    public function getRoles()
    {
        $roles = Role::where('id', '!=', 1)->get();
        return response()->json($roles);
    }

    public function getSiteData()
    {
        $setting = SiteSetting::find(1);

        if ($setting) {
            $setting->site_logo = $setting->site_logo
                ? asset('storage/images/settings/' . $setting->site_logo)
                : '';

            $setting->footer_logo = $setting->footer_logo
                ? asset('storage/images/settings/' . $setting->footer_logo)
                : '';

            $setting->footer_logo_one = $setting->footer_logo_one
                ? asset('storage/images/settings/' . $setting->footer_logo_one)
                : '';

            $setting->footer_logo_two = $setting->footer_logo_two
                ? asset('storage/images/settings/' . $setting->footer_logo_two)
                : '';

            $setting->favicon = $setting->favicon
                ? asset('storage/images/settings/' . $setting->favicon)
                : '';
        }

        return response()->json($setting);
    }
}
