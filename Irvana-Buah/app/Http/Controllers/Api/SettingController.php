<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return Setting::first();
    }

    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string',
            'site_logo' => 'nullable|string',
            'site_favicon' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'address' => 'nullable|string',
            'footer_text' => 'nullable|string',
        ]);
        $setting->update($data);
        return response()->json($setting);
    }
}
