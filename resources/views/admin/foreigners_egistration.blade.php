@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    input:focus-visible{
        border-bottom: 1px solid black !important;
/*        padding: 0px 10px;*/
border: none !important;
outline: none !important;
}

input{
    border: none !important; 
    border-bottom: 1px solid black !important;
/*        padding: 0px 10px;*/
}
label{
    font-weight: 400 !important;
}
@media (min-width: 1200px){

    .container {
        max-width: 1056px !important;
    }
}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <div class="d-flex w-50">
                <h4 class="breadcrumb-title">Foreigners Registration Form</h4>
                <ul class="db-breadcrumb-list">
                    <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                    <li>Foreigners Rules</li>
                </ul>
            </div>
            <div class="w-50 d-flex justify-content-end">
                <button class="btn bg-warning" onclick="printDiv()">Print</button>
            </div>
        </div>
        <div class="main-body">
            <div class="container d-flex justify-content-center">
                <div class="row" id="printableTable" style="width: 793.92px;">
                    <div class="row no-gutters col-md-12" style="padding: 0px 50px;">
                        <div class="col-md-12 col-md-offset-3">
                            <h2 class="" style="text-align: center;">Form ‘C’</h2>
                            <p class="" style="text-align: center;">The Registration of Foreigners Rules, 1966 (See rule)
                                <br> Temporary Certificate of Registration
                            </p>
                        </div>
                        <div class="col-md-12 mb-5" style="display: flex; justify-content: center;margin-bottom: 3rem!important;">
                            <label>Serial No. <input type="text" name="" value="{{ $data->id }}" style=" border: none !important; border-bottom: 1px solid black !important;text-align: center; width: 60px;"> /2024</label>
                        </div>
                        <div class="col-md-12 mb-5 d-flex justify-content-center"  style="display: flex; justify-content: center;margin-bottom: 3rem!important;">
                            <label style="line-height: 40px;">Miss /Mr.
                                <input class="input1" type="text" value="{{ $data->first_name }} {{ $data->middle_name }} {{ $data->last_name }}" class="mx-2 text-center" name="" style=" text-align:center; height: 18px;width: 320px; border: none !important; border-bottom: 1px solid black !important;">Foreigner of
                                <input class="input2" type="text" class="mx-2 text-center" value="{{$data->passport_country}}" name="" style=" text-align:center; height: 18px;width: 205px; border: none !important; border-bottom: 1px solid black !important;">Nationality holding Passport No.
                                <input class="input3" type="text" value="{{ $data->passport }}" class="mx-2 text-center" name=""  style=" text-align:center; height: 18px;width: 190px; border: none !important; border-bottom: 1px solid black !important;">issued at 
                                <input value="{{ date('d-m-Y', strtotime( $data->issue_date)); }}" class="input4" type="text" class="mx-2 text-center" name="" style=" text-align:center; height: 18px;width: 190px; border: none !important; border-bottom: 1px solid black !important; border: none !important; border-bottom: 1px solid black !important;"> 
                                Arrived Pakistan on
                                @if($data->package->package_type == "Vaisakhi")
                                <input value="12 April" class="input5" type="text" class="mx-2 text-center" name="" style=" text-align:center; height: 18px; border: none !important; border-bottom: 1px solid black !important;">
                                @else
                                <input value="17 November" class="input5" type="text" class="mx-2 text-center" name="" style=" text-align:center; height: 18px; border: none !important; border-bottom: 1px solid black !important;">
                                @endif
                                , 2024 by flight No.
                                <input value="" class="input6" type="text" style=" text-align:center; height: 18px; border: none !important; border-bottom: 1px solid black !important;" class="mx-2 text-center" name="">(Mode of transport) is proceeding to 
                                <input value="Islamabad" class="input7" type="text" class="mx-2 text-center" name="" value="ISLAMABAD" style=" text-align:center; height: 18px; border: none !important; border-bottom: 1px solid black !important;"> where her/his residential address would be:
                                <input value="{{ @$data->hotel->name }}" class="input8" type="text" class="mx-2 text-center" name=""  style=" text-align:center; height: 18px;width: 350px; border: none !important; border-bottom: 1px solid black!important;"> <br> Address:
                                <input value="{{$data->address}}" class="input9" type="text" class="mx-2 text-center" name="" style=" text-align:center; height: 18px;width: 590px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center">
                            <p><span style="padding-left: 105px;">She/he</span> has been temporarily registered at <span style="text-decoration: underline;">IIAP ISLAMABAD FIA CHECK POST, IIAP ISB.,</span> and is directed to report (place of arrival) the Registration Officer at <span style="text-decoration-line: underline;">DPO/CPO OFFICE </span> as soon as possible after his / her arrival at the place of stay but within <span style="text-decoration-line: underline;"> 24hrs / 07 </span> days of the date of issue of her / his certificate of the purpose of receiving her / his certificate of Registration in part-II of from “B”.</p>
                        </div>
                        <div class="col-md-12 mb-5 d-flex justify-content-center" style="display: flex; justify-content: center;margin-bottom: 3rem!important;">
                            <ul style="margin-left: 7.5rem!important;">
                                <li>
                                    For a period of <span style="text-decoration: underline;"> 24hrs / 07 </span> days from the date of issue of this certificate or until the report prescribed above has been made whichever, is less, this Form will be deemed to be a Certificate of Registration Officer, Magistrate or Police Officer not below the rank of Head Constable.
                                </li>
                                <li>
                                    If for any reason the report prescribed in the paragraph (1) cannot be made within 24hrs /07 days as required by paragraph (2) above, the holder of this from is directed to report in person at the office of the undersigned or the nearest Registration Office and to comply with such direction as to Registration as may then be given.
                                </li>
                                <li>
                                    The contents of this Form have been explained to the holder, thereof.
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between" style="display: flex;justify-content: space-between;">
                                <div>
                                    <label class="">Place:  Islamabad International Airport</label>
                                </div>
                                <div>
                                  <div class="d-flex flex-column" style="display: flex; flex-direction: column;">
                                    <input type="text" name="" style="border: 0px; border-bottom: 1px solid black !important;">
                                    <label class=" mt-1" style="text-align: center; margin-top: 10px;">Seal & Signature of Registration Officer</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-5 pl-0"  style="margin-bottom: 3rem!important; padding-left:0px ;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <label class="">Dated:</label>
                                    <input type="text" value="{{date('d-m-Y')}}" name="" style="text-align: center; border: 0px; border-bottom: 1px solid black !important;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<iframe name="print_frame" width="1056px" height="0" frameborder="0" src="about:blank"></iframe>
<div class="ttr-overlay"></div>

<script type="text/javascript">
    function printDiv() {
     window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML;
     window.frames["print_frame"].window.focus();
     window.frames["print_frame"].window.print();
 }
</script>
@endsection
