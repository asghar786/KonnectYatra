<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YatriVisa;
use App\Models\Balance;

class BalanceController extends Controller
{
    public function index($id){
        $data['visa'] = YatriVisa::where("id", $id)->first();
        $data['balance'] = Balance::with("visa")->where('visa_id', $id)->get();
        $pending_amount = (int)str_replace("$", "", $data['visa']->package_type) - (int)$data['visa']->amount;
        foreach ($data['balance'] as $key => $value) {
            $pending_amount = $pending_amount - (int)$value->amount;
        }
        $data['pending_amount'] = $pending_amount;

        return view('admin.balance', $data);
    }

    public function store(Request $request)
    {
        $balance = new Balance();
        $balance->amount = $request->input('amount');
        $balance->amount_type = $request->input('amount_type');
        $balance->raseed_no = $request->input('raseed_no');
        $balance->payment_date = $request->input('payment_date');
        $balance->visa_id = $request->input('visa_id');
        $balance->save();
        return back()->with('success','Balance is added sucessfully');
    }

    public function edit($id)
    {
        $data['balance'] = Balance::find($id);
        return view('admin.balance_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $balance = Balance::find($id);
        $balance->amount = $request->input('amount');
        $balance->raseed_no = $request->input('raseed_no');
        $balance->payment_date = $request->input('payment_date');
        $balance->update();
        return redirect(url('admin/add-balance', $balance->visa_id))->with('success','Balance is update sucessfully');  
    }

    public function destroy($id)
    {
        $user = Balance::where('id', $id);        
        $user->delete();
        return back()->with("success", "Row Deleted Successfully!");
    }
}
