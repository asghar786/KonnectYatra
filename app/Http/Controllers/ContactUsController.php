<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
    	if ($request->isMethod('post')) {
            $data = $request->all();
            $Obj = new ContactUs;
            $Obj->name = $data['name'];
            $Obj->email = $data['email'];
            $Obj->phone = $data['phone'];
            $Obj->subject = $data['subject'];
            $Obj->message = $data['message'];
            $Obj->save();

            $res_data = ContactUs::where('id', $Obj->id)->first();
            \Mail::to('konnectus.inc@gmail.com')->send(new \App\Mail\ContactUsMail($res_data));

            $response = array('status'=>'1','message'=>'Thank you for contacting us!.');
            echo json_encode($response); return;
        }

    	$data['all_packages'] = Package::all();
        return view('contactus', $data);
    }
}
