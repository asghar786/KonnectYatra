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
                <h4 class="breadcrumb-title">Undertaking Form</h4>
                <ul class="db-breadcrumb-list">
                    <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                    <li>Undertaking Form</li>
                </ul>
            </div>
            <div class="w-50 d-flex justify-content-end">
                <button class="btn bg-warning" onclick="printDiv()">Print</button>
            </div>
        </div>
        <div class="main-body">
            <div class="container d-flex justify-content-center">
                <div class="row" id="printableTable" style="width: 870px;">
                    <div class="row no-gutters col-md-12" style="padding: 0px 50px;">
                        <div class="col-md-12 col-md-offset-3">
                            <h2 class="" style="text-align: center; text-decoration: underline;">UNDERTAKING</h2>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center mt-3" style="margin-top: 3rem!important;">
                            <p>This is to certify that I / we wish to visit our ancestor's village. During our visit we would also meet some of our family friends. I am responsible for any mishap during this personal trip.</p>
                        </div>
                        <div class="col-md-12">
                            <p>I also understand that I / we are responsible for all expenses will occur during this personal trip.</p>
                        </div>
                        <div class="col-md-12">
                            <label style="line-height: 40px;">
                                Address of Village and Town:
                                <input value="" class="input1" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 500px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label style="line-height: 40px;">
                                Visiting to Mr.
                                <input value="" class="input2" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 260px; border: none !important; border-bottom: 1px solid black !important;">
                                NIC No.
                                <input value="" class="input3" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 260px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12 mb-5" style="margin-bottom: 3rem!important;">
                            <label style="line-height: 40px;">
                                Tel:
                                <input value="" class="input4" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 250px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label style="line-height: 40px; margin-left: 50px;">
                                1. Yatri Name & Number
                                <input value="" class="input5" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 150px; border: none !important; border-bottom: 1px solid black !important;">
                                <input value="" class="input6" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 220px; margin-left: 30px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12 mb-5" style="margin-bottom: 3rem!important;">
                            <label style="line-height: 40px; margin-left: 50px;">
                                Yatri's Passport No.
                                <input value="" class="input7" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 220px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label style="line-height: 40px; margin-left: 50px;">
                                2. Yatri Name & Number
                                <input value="" class="input5" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 150px; border: none !important; border-bottom: 1px solid black !important;">
                                <input value="" class="input6" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 220px; margin-left: 30px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12 mb-5" style="margin-bottom: 3rem!important;">
                            <label style="line-height: 40px; margin-left: 50px;">
                                Yatri's Passport No.
                                <input value="" class="input7" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 220px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label style="line-height: 40px;">
                                Signature
                                <input value="" class="input2" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 220px; margin-right: 100px; border: none !important; border-bottom: 1px solid black !important;">
                                Date
                                <input value="" class="input3" type="text" class="mx-2 text-center" name="" style="text-align:center; height: 18px;width: 220px; border: none !important; border-bottom: 1px solid black !important;">
                            </label>
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
