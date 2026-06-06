@extends('layouts.app')
@section('content')

<style>
    .listt {
        scrollbar-width: thin;
        scrollbar-color: #BBB #EEE;
    }

    .listt::-webkit-scrollbar {
        width: 10px;
    }

    .listt::-webkit-scrollbar-track {
        background: #C0C3C6;
    }

    .listt::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
        border: 3px solid #C0C3C6;
    }
    input[list]:focus {
        outline: none;
    }
    input[list] + div[list] {
        display: none;
        position: absolute;
        width: 100%;
        max-height: 164px;
        overflow-y: auto;
        max-width: 538px;
        background: #FFFFFF;
        border: var(--border);
        border-top: none;
        border-radius: 0 0 5px 5px;
        box-shadow: 0 3px 3px -3px #333;
        z-index: 100;
    }
    input[list] + div[list] span {
        display: block;
        padding: 7px 5px 7px 20px;
        color: black;
        background-color: #F7F7F7;
        text-decoration: none;
        cursor: pointer;
    }
    input[list] + div[list] span:not(:last-child) {
        border-bottom: 1px solid #EEE;
    }
    input[list] + div[list] span:hover {
        background-color: #4c1864;
        color:white;
    }
    .dropdown-toggle:hover, .dropdown-toggle:focus {
        color: black !important;
    }
    .owl-prev, .owl-next, .back-to-top, .btn {
        background-color: #f54e18 !important;
        color: #fff !important;
    }
    .title-head {
        border-color: #f54e18 !important;
    }
    .btn.dropdown-toggle.btn-default {
        color: #000 !important;
    }
    .card-header .title {
        font-size: 17px;
        color: #fff;
    }
    .card-header .accicon {
        float: right;
        font-size: 20px;  
        width: 1.2em;
    }
    .card-header{
        cursor: pointer;
        border-bottom: none;
        background-color: #ab3a15 !important;
        color: #fff !important;
    }
    .card{
        border: 1px solid #ddd;
    }
    .card-body{
        border-top: 1px solid #ddd;
    }
    .card-header:not(.collapsed) .rotate-icon {
        transform: rotate(180deg);
    }
    .select2-selection.select2-selection--single {
        height: 40px !important;
    }
    .select2-selection__arrow, .select2-selection__rendered {
        margin-top: 5px !important;
    }
</style>

<div class="page-content">
    <!-- Page Heading Box ==== -->
    <div class="page-banner ovbl-light" style="background-image:url({{ asset('assets/images2/Inner-banner-01.png') }});">
        <div class="container">
            <div class="page-banner-entry">
                <h1 class="text-white">Visa Form</h1>
            </div>
        </div>
    </div>
    <div class="breadcrumb-row">
        <div class="container">
            <ul class="list-inline">
                <li><a href="{{route('home')}}">Home</a></li>
                <li>Visa Form</li>
            </ul>
        </div>
    </div>
    <!-- Form Starts ---->
    <div class="container">
        <div class="container">
            @if(session('status'))
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        {{session('status')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
           @endif
           <div class="row" style="margin-top: 20px;">
                <div class="col-4">
                    <h6 class="text-center">Wahe Guru Ji ka Khalsa</h6>
                </div>
                <div class="col-4">
                    <h3 class="text-center">(First Come First Serve)</h3>
                </div>
                <div class="col-4">
                    <h6 class="text-center">Wahe Guru Ji ki Fateh</h6>
                </div>
            </div>
        </div>
       
        <form action="{{url('visa-form')}}" enctype="multipart/form-data" method="POST" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="row w-100">
                <div class="col-lg-12">
                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between mt-3">
                        <div class="alert alert-info row">
                            <div class="col-lg-1">
                                <i class="fa fa-exclamation-triangle" style="font-size: 45px;"></i>
                            </div>
                            <div class="col-lg-11">
                                <span>Fields marked with <span class="text-danger">*</span> in the application form are mandatory, remaining fields are non-mandatory and can be left unfilled. However, providing information in these fields will help in the decision process of your application.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 pt-3 pb-4 w-100">
                    <div class="accordion w-100" id="accordionExample">
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true">
                                <span class="title"><i class="fa-brands fa-squarespace mr-3" style="font-size: 24px;"></i>Application Information</span>
                                <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                            </div>
                            <div id="collapseOne" class="collapse show">
                                <div class="card-body row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="nationality" id="nationality" required>
                                                <option>Select</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select nationality.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="visa_category" class="form-label">Visa Category</label>
                                            <input type="text" class="form-control" name="visa_category" id="visa_category" value="Pilgrim Tourists" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="visa_sub_category" class="form-label">Visa Sub Category <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="visa_sub_category" id="visa_sub_category" required>
                                                <option>Select</option>
                                                <option value="Sikhs Foreign Nationals With Indian Origin">Sikhs Foreign Nationals With Indian Origin</option>
                                                <option value="Sikhs Indian Nationals With Third Country Residence">Sikhs Indian Nationals With Third Country Residence</option>
                                                <option value="Spouses And Children Of Indian Nationals With Third Country Residence">Spouses And Children Of Indian Nationals With Third Country Residence</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select visa sub category.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="applictaion_type" class="form-label">Application Type <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="applictaion_type" id="applictaion_type" required>
                                                <option>Select</option>
                                                <option value="Entry">Entry</option>
                                                <option value="Extension">Extension</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select application type.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="visa_type" class="form-label">Visa Type <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="visa_type" id="visa_type" required>
                                                <option>Select</option>
                                                <option value="Single Entry">Single Entry</option>
                                                <option value="Multiple Entry - Upto 1 Year">Multiple Entry - Upto 1 Year</option>
                                                <option value="Multiple Entry - More Than 1 Year">Multiple Entry - More Than 1 Year</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select visa type.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between my-3">
                                        <div class="mb-3 alert alert-info row mx-0">
                                            <div class="col-lg-1">
                                                <i class="fa fa-exclamation-triangle" style="font-size: 45px;"></i>
                                            </div>
                                            <div class="col-lg-11">
                                                <span>Have you applied before through POVS? If Yes, Please provide both of your Ref. Visa No and Ref. Passport No of previous application, in following text fields, so that your previous data can be loaded in current application.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="ref_visa_number" class="form-label">Ref. Visa No</label>
                                            <input type="text" class="form-control" name="ref_visa_number" id="ref_visa_number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="ref_passport_number" class="form-label">Ref. Passport No</label>
                                            <input type="text" class="form-control" name="ref_passport_number" id="ref_passport_number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="visit_purpose" class="form-label">Visit Purpose <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="visit_purpose" id="visit_purpose" required>
                                            <div class="invalid-feedback">
                                                Please provide visit propose.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="visa_duration" class="form-label">Allowed Visa Duration <span class="text-danger">*</span></label>
                                            <div class="d-flex justify-content-between">
                                                <select class="form-control" name="number" id="number" required>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                </select>
                                                <select class="form-control" name="month_year" id="month_year" required>
                                                    <option value="Month(s)">Month(s)</option>
                                                    <option value="Year(s)">Year(s)</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please select allowed visa duration.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between mt-3">
                                        <div>
                                            <p><b>Please select your country where you would like to be interviewed(if applicable) / Country of passport (In case of extension)</b></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between mb-3">
                                        <div class="mb-3 alert alert-info row mx-0">
                                            <div class="col-lg-1">
                                                <i class="fa fa-exclamation-triangle" style="font-size: 45px;"></i>
                                            </div>
                                            <div class="col-lg-11">
                                                <span>In case you are not present in your home country and are applying for visa from a third country THEN it is MANDATORY to upload PROOF OF LEGAL RESIDENCE under the Documents/Photograph section of the application - Failure to do so might result in REJECTION of your application.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="country" id="country" required>
                                                <option>Select</option>
                                                <option value="Entry">Entry</option>
                                                <option value="Extension">Extension</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select country.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="mission" class="form-label">Mission <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="mission" id="mission" required>
                                                <option>Select</option>
                                                <option value="Single Entry">Single Entry</option>
                                                <option value="Multiple Entry - Upto 1 Year">Multiple Entry - Upto 1 Year</option>
                                                <option value="Multiple Entry - More Than 1 Year">Multiple Entry - More Than 1 Year</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select mission.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between mt-3">
                                        <div>
                                            <p><b>What will be your port of entry and departure?</b></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="entry_port" class="form-label">Entry Port <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="entry_port" id="entry_port" required>
                                                <option>Select</option>
                                                <option value="Entry">Entry</option>
                                                <option value="Extension">Extension</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select entry port.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="departure_port" class="form-label">Departure Port <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="departure_port" id="departure_port" required>
                                                <option>Select</option>
                                                <option value="Single Entry">Single Entry</option>
                                                <option value="Multiple Entry - Upto 1 Year">Multiple Entry - Upto 1 Year</option>
                                                <option value="Multiple Entry - More Than 1 Year">Multiple Entry - More Than 1 Year</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select departure port.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between mt-3">
                                        <div>
                                            <p><b>Provide your planned dates of travel to Pakistan. This does not mean your visa will only be valid for these dates.</b></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="arrival_date" class="form-label">Arrival Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="arrival_date" id="arrival_date" required>
                                            <div class="invalid-feedback">
                                                Please provide arrival date.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="departure_date" id="departure_date" required>
                                            <div class="invalid-feedback">
                                                Please provide departure date.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between mt-3">
                                        <div class="mb-3 alert alert-info row mx-0">
                                            <div class="col-lg-1">
                                                <i class="fa fa-exclamation-triangle" style="font-size: 45px;"></i>
                                            </div>
                                            <div class="col-lg-11">
                                                <span>Your Application will be treated as per the Passport Country selected by you - You will be treated as a National of the Country which you have selected as your Passport Country.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between my-3">
                                        <div>
                                            <h4>Enter the details of passport or travel document that you will use to travel to Pakistan</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="passport_number" class="form-label">Passport/Document No <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="passport_number" id="passport_number" required>
                                            <div class="invalid-feedback">
                                                Please provide passport or document number.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="passport_type" class="form-label">Passport Type <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="passport_type" id="passport_type" required>
                                                <option>Select</option>
                                                <option value="Ordinary">Ordinary</option>
                                                <option value="Official">Official</option>
                                                <option value="Diplomatic">Diplomatic</option>
                                                <option value="UN Travel Document">UN Travel Document</option>
                                                <option value="UNLP">UNLP</option>
                                                <option value="Travel/Asylum/Temporary">Travel/Asylum/Temporary</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select passport type.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="issuing_authority" class="form-label">Issuing Authority <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="issuing_authority" id="issuing_authority" required>
                                            <div class="invalid-feedback">
                                                Please provide issuing authority.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="passport_country" class="form-label">Passport Country <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="passport_country" id="passport_country" required>
                                                <option>Select</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select passport country.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="issue_date" class="form-label">Issue Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="issue_date" id="issue_date" required>
                                            <div class="invalid-feedback">
                                                Please provide issue date.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="expiry_date" id="expiry_date" required>
                                            <div class="invalid-feedback">
                                                Please provide expiry date.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div>
                                            <label for="other_passport" class="form-label">Do you have any other passports or travel document? <span class="text-danger">*</span></label><br>
                                            <input type="radio" name="other_passport" id="yes_passport" value="Yes" checked>
                                            <label for="yes_passport">Yes</label>
                                            <input type="radio" name="other_passport" id="no_passport" class="ml-2" value="No">
                                            <label for="no_passport">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">     
                                <span class="title"><i class="fa-solid fa-address-book mr-3" style="font-size: 24px;"></i> Personal Information</span>
                                <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                            </div>
                            <div id="collapseTwo" class="collapse">
                                <div class="card-body row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="surname" id="surname" required>
                                            <div class="invalid-feedback">
                                                Please provide surname.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="given_name" class="form-label">Given Name(s) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="given_name" id="given_name" required>
                                            <div class="invalid-feedback">
                                                Please provide given name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="dob" id="dob" required>
                                            <div class="invalid-feedback">
                                                Please provide date of birth.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="pob" class="form-label">Place of Birth <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="pob" id="pob" required>
                                            <div class="invalid-feedback">
                                                Please provide place of birth.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="marital_status" class="form-label">Marital Status <span class="text-danger">*</span></label><br>
                                            <input type="radio" name="marital_status" id="single" value="Single" checked>
                                            <label for="single">Single</label>
                                            <input type="radio" name="marital_status" id="married" value="Married" class="ml-2">
                                            <label for="married">Married</label>
                                            <input type="radio" name="marital_status" id="widowed" value="Widowed" class="ml-2">
                                            <label for="widowed">Widowed</label><br>
                                            <input type="radio" name="marital_status" id="divorced" value="Divorced">
                                            <label for="divorced">Divorced</label>
                                            <input type="radio" name="marital_status" id="seperated" value="Seperated" class="ml-2">
                                            <label for="seperated">Seperated</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label><br>
                                            <input type="radio" name="gender" id="male" value="Male" checked>
                                            <label for="male">Male</label>
                                            <input type="radio" name="gender" id="female" value="Female" class="ml-2">
                                            <label for="female">Female</label>
                                            <input type="radio" name="gender" id="unspecified" value="Unspecified" class="ml-2">
                                            <label for="unspecified">Unspecified</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 d-flex justify-content-between">
                                        <div>
                                            <p><b>How long have you stayed at this address?</b></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="email_address" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email_address" id="email_address" required>
                                            <div class="invalid-feedback">
                                                Please provide email address.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="mobile_number" id="mobile_number" required>
                                            <div class="invalid-feedback">
                                                Please provide mobile number.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="acquired_by" class="form-label">Acquired By</label>
                                            <input type="text" class="form-control" name="acquired_by" id="acquired_by" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false">
                                <span class="title"><i class="fa-solid fa-people-roof mr-3" style="font-size: 24px;"></i>Family Information</span>
                                <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                            </div>
                            <div id="collapseThree" class="collapse">
                                <div class="card-body row">
                                    <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                        <div class="mb-3">
                                            <h4>Father's Information</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="father_name" id="father_name" required>
                                            <div class="invalid-feedback">
                                                Please provide father name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="father_nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control" name="father_nationality" id="father_nationality" required>
                                                <option>Select</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select father nationality.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 my-3">
                                        <div class="mb-3">
                                            <h4>Mother's Information</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="mother_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="mother_name" id="mother_name" required>
                                            <div class="invalid-feedback">
                                                Please provide mother name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="mother_nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control" name="mother_nationality" id="mother_nationality" required>
                                                <option>Select</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select mother nationality.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false">
                                <span class="title"><i class="fa-solid fa-layer-group mr-3" style="font-size: 24px;"></i>Visit Information</span>
                                <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                            </div>
                            <div id="collapseFour" class="collapse">
                                <div class="card-body row">
                                    <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                        <div class="mb-3">
                                            <h4>Stay Details</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="stay_type" class="form-label">Type of Stay <span class="text-danger">*</span></label>
                                            <select class="form-control" name="stay_type" id="stay_type" required>
                                                <option>Select</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select type of stay.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="check-in" class="form-label">Check in Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="check-in" id="check-in" required>
                                            <div class="invalid-feedback">
                                                Please provide check in date.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="check-out" class="form-label">Check out Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="check-out" id="check-out" required>
                                            <div class="invalid-feedback">
                                                Please provide check out date.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="stay_address" class="form-label">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="stay_address" id="stay_address" required>
                                            <div class="invalid-feedback">
                                                Please provide address.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="stay_province" class="form-label">Province <span class="text-danger">*</span></label>
                                            <select class="form-control" name="stay_province" id="stay_province" required>
                                                <option>Select</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide province.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="contact_number" id="contact_number" required>
                                            <div class="invalid-feedback">
                                                Please provide contact number.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="stay_district" class="form-label">District <span class="text-danger">*</span></label>
                                            <select class="form-control" name="stay_district" id="stay_district" required>
                                                <option>Select</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide district.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 w-100 pb-4 d-flex justify-content-end">
                    <button class="btn">Submit Application</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection