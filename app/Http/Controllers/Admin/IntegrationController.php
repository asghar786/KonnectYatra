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
            'google_site_verification' => SiteSetting::get('google_site_verification'),
            'clarity_project_id'       => SiteSetting::get('clarity_project_id'),
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
            'google_site_verification' => ['nullable', 'string', 'max:255'],
            'clarity_project_id'       => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-z0-9]+$/'],
        ], [
            'ga4_measurement_id.regex' => 'Measurement ID must look like G-XXXXXXX.',
            'whatsapp_number.regex'    => 'Enter a valid phone number in international format, e.g. +1 718 908 9464.',
            '*.url'                    => 'Please enter a full URL including https://',
            'clarity_project_id.regex' => 'The Clarity Project ID is letters and numbers only (e.g. abcdef1234).',
        ]);

        // Only persist fields that are actually present, so saving one form
        // (e.g. GA4) does not wipe a value owned by another form.
        foreach (['ga4_measurement_id', 'ga4_property_id', 'whatsapp_number',
                  'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url',
                  'google_site_verification', 'clarity_project_id'] as $key) {
            if ($request->has($key)) {
                SiteSetting::put($key, trim((string) $request->input($key)));
            }
        }

        return redirect(url('admin/integrations'))->with('success', 'Integration settings saved.');
    }
}
