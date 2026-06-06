<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('adminauth.admin_login');
    }

    public function store(Request $request)
    {
    
        $this->validate($request,[
        'email' => ['required', 'string', 'email'],
        'password' => ['required'],
    ]);

    // dd(auth()->user());
    if(!auth()->attempt($request->only('email','password'), $request->remember))
        {
            return back()->with('status','These credentials do not match our records.');
        }
        else {
            return redirect('admin/dashboard');
        }
    }
}
