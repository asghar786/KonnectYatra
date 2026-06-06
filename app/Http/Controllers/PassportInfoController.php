<?php

namespace App\Http\Controllers;
use App\Models\Passport;
use Illuminate\Http\Request;

class PassportInfoController extends Controller
{
    public function index()
    {
        $data = Passport::paginate(10);
        return view('admin.passportinfo',['passports'=>$data]);
    }

    public function showdata($id)
    {
        $passport_data = Passport::where('id', '=', $id)->get();
        return view('admin.passportedit',['passports'=>$passport_data]);
    }

    public function update(Request $req)
    {
        $passport=Passport::find($req->id);
            $passport->firstname=$req->fname;
            $passport->middlename=$req->middlename;
            $passport->lastname=$req->lname;
            $passport->city=$req->city;
            $passport->address=$req->address;
            $passport->apt=$req->apt;
            $passport->email=$req->email;
            $passport->phonenumber=$req->phonenumber;
            $passport->zipcode=$req->zipcode;
            $passport->dob=$req->dob;
            $passport->zipcode=$req->zipcode;
            $passport->state=$req->state;
            $passport->gender=$req->gender;
            $passport->notes=$req->notes;
            $passport->passportnumber=$req->passportnumber;
            $passport->pdoi=$req->pdoi;
            $passport->pdoe=$req->pdoe;
            $passport->issuedate=$req->issuedate;
            $passport->expiredate=$req->expiredate;
            $passport->nicpnumber=$req->nicpnumber;
            $passport->nicopnumber=$req->nicopnumber;
            $passport->save();
         return redirect('admin/passportinfo')->with('success', "Record Updated Successfully");
    }

    public function delete($id)
    {
        $passport = Passport::where('id', '=', $id);
        if($passport)
        {
            $passport->delete();
            return redirect('admin/passportinfo')->with('success', "Record Deleted Successfully");
        }
        else
        {
            return back()->with('error', "Record Not Found");
        }
    }

}
