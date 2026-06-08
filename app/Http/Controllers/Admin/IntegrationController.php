<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index()
    {
        return view('admin.integrations.index', [
            'ga4_measurement_id' => SiteSetting::get('ga4_measurement_id'),
            'ga4_property_id'    => SiteSetting::get('ga4_property_id'),
            'whatsapp_number'    => SiteSetting::get('whatsapp_number'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'ga4_measurement_id' => ['nullable', 'string', 'regex:/^G-[A-Z0-9]+$/'],
            'whatsapp_number'    => ['nullable', 'string', 'regex:/^\+?[0-9 ()-]{7,20}$/'],
        ], [
            'ga4_measurement_id.regex' => 'Measurement ID must look like G-XXXXXXX.',
            'whatsapp_number.regex'    => 'Enter a valid phone number in international format, e.g. +1 718 908 9464.',
        ]);

        // Only persist fields that are actually present, so saving one form
        // (e.g. GA4) does not wipe a value owned by the other form (WhatsApp).
        foreach (['ga4_measurement_id', 'ga4_property_id', 'whatsapp_number'] as $key) {
            if ($request->has($key)) {
                SiteSetting::put($key, trim((string) $request->input($key)));
            }
        }

        return redirect(url('admin/integrations'))->with('success', 'Integration settings saved.');
    }
}
