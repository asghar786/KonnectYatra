@extends('layouts.app')
@section('content')

<style type="text/css">
  #main #faq .card {
    margin-bottom: 30px;
    border: 0;
  }

  #main #faq .card .card-header {
    border: 0;
    -webkit-box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
    box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
    border-radius: 2px;
    padding: 0;
  }

  #main #faq .card .card-header .btn-header-link {
    color: #fff;
    display: block;
    text-align: left;
    background: #f54e18;
    font-weight: 600;
    padding: 20px;
    font-size: 16px;
  }

  #main #faq .card .card-header .btn-header-link:after {
    content: "\f107";
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    float: right;
  }

  #main #faq .card .card-header .btn-header-link.collapsed {
    background: #f54e18;
    color: #fff;
    font-weight: 600;
  }

  #main #faq .card .card-header .btn-header-link.collapsed:after {
    content: "\f106";
  }

  #main #faq .card .collapsing {
    background: #fff;
    line-height: 30px;
  }

  #main #faq .card .collapse {
    border: 0;
  }

  #main #faq .card .collapse.show {
    background: #fff;
    line-height: 30px;
    color: #222;
  }

  .select2-selection.select2-selection--single, .select2-selection__rendered {
    min-height: 48px;
  }

  .select2-selection__rendered, .select2-selection__arrow {
    margin-top: 8px;
  }

  .select2-container--default .select2-selection--{
    border-color: #a8a8a8 !important;
    font-size: 14px;
  }

  .select2.select2-container.select2-container--default {
    width: 100% !important;
  }

  input, select, table td {
    border-color: black !important;
  }

  .accordion .card button:before {
    content: none;
  }

  .accordion .card button:hover {
    background-color: #000 !important;
  }
</style>

<!-- Content -->
<div class="page-content bg-white">
  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container" style="background-image: url({{asset('assets/images2/Inner-banner-01.png')}});background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
          <h1 class="inner-title" style="font-size:65px !important;">PACKAGES</h1>
        </div>
      </div>
    </div>
  </section>
  <!-- inner page banner -->
  <div class="page-banner contact-page section-sp2">
    <div class="container p-5">
      <div class="row py-3">
        <div class="col-4">
          <h3 class="text-center">Wahe Guru Ji ka Khalsa</h3>
        </div>
        <div class="col-4">
          <h4 class="text-center mt-2">(First Come First Serve)</h4>
        </div>
        <div class="col-4">
          <h3 class="text-center">Wahe Guru Ji ki Fateh</h3>
        </div>
      </div>
      <form method="POST" action="{{ route('store-special-package') }}" class="row g-3 mt-4" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12 form-check p-2 text-center mb-4">
            <h2 class="my-4 text-center " style="font-size: 35px !important;">Holy Journey to Nankana Sahib</h2>
            <h5 class="text-center text-danger">INCLUDES VISA AND FULL SECURITY</h5>
        </div>
        @for($i = 0; $i < @$initial_info->total_persons; $i++)
        <div class="col-12 row mb-5 w-100">
            <div class="col-lg-12 form-check p-2 text-center mb-4">
                <h2 class="my-4 text-center " style="font-size: 26px !important;">Applicant # {{ $i+1 }}</h2>
            </div>
            <input type="hidden" id="selected_package_type" name="ticket_type_{{ $i+1 }}" value="land_package">
            <input class="form-check-input" name="package_id_{{ $i+1 }}" type="hidden" value="25" id="package_1">
            <input class="form-check-input" name="passport_type_{{ $i+1 }}" type="hidden" value="Ordinary">
            <div class="col-lg-12 form-check p-3 mb-2">
                <h2 class="my-2" style="font-size: 20px !important;">Application Information</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Passport No <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="passport_{{ $i+1 }}" placeholder="Enter Passport No" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                <div class="invalid-feedback">
                    Please provide valid passport.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="issuing_authority" class="form-label">Issuing Authority <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="issuing_authority_{{ $i+1 }}" id="issuing_authority" placeholder="Enter Issuing Authority" onkeydown="return /[a-z ]/i.test(event.key)" required>
                <div class="invalid-feedback">
                    Please provide issuing authority.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Passport Country <span class="text-danger">*</span></label>
                <select class="form-control select2js passport_country" name="passport_country_{{ $i+1 }}" required>
                    @foreach(@$countries as $key => $val)
                    <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select passport type.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Issue Date <span class="text-danger">*</span></label>
                <input class="form-control datepicker passport-datepicker" type="text" name="issue_date_{{ $i+1 }}" placeholder="mm-dd-yyyy" required>
                <div class="invalid-feedback">
                    Please provide issue date.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Expiry Date <span class="text-danger">*</span></label>
                <input class="form-control datepicker passport-datepicker" type="text" name="expiry_date_{{ $i+1 }}" placeholder="mm-dd-yyyy" min="{{ date('Y-m-d') }}" required>
                <div class="invalid-feedback">
                    Please provide expiry date.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area">
                <label>Reference No <span class="text-danger">*</span></label>
                <input class="form-control phone_us" type="text" name="reference_no_{{ $i+1 }}" placeholder="Enter Reference No" maxlength="11">
                <div class="invalid-feedback">
                    Please select reference number.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area">
                <label>Permanent Residence Country <span class="text-danger">*</span></label>
                <select class="form-control select2js" name="permanent_residence_country_{{ $i+1 }}">
                    @foreach(@$countries as $key => $val)
                    <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                  Please select permanent residence country.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area">
                <label>Expiry Date <span class="text-danger">*</span></label>
                <input class="form-control datepicker" type="text" name="green_card_expiry_date_{{ $i+1 }}">
                <div class="invalid-feedback">
                    Please provide expiry date.
                </div>
            </div>
            <div class="col-lg-12 form-check p-3 mb-2">
                <h2 class="my-2" style="font-size: 20px !important;">Personal & Family Information</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="first_name_{{ $i+1 }}" id="first_name" placeholder="Enter First Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                <div class="invalid-feedback">
                    Please provide first name.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" class="form-control" name="middle_name_{{ $i+1 }}" id="middle_name" placeholder="Enter Middle Name" onkeydown="return /[a-z ]/i.test(event.key)">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="last_name_{{ $i+1 }}" id="last_name" placeholder="Enter Last Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                <div class="invalid-feedback">
                    Please provide last name.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Date of Birth <span class="text-danger">*</span></label>
                <input class="form-control datepicker" type="text" name="dob_{{ $i+1 }}" placeholder="mm-dd-yyyy" value="" min="1997-01-01" max="2030-12-31" required>
                <div class="invalid-feedback">
                    Please provide date of birth.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="place_birth" class="form-label">Place of Birth <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="place_birth_{{ $i+1 }}" id="place_birth" placeholder="Enter Place of Birth" onkeydown="return /[a-z ]/i.test(event.key)" required>
                <div class="invalid-feedback">
                    Please provide place of birth.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Marital Status <span class="text-danger">*</span></label>
                <div class="form-check row">
                    <input class="mr-1 marital_status" type="radio" name="marital_status_{{ $i+1 }}" value="single" id="single_status_{{ $i+1 }}" required>
                    <label class="form-check-label mr-2" for="single_status_{{ $i+1 }}">Single</label>
                    <input class="mr-1 marital_status" type="radio" name="marital_status_{{ $i+1 }}" value="married" id="married_status_{{ $i+1 }}" required>
                    <label class="form-check-label mr-2" for="married_status_{{ $i+1 }}">Married</label>
                    <input class="mr-1 marital_status" type="radio" name="marital_status_{{ $i+1 }}" value="widowed" id="widowed_status_{{ $i+1 }}" required>
                    <label class="form-check-label mr-2" for="widowed_status_{{ $i+1 }}">Widowed</label>
                    <input class="mr-1 marital_status" type="radio" name="marital_status_{{ $i+1 }}" value="divorced" id="divorced_status_{{ $i+1 }}" required>
                    <label class="form-check-label mr-2" for="divorced_status_{{ $i+1 }}">Divorced</label>
                    <input class="mr-1 marital_status" type="radio" name="marital_status_{{ $i+1 }}" value="separated" id="separated_status_{{ $i+1 }}" required>
                    <label class="form-check-label mr-2" for="separated_status_{{ $i+1 }}">Separated</label>
                    <div class="invalid-feedback">
                        Please select one of them.
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Gender <span class="text-danger">*</span></label>
                <div class="form-check row">
                    <input class="mr-1" type="radio" name="gender_{{ $i+1 }}" id="male_{{ $i+1 }}" value="male" required>
                    <label class="form-check-label mr-2" for="male_{{ $i+1 }}">Male</label>
                    <input class="mr-1" type="radio" name="gender_{{ $i+1 }}" id="female_{{ $i+1 }}" value="female" required>
                    <label class="form-check-label mr-2" for="female_{{ $i+1 }}">Female</label>
                    <div class="invalid-feedback">
                        Please select gender.
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Religion <span class="text-danger">*</span></label>
                <select class="form-control select2js" name="religion_{{ $i+1 }}" required>
                    <option value="">Select</option>
                    <option value="Sikhism" selected>Sikhism</option>
                    <option value="Islam">Islam</option>
                    <option value="Christianity">Christianity</option>
                    <option value="Hinduism">Hinduism</option>
                    <option value="Buddhism">Buddhism</option>
                </select>
                <div class="invalid-feedback">
                    Please select your religion.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email_{{ $i+1 }}" id="email_{{ $i+1 }}" placeholder="Enter Email Address" required>
                <div class="invalid-feedback">
                    Please provide email address.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="phone" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                <input type="tel" class="form-control phone_us" maxlength="12" name="phone_{{ $i+1 }}" placeholder="Enter mobile number" id="phone_{{ $i+1 }}" required>
                <div class="invalid-feedback">
                    Please provide your mobile number.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="father_name_{{ $i+1 }}" id="father_name_{{ $i+1 }}" placeholder="Enter Father Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                <div class="invalid-feedback">
                    Please provide father name.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label class="w-100">Nationality <span class="text-danger">*</span></label>
                <select class="form-control select2js" name="father_nationality_{{ $i+1 }}" required>
                  @foreach(@$countries as $key => $val)
                  <option value="{{ @$val['nicename'] }}" @if(@$val['nicename'] == 'India') selected @endif>{{ @$val['nicename'] }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select nationality.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="mother_name" class="form-label">Mother Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="mother_name_{{ $i+1 }}" id="mother_name_{{ $i+1 }}" placeholder="Enter Mother Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                <div class="invalid-feedback">
                    Please provide mother name.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label class="w-100">Nationality <span class="text-danger">*</span></label>
                <select class="form-control select2js" name="mother_nationality_{{ $i+1 }}" required>
                  @foreach(@$countries as $key => $val)
                  <option value="{{ @$val['nicename'] }}" @if(@$val['nicename'] == 'India') selected @endif>{{ @$val['nicename'] }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select nationality.
                </div>
            </div>
            <div class="col-lg-12 form-check p-3 mb-2">
                <h2 class="my-2" style="font-size: 20px !important;">Documents / Photograph</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="photoFile" class="form-label">Upload Photo <span class="text-danger">*</span></label>
                <input class="form-control" type="file" name="photo_{{ $i+1 }}" id="photoFile_{{ $i+1 }}" required>
                <div class="invalid-feedback">
                    Please upload valid photo.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="formFile" class="form-label">Upload Passport <span class="text-danger">*</span></label>
                <input class="form-control" type="file" name="us_passport_{{ $i+1 }}" id="passportFile_{{ $i+1 }}" required>
                <div class="invalid-feedback">
                    Please upload valid passport.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="formFile" class="form-label">Upload ID/Driving License <span class="text-danger">*</span></label>
                <input class="form-control" type="file" name="driving_license_{{ $i+1 }}" id="formFile_{{ $i+1 }}" required>
                <div class="invalid-feedback">
                    Please upload valid ID or Driving License
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label for="formFile" class="form-label">Upload Green Card</label>
                <input class="form-control" type="file" name="green_card_{{ $i+1 }}" id="green-card_{{ $i+1 }}">
                <div class="invalid-feedback">
                    Please upload valid green card.
                </div>
            </div>
          </div>
        @endfor
        
        <div class="col-lg-12 form-check p-3 mb-2">
            <h2 class="my-2" style="font-size: 20px !important;">Payment Information</h2>
        </div>
        <div class="col-lg-12 row p-3">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <h4 class="my-2">Payment Type</h4>
                <div class="form-check">
                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="wire_transfer" value="Bank Wire Transfer" checked required>
                    <label class="form-check-label" for="wire_transfer" style="cursor: pointer;"><b>Paid by Bank Wire Transfer</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="check" value="Check" required>
                    <label class="form-check-label" for="check" style="cursor: pointer;"><b>Paid by Check</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="cash" value="Cash" required>
                    <label class="form-check-label" for="cash" style="cursor: pointer;"><b>Paid by Cash</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="zelle" value="Zelle" required>
                    <label class="form-check-label" for="zelle" style="cursor: pointer;"><b>Paid by Zelle</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="pay_later" value="Pay Later" required>
                    <label class="form-check-label" for="pay_later" style="cursor: pointer;"><b>Pay Later</b></label>
                    <div class="invalid-feedback">
                        Please select payment type.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 row p-3 my-3" id="wire_transfer_div">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <label>Routing Number <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="routing_number" id="routing_number" placeholder="Enter Routing Number">
                <div class="invalid-feedback">
                    Please provide routing number.
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <label>Account Number <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="account_number" id="account_number" placeholder="Enter Account Number">
                <div class="invalid-feedback">
                    Please provide account number.
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <label>Amount <span class="text-danger">*</span></label>
                <input class="form-control" type="number" name="amount" id="amount" placeholder="Enter Amount">
                <div class="invalid-feedback">
                    Please provide amount.
                </div>
            </div>
        </div>
        <div class="row p-3 my-3" id="check_div" style="display: none;">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <label>Check Number <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="check_number" id="check_number" placeholder="Enter Check Number">
                <div class="invalid-feedback">
                    Please provide check number.
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <label>Date of Check <span class="text-danger">*</span></label>
                <input class="form-control" type="date" name="date_of_check" id="date_of_check">
                <div class="invalid-feedback">
                    Please provide account number.
                </div>
            </div>
        </div>
        <div class="row p-3 my-3" id="note" style="display: none;">
            <p class="col-lg-12 col-md-12 col-sm-12 mb-3"><b>Note: </b>You have to pay this amount until <b>1 MONTH</b> of this yatra. Otherwise your booking will be <span style="color: red;">FAILED!</span></p>
        </div>
        @php
            $zellePhone = \App\Models\SiteSetting::get('pay_zelle_phone');
            $zelleName  = \App\Models\SiteSetting::get('pay_zelle_name');
            $zelleEmail = \App\Models\SiteSetting::get('pay_zelle_email');
            $zelleNote  = \App\Models\SiteSetting::get('pay_zelle_instructions');
        @endphp
        <div class="row p-3 my-3" id="zelle_div" style="display: none;">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3" style="background:#fff4ef;border:1px solid #ffd9c9;border-radius:12px;padding:16px;">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 style="font-weight:700;"><i class="fas fa-mobile-screen-button"></i> Pay by Zelle</h5>
                    <img src="{{ asset('assets/images2/zelle-logo.svg') }}" alt="Zelle" style="max-width:90px;height:auto;">
                </div>
                @if(!empty($zelleName))<p class="mb-1"><b>Recipient Name:</b> {{ $zelleName }}</p>@endif
                @if(!empty($zellePhone))<p class="mb-1"><b>Zelle Phone Number:</b> <b style="color:#f54e18;">{{ $zellePhone }}</b></p>@endif
                @if(!empty($zelleEmail))<p class="mb-1"><b>Zelle Email:</b> {{ $zelleEmail }}</p>@endif
                <p class="mb-0 mt-2"><b>Important:</b> Kindly test the account by sending <b>$1</b> first. Upon getting confirmation, then transfer the full / balance amount to the given number.</p>
                @if(!empty($zelleNote))<p class="mb-0 mt-2 text-muted">{!! nl2br(e($zelleNote)) !!}</p>@endif
            </div>
        </div>
          {{-- <div class="col-12 mt-2">
            <ul>
              <li>Price is guaranteed if booking is made 8 weeks in advance and paid in full. <b>Payable to Konnect.us, Inc. and mail at 185-02 Hillside Avenue, Jamaica NY 11432.</b></li>
              <li>Stay in 4 Star Hotel in Islamabad & Lahore. Breakfast/Dinner and Refreshment included.</li>
              <li>Pick and drop transportation throughout the holy trip.</li>
              <li>Yatris must follow the group rules and regulation. No private tour is allowed due to security reason</li>
              <li>This application is valid till October 31, 2023.</li>
              <li>(Double occupancy $100 discount only for one person if wife and husband traveling together. Note: JFK-ISB-LHE-JFK (One way passengers will pay $600 less from the above package price)</li>
              <li>For Business Class prices please call <b>RASHAD MAHMOOD @ +1 (718) 908-9464</b></li>
              <li><b>Cancellation of Trip: Airline applicable cancellation charges and $100 service charges applies.</b></li>
            </ul>
          </div>
          <div class="col-4 mt-2">
            <label>Signature of Yatri</label>
            <input class="form-control" type="text" name="signature" style="border-top: 0px; border-left: 0px; border-right: 0px;" onkeydown="return /[a-z ]/i.test(event.key)" required>
            <div class="invalid-feedback">
              Please add your signature.
            </div>
          </div> --}}
          <div class="col-12 mt-2">
            <input type="checkbox" name="terms" value="agree" required>
            <label class="form-label" style="font-weight: 100;">To the best of my knowledge and belief the information given in this application is correct.</label><br>
            <input type="checkbox" name="terms" value="agree" required>
            <label class="form-label" style="font-weight: 100;">I agree to the <a href="javascript:void;" data-toggle="modal" data-target="#exampleModal"><b>terms & conditions</b></a>.</label><br>
            <label style="font-weight: 100;"><b style="font-weight: 600;">NOTE:</b> Application will be submitted after payment process is completed.</label>
            <div class="invalid-feedback">
              Please click the above checkbox.
            </div>
          </div>
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Terms & Conditions</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h3>What can you do:</h3>
                  <p>
                    you can travel one way to Pakistan and go to India (pay $600 less of the package price) but if you carrying two suitcases you have to pay additional $35 luggage handling.
                  </p>
                  <p>
                    You can go to India and use our Land package and join the group. We can receive you from the Wagha Border, Lahore.
                  </p>
                  <h3>What you cannot do:</h3>
                  <ul>
                    <li>You can not change assigned seat during trip</li>
                    <li>Exchange phone numbers with local people or Government officials</li>
                    <li>No Alcohol allowed</li>
                    <li>You can not go anywhere without prior permission of the group leader</li>
                  </ul> 
                  <p>You will be responsible for all expenses of your private tour incase permission is granted by the special Police through the group leader.</p>
                  <p>
                    Price Guaranteed if booking is made 3 months in advance and paid in full. 2 months before departure you will pay different package price.
                  </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-center px-4 pt-5">
            <button class="button-primary width-6 mt-2 mx-1" id="submit_btn">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <!-- inner page banner END -->
  </div>
  <!-- Content END-->
  <style>
    table {
/*            border: 1px solid black;*/
height: auto;
width: auto;
}

th {

  padding: 0px;
  width: auto;
  height: auto;
  text-align: center;
}

td {
  border: 1px solid black;
  padding: 0px;
  width: auto;
  height: auto;
  text-align: center;

}
</style>
<script>
  $(document).ready(function () {
      // Attach a click event handler to the radio buttons
    $('input[name="package_type"]').on('click', function () {
        // Update the value of the hidden input field with the selected data-type
      $('#selected_package_type').val($(this).data('type'));
    });
  });


  (function() {
    'use strict';

    var forms = document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms).forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          var firstInvalidElement = form.querySelector(':invalid');
          firstInvalidElement.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
        }

        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>
<script>
  $(document).ready(function() {
      $(document).on("click", ".payment_type", function () {
            if ($(this).val() == "Bank Wire Transfer") {
                $("#routing_number").attr("required", true);
                $("#account_number").attr("required", true);
                $("#amount").attr("required", true);
                $("#check_number").attr("required", false);
                $("#date_of_check").attr("required", false);
                $("#check_div").fadeOut();
                $("#wire_transfer_div").fadeIn();
                $("#note").fadeOut();
            } else if ($(this).val() == "Check") {
                $("#routing_number").attr("required", false);
                $("#account_number").attr("required", false);
                $("#amount").attr("required", false);
                $("#check_number").attr("required", true);
                $("#date_of_check").attr("required", true);
                $("#check_div").fadeIn();
                $("#wire_transfer_div").fadeOut();
                $("#note").fadeOut();
            } else if ($(this).val() == "Cash") {
                $("#routing_number").attr("required", false);
                $("#account_number").attr("required", false);
                $("#amount").attr("required", false);
                $("#check_number").attr("required", false);
                $("#date_of_check").attr("required", false);
                $("#check_div").fadeOut();
                $("#wire_transfer_div").fadeOut();
                $("#zelle_div").fadeOut();
                $("#note").fadeOut();
            } else if ($(this).val() == "Zelle") {
                $("#routing_number").attr("required", false);
                $("#account_number").attr("required", false);
                $("#amount").attr("required", false);
                $("#check_number").attr("required", false);
                $("#date_of_check").attr("required", false);
                $("#check_div").fadeOut();
                $("#wire_transfer_div").fadeOut();
                $("#note").fadeOut();
                $("#zelle_div").fadeIn();
            } else {
                $("#routing_number").attr("required", false);
                $("#account_number").attr("required", false);
                $("#amount").attr("required", false);
                $("#check_number").attr("required", false);
                $("#date_of_check").attr("required", false);
                $("#check_div").fadeOut();
                $("#wire_transfer_div").fadeOut();
                $("#zelle_div").fadeOut();
                $("#note").fadeIn();
            }
        });
      // Attach click event listener to each checkbox
    $("#package_1, #package_2, #package_3").click(function() {
        // If a checkbox is checked, enable the other two
      if ($(this).is(":checked")) {
        $("#package_1, #package_2, #package_3").not(this).prop("disabled", true);
      }
        // If a checkbox is unchecked, enable the other two
      else {
        $("#package_1, #package_2, #package_3").prop("disabled", false);
      }
    });
    $('.phone_us').on('input', function() {
      let text=$(this).val()
      text=text.replace(/\D/g,'') 
      if(text.length>3) text=text.replace(/.{3}/,'$&-')
        if(text.length>7) text=text.replace(/.{7}/,'$&-')
          $(this).val(text);
      });
  });
</script>
<script>
    // Add event listeners to all the package checkboxes
  $("input[type='checkbox']").change(function() {
    var checked = $(this).is(":checked");
    var container = $(this).closest(".col-lg-4");
    container.find("input[type='radio']").prop("disabled", !checked);
    container.find("input[type='radio']").prop("required", true);
  });
</script>
<script>
  $(document).ready(function() {
    $('input[name="first_visit"]').on('click', function() {
      if ($(this).val() === 'yes') {
        $('#previous-visit').prop('required', false);
        $('#entry-port').prop('required', false);
        $('#first-visit').hide();
      } else {
        $('#previous-visit').prop('required', true);
        $('#entry-port').prop('required', true);
        $('#first-visit').show();
      }
    });

    $(document).on('click', '.marital_status', function() {
      var marital_status = $(".marital_status:checked").val();
      if (marital_status == "single") {
        $(".have_spouse").css("display", "none");
      } else {
        $(".have_spouse").css("display", "block");
      }
    });

    $(document).on('click', '#spouse', function() {
      if ($(this).is(":checked")) {
        $(".spouse_area").css("display", "block");
      } else {
        $(".spouse_area").css("display", "none");
      }
    });

    $(document).on('change', '.passport_country', function() {
      var selected = $(this).find("option:selected").val();

      if (selected == "India") {
        $(".green_card_area").css("display", "block");
        $("#reference_no").attr("required", true);
        $("#permanent_residence_country").attr("required", true);
        $("#expiry_date").attr("required", true);
      } else {
        $(".green_card_area").css("display", "none");
        $("#reference_no").attr("required", false);
        $("#permanent_residence_country").attr("required", false);
        $("#expiry_date").attr("required", false);
      }
    });

    $(document).on('change', '.passenger_first_visit', function() {
      if ($(this).val() === 'yes') {
        $(this).parent().parent().next().find('.previous-visit').prop('required', false);
        $(this).parent().parent().next().next().find('.entry-port').prop('required', false);
        $(this).parent().parent().next().hide();
        $(this).parent().parent().next().next().hide();
      } else {
        $(this).parent().parent().next().find('.previous-visit').prop('required', true);
        $(this).parent().parent().next().next().find('.entry-port').prop('required', true);
        $(this).parent().parent().next().show();
        $(this).parent().parent().next().next().show();
      }
    });
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
  $(document).ready(function() {
    $(document).on('click', ".next", function() {
      // if ($(this).hasClass("next1")) {
      //   var form = new FormData();
      //   form.append("package_type", $("input[name='package_type']:checked").val());
      //   form.append("passport", $("input[name='passport']").val());
      //   form.append("issuing_authority", $("input[name='issuing_authority']").val());
      //   form.append("passport_country", $("select[name='passport_country'] option:selected").val());
      //   form.append("reference_no", $("input[name='reference_no']").val());
      //   form.append("permanent_residence_country", $("select[name='permanent_residence_country'] option:selected").val());
      //   form.append("green_card_expiry_date", $("input[name='green_card_expiry_date']").val());
      //   form.append("issue_date", $("input[name='issue_date']").val());
      //   form.append("expiry_date", $("input[name='expiry_date']").val());
      //   form.append("type", "next1");
      // } else if ($(this).hasClass("next2")) {
      //   var form = new FormData();
      //   form.append("first_name", $("input[name='first_name']").val());
      //   form.append("middle_name", $("input[name='middle_name']").val());
      //   form.append("last_name", $("input[name='last_name']").val());
      //   form.append("dob", $("input[name='dob']").val());
      //   form.append("place_birth", $("input[name='place_birth']").val());
      //   form.append("marital_status", $("input[name='marital_status']:checked").val());
      //   form.append("gender", $("input[name='gender']:checked").val());
      //   form.append("religion", $("select[name='religion'] option:selected").val());
      //   form.append("email", $("input[name='email']").val());
      //   form.append("other_email", $("input[name='other_email']").val());
      //   form.append("phone", $("input[name='phone']").val());
      //   form.append("other_phone", $("input[name='other_phone']").val());
      //   form.append("type", "next2");
      // } else if ($(this).hasClass("next3")) {
      //   var form = new FormData();
      //   form.append("father_name", $("input[name='father_name']").val());
      //   form.append("father_nationality", $("select[name='father_nationality'] option:selected").val());
      //   form.append("mother_name", $("input[name='mother_name']").val());
      //   form.append("mother_nationality", $("select[name='mother_nationality'] option:selected").val());
      //   form.append("have_spouse", $("input[name='have_spouse']:checked").val());
      //   form.append("spouse_name", $("input[name='spouse_name']").val());
      //   form.append("spouse_birth_country", $("select[name='spouse_birth_country'] option:selected").val());
      //   form.append("spouse_nationality", $("select[name='spouse_nationality'] option:selected").val());
      //   form.append("type", "next3");
      // } else if ($(this).hasClass("next4")) {
      //   var form = new FormData();
      //   form.append("profession", $("input[name='profession']").val());
      //   form.append("travel_history", $("input[name='travel_history']:checked").val());
      //   form.append("pk_travel_history", $("input[name='pk_travel_history']:checked").val());
      //   form.append("type", "next4");
      // } else if ($(this).hasClass("next5")) {
      //   var form = new FormData();
      //   form.append("gurdwara_name", $("input[name='gurdwara_name']").val());
      //   form.append("address", $("input[name='passport']").val());
      //   form.append("city", $("input[name='city']").val());
      //   form.append("state", $("select[name='state'] option:selected").val());
      //   form.append("zip", $("input[name='zip']").val());
      //   form.append("secetary_name", $("input[name='secetary_name']").val());
      //   form.append("secretary_phone", $("input[name='secretary_phone']").val());
      //   form.append("reference_name", $("input[name='reference_name']").val());
      //   form.append("reference_phone", $("input[name='reference_phone']").val());
      //   form.append("type", "next5");
      // }
      // $.ajax({
      //   type: 'POST',
      //   url: "{{ url('/save-info') }}",
      //   processData: false,
      //   contentType: false,
      //   cache: false,
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   data: form,
      //   success: function(data){
      //     console.log(data);
      //   },
      //   error: function(err){
      //     console.log(err);
      //   }
      // });
      toastr['success']("Data saved successfully!", "Success!");

      $(this).parent().parent().parent().prev().children().addClass("collapsed");
      $(this).parent().parent().parent().parent().next().find(".collapse").addClass("show");
      var next = $(this).parent().parent().parent().parent().next();
      $('html, body').animate({
        scrollTop: next.offset().top - 100
      }, 2000);
      if ($("#faq6").hasClass("show")) {
        $("#submit_btn").attr("disabled", false);
      }
        // $(this).parent().parent().parent().parent().next().find(".collapse").prev().children().removeClass("collapsed");
        // $(this).parent().parent().parent().parent().next().find(".collapse").prev().children().click();
        // $(this).parent().parent().parent().prev().children().click();
    });

$(document).on('change', "#gurdwara", function() {
  var selected = $(this).find("option:selected").text();
  if (selected !== "Other") {
    $("#nearest_gurdwara").val(selected);
  } else {
    $("#nearest_gurdwara").val("");
  }
});

$(document).on('click', ".ticket_type", function() {
  if ($(this).val() == "round_trip") {
    $(".round_way_description").css("display", "block");
    $(".one_way_description").css("display", "none");
    $(".land_package_description").css("display", "none");
    $("#ticket_type").val("round_trip");
    var a = $("#package_type_1").attr("data-back-round");
    var b = $("#package_type_2").attr("data-back-round");
    var c = $("#package_type_3").attr("data-back-round");
    $("#package_type_1").val(a);
    $("#package_type_2").val(b);
    $("#package_type_3").val(c);
    var a = $(".package_type_1").attr("data-back-round");
    var b = $(".package_type_2").attr("data-back-round");
    var c = $(".package_type_3").attr("data-back-round");
    $(".package_type_1").text(a);
    $(".package_type_2").text(b);
    $(".package_type_3").text(c);
  } else if ($(this).val() == "one_way") {
    $(".one_way_description").css("display", "block");
    $(".round_way_description").css("display", "none");
    $(".land_package_description").css("display", "none");
    $("#ticket_type").val("one_way");
    var a = $("#package_type_1").attr("data-back-one");
    var b = $("#package_type_2").attr("data-back-one");
    var c = $("#package_type_3").attr("data-back-one");
    $("#package_type_1").val(a);
    $("#package_type_2").val(b);
    $("#package_type_3").val(c);
    var a = $(".package_type_1").attr("data-back-one");
    var b = $(".package_type_2").attr("data-back-one");
    var c = $(".package_type_3").attr("data-back-one");
    $(".package_type_1").text(a);
    $(".package_type_2").text(b);
    $(".package_type_3").text(c);
  } else if ($(this).val() == "land_package") {
    $(".land_package_description").css("display", "block");
    $(".one_way_description").css("display", "none");
    $(".round_way_description").css("display", "none");
    $("#ticket_type").val("land_package");
    var a = $("#package_type_1").attr("data-back-land");
    var b = $("#package_type_2").attr("data-back-land");
    var c = $("#package_type_3").attr("data-back-land");
    $("#package_type_1").val(a);
    $("#package_type_2").val(b);
    $("#package_type_3").val(c);
    var a = $(".package_type_1").attr("data-back-land");
    var b = $(".package_type_2").attr("data-back-land");
    var c = $(".package_type_3").attr("data-back-land");
    $(".package_type_1").text(a);
    $(".package_type_2").text(b);
    $(".package_type_3").text(c);
  }
});
      // Attach click event listener to radio buttons
$('input[name="have_passport"]').on('click', function() {
        // If yes is selected, show the div
  if ($(this).val() === 'yes') {
    $('#green-card').prop('required', true);
    if ($('#green-card').prev().find(".req").length == 0) {
      $('#green-card').prev().append('<span class="text-danger req ml-1">*</span>');
    }
  }
        // If no is selected, hide the div
  else {
    $('#green-card').prop('required', false);
    $('#green-card').prev().find('.req').remove();
  }
});

$(document).on('change', '.passenger_passport', function() {
        // If yes is selected, show the div
  if ($(this).val() == 'yes') {
    $(this).parent().parent().next().next().next().find(".green-card").prop('required', true);
    $(this).parent().parent().next().next().next().find("label").append('<span class="text-danger req ml-1">*</span>');
  }
        // If no is selected, hide the div
  else {
    $(this).parent().parent().next().next().next().find(".green-card").prop('required', false);
    $(this).parent().parent().next().next().next().find(".req").remove();
  }
});
});
</script>
@endsection