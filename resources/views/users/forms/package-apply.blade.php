@extends('userslayouts.app')
@section('content')

    <style type="text/css">
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
        .select2-selection.select2-selection--single, .select2-selection__rendered {
            min-height: 40px;
        }
        .select2-selection__rendered, .select2-selection__arrow {
            margin-top: 5px;
        }
        .select2-container--default .select2-selection--single {
            border-color: #a8a8a8 !important;
            font-size: 14px;
        }
        input, select {
            border-color: #a8a8a8 !important;
        } 
    </style>

    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <h4 class="breadcrumb-title">List of Yatri's</h4>
                <ul class="db-breadcrumb-list">
                    <li><a href="{{ url('/user/user_dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                    <li>List of Yatri's</li>
                </ul>
            </div>
            <!-- Breadcrumb row END -->
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-4">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                </div>
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
            <!-- inner page banner -->
            <div class="page-banner contact-page section-sp2" style="margin-top: -80px;">
                <div class="container px-5 py-4 mt-4" style="border: 1px solid #aaa; background-color: #eeeeee4a; border-radius: 10px;">
                    <div class="row mt-4">
                        <div class="col-12 row mb-3">
                            <h5 class="col-lg-12 text-center" style="font-size: 20px; color: #000;">Ticket Type</h5>
                            <div class="col-lg-6 form-check p-2 text-center">
                                <input class="form-check-input ticket_type mt-2" type="radio" name="ticket_type" id="round_way" value="round_way" checked>
                                <label class="form-check-label" for="round_way" style="font-size: 20px; color: #000;"> Round Way Ticket </label>
                            </div>
                            <div class="col-lg-6 form-check p-2 text-center">
                                <input class="form-check-input ticket_type mt-2" type="radio" name="ticket_type" id="one_way" value="one_way">
                                <label class="form-check-label" for="one_way" style="font-size: 20px; color: #000;"> One Way Ticket </label>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h5 class="mb-2 text-center round_way_description">{{ @$packages->round_way_description }}</h5>
                            <h5 class="mb-2 text-center one_way_description" style="display: none;">{{ @$packages->one_way_description }}</h5>
                            <h6 class="mb-4 text-center text-danger">INCLUDES VISA AND FULL SECURITY</h6>
                            <form method="POST" action="{{route('user-store-yatri-visa')}}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                @csrf
                                @php
                                    $timestamp = strtotime(@$packages->month_year);
                                    $new_date_format = date('F Y', $timestamp);
                                @endphp
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="package_id" type="hidden" value="{{ @$id }}" id="package_1">
                                        <input class="form-check-input" name="package_month" type="hidden" value="November 2023" id="package_month">
                                        <input class="form-check-input" name="ticket_type" type="hidden" id="ticket_type" value="round_way" id="package_month">
                                        <label class="form-check-label" for="flexCheckDefault" style="font-size: 16px;">
                                            November 2023 Package
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                                    <table class="w-100" style="background-color: #fff;">
                                        <thead>
                                            <tr>
                                                @if(!empty(@$packages->one_single_price))
                                                <td class="text-center"><b style="color: #000;">Single Occupancy</b></td>
                                                @endif
                                                @if(!empty(@$packages->one_double_price))
                                                <td class="text-center"><b style="color: #000;">Double Occupancy</b></td>
                                                @endif
                                                @if(!empty(@$packages->one_triple_price))
                                                <td class="text-center"><b style="color: #000;">Triple Occupancy</b></td>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if(!empty(@$packages->one_single_price))
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="package_type" data-back-one="Single ${{ @$packages->one_single_price }}" data-back-round="Single ${{ @$packages->round_single_price }}" value="Single ${{ @$packages->round_single_price }}" id="package_type_1" checked>
                                                    <label class="form-check-label package_type_1" for="package_type_1" data-back-one="${{ @$packages->one_single_price }}" data-back-round="${{ @$packages->round_single_price }}"> ${{ @$packages->round_single_price }} </label>
                                                </td>
                                                @endif
                                                @if(!empty(@$packages->one_double_price))
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="package_type" data-back-one="Double ${{ @$packages->one_double_price }}" data-back-round="Double ${{ @$packages->round_double_price }}" value="Double ${{ @$packages->round_double_price }}" id="package_type_2">
                                                    <label class="form-check-label package_type_2" for="package_type_2" data-back-one="(Less $100 in Double Occupancy for 2nd Person) If wife and husband traveling" data-back-round="(Less $100 in Double Occupancy for 2nd Person) If wife and husband traveling"> (Less $100 in Double Occupancy for 2nd Person) If wife and husband traveling</label>
                                                </td>
                                                @endif
                                                @if(!empty(@$packages->one_triple_price))
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="package_type" data-back-one="Triple ${{ @$packages->one_triple_price }}" data-back-round="Triple ${{ @$packages->round_triple_price }}" value="Triple ${{ @$packages->round_triple_price }}" id="package_type_3">
                                                    <label class="form-check-label package_type_3" for="package_type_3" data-back-one="${{ @$packages->one_triple_price }}" data-back-round="${{ @$packages->round_triple_price }}"> ${{ @$packages->round_triple_price }} </label>
                                                </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-12 mt-2">
                                    <h5 class="text-center">Instructions and Documents required</h5>
                                    <ul class="mt-2">
                                        <li>1 Photograph (white background)</li>
                                        <li>Copy of Passport (6 months valid Passport /copy of Green Card if not US citizen)</li>
                                        <li>Copy of ID card / Driver’s License</li>
                                        <li>Applications required 8 weeks before departure</li>
                                    </ul>
                                </div>

                                <div class="col-12 mt-2">
                                    <h5>Visa Form to be filled up</h5>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="first_name"
                                                    id="exampleFormControlInput1" placeholder="Enter First Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                                <div class="invalid-feedback">
                                                    Please provide first name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Middle Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="middle_name"
                                                    id="exampleFormControlInput1" placeholder="Enter Middle Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                                <div class="invalid-feedback">
                                                    Please provide middle name.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="last_name"
                                                    id="exampleFormControlInput1" placeholder="Enter Last Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                                <div class="invalid-feedback">
                                                    Please provide last name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Place of Birth <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="place_birth"
                                                    id="exampleFormControlInput1" placeholder="Enter place of birth" required>
                                                <div class="invalid-feedback">
                                                    Please provide place of birth.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Email Address <span class="text-danger">*</span></label>
                                            <input class="form-control" type="email" name="email"
                                                placeholder="Enter Email Address" required>
                                            <div class="invalid-feedback">
                                                Please provide email address.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Telephone <span class="text-danger">*</span></label>
                                            <input class="form-control phone_us" maxlength="12" name="telephone"
                                                placeholder="Enter Telephone" required>
                                            <div class="invalid-feedback">
                                                Please provide telephone.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Date of Birth <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="dob" max="{{ date('Y-m-d') }}"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide date of birth.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="nationality" id="nationality" required>
                                                @foreach(@$countries as $key => $val)
                                                @if(@$val['nicename'] == "United States")
                                                <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                                                @else
                                                <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide nationality.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>Passport No <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="passport"
                                                placeholder="Your Passport" required>
                                            <div class="invalid-feedback">
                                                Please provide valid passport.
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>Date of Issue <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="issue_date" required>
                                            <div class="invalid-feedback">
                                                Please provide valid passport issue date.
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>Date of Expiry <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="expiry_date" required>
                                            <div class="invalid-feedback">
                                                Please provide valid passport expiry date.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>Other Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="other_nationality" id="other_nationality" required>
                                                <option value="None">None</option>
                                                @foreach(@$countries as $key => $val)
                                                @if(@$val['nicename'] == "United States")
                                                <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                                                @else
                                                <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide other nationality.
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>Acquisition Date <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="acquisition_date" required>
                                            <div class="invalid-feedback">
                                                Please provide acquisition date.
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>Passport No</label>
                                            <input class="form-control" type="text" name="other_passport" placeholder="Your Other Passport">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Father Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="father_name" placeholder="Enter Father Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                            <div class="invalid-feedback">
                                                Please provide father name.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="father_nationality" id="father_nationality" required>
                                                @foreach(@$countries as $key => $val)
                                                @if(@$val['nicename'] == "United States")
                                                <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                                                @else
                                                <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide father nationality.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Mother Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="mother_name" placeholder="Enter Mother Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                            <div class="invalid-feedback">
                                                Please provide mother name.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="mother_nationality" id="mother_nationality" required>
                                                @foreach(@$countries as $key => $val)
                                                @if(@$val['nicename'] == "United States")
                                                <option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>
                                                @else
                                                <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide mother nationality.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Gender <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked required>
                                                <label class="form-check-label" for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                                <label class="form-check-label" for="female">Female</label>
                                                <div class="invalid-feedback">
                                                    Please select gender.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Marital Status <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="marital_status"
                                                    value="single" id="single_status" checked required>
                                                <label class="form-check-label" for="single_status">Single</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" name="marital_status"
                                                    value="married" id="married_status" required>
                                                <label class="form-check-label" for="married_status">Married</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" name="marital_status"
                                                    value="widowed" id="widowed_status" required>
                                                <label class="form-check-label" for="widowed_status">Widowed</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" name="marital_status"
                                                    value="divorced" id="divorced_status" required>
                                                <label class="form-check-label" for="divorced_status">Divorced</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" name="marital_status"
                                                    value="separated" id="separated_status" required>
                                                <label class="form-check-label" for="separated_status">Separated</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="invalid-feedback">
                                                    Please select one of them.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Do you have US Passport? <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="yes" name="have_passport" id="pass_yes" required>
                                                <label class="form-check-label" for="pass_yes">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" value="no" name="have_passport" id="pass_no" checked required>
                                                <label class="form-check-label" for="pass_no">No</label>
                                                <div class="invalid-feedback">
                                                    Please select one of them.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Is this your first visit to Pakistan? <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="first_visit"
                                                    value="yes" id="visit_yes" checked required>
                                                <label class="form-check-label" for="visit_yes">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" name="first_visit"
                                                    value="no" id="visit_no" required>
                                                <label class="form-check-label" for="visit_no">No</label>
                                                <div class="invalid-feedback">
                                                    Please select one of them.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-2" id="first-visit" style="display: none;">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label> Date of Previous Visit</label>
                                            <input class="form-control" type="date" id="previous-visit"
                                                name="pre_visit_date" max="{{ date('Y-m-d') }}">
                                            <div class="invalid-feedback">
                                                Please provide previous visit date.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label> Port of Entry</label>
                                            <input class="form-control" type="text" id="entry-port" name="port_of_entry"
                                                placeholder="Enter port of Entery" onkeydown="return /[a-z ]/i.test(event.key)">
                                            <div class="invalid-feedback">
                                                Please provide port of entry.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Profession <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="profession"
                                                placeholder="What's your profession" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                            <div class="invalid-feedback">
                                                Please provide profession.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="gurdwara" class="form-label">Select Gurdwara <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="gurdwara_id" id="gurdwara" required>
                                                {{-- <option selected disabled>Select Gurdwara</option> --}}
                                                @foreach(@$gurdwaras as $key => $val)
                                                <option value="{{ @$val['id'] }}">{{ @$val['gurdwara_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select any gurdwara.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Name of Nearest Gurdwara <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="gurdwara_name"
                                                placeholder="Enter name of your nearest gurdwara" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                            <div class="invalid-feedback">
                                                Please provide nearest gurdwara name.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Address <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="address"
                                                placeholder="Enter Address" required>
                                            <div class="invalid-feedback">
                                                Please provide address.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-2">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>City <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="city"
                                                placeholder="Enter city" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                            <div class="invalid-feedback">
                                                Please provide city.
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>State <span class="text-danger">*</span></label>
                                            <select class="form-control select2js" name="state" required>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                                <option value="DC">District of Columbia</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="GU">Guam</option>
                                                <option value="MP">Northern Mariana Islands</option>
                                                <option value="PR">Puerto Rico</option>
                                                <option value="UM">United States Minor Outlying Islands</option>
                                                <option value="VI">Virgin Islands, U.S.</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide state.
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label>Zip <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="zip"
                                                placeholder="Enter zip" required>
                                            <div class="invalid-feedback">
                                                Please provide valid zip.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Name of Secretary Gurdwara <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="secetary_name"
                                                placeholder="Enter name of secetary gurdwara" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                            <div class="invalid-feedback">
                                                Please provide name of secretary.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Telephone <span class="text-danger">*</span></label>
                                            <input class="form-control phone_us" maxlength="12" name="secretary_phone"
                                                placeholder="Enter phone number of secretary" required>
                                            <div class="invalid-feedback">
                                                Please provide phone number of secretary.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-2">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Reference Contact Person Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="reference_name"
                                                placeholder="Enter name of reference contact person" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                            <div class="invalid-feedback">
                                                Please provide name of reference contact person.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>Reference Contact Person Telephone <span class="text-danger">*</span></label>
                                            <input class="form-control phone_us" maxlength="12" name="reference_phone"
                                                placeholder="Enter phone number of secretary" required>
                                            <div class="invalid-feedback">
                                                Please provide telephone of reference contact person.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-2" id="us_passport">
                                        <div class="col-lg-6 col-md-4 col-sm-12">
                                            <label for="photoFile" class="form-label">Upload Photo <span class="text-danger">*</span></label>
                                            <input class="form-control" type="file" name="photo" id="photoFile" required>
                                            <div class="invalid-feedback">
                                                Please upload valid photo.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4 col-sm-12">
                                            <label for="formFile" class="form-label">Upload Passport <span class="text-danger">*</span></label>
                                            <input class="form-control" type="file" name="us_passport" id="formFile" required>
                                            <div class="invalid-feedback">
                                                Please upload valid passport.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-2">
                                        <div class="col-lg-6 col-md-4 col-sm-12">
                                            <label for="formFile" class="form-label">Upload Green Card</label>
                                            <input class="form-control" type="file" name="green_card" id="green-card">
                                            <div class="invalid-feedback">
                                                Please upload valid green card.
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4 col-sm-12">
                                            <label for="formFile" class="form-label">Upload ID/Driving License <span class="text-danger">*</span></label>
                                            <input class="form-control" type="file" name="driving_license" id="formFile" required>
                                            <div class="invalid-feedback">
                                                Please upload valid ID or Driving License
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 my-3">
                                    <h4>Passengers Details</h4>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label>Number of Passengers travelling with you</label>
                                            <select class="form-control total_family" name="total_traveling_members" required>
                                                <option value="0" selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide number of passengers.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mb-2" id="family_details">
                                        
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <ul>
                                        <li>Price is guaranteed if booking is made 8 weeks in advance and paid in full. <b>Payable to Konnect.us, Inc. and mail at 185-02 Hillside Avenue, Jamaica NY 11432.</b></li>
                                        <li>Stay in 4 Star Hotel in Islamabad & Lahore.  Breakfast/Dinner and Refreshment included.</li>
                                        <li>Pick and drop transportation throughout the holy trip.</li>
                                        <li>Yatris must follow the group rules and regulation. No private tour is allowed due to security reason</li>
                                        <li>This application is valid till October 31, 2023.</li>
                                        <li>(Double occupancy $100 discount only for one person if wife and husband traveling together. Note: JFK-ISB-LHE-JFK (One way passengers will pay $600 less from the above package price)</li>
                                        <li>For Business Class prices please call <b>RASHAD MAHMOOD @ +1 718-908-9464</b></li>
                                        <li><b>Cancellation of Trip: Airline applicable cancellation charges and $100 service charges applies.</b></li>
                                    </ul>
                                </div>
                                <div class="col-4 mt-2">
                                    <label>Signature of Yatri</label>
                                    <input class="form-control" type="text" name="signature" style="border-top: 0px; border-left: 0px; border-right: 0px;" onkeydown="return /[a-z ]/i.test(event.key)" required>
                                    <div class="invalid-feedback">
                                        Please add your signature.
                                    </div>
                                </div>
                                <div class="col-12 mt-5">
                                    <button class="btn btn-primary px-5">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- inner page banner END -->
        </div>
    </main>
    <!-- Content END-->
    <style>
        table {
            border: 1px solid black;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".select2js").select2();
        });
    </script>
    <script>
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
            // Attach click event listener to radio buttons
            $('input[name="first_visit"]').on('click', function() {
                // If yes is selected, show the div
                if ($(this).val() === 'yes') {
                    $('#previous-visit').prop('required', false);
                    $('#entry-port').prop('required', false);
                    $('#first-visit').hide();
                }
                // If no is selected, hide the div
                else {
                    $('#previous-visit').prop('required', true);
                    $('#entry-port').prop('required', true);
                    $('#first-visit').show();
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
    <script>
        $(document).ready(function() {
            $(document).on('change', ".total_family", function() {
                var total = $(this).val();
                $("#family_details").html("");
                for (var i = 1; i <= total; i++) {
                    var html = `<h4 class="col-lg-12 col-md-12 col-sm-12 my-3">Passenger # ${i}</h4>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_first_name[]"
                            placeholder="Enter First Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide first name.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Middle Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_middle_name[]"
                            placeholder="Enter Middle Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide middle name.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_last_name[]"
                            placeholder="Enter Last Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide last name.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Place of birth <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_pob[]"
                            placeholder="Enter place of birth" required>
                        <div class="invalid-feedback">
                            Please provide place of birth.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Email Address <span class="text-danger">*</span></label>
                        <input class="form-control" type="email" name="passenger_email_address[]"
                            placeholder="Enter Email Address" required>
                        <div class="invalid-feedback">
                            Please provide email address.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Telephone <span class="text-danger">*</span></label>
                        <input class="form-control phone_us" maxlength="12" name="passenger_telephone[]"
                            placeholder="Enter Telephone" required>
                        <div class="invalid-feedback">
                            Please provide telephone.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Date of Birth <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" name="passenger_dob[]" max="{{ date('Y-m-d') }}"
                            required>
                        <div class="invalid-feedback">
                            Please provide date of birth.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Nationality <span class="text-danger">*</span></label>
                        <select class="form-control selectjs" name="passenger_nationality[]" required>`;
                            @foreach(@$countries as $key => $val)
                            @if(@$val['nicename'] == "United States")
                            html += `<option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>`;
                            @else
                            html += `<option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>`
                            @endif
                            @endforeach
                        html += `</select>
                        <div class="invalid-feedback">
                            Please provide nationality of passenger.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>Passport No <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_passport_no[]" placeholder="Enter passport number" required>
                        <div class="invalid-feedback">
                            Please provide valid passport number.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>Date of Issue <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" name="passenger_issue_date[]" required>
                        <div class="invalid-feedback">
                            Please provide valid passport issue date.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>Date of Expiry <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" name="passenger_expiry_date[]" required>
                        <div class="invalid-feedback">
                            Please provide valid passport expiry date.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>Other Nationality <span class="text-danger">*</span></label>
                        <select class="form-control selectjs" name="passenger_other_nationality[]" required>`;
                            @foreach(@$countries as $key => $val)
                            @if(@$val['nicename'] == "United States")
                            html += `<option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>`;
                            @else
                            html += `<option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>`
                            @endif
                            @endforeach
                        html += `</select>
                        <div class="invalid-feedback">
                            Please provide other nationality of passenger.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>Acquisition Date <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" name="passenger_acquisition_date[]" required>
                        <div class="invalid-feedback">
                            Please provide acquisition date.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>Passport No</label>
                        <input class="form-control" type="text" name="passenger_other_passport_no[]" placeholder="Enter passport number">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Father Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_father[]"
                            placeholder="Enter father name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide father name.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Nationality <span class="text-danger">*</span></label>
                        <select class="form-control selectjs" name="passenger_father_nationality[]" required>`;
                            @foreach(@$countries as $key => $val)
                            @if(@$val['nicename'] == "United States")
                            html += `<option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>`;
                            @else
                            html += `<option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>`
                            @endif
                            @endforeach
                        html += `</select>
                        <div class="invalid-feedback">
                            Please provide nationality of father.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Mother Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_mother_name[]" placeholder="Enter Mother Name" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide mother name.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Nationality <span class="text-danger">*</span></label>
                        <select class="form-control selectjs" name="passenger_mother_nationality[]" required>`;
                            @foreach(@$countries as $key => $val)
                            @if(@$val['nicename'] == "United States")
                            html += `<option value="{{ @$val['nicename'] }}" selected>{{ @$val['nicename'] }}</option>`;
                            @else
                            html += `<option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>`
                            @endif
                            @endforeach
                        html += `</select>
                        <div class="invalid-feedback">
                            Please provide other nationality of mother.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Gender <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="passenger_gender_${i}" id="passenger_male_${i}" value="male" required>
                            <label class="form-check-label" for="passenger_male_${i}">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" name="passenger_gender_${i}" id="passenger_female_${i}" value="female" required>
                            <label class="form-check-label" for="passenger_female_${i}">Female</label>
                            <div class="invalid-feedback">
                                Please select gender.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Marital Status <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="passenger_marital_status_${i}"
                                value="single" id="single_status_${i}" checked required>
                            <label class="form-check-label" for="single_status_${i}">Single</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" name="passenger_marital_status_${i}"
                                value="married" id="married_status_${i}" required>
                            <label class="form-check-label" for="married_status_${i}">Married</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" name="passenger_marital_status_${i}"
                                value="widowed" id="widowed_status_${i}" required>
                            <label class="form-check-label" for="widowed_status_${i}">Widowed</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" name="passenger_marital_status_${i}"
                                value="divorced" id="divorced_status_${i}" required>
                            <label class="form-check-label" for="divorced_status_${i}">Divorced</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" name="passenger_marital_status_${i}"
                                value="separated" id="separated_status_${i}" required>
                            <label class="form-check-label" for="separated_status_${i}">Separated</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="invalid-feedback">
                                Please select one of them.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Do you have US Passport? <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input passenger_passport" type="radio" value="yes" name="passenger_have_passport_${i}" id="passenger_pass_yes_${i}" required>
                            <label class="form-check-label" for="passenger_pass_yes_${i}">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input passenger_passport" type="radio" value="no" name="passenger_have_passport_${i}" id="passenger_pass_no_${i}" required>
                            <label class="form-check-label" for="passenger_pass_no_${i}">No</label>
                            <div class="invalid-feedback">
                                Please select one of them.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Is this your first visit to Pakistan? <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input passenger_first_visit" type="radio" name="passenger_first_visit_${i}"
                                value="yes" id="passenger_visit_yes_${i}" checked required>
                            <label class="form-check-label" for="passenger_visit_yes_${i}">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input class="form-check-input passenger_first_visit" type="radio" name="passenger_first_visit_${i}"
                                value="no" id="passenger_visit_no_${i}" required>
                            <label class="form-check-label" for="passenger_visit_no_${i}">No</label>
                            <div class="invalid-feedback">
                                Please select one of them.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2" style="display: none;">
                        <label> Date of Previous Visit</label>
                        <input class="form-control previous-visit" type="date" id="previous-visit"
                            name="passenger_pre_visit_date[]" max="{{ date('Y-m-d') }}">
                        <div class="invalid-feedback">
                            Please provide previous visit date.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2" style="display: none;">
                        <label> Port of Entry</label>
                        <input class="form-control entry-port" type="text" id="entry-port" name="passenger_port_of_entry[]"
                            placeholder="Enter port of Entery" onkeydown="return /[a-z ]/i.test(event.key)">
                        <div class="invalid-feedback">
                            Please provide port of entry.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Profesion <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_profession[]"
                            placeholder="What's your profession" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide profession.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label for="gurdwara" class="form-label">Select Gurdwara <span class="text-danger">*</span></label>
                        <select class="form-control selectjs" name="passenger_gurdwara_id[]" required>`;
                    @foreach(@$gurdwaras as $key => $val)
                    html += `<option value="{{ @$val['id'] }}">{{ @$val['gurdwara_name'] }}</option>`;
                    @endforeach
                    html += `</select>
                        <div class="invalid-feedback">
                            Please provide applicant name.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Name of Nearest Gurdwara <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_gurdwara_name[]"
                            placeholder="Enter name of your nearest gurdwara" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide nearest gurdwara name.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Address <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_address[]"
                            placeholder="Enter Address" required>
                        <div class="invalid-feedback">
                            Please provide address.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>City <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_city[]"
                            placeholder="Enter city" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide city.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>State <span class="text-danger">*</span></label>
                        <select class="form-control selectjs" name="passenger_state[]" required>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                            <option value="DC">District of Columbia</option>
                            <option value="AS">American Samoa</option>
                            <option value="GU">Guam</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="UM">United States Minor Outlying Islands</option>
                            <option value="VI">Virgin Islands, U.S.</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select state.
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label>Zip <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_zip[]"
                            placeholder="Enter zip" required>
                        <div class="invalid-feedback">
                            Please provide valid zip.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Name of Secretary Gurdwara <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_secetary_name[]"
                            placeholder="Enter name of secetary gurdwara" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide name of secretary.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Telephone <span class="text-danger">*</span></label>
                        <input class="form-control phone_us" maxlength="12" name="passenger_secretary_phone[]"
                            placeholder="Enter phone number of secretary" required>
                        <div class="invalid-feedback">
                            Please provide phone number of secretary.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Reference Contact Person Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="passenger_reference_name[]"
                            placeholder="Enter name of reference contact person" onkeydown="return /[a-z ]/i.test(event.key)" required>
                        <div class="invalid-feedback">
                            Please provide name of reference contact person.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label>Reference Contact Person Telephone <span class="text-danger">*</span></label>
                        <input class="form-control phone_us" maxlength="12" name="passenger_reference_phone[]"
                            placeholder="Enter phone number of secretary" required>
                        <div class="invalid-feedback">
                            Please provide telephone of reference contact person.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 mb-2">
                        <label for="photoFile" class="form-label">Upload Photo <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="passenger_photo[]" id="photoFile" required>
                        <div class="invalid-feedback">
                            Please upload valid photo.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label for="formFile" class="form-label">Upload Passport <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="passenger_us_passport[]" id="formFile" required>
                        <div class="invalid-feedback">
                            Please upload valid passport.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label for="formFile" class="form-label">Upload Green Card</label>
                        <input class="form-control green-card" type="file" name="passenger_green_card[]">
                        <div class="invalid-feedback">
                            Please upload valid green card.
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <label for="formFile" class="form-label">Upload ID/Driving License <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="passenger_driving_license[]" id="formFile" required>
                        <div class="invalid-feedback">
                            Please upload valid ID or Driving License
                        </div>
                    </div>`;
                    $("#family_details").append(html);
                    $(".selectjs").select2();
                    $('.phone_us').on('input', function() {
                        let text=$(this).val()
                        text=text.replace(/\D/g,'') 
                        if(text.length>3) text=text.replace(/.{3}/,'$&-')
                        if(text.length>7) text=text.replace(/.{7}/,'$&-')
                        $(this).val(text);
                    });
                }
            });
            $(document).on('click', ".ticket_type", function() {
                if ($(this).val() == "round_way") {
                    $(".round_way_description").css("display", "block");
                    $(".one_way_description").css("display", "none");
                    $("#ticket_type").val("round_way");
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
                } else {
                    $(".one_way_description").css("display", "block");
                    $(".round_way_description").css("display", "none");
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
