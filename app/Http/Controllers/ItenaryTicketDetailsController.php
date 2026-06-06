<?php

namespace App\Http\Controllers;
use App\Model\Itenary;
use App\Models\Itenarychild;
use App\Models\Adult;
use App\Models\Infant;
use App\Models\Child;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ItenaryTicketDetailsController extends Controller
{
    public function index($id)
    {
        $itenary_data=DB::table('Itenary')->where('id','=', $id)->get();
        $child_data= DB::table('itenary_child')->where('pass_id','=', $id)->get()->all();
        $adult_data= DB::table('itenary_adult')->where('pass_id','=', $id)->get()->all();
        $infant_data= DB::table('itenary_infant')->where('pass_id','=', $id)->get()->all();
        return view('admin.itenary_ticket_details',['itenaries'=>$itenary_data,'itenarychilds'=>$child_data ,'itenaryadults'=>$adult_data ,'itenaryinfants'=>$infant_data]);
    }
    public function deleteadult($id){
        $adult = Adult::WHERE('id','=',$id);
        if($adult)
        {
            $adult->delete();
            return redirect('admin/itenaries')->with('success', "Ticket  deleted");
        }
        else
        {
            return back()->with('Error', "Record Not Found");
        }
    }
    public function deletechild($id){
        $child = Child::WHERE('id','=',$id);
        if($child)
        {
            $child->delete();
            return redirect('admin/itenaries')->with('succes', "Ticket  deleted");
        }
        else
        {
            return back()->with('Error', "Record Not Found");
        }
    }
    public function deleteinfant($id){
        $infant = Infant::WHERE('id','=',$id);
        if($infant)
        {
            $infant->delete();
            return redirect('admin/itenaries')->with('success', "Ticket  deleted");
        }
        else
        {
            return back()->with('error', "Record Not Found");
        }
    }
}
