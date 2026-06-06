<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class VisaController extends Controller
{
    public function index()
    {
    	$data['all_packages'] = Package::all();
        return view('visa', $data);
    }
}
