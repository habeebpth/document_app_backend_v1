<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit()
    {
        // Assuming only one settings row exists
        $setting = Setting::first();
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $setting->company_name = $request->company_name;
        $setting->company_address = $request->company_address;
        $setting->phone_number = $request->phone_number;

        // Upload company logo
        if ($request->hasFile('company_logo')) {
            if ($setting->company_logo) {
                Storage::delete($setting->company_logo);
            }
$setting->company_logo = $request->file('company_logo')->store('public/settings');
        }

        // Upload background image
        if ($request->hasFile('background_image')) {
            if ($setting->background_image) {
                Storage::delete($setting->background_image);
            }
            $setting->background_image = $request->file('background_image')->store('public/settings');

        }

        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
