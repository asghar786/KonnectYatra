<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class CreateStudentController extends Controller
{
    public function index(){
        return view('admin.create_student');
    }
    public function store(Request $req){
     
        $student =new Student();
        if($req->file('file')){
            $file=$req->file('file');
            $filename=$file->getClientOriginalName();
            $file->storeAs('uploads', $filename);
        }
        
        $student->create([
                'firstname'=>$req->fname,
                'middlename'=>$req->mname,
                'lastname'=>$req->lname,
                'city'=>$req->city,
                'address1'=>$req->address1,
                'address2'=>$req->address2,
                'email'=>$req->email,
                'phonenumber'=>$req->phonenumber,
                'zipcode'=>$req->zipcode,
                'dob'=>$req->dob,
                'state'=>$req->state,
                'gender'=>$req->gender,
                'notes'=>$req->notes,
                'drivinglicensenumber'=>$req->driverlicensenumber,
                'class'=>$req->class,
                'check'=>$req->check,
                'issuedate'=>$req->issuedate,
                'coursecompletiondate'=>$req->completiondate,
                'scheduledate'=>$req->scheduledate,
                'file'=>$filename,
              
        ]);
        return redirect('admin/students')->with('success',' Student Created Successfully');
    }
}
