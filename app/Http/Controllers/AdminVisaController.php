<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visa;
use App\Models\User;
use App\Models\Child;
use App\Models\Member;
use App\Models\Visit;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AdminVisaController extends Controller
{
    public function index()
    {
        $data = Visa::all();
        return view('admin.apply_visa',['visas'=>$data]);
    }

    public function delete($id)
    {
        $visa = Visa::WHERE('id','=',$id);
        if($visa)
        {
            $visa->delete();
            return back()->with("success", "Record Deleted Successfully");
        }
        else
        {
            return back()->with('error', "Record Not Found");
        }
    }

    public function showdata($id)
    {
        $dataid = Crypt::decrypt($id);
        $data = Visa::findorFail($dataid);
        $data2 = Child::WHERE('visa_id','=',$id)->get()->all();
        $data3 = Member::WHERE('visa_id','=',$id)->get()->all();
        $data4 = Visit::WHERE('visa_id','=',$id)->get()->all();
        $data5 = User::all();
        return view('admin.edit',['users'=>$data5,'visas'=>$data,'childs'=>$data2,'members'=>$data3,'visits'=>$data4]);
    }

    public function update(Request $request)
    {

        $visa = Visa::find($request->id);
        if($visa)
        {
            $this->validate($request,[
                'user_id',
                'child_id',
                'visa_type',
                'visit_purpose',
                'duration_stay',
                'visa_require',
                'visa_entry',
                'entry_port',
                'departure_port',
                'visit_place1',
                'visit_place2',
                'visit_place3',
                'visit_place4',
                'p_first_name',
                'p_middle_name',
                'p_last_name',
                'applicant_dob',
                'sex_type',
                'blood_group',
                'applicant_city',
                'applicant_state',
                'applicant_country',
                'martial_status',
                'applicant_religion',
                'identification_mark',
                'native_language',
                'pres_nationality',
                'prev_nationality',
                'dual_nationality',
                'passport_type',
                'issuing_authority',
                'passport_number',
                'place_issue',
                'doi',
                'doe',
                'abroad_address',
                'abroad_phone',
                'abroad_Work',
                'abroad_cell',
                'pak_address',
                'pak_home',
                'pak_work',
                'pak_cell',
                'sponserd',
                'sponser_name',
                'sponser_address',
                'sponser_contact',
                'profession_name',
                'profession_address',
                'profession_contact',
                'profession_email',
                'designation_name',
                'designation_department',
                'designation_duration',
                'designation_duties',
                'designation_address',
                'designation_phone',
                'apply_FTC',
                'img_residence',
                'mother_name',
                'mother_nationality',
                'father_name',
                'father_nationality',
                'spous_name',
                'spous_nationality',
                'spous_dob',
                'spous_pob',
                'spous_profession',
                'spous_contact',
                'children',
                'child_name',
                'child_dob',
                'travel_with',
                'TM_name',
                'TM_dob',
                'TM_passport',
                'TM_address',
                'bank_account',
                'bank_name',
                'bank_branch',
                'ac_number',
                'bank_Address',
                'visited_pakistan',
                'visit_date',
                'visit_designation',
                'visited_purpose',
                'visit_duration',
                'refusal',
                'refuse_entry',
                'refusal_message',
                'deported',
                'deport_date',
                'deport_country',
                'deport_reason',
                'deport_ref_no',
                'criminal_case',
                'crime_date',
                'crime_country',
                'crime_offence',
                'crime_Sentence',
                'apply_date',
                'signature',
            ]);


            if($file=$request->hasfile('img_residence'))
        {
            $file=$request->file('img_residence');
            $fileName=uniqid().$file->getClientOriginalName();
            $destinationPath=public_path().'/img_residence/';
            $file->move($destinationPath,$fileName);
            $request->image=$fileName;
        }

            // $visa->id=$request->id;
            $visa->user_id=$request->user_id;
            $visa->child_id=$request->child_id;
            $visa->visa_type=$request->visa_type;
            $visa->visit_purpose=$request->visit_purpose;
            $visa->duration_stay=$request->duration_stay;
            $visa->visa_require=$request->visa_require;
            $visa->visa_entry=$request->visa_entry;
            $visa->entry_port=$request->entry_port;
            $visa->departure_port=$request->departure_port;
            $visa->visit_place1=$request->visit_place1;
            $visa->visit_place2=$request->visit_place2;
            $visa->visit_place3=$request->visit_place3;
            $visa->visit_place4=$request->visit_place4;
            $visa->p_first_name=$request->p_first_name;
            $visa->p_middle_name=$request->p_middle_name;
            $visa->p_last_name=$request->p_last_name;
            $visa->applicant_dob=$request->applicant_dob;
            $visa->sex_type=$request->sex_type;
            $visa->blood_group=$request->blood_group;
            $visa->applicant_city=$request->applicant_city;
            $visa->applicant_state=$request->applicant_state;
            $visa->applicant_country=$request->applicant_country;
            $visa->martial_status=$request->martial_status;
            $visa->applicant_religion=$request->applicant_religion;
            $visa->identification_mark=$request->identification_mark;
            $visa->native_language=$request->native_language;
            $visa->pres_nationality=$request->pres_nationality;
            $visa->prev_nationality=$request->prev_nationality;
            $visa->dual_nationality=$request->dual_nationality;
            $visa->passport_type=$request->passport_type;
            $visa->issuing_authority=$request->issuing_authority;
            $visa->passport_number=$request->passport_number;
            $visa->place_issue=$request->place_issue;
            $visa->doi=$request->doi;
            $visa->doe=$request->doe;
            $visa->abroad_address=$request->abroad_address;
            $visa->abroad_phone=$request->abroad_phone;
            $visa->abroad_Work=$request->abroad_Work;
            $visa->abroad_cell=$request->abroad_cell;
            $visa->pak_address=$request->pak_address;
            $visa->pak_home=$request->pak_home;
            $visa->pak_work=$request->pak_work;
            $visa->pak_cell=$request->pak_cell;
            $visa->sponserd=$request->sponserd;
            $visa->sponser_name=$request->sponser_name;
            $visa->sponser_address=$request->sponser_address;
            $visa->sponser_contact=$request->sponser_contact;
            $visa->profession_name=$request->profession_name;
            $visa->profession_address=$request->profession_address;
            $visa->profession_contact=$request->profession_contact;
            $visa->profession_email=$request->profession_email;
            $visa->designation_name=$request->designation_name;
            $visa->designation_department=$request->designation_department;
            $visa->designation_duration=$request->designation_duration;
            $visa->designation_duties=$request->designation_duties;
            $visa->designation_address=$request->designation_address;
            $visa->designation_phone=$request->designation_phone;
            $visa->apply_FTC=$request->apply_FTC;
            $visa->img_residence=$request->img_residence;
            $visa->mother_name=$request->mother_name;
            $visa->mother_nationality=$request->mother_nationality;
            $visa->father_name=$request->father_name;
            $visa->father_nationality=$request->father_nationality;
            $visa->spous_name=$request->spous_name;
            $visa->spous_nationality=$request->spous_nationality;
            $visa->spous_dob=$request->spous_dob;
            $visa->spous_pob=$request->spous_pob;
            $visa->spous_profession=$request->spous_profession;
            $visa->spous_contact=$request->spous_contact;
            $visa->children=$request->children;
            $visa->travel_with=$request->travel_with;
            $visa->bank_account=$request->bank_account;
            $visa->bank_name=$request->bank_name;
            $visa->bank_branch=$request->bank_branch;
            $visa->ac_number=$request->ac_number;
            $visa->bank_Address=$request->bank_Address;
            $visa->visited_pakistan=$request->visited_pakistan;
            $visa->refusal=$request->refusal;
            $visa->refuse_entry=$request->refuse_entry;
            $visa->refusal_message=$request->refusal_message;
            $visa->deported=$request->deported;
            $visa->deport_date=$request->deport_date;
            $visa->deport_country=$request->deport_country;
            $visa->deport_reason=$request->deport_reason;
            $visa->deport_ref_no=$request->deport_ref_no;
            $visa->criminal_case=$request->criminal_case;
            $visa->crime_date=$request->crime_date;
            $visa->crime_country=$request->crime_country;
            $visa->crime_offence=$request->crime_offence;
            $visa->crime_Sentence=$request->crime_Sentence;
            $visa->apply_date=$request->apply_date;
            $visa->signature=$request->signature;
            if($request->child_name && $request->child_dob)
            {
                for($i = 0; $i < count($request->child_name) && ($request->child_dob); $i++)
                {
                    $child[] = [
                        'visa_id' => $visa->id,
                        'child_name' => $request->child_name[$i],
                        'child_dob' => $request->child_dob[$i],
                    ];

                }
                Child::insert($child);
            }
            
            if($request->TM_name && $request->TM_dob && $request->TM_passport && $request->TM_address)
            {
                for($i = 0; $i < count($request->TM_name) && ($request->TM_dob) && ($request->TM_passport) && ($request->TM_address); $i++)
                {
                    $member[] =[
                        'visa_id' => $visa->id,
                        'TM_name' => $request->TM_name[$i],
                        'TM_dob' => $request->TM_dob[$i],
                        'TM_passport' => $request->TM_passport[$i],
                        'TM_address' => $request->TM_address[$i],
                    ];
                }
                Member::insert($member);
            }
            if($request->visit_date && $request->visit_designation && $request->visited_purpose && $request->visit_duration)
            {
                for($i = 0; $i < count($request->visit_date) && ($request->visit_designation) && ($request->visited_purpose) && ($request->visit_duration); $i++)
                {
                    $visit[] =[
                        'visa_id' => $visa->id,
                        'visit_date' => $request->visit_date[$i],
                        'visit_designation' => $request->visit_designation[$i],
                        'visited_purpose' => $request->visited_purpose[$i],
                        'visit_duration' => $request->visit_duration[$i],
                    ];
                }
                Visit::insert($visit);
            }

            $visa->update();
            return redirect('admin/apply_visa')->with('success','Record Updated Successfuly');
        }
    }
}
