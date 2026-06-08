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
            'facebook_url'       => SiteSetting::get('facebook_url'),
            'twitter_url'        => SiteSetting::get('twitter_url'),
            'instagram_url'      => SiteSetting::get('instagram_url'),
            'linkedin_url'       => SiteSetting::get('linkedin_url'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'ga4_measurement_id' => ['nullable', 'string', 'regex:/^G-[A-Z0-9]+$/'],
            'whatsapp_number'    => ['nullable', 'string', 'regex:/^\+?[0-9 ()-]{7,20}$/'],
            'facebook_url'       => ['nullable', 'url', 'max:255'],
            'twitter_url'        => ['nullable', 'url', 'max:255'],
            'instagram_url'      => ['nullable', 'url', 'max:255'],
            'linkedin_url'       => ['nullable', 'url', 'max:255'],
        ], [
            'ga4_measurement_id.regex' => 'Measurement ID must look like G-XXXXXXX.',
            'whatsapp_number.regex'    => 'Enter a valid phone number in international format, e.g. +1 718 908 9464.',
            '*.url'                    => 'Please enter a full URL including https://',
        ]);

        // Only persist fields that are actually present, so saving one form
        // (e.g. GA4) does not wipe a value owned by another form.
        foreach (['ga4_measurement_id', 'ga4_property_id', 'whatsapp_number',
                  'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url'] as $key) {
            if ($request->has($key)) {
                SiteSetting::put($key, trim((string) $request->input($key)));
            }
        }

        return redirect(url('admin/integrations'))->with('success', 'Integration settings saved.');
    }
}
