<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Gurdwara;
use App\Models\Country;
use App\Models\YatriVisa;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('users.user_dashboard');
    }

    public function package(Request $request, $id)
    {
        $data['all_packages'] = Package::all();
        $data['id'] = $id;
        $data['packages'] = Package::where("id", $id)->first();
        return view('users.forms.package', $data);
    }

    public function all_package(Request $request)
    {
        $data['all_packages'] = Package::where('status', 1)->get();
        return view('users.forms.all_package', $data);
    }

    public function package_apply($id)
    {
        $data['all_packages'] = Package::all();
        $data['id'] = $id;
        $data['packages'] = Package::where("id", $id)->first();
        $data['gurdwaras'] = Gurdwara::all();
        $data['countries'] = Country::all();
        return view('users.forms.package-apply', $data);
    }

    public function payment(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $payment_type = $request->payment_type;
            $routing_number = $request->routing_number;
            $account_number = $request->account_number;
            $amount = $request->amount;
            if ($payment_type == "Wire Transfer") {
                $data = ["payment_type" => $payment_type, "routing_number" => $routing_number, "account_number" => $account_number, "amount" => $amount, "payment_status" => "paid"];
                YatriVisa::where("id", $id)->update($data);
            } else {
                if ($request->file('receipt')) {   
                    $file = $request->file('receipt');
                    $fileName = uniqid().$file->getClientOriginalName();
                    $destinationPath = public_path('bank_receipt');
                    $file->move($destinationPath,$fileName);
                    $receipt = $fileName;
                }
                $data = ["payment_type" => $payment_type, "payment_status" => "paid", "bank_receipt" => $receipt];
                YatriVisa::where("id", $id)->update($data);
            }

            return redirect(url("user/thank-you"));
        }

        $data['all_packages'] = Package::all();
        $data['id'] = $id;
        if (!empty($request->status)) {
            $data['status'] = $request->status;
        }
        return view('users.payment', $data);
    }

    public function store_yatri_visa(Request $request)
    {
        $total_count = YatriVisa::where("state", $request->state)->count();
        $total_count = $total_count + $total_child_count + 1;

        $package = Package::where("id", $request->package_id)->first();

        $yatri_visa = new YatriVisa();
        $photo = null;
        if($request->file('photo'))
        {
            
            $file = $request->file('photo');
            $fileName = uniqid().$file->getClientOriginalName();
            $destinationPath = public_path('photo_uploads');
            $file->move($destinationPath,$fileName);
            $photo = $fileName;
        }
        $passport = null;
        if($request->file('us_passport'))
        {
            
            $file = $request->file('us_passport');
            $fileName = uniqid().$file->getClientOriginalName();
            $destinationPath = public_path('passport_uploads');
            $file->move($destinationPath,$fileName);
            $passport = $fileName;
        }
        $greencard = null;
        if($request->file('green_card'))
        {
            
            $file = $request->file('green_card');
            $fileName = uniqid().$file->getClientOriginalName();
            $destinationPath = public_path('greencard_uploads');
            $file->move($destinationPath,$fileName);
            $greencard = $fileName;
        }
        $drivinglicense = null;
        if($request->file('driving_license'))
        {
            
            $file = $request->file('driving_license');
            $fileName = uniqid().$file->getClientOriginalName();
            $destinationPath = public_path('drivinglicense_uploads');
            $file->move($destinationPath,$fileName);
            $drivinglicense = $fileName;
        }
        $yatri_visa->user_id = \Auth::user()->id;
        $yatri_visa->package_id = $request->package_id;
        $yatri_visa->yatri_id = $request->state."-00".$total_count;
        $yatri_visa->package_type = $request->package_type;
        $yatri_visa->ticket_type = $request->ticket_type;
        $yatri_visa->passport = $request->passport;
        $yatri_visa->passport_type = $request->passport_type;
        $yatri_visa->issuing_authority = $request->issuing_authority;
        $yatri_visa->passport_country = $request->passport_country;
        $yatri_visa->issue_date = $request->issue_date;
        $yatri_visa->expiry_date = $request->expiry_date;
        if (!empty($request->reference_no)) {
            $yatri_visa->reference_no = $request->reference_no;
        }
        if (!empty($request->residence_country)) {
            $yatri_visa->residence_country = $request->residence_country;
        }
        if (!empty($request->green_card_expiry_date)) {
            $yatri_visa->green_card_expiry_date = $request->green_card_expiry_date;
        }
        $yatri_visa->first_name = $request->first_name;
        $yatri_visa->middle_name = $request->middle_name;
        $yatri_visa->last_name = $request->last_name;
        $yatri_visa->dob = $request->dob;
        $yatri_visa->place_birth = $request->place_birth;
        $yatri_visa->marital_status = $request->marital_status;
        $yatri_visa->gender = $request->gender;
        $yatri_visa->religion = $request->religion;
        $yatri_visa->email = $request->email;
        $yatri_visa->other_email = $request->other_email;
        $yatri_visa->phone = $request->phone;
        $yatri_visa->other_phone = $request->other_phone;
        $yatri_visa->father_name = $request->father_name;
        $yatri_visa->father_nationality = $request->father_nationality;
        $yatri_visa->mother_name = $request->mother_name;
        $yatri_visa->mother_nationality = $request->mother_nationality;
        if (!empty($request->have_spouse)) {
            $yatri_visa->have_spouse = $request->have_spouse;
            $yatri_visa->spouse_name = $request->spouse_name;
            $yatri_visa->spouse_birth_country = $request->spouse_birth_country;
            $yatri_visa->spouse_nationality = $request->spouse_nationality;
        }
        $yatri_visa->profession = $request->profession;
        $yatri_visa->travel_history = $request->travel_history;
        $yatri_visa->pk_travel_history = @$request->pk_travel_history;
        $yatri_visa->gurdwara_id = $request->gurdwara_id;
        $yatri_visa->gurdwara_name = $request->gurdwara_name;
        $yatri_visa->address = $request->address;
        $yatri_visa->city = $request->city;
        $yatri_visa->state = $request->state;
        $yatri_visa->zip = $request->zip;
        $yatri_visa->secretary_phone = $request->secretary_phone;
        $yatri_visa->secetary_name = $request->secetary_name;
        $yatri_visa->reference_name = $request->reference_name;
        $yatri_visa->reference_phone = $request->reference_phone;
        $yatri_visa->photo = $photo;
        $yatri_visa->us_passport = $passport;
        $yatri_visa->green_card = $greencard;
        $yatri_visa->driving_license = $drivinglicense;
        $yatri_visa->payment_status = "pending";
        $yatri_visa->save();

        return redirect(url("user/all-packages/payment", $yatri_visa->id));
    }

    public function thank_you()
    {
        return view('users.thank-you');
    }
}
