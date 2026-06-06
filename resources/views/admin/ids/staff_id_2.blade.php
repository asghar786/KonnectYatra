@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    body {
        background-color: #f8f9fa;
    }
    .ac-card{
        background-image: url("{{ asset('assets2/images/background.png') }}");
        background-position: center; 
        background-repeat: no-repeat; 
    }
    .output {
        justify-content: center;
        align-content: start;
        padding-top: 1rem;
    }
    .ac-card {
        grid-template-columns: 173px 1fr 50px;
        background-color: #fff;
        width: 355px;
        height: 240px;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .ac-icon {
        width: 40px;
        margin-top: 10px;
    }
    .ac-card-image {
        width: 100px;
        margin: 10px 0 0 15px;
    }
    .ac-card-1 {
        width: 122px;
        margin: 10px 0 0 15px;
    }
    .ac-card-2 {
        width: 80px;
        margin: 10px 0 0 15px;
    }
    .ac-card-info {
        font-size: 1.15rem;
        margin: 0;
    }
    .ac-card-info p {
        margin-top: 8px;
        line-height: 1.3;
    }
    .id-footer{
        background-color: #2e3092;
        color: white;
        padding: 15px 15px;
        margin-top: 4px;
    }
    .ac-logo {
        width: 125px;
        margin-left: 10px;
    }
    .skdf{
        font-size: 14px;
    }
    .border-dark{
        border: 1px solid;
        width: 120px;
        height: 72px;
        text-align: center;
        border-radius: 10px;
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri ID</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/ids') }}">IDs</a></li>
                <li>Yatri ID</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                <button class="btn btn-success" type="button" onclick="printDiv('yatri_id')">Print</button>
                <a class="btn btn-info ml-2" href="{{ url('admin/back-view') }}">Back View</a>
            </div>
        </div>
        <div class="main-body pt-3">
            <div class="row" id="yatri_id" style="width: 100%; display: none;">
                <div style="width: 34%; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 355px; height: 240px; position: absolute; top: 0; right: -60%;">
                            <img style="width: 100%;" src="{{ asset('assets2/images/imgage-card.png') }}">    
                            <div class="d-flex" style="max-height: 120px;">
                                <div class="ac-card-image" style="width: 100px; height: 110px; margin: 10px 0 0 15px;">
                                    <img class="card-img-top" src="{{ asset('assets/images2/producer.jpg') }}" alt="image" style="width: 100%; height: 100%;">
                                </div>
                                <div class="ac-card-1" style="width: 122px; height: 110px; margin: 10px 0 0 15px; padding-top: 5px;">
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">Role</p>
                                    <p class="mb-0 skdf" style="font-size: 14px;">Producer/Director</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">CNIC #</p>
                                    <p class="mb-0 skdf" style="font-size: 14px;">35102-2581672-0</p>
                                </div>
                                <div class="ac-card-2 text-center" style="width: 80px; height: 110px; margin: 10px 0 0 15px;">
                                    <img src="{{ asset('assets2/images/ds-removebg-preview.png') }}" style="width: 50px;">
                                    <div class="border-dark" style="margin-top: 10px; border-color: #bbb !important; border: 1px solid; width: 100%; height: 72px; text-align: center; border-radius: 10px;">
                                        <p class="font-weight-bold" style="font-size: 14px; margin-top: 5px;">Crew</p>
                                        <p class="font-weight-bold" style="font-size: 14px; margin-top: -25px;">
                                            Member
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="font-weight-bold" style="margin-left: 15px; margin-right: 15px; margin-bottom: 0px; display: flex; justify-content: space-between;">
                                <span style="font-size: 14px;">Mahwish Fazal</span>
                                <span style="font-size: 11px;">Father's Name: Fazal Ur Rehman</span>
                            </p>
                            <div style="background-color: #2e3092 !important; width: 355px;">
                                <img src="{{ asset('assets2/images/footer_img.png') }}" style="width: 100%; height: 25px;">
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 34%; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 355px; height: 240px; position: absolute; top: 0; right: -60%;">
                            <img style="width: 100%;" src="{{ asset('assets2/images/imgage-card.png') }}">    
                            <div class="d-flex" style="max-height: 120px;">
                                <div class="ac-card-image" style="width: 100px; height: 110px; margin: 10px 0 0 15px;">
                                    <img class="card-img-top" src="{{ asset('assets/images2/cameraman-1.jpg') }}" alt="image" style="width: 100%; height: 100%;">
                                </div>
                                <div class="ac-card-1" style="width: 122px; height: 110px; margin: 10px 0 0 15px; padding-top: 5px;">
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">Role</p>
                                    <p class="mb-0 skdf" style="font-size: 14px;">Cameraman</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">CNIC #</p>
                                    <p class="mb-0 skdf" style="font-size: 14px;">13101-0406405-1</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">(Panja Sahib)</p>
                                </div>
                                <div class="ac-card-2 text-center" style="width: 80px; height: 110px; margin: 10px 0 0 15px;">
                                    <img src="{{ asset('assets2/images/ds-removebg-preview.png') }}" style="width: 50px;">
                                    <div class="border-dark" style="margin-top: 10px; border-color: #bbb !important; border: 1px solid; width: 100%; height: 72px; text-align: center; border-radius: 10px;">
                                        <p class="font-weight-bold" style="font-size: 14px; margin-top: 5px;">Crew</p>
                                        <p class="font-weight-bold" style="font-size: 14px; margin-top: -25px;">
                                            Member
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="font-weight-bold" style="margin-left: 15px; margin-right: 15px; margin-bottom: 0px; display: flex; justify-content: space-between;">
                                <span style="font-size: 14px;">Khurram Shahzad</span>
                                <span style="font-size: 11px;">Father's Name: M. Javed</span>
                            </p>
                            <div style="background-color: #2e3092 !important; width: 355px;">
                                <img src="{{ asset('assets2/images/footer_img.png') }}" style="width: 100%; height: 25px;">
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 34%; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 355px; height: 240px; position: absolute; top: 0; right: -60%;">
                            <img style="width: 100%;" src="{{ asset('assets2/images/imgage-card.png') }}">    
                            <div class="d-flex" style="max-height: 120px;">
                                <div class="ac-card-image" style="width: 100px; height: 110px; margin: 10px 0 0 15px;">
                                    <img class="card-img-top" src="{{ asset('assets/images2/cameraman-2.jpg') }}" alt="image" style="width: 100%; height: 100%;">
                                </div>
                                <div class="ac-card-1" style="width: 122px; height: 110px; margin: 10px 0 0 15px; padding-top: 5px;">
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">Role</p>
                                    <p class="mb-0 skdf" style="font-size: 14px;">Cameraman</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">CNIC #</p>
                                    <p class="mb-0 skdf" style="font-size: 14px;">35201-3034856-3</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2; font-family: Rubik;font-size: 14px;">(Lahore)</p>
                                </div>
                                <div class="ac-card-2 text-center" style="width: 80px; height: 110px; margin: 10px 0 0 15px;">
                                    <img src="{{ asset('assets2/images/ds-removebg-preview.png') }}" style="width: 50px;">
                                    <div class="border-dark" style="margin-top: 10px; border-color: #bbb !important; border: 1px solid; width: 100%; height: 72px; text-align: center; border-radius: 10px;">
                                        <p class="font-weight-bold" style="font-size: 14px; margin-top: 5px;">Crew</p>
                                        <p class="font-weight-bold" style="font-size: 14px; margin-top: -25px;">
                                            Member
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="font-weight-bold" style="margin-left: 15px; margin-right: 15px; margin-bottom: 0px; display: flex; justify-content: space-between;">
                                <span style="font-size: 14px;">Farhan Ali</span>
                                <span style="font-size: 11px;">Father's Name: Iftikhar Ali</span>
                            </p>
                            <div style="background-color: #2e3092 !important; width: 355px;">
                                <img src="{{ asset('assets2/images/footer_img.png') }}" style="width: 100%; height: 25px;">
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="row my-4">
                <div class="offset-lg-2 col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0">
                            <img style="width: 100%;" src="{{ asset('assets2/images/imgage-card.png') }}">    
                            <div class="d-flex" style="max-height: 120px;">
                                <div class="ac-card-image">
                                    <img class="card-img-top" src="{{ asset('assets/images2/producer.jpg') }}" alt="image" style="width: 100%; height: 100%;">
                                </div>
                                <div class="ac-card-1 pt-3">
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">Role</span></p>
                                    <p class="mb-0 skdf">Producer/Director</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">CNIC #</p>
                                    <p class="mb-0 skdf">35102-2581672-0</p>
                                </div>
                                <div class="ac-card-2 text-center">
                                    <img src="{{ asset('assets2/images/ds-removebg-preview.png') }}" style="width: 50px;">
                                    <div class="border-dark mt-2 p-1" style="border-color: #bbb !important; width: 100%;">
                                        <p class="mb-0 mt-1 font-weight-bold" style="font-size: 14px;">Crew</p>
                                        <p class="mb-0 font-weight-bold" style="font-size: 14px;">
                                            Member
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="mx-2 mb-0 font-weight-bold d-flex justify-content-between">
                                <span class="ml-1" style="font-size: 14px;">Mahwish Fazal</span>
                                <span style="font-size: 11px;">Father's Name: Fazal Ur Rehman</span>
                            </p>
                            <div class="id-footer pt-0 mt-0 px-2">
                                <span style="font-size: 10px;">
                                    18502 Hillside Avenue, Jamaica, NY 11432
                                </span>
                                <span style="font-size: 11px;" class="ml-4">
                                    www.konnectyatra.org
                                </span>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0">
                            <img style="width: 100%;" src="{{ asset('assets2/images/imgage-card.png') }}">    
                            <div class="d-flex" style="max-height: 120px;">
                                <div class="ac-card-image">
                                    <img class="card-img-top" src="{{ asset('assets/images2/cameraman-1.jpg') }}" alt="image" style="width: 100%; height: 100%;">
                                </div>
                                <div class="ac-card-1 pt-1">
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">Role</span></p>
                                    <p class="mb-0 skdf">Cameraman</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">CNIC #</p>
                                    <p class="mb-0 skdf">13101-0406405-1</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">(Panja Sahib)</p>
                                </div>
                                <div class="ac-card-2 text-center">
                                    <img src="{{ asset('assets2/images/ds-removebg-preview.png') }}" style="width: 50px;">
                                    <div class="border-dark mt-2 p-1" style="border-color: #bbb !important; width: 100%;">
                                        <p class="mb-0 mt-1 font-weight-bold" style="font-size: 14px;">Crew</p>
                                        <p class="mb-0 font-weight-bold" style="font-size: 14px;">
                                            Member
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="mx-2 mb-0 font-weight-bold d-flex justify-content-between">
                                <span class="ml-1" style="font-size: 14px;">Khurram Shahzad</span>
                                <span style="font-size: 11px;">Father's Name: M. Javed</span>
                            </p>
                            <div class="id-footer pt-0 mt-0 px-2">
                                <span style="font-size: 10px;">
                                    18502 Hillside Avenue, Jamaica, NY 11432
                                </span>
                                <span style="font-size: 11px;" class="ml-4">
                                    www.konnectyatra.org
                                </span>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="offset-lg-2 col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0">
                            <img style="width: 100%;" src="{{ asset('assets2/images/imgage-card.png') }}">    
                            <div class="d-flex" style="max-height: 120px;">
                                <div class="ac-card-image">
                                    <img class="card-img-top" src="{{ asset('assets/images2/cameraman-2.jpg') }}" alt="image" style="width: 100%; height: 100%;">
                                </div>
                                <div class="ac-card-1 pt-1">
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">Role</span></p>
                                    <p class="mb-0 skdf">Cameraman</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">CNIC #</p>
                                    <p class="mb-0 skdf">35201-3034856-3</p>
                                    <p class="font-weight-bold mb-0 skdf" style="line-height: 1.2;">(Lahore)</p>
                                </div>
                                <div class="ac-card-2 text-center">
                                    <img src="{{ asset('assets2/images/ds-removebg-preview.png') }}" style="width: 50px;">
                                    <div class="border-dark mt-2 p-1" style="border-color: #bbb !important; width: 100%;">
                                        <p class="mb-0 mt-1 font-weight-bold" style="font-size: 14px;">Crew</p>
                                        <p class="mb-0 font-weight-bold" style="font-size: 14px;">
                                            Member
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="mx-2 mb-0 font-weight-bold d-flex justify-content-between">
                                <span class="ml-1" style="font-size: 14px;">Farhan Ali</span>
                                <span style="font-size: 11px;">Father's Name: Iftikhar Ali</span>
                            </p>
                            <div class="id-footer pt-0 mt-0 px-2">
                                <span style="font-size: 10px;">
                                    18502 Hillside Avenue, Jamaica, NY 11432
                                </span>
                                <span style="font-size: 11px;" class="ml-4">
                                    www.konnectyatra.org
                                </span>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
    <script type="text/javascript">
        function printDiv(divName) {

            var printContents = document.getElementById(divName).innerHTML;

            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

                // document.body.style.marginTop="-45px";

            window.print();

            document.body.innerHTML = originalContents;

            location.reload();

        }
    </script>
@endsection