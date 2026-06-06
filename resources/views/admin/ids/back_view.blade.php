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
        /*width: 122px;*/
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
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div style="width: 440px; height: 278px; display: flex; justify-content: center; float: left; margin-top: 10px !important; padding-bottom: 45px !important; border-bottom: 1px dotted #000; margin-left: 10px; padding-left: 80px;">
                    <main id="main" class="output" style="position: relative;">
                        <img src="{{ asset("assets2/images/background.png") }}" style="margin-top: 50px;">
                        <div class="ac-card mb-0" style="width: 400px; height: 265px; position: absolute; top: 0; right: -80%; padding: 15px;">  
                            <div class="d-flex" style="height: 100%; padding-top: 10px;">
                                <div class="ac-card-1" style="width: 100%; text-align: center;">
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-left: 30px !important;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="font-weight-bold" style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 17px; color: #167eff !important; font-weight: 700; margin-left: -10px !important;"><img src="{{ asset('assets/images2/phone.png') }}" width="25px;"> {{$back_ids->phone}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-bottom: 0px; margin-left: -20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 15px; font-weight: 700; margin-left: 20px !important;"><img src="{{ asset('assets/images2/hotel.png') }}" width="30px;"> {{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
           <div class="row my-4">
                <div class="offset-lg-2 col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="offset-lg-2 col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="offset-lg-2 col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="offset-lg-2 col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="col-lg-4 d-flex justify-content-center mb-3">
                    <main id="main" class="output">
                        <div class="ac-card mb-0 p-3">  
                            <div class="d-flex pt-2">
                                <div class="ac-card-1 text-center">
                                    <p class="font-weight-bold" style="margin-left: 10px; font-size: 16px;">{{$back_ids->name}}, {{$back_ids->role}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">Emergency Contact No.</p>
                                    <p class="font-weight-bold" style="font-size: 16px; color: #167eff !important;">{{$back_ids->phone}}</p>
                                    <p class="mb-0 font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel}}</p>
                                    <p class="font-weight-bold" style="font-size: 16px;">{{$back_ids->hotel1}}</p>
                                </div>
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