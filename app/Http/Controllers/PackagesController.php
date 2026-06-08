<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Gurdwara;
use App\Models\YatriVisa;
use App\Models\Country;
use App\Models\Season;
use App\Models\Hotels;
use App\Models\Events;
use App\Models\Locations;
use App\Models\News;
use App\Models\InitialInfo;
use App\Models\Conversion;
use Illuminate\Support\Facades\Cookie;

class PackagesController extends Controller
{
    public function index($id)
    {
        $data['packages'] = Package::where("id", $id)->first();
        $data['all_packages'] = Package::all();
        return view('packages', $data);
    }

    public function package(Request $request, $id)
    {
        $data['all_packages'] = Package::all();
        $data['id'] = $id;
        $data['packages'] = Package::where("id", $id)->first();
        return view('forms.package', $data);
    }
    
    public function specialPackage(Request $request)
    {
        $data['all_packages'] = Package::all();
        
        return view('forms.special-land-package', $data);
    }
    
    public function save_initial_info(Request $request)
    {
        $info = new InitialInfo;
        $info->total_persons = $request->total_persons;
        $info->package_type = $request->package_type;
        $info->added_days = json_encode($request->days);
        $info->total_price = $request->total_price;
        $info->save();
        
        return redirect(url('/special-package/'.$info->id.'/apply'));
    }
    
    public function bookSpecialPackage(Request $request, $id)
    {
        $data['all_packages'] = Package::all();
        $data['id'] = $id;
        $data['initial_info'] = InitialInfo::where("id", $id)->first();
        $data['gurdwaras'] = Gurdwara::all();
        $data['countries'] = Country::all();
        
        return view('forms.special-land-package-apply', $data);
    }

    public function all_package(Request $request)
    {
        $data['all_packages'] = Package::where('package_type', 'Vaisakhi')->get();
        $data['all_packages1'] = Package::where('package_type', 'Gurpurab')->get();
        $data['all_packages2'] = Package::where('package_type', 'VIP')->get();
        return view('forms.all_package', $data);
    }

    public function save_info(Request $request)
    {
        if ($request->type == "next1") {
            if (!empty($request->package_type)) {
                Cookie::queue(Cookie::make("package_type", $request->package_type, 43200));
            }
            if (!empty($request->passport)) {
                Cookie::queue(Cookie::make("passport", $request->passport, 43200));
            }
            if (!empty($request->issuing_authority)) {
                Cookie::queue(Cookie::make("issuing_authority", $request->issuing_authority, 43200));
            }
            if (!empty($request->passport_country)) {
                Cookie::queue(Cookie::make("passport_country", $request->passport_country, 43200));
            }
            if (!empty($request->issue_date)) {
                Cookie::queue(Cookie::make("issue_date", $request->issue_date, 43200));
            }
            if (!empty($request->expiry_date)) {
                Cookie::queue(Cookie::make("expiry_date", $request->expiry_date, 43200));
            }
            if (!empty($request->reference_no)) {
                Cookie::queue(Cookie::make("reference_no", $request->reference_no, 43200));
            }
            if (!empty($request->permanent_residence_country)) {
                Cookie::queue(Cookie::make("permanent_residence_country", $request->permanent_residence_country, 43200));
            }
            if (!empty($request->green_card_expiry_date)) {
                Cookie::queue(Cookie::make("green_card_expiry_date", $request->green_card_expiry_date, 43200));
            }
        } else if ($request->type == "next2") {
            Cookie::queue(Cookie::make("next2", "true", 43200));
            if (!empty($request->first_name)) {
                Cookie::queue(Cookie::make("first_name", $request->first_name, 43200));
            }
            if (!empty($request->middle_name)) {
                Cookie::queue(Cookie::make("middle_name", $request->middle_name, 43200));
            }
            if (!empty($request->last_name)) {
                Cookie::queue(Cookie::make("last_name", $request->last_name, 43200));
            }
            if (!empty($request->dob)) {
                Cookie::queue(Cookie::make("dob", $request->dob, 43200));
            }
            if (!empty($request->place_birth)) {
                Cookie::queue(Cookie::make("place_birth", $request->place_birth, 43200));
            }
            if (!empty($request->marital_status)) {
                Cookie::queue(Cookie::make("marital_status", $request->marital_status, 43200));
            }
            if (!empty($request->gender)) {
                Cookie::queue(Cookie::make("gender", $request->gender, 43200));
            }
            if (!empty($request->religion)) {
                Cookie::queue(Cookie::make("religion", $request->religion, 43200));
            }
            if (!empty($request->email)) {
                Cookie::queue(Cookie::make("email", $request->email, 43200));
            }
            if (!empty($request->other_email)) {
                Cookie::queue(Cookie::make("other_email", $request->other_email, 43200));
            }
            if (!empty($request->phone)) {
                Cookie::queue(Cookie::make("phone", $request->phone, 43200));
            }
            if (!empty($request->other_phone)) {
                Cookie::queue(Cookie::make("other_phone", $request->other_phone, 43200));
            }
        } else if ($request->type == "next3") {
            Cookie::queue(Cookie::make("next3", "true", 43200));
            if (!empty($request->father_name)) {
                Cookie::queue(Cookie::make("father_name", $request->father_name, 43200));
            }
            if (!empty($request->father_nationality)) {
                Cookie::queue(Cookie::make("father_nationality", $request->father_nationality, 43200));
            }
            if (!empty($request->mother_name)) {
                Cookie::queue(Cookie::make("mother_name", $request->mother_name, 43200));
            }
            if (!empty($request->mother_nationality)) {
                Cookie::queue(Cookie::make("mother_nationality", $request->mother_nationality, 43200));
            }
            if (!empty($request->have_spouse)) {
                Cookie::queue(Cookie::make("have_spouse", $request->have_spouse, 43200));
            }
            if (!empty($request->spouse_name)) {
                Cookie::queue(Cookie::make("spouse_name", $request->spouse_name, 43200));
            }
            if (!empty($request->spouse_birth_country)) {
                Cookie::queue(Cookie::make("spouse_birth_country", $request->spouse_birth_country, 43200));
            }
            if (!empty($request->spouse_nationality)) {
                Cookie::queue(Cookie::make("spouse_nationality", $request->spouse_nationality, 43200));
            }
        } else if ($request->type == "next4") {
            Cookie::queue(Cookie::make("next4", "true", 43200));
            if (!empty($request->profession)) {
                Cookie::queue(Cookie::make("profession", $request->profession, 43200));
            }
            if (!empty($request->travel_history)) {
                Cookie::queue(Cookie::make("travel_history", $request->travel_history, 43200));
            }
            if (!empty($request->pk_travel_history)) {
                Cookie::queue(Cookie::make("pk_travel_history", $request->pk_travel_history, 43200));
            }
        } else if ($request->type == "next5") {
            Cookie::queue(Cookie::make("next5", "true", 43200));
            if (!empty($request->gurdwara_name)) {
                Cookie::queue(Cookie::make("gurdwara_name", $request->gurdwara_name, 43200));
            }
            if (!empty($request->address)) {
                Cookie::queue(Cookie::make("address", $request->address, 43200));
            }
            if (!empty($request->city)) {
                Cookie::queue(Cookie::make("city", $request->city, 43200));
            }
            if (!empty($request->state)) {
                Cookie::queue(Cookie::make("state", $request->state, 43200));
            }
            if (!empty($request->zip)) {
                Cookie::queue(Cookie::make("zip", $request->zip, 43200));
            }
            if (!empty($request->secetary_name)) {
                Cookie::queue(Cookie::make("secetary_name", $request->secetary_name, 43200));
            }
            if (!empty($request->secretary_phone)) {
                Cookie::queue(Cookie::make("secretary_phone", $request->secretary_phone, 43200));
            }
            if (!empty($request->reference_name)) {
                Cookie::queue(Cookie::make("reference_name", $request->reference_name, 43200));
            }
            if (!empty($request->reference_phone)) {
                Cookie::queue(Cookie::make("reference_phone", $request->reference_phone, 43200));
            }
        }

        return json_encode(['flag' => true, 'msg' => 'Successfully saved!']);
    }

    public function hotel_detail($id)
    {
        $data['hotel'] = Hotels::with('images')->where("id", $id)->first();
        return view('details.hotel_detail', $data);
    }

    public function location_detail($id)
    {
        $data['location'] = Locations::with('images')->where("id", $id)->first();
        return view('details.location_detail', $data);
    }

    public function event_detail($id)
    {
        $data['event'] = Events::where("id", $id)->first();
        return view('details.event_detail', $data);
    }

    public function news_detail($id)
    {
        $data['news'] = News::where("id", $id)->first();
        return view('details.news_detail', $data);
    }

    public function package_apply(Request $request, $id)
    {
        $data['all_packages'] = Package::all();
        $data['id'] = $id;
        $data['packages'] = Package::where("id", $id)->first();
        $data['gurdwaras'] = Gurdwara::all();
        $data['countries'] = Country::all();
        $cookie = [];
        if (Cookie::has("package_type")) {
            $cookie["package_type"] = Cookie::get("package_type");
        }
        if (Cookie::has("passport")) {
            $cookie['passport'] = Cookie::get("passport");
        }
        if (Cookie::has("issuing_authority")) {
            $cookie['issuing_authority'] = Cookie::get("issuing_authority");
        }
        if (Cookie::has("passport_country")) {
            $cookie['passport_country'] = Cookie::get('passport_country');
        }
        if (Cookie::has("issue_date")) {
            $cookie['issue_date'] = Cookie::get('issue_date');
        }
        if (Cookie::has("expiry_date")) {
            $cookie['expiry_date'] = Cookie::get("expiry_date");
        }
        if (Cookie::has("reference_no")) {
            $cookie['reference_no'] = Cookie::get('reference_no');
        }
        if (Cookie::has("permanent_residence_country")) {
            $cookie['permanent_residence_country'] = Cookie::get('permanent_residence_country');
        }
        if (Cookie::has("green_card_expiry_date")) {
            $cookie['green_card_expiry_date'] = Cookie::get("green_card_expiry_date");
        }
        if (Cookie::has("next2")) {
            $cookie["next2"] = Cookie::get("next2");
        }
        if (Cookie::has("first_name")) {
            $cookie["first_name"] = Cookie::get("first_name");
        }
        if (Cookie::has("middle_name")) {
            $cookie["middle_name"] = Cookie::get("middle_name");
        }
        if (Cookie::has("last_name")) {
            $cookie["last_name"] = Cookie::get("last_name");
        }
        if (Cookie::has("dob")) {
            $cookie['dob'] = Cookie::get("dob");
        }
        if (Cookie::has("place_birth")) {
            $cookie['place_birth'] = Cookie::get("place_birth");
        }
        if (Cookie::has("marital_status")) {
            $cookie['marital_status'] = Cookie::get('marital_status');
        }
        if (Cookie::has("gender")) {
            $cookie['gender'] = Cookie::get('gender');
        }
        if (Cookie::has("religion")) {
            $cookie['religion'] = Cookie::get("religion");
        }
        if (Cookie::has("email")) {
            $cookie['email'] = Cookie::get('email');
        }
        if (Cookie::has("other_email")) {
            $cookie['other_email'] = Cookie::get('other_email');
        }
        if (Cookie::has("phone")) {
            $cookie['phone'] = Cookie::get("phone");
        }
        if (Cookie::has("other_phone")) {
            $cookie['other_phone'] = Cookie::get("other_phone");
        }
        if (Cookie::has("next3")) {
            $cookie["next3"] = Cookie::get("next3");
        }
        if (Cookie::has("father_name")) {
            $cookie["father_name"] = Cookie::get("father_name");
        }
        if (Cookie::has("father_nationality")) {
            $cookie["father_nationality"] = Cookie::get("father_nationality");
        }
        if (Cookie::has("mother_name")) {
            $cookie["mother_name"] = Cookie::get("mother_name");
        }
        if (Cookie::has("mother_nationality")) {
            $cookie['mother_nationality'] = Cookie::get("mother_nationality");
        }
        if (Cookie::has("have_spouse")) {
            $cookie["have_spouse"] = Cookie::get("have_spouse");
        }
        if (Cookie::has("spouse_name")) {
            $cookie["spouse_name"] = Cookie::get("spouse_name");
        }
        if (Cookie::has("spouse_birth_country")) {
            $cookie["spouse_birth_country"] = Cookie::get("spouse_birth_country");
        }
        if (Cookie::has("spouse_nationality")) {
            $cookie['spouse_nationality'] = Cookie::get("spouse_nationality");
        }
        if (Cookie::has("next4")) {
            $cookie["next4"] = Cookie::get("next4");
        }
        if (Cookie::has("profession")) {
            $cookie["profession"] = Cookie::get("profession");
        }
        if (Cookie::has("travel_history")) {
            $cookie["travel_history"] = Cookie::get("travel_history");
        }
        if (Cookie::has("pk_travel_history")) {
            $cookie["pk_travel_history"] = Cookie::get("pk_travel_history");
        }
        if (Cookie::has("next5")) {
            $cookie["next5"] = Cookie::get("next5");
        }
        if (Cookie::has("gurdwara_name")) {
            $cookie["gurdwara_name"] = Cookie::get("gurdwara_name");
        }
        if (Cookie::has("address")) {
            $cookie["address"] = Cookie::get("address");
        }
        if (Cookie::has("city")) {
            $cookie['city'] = Cookie::get("city");
        }
        if (Cookie::has("state")) {
            $cookie["state"] = Cookie::get("state");
        }
        if (Cookie::has("zip")) {
            $cookie["zip"] = Cookie::get("zip");
        }
        if (Cookie::has("secetary_name")) {
            $cookie["secetary_name"] = Cookie::get("secetary_name");
        }
        if (Cookie::has("secretary_phone")) {
            $cookie["secretary_phone"] = Cookie::get("secretary_phone");
        }
        if (Cookie::has("reference_name")) {
            $cookie["reference_name"] = Cookie::get("reference_name");
        }
        if (Cookie::has("reference_phone")) {
            $cookie["reference_phone"] = Cookie::get("reference_phone");
        }
        $data['cookie'] = $cookie;
        return view('forms.package-apply', $data);
    }

    public function payment(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $season = Season::where("status", '1')->first();
            if (empty($season)) {
                $season = Season::orderBy("id", "DESC")->first();
            }

            $total_count = YatriVisa::where("ticket_type", $request->ticket_type)->where("season_id", $season->id)->where("payment_status", "paid")->count();
            $total_count = $total_count + 1;

            $yatri_visa = YatriVisa::where("id", $id)->first();

            $ticket_type = "RT";
            if ($yatri_visa->ticket_type == "one_way") {
                $ticket_type = "O/W";
            } else if ($yatri_visa->ticket_type == "land_package") {
                $ticket_type = "L/P";
            }

            $payment_type = $request->payment_type;
            if ($payment_type == "Bank Wire Transfer") {
                $routing_number = $request->routing_number;
                $account_number = $request->account_number;
                $amount = $request->amount;
                $data = ["yatri_id" => $ticket_type."-".$total_count, "payment_type" => $payment_type, "routing_number" => $routing_number, "account_number" => $account_number, "amount" => $amount, "payment_status" => "paid"];
                YatriVisa::where("id", $id)->update($data);
            } else if ($payment_type == "Check") {
                $check_number = $request->check_number;
                $date_of_check = $request->date_of_check;
                $data = ["yatri_id" => $ticket_type."-".$total_count, "payment_type" => $payment_type, "check_number" => $check_number, "date_of_check" => $date_of_check, "payment_status" => "paid"];
                YatriVisa::where("id", $id)->update($data);
            } else if ($payment_type == "Cash") {
                $data = ["yatri_id" => $ticket_type."-".$total_count, "payment_type" => $payment_type, "payment_status" => "paid"];
                YatriVisa::where("id", $id)->update($data);
            } else if ($payment_type == "Pay Later") {
                $data = ["payment_status" => "pending"];
                YatriVisa::where("id", $id)->update($data);
            }

            return redirect(url("thank-you"));
        }

        $data['all_packages'] = Package::all();
        $data['id'] = $id;
        return view('payment', $data);
    }

    public function apply($id)
    {
        $data['packages'] = Package::where("id", $id)->first();
        $data['all_packages'] = Package::all();
        return view('apply-package', $data);
    }

    public function thank_you()
    {
        return view('thank-you');
    }
    
    public function store_yatri_visa(Request $request)
    {
        $season = Season::where("status", '1')->first();
        if (empty($season)) {
            $season = Season::orderBy("id", "DESC")->first();
        }

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
        if (@\Auth::user()) {
            $yatri_visa->user_id = \Auth::user()->id;
        }
        $yatri_visa->package_id = $request->package_id;
        $yatri_visa->season_id = $season->id;
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

        Conversion::log('booking_request', $request, $yatri_visa->id);

        return redirect(url("all-packages/payment", $yatri_visa->id));
    }

    public function store_special_package(Request $request)
    {
        $season = Season::where("status", '1')->first();
        if (empty($season)) {
            $season = Season::orderBy("id", "DESC")->first();
        }
        $data = $request->all();

        $package = Package::where("id", $request->package_id)->first();
        
        $total_persons = 0;
        for($i = 0; $i < 10; $i++) {
            if(@$data['passport_'.$i+1] && @$data['photo_'.$i+1]) {
                $total_persons++;
            }
        }

        for($i = 0; $i < 10; $i++) {
            if(@$data['passport_'.$i+1] && @$data['photo_'.$i+1]) {
                $yatri_visa = new YatriVisa();
                $photo = null;
                if($data['photo_'.$i+1])
                {
        
                    $file = $data['photo_'.$i+1];
                    $fileName = uniqid().$file->getClientOriginalName();
                    $destinationPath = public_path('photo_uploads');
                    $file->move($destinationPath,$fileName);
                    $photo = $fileName;
                }
                $passport = null;
                if($data['us_passport_'.$i+1])
                {
        
                    $file = $data['us_passport_'.$i+1];
                    $fileName = uniqid().$file->getClientOriginalName();
                    $destinationPath = public_path('passport_uploads');
                    $file->move($destinationPath,$fileName);
                    $passport = $fileName;
                }
                $greencard = null;
                if(@$data['green_card_'.$i+1])
                {
        
                    $file = $data['green_card_'.$i+1];
                    $fileName = uniqid().$file->getClientOriginalName();
                    $destinationPath = public_path('greencard_uploads');
                    $file->move($destinationPath,$fileName);
                    $greencard = $fileName;
                }
                $drivinglicense = null;
                if($data['driving_license_'.$i+1])
                {
        
                    $file = $data['driving_license_'.$i+1];
                    $fileName = uniqid().$file->getClientOriginalName();
                    $destinationPath = public_path('drivinglicense_uploads');
                    $file->move($destinationPath,$fileName);
                    $drivinglicense = $fileName;
                }
                if (@\Auth::user()) {
                    $yatri_visa->user_id = \Auth::user()->id;
                }
                $yatri_visa->package_id = $data['package_id_'.$i+1];
                $yatri_visa->season_id = $season->id;
                $yatri_visa->package_type = @$data['package_type_'.$i+1];
                $yatri_visa->ticket_type = $data['ticket_type_'.$i+1];
                $yatri_visa->passport = $data['passport_'.$i+1];
                $yatri_visa->passport_type = $data['passport_type_'.$i+1];
                $yatri_visa->issuing_authority = $data['issuing_authority_'.$i+1];
                $yatri_visa->passport_country = $data['passport_country_'.$i+1];
                $yatri_visa->issue_date = $data['issue_date_'.$i+1];
                $yatri_visa->expiry_date = $data['expiry_date_'.$i+1];
                if (!empty($data['reference_no_'.$i+1])) {
                    $yatri_visa->reference_no = $data['reference_no_'.$i+1];
                }
                if (!empty($data['residence_country_'.$i+1])) {
                    $yatri_visa->residence_country = $data['residence_country_'.$i+1];
                }
                if (!empty($data['green_card_expiry_date_'.$i+1])) {
                    $yatri_visa->green_card_expiry_date = $data['green_card_expiry_date_'.$i+1];
                }
                $yatri_visa->first_name = $data['first_name_'.$i+1];
                $yatri_visa->middle_name = $data['middle_name_'.$i+1];
                $yatri_visa->last_name = $data['last_name_'.$i+1];
                $yatri_visa->dob = $data['dob_'.$i+1];
                $yatri_visa->place_birth = $data['place_birth_'.$i+1];
                $yatri_visa->marital_status = $data['marital_status_'.$i+1];
                $yatri_visa->gender = $data['gender_'.$i+1];
                $yatri_visa->religion = $data['religion_'.$i+1];
                $yatri_visa->email = $data['email_'.$i+1];
                $yatri_visa->phone = $data['phone_'.$i+1];
                $yatri_visa->father_name = $data['father_name_'.$i+1];
                $yatri_visa->father_nationality = $data['father_nationality_'.$i+1];
                $yatri_visa->mother_name = $data['mother_name_'.$i+1];
                $yatri_visa->mother_nationality = $data['mother_nationality_'.$i+1];
                $yatri_visa->photo = $photo;
                $yatri_visa->us_passport = $passport;
                $yatri_visa->green_card = $greencard;
                $yatri_visa->driving_license = $drivinglicense;
                
                $total_count = YatriVisa::where("ticket_type", $data['ticket_type_'.$i+1])->where("season_id", $season->id)->where("payment_status", "paid")->count();
                $total_count = $total_count + 1;
    
                $ticket_type = "L/P";
                
                $payment_type = $data['payment_type'];
                $yatri_visa->yatri_id = $ticket_type."-".$total_count;
                $yatri_visa->payment_type = $payment_type;
                
                if ($payment_type == "Bank Wire Transfer") {
                    $yatri_visa->routing_number = $data['routing_number'];
                    $yatri_visa->account_number = $data['account_number'];
                    $yatri_visa->amount = (int)$data['amount'] / $total_persons;
                    $yatri_visa->payment_status = "paid";
                } else if ($payment_type == "Check") {
                    $yatri_visa->check_number = $data['check_number'];
                    $yatri_visa->date_of_check = $data['date_of_check'];
                    $yatri_visa->payment_status = "paid";
                } else if ($payment_type == "Cash") {
                    $yatri_visa->payment_status = "paid";
                } else if ($payment_type == "Pay Later") {
                    $yatri_visa->payment_status = "pending";
                }
                
                $yatri_visa->save();
            }
        }

        Conversion::log('special_booking', $request);

        return redirect(url("thank-you"));
    }

    public function agreement($id)
    {
       $data['id'] = $id;         
       return view('forms.agreement', $data);
    }
}
