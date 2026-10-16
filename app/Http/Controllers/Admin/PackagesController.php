<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageDetails;
use App\Models\PriceDetails;
use App\Models\YatariPackage;
use App\Models\YatriVisa;
use App\Models\Remarks;
use App\Models\User;
use App\Models\Events;
use App\Models\News;
use App\Models\Hotels;
use App\Models\Bus;
use App\Models\Locations;
use App\Models\Gallery;
use App\Models\YatriIds;
use App\Models\Season;
use App\Models\Gurdwara;
use App\Models\Country;
use App\Models\DepartureOrigin;
use App\Models\YatriIdsBack;
use App\Models\Balance;
use App\Support\YatriDate;
use App\Support\YatriId;
use Session;

class PackagesController extends Controller
{
  public function index()
  {
    $data = Package::all();
    $yatri_package =  Package::all();
    // Total bookings per package id (full history, incl. removed) — used for the
    // "X selected this package" caption and to disable delete for availed packages.
    $booking_counts = YatriVisa::withTrashed()->select('package_id', \DB::raw('count(*) as c'))
      ->groupBy('package_id')->pluck('c', 'package_id');
    return view('admin.packages.packages', [
      'packages'       => $data,
      'yatri_package'  => $yatri_package,
      'booking_counts' => $booking_counts,
    ]);
  }

  public function users()
  {
    $data = Package::all();
    $users = User::where('role', 'user')->get();
    return view('admin.users',['packages'=>$data],['users'=>$users]);
  }

  public function view_user($id)
  {
    $user = User::findOrFail($id);
    $bookings = YatriVisa::with('package')->where('user_id', $id)->orderBy('id', 'DESC')->get();
    return view('admin.user-detail', ['user' => $user, 'bookings' => $bookings]);
  }

  public function booking_detail($id)
  {
    $data['yatri'] = YatriVisa::with("package", "gurdwara", "hotel", "bus", "documents")->where('id',$id)->first();
    return view('admin.booking-detail', $data);
  }

  public function admin_back_view()
  {
    $data['back_ids'] = YatriIdsBack::first();
    return view('admin.ids.admin_back_view', $data);
  }


  public function payment(Request $request, $id)
  {
    // dd($payment_date);
    if ($request->isMethod('post')) {
      $season = Season::where("status", '1')->first();
      if (empty($season)) {
        $season = Season::orderBy("id", "DESC")->first();
      }
      $yatri_visa = YatriVisa::where("id", $id)->first();

      $total_count = YatriVisa::where("ticket_type", $yatri_visa->ticket_type)->where("season_id", $season->id)->where("payment_status", "paid")->count();
      $total_count = $total_count + 1;

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
        $payment_date = now()->format('d-m-Y');
        $rased = $request->rased_number;
        $data = ["yatri_id" => $ticket_type."-".$total_count, "payment_type" => $payment_type, "routing_number" => $routing_number, "account_number" => $account_number, "rased_number" => $rased, "payment_date" => $payment_date, "amount" => $amount, "payment_status" => "paid"];
        YatriVisa::where("id", $id)->update($data);
      } else if ($payment_type == "Check") {
        $rased = $request->rased_number;
        $check_number = $request->check_number;
        $date_of_check = $request->date_of_check;
        $payment_date = now()->format('d-m-Y');
        $amount = $request->amount;


        $data = ["yatri_id" => $ticket_type."-".$total_count, "payment_type" => $payment_type, "check_number" => $check_number, "date_of_check" => $date_of_check, "payment_date" => $payment_date, "amount" => $amount, "rased_number" => $rased, "payment_status" => "paid"];
        YatriVisa::where("id", $id)->update($data);
      } else if ($payment_type == "Cash" || $payment_type == "Zelle") {
        $rased = $request->rased_number;
        $payment_date = now()->format('d-m-Y');
        $amount = $request->amount;

        $data = ["yatri_id" => $ticket_type."-".$total_count, "payment_type" => $payment_type, "amount" => $amount, "payment_date" => $payment_date, "rased_number" => $rased, "payment_status" => "paid"];
        YatriVisa::where("id", $id)->update($data);
      } else if ($payment_type == "Pay Later") {
        $data = ["payment_status" => "pending"];
        YatriVisa::where("id", $id)->update($data);
      }

      // Notify the traveller (+ admin office) that their payment status changed.
      $yatri_visa->refresh();
      $statusValue = $payment_type == "Pay Later" ? 'Pending' : 'Paid';
      $note = $payment_type == "Pay Later"
        ? 'Your payment is pending.'
        : ('Payment of $' . number_format((int) $request->amount) . ' via ' . $payment_type . ' has been recorded.');
      \App\Support\BookingMailer::sendStatusUpdate($yatri_visa, 'Payment Status', $statusValue, $note);

      return redirect(url("admin/yatri-visa"));
    }

    $data['all_packages'] = Package::all();
    $data['id'] = $id;
    return view('admin.payment', $data);
  }

  public function airline_list()
  {
    $active_season = Session::get('season');
    if (empty($active_season)) {
      $active_season = Season::orderBy('id', 'DESC')->first();
      if(!empty($active_season)) {
        $data['yatri'] = YatriVisa::where("season_id", $active_season->id)->get();
      } else {
        $data['yatri'] = [];
      }
    } else {
      $data['yatri'] = YatriVisa::where("season_id", $active_season)->get();
    }
    return view('admin.airline-list', $data);
  }

  public function visa()
  {
    $active_season = Session::get('season');
    if (empty($active_season)) {
      $active_season = Season::orderBy('id', 'DESC')->first();
      if(!empty($active_season)) {
        $data['visa'] = YatriVisa::with("package", "gurdwara", "hotel", "bus")->where("season_id", $active_season->id)->get();
      } else {
        $data['visa'] = [];
      }
    } else {
      $data['visa'] = YatriVisa::with("package", "gurdwara", "hotel", "bus")->where("season_id", $active_season)->get();
    }
    return view('admin.visa.visa', $data);
  }

  public function visa_detail($id)
  {
    $data['visa'] = YatriVisa::with("package", "gurdwara", "hotel", "bus")->where('id', $id)->first();
    return view('admin.visa.visa_detail', $data);
  }

  public function invitation_detail()
  {
    $active_season = Session::get('season');
    if (empty($active_season)) {
      $active_season = Season::orderBy('id', 'DESC')->first();
      if(!empty($active_season)) {
        $data['detail'] = YatriVisa::with("package", "gurdwara", "hotel", "bus")->where("season_id", $active_season->id)->get();
      } else {
        $data['detail'] = [];
      }
    } else {
      $data['detail'] = YatriVisa::with("package", "gurdwara", "hotel", "bus")->where("season_id", $active_season)->get();
    }
    return view('admin.invitation-detail', $data);
  }

  public function add_remarks(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();
      $data['user_id'] = $id;
      Remarks::create($data);

      return back()->with("success", "Remarks Added Successfully!");
    }
    $data['packages'] = Package::all();
    $data['remarks'] = Remarks::where("user_id", $id)->get();
    $data['id'] = $id;
    return view('admin.add-remarks', $data);
  }

  public function delete_users($id)
  {
    $user = User::where('id', $id);
    if($user)
    {
      $user->delete();
      return back()->with("success", "User Deleted Successfully!");
    }
  }

  public function create(Request $request)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('image')) {   
        $fileName = \App\Support\ImageHelper::save($request->file('image'), 'assets/flyers', ['width' => 1200, 'mode' => 'max', 'quality' => 90]);
      }
      // dd($data['sdescription']);
      $package = new Package;
      $package->name = @$data['package_name'];
      $package->state = @$data['state'];
      // state_code is the airport code the public packages page filters on — a
      // package with no code never appears under any departure airport.
      $package->state_code = @$data['state_code'];
      $package->month_year = @$data['month_year'];
      $package->round_single_price = @$data['round_single_price'];
      $package->round_double_price = @$data['round_double_price'];
      $package->round_triple_price = @$data['round_triple_price'];
      $package->round_way_description = @$data['round_way_description'];
      $package->one_single_price = (int)@$data['one_single_price'];
      $package->one_double_price = @$data['one_double_price'];
      $package->one_triple_price = @$data['one_triple_price'];
      $package->one_way_description = @$data['one_way_description'];
      $package->image = @$fileName;
      $package->description = @$data['description'];
      $package->sdescription = $data['sdescription'];
      $package->five_star_round_price = $data['five_star_round_price'];
      $package->five_star_single_price = $data['five_star_single_price'];
      $package->four_star_round_price = $data['four_star_round_price'];
      $package->four_star_single_price = $data['four_star_single_price'];
      $package->five_star_land_price = $data['five_star_land_price'];
      $package->four_star_land_price = $data['four_star_land_price'];
      $package->package_type = $data['package_type'];
      // Only status = 1 is rendered on the public packages page.
      $package->status = isset($data['status']) ? (int) $data['status'] : 1;
      $package->save();

      $package_details = new PackageDetails;
      $package_details->package_id = @$package->id;
      $package_details->day_1 = @$data['day_1'];
      $package_details->plan_1 = @$data['plan_1'];
      $package_details->no_1 = @$data['no_1'];
      $package_details->day_2 = @$data['day_2'];
      $package_details->plan_2 = @$data['plan_2'];
      $package_details->no_2 = @$data['no_2'];
      $package_details->day_3 = @$data['day_3'];
      $package_details->plan_3 = @$data['plan_3'];
      $package_details->no_3 = @$data['no_3'];
      $package_details->day_4 = @$data['day_4'];
      $package_details->plan_4 = @$data['plan_4'];
      $package_details->no_4 = @$data['no_4'];
      $package_details->day_5 = @$data['day_5'];
      $package_details->plan_5 = @$data['plan_5'];
      $package_details->no_5 = @$data['no_5'];
      $package_details->day_6 = @$data['day_6'];
      $package_details->plan_6 = @$data['plan_6'];
      $package_details->no_6 = @$data['no_6'];
      $package_details->day_7 = @$data['day_7'];
      $package_details->plan_7 = @$data['plan_7'];
      $package_details->no_7 = @$data['no_7'];
      $package_details->day_8 = @$data['day_8'];
      $package_details->plan_8 = @$data['plan_8'];
      $package_details->no_8 = @$data['no_8'];
      $package_details->save();

      $price_details = new PriceDetails;
      $price_details->package_id = @$package->id;
      $price_details->single_ticket = @$data['single_ticket'];
      $price_details->double_ticket = @$data['double_ticket'];
      $price_details->triple_ticket = @$data['triple_ticket'];
      $price_details->single_isb_to_lhr = @$data['single_isb_to_lhr'];
      $price_details->double_isb_to_lhr = @$data['double_isb_to_lhr'];
      $price_details->triple_isb_to_lhr = @$data['triple_isb_to_lhr'];
      $price_details->single_tolls = @$data['single_tolls'];
      $price_details->double_tolls = @$data['double_tolls'];
      $price_details->triple_tolls = @$data['triple_tolls'];
      $price_details->single_isb_hotel = @$data['single_isb_hotel'];
      $price_details->double_isb_hotel = @$data['double_isb_hotel'];
      $price_details->triple_isb_hotel = @$data['triple_isb_hotel'];
      $price_details->single_transport = @$data['single_transport'];
      $price_details->double_transport = @$data['double_transport'];
      $price_details->triple_transport = @$data['triple_transport'];
      $price_details->single_lhr_hotel = @$data['single_lhr_hotel'];
      $price_details->double_lhr_hotel = @$data['double_lhr_hotel'];
      $price_details->triple_lhr_hotel = @$data['triple_lhr_hotel'];
      $price_details->single_food = @$data['single_food'];
      $price_details->double_food = @$data['double_food'];
      $price_details->triple_food = @$data['triple_food'];
      $price_details->single_visa = @$data['single_visa'];
      $price_details->double_visa = @$data['double_visa'];
      $price_details->triple_visa = @$data['triple_visa'];
      $price_details->single_misc = @$data['single_misc'];
      $price_details->double_misc = @$data['double_misc'];
      $price_details->triple_misc = @$data['triple_misc'];
      $price_details->single_margin = @$data['single_margin'];
      $price_details->double_margin = @$data['double_margin'];
      $price_details->triple_margin = @$data['triple_margin'];
      $price_details->single_local_tour = @$data['single_local_tour'];
      $price_details->double_local_tour = @$data['double_local_tour'];
      $price_details->triple_local_tour = @$data['triple_local_tour'];
      $price_details->single_crew = @$data['single_crew'];
      $price_details->double_crew = @$data['double_crew'];
      $price_details->triple_crew = @$data['triple_crew'];
      $price_details->single_kartarpur = @$data['single_kartarpur'];
      $price_details->double_kartarpur = @$data['double_kartarpur'];
      $price_details->triple_kartarpur = @$data['triple_kartarpur'];
      $price_details->single_nanakana = @$data['single_nanakana'];
      $price_details->double_nanakana = @$data['double_nanakana'];
      $price_details->triple_nanakana = @$data['triple_nanakana'];
      $price_details->save();

      $response = array('status'=>'1','message'=>'Package is added sucessfully.','action'=>'reload');
      echo json_encode($response); return;
    }

    $data['origins'] = DepartureOrigin::grouped();
    $data['action'] = url('/admin/apply_packages/create');
    $data['btn_text'] = "Create";
    return view('admin.packages.create_edit', $data);
  }

  public function edit(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      $fileName = null;
      if ($request->file('image')) {
        $fileName = \App\Support\ImageHelper::save($request->file('image'), 'assets/flyers', ['width' => 1200, 'mode' => 'max', 'quality' => 90]);
      }

      $package = [
        "name" => @$data['package_name'],
        "state" => @$data['state'],
        "state_code" => @$data['state_code'],
        "month_year" => @$data['month_year'],
        "round_single_price" => @$data['round_single_price'],
        "round_double_price" => @$data['round_double_price'],
        "round_triple_price" => @$data['round_triple_price'],
        "round_way_description" => @$data['round_way_description'],
        "one_single_price" => @$data['one_single_price'],
        "one_double_price" => @$data['one_double_price'],
        "one_triple_price" => @$data['one_triple_price'],
        "one_way_description" => @$data['one_way_description'],
        "description" => @$data['description'],
        "sdescription" => @$data['sdescription'],
        "five_star_round_price" => @$data['five_star_round_price'],
        "five_star_single_price" => @$data['five_star_single_price'],
        "four_star_round_price" => @$data['four_star_round_price'],
        "four_star_single_price" => @$data['four_star_single_price'],
        "five_star_land_price" => @$data['five_star_land_price'],
        "four_star_land_price" => @$data['four_star_land_price'],
        "package_type" => @$data['package_type']
      ];
      // Absent only if the form was submitted without the field; leave it alone then.
      if(isset($data['status']))
      {
        $package["status"] = (int) $data['status'];
      }
      // Brochure: a new upload replaces the current one, "Remove Image" clears it.
      // Each package owns its flyer file, so the superseded one is deleted rather
      // than left behind in assets/flyers.
      if (!empty($fileName)) {
        $package["image"] = $fileName;
      } elseif ($request->input('remove_image')) {
        $package["image"] = null;
      }
      if (array_key_exists("image", $package)) {
        $old = Package::where("id", $id)->value("image");
        if (!empty($old)) {
          @unlink(public_path('assets/flyers/'.$old));
        }
      }
      Package::where("id", $id)->update($package);

      $package_details = [
        "day_1" => @$data['day_1'],
        "plan_1" => @$data['plan_1'],
        "no_1" => @$data['no_1'],
        "day_2" => @$data['day_2'],
        "plan_2" => @$data['plan_2'],
        "no_2" => @$data['no_2'],
        "day_3" => @$data['day_3'],
        "plan_3" => @$data['plan_3'],
        "no_3" => @$data['no_3'],
        "day_4" => @$data['day_4'],
        "plan_4" => @$data['plan_4'],
        "no_4" => @$data['no_4'],
        "day_5" => @$data['day_5'],
        "plan_5" => @$data['plan_5'],
        "no_5" => @$data['no_5'],
        "day_6" => @$data['day_6'],
        "plan_6" => @$data['plan_6'],
        "no_6" => @$data['no_6'],
        "day_7" => @$data['day_7'],
        "plan_7" => @$data['plan_7'],
        "no_7" => @$data['no_7'],
        "day_8" => @$data['day_8'],
        "plan_8" => @$data['plan_8'],
        "no_8" => @$data['no_8']
      ];

      PackageDetails::where("package_id", $id)->update($package_details);

      $price_details = [
        "single_ticket" => @$data['single_ticket'],
        "double_ticket" => @$data['double_ticket'],
        "triple_ticket" => @$data['triple_ticket'],
        "single_isb_to_lhr" => @$data['single_isb_to_lhr'],
        "double_isb_to_lhr" => @$data['double_isb_to_lhr'],
        "triple_isb_to_lhr" => @$data['triple_isb_to_lhr'],
        "single_tolls" => @$data['single_tolls'],
        "double_tolls" => @$data['double_tolls'],
        "triple_tolls" => @$data['triple_tolls'],
        "single_isb_hotel" => @$data['single_isb_hotel'],
        "double_isb_hotel" => @$data['double_isb_hotel'],
        "triple_isb_hotel" => @$data['triple_isb_hotel'],
        "single_transport" => @$data['single_transport'],
        "double_transport" => @$data['double_transport'],
        "triple_transport" => @$data['triple_transport'],
        "single_lhr_hotel" => @$data['single_lhr_hotel'],
        "double_lhr_hotel" => @$data['double_lhr_hotel'],
        "triple_lhr_hotel" => @$data['triple_lhr_hotel'],
        "single_food" => @$data['single_food'],
        "double_food" => @$data['double_food'],
        "triple_food" => @$data['triple_food'],
        "single_visa" => @$data['single_visa'],
        "double_visa" => @$data['double_visa'],
        "triple_visa" => @$data['triple_visa'],
        "single_misc" => @$data['single_misc'],
        "double_misc" => @$data['double_misc'],
        "triple_misc" => @$data['triple_misc'],
        "single_margin" => @$data['single_margin'],
        "double_margin" => @$data['double_margin'],
        "triple_margin" => @$data['triple_margin'],
        "single_local_tour" => @$data['single_local_tour'],
        "double_local_tour" => @$data['double_local_tour'],
        "triple_local_tour" => @$data['triple_local_tour'],
        "single_crew" => @$data['single_crew'],
        "double_crew" => @$data['double_crew'],
        "triple_crew" => @$data['triple_crew'],
        "single_kartarpur" => @$data['single_kartarpur'],
        "double_kartarpur" => @$data['double_kartarpur'],
        "triple_kartarpur" => @$data['triple_kartarpur'],
        "single_nanakana" => @$data['single_nanakana'],
        "double_nanakana" => @$data['double_nanakana'],
        "triple_nanakana" => @$data['triple_nanakana']
      ];
      
      PriceDetails::where("package_id", $id)->update($price_details);

      $response = array('status'=>'1','message'=>'Package is updated sucessfully.','action'=>'reload');
      echo json_encode($response); return;
    }

    $data['package'] = Package::with('package_details', 'price_details')->where("id", $id)->first();
    $data['origins'] = DepartureOrigin::grouped();
    $data['action'] = url('/admin/apply_packages/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.packages.create_edit', $data);
  }

  public function profile(Request $request)
  {
    $user = User::find(\Auth::user()->id);

    if ($request->isMethod('post')) {
      $request->validate([
        'name'         => ['required', 'string', 'max:191'],
        'avatar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
      ], [
        'new_password.confirmed' => 'The new password and confirmation do not match.',
        'new_password.min'       => 'The new password must be at least 8 characters.',
      ]);

      // Changing the password requires the correct current password.
      if ($request->filled('new_password')) {
        if (!\Hash::check((string) $request->current_password, $user->password)) {
          return back()->withErrors(['current_password' => 'Your current password is incorrect.'])->withInput();
        }
        $user->password = \Hash::make($request->new_password);
      }

      $user->name = $request->name;

      if ($request->file('avatar')) {
        $user->avatar = 'avatars/' . \App\Support\ImageHelper::save($request->file('avatar'), 'avatars', ['width' => 400, 'height' => 400, 'mode' => 'cover', 'quality' => 90]);
      }

      $user->save();

      return back()->with('success', 'Your profile has been updated successfully.');
    }

    return view('admin.profile', ['user' => $user]);
  }

  public function edit_yatri_package($id)
  {
    $yatri = YatariPackage::where('id',$id)->first();
    if($yatri)
    {
      return response()->json($yatri,200);
    }
    else
    {
      return response()->json(['error' => 'Yatri not found'], 404);
    }
  }

  public function update_yatri_package(Request $request)
  {
    $yatri = YatariPackage::where('id',$request->id)->first();
    if($yatri)
    {
      $yatri->month = $request->month;
      $yatri->single_price = $request->single_price;
      $yatri->double_price = $request->double_price;
      $yatri->triple_price = $request->triple_price;
      $yatri->save();
      return back()->with('success','Package Updated Successfully');
    }
    else
    {
      return back()->with('error','Something went Wrong');
    }
  }

  /**
   * Duplicate a package so a new departure/fare variant can be built from an
   * existing one instead of retyping the ~80% that stays the same. The copy
   * opens straight in the edit form for the departure, fares and brochure.
   */
  public function copy($id)
  {
    $package = Package::find($id);
    if(!$package)
    {
      return back()->with("error", "Package not found.");
    }

    $copy = $package->replicate();
    $copy->name = mb_substr($package->name . ' (Copy)', 0, 255);
    // The copy gets its own flyer file. If it shared the original's filename,
    // uploading a new brochure on the copy would delete the original's image —
    // edit() unlinks the previous file whenever the image changes.
    $copy->image = $this->duplicateFlyer($package->image);
    $copy->save();

    // The itinerary and price breakdown live in their own tables.
    if($details = PackageDetails::where('package_id', $id)->first())
    {
      $new = $details->replicate();
      $new->package_id = $copy->id;
      $new->save();
    }
    if($prices = PriceDetails::where('package_id', $id)->first())
    {
      $new = $prices->replicate();
      $new->package_id = $copy->id;
      $new->save();
    }

    return redirect(url('admin/apply_packages/edit', $copy->id))
      ->with("success", "Copied \"{$package->name}\". Change the departure, fares and brochure, then click Update.");
  }

  /**
   * Copy a flyer to a new unique filename so each package owns its own image.
   * Returns null when there is no image, or the stored one is missing on disk.
   */
  private function duplicateFlyer($image)
  {
    if(empty($image))
    {
      return null;
    }
    $source = public_path('assets/flyers/' . $image);
    if(!is_file($source))
    {
      return null;
    }
    $name = uniqid() . '_' . pathinfo($image, PATHINFO_FILENAME);
    $ext  = pathinfo($image, PATHINFO_EXTENSION);
    $newName = $ext ? $name . '.' . $ext : $name;

    return @copy($source, public_path('assets/flyers/' . $newName)) ? $newName : null;
  }

  public function delete($id)
  {
    $package = Package::find($id);
    if(!$package)
    {
      return back()->with("error", "Package not found.");
    }

    // A package can only be deleted if no Yatri has ever availed (booked) it.
    $bookings = YatriVisa::withTrashed()->where('package_id', $id)->count();
    if($bookings > 0)
    {
      return back()->with("error", "Cannot delete \"{$package->name}\" — {$bookings} Yatri(s) have already availed this package. Disable it instead.");
    }

    $package->delete();
    PackageDetails::where('package_id', $id)->delete();
    PriceDetails::where('package_id', $id)->delete();
    return back()->with("success", "Package Deleted Successfully");
  }

  public function store(Request $request)
  {
    // $date =  \Carbon\Carbon::parse($request->date_1st);
    // $nextDay = $date->addDay();
    // dd($request->date_1st,$nextDay->format('Y-m-d'));
    $package = new Package();
    $package->create([
      'g_name'=>$request->g_name,
      'state'=>$request->state,
      'month' =>$request->month,
      'date_1st' =>$request->date_1st,
    ]);
    return back()->with('success','Package Applied Successfuly');
  }

  public function yatri_visa()
  {
    $active_season = Session::get('season');
    if (empty($active_season)) {
      $active_season = Season::orderBy('id', 'DESC')->first();
      if(!empty($active_season)) {
        $yatries = YatriVisa::with("package")->withCount("comments")->where("season_id", $active_season->id)->get();
      } else {
        $yatries = [];
      }
    } else {
      $yatries = YatriVisa::with("package")->withCount("comments")->where("season_id", $active_season)->get();
    }
    foreach ($yatries as $key => $value) {
      $balance = Balance::with("visa")->where('visa_id', $value->id)->get();
      // Group total = per-person price × number of people travelling.
      $unit = (int) str_replace("$", "", $value->package_type);
      $people = max(1, (int) $value->travellers_count);
      $grandTotal = (int) ($value->total_amount > 0 ? round($value->total_amount) : $unit * $people);
      $pending_amount = $grandTotal - (int)$value->amount;
      foreach ($balance as $k => $val) {
        $pending_amount = $pending_amount - (int)$val->amount;
      }
      $yatries[$key]->pending_amount = $pending_amount;
      $yatries[$key]->grand_total = $grandTotal;
    }
    return view('admin.packages.yatri',compact('yatries'));
  }

  public function passenger_list(Request $request)
  {
    $active_season = Session::get('season');
    if (empty($active_season)) {
      $active_season = Season::orderBy('id', 'DESC')->first();
      if (!empty($active_season)) {
        $active_season = $active_season->id;
      }
    }
    $data['yatries'] = YatriVisa::with("package", "package.price_details", "package.package_details");
    if (!empty($request->state) && $request->state !== "all") {
      $data['state'] = $request->state;
      $state = $request->state;
      $data['yatries'] = $data['yatries']->whereHas("package", function ($q) use($state) {
        $q->where("state", $state);
      });
    }
    if (!empty($request->ticket_type) && $request->ticket_type !== "all") {
      $data['ticket_type'] = $request->ticket_type;
      $data['yatries'] = $data['yatries']->where("ticket_type", $request->ticket_type);
    }
    $data['yatries'] = $data['yatries']->where("season_id", $active_season)->get();
    $data['packages'] = Package::all();
    return view('admin.passenger-list', $data);
  }

  public function view_yatri_visa($id)
  {
    $yatri = YatriVisa::with("gurdwara", "hotel", "bus")->where('id',$id)->first();
    if($yatri)
    {
      $data['yatri'] = $yatri;
      $data['bus'] = Bus::all();
      $data['hotel'] = Hotels::all();
      return view('admin.packages.view-yatri', $data);
    }
    else
    {
      return back()->with('error','Something went wrong');
    }
  }

  public function edit_yatri_visa($id)
  {
    $packages = YatariPackage::all();
    $countries = Country::all();
    $gurdwaras  = Gurdwara::all();
    $allPackages = Package::where('status', 1)->orderBy('name')->get();
    $yatri = YatriVisa::where('id',$id)->first();
    if($yatri)
    {
      return view('admin.packages.edit-yatri',compact('yatri','packages','countries','gurdwaras','allPackages'));
    }
    else
    {
      return back()->with('error','Something went wrong');
    }
  }

  /**
   * Blank version of the edit form, for keying in a paper application by hand.
   * Same view, so the fields a candidate fills on the printed form and the
   * fields the admin types cannot drift apart.
   */
  public function create_yatri_visa()
  {
    $packages    = YatariPackage::all();
    $countries   = Country::all();
    $gurdwaras   = Gurdwara::all();
    $allPackages = Package::where('status', 1)->orderBy('name')->get();
    $yatri       = new YatriVisa();

    return view('admin.packages.edit-yatri', compact('yatri','packages','countries','gurdwaras','allPackages'));
  }

  /** Save a booking the admin entered by hand. */
  public function store_yatri_visa_admin(Request $request)
  {
    $request->validate([
      'first_name' => 'required|string|max:190',
      'last_name'  => 'required|string|max:190',
      'passport'   => 'required|string|max:190',
    ]);

    $data = $this->prepareYatriData($request);

    // The list is filtered by season, so a record saved into the wrong one is
    // invisible on the page the admin just came from. Use the season they are
    // currently viewing, falling back the same way the list itself does.
    $season = Session::get('season')
      ?: optional(Season::where('status', '1')->first())->id
      ?: optional(Season::orderBy('id', 'DESC')->first())->id;
    $data['season_id'] = $season;

    // `marital_status` and `photo` are NOT NULL with no default, and a paper
    // application often arrives without either — an unticked radio and no
    // photograph yet. Insert an empty value rather than making the admin invent
    // one; both read as "not provided" everywhere they are displayed.
    foreach (['marital_status', 'photo'] as $column) {
      if (!isset($data[$column])) {
        $data[$column] = '';
      }
    }

    $data['yatri_id']    = YatriId::generate($request->ticket_type);
    $data['visa_status'] = 'Pending';
    // Nothing is paid until someone records a payment, so leave `amount` unset:
    // the list works out what is due from the package price minus payments.

    $yatri = YatriVisa::create($data);

    return redirect(url('admin/booking-detail', $yatri->id))
      ->with('success', 'Yatri ' . $yatri->yatri_id . ' added successfully!');
  }

  public function yatri_visa_update(Request $request, $id)
  {
    if($request->isMethod('post')){

      $data = $this->prepareYatriData($request);

      YatriVisa::where("id", $id)->update($data);
      return redirect(url('admin/booking-detail', $id))->with("success", "Yatri details updated successfully!");
    }
  }

  /**
   * Everything the create and edit forms have in common: move any uploaded
   * files into place and put the dates into the house format.
   */
  private function prepareYatriData(Request $request): array
  {
    $data = $request->all();
    unset($data['_token']);

    $uploads = [
      'photo'           => 'photo_uploads',
      'us_passport'     => 'passport_uploads',
      'driving_license' => 'drivinglicense_uploads',
      'green_card'      => 'greencard_uploads',
    ];
    foreach ($uploads as $field => $directory) {
      if ($request->file($field)) {
        $file     = $request->file($field);
        $fileName = uniqid().$file->getClientOriginalName();
        $file->move(public_path($directory), $fileName);
        $data[$field] = $fileName;
      } else {
        // An untouched file input posts nothing; make sure a stray empty value
        // never overwrites the filename already stored.
        unset($data[$field]);
      }
    }

    // The date columns are varchar, so whatever the form posts is what gets
    // stored. Put every date into the house DD-MMM-YYYY format on the way in,
    // so the record reads the same as one the public apply form writes.
    foreach (['dob', 'issue_date', 'expiry_date', 'green_card_expiry_date', 'pk_entry_date'] as $dateField) {
      if (array_key_exists($dateField, $data)) {
        $data[$dateField] = YatriDate::format($data[$dateField]);
      }
    }

    return $data;
  }
  public function delete_yatri($id)
  {
    $yatri = YatriVisa::where('id',$id)->first();
    if($yatri)
    {
      $yatri->delete();
      return back()->with('success','Yatri Visa Record Deleted Successfully');
    }
    else
    {
      return back()->with('error','Something went wrong');
    }
  }

  // Update the visa processing status from the Yatri Bookings list.
  public function update_visa_status($id, $status)
  {
    $map = ['pending' => 'Pending', 'in_process' => 'In Process', 'approved' => 'Approved', 'rejected' => 'Rejected'];
    $yatri = YatriVisa::find($id);
    if ($yatri && isset($map[$status])) {
      $yatri->visa_status = $map[$status];
      $yatri->save();
      // Notify the traveller of the visa-status change, with a copy to the admin office.
      \App\Support\BookingMailer::sendStatusUpdate($yatri, 'Visa Status', $map[$status]);
      return back()->with('success', 'Visa status updated to '.$map[$status].'.');
    }
    return back()->with('error', 'Something went wrong');
  }

  // Communication log for a booking: list + add comments so staff remember what was discussed.
  public function yatri_comments($id)
  {
    $yatri = YatriVisa::with('comments')->findOrFail($id);
    return view('admin.packages.yatri-comments', compact('yatri'));
  }

  public function store_yatri_comment(Request $request, $id)
  {
    $request->validate(['comment' => 'required|string|max:2000']);
    $yatri = YatriVisa::findOrFail($id);
    \App\Models\YatriComment::create([
      'yatri_visa_id' => $yatri->id,
      'comment'       => $request->comment,
      'author'        => optional(\Auth::user())->name,
    ]);
    return back()->with('success', 'Comment added.');
  }

  public function events()
  {
    $data = Events::all();
    return view('admin.events.events',['events'=>$data]);
  }

  public function create_events(Request $request)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('image')) {   
        $data['image'] = \App\Support\ImageHelper::save($request->file('image'), 'news_and_events', ['width' => 1280, 'height' => 720, 'mode' => 'cover', 'quality' => 90]);
      }

      Events::create($data);

      // $response = array('status'=>'1','message'=>'Event is added sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/events'))->with("success", "Events added successfully!");
    }

    $data['action'] = url('/admin/events/create');
    $data['btn_text'] = "Create";
    return view('admin.events.create_edit', $data);
  }

  public function edit_events(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('image')) {   
        $data['image'] = \App\Support\ImageHelper::save($request->file('image'), 'news_and_events', ['width' => 1280, 'height' => 720, 'mode' => 'cover', 'quality' => 90]);
      }

      unset($data['_token']);
      Events::where("id", $id)->update($data);

      // $response = array('status'=>'1','message'=>'Event is updated sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/events'))->with("success", "Events updated successfully!");
    }

    $data['events'] = Events::where("id", $id)->first();
    $data['action'] = url('/admin/events/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.events.create_edit', $data);
  }

  public function delete_events($id)
  {
    $event = Events::where('id', $id);
    if($event)
    {
      $event->delete();
      return back()->with("success", "Event deleted successfully!");
    }
  }

  public function news()
  {
    $data = News::all();
    return view('admin.news.news',['news'=>$data]);
  }

  public function create_news(Request $request)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('file')) {   
        $file = $request->file('file');
        $fileName = uniqid().$file->getClientOriginalName();
        $destinationPath = public_path('news_and_events');
        $file->move($destinationPath,$fileName);
        $data['file'] = $fileName;
      }

      News::create($data);

      // $response = array('status'=>'1','message'=>'News is added sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/news'))->with("success", "News added successfully!");
    }

    $data['action'] = url('/admin/news/create');
    $data['btn_text'] = "Create";
    return view('admin.news.create_edit', $data);
  }

  public function edit_news(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('file')) {   
        $file = $request->file('file');
        $fileName = uniqid().$file->getClientOriginalName();
        $destinationPath = public_path('news_and_events');
        $file->move($destinationPath,$fileName);
        $data['file'] = $fileName;
      }

      unset($data['_token']);
      News::where("id", $id)->update($data);

      // $response = array('status'=>'1','message'=>'Event is updated sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/news'))->with("success", "News updated successfully!");
    }

    $data['news'] = News::where("id", $id)->first();
    $data['action'] = url('/admin/news/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.news.create_edit', $data);
  }

  public function delete_news($id)
  {
    $news = News::where('id', $id);
    if($news)
    {
      $news->delete();
      return back()->with("success", "News deleted successfully!");
    }
  }

  public function hotels()
  {
    $data = Hotels::with('images')->get();
    return view('admin.hotels.hotels',['hotels'=>$data]);
  }

  public function create_hotels(Request $request)
  {
    if($request->isMethod('post')){
      $data = $this->cleanHotelData($request);

      if ($request->file('image')) {
        $data['image'] = $this->uploadHotelFile($request->file('image'));
      }
      $hotel = Hotels::create($data);
      $this->saveHotelGalleryImages($request, $hotel->id);

      return redirect(url('admin/hotels'))->with("success", "Hotel added successfully!");
    }

    $data['hotels'] = null;
    $data['action'] = url('/admin/hotels/create');
    $data['btn_text'] = "Create";
    return view('admin.hotels.create_edit', $data);
  }

  public function edit_hotels(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $this->cleanHotelData($request);

      if ($request->file('image')) {
        $data['image'] = $this->uploadHotelFile($request->file('image'));
      }
      \App\Models\Hotels::where("id", $id)->update($data);
      $this->saveHotelGalleryImages($request, $id);

      return redirect(url('admin/hotels'))->with("success", "Hotel updated successfully!");
    }

    $data['hotels'] = Hotels::with('images')->where("id", $id)->first();
    $data['action'] = url('/admin/hotels/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.hotels.create_edit', $data);
  }

  /** Sanitised, column-safe hotel attributes (no _token/files; empty geo -> null). */
  private function cleanHotelData(Request $request): array
  {
    $data = $request->only([
      'name', 'price', 'phone', 'address', 'state', 'city', 'zip',
      'latitude', 'longitude', 'description',
    ]);
    foreach (['latitude', 'longitude'] as $k) {
      $data[$k] = ($data[$k] ?? '') === '' ? null : $data[$k];
    }
    return $data;
  }

  private function uploadHotelFile($file, array $opts = ['width' => 1280, 'height' => 850, 'mode' => 'cover', 'quality' => 90]): string
  {
    return \App\Support\ImageHelper::save($file, 'hotels', $opts);
  }

  /** Store any additional gallery images uploaded for a hotel. */
  private function saveHotelGalleryImages(Request $request, $hotelId): void
  {
    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $file) {
        if (!$file) continue;
        \App\Models\HotelImage::create([
          'hotel_id' => $hotelId,
          'image'    => $this->uploadHotelFile($file, ['width' => 1600, 'height' => 1200, 'mode' => 'max', 'quality' => 90]),
        ]);
      }
    }
  }

  public function delete_hotel_image($id)
  {
    \App\Models\HotelImage::where('id', $id)->delete();
    return back()->with('success', 'Hotel image removed.');
  }

  public function delete_hotels($id)
  {
    $hotels = Hotels::where('id', $id);
    if($hotels)
    {
      $hotels->delete();
      return back()->with("success", "Hotels deleted successfully!");
    }
  }

  public function bus()
  {
    $data = Bus::all();
    return view('admin.bus.bus',['bus'=>$data]);
  }

  public function create_bus(Request $request)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('file')) {   
        $data['file'] = \App\Support\ImageHelper::save($request->file('file'), 'bus', ['width' => 1200, 'height' => 800, 'mode' => 'cover', 'quality' => 90]);
      }

      Bus::create($data);

      // $response = array('status'=>'1','message'=>'News is added sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/bus'))->with("success", "Bus added successfully!");
    }

    $data['action'] = url('/admin/bus/create');
    $data['btn_text'] = "Create";
    return view('admin.bus.create_edit', $data);
  }

  public function edit_bus(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('file')) {   
        $data['file'] = \App\Support\ImageHelper::save($request->file('file'), 'bus', ['width' => 1200, 'height' => 800, 'mode' => 'cover', 'quality' => 90]);
      }

      unset($data['_token']);
      Bus::where("id", $id)->update($data);

      // $response = array('status'=>'1','message'=>'Event is updated sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/bus'))->with("success", "Bus updated successfully!");
    }

    $data['bus'] = Bus::where("id", $id)->first();
    $data['action'] = url('/admin/bus/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.bus.create_edit', $data);
  }

  public function delete_bus($id)
  {
    $bus = Bus::where('id', $id);
    if($bus)
    {
      $bus->delete();
      return back()->with("success", "Bus deleted successfully!");
    }
  }

  public function seasons()
  {
    $data = Season::orderBy('id', 'DESC')->get();
    return view('admin.seasons.seasons',['seasons'=>$data]);
  }

  public function create_seasons(Request $request)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if (!empty($data['status'])) {
        Season::where('status', '1')->update(['status' => '0']);
      }
      Season::create($data);

      // $response = array('status'=>'1','message'=>'News is added sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/seasons'))->with("success", "Season added successfully!");
    }

    $data['action'] = url('/admin/seasons/create');
    $data['btn_text'] = "Create";
    return view('admin.seasons.create_edit', $data);
  }

  public function edit_seasons(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      unset($data['_token']);
      if (!empty($data['status'])) {
        Season::where('status', '1')->update(['status' => '0']);
      }
      Season::where("id", $id)->update($data);

      // $response = array('status'=>'1','message'=>'Event is updated sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/seasons'))->with("success", "Season updated successfully!");
    }

    $data['season'] = Season::where("id", $id)->first();
    $data['action'] = url('/admin/seasons/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.seasons.create_edit', $data);
  }

  public function delete_seasons($id)
  {
    $season = Season::where('id', $id);
    if($season)
    {
      $season->delete();
      return back()->with("success", "Season deleted successfully!");
    }
  }

  /* ---------------------------------------------------------------------
   | Departure Origins — Country / State-City / Airport for the public
   | /all-packages cascading selector.
   * ------------------------------------------------------------------- */
  public function origins()
  {
    // USA 1st, Canada 2nd, all other countries alphabetical after — mirrors
    // the sort used for the public /all-packages country dropdown.
    $data = DepartureOrigin::orderByRaw("CASE
          WHEN LOWER(TRIM(country)) IN ('usa','u.s.a','u.s.a.','united states') THEN 0
          WHEN LOWER(TRIM(country)) = 'canada' THEN 1
          ELSE 2 END")
        ->orderBy('country')
        ->orderBy('sort_order')
        ->orderBy('state')
        ->get();
    return view('admin.origins.origins', ['origins' => $data]);
  }

  public function create_origins(Request $request)
  {
    if ($request->isMethod('post')) {
      $this->validate($request, [
        'country'      => 'required|string|max:255',
        'state'        => 'required|string|max:255',
        'airport_name' => 'required|string|max:255',
        'airport_code' => 'required|string|max:16',
      ]);

      DepartureOrigin::create([
        'country'      => trim($request->country),
        'state'        => trim($request->state),
        'airport_name' => trim($request->airport_name),
        'airport_code' => strtoupper(trim($request->airport_code)),
        'sort_order'   => (int) $request->sort_order,
        'status'       => $request->has('status') ? 1 : 0,
      ]);
      return redirect(url('admin/origins'))->with("success", "Departure origin added successfully!");
    }

    $data['action']   = url('/admin/origins/create');
    $data['btn_text'] = "Create";
    return view('admin.origins.create_edit', $data);
  }

  public function edit_origins(Request $request, $id)
  {
    if ($request->isMethod('post')) {
      $this->validate($request, [
        'country'      => 'required|string|max:255',
        'state'        => 'required|string|max:255',
        'airport_name' => 'required|string|max:255',
        'airport_code' => 'required|string|max:16',
      ]);

      DepartureOrigin::where('id', $id)->update([
        'country'      => trim($request->country),
        'state'        => trim($request->state),
        'airport_name' => trim($request->airport_name),
        'airport_code' => strtoupper(trim($request->airport_code)),
        'sort_order'   => (int) $request->sort_order,
        'status'       => $request->has('status') ? 1 : 0,
      ]);
      return redirect(url('admin/origins'))->with("success", "Departure origin updated successfully!");
    }

    $data['origin']   = DepartureOrigin::where('id', $id)->first();
    $data['action']   = url('/admin/origins/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.origins.create_edit', $data);
  }

  public function delete_origins($id)
  {
    DepartureOrigin::where('id', $id)->delete();
    return back()->with("success", "Departure origin deleted successfully!");
  }

  public function assign_hotel(Request $request)
  {
    $id = $request->visa_id;
    YatriVisa::where('id', $id)->update(["hotel_id" => $request->hotel, "room_number" => $request->room_number, "color" => $request->color]);
    return back()->with("success", "Hotel assigned successfully!");
  }

  public function assign_bus(Request $request)
  {
    $id = $request->visa_id;
    YatriVisa::where('id', $id)->update(["bus_id" => $request->bus]);
    return back()->with("success", "Bus assigned successfully!");
  }

  public function locations()
  {
    $data = Locations::with('images')->get();
    return view('admin.locations.locations',['locations'=>$data]);
  }

  public function create_locations(Request $request)
  {
    if($request->isMethod('post')){
      $data = $this->cleanLocationData($request);

      if ($request->file('image')) {
        $data['image'] = $this->uploadLocationFile($request->file('image'));
      }
      $location = Locations::create($data);
      $this->saveLocationGalleryImages($request, $location->id);
      // If no feature image was uploaded but gallery photos were, use the first one.
      if (empty($location->image)) {
        $first = \App\Models\LocationImage::where('location_id', $location->id)->first();
        if ($first) { $location->update(['image' => $first->image]); }
      }

      return redirect(url('admin/locations'))->with("success", "Location added successfully!");
    }

    $data['locations'] = null;
    $data['action'] = url('/admin/locations/create');
    $data['btn_text'] = "Create";
    return view('admin.locations.create_edit', $data);
  }

  public function edit_locations(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $this->cleanLocationData($request);

      if ($request->file('image')) {
        $data['image'] = $this->uploadLocationFile($request->file('image'));
      }
      Locations::where("id", $id)->update($data);
      $this->saveLocationGalleryImages($request, $id);

      return redirect(url('admin/locations'))->with("success", "Location updated successfully!");
    }

    $data['locations'] = Locations::with('images')->where("id", $id)->first();
    $data['action'] = url('/admin/locations/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.locations.create_edit', $data);
  }

  private function cleanLocationData(Request $request): array
  {
    $data = $request->only(['name', 'city', 'state', 'latitude', 'longitude', 'description']);
    foreach (['latitude', 'longitude'] as $k) {
      $data[$k] = ($data[$k] ?? '') === '' ? null : $data[$k];
    }
    return $data;
  }

  private function uploadLocationFile($file, array $opts = ['width' => 1280, 'height' => 850, 'mode' => 'cover', 'quality' => 90]): string
  {
    return \App\Support\ImageHelper::save($file, 'locations', $opts);
  }

  private function saveLocationGalleryImages(Request $request, $locationId): void
  {
    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $file) {
        if (!$file) continue;
        \App\Models\LocationImage::create([
          'location_id' => $locationId,
          'image'       => $this->uploadLocationFile($file, ['width' => 1600, 'height' => 1200, 'mode' => 'max', 'quality' => 90]),
        ]);
      }
    }
  }

  public function delete_location_image($id)
  {
    \App\Models\LocationImage::where('id', $id)->delete();
    return back()->with('success', 'Location image removed.');
  }

  /** Tag a gallery image as the location's feature image. */
  public function set_location_feature($imageId)
  {
    $img = \App\Models\LocationImage::find($imageId);
    if ($img) {
      Locations::where('id', $img->location_id)->update(['image' => $img->image]);
      return back()->with('success', 'Feature image updated.');
    }
    return back();
  }

  public function delete_locations($id)
  {
    $locations = Locations::where('id', $id);
    if($locations)
    {
      $locations->delete();
      return back()->with("success", "Locations deleted successfully!");
    }
  }

  public function gallery()
  {
    $data = Gallery::orderBy("id", "DESC")->get();
    return view('admin.gallery.gallery',['gallery'=>$data]);
  }

  public function create_gallery(Request $request)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('image')) {   
        $data['image'] = \App\Support\ImageHelper::save($request->file('image'), 'gallery', ['width' => 1920, 'height' => 1920, 'mode' => 'max', 'quality' => 90]);
      }

      Gallery::create($data);

      // $response = array('status'=>'1','message'=>'News is added sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/gallery'))->with("success", "Gallery added successfully!");
    }

    $data['action'] = url('/admin/gallery/create');
    $data['btn_text'] = "Create";
    return view('admin.gallery.create_edit', $data);
  }

  public function edit_gallery(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('image')) {   
        $data['image'] = \App\Support\ImageHelper::save($request->file('image'), 'gallery', ['width' => 1920, 'height' => 1920, 'mode' => 'max', 'quality' => 90]);
      }

      unset($data['_token']);
      Gallery::where("id", $id)->update($data);

      // $response = array('status'=>'1','message'=>'Event is updated sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/gallery'))->with("success", "Gallery updated successfully!");
    }

    $data['gallery'] = Gallery::where("id", $id)->first();
    $data['action'] = url('/admin/gallery/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.gallery.create_edit', $data);
  }

  public function delete_gallery($id)
  {
    $gallery = Gallery::where('id', $id);
    if($gallery)
    {
      $gallery->delete();
      return back()->with("success", "Gallery deleted successfully!");
    }
  }

  public function ids()
  {
    $active_season = Session::get('season');
    if (empty($active_season)) {
      $active_season = Season::orderBy('id', 'DESC')->first();
      if(!empty($active_season)) {
        $data['yatri'] = YatriIds::where("season_id", $active_season->id)->where("type", 'yatri')->get();
        $data['crew'] = YatriIds::where("type", 'Crew Member')->get();
      } else {
        $data['yatri'] = [];
        $data['crew'] = YatriIds::where("type", 'Crew Member')->get();
      }
    } else {
      $data['yatri'] = YatriIds::where("season_id", $active_season)->where("type", 'yatri')->get();
      $data['crew'] = YatriIds::where("type", 'Crew Member')->get();
    }
    return view('admin.ids.ids',$data);
  }

  public function create_ids(Request $request)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      $season = Season::where("status", '1')->first();
      if (empty($season)) {
        $season = Season::orderBy("id", "DESC")->first();
      }

      if ($request->file('photo')) {   
        $file = $request->file('photo');
        $fileName = uniqid().$file->getClientOriginalName();
        $destinationPath = public_path('ids');
        $file->move($destinationPath,$fileName);
        $data['photo'] = $fileName;
      }
      $data['season_id'] = $season->id;
      $data['type'] = $this->idType($data['type'] ?? '');

      // One card per Yatri # per season. A save that seemed to vanish used to get
      // re-entered - Rashad #20 went in three times (2026-09-30).
      if ($data['type'] === 'Yatri' && !empty($data['yatri_no'])) {
        $taken = YatriIds::where('season_id', $season->id)->where('type', 'Yatri')->where('yatri_no', $data['yatri_no'])->first();
        if ($taken) {
          if (!empty($data['photo'])) {
            @unlink(public_path('ids/' . $data['photo']));
          }
          return back()->withInput()->with('error', 'Yatri #' . $data['yatri_no'] . ' already exists this season (' . $taken->name . '). Edit that one instead.');
        }
      }
      YatriIds::create($data);

      // $response = array('status'=>'1','message'=>'News is added sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/ids'))->with("success", "ID is added successfully!");
    }

    $data['action'] = url('/admin/ids/create');
    $data['btn_text'] = "Create";
    return view('admin.ids.create_edit', $data);
  }

  public function edit_ids($id)
  {

      // if ($request->file('photo')) {   
      //   $file = $request->file('photo');
      //   $fileName = uniqid().$file->getClientOriginalName();
      //   $destinationPath = public_path('ids');
      //   $file->move($destinationPath,$fileName);
      //   $data['photo'] = $fileName;
      // }
      // unset($data['_token']);
      // YatriIds::where("id", $id)->update($data);

      // // $response = array('status'=>'1','message'=>'Event is updated sucessfully.','action'=>'reload');
      // // echo json_encode($response); return;
    $data['yatri_id'] = YatriIds::find($id);
    return view('admin.ids.edit', $data);


    // $data['yatri_id'] = YatriIds::where("id", $id)->first();
    // $data['action'] = url('/admin/ids/edit', $id);
    // $data['btn_text'] = "Update";
  }

  public function update_ids(Request $request, $id)
  {
    if($request->isMethod('post')){
      $data = $request->all();

      if ($request->file('photo')) {   
        $file = $request->file('photo');
        $fileName = uniqid().$file->getClientOriginalName();
        $destinationPath = public_path('ids');
        $file->move($destinationPath,$fileName);
        $data['photo'] = $fileName;
      }
      unset($data['_token']);
      if (isset($data['type'])) {
        $data['type'] = $this->idType($data['type']);
      }
      YatriIds::where("id", $id)->update($data);

      // $response = array('status'=>'1','message'=>'Event is updated sucessfully.','action'=>'reload');
      // echo json_encode($response); return;
      return redirect(url('admin/ids'))->with("success", "ID is updated successfully!");
    }

    $data['yatri_id'] = YatriIds::where("id", $id)->first();
    $data['action'] = url('/admin/ids/edit', $id);
    $data['btn_text'] = "Update";
    return view('admin.ids.create_edit', $data);
  }

  // The ID pages list type "Yatri" and "Crew Member" only, so a stored type must
  // be one of the two. Anything else (a job title typed into the box) is read
  // as a Yatri - titles belong in `role`.
  private function idType($type)
  {
    return strcasecmp(trim((string) $type), 'Crew Member') === 0 ? 'Crew Member' : 'Yatri';
  }

  public function delete_ids($id)
  {
    $ids = YatriIds::where('id', $id);
    if($ids)
    {
      $ids->delete();
      return back()->with("success", "ID is deleted successfully!");
    }
  }

  public function yatri_id($id)
  {
    $active_season = Session::get('season');
    if (empty($active_season)) {
      $active_season = Season::orderBy('id', 'DESC')->first();
      if (!empty($active_season)) {
        $active_season = $active_season->id;
      }
    }
    $data = new YatriIds;
    if ($id <= 1) {
      $data = $data->limit(8);
    } else {
      $offset = ((int)$id - 1) * 8;
      $data = $data->offset($offset)->limit(8);
    }
    $data = $data->where("season_id", $active_season)->where('type', 'yatri')->orderBy("yatri_no", "ASC")->get();
    $all_data['yatri_ids'] = $data;
    $all_data['page'] = max(1, (int)$id);
    $all_data['next'] = (int)$id + 1;
    $all_data['prev'] = (int)$id - 1;
    // For the back sheet that "Print Front + Back" prints behind the fronts.
    $all_data['back_ids'] = YatriIdsBack::first();
    return view('admin.ids.yatri_id', $all_data);
  }

  // The Crew ID page prints only the cards ticked there, so it passes the count
  // along (?cards=N) and gets one back sheet per front sheet it will print.
  public function back_view(Request $request, $id = 1)
  {
    $cards = (int) $request->query('cards', 0);
    if ($cards < 1) {
      $cards = YatriIds::where('type', 'Crew Member')->count();
    }
    return $this->idBackSheet($cards > 0, url('admin/staff_ids', 1), 'No crew members selected.', (int) ceil($cards / 8));
  }

  public function yatri_back_view($id = 1)
  {
    $active_season = Session::get('season') ?: optional(Season::orderBy('id', 'DESC')->first())->id;
    $page  = max(1, (int)$id);
    // Count the whole season and ask whether this page has anyone on it.
    // count() on an offset query returns 0 past page 1 (the offset applies to
    // the single COUNT row), which left pages 2+ with no backs (2026-09-30).
    $total = YatriIds::where('season_id', $active_season)->where('type', 'yatri')->count();
    return $this->idBackSheet($total > ($page - 1) * 8, url('admin/yatri-id', $page), 'No yatris found.');
  }

  // Every back is identical, so a back sheet always carries all eight slots.
  // Printing one back per card instead left a short last page (say 3 cards)
  // with backs on the wrong side after a duplex flip, because the flip mirrors
  // the columns. A full sheet puts a back behind every front whichever way the
  // printer turns the paper; the spares are simply not cut out.
  // Crew and Yatri backs are the same CR80 card (see _print).
  private function idBackSheet($hasCards, $frontUrl, $emptyText, $sheets = 1)
  {
    return view('admin.ids.back_view', [
      'sheets'    => $hasCards ? max(1, (int) $sheets) : 0,
      'front_url' => $frontUrl,
      'empty'     => $emptyText,
      'back_ids'  => YatriIdsBack::first(),
    ]);
  }
  public function foreigners_registration($id)
  {
    $data['data'] = YatriVisa::with('package', 'hotel')->where('id', $id)->first();
    // dd($data['data']);
    return view('admin.foreigners_egistration', $data);
  }
  // All crew on one page: the office ticks only the staff travelling this time
  // and the page prints just those, eight to a sheet. {id} is kept so existing
  // links still resolve; the crew list is short enough not to need paging.
  public function staff_ids($id = 1)
  {
    $all_data['staff_ids'] = YatriIds::where('type', 'Crew Member')->orderBy('id', 'ASC')->get();
    $all_data['back_ids']  = YatriIdsBack::first();
    return view('admin.ids.staff_id_1', $all_data);
  }
  public function ids_back()
  {
   $data["ids_back"] = YatriIdsBack::first();
   // dd($data); 
   return view("admin.ids.create_back_ids", $data);
 }
 public function create_ids_back(Request $request)
 {
  if($request->isMethod('post')){
    $data = $request->all();
    unset($data['_token']);
    YatriIdsBack::where('id', 1)->update($data);
    return redirect(url('admin/ids/back'))->with("success", "ID is added successfully!");
  }
}
}
