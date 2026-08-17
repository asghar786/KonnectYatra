<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\Business;
use App\Support\ImageHelper;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        // Pre-fill every day so the form always shows seven rows, keeping any
        // hours already saved.
        $saved = collect(Business::hours())->keyBy('day');

        // get() rather than [$day] — Collection::offsetGet() warns on a missing
        // key, and on a fresh install all seven days are missing.
        $hours = collect(Business::DAYS)->map(function ($day) use ($saved) {
            $row = $saved->get($day, []);

            return [
                'day'    => $day,
                'open'   => $row['open']  ?? '09:00',
                'close'  => $row['close'] ?? '18:00',
                'closed' => (bool) ($row['closed'] ?? false),
            ];
        })->all();

        return view('admin.seo.index', [
            'seo_title'       => SiteSetting::get('seo_title'),
            'seo_description' => SiteSetting::get('seo_description'),
            'seo_keywords'    => SiteSetting::get('seo_keywords'),
            'seo_og_image'    => SiteSetting::get('seo_og_image'),

            'biz'             => Business::address(),
            'biz_phone'       => Business::phone(),
            'biz_email'       => Business::email(),
            'biz_geo'         => Business::geo(),
            'biz_price_range' => Business::priceRange(),
            'biz_hours'       => $hours,
            'biz_hours_set'   => (bool) Business::hours(),
            'biz_sameas'      => Business::raw('sameas_extra'),
            'biz_sameas_live' => Business::sameAs(),
            'biz_address_line'=> Business::addressLine(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'seo_title'       => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_keywords'    => ['nullable', 'string', 'max:500'],
            'og_image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        SiteSetting::put('seo_title', trim((string) $request->input('seo_title')));
        SiteSetting::put('seo_description', trim((string) $request->input('seo_description')));
        SiteSetting::put('seo_keywords', trim((string) $request->input('seo_keywords')));

        if ($request->file('og_image')) {
            $name = ImageHelper::save($request->file('og_image'), 'seo', ['width' => 1200, 'height' => 630, 'mode' => 'cover', 'quality' => 90]);
            SiteSetting::put('seo_og_image', 'seo/' . $name);
        }

        return redirect(url('admin/seo'))->with('success', 'SEO settings saved.');
    }

    /**
     * Business details — the address, phone, map position and opening hours that
     * feed both the visible pages and the Schema.org markup.
     */
    public function updateBusiness(Request $request)
    {
        $request->validate([
            'street'        => ['nullable', 'string', 'max:255'],
            'locality'      => ['nullable', 'string', 'max:120'],
            'region'        => ['nullable', 'string', 'max:120'],
            'postal'        => ['nullable', 'string', 'max:20'],
            'country'       => ['nullable', 'string', 'max:2'],
            'telephone'     => ['nullable', 'string', 'max:60'],
            'email'         => ['nullable', 'email', 'max:120'],
            'lat'           => ['nullable', 'numeric', 'between:-90,90'],
            'lng'           => ['nullable', 'numeric', 'between:-180,180'],
            'price_range'   => ['nullable', 'in:$,$$,$$$,$$$$'],
            'sameas_extra'  => ['nullable', 'string', 'max:2000'],
            'hours'         => ['nullable', 'array'],
            'hours.*.open'  => ['nullable', 'date_format:H:i'],
            'hours.*.close' => ['nullable', 'date_format:H:i'],
        ], [
            'lat.between'         => 'Latitude must be between -90 and 90. Copy it from the Google Maps pin.',
            'lng.between'         => 'Longitude must be between -180 and 180. Copy it from the Google Maps pin.',
            'hours.*.open.date_format'  => 'Opening times must look like 09:00.',
            'hours.*.close.date_format' => 'Closing times must look like 18:00.',
        ]);

        foreach (['street', 'locality', 'region', 'postal', 'telephone', 'email', 'price_range', 'sameas_extra'] as $key) {
            SiteSetting::put('biz_' . $key, trim((string) $request->input($key)));
        }

        SiteSetting::put('biz_country', strtoupper(trim((string) $request->input('country', 'US'))));

        // Both or neither: a lone latitude is not a location.
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        if ($lat === null || $lat === '' || $lng === null || $lng === '') {
            SiteSetting::put('biz_lat', '');
            SiteSetting::put('biz_lng', '');
        } else {
            SiteSetting::put('biz_lat', (string) $lat);
            SiteSetting::put('biz_lng', (string) $lng);
        }

        $rows = [];

        foreach (Business::DAYS as $day) {
            $row    = $request->input('hours.' . $day, []);
            $closed = !empty($row['closed']);
            $open   = trim((string) ($row['open'] ?? ''));
            $close  = trim((string) ($row['close'] ?? ''));

            // A day with no times is the same as no information about that day.
            if (!$closed && ($open === '' || $close === '')) {
                continue;
            }

            $rows[] = ['day' => $day, 'open' => $open, 'close' => $close, 'closed' => $closed];
        }

        // Only publish hours once at least one day is actually open — a week of
        // "closed" would tell Google the business never opens.
        $anyOpen = collect($rows)->contains(fn ($r) => !$r['closed']);

        SiteSetting::put('biz_hours', $anyOpen ? json_encode($rows) : '');

        return redirect(url('admin/seo') . '#business')
            ->with('success', 'Business details saved. They now appear on the site and in your Schema.org markup.');
    }
}
