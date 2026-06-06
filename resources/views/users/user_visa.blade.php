@extends('userslayouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Apply For Visa</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Yatri Can Apply For Visa </li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{session('status')}}
            </div>

            @elseif(session('failed'))
            <div class="alert alert-danger" role="alert">
            {{session('failed')}}
            </div>
            @endif
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Apply Visa <i class="fa fa-plus"></i>
              </button>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-3 mb-5">
                        <div class="collapse" id="collapseExample">
                            <form id="msform" name="visaform" method="POST" action="{{route('user_visa')}}" enctype="multipart/form-data">
                                @csrf
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active">Visa Details</li>
                                    <li>Applicant's Details</li>
                                    <li>Passport Detail's</li>
                                    <li>General Information</li>
                                    <li>Family Detail's</li>
                                    <li>Apply Successfuly</li>
                                </ul>
                                <fieldset id="welcomeform1">
                                    @foreach($users as $user)
                                    <input type="hidden" value="{{$user->id}}" name="user_id">
                                    @endforeach
                                    @foreach($childs as $child)
                                    <input type="hidden" value="{{$child->id}}" name="child_id">
                                    @endforeach
                                    <h2 class="fs-title">Visa Details</h2>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label>1:<u><b>Type of visa applied for:</b></u></label><br>
                                            <span class="text-danger" id="visatypeError"></span>
                                            <div class="visa_type">Diplomatic <input type="checkbox" value="diplomatic" name="visa_type"></div>
                                            <div class="visa_type">Official <input type="checkbox" value="official" name="visa_type"></div>
                                            <div class="visa_type">Milatry <input type="checkbox" value="milatry" name="visa_type"></div>
                                            <div class="visa_type">Business <input type="checkbox" value="business" name="visa_type"></div>
                                            <div class="visa_type">Tourist <input type="checkbox" value="tourist" name="visa_type"></div>
                                            <div class="visa_type">Family <input type="checkbox" value="family" name="visa_type"></div>
                                            <div class="visa_type">Transit <input type="checkbox" value="transit" name="visa_type"></div>
                                            <div class="visa_type">Journalist <input type="checkbox" value="journalist" name="visa_type"></div>
                                            <div class="visa_type">Others <input type="checkbox" value="others" name="visa_type"></div><br>
                                            {{-- <div class="visa_type">Specify <input type="text" name="visa_type"></div> --}}

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group tab">
                                            <label>2:<u><b>Purpose of Visit:</b></u></label><br>
                                            <span class="text-danger" id="visitpurposeError"></span>
                                            <input type="text" name="visit_purpose" id="vp" style="width: 80%;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label>3:<u><b>Duration of Stay:</b></u></label><br>
                                            <span class="text-danger" id="durationError"></span>
                                            <input type="text" name="duration_stay" id="dos" style="width: 80%;">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label>4:<u><b>Visa Required for:</b></u></label><br>
                                            <span class="text-danger" id="visarequireError"></span>
                                            <div class="visa_type">Less than 01 Month <input type="checkbox" value="Less than 01 Month" name="visa_require"></div>
                                            <div class="visa_type">06 Months <input type="checkbox" value="06 Months" name="visa_require"></div>
                                            <div class="visa_type">01 Year <input type="checkbox" value="01 Year" name="visa_require"></div>
                                            <div class="visa_type">02 Years <input type="checkbox" value="02 Years" name="visa_require"></div>
                                            <div class="visa_type">05 Years <input type="checkbox" value="05 Years" name="visa_require"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label>5:<u><b>Type of Visa:</b></u></label><br>
                                            <span class="text-danger" id="visaentryError"></span>
                                            <div class="visa_type">Single Entry <input type="checkbox" value="Single Entry" name="visa_entry"></div>
                                            <div class="visa_type">Double Entry <input type="checkbox" value="Double Entry" name="visa_entry"></div>
                                            <div class="visa_type">Multiple Entry <input type="checkbox" value="Multiple Entry" name="visa_entry"></div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 form-group">
                                            <label>6:<u><b>Port of Entry:</b></u></label><br>
                                            <span class="text-danger" id="portentryError"></span>
                                            <font style="font-weight: bold;">i.</font> <input type="text" name="entry_port" id="poe">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 form-group">
                                            <label>7:<u><b>Port of Departure:</b></u></label><br>
                                            <span class="text-danger" id="portdepartureError"></span>
                                            <font style="font-weight: bold;">ii.</font> <input type="text" name="departure_port" id="pod">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-sm-3 form-group ">
                                            <label>8:<u><b>Place to be Visited in Pakistan:</b></u></label><br>
                                            <div class="row d-flex align-items-center justify-content-center">
                                                <div class="col-3-lg">
                                                <span class="text-danger" id="p1Error"></span>
                                                <font class="visa_type" style="font-weight: bold;">a.</font> <input type="text" id="p1" name="visit_place1">
                                                </div>
                                                <div class="col-3-lg">
                                                <span class="text-danger" id="p2Error"></span>
                                                <font class="visa_type"style="font-weight: bold;">b.</font> <input type="text"  id="p2"  name="visit_place2">
                                                </div>
                                                <div class="col-3-lg">
                                                <span class="text-danger"  id="p3Error"></span>
                                                <font class="visa_type"style="font-weight: bold;">c.</font> <input type="text"  id="p3" name="visit_place3">
                                                </div>
                                                <div class="col-3-lg">
                                                <span class="text-danger"  id="p4Error"></span>
                                                <font class="visa_type"style="font-weight: bold;">d.</font> <input type="text"  id="p4" name="visit_place4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <a href="#welcomeform2"><input type="button" name="answer" type="button" name="next" value="Next" class="next action-button"onclick="showform2()" /></a>
                                        </div>
                                    </div>
                                        {{-- <input type="button" name="next" class="next action-button" value="Next" style="margin-left: auto; margin-right:auto; display:block;"/> --}}
                                </fieldset><br>
                                <fieldset id="welcomeform2" style="display: none;">
                                    <h2 class="fs-title">Applicant's Details</h2>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-4 col-sm-12">
                                            <label>1:<u><b>Name as in Passport:</b></u></label><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <span class="text-danger" id="pname1Error"></span>
                                                    <font class="visa_type" style="font-weight: bold;">First </font> <input type="text" id="pname1" name="p_first_name">
                                                </div>
                                                <div class="col-lg-4">
                                                    <font class="visa_type"style="font-weight: bold;">Middle </font> <input type="text" name="p_middle_name">
                                                </div>
                                                <div class="col-lg-4">
                                                    <span class="text-danger" id="pname3Error"></span>
                                                    <font class="visa_type"style="font-weight: bold;">Last </font> <input type="text"   id="pname3" name="p_last_name">
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-4 col-sm-12">
                                            <label>2:<u><b>Date of Birth:</b></u></label><br>
                                            <span class="text-danger" id="date1Error"></span>
                                            <input type="date" name="applicant_dob" id="date1" style="width: 80%;">
                                        </div>
                                        <div class="col-lg-7 col-md-4 col-sm-12">
                                            <label>3:<u><b>Sex:</b></u></label><br>
                                            <span class="text-danger" id="sextype1Error"></span>
                                            <div class="visa_type">Male <input type="checkbox" value="Male" name="sex_type"></div>
                                            <div class="visa_type">Female <input type="checkbox" value="Female" name="sex_type"></div>
                                            <div class="visa_type">V.Blood Group: <input type="text" name="blood_group"></div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-4 col-sm-12">
                                            <label>4:<u><b>Place of Birth:</b></u></label><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                <span class="text-danger" id="app_cityError"></span>
                                                     <font class="visa_type" style="font-weight: bold;">City </font> <input type="text" id="app_city" name="applicant_city">
                                                </div>
                                                <div class="col-lg-4">
                                                <span class="text-danger" id="app_stateError"></span>
                                                    <font class="visa_type"style="font-weight: bold;">State </font> <input type="text" id="app_state" name="applicant_state" >
                                                </div>
                                                <div class="col-lg-4">
                                                <span class="text-danger" id="app_countryError"></span>
                                                    <font class="visa_type"style="font-weight: bold;">Country </font> <input type="text" id="app_country" name="applicant_country">
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>5:<u><b>Martial Status:</b></u></label><br>
                                            <span class="text-danger" id="martial_statusError"></span>
                                            <div class="visa_type">Single <input type="checkbox"  value="single" name="martial_status"></div>
                                            <div class="visa_type">Married <input type="checkbox" value="married" name="martial_status"></div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>6:<u><b>Religion:</b></u></label><br>
                                             <span class="text-danger" id="religionError"></span>
                                            <input type="text" name="applicant_religion" id="religion">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>7:<u><b>Identification Mark:</b></u></label><br>
                                            <input type="text" name="identification_mark" style="width: 80%">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>8:<u><b>Native Language:</b></u></label><br>
                                            <span class="text-danger" id="nativeError"></span>
                                            <input type="text" name="native_language" id="native" style="width: 80%">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-4 col-sm-12">
                                            <label>9:<u><b>Nationality:</b></u></label><br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <span class="text-danger" id="p_nError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">Present </font> <input type="text" id="p_nationality" name="pres_nationality">
                                                </div>
                                                <div class="col-lg-4">
                                                    <span class="text-danger" id="pre_nError"></span>
                                                    <font class="visa_type"style="font-weight: bold;">Previous </font> <input type="text" id="pre_nationality" name="prev_nationality">
                                                </div>
                                                <div class="col-lg-4">
                                                    <span class="text-danger" id="dual_nError"></span>
                                                    <font class="visa_type"style="font-weight: bold;">Dual </font> <input type="text"   id="duall_nationality" name="dual_nationality">
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <a href="#welcomeform1"><input type="button" name="previous" class="previous action-button-previous" value="Previous"/></a>
                                            <a href="#welcomeform3"><input type="button" name="answer" type="button" name="next" value="Next" class="next action-button"onclick="showform3()" /></a>
                                        </div>
                                    </div>
                                </fieldset><br>
                                <fieldset id="welcomeform3" style="display: none;">
                                    <h2 class="fs-title">Passport Detial's</h2>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>1:<u><b>Type of Passport:</b></u></label><br>
                                            <span class="text-danger" id="passtypeError"></span>
                                            <font class="visa_type" style="font-weight: bold;">Diplomatic </font> <input type="checkbox" value="diplomatic" name="passport_type">
                                            <font class="visa_type"style="font-weight: bold;">Official / Service </font> <input type="checkbox" value="official" name="passport_type">
                                            <font class="visa_type"style="font-weight: bold;">Ordinary </font> <input type="checkbox" value="ordinary" name="passport_type">
                                            <font class="visa_type"style="font-weight: bold;">UN Travel Document  </font> <input type="checkbox" value="un travel document" name="passport_type">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>2:<u><b>Issuing Authority:</b></u></label><br>
                                            <span class="text-danger" id="authorityError"></span>
                                            <input type="text" name="issuing_authority" id="iss_auth" style="width: 80%">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>3:<u><b>Passport Number:</b></u></label><br>
                                            <span class="text-danger" id="passportError"></span>
                                            <input type="text" name="passport_number" id="pass_number" style="width: 80%;">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>4:<u><b>Place of Issue:</b></u></label><br>
                                            <span class="text-danger" id="placeissueError"></span>
                                            <input type="text" name="place_issue" id="pla_issu" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>5:<u><b>Date of Issue:</b></u></label><br>
                                            <span class="text-danger" id="doiError"></span>
                                            <input type="date" name="doi" id="doi_issue" style="width: 80%;">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>6:<u><b>Date of Expiry:</b></u></label><br>
                                            <span class="text-danger" id="doeError"></span>
                                            <input type="date" name="doe" id="doe_issue" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <a href="#welcomeform2"><input type="button" name="previous" class="previous action-button-previous" value="Previous"/></a>
                                            <a href="#welcomeform4"><input type="button" name="answer" type="button" name="next" value="Next" class="next action-button"onclick="showform4()" /></a>
                                        </div>
                                    </div>
                                </fieldset><br>
                                <fieldset id="welcomeform4" style="display: none;">
                                    <h2 class="fs-title">General Information</h2>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label>1:<u><b>Addres & Email:</b></u></label><br>
                                            <font class="visa_type" style="font-weight: bold;">Abroad/Country</font><input type="text" name="abroad_address" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label><u><b>Telephone:</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Home </font> <input type="text" name="abroad_phone">
                                            <font class="visa_type"style="font-weight: bold;">work</font> <input type="text" name="abroad_Work">
                                            <font class="visa_type"style="font-weight: bold;">cell </font> <input type="text" name="abroad_cell">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label>2:<u><b>Addres & Email:</b></u></label><br>
                                            <font class="visa_type" style="font-weight: bold;">In Pakistan</font><input type="text" name="pak_address" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label><u><b>Telephone:</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Home </font> <input type="text" name="pak_home">
                                            <font class="visa_type"style="font-weight: bold;">work</font> <input type="text" name="pak_work">
                                            <font class="visa_type"style="font-weight: bold;">cell </font> <input type="text" name="pak_cell">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label  for="sponserdcheck">3:<u><b>Is your visa sponserd?:</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="sponserd" id="sponserdcheck" onclick="Sponserd(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="sponserd">
                                            <div id="check" style="display: none">
                                                <label>If yes, give details</label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-lg-4">
                                                        <label><b>Name of Sponser</b></label><br>
                                                        <font class="visa_type" style="font-weight: bold;">i</font><input type="text" name="sponser_name" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><b>Address</b></label><br>
                                                        <font class="visa_type" style="font-weight: bold;">ii</font><input type="text" name="sponser_address" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><b>Contact Number</b></label><br>
                                                        <font class="visa_type" style="font-weight: bold;">iii</font><input type="text" name="sponser_contact" style="width: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label><u>4:<b>Detaill of profession:</b></u></label>
                                            <pre>a.  Profession (Please specify Rank / Service, in case of Armed Forces / Uniform Personnel)</pre>
                                            <pre><u><b>Note:</b></u> In case of military services, Please fill in the attached Performa.</pre>
                                            <pre>b. Employer’s / Sponsor’s details ( in Pakistan / Abroad (if Applicable) )</pre>
                                            <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                <div class="col-lg-3">
                                                    <label><b>Name</b></label><br>
                                                    <font class="visa_type" style="font-weight: bold;">i</font><input type="text" name="profession_name" style="width: 80%;">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label><b>Address</b></label><br>
                                                    <font class="visa_type" style="font-weight: bold;">ii</font><input type="text" name="profession_address" style="width: 80%;">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label><b>Telephone No.</b></label><br>
                                                    <font class="visa_type" style="font-weight: bold;">iii</font><input type="text" name="profession_contact" style="width: 80%;">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label><b>Email</b></label><br>
                                                    <font class="visa_type" style="font-weight: bold;">iv</font><input type="text" name="profession_email" style="width: 80%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label><u>5:<b>Detaill of Job Held In Past:</b></u></label>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b>Designation</b></label><br>
                                                    <span class="text-danger" id="desigError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">i</font><input type="text" id="job_desig" name="designation_name" style="width: 80%;">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b>Departments</b></label><br>
                                                    <span class="text-danger" id="departError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">ii</font><input type="text" id="job_depart" name="designation_department" style="width: 80%;">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b>Duration(From - To)</b></label><br>
                                                    <span class="text-danger" id="duraError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">iii</font><input type="text" id="job_dura" name="designation_duration" style="width: 80%;">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b>Duties</b></label><br>
                                                    <span class="text-danger" id="dutiesError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">iv</font><input type="text" id="job_duties" name="designation_duties" style="width: 80%;">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b>Address</b></label><br>
                                                    <span class="text-danger" id="addresError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">v</font><input type="text" id="job_add" name="designation_address" style="width: 80%;">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label><b>Phone</b></label><br>
                                                    <span class="text-danger" id="phonError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">vi</font><input type="text" id="job_phone" name="designation_phone" style="width: 80%;">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label  for="sponserdthirdcheck">6:<u><b>Are you applying visa from a third country?:</b></u></label>
                                                    <span class="text-danger" id="appvisaError"></span>
                                                    <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="apply_FTC" id="sponserdthirdcheck" onclick="Sponserdthird(this)" >
                                                    <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="apply_FTC">
                                                    <div id="checkthird" style="display: none">
                                                        <label>If yes, give details</label><br>
                                                        <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                            <div class="col-lg-12">
                                                                <label for="img">Upload image copy of residence:</label><br>
                                                                <span class="text-danger" id="resid_imgError" ></span>
                                                                <input type="file" id="img" name="img_residence" accept="image/*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><br>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <a href="#welcomeform3"><input type="button" name="previous" class="previous action-button-previous" value="Previous"/></a>
                                            <a href="#welcomeform5"><input type="button" name="answer" type="button" name="next" value="Next" class="next action-button"onclick="showform5()" /></a>
                                        </div>
                                    </div>
                                </fieldset><br>
                                <fieldset id="welcomeform5" style="display: none;">
                                    <h2 class="fs-title">Family Detial's</h2>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>1:<u><b>Name of Mother:</b></u></label><br>
                                            <span class="text-danger" id="mnameError"></span>
                                            <input type="text" name="mother_name" id="mname" style="width: 80%;">
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>2:<u><b>Nationality of Mother:</b></u></label><br>
                                            <span class="text-danger" id="mnationError"></span>
                                           <input type="text" name="mother_nationality" id="mnation" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>3:<u><b>Name of Father:</b></u></label><br>
                                            <span class="text-danger" id="fnameError"></span>
                                            <input type="text" name="father_name" id="fname" style="width: 80%;">
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>4:<u><b>Nationality of Father:</b></u></label><br>
                                            <span class="text-danger" id="fnationError"></span>
                                           <input type="text" name="father_nationality" id="fnation" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <b class="text-danger">Spous Details:</b>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>5:<u><b>Name:</b></u></label><br>
                                            <span class="text-danger" id="spousnError"></span>
                                            <input type="text" name="spous_name" id="spousname" style="width: 80%;">
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>6:<u><b>Nationality:</b></u></label><br>
                                            <span class="text-danger" id="spousnationError"></span>
                                           <input type="text" name="spous_nationality" id="spousnatioon" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>7:<u><b>Date of Birth:</b></u></label><br>
                                            <span class="text-danger" id="spousdobError"></span>
                                            <input type="date" name="spous_dob" id="spousdob" style="width: 80%;">
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>8:<u><b>Place of Birth:</b></u></label><br>
                                            <span class="text-danger" id="spouspobError"></span>
                                           <input type="text" name="spous_pob" id="spouspob" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>9:<u><b>Profession:</b></u></label><br>
                                            <span class="text-danger" id="spousprofError"></span>
                                            <input type="text" name="spous_profession" id="spousproff" style="width: 80%;">
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label>10:<u><b>Spous Contact No:</b></u></label><br>
                                            <span class="text-danger" id="spousnumError"></span>
                                           <input type="text" name="spous_contact" id="spousnumber" style="width: 80%;">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label  for="sponserdaddcheck">11:<u><b>Do you have any children?:</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="children" id="sponserdaddcheck" onclick="Sponserdadd(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="children"><span class="text-danger" id="childError"></span>
                                            <div id="checkadd" style="display: none">
                                                <label>If yes, please provide details for each of your child. </label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-12">
                                                        <button type="button" class="btn-secondry  m-r5 add_button" id="addrow"><i class="fa fa-fw fa-plus-circle"></i>Add Child</button>
                                                    </div>
                                                    <div class="col-lg-12 mt-4 field_wrapper">
                                                        <table id="myTable" class="table order-list" style="width:100%;">
                                                            <tr>
                                                                <td>
                                                                    <label>Name</label>
                                                                    <input class="form-control" value="" type="text" name="child_name[]">
                                                                </td>
                                                                <td>
                                                                    <label>Date of Birth</label>
                                                                    <input class="form-control" value="" date="" type="date" name="child_dob[]">
                                                                </td>
                                                                <td>
                                                                    <label>Close</label><br>
                                                                    <a type="button" class="ibtnDel delete" href="javascript:void(0)"><i class="fa fa-close"></i></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label  for="sponserdtravelcheck">12:<u><b>Is Someone Traveling with you?:</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="travel_with" id="sponserdtravelcheck" onclick="Sponserdtravel(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="travel_with"><span class="text-danger" id="membertravelError"></span>
                                            <div id="checktravel" style="display: none">
                                                <label>If yes, Please list any of accompanying person / family member (including children) traveling with you to
                                                    Pakistan. </label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-12">
                                                        <button type="button" class="btn-secondry add-item2 m-r5 add_button2"><i class="fa fa-fw fa-plus-circle"></i>Add Member</button>
                                                    </div>
                                                    <div class="col-lg-12 mt-4 field_wrapper2">
                                                        <table id="myTable" class="table order-list"  style="width:100%;">
                                                            <tr class="list-item2">
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-lg-3 col-md-3">
                                                                            <label class="col-form-label">Name</label>
                                                                            <div>
                                                                                <input class="form-control" type="text" name="TM_name[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">
                                                                            <label class="col-form-label">Date of Birth</label>
                                                                            <div>
                                                                                <input class="form-control" type="date" name="TM_dob[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">
                                                                            <label class="col-form-label">Passport Number</label>
                                                                            <div>
                                                                                <input class="form-control" type="text" name="TM_passport[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2">
                                                                            <label class="col-form-label">Address</label>
                                                                            <div>
                                                                                <input class="form-control" type="text" name="TM_address[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1 col-md-1">
                                                                            <label class="col-form-label">Close</label>
                                                                            <div class="form-group">
                                                                                <a class="delete " href="#"><i class="fa fa-close"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label  for="sponserbankcheck">13:<u><b>Do you have any bank account in Pakistan?</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="bank_account" id="sponserbankcheck" onclick="Sponserdbank(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="bank_account"><span class="text-danger" id="accountError"></span>
                                            <div id="checkbank" style="display: none">
                                                <label>If yes, Please give details.</label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-lg-3">
                                                        <label><u><b>Bank Name:</b></u></label><br>
                                                        <input type="text" name="bank_name" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Branch Name:</b></u></label><br>
                                                        <input type="text" name="bank_branch" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>A/C Number:</b></u></label><br>
                                                        <input type="text" name="ac_number" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Address:</b></u></label><br>
                                                        <input type="text" name="bank_Address" style="width: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label  for="sponserhistorycheck">14:<u><b>Have you ever visited Pakistan during last five years?</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="visited_pakistan" id="sponserhistorycheck" onclick="Sponserdhistory(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="visited_pakistan"> <span class="text-danger" id="pakdurationError"></span>
                                            <div id="checkhistory" style="display: none">
                                                <label>If yes, Please provide details.</label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-12">
                                                        <button type="button" class="btn-secondry add-item3 m-r5 add_button3"><i class="fa fa-fw fa-plus-circle"></i>Add Visit</button>
                                                    </div>
                                                    <div class="col-lg-12 mt-4 field_wrapper3">
                                                        <table id="item-add3" style="width:100%;">
                                                            <tr class="list-item3">
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-lg-3 col-md-3">
                                                                            <label class="col-form-label">Date</label>
                                                                            <div>
                                                                                <input class="form-control" type="date" name="visit_date[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">
                                                                            <label class="col-form-label">Designation</label>
                                                                            <div>
                                                                                <input class="form-control" type="text"  name="visit_designation[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-3">
                                                                            <label class="col-form-label">Purpose</label>
                                                                            <div>
                                                                                <input class="form-control" type="text" name="visited_purpose[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2">
                                                                            <label class="col-form-label">Duration</label>
                                                                            <div>
                                                                                <input class="form-control" type="text" name="visit_duration[]">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1 col-md-1">
                                                                            <label class="col-form-label">Close</label>
                                                                            <div class="form-group">
                                                                                <a class="delete" href="#"><i class="fa fa-close"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label  for="sponserhistorycheck">15:<u><b>Have you ever been refused a visa for any country, including Pakistan?</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="refusal">
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="refusal"><span class="text-danger" id="refusalError"></span>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label  for="sponserrefusecheck">16:<u><b>Have you ever been refused entry on arrival to Pakistan?</b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="refuse_entry" id="sponserrefusecheck" onclick="Sponserdrefuse(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="refuse_entry"><span class="text-danger" id="arivalrefusalError"></span>
                                            <div id="checkrefuse" style="display: none">
                                                <label>If yes, Please provide details of refusal.</label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-lg-12">
                                                        <textarea rows="4" cols="50" name="refusal_message"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label  for="sponserdeportedcheck">17:<u><b>Have you ever been deported, removed or otherwise required to leave any country, including Pakistan? </b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="deported" id="sponserdeportedcheck" onclick="Sponserddeported(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="deported"><span class="text-danger" id="deportError"></span>
                                            <div id="checkdeported" style="display: none">
                                                <label>If yes, Please provide details.</label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-lg-3">
                                                        <label><u><b>Date</b></u></label><br>
                                                        <input type="date" name="deport_date" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Country</b></u></label><br>
                                                        <input type="text" name="deport_country" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Reason</b></u></label><br>
                                                        <input type="text" name="deport_reason" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Ref No.(pakistan)</b></u></label><br>
                                                        <input type="text" name="deport_ref_no" style="width: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label  for="sponsercriminalcheck">18:<u><b>Do you have any criminal convictions or charged in any country? </b></u></label>
                                            <font class="visa_type" style="font-weight: bold;">Yes </font> <input type="checkbox" value="yes" name="criminal_case" id="sponsercriminalcheck" onclick="Sponserdcriminal(this)" >
                                            <font class="visa_type"style="font-weight: bold;">No</font> <input type="checkbox" value="no" name="criminal_case"><span class="text-danger" id="crimeError"></span>
                                            <div id="checkcriminal" style="display: none">
                                                <label>If yes, Please provide details.</label><br>
                                                <div class="row" style="border: 1px solid black; padding:20px; border-radius:8px;">
                                                    <div class="col-lg-3">
                                                        <label><u><b>Date</b></u></label><br>
                                                        <input type="date" name="crime_date" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Country</b></u></label><br>
                                                        <input type="text" name="crime_country" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Offence</b></u></label><br>
                                                        <input type="text" name="crime_offence" style="width: 80%;">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label><u><b>Sentence</b></u></label><br>
                                                        <input type="text" name="crime_Sentence" style="width: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <a href="#welcomeform4"><input type="button" name="previous" class="previous action-button-previous" value="Previous"/></a>
                                            <a href="#welcomeform6"><input type="button" name="answer" type="button" name="next" value="Next" class="next action-button"onclick="showform6()" /></a>
                                        </div>
                                    </div>
                                </fieldset><br>
                                <fieldset id="welcomeform6" style="display: none;">
                                    <h2 class="fs-title">Apply Successfully</h2>
                                    <div class="row">
                                        <label><b><u>DECLARATION:</u></b></label>
                                        <p><b>I declare that the information given in this form is correct to the best of my knowledge
                                            and belief and if any of the particulars furnished above are found to be incorrect or
                                            withheld the visa is liable to be rejected / cancelled at any time</b></p>
                                            <div class="col-lg-6">
                                                <label><b><u>Dated:</u></b></label>
                                                <input type="date" name="apply_date" >
                                            </div>
                                            <div class="col-lg-6">
                                                <label><b><u>(Signature of Applicant)</u></b></label>
                                                <input type="text" name="signature">
                                                <b>Note: </b>Type Your name sytem will converte it into your signature
                                            </div>
                                    </div>
                                    {{-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> --}}
                                    <button type="submit" name="submit" id="apply" class="submit action-button"style="float: right;">Submit</button>
                                </fieldset><br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</main>
<div class="ttr-overlay"></div>
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><table class="table order-list"><tr><td><input class="form-control" type="text" name="child_name[]" value=""/></td><td><input class="form-control" type="date" name="child_dob[]" value=""/></td><td><a href="javascript:void(0);" class="delete"><i class="fa fa-close"></i></a></td></tr></table></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().remove();
    });

    //Once remove button is clicked
    // $(wrapper).on('click', '.remove_button', function(e){
    //     e.preventDefault();
    //     $(this).parent('div').remove(); //Remove field html
    //     x--; //Decrement field counter
    // });
});


$(document).ready(function(){
    var maxField2 = 5; //Input fields increment limitation
    var addButton2 = $('.add_button2'); //Add button selector
    var wrapper2 = $('.field_wrapper2'); //Input field wrapper
    var fieldHTML2 = '<div class="col-lg-12"><table  class="table order-list"  style="width:100%;"><tr class="list-item2"><td><div class="row"><div class="col-lg-3 col-md-3"><div><input class="form-control" type="text" name="TM_name[]"></div></div><div class="col-lg-3 col-md-3"><div><input class="form-control" type="date" name="TM_dob[]"></div></div><div class="col-lg-3 col-md-3"><div><input class="form-control" type="text" name="TM_passport[]"></div></div><div class="col-lg-2 col-md-2"><div><input class="form-control" type="text" name="TM_address[]"></div></div><div class="col-lg-1 col-md-1"><div class="form-group"><a class="delete" href="javascript:void(0)"><i class="fa fa-close"></i></a></div></div></div></td></tr></table></div>'; //New input field html
    var xb = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton2).click(function(){
        //Check maximum number of input fields
        if(xb < maxField2){
            xb++; //Increment field counter
            $(wrapper2).append(fieldHTML2); //Add field html
        }
    });

    $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().remove();
    });
});


$(document).ready(function(){
        var maxField3 = 5; //Input fields increment limitation
        var addButton3 = $('.add_button3'); //Add button selector
        var wrapper3 = $('.field_wrapper3'); //Input field wrapper
        var fieldHTML3 = '<div class="col-lg-12"> <table> <tr class="list-item3"> <td> <div class="row"> <div class="col-lg-3 col-md-3"> <div> <input class="form-control" type="date" name="visit_date[]"> </div> </div> <div class="col-lg-3 col-md-3">  <div> <input class="form-control" type="text" name="visit_designation[]"> </div> </div> <div class="col-lg-3 col-md-3">  <div> <input class="form-control" type="text" name="visited_purpose[]"> </div> </div> <div class="col-lg-2 col-md-2">  <div> <input class="form-control" type="text" name="visit_duration[]"> </div> </div> <div class="col-lg-1 col-md-1"><div class="form-group"> <a class="delete" href="javascript:void(0)"><i class="fa fa-close"></i></a> </div> </div> </div> </td> </tr> </table> </div>'; //New input field html
        var xc = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton3).click(function(){
            //Check maximum number of input fields
            if(xc < maxField3){
                xc++; //Increment field counter
                $(wrapper3).append(fieldHTML3); //Add field html
            }
        });

        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().remove();
    });
    });
</script>


{{--
<script>
    // Pricing add

    // function newMenuItem() {
    //     var newElem = $('tr.list-item').first().clone();
    //     newElem.find('input').val('');
    //     newElem.setAttribute("name", "child_name["+child_count+"]");
    //     newElem.appendTo('table#item-add');
    // }
    // if ($("table#item-add").is('*')) {
    //     $('.add-item').on('click', function(e) {
    //         e.preventDefault();
    //         newMenuItem();
    //     });
    //     $(document).on("click", "#item-add .delete", function(e) {
    //         e.preventDefault();
    //         $(this).parent().parent().parent().parent().remove();
    //     });
    // }
</script> --}}
@endsection
