<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use Illuminate\Http\Request;

class PageBannerController extends Controller
{
    public function index()
    {
        $banners = PageBanner::orderBy('label')->get();
        return view('admin.banners.index', ['banners' => $banners]);
    }

    public function update(Request $request, $id)
    {
        $banner = PageBanner::findOrFail($id);

        if ($request->file('image')) {
            $banner->image = \App\Support\ImageHelper::save($request->file('image'), 'banners', ['width' => 1920, 'height' => 600, 'mode' => 'cover', 'quality' => 90]);
            $banner->save();
        }

        return redirect(url('admin/page-banners'))->with('success', $banner->label . ' banner updated successfully!');
    }
}
