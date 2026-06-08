<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        return view('admin.websitesetting', compact('setting'));
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
        $request->validate([
            'site_title' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $setting = SiteSetting::find(1);
            if (!$setting) {
                $setting = new SiteSetting();
            }

            // Update fields
            $setting->site_title = $request->site_title;
            $setting->contact_email = $request->contact_email;
            $setting->alt_email = $request->alt_email;
            $setting->contact_phone = $request->contact_phone;
            $setting->alt_phone = $request->alt_phone;
            $setting->call_wp_number = $request->call_wp_number;
            $setting->wp_message = $request->wp_message;
            $setting->copyright = $request->copyright;
            $setting->commision = $request->commision;
            $setting->site_desc = $request->site_desc;
            $setting->site_map_key = $request->site_map_key;
            $setting->address = $request->address;
            $setting->site_meta_desc = $request->site_meta_desc;
            $setting->site_meta_key = $request->site_meta_key;
            $setting->smtp_host = $request->smtp_host;
            $setting->smtp_port = $request->smtp_port;
            $setting->smtp_username = $request->smtp_username;
            $setting->smtp_password = $request->smtp_password;
            $setting->smtp_from_name = $request->smtp_from_name;
            $setting->smtp_from_email = $request->smtp_from_email;
            $setting->footer_text_one = $request->footer_text_one;
            $setting->footer_text_two = $request->footer_text_two;
            $setting->cta_title = $request->cta_title;
            $setting->cta_sub_title = $request->cta_sub_title;


            // /** Upload Path */
            $destinationPath = public_path('storage/images/settings/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Site Logo
            if ($request->hasFile('site_logo')) {
                $file = $request->file('site_logo');
                $siteLogo = 'Site_logo_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->site_logo)) {
                    $oldFilePath = $destinationPath . $setting->site_logo;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $siteLogo);

                $setting->site_logo = $siteLogo;
            }

            if ($request->hasFile('footer_logo')) {
                $file = $request->file('footer_logo');
                $footerLogo = 'Footer_logo_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->footer_logo)) {
                    $oldFilePath = $destinationPath . $setting->footer_logo;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogo);

                $setting->footer_logo = $footerLogo;
            }

            if ($request->hasFile('footer_logo_one')) {
                $file = $request->file('footer_logo_one');
                $footerLogoOne = 'Footer_logo_one_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->footer_logo_one)) {
                    $oldFilePath = $destinationPath . $setting->footer_logo_one;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoOne);

                $setting->footer_logo_one = $footerLogoOne;
            }


            if ($request->hasFile('footer_logo_two')) {
                $file = $request->file('footer_logo_two');
                $footerLogoTwo = 'Footer_logo_two_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->footer_logo_two)) {
                    $oldFilePath = $destinationPath . $setting->footer_logo_two;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $footerLogoTwo);

                $setting->footer_logo_two = $footerLogoTwo;
            }

            if ($request->hasFile('favicon')) {
                $file = $request->file('favicon');
                $favicon = 'favicon_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($setting->favicon)) {
                    $oldFilePath = $destinationPath . $setting->favicon;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $favicon);

                $setting->favicon = $favicon;
            }



            $setting->save();
            DB::commit();
            return back()->with('success', 'Site settings updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
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
