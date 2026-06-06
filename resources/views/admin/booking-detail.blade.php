@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    body {
        background-color: #f8f9fa;
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Booking Details</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Booking Details</li>
            </ul>
            <div class="w-75 d-flex justify-content-end">
                <button class="btn btn-success" type="button" onclick="printDiv('detail-div')">Print</button>
            </div>
        </div>
        <div class="main-body">
            <div class="row my-4" id="detail-div" style="display: none;">
                <div class="w-100">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Booking Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Submission Date:</span>
                                    <span style="width: 60%;">{{ date("d F, Y", strtotime(@$yatri->created_at)) }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Package Type:</span>
                                    <span style="width: 60%;">Single Occupancy</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Hotel Name:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->hotel->name) ? @$yatri->hotel->name : "N/A" }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Total Amount:</span>
                                    <span style="width: 60%;">{{ @$yatri->package_type }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 w-50" style="list-style-type: none;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Package Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->package->name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Ticket Type:</span>
                                    <span style="width: 60%;">{{ ucfirst(str_replace("_", " ", @$yatri->ticket_type)) }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Bus #:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->bus->bus_number) ? @$yatri->bus->bus_number : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-100 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Yatri's Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <h4 class="mb-4 w-100" style="padding-left: 30px;">Yatri Details</h4>
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Applicant Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->last_name.' '.@$yatri->first_name.' '.@$yatri->middle_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Email:</span>
                                    <span style="width: 60%;">{{ @$yatri->email }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Phone:</span>
                                    <span style="width: 60%;">{{ @$yatri->phone }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Father Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->father_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Mother Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->mother_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Passport:</span>
                                    <span style="width: 60%;">{{ @$yatri->passport }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Address:</span>
                                    <span style="width: 60%;">{{ @$yatri->address }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">State:</span>
                                    <span style="width: 60%;">{{ @$yatri->state }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Secretary Name:</span>
                                    <span style="width: 60%;">{{ @$yatri->secetary_name }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Secretary Phone:</span>
                                    <span style="width: 60%;">{{ @$yatri->secretary_phone }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Uploaded Photo:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->photo))
                                            <img src="{{asset('photo_uploads')}}/{{$yatri->photo}}" style="width: 170px; height: 140px;">
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                                <li class="w-100 row mb-3">
                                    <span style="width: 40%; font-weight: 500;">Uploaded Green Card:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->green_card))
                                            <img src="{{asset('greencard_uploads')}}/{{$yatri->green_card}}" style="width: 170px; height: 140px;">
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Gurdwara Name:</span>
                                    <span style="width: 60%;">{{ (!empty(@$yatri->gurdwara->gurdwara_name)) ? @$yatri->gurdwara->gurdwara_name : "N/A" }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Place of Birth:</span>
                                    <span style="width: 60%;">{{ @$yatri->place_birth }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Date of Birth:</span>
                                    <span style="width: 60%;">{{ @$yatri->dob }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Nationality:</span>
                                    <span style="width: 60%;">{{ @$yatri->passport_country }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Gender:</span>
                                    <span style="width: 60%;">{{ @$yatri->gender }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Profession:</span>
                                    <span style="width: 60%;">{{ @$yatri->profession }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">City:</span>
                                    <span style="width: 60%;">{{ @$yatri->city }}</span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Zip:</span>
                                    <span style="width: 60%;">{{ @$yatri->zip }}</span>
                                </li>
                                <li class="w-100 row mb-3">
                                    <span style="width: 40%; font-weight: 500;">Uploaded Passport:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->us_passport))
                                            <img src="{{asset('passport_uploads')}}/{{$yatri->us_passport}}" style="width: 170px; height: 140px;">
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                                <li class="w-100 row">
                                    <span style="width: 40%; font-weight: 500;">Uploaded ID/Driving License:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->driving_license))
                                            <img src="{{asset('drivinglicense_uploads')}}/{{$yatri->driving_license}}" style="width: 170px; height: 140px;">
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-100 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 w-50" style="list-style-type: none; padding-left: 50px;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Payment Type:</span>
                                    <span style="width: 60%;">{{ @$yatri->payment_type }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Bank Receipt:</span>
                                    <span style="width: 60%;">
                                        @if(!empty($yatri->bank_receipt))
                                            <img src="{{asset('bank_receipt')}}/{{$yatri->bank_receipt}}" style="width: 170px; height: 140px;">
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 w-50" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Routing Number:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->routing_number) ? @$yatri->routing_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Account Number:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->account_number) ? @$yatri->account_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span style="width: 40%; font-weight: 500;">Amount:</span>
                                    <span style="width: 60%;">{{ !empty(@$yatri->amount) ? "$".@$yatri->amount : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Booking Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Submission Date:</span>
                                    <span class="col-lg-8">{{ date("d F, Y", strtotime(@$yatri->created_at)) }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Package Type:</span>
                                    <span class="col-lg-8">Single Occupancy</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Hotel Name:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->hotel->name) ? @$yatri->hotel->name : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Total Amount:</span>
                                    <span class="col-lg-8">{{ @$yatri->package_type }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Package Name:</span>
                                    <span class="col-lg-8">{{ @$yatri->package->name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Ticket Type:</span>
                                    <span class="col-lg-8">{{ ucfirst(str_replace("_", " ", @$yatri->ticket_type)) }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Bus #:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->bus->bus_number) ? @$yatri->bus->bus_number : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Yatri's Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <h4 class="mb-4 col-lg-12">Yatri Details</h4>
                            <h5 class="mb-4 col-lg-12 mt-4">{{ @$yatri->yatri_id }}</h5>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Applicant Name:</span>
                                    <span class="col-lg-8">{{ @$yatri->last_name.' '.@$yatri->first_name.' '.@$yatri->middle_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Email Address:</span>
                                    <span class="col-lg-8">{{ @$yatri->email }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Phone Number:</span>
                                    <span class="col-lg-8">{{ @$yatri->phone }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Father Name:</span>
                                    <span class="col-lg-8">{{ @$yatri->father_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Mother Name:</span>
                                    <span class="col-lg-8">{{ @$yatri->mother_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Passport:</span>
                                    <span class="col-lg-8">{{ @$yatri->passport }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Address:</span>
                                    <span class="col-lg-8">{{ @$yatri->address }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">State:</span>
                                    <span class="col-lg-8">{{ @$yatri->state }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Secretary Name:</span>
                                    <span class="col-lg-8">{{ @$yatri->secetary_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Secretary Phone:</span>
                                    <span class="col-lg-8">{{ @$yatri->secretary_phone }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Uploaded Photo:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($yatri->photo))
                                            <a href="{{asset('photo_uploads')}}/{{$yatri->photo}}" data-lightbox="image-gallery">
                                                <img src="{{asset('photo_uploads')}}/{{$yatri->photo}}" style="width: 170px; height: 140px;">
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row mb-3">
                                    <span class="col-lg-4" style="font-weight: 500;">Uploaded Green Card:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($yatri->green_card))
                                            <a href="{{asset('greencard_uploads')}}/{{$yatri->green_card}}" data-lightbox="image-gallery">
                                                <img src="{{asset('greencard_uploads')}}/{{$yatri->green_card}}" style="width: 170px; height: 140px;">
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Gurdwara Name:</span>
                                    <span class="col-lg-8">{{ (!empty(@$yatri->gurdwara->gurdwara_name)) ? @$yatri->gurdwara->gurdwara_name : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Place of Birth:</span>
                                    <span class="col-lg-8">{{ @$yatri->place_birth }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Date of Birth:</span>
                                    <span class="col-lg-8">{{ @$yatri->dob }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Nationality:</span>
                                    <span class="col-lg-8">{{ @$yatri->passport_country }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Gender:</span>
                                    <span class="col-lg-8">{{ @$yatri->gender }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Profession:</span>
                                    <span class="col-lg-8">{{ @$yatri->profession }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">City:</span>
                                    <span class="col-lg-8">{{ @$yatri->city }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Zip:</span>
                                    <span class="col-lg-8">{{ @$yatri->zip }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row mb-3">
                                    <span class="col-lg-4" style="font-weight: 500;">Uploaded Passport:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($yatri->us_passport))
                                            <a href="{{asset('passport_uploads')}}/{{$yatri->us_passport}}" data-lightbox="image-gallery">
                                                <img src="{{asset('passport_uploads')}}/{{$yatri->us_passport}}" style="width: 170px; height: 140px;">
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Uploaded ID/Driving License:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($yatri->driving_license))
                                            <a href="{{asset('drivinglicense_uploads')}}/{{$yatri->driving_license}}" data-lightbox="image-gallery">
                                                <img src="{{asset('drivinglicense_uploads')}}/{{$yatri->driving_license}}" style="width: 170px; height: 140px;">
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Payment Type:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->payment_type) ? @$yatri->payment_type : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Bank Receipt:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($yatri->bank_receipt))
                                            <a href="{{asset('bank_receipt')}}/{{$yatri->bank_receipt}}" data-lightbox="image-gallery">
                                                <img src="{{asset('bank_receipt')}}/{{$yatri->bank_receipt}}" style="width: 170px; height: 140px;">
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Routing Number:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->routing_number) ? @$yatri->routing_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Account Number:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->account_number) ? @$yatri->account_number : "N/A" }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Amount:</span>
                                    <span class="col-lg-8">{{ !empty(@$yatri->amount) ? "$".@$yatri->amount : "N/A" }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
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