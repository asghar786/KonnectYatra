@extends('layouts.app')
@section('content')

<style type="text/css">
  /* Age pill shown next to the Date of Birth field */
  .dob-age-pill{
    display:inline-flex;align-items:center;gap:6px;
    background:#fff2ec;color:#f54e18;border:1px solid #f7c3af;
    font-weight:700;font-size:14px;line-height:1;
    padding:9px 16px;border-radius:30px;white-space:nowrap;
  }
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
      <form method="POST" action="{{ route('store-yatri-visa') }}" class="row g-3 mt-4" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="col-12 row mb-3 w-100" id="main">
          <div class="accordion w-100" id="faq">
            <div class="card">
              <div class="card-header" id="faqhead1">
                {{-- <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1">Application Information</a> --}}
                <a href="javascript:void;" class="btn btn-header-link">Application Information</a>
              </div>

              <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                <div class="card-body row">
                  <input class="form-check-input" name="package_id" type="hidden" value="{{ @$id }}" id="package_1">
                  <input type="hidden" id="selected_package_type" name="ticket_type" value="{{ @$cookie['ticket_type'] ?: 'round_trip' }}">

                  {{-- <h4 class="col-lg-12 text-center mt-4" style="font-size: 20px; color: #000;">Ticket Type</h4>
                  <div class="col-lg-6 form-check p-2 text-center mb-3">
                    <input class="form-check-input ticket_type mt-2" type="radio" name="ticket_type" id="round_trip" value="round_trip" checked>
                    <label class="form-check-label" for="round_trip" style="font-size: 18px; color: #000; cursor: pointer;"> Round Trip Ticket </label>
                  </div>
                  <div class="col-lg-6 form-check p-2 text-center mb-3">
                    <input class="form-check-input ticket_type mt-2"  type="radio" name="ticket_type" id="one_way" value="one_way">
                    <label class="form-check-label" for="one_way" style="font-size: 18px; color: #000; cursor: pointer;"> One Way Trip Ticket </label>
                  </div> --}}
                  {{-- <div class="col-lg-4 form-check p-2 text-center mb-3">
                    <input class="form-check-input ticket_type mt-2"  type="radio" name="ticket_type" id="land_package" value="land_package">
                    <label class="form-check-label" for="land_package" style="font-size: 18px; color: #000; cursor: pointer;"> Land Package Trip Ticket </label>
                  </div> --}}
                  <div class="col-lg-12 form-check p-2 text-center mb-4">
                    <h4 class="mb-2 text-center round_way_description">{{ @$packages->round_way_description }}</h4>
                    <h4 class="mb-2 text-center one_way_description" style="display: none;">{{ @$packages->one_way_description }}</h4>
                    <h4 class="mb-2 text-center land_package_description" style="display: none;">{{ @$packages->land_package_description }}</h4>
                    <h2 class="my-4 text-center " style="font-size: 35px !important;">Holy Journey to Nankana Sahib</h2>
                    <h5 class="text-center text-danger">INCLUDES VISA AND FULL SECURITY</h5>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                    <table class="w-100" style="background-color: #fff;">
                      <thead>
                        <tr>
                          <td colspan="3" class="text-center p-2"><b style="color: #fff !important;">{{ @$packages->state }} 5* Hotel package (per person)</b></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>                    
                          @if(!empty(@$packages->five_star_round_price))
                          <td class="text-center p-2 text-dark"><b>Round trip</b></td>
                          @endif
                          @if(!empty(@$packages->five_star_single_price))
                          <td class="text-center p-2 text-dark"><b>One Way</b></td>
                          @endif
                          @if(!empty(@$packages->five_star_land_price))
                          <td class="text-center p-2 text-dark"><b>Land Package</b></td>
                          @endif
                        </tr>
                        <tr>
                          @if(!empty(@$packages->five_star_round_price))
                          <td style="width: 33.33%;" class="text-center p-2">
                            <input class="form-check-input mt-2" type="radio" value="${{@$packages->five_star_round_price }}" data-type="round_trip" name="package_type" id="package_type_1" @if(@$cookie['package_type'] == '$'.@$packages->five_star_round_price) checked @endif>
                            <label class="form-check-label package_type_1 text-dark" for="package_type_1"> ${{ @$packages->five_star_round_price }} </label>
                          </td>
                          @endif
                          @if(!empty(@$packages->five_star_single_price))
                          <td style="width: 33.33%;" class="text-center p-2">
                            <input class="form-check-input mt-2" value="${{@$packages->five_star_single_price }}" data-type="one_way" type="radio" name="package_type" id="package_type_2" @if(@$cookie['package_type'] == '$'.@$packages->five_star_single_price) checked @endif>
                            <label class="form-check-label package_type_2 text-dark" for="package_type_2"> ${{ @$packages->five_star_single_price }}</label>
                          </td>
                          @endif
                          @if(!empty(@$packages->five_star_land_price))
                          <td style="width: 33.33%;" class="text-center p-2">
                            <input class="form-check-input mt-2" value="${{@$packages->five_star_land_price }}" data-type="land_package" type="radio" name="package_type" id="package_type_3" @if(@$cookie['package_type'] == '$'.@$packages->five_star_land_price) checked @endif>
                            <label class="form-check-label package_type_3 text-dark" for="package_type_3"> ${{ @$packages->five_star_land_price }}</label>
                          </td>
                          @endif
                        </tr>
                      </tbody>
                    </table>
                    @if(!empty(@$packages->four_star_round_price) || !empty(@$packages->four_star_single_price) || !empty(@$packages->four_star_land_price))
                    <table class="w-100 mt-4" style="background-color: #fff;">
                      <thead>
                        <tr>
                          <td colspan="3" class="text-center p-2"><b style="color: #fff !important;">{{ @$packages->state }} 4* Hotel package (per person)</b></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          @if(!empty(@$packages->four_star_round_price))
                          <td class="text-center p-2 text-dark"><b>Round trip</b></td>
                          @endif
                          @if(!empty(@$packages->four_star_single_price))
                          <td class="text-center p-2 text-dark"><b>One Way</b></td>
                          @endif
                          @if(!empty(@$packages->four_star_land_price))
                          <td class="text-center p-2 text-dark"><b>Land Package</b></td>
                          @endif
                        </tr>
                        <tr>
                          @if(!empty(@$packages->four_star_round_price))
                          <td style="width: 33.33%;" class="text-center p-2">
                            <input class="form-check-input mt-2" type="radio" name="package_type" data-type="round_trip" value="${{ @$packages->four_star_round_price }}" id="package_type_4" @if(@$cookie['package_type'] == '$'.@$packages->four_star_round_price) checked @endif>
                            <label class="form-check-label package_type_4 text-dark" for="package_type_4"> ${{ @$packages->four_star_round_price }} </label>
                          </td>
                          @endif
                          @if(!empty(@$packages->four_star_single_price))
                          <td style="width: 33.33%;" class="text-center p-2">
                            <input class="form-check-input mt-2" type="radio" name="package_type" data-type="one_way" value="${{ @$packages->four_star_single_price }}" id="package_type_5" @if(@$cookie['package_type'] == '$'.@$packages->four_star_single_price) checked @endif>
                            <label class="form-check-label package_type_5 text-dark" for="package_type_5"> ${{ @$packages->four_star_single_price }}</label>
                          </td>
                          @endif
                          @if(!empty(@$packages->four_star_land_price))
                          <td style="width: 33.33%;" class="text-center p-2">
                            <input class="form-check-input mt-2" type="radio" name="package_type" data-type="land_package" value="${{ @$packages->four_star_land_price }}" id="package_type_6" @if(@$cookie['package_type'] == '$'.@$packages->four_star_land_price) checked @endif>
                            <label class="form-check-label package_type_6 text-dark" for="package_type_6"> ${{ @$packages->four_star_land_price }}</label>
                          </td>
                          @endif
                        </tr>
                      </tbody>
                    </table>
                    @endif
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Passport No <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" value="{{ @$cookie['passport'] }}" name="passport" placeholder="Enter Passport No" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                    <div class="invalid-feedback">
                      Please provide valid passport.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Passport Type <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="passport_type" required>
                      <option value="Ordinary" @if(@$cookie['passport_type'] == 'Ordinary') selected @endif>Ordinary Passport</option>
                      <option value="Official" @if(@$cookie['passport_type'] == 'Official') selected @endif>Official Passport</option>
                      <option value="Diplomatic" @if(@$cookie['passport_type'] == 'Diplomatic') selected @endif>Diplomatic Passport</option>
                      <option value="Emergency Travel Document" @if(@$cookie['passport_type'] == 'Emergency Travel Document') selected @endif>Emergency Travel Document</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select passport type.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Traveller Nationality <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="nationality" id="nationality" required>
                      @foreach(@$countries as $key => $val)
                      @if(empty(@$cookie['nationality']) && @$val['nicename'] == "United States")
                      <option value="{{ @$val['nicename'] }}" data-iso="{{ @$val['iso'] }}" selected>{{ @$val['nicename'] }}</option>
                      @else
                      <option value="{{ @$val['nicename'] }}" data-iso="{{ @$val['iso'] }}" @if(@$cookie['nationality'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
                      @endif
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select traveller nationality.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="issuing_authority" class="form-label">Issuing Authority <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="issuing_authority" value="{{ @$cookie['issuing_authority'] }}" id="issuing_authority" placeholder="Enter Issuing Authority" onkeydown="return /[a-z ]/i.test(event.key)" required>
                    <div class="invalid-feedback">
                      Please provide issuing authority.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Passport Country <span class="text-danger">*</span></label>
                    <select class="form-control select2js passport_country" name="passport_country" required>
                      @foreach(@$countries as $key => $val)
                      @if(empty(@$cookie['passport_country']) && @$val['nicename'] == "United States")
                      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                      @else
                      <option value="{{ @$val['nicename'] }}" @if(@$cookie['passport_country'] == $val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
                      @endif
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select passport type.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Issue Date <span class="text-danger">*</span></label>
                    <input class="form-control datepicker passport-datepicker" type="text" name="issue_date" placeholder="DD-MMM-YYYY" value="{{ @$cookie['issue_date'] }}" required>
                    <div class="invalid-feedback">
                      Please provide issue date.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Expiry Date <span class="text-danger">*</span></label>
                    <input class="form-control datepicker passport-datepicker" type="text" name="expiry_date" placeholder="DD-MMM-YYYY" value="{{ @$cookie['expiry_date'] }}" min="{{ date('Y-m-d') }}" required>
                    <div class="invalid-feedback">
                      Please provide expiry date.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area" @if(empty(@$cookie['reference_no'])) style="display: none;" @endif>
                    <label>Reference No <span class="text-danger">*</span></label>
                    <input class="form-control phone_us" type="text" value="{{ @$cookie['reference_no'] }}" name="reference_no" placeholder="Enter Reference No" maxlength="11">
                    <div class="invalid-feedback">
                      Please select reference number.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area" @if(empty(@$cookie['permanent_residence_country'])) style="display: none;" @endif>
                    <label>Permanent Residence Country <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="permanent_residence_country">
                      @foreach(@$countries as $key => $val)
                      @if(empty(@$cookie['permanent_residence_country']) && @$val['nicename'] == "United States")
                      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                      @else
                      <option value="{{ @$val['nicename'] }}" @if(@$cookie['permanent_residence_country'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
                      @endif
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select permanent residence country.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area" @if(empty(@$cookie['green_card_expiry_date'])) style="display: none;" @endif>
                    <label>Expiry Date <span class="text-danger">*</span></label>
                    <input class="form-control datepicker" type="text" value="{{ @$cookie['green_card_expiry_date'] }}" name="green_card_expiry_date">
                    <div class="invalid-feedback">
                      Please provide expiry date.
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mt-3 d-flex justify-content-end">
                    <button class="button-text width-6 btn-slider1 next next1 p-3" style="border-radius:10px !important; width: auto; background-color: #fff;" type="button">Save & Next</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="faqhead2">
                {{-- <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2">Personal Information</a> --}}
                <a href="javascript:void;" class="btn btn-header-link">Personal Information</a>
              </div>

              <div id="faq2" class="collapse @if(@$cookie['next2']) show @endif" aria-labelledby="faqhead2" data-parent="#faq">
                <div class="card-body row pt-3">
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_name" value="{{ @$cookie['first_name'] }}" id="first_name" placeholder="Enter First Name" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                    <div class="invalid-feedback">
                      Please provide first name.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" value="{{ @$cookie['middle_name'] }}" id="middle_name" placeholder="Enter Middle Name" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_name" value="{{ @$cookie['last_name'] }}" id="last_name" placeholder="Enter Last Name" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                    <div class="invalid-feedback">
                      Please provide last name.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Date of Birth <span class="text-danger">*</span></label>
                    <div class="d-flex flex-wrap align-items-center" style="gap:10px;">
                      <input class="form-control dob-datepicker dob-age-src" type="text" name="dob" value="{{ @$cookie['dob'] }}" placeholder="DD-MMM-YYYY" style="flex:0 0 50%;max-width:50%;" required>
                      <span class="dob-age-pill" style="display:none;"></span>
                      <div class="invalid-feedback" style="flex:0 0 100%;">
                        Please provide date of birth.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="place_birth" class="form-label">Place of Birth <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="place_birth" value="{{ @$cookie['place_birth'] }}" id="place_birth" placeholder="Enter Place of Birth" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                    <div class="invalid-feedback">
                      Please provide place of birth.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Marital Status <span class="text-danger">*</span></label>
                    <div class="form-check row">
                      <input class="mr-1 marital_status" type="radio" name="marital_status"
                      value="single" id="single_status" @if(@$cookie['marital_status'] == 'single' || empty(@$cookie['marital_status'])) checked @endif required>
                      <label class="form-check-label mr-2" for="single_status">Single</label>
                      <input class="mr-1 marital_status" type="radio" name="marital_status"
                      value="married" id="married_status" @if(@$cookie['marital_status'] == 'married') checked @endif required>
                      <label class="form-check-label mr-2" for="married_status">Married</label>
                      <input class="mr-1 marital_status" type="radio" name="marital_status"
                      value="widowed" id="widowed_status" @if(@$cookie['marital_status'] == 'widowed') checked @endif required>
                      <label class="form-check-label mr-2" for="widowed_status">Widowed</label>
                      <input class="mr-1 marital_status" type="radio" name="marital_status"
                      value="divorced" id="divorced_status" @if(@$cookie['marital_status'] == 'divorced') checked @endif required>
                      <label class="form-check-label mr-2" for="divorced_status">Divorced</label>
                      <input class="mr-1 marital_status" type="radio" name="marital_status"
                      value="separated" id="separated_status" @if(@$cookie['marital_status'] == 'separated') checked @endif required>
                      <label class="form-check-label mr-2" for="separated_status">Separated</label>
                      <div class="invalid-feedback">
                        Please select one of them.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Gender <span class="text-danger">*</span></label>
                    <div class="form-check row">
                      <input class="mr-1" type="radio" name="gender" id="male" value="male" @if(@$cookie['gender'] == 'male' || empty(@$cookie['gender'])) checked @endif required>
                      <label class="form-check-label mr-2" for="male">Male</label>
                      <input class="mr-1" type="radio" name="gender" id="female" @if(@$cookie['gender'] == 'female') checked @endif value="female" required>
                      <label class="form-check-label mr-2" for="female">Female</label>
                      <div class="invalid-feedback">
                        Please select gender.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Religion <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="religion" required>
                      <option value="">Select</option>
                      <option value="Sikhism" @if(@$cookie['religion'] == 'Sikhism') selected @endif>Sikhism</option>
                      <option value="Islam" @if(@$cookie['religion'] == 'Islam') selected @endif>Islam</option>
                      <option value="Christianity" @if(@$cookie['religion'] == 'Christianity') selected @endif>Christianity</option>
                      <option value="Hinduism" @if(@$cookie['religion'] == 'Hinduism') selected @endif>Hinduism</option>
                      <option value="Buddhism" @if(@$cookie['religion'] == 'Buddhism') selected @endif>Buddhism</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select your religion.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="email" class="form-label">Primary Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" value="{{ @$cookie['email'] }}" id="email" placeholder="Enter Email Address" style="text-transform:lowercase;" oninput="this.value=this.value.toLowerCase()" required>
                    <div class="invalid-feedback">
                      Please provide email address.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="email" class="form-label">Other Email Address </label>
                    <input type="email" class="form-control" name="other_email" value="{{ @$cookie['other_email'] }}" id="email" placeholder="Enter Email Address" style="text-transform:lowercase;" oninput="this.value=this.value.toLowerCase()">
                    <div class="invalid-feedback">
                      Please provide email address.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="phone_display" class="form-label">Primary Mobile Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control phone_intl" data-hidden="phone" id="phone_display" autocomplete="off" required>
                    <input type="hidden" name="phone" id="phone" value="{{ @$cookie['phone'] }}">
                    <div class="invalid-feedback">
                      Please provide your mobile number.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="other_phone_display" class="form-label">Other Mobile Number</label>
                    <input type="tel" class="form-control phone_intl" data-hidden="other_phone" id="other_phone_display" autocomplete="off">
                    <input type="hidden" name="other_phone" id="other_phone" value="{{ @$cookie['other_phone'] }}">
                    <div class="invalid-feedback">
                      Please provide any other mobile number.
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mt-3 d-flex justify-content-end">
                    <button class="button-text width-6 btn-slider1 next next2 p-3" style="border-radius:10px !important; width: auto; background-color: #fff;" type="button">Save & Next</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="faqhead3">
                {{-- <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3">Family Information</a> --}}
                <a href="javascript:void;" class="btn btn-header-link">Family Information</a>
              </div>

              <div id="faq3" class="collapse @if(@$cookie['next3']) show @endif" aria-labelledby="faqhead3" data-parent="#faq">
                <div class="card-body row pt-3">
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="father_name" class="form-label">Traveller's Father Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Enter Father Name" value="{{ @$cookie['father_name'] }}" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                    <div class="invalid-feedback">
                      Please provide father name.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="w-100">Traveller's Father Nationality <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="father_nationality" required>
                      @foreach(@$countries as $key => $val)
                      @if(empty(@$cookie['father_nationality']) && @$val['nicename'] == "United States")
                      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                      @else
                      <option value="{{ @$val['nicename'] }}" @if(@$cookie['father_nationality'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
                      @endif
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select nationality.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="mother_name" class="form-label">Traveller's Mother Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Enter Mother Name" value="{{ @$cookie['mother_name'] }}" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                    <div class="invalid-feedback">
                      Please provide mother name.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="w-100">Traveller's Mother Nationality <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="mother_nationality" required>
                      @foreach(@$countries as $key => $val)
                      @if(empty(@$cookie['mother_nationality']) && @$val['nicename'] == "United States")
                      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                      @else
                      <option value="{{ @$val['nicename'] }}" @if(@$cookie['mother_nationality'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
                      @endif
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select nationality.
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 have_spouse" @if(empty(@$cookie['have_spouse'])) style="display: none;" @endif>
                    <input type="checkbox" name="have_spouse" @if(!empty(@$cookie['have_spouse'])) checked @endif id="spouse" value="yes">
                    <label class="form-label mb-0" for="spouse" style="font-weight: 100;">Do you have a Spouse?</label>
                    <div class="invalid-feedback">
                      Please provide your spouse detail.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 spouse_area" @if(empty(@$cookie['spouse_name'])) style="display: none;" @endif>
                    <label for="spouse_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="{{ @$cookie['spouse_name'] }}" name="spouse_name" id="spouse_name" placeholder="Enter Spouse Name" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">
                    <div class="invalid-feedback">
                      Please provide spouse name.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 spouse_area" @if(empty(@$cookie['spouse_birth_country'])) style="display: none;" @endif>
                    <label class="w-100">Country of Birth <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="spouse_birth_country">
                      @foreach(@$countries as $key => $val)
                      @if(empty(@$cookie['spouse_birth_country']) && @$val['nicename'] == "United States")
                      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                      @else
                      <option value="{{ @$val['nicename'] }}" @if(@$cookie['spouse_birth_country'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
                      @endif
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select country of birth.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 spouse_area" @if(empty(@$cookie['spouse_nationality'])) style="display: none;" @endif>
                    <label class="w-100">Nationality <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="spouse_nationality">
                      @foreach(@$countries as $key => $val)
                      @if(empty(@$cookie['spouse_nationality']) && @$val['nicename'] == "United States")
                      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                      @else
                      <option value="{{ @$val['nicename'] }}" @if(@$cookie['spouse_nationality'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
                      @endif
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select nationality of spouse.
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mt-3 d-flex justify-content-end">
                    <button class="button-text width-6 btn-slider1 next next3 p-3" style="border-radius:10px !important; width: auto; background-color: #fff;" type="button">Save & Next</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="faqheadCompanions">
                <a href="javascript:void;" class="btn btn-header-link">Travelling Companions</a>
              </div>

              <div id="faqCompanions" class="collapse" aria-labelledby="faqheadCompanions" data-parent="#faq">
                <div class="card-body row pt-3">
                  <div class="col-12 mb-2">
                    <input type="checkbox" id="travelling_with_family" name="travelling_with_family" value="yes">
                    <label class="form-label mb-0" for="travelling_with_family" style="font-weight: 100;">
                      I am travelling with my spouse / family <span class="text-muted">(we must stay together — same hotel room group)</span>
                    </label>
                  </div>

                  <div class="col-12 companions_block" style="display: none;">
                    <div class="alert" style="background:#fff4ef;border:1px solid #ffd9c9;color:#8a3b1a;border-radius:10px;">
                      Add everyone travelling with you (spouse first, then children or other family).
                      The package price is multiplied by the total number of people.
                    </div>
                    <div id="companions_list"></div>
                    <button type="button" class="btn btn-outline-secondary" id="add_companion">
                      <i class="fa fa-plus"></i> Add More Person
                    </button>
                  </div>

                  <div class="col-12 mt-3">
                    <div class="p-3" id="price_summary" style="background:#f6f7f9;border:1px solid #e7e9ef;border-radius:12px;font-size:16px;color:#1c2541;">
                      <!-- filled by JS -->
                    </div>
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12 mt-3 d-flex justify-content-end">
                    <button class="button-text width-6 btn-slider1 next p-3" style="border-radius:10px !important; width: auto; background-color: #fff;" type="button">Save & Next</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="faqhead4">
                {{-- <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq4" aria-expanded="true" aria-controls="faq4">Employment & Travel History</a> --}}
                <a href="javascript:void;" class="btn btn-header-link">Employment & Travel History</a>
              </div>

              <div id="faq4" class="collapse @if(@$cookie['next4']) show @endif" aria-labelledby="faqhead4" data-parent="#faq">
                <div class="card-body row pt-3">
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <label for="profession" class="form-label">Traveller's Profession <span class="text-danger">*</span></label>
                    <input type="text" class="form-control w-50" value="{{ @$cookie['profession'] }}" name="profession" id="profession" placeholder="Enter Profession" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                    <div class="invalid-feedback">
                      Please provide profession.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Have you travelled to any country in past 3 years? <span class="text-danger">*</span></label>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-check row">
                      <input class="mr-1 travel_history" type="radio" name="travel_history" id="travel_history_yes" value="yes" @if(@$cookie['travel_history'] == "yes") checked @endif required>
                      <label class="form-check-label mr-2" for="travel_history_yes">Yes</label>
                      <input class="mr-1 travel_history" type="radio" name="travel_history" id="travel_history_no" value="no" @if(@$cookie['travel_history'] == "no" || empty(@$cookie['travel_history'])) checked @endif required>
                      <label class="form-check-label mr-2" for="travel_history_no">No</label>
                      <div class="invalid-feedback">
                        Please select any one.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Have you been granted Pakistani visa before? <span class="text-danger">*</span></label>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-check row">
                      <input class="mr-1 pk_travel_history" type="radio" @if(@$cookie['pk_travel_history'] == "yes") checked @endif name="pk_travel_history" id="pk_history_yes" value="yes" required>
                      <label class="form-check-label mr-2" for="pk_history_yes">Yes</label>
                      <input class="mr-1 pk_travel_history" type="radio" name="pk_travel_history" @if(@$cookie['pk_travel_history'] == "no" || empty(@$cookie['pk_travel_history'])) checked @endif id="pk_history_no" value="no" checked required>
                      <label class="form-check-label mr-2" for="pk_history_no">No</label>
                      <div class="invalid-feedback">
                        Please select any one.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mb-3 pk_entry_area" @if(@$cookie['pk_travel_history'] != "yes") style="display: none;" @endif>
                    <label>How did you enter Pakistan? <span class="text-danger">*</span></label>
                    <div class="form-check row">
                      <input class="mr-1" type="radio" name="pk_entry_port" id="pk_entry_lahore" value="Lahore Airport" @if(@$cookie['pk_entry_port'] == "Lahore Airport" || empty(@$cookie['pk_entry_port'])) checked @endif>
                      <label class="form-check-label mr-3" for="pk_entry_lahore">Lahore Airport</label>
                      <input class="mr-1" type="radio" name="pk_entry_port" id="pk_entry_islamabad" value="Islamabad Airport" @if(@$cookie['pk_entry_port'] == "Islamabad Airport") checked @endif>
                      <label class="form-check-label mr-3" for="pk_entry_islamabad">Islamabad Airport</label>
                      <input class="mr-1" type="radio" name="pk_entry_port" id="pk_entry_wagah" value="Wagah Border" @if(@$cookie['pk_entry_port'] == "Wagah Border") checked @endif>
                      <label class="form-check-label mr-3" for="pk_entry_wagah">Wagah Border</label>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 pk_entry_area" @if(@$cookie['pk_travel_history'] != "yes") style="display: none;" @endif>
                    <label>Recent Date of Entry <span class="text-danger">*</span></label>
                    <div class="pk_entry_date_field">
                      <input class="form-control entry-datepicker" type="text" name="pk_entry_date" id="pk_entry_date" placeholder="DD-MMM-YYYY" value="{{ @$cookie['pk_entry_date'] }}" autocomplete="off" required>
                    </div>
                    <div class="pk_entry_year_field" style="display: none;">
                      <select class="form-control no-selectpicker" name="pk_entry_year" id="pk_entry_year" disabled required>
                        <option value="">Select Year</option>
                        @for($y = (int) date('Y'); $y >= 1980; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                      </select>
                    </div>
                    <div class="form-check mt-2">
                      <input class="form-check-input" type="checkbox" name="pk_entry_date_unknown" id="pk_entry_date_unknown" value="1">
                      <label class="form-check-label" for="pk_entry_date_unknown">I don't remember the exact date — I only know the year</label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mt-3 d-flex justify-content-end">
                    <button class="button-text width-6 btn-slider1 next next4 p-3" style="border-radius:10px !important; width: auto; background-color: #fff;" type="button">Save & Next</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="faqhead5">
                {{-- <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq5" aria-expanded="true" aria-controls="faq5">Gurdwara Information</a> --}}
                <a href="javascript:void;" class="btn btn-header-link">Gurdwara Information</a>
              </div>

              <div id="faq5" class="collapse @if(@$cookie['next5']) show @endif" aria-labelledby="faqhead5" data-parent="#faq">
                <div class="card-body row pt-3">
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="gurdwara" class="form-label">Select Gurdwara <span class="text-danger">*</span></label>
                    <select class="form-control select2js" name="gurdwara_id" id="gurdwara" required>
                      @foreach(@$gurdwaras as $key => $val)
                      <option value="{{ @$val['id'] }}" @if(@$cookie['gurdwara_id'] == @$val['id']) selected @endif>{{ @$val['gurdwara_name'] }}</option>
                      @endforeach
                      <option value="Other" @if(@$cookie['gurdwara_id'] == "Other") selected @endif>Other</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select any gurdwara.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Name of Nearest Gurdwara</label>
                    <input class="form-control" value="{{ @$cookie['gurdwara_name'] }}" type="text" name="gurdwara_name" id="nearest_gurdwara" placeholder="Enter name of your nearest gurdwara" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">
                    <div class="invalid-feedback">
                      Please provide nearest gurdwara name.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Address</label>
                    <input class="form-control" value="{{ @$cookie['address'] }}" type="text" name="address" placeholder="Enter Address">
                    <div class="invalid-feedback">
                      Please provide address.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>City</label>
                    <input class="form-control" value="{{ @$cookie['city'] }}" type="text" name="city"
                    placeholder="Enter city" onkeydown="return /[a-z ]/i.test(event.key)">
                    <div class="invalid-feedback">
                      Please provide city.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>State</label>
                    <select class="form-control select2js" name="state">
                      <option value="AL" @if(@$cookie['state'] == "AL") selected @endif>Alabama</option>
                      <option value="AK" @if(@$cookie['state'] == "AK") selected @endif>Alaska</option>
                      <option value="AZ" @if(@$cookie['state'] == "AZ") selected @endif>Arizona</option>
                      <option value="AR" @if(@$cookie['state'] == "AR") selected @endif>Arkansas</option>
                      <option value="CA" @if(@$cookie['state'] == "CA") selected @endif>California</option>
                      <option value="CO" @if(@$cookie['state'] == "CO") selected @endif>Colorado</option>
                      <option value="CT" @if(@$cookie['state'] == "CT") selected @endif>Connecticut</option>
                      <option value="DE" @if(@$cookie['state'] == "DE") selected @endif>Delaware</option>
                      <option value="FL" @if(@$cookie['state'] == "FL") selected @endif>Florida</option>
                      <option value="GA" @if(@$cookie['state'] == "GA") selected @endif>Georgia</option>
                      <option value="HI" @if(@$cookie['state'] == "HI") selected @endif>Hawaii</option>
                      <option value="ID" @if(@$cookie['state'] == "ID") selected @endif>Idaho</option>
                      <option value="IL" @if(@$cookie['state'] == "IL") selected @endif>Illinois</option>
                      <option value="IN" @if(@$cookie['state'] == "IN") selected @endif>Indiana</option>
                      <option value="IA" @if(@$cookie['state'] == "IA") selected @endif>Iowa</option>
                      <option value="KS" @if(@$cookie['state'] == "KS") selected @endif>Kansas</option>
                      <option value="KY" @if(@$cookie['state'] == "KY") selected @endif>Kentucky</option>
                      <option value="LA" @if(@$cookie['state'] == "LA") selected @endif>Louisiana</option>
                      <option value="ME" @if(@$cookie['state'] == "ME") selected @endif>Maine</option>
                      <option value="MD" @if(@$cookie['state'] == "MD") selected @endif>Maryland</option>
                      <option value="MA" @if(@$cookie['state'] == "MA") selected @endif>Massachusetts</option>
                      <option value="MI" @if(@$cookie['state'] == "MI") selected @endif>Michigan</option>
                      <option value="MN" @if(@$cookie['state'] == "MN") selected @endif>Minnesota</option>
                      <option value="MS" @if(@$cookie['state'] == "MS") selected @endif>Mississippi</option>
                      <option value="MO" @if(@$cookie['state'] == "MO") selected @endif>Missouri</option>
                      <option value="MT" @if(@$cookie['state'] == "MT") selected @endif>Montana</option>
                      <option value="NE" @if(@$cookie['state'] == "NE") selected @endif>Nebraska</option>
                      <option value="NV" @if(@$cookie['state'] == "NV") selected @endif>Nevada</option>
                      <option value="NH" @if(@$cookie['state'] == "NH") selected @endif>New Hampshire</option>
                      <option value="NJ" @if(@$cookie['state'] == "NJ") selected @endif>New Jersey</option>
                      <option value="NM" @if(@$cookie['state'] == "NM") selected @endif>New Mexico</option>
                      <option value="NY" @if(@$cookie['state'] == "NY") selected @endif>New York</option>
                      <option value="NC" @if(@$cookie['state'] == "NC") selected @endif>North Carolina</option>
                      <option value="ND" @if(@$cookie['state'] == "ND") selected @endif>North Dakota</option>
                      <option value="OH" @if(@$cookie['state'] == "OH") selected @endif>Ohio</option>
                      <option value="OK" @if(@$cookie['state'] == "OK") selected @endif>Oklahoma</option>
                      <option value="OR" @if(@$cookie['state'] == "OR") selected @endif>Oregon</option>
                      <option value="PA" @if(@$cookie['state'] == "PA") selected @endif>Pennsylvania</option>
                      <option value="RI" @if(@$cookie['state'] == "RI") selected @endif>Rhode Island</option>
                      <option value="SC" @if(@$cookie['state'] == "SC") selected @endif>South Carolina</option>
                      <option value="SD" @if(@$cookie['state'] == "SD") selected @endif>South Dakota</option>
                      <option value="TN" @if(@$cookie['state'] == "TN") selected @endif>Tennessee</option>
                      <option value="TX" @if(@$cookie['state'] == "TX") selected @endif>Texas</option>
                      <option value="UT" @if(@$cookie['state'] == "UT") selected @endif>Utah</option>
                      <option value="VT" @if(@$cookie['state'] == "VT") selected @endif>Vermont</option>
                      <option value="VA" @if(@$cookie['state'] == "VA") selected @endif>Virginia</option>
                      <option value="WA" @if(@$cookie['state'] == "WA") selected @endif>Washington</option>
                      <option value="WV" @if(@$cookie['state'] == "WV") selected @endif>West Virginia</option>
                      <option value="WI" @if(@$cookie['state'] == "WI") selected @endif>Wisconsin</option>
                      <option value="WY" @if(@$cookie['state'] == "WY") selected @endif>Wyoming</option>
                      <option value="DC" @if(@$cookie['state'] == "DC") selected @endif>District of Columbia</option>
                      <option value="AS" @if(@$cookie['state'] == "AS") selected @endif>American Samoa</option>
                      <option value="GU" @if(@$cookie['state'] == "GU") selected @endif>Guam</option>
                      <option value="MP" @if(@$cookie['state'] == "MP") selected @endif>Northern Mariana Islands</option>
                      <option value="PR" @if(@$cookie['state'] == "PR") selected @endif>Puerto Rico</option>
                      <option value="UM" @if(@$cookie['state'] == "UM") selected @endif>United States Minor Outlying Islands</option>
                      <option value="VI" @if(@$cookie['state'] == "VI") selected @endif>Virgin Islands, U.S.</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select state.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Zip</label>
                    <input class="form-control" type="text" value="{{ @$cookie['zip'] }}" name="zip" placeholder="Enter zip">
                    <div class="invalid-feedback">
                      Please provide valid zip.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Name of Secretary/Pardan Gurdwara</label>
                    <input class="form-control" type="text" value="{{ @$cookie['secetary_name'] }}" name="secetary_name" placeholder="Enter name of secetary gurdwara" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">
                    <div class="invalid-feedback">
                      Please provide name of secretary.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Mobile Number</label>
                    <input type="tel" class="form-control phone_us" value="{{ @$cookie['secretary_phone'] }}" maxlength="12" name="secretary_phone" placeholder="Enter phone number of secretary">
                    <div class="invalid-feedback">
                      Please provide phone number of secretary.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Reference Person Name</label>
                    <input class="form-control" type="text" value="{{ @$cookie['reference_name'] }}" name="reference_name"
                    placeholder="Enter name of reference contact person" onkeydown="return /[a-z ]/i.test(event.key)" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">
                    <div class="invalid-feedback">
                      Please provide name of secretary.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Reference Person Mobile Number</label>
                    <input type="tel" class="form-control phone_us" value="{{ @$cookie['reference_phone'] }}" maxlength="12" name="reference_phone" placeholder="Enter phone number of reference person">
                    <div class="invalid-feedback">
                      Please provide phone number of secretary.
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 mt-3 d-flex justify-content-end">
                    <button class="button-text width-6 btn-slider1 next next5 p-3" style="border-radius:10px !important; width: auto; background-color: #fff;" type="button">Save & Next</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="faqhead6">
                {{-- <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq6" aria-expanded="true" aria-controls="faq6">Documents / Photograph</a> --}}
                <a href="javascript:void;" class="btn btn-header-link">Documents / Photograph</a>
              </div>

              <div id="faq6" class="collapse" aria-labelledby="faqhead6" data-parent="#faq">
                <div class="card-body row pt-3">
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="photoFile" class="form-label">Upload Photo <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="photo" id="photoFile" required>
                    <div class="invalid-feedback">
                      Please upload valid photo.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="formFile" class="form-label">Upload Passport <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="us_passport" id="formFile" required>
                    <div class="invalid-feedback">
                      Please upload valid passport.
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="formFile" class="form-label">Upload ID/Driving License <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="driving_license" id="formFile" required>
                    <div class="invalid-feedback">
                      Please upload valid ID or Driving License
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label for="formFile" class="form-label">Upload Green Card</label>
                    <input class="form-control" type="file" name="green_card" id="green-card">
                    <div class="invalid-feedback">
                      Please upload valid green card.
                    </div>
                  </div>

                  <!-- Additional documents (added dynamically) -->
                  <div class="col-12" id="extra_docs"></div>

                  <div class="col-12 mb-2">
                    <button type="button" class="btn btn-outline-secondary" id="add_more_doc">
                      <i class="fa fa-plus"></i> Add More Documents
                    </button>
                    <small class="d-block text-muted mt-2">Accepted: PDF, JPG, JPEG, PNG, GIF. Images are stored as optimized WebP.</small>
                  </div>
                </div>
              </div>
            </div>
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
            <button type="submit" class="button-primary width-6 mt-2 mx-1" id="submit_btn">Proceed to Payment</button>
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
      // Sync the hidden ticket_type with the pre-checked price radio (carried from the detail page).
    var $checked = $('input[name="package_type"]:checked');
    if ($checked.length) {
      $('#selected_package_type').val($checked.data('type'));
    }
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
  // International mobile numbers (intl-tel-input / libphonenumber): the country is locked to
  // the traveller's selected nationality (dial code shown, not user-changeable), and the number
  // is formatted & validated per that country. The hidden field stores the full international
  // number (e.g. +1 305-785-3690 / +44 7400 123456) for the backend.
  $(document).ready(function() {
    if (typeof window.intlTelInput !== 'function' || !$('.phone_intl').length) return;

    function nationalityIso() {
      var iso = ($("select[name='nationality']").find("option:selected").data("iso") || 'us');
      return ('' + iso).toLowerCase();
    }

    // Format the typed digits into the country's own example pattern (the placeholder intl-tel-input
    // sets, e.g. US "201-555-0123"). Digits drop into the digit slots; extra digits are dropped, so
    // the length is naturally restricted to that country's number length.
    function maskToPattern(input) {
      var mask = input.getAttribute('placeholder') || '';
      var digits = input.value.replace(/\D/g, '');
      if (!mask) { input.value = digits; return; } // utils not loaded yet -> keep raw digits
      var slots = (mask.match(/\d/g) || []).length;
      digits = digits.slice(0, slots);
      var out = '', di = 0;
      for (var i = 0; i < mask.length && di < digits.length; i++) {
        out += /\d/.test(mask[i]) ? digits[di++] : mask[i];
      }
      input.value = out;
    }

    var instances = [];
    $('.phone_intl').each(function() {
      var input = this;
      var iti = window.intlTelInput(input, {
        initialCountry: nationalityIso(),
        separateDialCode: true,   // show the +code beside the flag
        autoPlaceholder: 'polite',
        formatOnDisplay: true,
        utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js'
      });
      var hidden = document.getElementById(input.getAttribute('data-hidden'));

      function fullNumber() {
        if (window.intlTelInputUtils) {
          return iti.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL); // e.g. +1 305-785-3690
        }
        return iti.getNumber ? iti.getNumber() : input.value;
      }
      function sync() {
        var hasValue = input.value.trim().length > 0;
        // Store the full international number; flag invalid numbers for the submit validator.
        if (hasValue && iti.isValidNumber && iti.isValidNumber()) {
          hidden.value = fullNumber();
          input.setCustomValidity('');
        } else if (hasValue) {
          hidden.value = fullNumber();
          input.setCustomValidity('Please enter a valid phone number for the selected country.');
        } else {
          hidden.value = '';
          input.setCustomValidity('');
        }
      }

      function onType() { maskToPattern(input); sync(); }

      // Seed the visible field from any stored value (international format).
      if (hidden.value) {
        iti.setNumber(hidden.value);
      }
      input.addEventListener('input', onType);
      input.addEventListener('blur', onType);
      iti.promise && iti.promise.then(onType); // re-format/validate once utils + placeholder are ready
      instances.push({ input: input, iti: iti, sync: sync, onType: onType });
    });

    // When the nationality changes, lock every mobile field to that country and re-format/validate.
    $(document).on('change', "select[name='nationality']", function() {
      var iso = nationalityIso();
      instances.forEach(function(o) { o.iti.setCountry(iso); o.onType(); });
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

    // "How did you enter Pakistan?" + Date of Entry: shown only when a Pakistani visa was
    // granted before. The Date of Entry can be an exact date, or — if not remembered — just
    // a year (checkbox swaps the date picker for a year dropdown). Hidden/irrelevant inputs
    // are disabled so they don't block the required-field validation on submit.
    function applyPkEntryMode() {
      var onlyYear = $('#pk_entry_date_unknown').is(':checked');
      $('.pk_entry_date_field').toggle(!onlyYear);
      $('.pk_entry_year_field').toggle(onlyYear);
      $('#pk_entry_date').prop('disabled', onlyYear);
      $('#pk_entry_year').prop('disabled', !onlyYear);
    }
    function togglePkEntry() {
      var yes = $(".pk_travel_history:checked").val() === 'yes';
      $(".pk_entry_area").toggle(yes);
      if (yes) {
        applyPkEntryMode();
      } else {
        // Disable both so the now-hidden required fields are skipped by validation.
        $('#pk_entry_date, #pk_entry_year').prop('disabled', true);
      }
    }
    $(document).on('change', '.pk_travel_history', togglePkEntry);
    $(document).on('change', '#pk_entry_date_unknown', applyPkEntryMode);
    togglePkEntry(); // set initial state on load

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
<script>
  // Additional documents: add/remove rows (Name of Document + file upload).
  $(document).ready(function () {
    $('#add_more_doc').on('click', function () {
      var row =
        '<div class="row extra-doc-row mb-2 align-items-end">' +
          '<div class="col-lg-6 col-md-6 col-sm-12 mb-2">' +
            '<label class="form-label">Name of Document</label>' +
            '<input class="form-control" type="text" name="doc_name[]" placeholder="e.g. Marriage Certificate, Old Visa">' +
          '</div>' +
          '<div class="col-lg-5 col-md-5 col-sm-10 mb-2">' +
            '<label class="form-label">Upload Document</label>' +
            '<input class="form-control" type="file" name="doc_file[]" accept=".pdf,.jpg,.jpeg,.png,.gif">' +
          '</div>' +
          '<div class="col-lg-1 col-md-1 col-sm-2 mb-2">' +
            '<button type="button" class="btn btn-outline-danger remove-doc" title="Remove">&times;</button>' +
          '</div>' +
        '</div>';
      $('#extra_docs').append(row);
    });

    $('#extra_docs').on('click', '.remove-doc', function () {
      $(this).closest('.extra-doc-row').remove();
    });

    // Show a green circled check at the end of an upload field once a file is selected.
    function wrapFileField(input) {
      var $i = $(input);
      if ($i.closest('.file-check-wrap').length) return; // already wrapped
      $i.wrap('<div class="file-check-wrap"></div>');
      $i.after('<span class="file-check"><i class="fa fas fa-check-circle"></i></span>');
    }
    function refreshFileCheck(input) {
      wrapFileField(input);
      $(input).closest('.file-check-wrap').toggleClass('has-file', !!(input.files && input.files.length));
    }
    // Wrap the fixed document inputs up front so the layout is consistent.
    $('#faq6 input[type="file"]').each(function () { wrapFileField(this); });
    // Any file input (including dynamically added document rows) toggles its tick on change.
    $(document).on('change', 'input[type="file"]', function () { refreshFileCheck(this); });
  });

  // On "Proceed to Payment", if a mandatory field is missing, tell the
  // traveller exactly which one (instead of silently doing nothing). The
  // button is always clickable so they always get feedback.
  (function () {
    var form = document.querySelector('form[action*="store-yatri-visa"]');
    if (!form) return;

    // Friendly label for a control: its <label>, else nearest label, else name.
    function fieldLabel(el) {
      var label;
      if (el.id) {
        label = document.querySelector('label[for="' + el.id + '"]');
        if (label) return clean(label.textContent);
      }
      var group = el.closest('.form-group') || el.closest('[class*="col-"]');
      if (group) {
        label = group.querySelector('label');
        if (label) return clean(label.textContent);
      }
      return clean((el.getAttribute('name') || 'This field').replace(/[_\[\]]/g, ' '));
    }
    function clean(t) { return (t || '').replace(/\*/g, '').replace(/\s+/g, ' ').trim(); }

    function notify(message) {
      if (window.Swal && typeof window.Swal.fire === 'function') {
        window.Swal.fire({ icon: 'warning', title: 'Missing required field', text: message, confirmButtonColor: '#f54e18' });
      } else {
        alert(message);
      }
    }

    form.addEventListener('submit', function (event) {
      // First required control that fails native validation.
      var first = null;
      var controls = form.querySelectorAll('input, select, textarea');
      for (var i = 0; i < controls.length; i++) {
        if (controls[i].willValidate && !controls[i].checkValidity()) { first = controls[i]; break; }
      }
      if (!first) return; // all good — let it submit

      event.preventDefault();
      event.stopPropagation();

      var group = first.closest('.form-group') || first.closest('[class*="col-"]') || first;
      group.scrollIntoView({ behavior: 'smooth', block: 'center' });
      first.classList.add('is-invalid');

      // Focus the right element. select2 hides the native <select>, so focus
      // its rendered box instead; otherwise the bubble can't be shown.
      var focusTarget = first;
      if (first.offsetParent === null && group !== first) {
        var rendered = group.querySelector('.select2-selection, .select2-search__field');
        if (rendered) focusTarget = rendered;
      }
      try { focusTarget.focus({ preventScroll: true }); } catch (e) {}

      notify('Please complete this required field: "' + fieldLabel(first) + '".');
    }, false);

    // Clear the red highlight once the traveller fixes a field.
    $(form).on('input change', 'input, select, textarea', function () {
      if (this.checkValidity()) this.classList.remove('is-invalid');
    });
  })();
</script>
<script>
  // ---------- Travelling Companions (spouse / family) ----------
  // Capture each co-traveller (Relation, Full Name, Country of Birth, Nationality,
  // Passport No + upload). Total = package price (per person) × number of people.
  $(document).ready(function () {
    @php
      $companionCountryOptions = '';
      foreach (($countries ?? []) as $c) {
          $n = e($c['nicename']);
          $sel = ($c['nicename'] === 'United States') ? ' selected' : '';
          $companionCountryOptions .= '<option value="'.$n.'"'.$sel.'>'.$n.'</option>';
      }
    @endphp
    var COUNTRY_OPTIONS = {!! json_encode($companionCountryOptions) !!};

    var RELATIONS = ['Wife', 'Husband', 'Son', 'Daughter', 'Grand Son', 'Grand Daughter', 'Sister', 'Brother'];

    function relationOptions(preselect) {
      var html = '<option value="">Select</option>';
      RELATIONS.forEach(function (r) {
        html += '<option value="' + r + '"' + (r === preselect ? ' selected' : '') + '>' + r + '</option>';
      });
      return html;
    }

    // Default spouse relation from the traveller's gender (male → Wife, female → Husband).
    function defaultSpouseRelation() {
      var g = $("input[name='gender']:checked").val();
      if (g === 'male')   return 'Wife';
      if (g === 'female') return 'Husband';
      return '';
    }

    function companionRow(preselectRelation) {
      return '' +
        '<div class="companion-item card mb-3" style="border:1px solid #e7e9ef;border-radius:12px;">' +
          '<div class="card-body row pt-3">' +
            '<div class="col-lg-4 col-md-6 mb-3">' +
              '<label class="form-label">Relation <span class="text-danger">*</span></label>' +
              '<select class="form-control" name="companion_relation[]" required>' + relationOptions(preselectRelation) + '</select>' +
            '</div>' +
            '<div class="col-lg-4 col-md-6 mb-3">' +
              '<label class="form-label">Full Name <span class="text-danger">*</span></label>' +
              '<input type="text" class="form-control" name="companion_name[]" placeholder="Enter Full Name" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>' +
            '</div>' +
            '<div class="col-lg-4 col-md-6 mb-3">' +
              '<label class="form-label">Passport No</label>' +
              '<input type="text" class="form-control" name="companion_passport_no[]" placeholder="Passport No" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">' +
            '</div>' +
            '<div class="col-lg-4 col-md-6 mb-3">' +
              '<label class="form-label">Country of Birth <span class="text-danger">*</span></label>' +
              '<select class="form-control" name="companion_birth_country[]" required>' + COUNTRY_OPTIONS + '</select>' +
            '</div>' +
            '<div class="col-lg-4 col-md-6 mb-3">' +
              '<label class="form-label">Nationality <span class="text-danger">*</span></label>' +
              '<select class="form-control" name="companion_nationality[]" required>' + COUNTRY_OPTIONS + '</select>' +
            '</div>' +
            '<div class="col-lg-3 col-md-9 mb-3">' +
              '<label class="form-label">Upload Passport</label>' +
              '<input type="file" class="form-control" name="companion_passport[]" accept=".pdf,.jpg,.jpeg,.png,.gif">' +
            '</div>' +
            '<div class="col-lg-1 col-md-3 mb-3 d-flex align-items-end">' +
              '<button type="button" class="btn btn-outline-danger remove-companion" title="Remove">&times;</button>' +
            '</div>' +
          '</div>' +
        '</div>';
    }

    function unitPrice() {
      var v = $("input[name='package_type']:checked").val() || '';
      return parseFloat(v.replace(/[^0-9.]/g, '')) || 0;
    }
    function peopleCount() {
      var withFamily = $('#travelling_with_family').is(':checked');
      return 1 + (withFamily ? $('#companions_list .companion-item').length : 0);
    }
    function money(n) { return '$' + n.toLocaleString('en-US'); }

    function refreshTotal() {
      var unit = unitPrice(), ppl = peopleCount();
      var html;
      if (unit > 0) {
        html = '<b>Total people travelling:</b> ' + ppl +
               ' &nbsp;|&nbsp; <b>Package price:</b> ' + money(unit) + ' per person' +
               ' &nbsp;|&nbsp; <b style="color:#f54e18;font-size:19px;">Total: ' + money(unit * ppl) + '</b>';
      } else {
        html = '<b>Total people travelling:</b> ' + ppl +
               ' &nbsp;|&nbsp; <span style="color:#f54e18;font-weight:700;">Call for Price</span>';
      }
      $('#price_summary').html(html);
    }

    // Has the traveller declared a spouse (checkbox ticked + name entered) in
    // the Family Information section above?
    function hasSpouse() {
      return $('#spouse').is(':checked') && $.trim($('#spouse_name').val()) !== '';
    }

    // Copy the spouse details from Family Information into a companion row.
    function fillSpouseRow($row) {
      if (!$row || !$row.length) return;
      $row.find("select[name='companion_relation[]']").val(defaultSpouseRelation());
      $row.find("input[name='companion_name[]']").val($.trim($('#spouse_name').val()));
      var bc  = $("select[name='spouse_birth_country']").val();
      var nat = $("select[name='spouse_nationality']").val();
      if (bc)  $row.find("select[name='companion_birth_country[]']").val(bc);
      if (nat) $row.find("select[name='companion_nationality[]']").val(nat);
    }

    function toggleFamily() {
      var on = $('#travelling_with_family').is(':checked');
      $('.companions_block').toggle(on);
      if (on && $('#companions_list .companion-item').length === 0) {
        // First companion is the spouse — preselect relation from traveller gender
        // and auto-fill the spouse's details from Family Information when present.
        $('#companions_list').append(companionRow(defaultSpouseRelation()));
        if (hasSpouse()) fillSpouseRow($('#companions_list .companion-item').first());
      }
      if (!on) {
        // Remove rows so their required (now-hidden) fields don't block submit.
        $('#companions_list').empty();
      }
      refreshTotal();
    }

    $('#travelling_with_family').on('change', toggleFamily);

    // Ticking "Do you have a Spouse?" makes the companions section available and
    // drops the spouse in as the first traveller automatically.
    $('#spouse').on('change', function () {
      if (!$(this).is(':checked')) return;
      if ($('#travelling_with_family').is(':checked')) {
        // Already travelling with family — just (re)fill the spouse row.
        if (hasSpouse()) fillSpouseRow($('#companions_list .companion-item').first());
      } else {
        $('#travelling_with_family').prop('checked', true).trigger('change');
      }
    });

    // Keep the spouse companion row's name in sync while the spouse name is typed.
    $('#spouse_name').on('input', function () {
      if (!$('#travelling_with_family').is(':checked')) return;
      var $first = $('#companions_list .companion-item').first();
      var rel = $first.find("select[name='companion_relation[]']").val();
      // Only sync the first row while it still holds the spouse (Wife/Husband).
      if ($first.length && (rel === 'Wife' || rel === 'Husband')) {
        $first.find("input[name='companion_name[]']").val($.trim($(this).val()));
      }
    });
    $('#add_companion').on('click', function () {
      $('#companions_list').append(companionRow(''));
      refreshTotal();
    });
    $('#companions_list').on('click', '.remove-companion', function () {
      $(this).closest('.companion-item').remove();
      refreshTotal();
    });
    // Recompute when the per-person package price changes.
    $(document).on('change', "input[name='package_type'], .ticket_type", refreshTotal);

    refreshTotal(); // initial state (1 person)
  });
</script>

<script>
  // Date of Birth -> live "Age: N Years" pill next to the DOB field.
  (function () {
    var MONTHS = {JAN:0,FEB:1,MAR:2,APR:3,MAY:4,JUN:5,JUL:6,AUG:7,SEP:8,OCT:9,NOV:10,DEC:11};

    // Parse a DD-MMM-YYYY string (e.g. "08-SEP-1972") into a Date, or null.
    function parseDob(str) {
      if (!str) return null;
      var m = String(str).trim().match(/^(\d{1,2})-([A-Za-z]{3})-(\d{4})$/);
      if (!m) return null;
      var day = parseInt(m[1], 10), mon = MONTHS[m[2].toUpperCase()], year = parseInt(m[3], 10);
      if (mon === undefined) return null;
      var d = new Date(year, mon, day);
      if (d.getFullYear() !== year || d.getMonth() !== mon || d.getDate() !== day) return null;
      return d;
    }

    function ageFrom(dob) {
      var now = new Date();
      var age = now.getFullYear() - dob.getFullYear();
      var mDiff = now.getMonth() - dob.getMonth();
      if (mDiff < 0 || (mDiff === 0 && now.getDate() < dob.getDate())) age--;
      return age;
    }

    function updateAge($input) {
      var $pill = $input.closest('.d-flex').find('.dob-age-pill');
      var dob = parseDob($input.val());
      if (dob && dob <= new Date()) {
        var years = ageFrom(dob);
        $pill.html('Age: <strong>' + years + ' Year' + (years === 1 ? '' : 's') + '</strong>').show();
      } else {
        $pill.hide().empty();
      }
    }

    $(document).on('change input blur', '.dob-age-src', function () { updateAge($(this)); });
    // jQuery UI datepicker fills the value then fires change; also cover prefilled cookie value.
    $(function () { $('.dob-age-src').each(function () { updateAge($(this)); }); });
  })();
</script>
@endsection