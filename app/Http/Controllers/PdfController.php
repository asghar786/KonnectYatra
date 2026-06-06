<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;
use App\Models\Visa;
use App\Models\Child;
use App\Models\Member;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class PdfController extends Controller
{
    public function getpdf($id)
    {
        $dataid = Crypt::decrypt($id);
        $data = Visa::WHERE('id','=',$dataid)->first();
        $data2 =  Child::WHERE('visa_id','=',$id)->get()->all();
        $data3 =  Member::WHERE('visa_id','=',$id)->get()->all();
        $data4 =  Visit::WHERE('visa_id','=',$id)->get()->all();
        // $pdf = PDF::loadView('admin.pdf.mypdf',["visa"=>$data],["children"=>$data2],["members"=>$data3]);
        $pdf = PDF::loadView('admin.pdf.mypdf',['visa'=>$data,'children'=>$data2,'members'=>$data3, 'visits'=>$data4]);
        return $pdf->stream();
    }
}
