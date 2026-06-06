<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\News;

class AboutUsController extends Controller
{
    public function index()
    {
    	$data['all_packages'] = Package::all();
    	$data['news'] = News::all();
        return view('aboutus', $data);
    }
}
