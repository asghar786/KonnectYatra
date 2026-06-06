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
            $file = $request->file('image');
            $fileName = uniqid() . $file->getClientOriginalName();
            $destinationPath = public_path('banners');
            $file->move($destinationPath, $fileName);
            $banner->image = $fileName;
            $banner->save();
        }

        return redirect(url('admin/page-banners'))->with('success', $banner->label . ' banner updated successfully!');
    }
}
