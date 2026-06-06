@extends('admin.layouts.app') 
@section('content') 
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Edit Yatri Visa Packages</h4>
            <ul class="db-breadcrumb-list">
                <li>
                  <a href="#">
                    <i class="fa fa-home"></i>Home </a>
                </li>
                <li>Admin Can Edit Yatri Applied Visa Packages</li>
            </ul>
        </div>
        <div class="main-body">
            <div class=" px-5" bis_skin_checked="1">
                <form method="POST" action="{{ url('admin/yatri-visa-update/'.$yatri->id) }}" class="row g-3 mt-4" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 row mb-3 w-100" id="main">
                      <div class="accordion w-100" id="faq">
                        <div class="card">
                          <div id="faq1" class="">
                            <div class="card-body row"> 
                              <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <label>Passport No <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="{{ @$yatri['passport'] }}" name="passport" placeholder="Enter Passport No" required>
                                <div class="invalid-feedback">
                                  Please provide valid passport.
                              </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label>Passport Type <span class="text-danger">*</span></label>
                            <select class="form-control select2js" name="passport_type" required>
                              <option value="Ordinary" @if($yatri->passport_type == "Ordinary") selected @endif>Ordinary</option>
                              <option value="Official" @if($yatri->passport_type == "Official") selected @endif>Official</option>
                              <option value="Diplomatic" @if($yatri->passport_type == "Diplomatic") selected @endif>Diplomatic</option>
                              <option value="UN Travel Document" @if($yatri->passport_type == "UN Travel Document") selected @endif>UN Travel Document</option>
                              <option value="UNLP" @if($yatri->passport_type == "UNLP") selected @endif>UNLP</option>
                              <option value="Travel/Asylum/Temporary" @if($yatri->passport_type == "Travel/Asylum/Temporary") selected @endif>Travel/Asylum/Temporary</option>
                          </select>
                          <div class="invalid-feedback">
                              Please select passport type.
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label for="issuing_authority" class="form-label">Issuing Authority <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="issuing_authority" value="{{ @$yatri['issuing_authority'] }}" id="issuing_authority" placeholder="Enter Issuing Authority" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                          Please provide issuing authority.
                      </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label>Passport Country <span class="text-danger">*</span></label>
                    <select class="form-control select2js passport_country" name="passport_country" required>
                      @foreach(@$countries as $key => $val)
                      <option value="{{ @$val->nicename }}" @if($yatri->passport_country == $val->nicename) selected @endif>{{ @$val->nicename }}</option>
                      @endforeach
                  </select>
                  <div class="invalid-feedback">
                      Please select passport type.
                  </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <label>Issue Date <span class="text-danger">*</span></label>
                <input class="form-control" type="date" name="issue_date" value="{{ @$yatri['issue_date'] }}" max="{{ date('Y-m-d') }}"
                required>
                <div class="invalid-feedback">
                  Please provide issue date.
              </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <label>Expiry Date <span class="text-danger">*</span></label>
            <input class="form-control" type="date" name="expiry_date" value="{{ @$yatri['expiry_date'] }}" min="{{ date('Y-m-d') }}">
            <div class="invalid-feedback">
              Please provide expiry date.
          </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area" @if(empty(@$yatri['reference_no'])) style="display: none;" @endif>
        <label>Reference No <span class="text-danger">*</span></label>
        <input class="form-control phone_us" type="text" value="{{ @$yatri['reference_no'] }}" name="reference_no" placeholder="Enter Reference No" maxlength="11">
        <div class="invalid-feedback">
          Please select reference number.
      </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area">
    <label>Permanent Residence Country <span class="text-danger">*</span></label>
    <select class="form-control select2js" name="residence_country">
      @foreach(@$countries as $key => $val)
      <option value="{{ @$val['nicename'] }}" @if($yatri->residence_country == $val->nicename) selected @endif>{{ @$val['nicename'] }}</option> 
      @endforeach
  </select>
  <div class="invalid-feedback">
      Please select permanent residence country.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3 green_card_area" @if(empty(@$yatri['green_card_expiry_date'])) style="display: none;" @endif>
    <label>Expiry Date <span class="text-danger">*</span></label>
    <input class="form-control" type="date" value="{{ @$yatri['green_card_expiry_date'] }}" name="green_card_expiry_date" min="{{ date('Y-m-d') }}">
    <div class="invalid-feedback">
      Please provide expiry date.
  </div>
</div>

</div>
</div>
</div>
<div class="card">
  

  <div id="faq2" class="" aria-labelledby="faqhead2" data-parent="#faq">
    <div class="card-body row pt-3">
      <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="first_name" value="{{ @$yatri['first_name'] }}" id="first_name" placeholder="Enter First Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
        <div class="invalid-feedback">
          Please provide first name.
      </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="middle_name" class="form-label">Middle Name</label>
    <input type="text" class="form-control" name="middle_name" value="{{ @$yatri['middle_name'] }}" id="middle_name" placeholder="Enter Middle Name" onkeydown="return /[a-z ]/i.test(event.key)">
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="last_name" value="{{ @$yatri['last_name'] }}" id="last_name" placeholder="Enter Last Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
    <div class="invalid-feedback">
      Please provide last name.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Date of Birth <span class="text-danger">*</span></label>
    <input class="form-control" type="date" name="dob" value="{{ @$yatri['dob'] }}" max="{{ date('Y-m-d') }}"
    required>
    <div class="invalid-feedback">
      Please provide date of birth.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="place_birth" class="form-label">Place of Birth <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="place_birth" value="{{ @$yatri['place_birth'] }}" id="place_birth" placeholder="Enter Place of Birth" onkeydown="return /[a-z ]/i.test(event.key)" required>
    <div class="invalid-feedback">
      Please provide place of birth.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Marital Status <span class="text-danger">*</span></label>
    <div class="form-check row">
      <input class="mr-1 marital_status" type="radio" name="marital_status"
      value="single" id="single_status" @if(@$yatri['marital_status'] == 'single' || empty(@$yatri['marital_status'])) checked @endif required>
      <label class="form-check-label mr-2" for="single_status">Single</label>
      <input class="mr-1 marital_status" type="radio" name="marital_status"
      value="married" id="married_status" @if(@$yatri['marital_status'] == 'married') checked @endif required>
      <label class="form-check-label mr-2" for="married_status">Married</label>
      <input class="mr-1 marital_status" type="radio" name="marital_status"
      value="widowed" id="widowed_status" @if(@$yatri['marital_status'] == 'widowed') checked @endif required>
      <label class="form-check-label mr-2" for="widowed_status">Widowed</label>
      <input class="mr-1 marital_status" type="radio" name="marital_status"
      value="divorced" id="divorced_status" @if(@$yatri['marital_status'] == 'divorced') checked @endif required>
      <label class="form-check-label mr-2" for="divorced_status">Divorced</label>
      <input class="mr-1 marital_status" type="radio" name="marital_status"
      value="separated" id="separated_status" @if(@$yatri['marital_status'] == 'separated') checked @endif required>
      <label class="form-check-label mr-2" for="separated_status">Separated</label>
      <div class="invalid-feedback">
        Please select one of them.
    </div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Gender <span class="text-danger">*</span></label>
    <div class="form-check row">
      <input class="mr-1" type="radio" name="gender" id="male" value="male" @if(@$yatri['gender'] == 'male' || empty(@$yatri['gender'])) checked @endif required>
      <label class="form-check-label mr-2" for="male">Male</label>
      <input class="mr-1" type="radio" name="gender" id="female" @if(@$yatri['gender'] == 'female') checked @endif value="female" required>
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
      <option value="Sikhism" @if(@$yatri['religion'] == 'Sikhism') selected @endif>Sikhism</option>
      <option value="Islam" @if(@$yatri['religion'] == 'Islam') selected @endif>Islam</option>
      <option value="Christianity" @if(@$yatri['religion'] == 'Christianity') selected @endif>Christianity</option>
      <option value="Hinduism" @if(@$yatri['religion'] == 'Hinduism') selected @endif>Hinduism</option>
      <option value="Buddhism" @if(@$yatri['religion'] == 'Buddhism') selected @endif>Buddhism</option>
  </select>
  <div class="invalid-feedback">
      Please select your religion.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
    <input type="email" class="form-control" name="email" value="{{ @$yatri['email'] }}" id="email" placeholder="Enter Email Address" required>
    <div class="invalid-feedback">
      Please provide email address.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="email" class="form-label">Other Email Address </label>
    <input type="email" class="form-control" name="other_email" value="{{ @$yatri['other_email'] }}" id="email" placeholder="Enter Email Address">
    <div class="invalid-feedback">
      Please provide email address.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="phone" class="form-label">Mobile Number <span class="text-danger">*</span></label>
    <input type="tel" class="form-control phone_us" maxlength="12" value="{{ @$yatri['phone'] }}" name="phone" placeholder="Enter mobile number" id="phone" required>
    <div class="invalid-feedback">
      Please provide your mobile number.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="other_phone" class="form-label">Other Mobile Number</label>
    <input type="tel" class="form-control phone_us" maxlength="12" value="{{ @$yatri['other_phone'] }}" name="other_phone" placeholder="Enter any other mobile number" id="other_phone">
    <div class="invalid-feedback">
      Please provide any other mobile number.
  </div>
</div>

</div>
</div>
</div>
<div class="card">
  <div id="faq3" class="" aria-labelledby="faqhead3" data-parent="#faq">
    <div class="card-body row pt-3">
      <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
        <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Enter Father Name" value="{{ @$yatri['father_name'] }}" onkeydown="return /[a-z ]/i.test(event.key)" required>
        <div class="invalid-feedback">
          Please provide father name.
      </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label class="w-100">Nationality <span class="text-danger">*</span></label>
    <select class="form-control select2js" name="father_nationality" required>
      @foreach(@$countries as $key => $val)
      @if(empty(@$yatri['father_nationality']) && @$val['nicename'] == "United States")
      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
      @else
      <option value="{{ @$val['nicename'] }}" @if(@$yatri['father_nationality'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
      @endif
      @endforeach
  </select>
  <div class="invalid-feedback">
      Please select nationality.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="mother_name" class="form-label">Mother Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Enter Mother Name" value="{{ @$yatri['mother_name'] }}" onkeydown="return /[a-z ]/i.test(event.key)" required>
    <div class="invalid-feedback">
      Please provide mother name.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label class="w-100">Nationality <span class="text-danger">*</span></label>
    <select class="form-control select2js" name="mother_nationality" required>
      @foreach(@$countries as $key => $val)
      @if(empty(@$yatri['mother_nationality']) && @$val['nicename'] == "United States")
      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
      @else
      <option value="{{ @$val['nicename'] }}" @if(@$yatri['mother_nationality'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
      @endif
      @endforeach
  </select>
  <div class="invalid-feedback">
      Please select nationality.
  </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 mb-3 have_spouse" @if(empty(@$yatri['have_spouse'])) style="display: none;" @endif>
    <input type="checkbox" name="have_spouse" @if(!empty(@$yatri['have_spouse'])) checked @endif id="spouse" value="yes">
    <label class="form-label mb-0" for="spouse" style="font-weight: 100;">Do you have a Spouse?</label>
    <div class="invalid-feedback">
      Please provide your spouse detail.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3 spouse_area" @if(empty(@$yatri['spouse_name'])) style="display: none;" @endif>
    <label for="spouse_name" class="form-label">Full Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control" value="{{ @$yatri['spouse_name'] }}" name="spouse_name" id="spouse_name" placeholder="Enter Spouse Name" onkeydown="return /[a-z ]/i.test(event.key)">
    <div class="invalid-feedback">
      Please provide spouse name.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3 spouse_area" @if(empty(@$yatri['spouse_birth_country'])) style="display: none;" @endif>
    <label class="w-100">Country of Birth <span class="text-danger">*</span></label>
    <select class="form-control select2js" name="spouse_birth_country">
      @foreach(@$countries as $key => $val)
      @if(empty(@$yatri['spouse_birth_country']) && @$val['nicename'] == "United States")
      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
      @else
      <option value="{{ @$val['nicename'] }}" @if(@$yatri['spouse_birth_country'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
      @endif
      @endforeach
  </select>
  <div class="invalid-feedback">
      Please select country of birth.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3 spouse_area" @if(empty(@$yatri['spouse_nationality'])) style="display: none;" @endif>
    <label class="w-100">Nationality <span class="text-danger">*</span></label>
    <select class="form-control select2js" name="spouse_nationality">
      @foreach(@$countries as $key => $val)
      @if(empty(@$yatri['spouse_nationality']) && @$val['nicename'] == "United States")
      <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
      @else
      <option value="{{ @$val['nicename'] }}" @if(@$yatri['spouse_nationality'] == @$val['nicename']) selected @endif>{{ @$val['nicename'] }}</option>
      @endif
      @endforeach
  </select>
  <div class="invalid-feedback">
      Please select nationality of spouse.
  </div>
</div>
</div>
</div>
</div>
<div class="card">
  <div id="faq4" class="" aria-labelledby="faqhead4" data-parent="#faq">
    <div class="card-body row pt-3">
      <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
        <label for="profession" class="form-label">Profession <span class="text-danger">*</span></label>
        <input type="text" class="form-control w-50" value="{{ @$yatri['profession'] }}" name="profession" id="profession" placeholder="Enter Profession" onkeydown="return /[a-z ]/i.test(event.key)" required>
        <div class="invalid-feedback">
          Please provide profession.
      </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Have you travelled to any country in past 3 years? <span class="text-danger">*</span></label>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <div class="form-check row">
      <input class="mr-1 travel_history" type="radio" name="travel_history" id="travel_history_yes" value="yes" @if(@$yatri['travel_history'] == "yes") checked @endif required>
      <label class="form-check-label mr-2" for="travel_history_yes">Yes</label>
      <input class="mr-1 travel_history" type="radio" name="travel_history" id="travel_history_no" value="no" @if(@$yatri['travel_history'] == "no" || empty(@$yatri['travel_history'])) checked @endif required>
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
      <input class="mr-1 pk_travel_history" type="radio" @if(@$yatri['pk_travel_history'] == "yes") checked @endif name="pk_travel_history" id="pk_history_yes" value="yes" required>
      <label class="form-check-label mr-2" for="pk_history_yes">Yes</label>
      <input class="mr-1 pk_travel_history" type="radio" name="pk_travel_history" @if(@$yatri['pk_travel_history'] == "no" || empty(@$yatri['pk_travel_history'])) checked @endif id="pk_history_no" value="no" checked required>
      <label class="form-check-label mr-2" for="pk_history_no">No</label>
      <div class="invalid-feedback">
        Please select any one.
    </div>
</div>
</div>
</div>
</div>
</div>
<div class="card">

  <div id="faq5" class="" aria-labelledby="faqhead5" data-parent="#faq">
    <div class="card-body row pt-3">
      <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
        <label for="gurdwara" class="form-label">Select Gurdwara <span class="text-danger">*</span></label>
        <select class="form-control select2js" name="gurdwara_id" id="gurdwara" required>
          @foreach(@$gurdwaras as $key => $val)
          <option value="{{ @$val['id'] }}" @if(@$yatri['gurdwara_id'] == @$val['id']) selected @endif>{{ @$val['gurdwara_name'] }}</option>
          @endforeach
          <option value="Other" @if(@$yatri['gurdwara_id'] == "Other") selected @endif>Other</option>
      </select>
      <div class="invalid-feedback">
          Please select any gurdwara.
      </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Name of Nearest Gurdwara <span class="text-danger">*</span></label>
    <input class="form-control" value="{{ @$yatri['gurdwara_name'] }}" type="text" name="gurdwara_name" id="nearest_gurdwara" placeholder="Enter name of your nearest gurdwara" onkeydown="return /[a-z ]/i.test(event.key)" required>
    <div class="invalid-feedback">
      Please provide nearest gurdwara name.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Address <span class="text-danger">*</span></label>
    <input class="form-control" value="{{ @$yatri['address'] }}" type="text" name="address" placeholder="Enter Address" required>
    <div class="invalid-feedback">
      Please provide address.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>City <span class="text-danger">*</span></label>
    <input class="form-control" value="{{ @$yatri['city'] }}" type="text" name="city"
    placeholder="Enter city" onkeydown="return /[a-z ]/i.test(event.key)" required>
    <div class="invalid-feedback">
      Please provide city.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>State <span class="text-danger">*</span></label>
    <select class="form-control select2js" name="state" required>
      <option value="AL" @if(@$yatri['state'] == "AL") selected @endif>Alabama</option>
      <option value="AK" @if(@$yatri['state'] == "AK") selected @endif>Alaska</option>
      <option value="AZ" @if(@$yatri['state'] == "AZ") selected @endif>Arizona</option>
      <option value="AR" @if(@$yatri['state'] == "AR") selected @endif>Arkansas</option>
      <option value="CA" @if(@$yatri['state'] == "CA") selected @endif>California</option>
      <option value="CO" @if(@$yatri['state'] == "CO") selected @endif>Colorado</option>
      <option value="CT" @if(@$yatri['state'] == "CT") selected @endif>Connecticut</option>
      <option value="DE" @if(@$yatri['state'] == "DE") selected @endif>Delaware</option>
      <option value="FL" @if(@$yatri['state'] == "FL") selected @endif>Florida</option>
      <option value="GA" @if(@$yatri['state'] == "GA") selected @endif>Georgia</option>
      <option value="HI" @if(@$yatri['state'] == "HI") selected @endif>Hawaii</option>
      <option value="ID" @if(@$yatri['state'] == "ID") selected @endif>Idaho</option>
      <option value="IL" @if(@$yatri['state'] == "IL") selected @endif>Illinois</option>
      <option value="IN" @if(@$yatri['state'] == "IN") selected @endif>Indiana</option>
      <option value="IA" @if(@$yatri['state'] == "IA") selected @endif>Iowa</option>
      <option value="KS" @if(@$yatri['state'] == "KS") selected @endif>Kansas</option>
      <option value="KY" @if(@$yatri['state'] == "KY") selected @endif>Kentucky</option>
      <option value="LA" @if(@$yatri['state'] == "LA") selected @endif>Louisiana</option>
      <option value="ME" @if(@$yatri['state'] == "ME") selected @endif>Maine</option>
      <option value="MD" @if(@$yatri['state'] == "MD") selected @endif>Maryland</option>
      <option value="MA" @if(@$yatri['state'] == "MA") selected @endif>Massachusetts</option>
      <option value="MI" @if(@$yatri['state'] == "MI") selected @endif>Michigan</option>
      <option value="MN" @if(@$yatri['state'] == "MN") selected @endif>Minnesota</option>
      <option value="MS" @if(@$yatri['state'] == "MS") selected @endif>Mississippi</option>
      <option value="MO" @if(@$yatri['state'] == "MO") selected @endif>Missouri</option>
      <option value="MT" @if(@$yatri['state'] == "MT") selected @endif>Montana</option>
      <option value="NE" @if(@$yatri['state'] == "NE") selected @endif>Nebraska</option>
      <option value="NV" @if(@$yatri['state'] == "NV") selected @endif>Nevada</option>
      <option value="NH" @if(@$yatri['state'] == "NH") selected @endif>New Hampshire</option>
      <option value="NJ" @if(@$yatri['state'] == "NJ") selected @endif>New Jersey</option>
      <option value="NM" @if(@$yatri['state'] == "NM") selected @endif>New Mexico</option>
      <option value="NY" @if(@$yatri['state'] == "NY") selected @endif>New York</option>
      <option value="NC" @if(@$yatri['state'] == "NC") selected @endif>North Carolina</option>
      <option value="ND" @if(@$yatri['state'] == "ND") selected @endif>North Dakota</option>
      <option value="OH" @if(@$yatri['state'] == "OH") selected @endif>Ohio</option>
      <option value="OK" @if(@$yatri['state'] == "OK") selected @endif>Oklahoma</option>
      <option value="OR" @if(@$yatri['state'] == "OR") selected @endif>Oregon</option>
      <option value="PA" @if(@$yatri['state'] == "PA") selected @endif>Pennsylvania</option>
      <option value="RI" @if(@$yatri['state'] == "RI") selected @endif>Rhode Island</option>
      <option value="SC" @if(@$yatri['state'] == "SC") selected @endif>South Carolina</option>
      <option value="SD" @if(@$yatri['state'] == "SD") selected @endif>South Dakota</option>
      <option value="TN" @if(@$yatri['state'] == "TN") selected @endif>Tennessee</option>
      <option value="TX" @if(@$yatri['state'] == "TX") selected @endif>Texas</option>
      <option value="UT" @if(@$yatri['state'] == "UT") selected @endif>Utah</option>
      <option value="VT" @if(@$yatri['state'] == "VT") selected @endif>Vermont</option>
      <option value="VA" @if(@$yatri['state'] == "VA") selected @endif>Virginia</option>
      <option value="WA" @if(@$yatri['state'] == "WA") selected @endif>Washington</option>
      <option value="WV" @if(@$yatri['state'] == "WV") selected @endif>West Virginia</option>
      <option value="WI" @if(@$yatri['state'] == "WI") selected @endif>Wisconsin</option>
      <option value="WY" @if(@$yatri['state'] == "WY") selected @endif>Wyoming</option>
      <option value="DC" @if(@$yatri['state'] == "DC") selected @endif>District of Columbia</option>
      <option value="AS" @if(@$yatri['state'] == "AS") selected @endif>American Samoa</option>
      <option value="GU" @if(@$yatri['state'] == "GU") selected @endif>Guam</option>
      <option value="MP" @if(@$yatri['state'] == "MP") selected @endif>Northern Mariana Islands</option>
      <option value="PR" @if(@$yatri['state'] == "PR") selected @endif>Puerto Rico</option>
      <option value="UM" @if(@$yatri['state'] == "UM") selected @endif>United States Minor Outlying Islands</option>
      <option value="VI" @if(@$yatri['state'] == "VI") selected @endif>Virgin Islands, U.S.</option>
  </select>
  <div class="invalid-feedback">
      Please select state.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Zip <span class="text-danger">*</span></label>
    <input class="form-control" type="text" value="{{@$yatri->zip}}" name="zip" placeholder="Enter zip" required>
    <div class="invalid-feedback">
      Please provide valid zip.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Name of Secretary Gurdwara</label>
    <input class="form-control" type="text" value="{{@$yatri->secretary_phone}}" name="secetary_name" placeholder="Enter name of secetary gurdwara" onkeydown="return /[a-z ]/i.test(event.key)">
    <div class="invalid-feedback">
      Please provide name of secretary.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Mobile Number</label>
    <input type="tel" class="form-control phone_us" value="{{@$yatri->reference_phone}}" maxlength="12" name="secretary_phone" placeholder="Enter phone number of secretary">
    <div class="invalid-feedback">
      Please provide phone number of secretary.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Reference Person Name <span class="text-danger">*</span></label>
    <input class="form-control" type="text" value="{{@$yatri->reference_name}}" name="reference_name"
    placeholder="Enter name of reference contact person" onkeydown="return /[a-z ]/i.test(event.key)" required>
    <div class="invalid-feedback">
      Please provide name of secretary.
  </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label>Reference Person Mobile Number <span class="text-danger">*</span></label>
    <input type="tel" class="form-control phone_us" value="{{@$yatri->reference_phone}}" maxlength="12" name="reference_phone" placeholder="Enter phone number of reference person" required>
    <div class="invalid-feedback">
      Please provide phone number of secretary.
  </div>
</div>
</div>
</div>
</div>
<div class="card">

  <div id="faq6" class="" aria-labelledby="faqhead6" data-parent="#faq">
    <div class="card-body row pt-3">
      <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
        <label for="photoFile" class="form-label">Upload Photo <span class="text-danger">*</span></label>
        <input class="form-control" type="file" name="photo" id="photoFile">
        @if(!empty(@$yatri->photo))
        <div class="mt-3">
          <img style="width: 100px" src="{{asset('photo_uploads/'.$yatri->photo)}}" alt="">
      </div>
      @endif
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="formFile" class="form-label">Upload Passport <span class="text-danger">*</span></label>
    <input class="form-control" type="file" name="us_passport" id="formFile">
    @if(!empty(@$yatri->us_passport))
    <div class="mt-3">
        <img style="width: 100px" src="{{asset('passport_uploads/'.$yatri->us_passport)}}" alt="">
    </div>
    @endif
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="formFile" class="form-label">Upload ID/Driving License <span class="text-danger">*</span></label>
    <input class="form-control" type="file" name="driving_license" id="formFile">
    @if(!empty(@$yatri->driving_license))
    <div class="mt-3">
        <img style="width: 100px" src="{{asset('drivinglicense_uploads/'.$yatri->driving_license)}}" alt="">
    </div>
    @endif
</div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
    <label for="formFile" class="form-label">Upload Green Card</label>
    <input class="form-control" type="file" name="green_card" id="green-card">
    @if(!empty(@$yatri->green_card))
    <div class="mt-3">
        <img style="width: 100px" src="{{asset('greencard_uploads/'.$yatri->green_card)}}" alt="">
    </div>
    @endif
</div>
<div class="col-lg-1  col-md-1 col-sm-12 mb-3">
    <button type="submit" class="btn btn-lg btn-block btn-success mt-2 mx-1 mb-2">Submit</button>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</main>
<div class="ttr-overlay"></div>
@endsection