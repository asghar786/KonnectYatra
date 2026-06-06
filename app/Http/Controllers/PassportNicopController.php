<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passport;
class PassportNicopController extends Controller
{
    public function index()
    {
        return view('admin.passport_nicop');
    }

    public function store(Request $req){

        Passport::create([
            'firstname'=>$req->fname,
            'middlename'=>$req->mname,
            'lastname'=>$req->lname,
            'city'=>$req->city,
            'address'=>$req->address,
            'apt'=>$req->apt,
            'email'=>$req->email,
            'phonenumber'=>$req->phonenumber,
            'zipcode'=>$req->zipcode,
            'dob'=>$req->dob,
            'state'=>$req->state,
            'gender'=>$req->gender,
            'notes'=>$req->notes,
            'passportnumber'=>$req->passportnumber,
            'pdoi'=>$req->pdoi,
            'pdoe'=>$req->pdoe,
            'issuedate'=>$req->issuedate,
            'expiredate'=>$req->expiredate,
            'nicpnumber'=>$req->nicpnumber,
            'nicopnumber'=>$req->nicopnumber,
        ]);
        return back()->with('success',' Passport Added Successfully');
    }
}
