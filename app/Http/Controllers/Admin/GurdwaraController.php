<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gurdwara;
use DB;

class GurdwaraController extends Controller
{
    public function index()
    {
        $data = Gurdwara::all();
        return view('admin.gurdwara.gurdwara',["gurdwaras"=>$data]);
    }
    
    public function undertaking()
    {
        return view('admin.undertaking');
    }
    
    public function gurdwaras(Request $request)
    {
        $gurdwaras = new Gurdwara;
        if(!empty($request->state) && $request->state !== "all") {
            $gurdwaras = $gurdwaras->where("state", $request->state);
        }
        if(!empty($request->color) && $request->color !== "all") {
            $gurdwaras = $gurdwaras->where("color", $request->color);
        }
        $gurdwaras = $gurdwaras->get();
        $all_states = DB::table('gurdwara')
            ->select('state', DB::raw('MAX(id) as max_id'), DB::raw('COUNT(*) as gurdwara_count'))
            ->groupBy('state')
            ->get();
        
        return view('admin.gurdwara.all_gurdwaras', ["gurdwaras" => $gurdwaras, "all_states" => $all_states]);
    }

    public function gurdwara_delete($id)
    {
        $gurdwara = Gurdwara::WHERE('id','=',$id);
        if($gurdwara)
        {
            $gurdwara->delete();
            return back()->with("success", "Gurdwara Deleted Successfully");
        }
    }

    public function store(Request $request)
    {
        $gurdwara = new Gurdwara();
        if($file=$request->hasfile('gurdwara_image'))
        {
            $request->gurdwara_image = \App\Support\ImageHelper::save($request->file('gurdwara_image'), 'gurdwara_images', ['width' => 1280, 'height' => 850, 'mode' => 'cover', 'quality' => 90]);
        }
        $gurdwara ->create([
            'pardan_name' => $request->pardan_name,
            'gurdwara_name' => $request->gurdwara_name,
            'phone_no' => $request->phone_no,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'email_address' => $request->email_address,
            'secretary_name' => $request->secretary_name,
            'secretary_phone_no' => $request->secretary_phone_no,
            'head_garanti_name' => $request->head_garanti_name,
            'head_garanti_phone_no' => $request->head_garanti_phone_no,
            'chairman_name' => $request->chairman_name,
            'chairman_phone_no' => $request->chairman_phone_no,
            'manager_name' => $request->manager_name,
            'manager_phone_no' => $request->manager_phone_no,
            'sangat' => $request->sangat,
            'color' => $request->color,
            'gurdwara_image' => $request->gurdwara_image,
        ]);

        return back()->with('success','Gurdwara Added Successfully');
    }

    public function create_gurdwara()
    {
        $data['action'] = route('admin_gurdwara');
        $data['btn_text'] = "Create";
        return view('admin.gurdwara.create_edit', $data);
    }

    public function edit_gurdwara($id)
    {
        $gurdwara = Gurdwara::where('id',$id)->first();
        if($gurdwara)
        {
            $data['gurdwara'] = $gurdwara;
            $data['action'] = route('update-gurdwara', $id);
            $data['btn_text'] = "Update";
            return view('admin.gurdwara.create_edit', $data);
        }
        else
        {
            return back()->with('Record not found');
        }
    }

    public function update_gurdwara(Request $request)
    {
        $gurdwara = Gurdwara::findorfail($request->id);
        if($gurdwara)
        {
            if($file=$request->hasfile('gurdwara_image'))
            {
                $request->gurdwara_image = \App\Support\ImageHelper::save($request->file('gurdwara_image'), 'gurdwara_images', ['width' => 1280, 'height' => 850, 'mode' => 'cover', 'quality' => 90]);
                $gurdwara->gurdwara_image = $request->gurdwara_image;
            }
            $gurdwara->pardan_name = $request->pardan_name;
            $gurdwara->gurdwara_name = $request->gurdwara_name;
            $gurdwara->phone_no = $request->phone_no;
            $gurdwara->email_address = $request->email_address;
            $gurdwara->address = $request->address;
            $gurdwara->city = $request->city;
            $gurdwara->state = $request->state;
            $gurdwara->country = $request->country;
            $gurdwara->secretary_name = $request->secretary_name;
            $gurdwara->secretary_phone_no = $request->secretary_phone_no;
            $gurdwara->head_garanti_name = $request->head_garanti_name;
            $gurdwara->head_garanti_phone_no = $request->head_garanti_phone_no;
            $gurdwara->chairman_name = $request->chairman_name;
            $gurdwara->chairman_phone_no = $request->chairman_phone_no;
            $gurdwara->manager_name = $request->manager_name;
            $gurdwara->manager_phone_no = $request->manager_phone_no;
            $gurdwara->sangat = $request->sangat;
            $gurdwara->color = $request->color;
            $gurdwara->save();
            return redirect()->route('admin_gurdwara')->with('success','Record updated successfully');
        }
        else
        {
            return back()->with('error','Something Went Wrong');
        }
    }
}
