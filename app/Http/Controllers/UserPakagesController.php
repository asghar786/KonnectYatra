<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visa;
use App\Models\YatriVisa;
use App\Models\User;
class UserPakagesController extends Controller
{
    public function index()
    {
        return view('users.user_packages');
    }

    public function yatri_list()
    {
    	$data['yatries'] = YatriVisa::with("passenger", "package", "gurdwara", "hotel", "bus")->where("user_id", \Auth::user()->id)->get();
    	$data['user'] = User::where("id", \Auth::user()->id)->first();
        return view('users.yatri-list', $data);
    }

    public function add_booking()
    {
    	$data['yatries'] = YatriVisa::where("user_id", \Auth::user()->id)->get();
    	$data['user'] = User::where("id", \Auth::user()->id)->first();
        return view('users.add-booking', $data);
    }

    public function bookings()
    {
        $data['yatries'] = YatriVisa::where("user_id", \Auth::user()->id)->get();
        $data['user'] = User::where("id", \Auth::user()->id)->first();
        return view('users.bookings', $data);
    }

    public function profile(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if (!empty($data['password'])) {
                $data['password'] = \Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $Obj = User::find(\Auth::user()->id);
            $Obj->update($data);
            return redirect(url('user/profile'))->withSuccess("Profile is updated sucessfully.");
        }

        $data["user"] = User::where('id', \Auth::user()->id)->first();
        return view('users.profile', $data);
    }
}
