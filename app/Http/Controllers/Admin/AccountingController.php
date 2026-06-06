<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payable;
use App\Models\Receivable;
use App\Models\AccountHead;
use PDF;

class AccountingController extends Controller
{
    public function index()
    {
        $data['payable'] = Payable::all();
        $data['total_payable'] = Payable::sum('amount');
        $data['payable_paid'] = 0;
        $data['payable_notpaid'] = 0;

        $data['receivable'] = Receivable::all();
        $data['total_receivable'] = Receivable::sum('amount');
        $data['receivable_received'] = 0;
        $data['receivable_notreceived'] = 0;
        return view('admin.accounting.accounting',$data);
    }

    public function create_payable(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            Payable::create($data);

            return redirect(url('admin/accounting'))->with("success", "Payable added successfully!");
        }

        $data['action'] = url('/admin/payable/create');
        $data['btn_text'] = "Create";
        $data['account_head'] = AccountHead::all();
        return view('admin.accounting.payable.create_edit', $data);
    }

    public function edit_payable(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            Payable::where("id", $id)->update($data);
            return redirect(url('admin/accounting'))->with("success", "Payable updated successfully!");
        }

        $data['locations'] = Payable::where("id", $id)->first();
        $data['account_head'] = AccountHead::all();

        $data['action'] = url('/admin/payable/edit', $id);
        $data['btn_text'] = "Update";
        return view('admin.accounting.payable.create_edit', $data);
    }

    public function delete_payable($id)
    {
        $locations = Payable::where('id', $id);
        if($locations)
        {
            $locations->delete();
            return back()->with("success", "Payables deleted successfully!");
        }
    }


    // Receivable

    public function create_receivable(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            Receivable::create($data);

            return redirect(url('admin/accounting'))->with("success", "Receivable added successfully!");
        }

        $data['action'] = url('/admin/receivable/create');
        $data['btn_text'] = "Create";
        $data['account_head'] = AccountHead::all();

        return view('admin.accounting.receivable.create_edit', $data);
    }

    public function edit_receivable(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            Receivable::where("id", $id)->update($data);
            return redirect(url('admin/accounting'))->with("success", "Receivable updated successfully!");
        }

        $data['receivable'] = Receivable::where("id", $id)->first();
        $data['action'] = url('/admin/receivable/edit', $id);
        $data['btn_text'] = "Update";
        $data['account_head'] = AccountHead::all();
        
        return view('admin.accounting.receivable.create_edit', $data);
    }

    public function delete_receivable($id)
    {
        $locations = Receivable::where('id', $id);
        if($locations)
        {
            $locations->delete();
            return back()->with("success", "Receivables deleted successfully!");
        }
    }

    // Account Head

    public function account_head()
    {
        $data['account_head'] = AccountHead::orderBy("type", "desc")->get();
        foreach ($data['account_head'] as $key => $val) { 

            $val->total_payable = Payable::where('account_head_id', $val->id)->sum('amount');
        }

        foreach ($data['account_head'] as $key => $val) { 

            $val->total_receiveable = receivable::where('account_head_id', $val->id)->sum('amount');
        }

        return view('admin.account-head.index', $data);
    }


    public function create_account_head(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            AccountHead::create($data);

            return redirect(url('admin/account-head'))->with("success", "Account head added successfully!");
        }

        $data['action'] = url('/admin/account-head/create');
        $data['btn_text'] = "Create";
        return view('admin.account-head.create_edit', $data);
    }

    public function edit_account_head(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            AccountHead::where("id", $id)->update($data);
            return redirect(url('admin/account-head'))->with("success", "Account head updated successfully!");
        }

        $data['account_head'] = AccountHead::where("id", $id)->first();
        $data['action'] = url('/admin/account-head/edit', $id);
        $data['btn_text'] = "Update";
        return view('admin.account-head.create_edit', $data);
    }

    public function delete_account_head($id)
    {
        $account_head = AccountHead::where('id', $id);
        if($account_head)
        {
            $account_head->delete();
            return back()->with("success", "Account head deleted successfully!");
        }
    }
    public function view_receivable($id)
    {
        $data['view'] = Receivable::where('id', $id)->first();
        $pdf = PDF::loadView('admin.accounting.receivable.view', $data);
    
        return $pdf->download('invoice.pdf');
    }
}
