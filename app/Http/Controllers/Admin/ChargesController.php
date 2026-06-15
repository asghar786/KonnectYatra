<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Charge;
use App\Models\ChargePay;
use App\Models\YatriVisa;

class ChargesController extends Controller
{
    public function charges(Request $request)
    {
    	$active_season = Session::get('season');
	    if (empty($active_season)) {
	      	$active_season = Season::orderBy('id', 'DESC')->first();
	      	if (!empty($active_season)) {
	      		$data['total_yatri'] = YatriVisa::where("season_id", $active_season->id)->count();
	      	} else {
	      		$data['total_yatri'] = 0;
	      	}
	    } else {
    		$data['total_yatri'] = YatriVisa::where("season_id", $active_season)->count();
	    }
	    $data['new_york'] = Charge::where("state", "New York")->get();
		$data['washington'] = Charge::where("state", "Washington")->get();
		$data['los_angeles'] = Charge::where("state", "Los Angeles")->get();
		$data['chicago'] = Charge::where("state", "Chicago")->get();
		$data['miami'] = Charge::where("state", "Miami")->get();
		$data['seattle'] = Charge::where("state", "Seattle")->get();
		$data['houston'] = Charge::where("state", "Houston")->get();
		$data['torronto'] = Charge::where("state", "Toronto")->get();
		$data['atlanta'] = Charge::where("state", "Atlanta")->get();

    	return view("admin.charges.view", $data);
    }

    public function create_charges(Request $request)
    {
    	if ($request->isMethod("POST")) {
    		$active_season = Session::get('season');
		    if (empty($active_season)) {
		    	$active_season = Season::orderBy('id', 'DESC')->first();
		      	if (!empty($active_season)) {
		      		$active_season = $active_season->id;
		      	}
		      }
	        $charges = new Charge;
	        $charges->amount = $request->input('amount');
	        $charges->description = $request->input('description');
	        $charges->state = $request->input('state');
	        $charges->save();

	        return redirect(url('admin/charges'));	
    	}

    	$data['btn_text'] = "Add";
    	$data['action'] = url('admin/charges/create');
    	return view("admin.charges.create_edit", $data);
    }

    public function edit_charges(Request $request, $id)
    {
    	if ($request->isMethod("POST")) {
    		$data = $request->all();
	        Charge::find($id)->update($data);

	        return redirect(url('admin/charges'));
    	}

    	$data['btn_text'] = "Update";
    	$data['action'] = url('admin/charges/edit', $id);
    	$data['charge'] = Charge::find($id);
    	return view("admin.charges.create_edit", $data);
    }

    public function delete_charges($id)
    {
        $charge = Charge::where('id', $id);        
        $charge->delete();

        return redirect(url('admin/charges'));
    }

    public function manage_charges(Request $request, $id)
    {
    	$data['charges_paid'] = ChargePay::where("yatri_id", $id)->get();
    	$data['yatri_id'] = $id;

    	$active_season = Session::get('season');
	    if (empty($active_season)) {
	      	$active_season = Season::orderBy('id', 'DESC')->first();
	      	if (!empty($active_season)) {
	      		$total_charges = Charge::where("season_id", $active_season->id)->sum("amount");
	      		$total_yatri = YatriVisa::where("season_id", $active_season->id)->count();
	      	} else {
	      		$total_charges = 0;
	      		$total_yatri = [];
	      	}
	    } else {
    		$total_charges = Charge::where("season_id", $active_season)->sum("amount");
    		$total_yatri = YatriVisa::where("season_id", $active_season)->count();
	    }

	    $data['per_person_charge'] = $total_charges / $total_yatri;
	    $data['paid_amount'] = ChargePay::where("yatri_id", $id)->sum("amount");

    	return view("admin.charges.manage-charges", $data);
    }

    public function create_manage_charges(Request $request, $id)
    {
    	if ($request->isMethod("POST")) {
	        $charges = new ChargePay;
	        $charges->amount = $request->input('amount');
	        $charges->yatri_id = $id;
	        $charges->save();

	        return redirect(url('admin/manage-charges', $id));	
    	}

    	$data['btn_text'] = "Add";
    	$data['action'] = url('admin/manage-charges/create', $id);
    	return view("admin.charges.create_edit_charges", $data);
    }

    public function edit_manage_charges(Request $request, $id)
    {
    	if ($request->isMethod("POST")) {
    		$data = $request->all();
	        ChargePay::find($id)->update($data);

	        return redirect()->back();
    	}

    	$data['btn_text'] = "Update";
    	$data['action'] = url('admin/manage-charges/edit', $id);
    	$data['charge'] = ChargePay::find($id);
    	return view("admin.charges.create_edit_charges", $data);
    }

    public function delete_manage_charges($id)
    {
        $charge = ChargePay::where('id', $id);        
        $charge->delete();

        return redirect()->back();
    }
}
