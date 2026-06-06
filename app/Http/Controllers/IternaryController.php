<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itenary;
use App\Models\Itenarychild;
use App\Models\Adult;
use App\Models\Infant;
use App\Models\Multicity;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IternaryController extends Controller
{
    public function index()
    {
        $itenary_data = DB::table('itenary')->select('id')->get();
        $all_packages = Package::all();
        return view('iternary', ['itenaries'=>$itenary_data, 'all_packages'=>$all_packages]);
    }
  
    public function store(Request $req)
    {
     

    
    $iternary = new Itenary();

    $iternary->fill([
        'pass_id'=>$req->pass_id,
        'category'=>$req->trip,
        'from' => $req->from,
        'to'=>$req->to,
        'depart'=>$req->departdate,
        'return'=>$req->returndate,
        'class'=>$req->class,
        'name'=>$req->name,
        'email'=>$req->email,
        'contact'=>$req->contact,
        'passengers'=>$req->passengers,
        // 'firstnamea'=>$req->fnamea,
        // 'lastnamea'=>$req->lnamea,
        // 'doba'=>$req->doba,
        // 'firstnamec'=>$req->fnamec,
        // 'lastnamec'=>$req->lnamec,
        // 'dobc'=>$req->dobc,
        // 'firstnamei'=>$req->fnamei,
        // 'lastnamei'=>$req->lnamei,
        // 'dobi'=>$req->dobi,
        
    ]);    

    $iternary->save();

  if($req->trip == "multicities"){
    if (is_array($req->frommulti) && !empty($req->frommulti)) {
        for($i=0; $i < count($req->frommulti) && ($req->tomulti) && ($req->departdatemulti); $i++){
        
            $multicity[]=[
                'pass_id'=>$iternary->id,
                'from' => $req->frommulti[$i],
                 'to'=>$req->tomulti[$i],
                 'depart'=>$req->departdatemulti[$i],
            ];
           
        }
    } else {
        $multicity[]=[
            'pass_id'=>$iternary->id,
            'from' => $req->from,
             'to'=>$req->to,
             'depart'=>$req->departdate,
        ];
    }
    
    Multicity::insert($multicity);
  }
   
    if(($req->fnamea) && ($req->lnamea) && ($req->doba))
    {
        for($i=0; $i < count($req->fnamea) && ($req->lnamea) && ($req->doba); $i++){
        
            $adult[]=[
                'pass_id'=>$iternary->id,
                'firstnamea'=>$req->fnamea[$i],
                'lastnamea'=>$req->lnamea[$i],
                'doba'=>$req->doba[$i],
            ];

        }

        Adult::insert($adult);
    }

    if(($req->fnamec) && ($req->lnamec) && ($req->dobc))
    {

        for($i=0; $i < count($req->fnamec) && ($req->lnamec) && ($req->dobc); $i++){
        
            $child[]=[
                'pass_id'=>$iternary->id,
                'firstnamec'=>$req->fnamec[$i],
                'lastnamec'=>$req->lnamec[$i],
                'dobc'=>$req->dobc[$i],
            ];

        }

        Itenarychild::insert($child);
    }

    if(($req->fnamei) && ($req->lnamei) && ($req->dobi))
    {
        for($i=0; $i < count($req->fnamei) && ($req->lnamei) && ($req->dobi); $i++){
 
            $infant[]=[
                'pass_id'=>$iternary->id,
                'firstnamei'=>$req->fnamei[$i],
                'lastnamei'=>$req->lnamei[$i],
                'dobi'=>$req->dobi[$i],
            ];
        
           }
        
           Infant::insert($infant);
    }   

    return back()->with('success',' Added Successfully');

    }

    // public function showItenary($id)
    // {
    //     $data = Itenary::findorFail($id);
    //     $data2 = Itenarychild::WHERE('pass_id' , '=' , $id)->get()->all();
    //     return view('admin.itenary_ticket_details',['itenarychild_data'=>$data2]);
    // }
}
