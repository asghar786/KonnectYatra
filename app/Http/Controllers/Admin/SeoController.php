<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\ImageHelper;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        return view('admin.seo.index', [
            'seo_title'       => SiteSetting::get('seo_title'),
            'seo_description' => SiteSetting::get('seo_description'),
            'seo_keywords'    => SiteSetting::get('seo_keywords'),
            'seo_og_image'    => SiteSetting::get('seo_og_image'),
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
}
