<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visa;
use App\Models\User;
use App\Models\Child;
use App\Models\Member;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class UserVisaController extends Controller
{
    public function index()
    {
        $user_id= DB::table('users')
        ->select('id')
        ->where('role', '=', 'user')
        ->get();
        $child_data = Child::all();
        return view('users.user_visa',['users'=>$user_id],['childs'=>$child_data]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // return $request;
        // exit;
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

        $visa = new Visa();

        $visa->fill([
            'user_id'=>$request->user_id,
            'child_id'=>$request->child_id,
            'visa_type'=>$request->visa_type,
            'visit_purpose'=>$request->visit_purpose,
            'duration_stay'=>$request->duration_stay,
            'visa_require'=>$request->visa_require,
            'visa_entry'=>$request->visa_entry,
            'entry_port'=>$request->entry_port,
            'departure_port'=>$request->departure_port,
            'visit_place1'=>$request->visit_place1,
            'visit_place2'=>$request->visit_place2,
            'visit_place3'=>$request->visit_place3,
            'visit_place4'=>$request->visit_place4,
            'p_first_name'=>$request->p_first_name,
            'p_middle_name'=>$request->p_middle_name,
            'p_last_name'=>$request->p_last_name,
            'applicant_dob'=>$request->applicant_dob,
            'sex_type'=>$request->sex_type,
            'blood_group'=>$request->blood_group,
            'applicant_city'=>$request->applicant_city,
            'applicant_state'=>$request->applicant_state,
            'applicant_country'=>$request->applicant_country,
            'martial_status'=>$request->martial_status,
            'applicant_religion'=>$request->applicant_religion,
            'identification_mark'=>$request->identification_mark,
            'native_language'=>$request->native_language,
            'pres_nationality'=>$request->pres_nationality,
            'prev_nationality'=>$request->prev_nationality,
            'dual_nationality'=>$request->dual_nationality,
            'passport_type'=>$request->passport_type,
            'issuing_authority'=>$request->issuing_authority,
            'passport_number'=>$request->passport_number,
            'place_issue'=>$request->place_issue,
            'doi'=>$request->doi,
            'doe'=>$request->doe,
            'abroad_address'=>$request->abroad_address,
            'abroad_phone'=>$request->abroad_phone,
            'abroad_Work'=>$request->abroad_Work,
            'abroad_cell'=>$request->abroad_cell,
            'pak_address'=>$request->pak_address,
            'pak_home'=>$request->pak_home,
            'pak_work'=>$request->pak_work,
            'pak_cell'=>$request->pak_cell,
            'sponserd'=>$request->sponserd,
            'sponser_name'=>$request->sponser_name,
            'sponser_address'=>$request->sponser_address,
            'sponser_contact'=>$request->sponser_contact,
            'profession_name'=>$request->profession_name,
            'profession_address'=>$request->profession_address,
            'profession_contact'=>$request->profession_contact,
            'profession_email'=>$request->profession_email,
            'designation_name'=>$request->designation_name,
            'designation_department'=>$request->designation_department,
            'designation_duration'=>$request->designation_duration,
            'designation_duties'=>$request->designation_duties,
            'designation_address'=>$request->designation_address,
            'designation_phone'=>$request->designation_phone,
            'apply_FTC'=>$request->apply_FTC,
            'img_residence'=>$request->img_residence,
            'mother_name'=>$request->mother_name,
            'mother_nationality'=>$request->mother_nationality,
            'father_name'=>$request->father_name,
            'father_nationality'=>$request->father_nationality,
            'spous_name'=>$request->spous_name,
            'spous_nationality'=>$request->spous_nationality,
            'spous_dob'=>$request->spous_dob,
            'spous_pob'=>$request->spous_pob,
            'spous_profession'=>$request->spous_profession,
            'spous_contact'=>$request->spous_contact,
            'children'=>$request->children,
            'travel_with'=>$request->travel_with,
            'bank_account'=>$request->bank_account,
            'bank_name'=>$request->bank_name,
            'bank_branch'=>$request->bank_branch,
            'ac_number'=>$request->ac_number,
            'bank_Address'=>$request->bank_Address,
            'visited_pakistan'=>$request->visited_pakistan,
            'refusal'=>$request->refusal,
            'refuse_entry'=>$request->refuse_entry,
            'refusal_message'=>$request->refusal_message,
            'deported'=>$request->deported,
            'deport_date'=>$request->deport_date,
            'deport_country'=>$request->deport_country,
            'deport_reason'=>$request->deport_reason,
            'deport_ref_no'=>$request->deport_ref_no,
            'criminal_case'=>$request->criminal_case,
            'crime_date'=>$request->crime_date,
            'crime_country'=>$request->crime_country,
            'crime_offence'=>$request->crime_offence,
            'crime_Sentence'=>$request->crime_Sentence,
            'apply_date'=>$request->apply_date,
            'signature'=>$request->signature,
        ]);
        $visa_id= $visa->save();

// $childern=[];
        for($i = 0; $i < count($request->child_name) && ($request->child_dob); $i++)
        {
            $child[] = [
                'visa_id' => $visa->id,
                'child_name' => $request->child_name[$i],
                'child_dob' => $request->child_dob[$i],
            ];
           // $chd=DB::insert('insert into child (child_name,child_dob) values (?, ?)', [$request->child_name[$i], $request->child_dob[$i]]);
            // array_push($childern,$chd);
        }
        Child::insert($child);

        // dd($childern);

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

        return back()->with('status','Visa Applied Successfuly');
    }
}
