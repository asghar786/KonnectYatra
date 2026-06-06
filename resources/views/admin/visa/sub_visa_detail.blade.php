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
            <h4 class="breadcrumb-title">Visa Details</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Visa Details</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row my-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Applicant Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Visa Category:</span>
                                    <span class="col-lg-8">Pilgrim Tourists</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Visa Sub-category:</span>
                                    <span class="col-lg-8">Sikhs Foreign Nationals With Indian Origin</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Application Type:</span>
                                    <span class="col-lg-8">Entry</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Visa Type:</span>
                                    <span class="col-lg-8">Single Entry</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Visit Purpose:</span>
                                    <span class="col-lg-8">For Holy Journey</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Visa Duration:</span>
                                    <span class="col-lg-8">1 Month</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Country:</span>
                                    <span class="col-lg-8">{{ @$visa->nationality }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Mission:</span>
                                    <span class="col-lg-8">{{ @$visa->package->state }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Entry Port:</span>
                                    <span class="col-lg-8">Islamabad Airport</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Departure Port:</span>
                                    <span class="col-lg-8">Lahore Airport</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Arrival date:</span>
                                    <span class="col-lg-8">{{ @$visa->package->package_details->day_1 }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Departure Date:</span>
                                    <span class="col-lg-8">{{ @$visa->package->package_details->day_8 }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Passport/Document No:</span>
                                    <span class="col-lg-8">{{ @$visa->passport }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Passport Country:</span>
                                    <span class="col-lg-8">{{ @$visa->nationality }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Issue Date:</span>
                                    <span class="col-lg-8">{{ @$visa->issue_date }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Expiry Date:</span>
                                    <span class="col-lg-8">{{ @$visa->expiry_date }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Personal Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Surname:</span>
                                    <span class="col-lg-8">{{ @$visa->last_name.' '.@$visa->first_name.' '.@$visa->middle_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Given Name(s):</span>
                                    <span class="col-lg-8">{{ @$visa->last_name.' '.@$visa->first_name.' '.@$visa->middle_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Date of Birth:</span>
                                    <span class="col-lg-8">{{ @$visa->dob }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Place of Birth:</span>
                                    <span class="col-lg-8">{{ @$visa->place_birth }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Marital Status:</span>
                                    <span class="col-lg-8">{{ @$visa->marital_status }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Gender:</span>
                                    <span class="col-lg-8">{{ @$visa->gender }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Email Address:</span>
                                    <span class="col-lg-8">{{ @$visa->email_address }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Phone Number:</span>
                                    <span class="col-lg-8">{{ @$visa->telephone }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Present Nationality:</span>
                                    <span class="col-lg-8">{{ @$visa->nationality }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Other Nationality:</span>
                                    <span class="col-lg-8">{{ @$visa->other_nationality }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Acquisition Date:</span>
                                    <span class="col-lg-8">{{ @$visa->acquisition_date }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Family Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Father Name:</span>
                                    <span class="col-lg-8">{{ @$visa->father_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Nationality:</span>
                                    <span class="col-lg-8">{{ @$visa->father_nationality }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Mother Name:</span>
                                    <span class="col-lg-8">{{ @$visa->mother_name }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Nationality:</span>
                                    <span class="col-lg-8">{{ @$visa->mother_nationality }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Visit Information</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Type of Stay:</span>
                                    <span class="col-lg-8">Hotel</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Check in date:</span>
                                    <span class="col-lg-8">{{ @$visa->package->package_details->day_1 }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Check out date:</span>
                                    <span class="col-lg-8">{{ @$visa->package->package_details->day_8 }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Address:</span>
                                    <span class="col-lg-8">{{ @$visa->hotel->address }}</span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Province:</span>
                                    <span class="col-lg-8">{{ @$visa->hotel->state }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Contact Number:</span>
                                    <span class="col-lg-8">{{ @$visa->hotel->phone }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">District:</span>
                                    <span class="col-lg-8">{{ @$visa->hotel->city }}</span>
                                </li>
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Hotel Name:</span>
                                    <span class="col-lg-8">{{ @$visa->hotel->name }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Documents / Photograph</h6>
                        </div>
                        <div class="card-body py-4 row">
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row">
                                    <span class="col-lg-4" style="font-weight: 500;">Uploaded Photo:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($visa->photo))
                                            <a href="{{asset('photo_uploads')}}/{{$visa->photo}}" data-lightbox="image-gallery">
                                                <img src="{{asset('photo_uploads')}}/{{$visa->photo}}" style="width: 170px; height: 140px;">
                                            </a>
                                            <div class="download-icon mt-3">
                                                <a href="{{asset('photo_uploads')}}/{{$visa->photo}}" class="btn btn-success" style="width: 170px;" download>
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </div>
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <ul class="mb-0 col-lg-6" style="list-style-type: none;">
                                <li class="w-100 d-flex justify-content-between row mb-3">
                                    <span class="col-lg-4" style="font-weight: 500;">Uploaded Passport:</span>
                                    <span class="col-lg-8">
                                        @if(!empty($visa->us_passport))
                                            <a href="{{asset('passport_uploads')}}/{{$visa->us_passport}}" data-lightbox="image-gallery">
                                                <img src="{{asset('passport_uploads')}}/{{$visa->us_passport}}" style="width: 170px; height: 140px;">
                                            </a>
                                            <div class="download-icon mt-3">
                                                <a href="{{asset('passport_uploads')}}/{{$visa->us_passport}}" class="btn btn-success" style="width: 170px;" download>
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </div>
                                        @else
                                            N/A
                                        @endif
                                    </span>
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