<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itenary;
use App\Models\Adult;
use App\Models\Child;
use App\Models\Infant;

class ItenariesController extends Controller
{
    public function index(){
        $itenary_data =Itenary::all();
        return view('admin.itenaries',['itenaries'=>$itenary_data]);
    }
    public function iternaries_list(){
        $itenary_data =Itenary::all();
        return view('admin.iternaries-list',['itenaries'=>$itenary_data]);
    }
    public function delete($id){
        $itenary = Itenary::WHERE('id','=',$id);
       
        if($itenary)
        {
            
            $itenary->delete();
           

            return redirect('admin/itenaries')->with('success', "Student deleted");
        }
        else
        {
            return back()->with('error', "Record Not Found");
        }
    }
}