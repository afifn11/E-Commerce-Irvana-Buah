<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display settings form
     */
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        
        return view('settings.index', compact('setting'));
    }

    /**
     * Update website settings
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'footer_text' => 'nullable|string|max:1000',
        ]);

        $setting = Setting::first() ?? new Setting();

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo
            if ($setting->site_logo && Storage::disk('public')->exists($setting->site_logo)) {
                Storage::disk('public')->delete($setting->site_logo);
            }

            $logoFile = $request->file('site_logo');
            $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('settings', $logoName, 'public');
            $data['site_logo'] = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            // Delete old favicon
            if ($setting->site_favicon && Storage::disk('public')->exists($setting->site_favicon)) {
                Storage::disk('public')->delete($setting->site_favicon);
            }

            $faviconFile = $request->file('site_favicon');
            $faviconName = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
            $faviconPath = $faviconFile->storeAs('settings', $faviconName, 'public');
            $data['site_favicon'] = $faviconPath;
        }

        if ($setting->exists) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui!');
    }

    /**
     * Get logo URL
     */
    public function getLogoUrl()
    {
        $setting = Setting::first();
        
        if ($setting && $setting->site_logo) {
            return asset('storage/' . $setting->site_logo);
        }
        
        return asset('assets/img/logo-irvana-buah.png'); // Default logo
    }

    /**
     * Get favicon URL
     */
    public function getFaviconUrl()
    {
        $setting = Setting::first();
        
        if ($setting && $setting->site_favicon) {
            return asset('storage/' . $setting->site_favicon);
        }
        
        return asset('assets/img/favicon.ico'); // Default favicon
    }

    /**
     * Reset logo to default
     */
    public function resetLogo()
    {
        $setting = Setting::first();
        
        if ($setting && $setting->site_logo) {
            // Delete current logo
            if (Storage::disk('public')->exists($setting->site_logo)) {
                Storage::disk('public')->delete($setting->site_logo);
            }

            $setting->update(['site_logo' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo berhasil direset ke default'
        ]);
    }

    /**
     * Reset favicon to default
     */
    public function resetFavicon()
    {
        $setting = Setting::first();
        
        if ($setting && $setting->site_favicon) {
            // Delete current favicon
            if (Storage::disk('public')->exists($setting->site_favicon)) {
                Storage::disk('public')->delete($setting->site_favicon);
            }

            $setting->update(['site_favicon' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Favicon berhasil direset ke default'
        ]);
    }

    /**
     * Get all settings as JSON (for API)
     */
    public function getSettings()
    {
        $setting = Setting::first();
        
        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'site_name' => $setting->site_name,
                'site_logo_url' => $setting->site_logo ? asset('storage/' . $setting->site_logo) : null,
                'site_favicon_url' => $setting->site_favicon ? asset('storage/' . $setting->site_favicon) : null,
                'email' => $setting->email,
                'phone' => $setting->phone,
                'whatsapp' => $setting->whatsapp,
                'address' => $setting->address,
                'footer_text' => $setting->footer_text,
            ]
        ]);
    }
}