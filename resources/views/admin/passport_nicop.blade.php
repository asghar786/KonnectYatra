@extends('admin.layouts.app')
@section('content')
    <!--Main container start -->
    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <h4 class="breadcrumb-title">Create Passport & NICOP</h4>
            </div>
            <div class="container">
                <div class="container ddcform">
                    <div class="row ml-3 mt-3">
                        <form id="regForm" method="POST" action="{{ route('passport_nicop') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Circles which indicates the steps of the form: -->
                            <div class="d-none d-md-block" style="text-align:center; margin-top:-100px; ">
                                <span class="step">1</span>
                                <span>
                                    <img src="{{ asset('assets/images2/arrow.png') }}" width="50px" height="10px;" />
                                </span>
                                <span class="step">2</span>
                                <span>
                                    <img src="{{ asset('assets/images2/arrow.png') }}" width="50px" height="10px;" />
                                </span>
                                <span class="step">3</span>
                                <a href="{{ route('passportinfo') }}"><button type="button" class="btn btn-sm"
                                        style="float: right;">View Details</button></a>
                            </div>
                            <!-- One "tab" for each step in the form: -->
                            <div class="tab">
                                <div class="formheading mt-3">
                                    <h4 class="form-title">Personal Information</h4>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <p> <span class="formspan">First Name</span>
                                            <input name="fname" id="fname" placeholder="first name..."
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <p> <span class="formspan">Middle Name</span>
                                            <input name="mname" placeholder="Middle name..."
                                                oninput="this.className = ''">
                                        </p>
                                    </div>
                                    <div class="col-6 ">
                                        <p> <span class="formspan">Last Name</span>
                                            <input name="lname" id="lname" placeholder="last name..."
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error2"></span>
                                        </p>
                                    </div>
                                    <div class="col-3">
                                        <p> <span class="formspan">Gender</span>
                                            <select id="cars" name="gender" class="form-control">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </p>
                                    </div>
                                    <div class="col-3">
                                        <p> <span class="formspan">Date of Birth</span>
                                            <input type="text" class="datepicker" name="dob" id="dob" 
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error8"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 ">
                                        <p> <span class="formspan">Address</span>
                                            <input name="address" id="address1" placeholder="address..."
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error4"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 ">
                                        <p> <span class="formspan">Apt #</span>
                                            <input name="apt" id="address2" placeholder="address..."
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error5"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 ">
                                        <p> <span class="formspan">City</span>
                                            <input name="city" id="city" placeholder="City..."
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error3"></span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p> <span class="formspan">State</span>
                                            <input type="text" name="state" id="state" placeholder="state"
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error9"></span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p> <span class="formspan">ZipCode</span>
                                            <input type="number" id="zipcode" name="zipcode" placeholder="XXXXXXX"
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error7"></span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p> <span class="formspan">Phone number</span>
                                            <input type="number" id="phonenumber" name="phonenumber"
                                                placeholder="phone number..." oninput="this.className = ''"> <span
                                                class="text-danger" id="error6"></span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p> <span class="formspan">E-mail</span>
                                            <input name="email" type="email" placeholder="E-mail..."
                                                oninput="this.className = ''">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="formheading mt-3">
                                    <h4 class="form-title">Passport Information</h4>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3 ">
                                        <p> <span class="formspan">Notes</span>
                                            <input name="notes" id="notes" placeholder="notes"
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error10"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <p> <span class="formspan">Passport Number</span>
                                            <input type="number" id="dln" name="passportnumber"
                                                placeholder="XXXXXXXXXXX" oninput="this.className = ''"> <span
                                                class="text-danger" id="error11"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 ">
                                        <p> <span class="formspan">Date of Issue</span>
                                            <input type="text" class="datepicker" name="pdoi" id="pdoi"
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error12"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 ">
                                        <p> <span class="formspan">Date of Expiry</span>
                                            <input type="text" class="datepicker" name="pdoe" id="pdoe"
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error121"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="formheading mt-3">
                                    <h4 class="form-title">NICOP Information</h4>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <p> <span class="formspan">NIC Number</span>
                                            <input name="nicpnumber" id="nicnum" type="text" placeholder="XXXXXXX"
                                                oninput="this.className = ''" required> <span class="text-danger"
                                                id="error14"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <p> <span class="formspan">NICOP Number</span>
                                            <input name="nicopnumber" id="nicopnum" type="text"
                                                placeholder="XXXXXXX" oninput="this.className = ''" required> <span
                                                class="text-danger" id="error15"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <p> <span class="formspan">Date of Issue</span>
                                            <input name="issuedate" id="dissuedate" type="text" class="datepicker" 
                                                oninput="this.className = ''"> <span class="text-danger"
                                                id="error13"></span>
                                        </p>
                                    </div>
                                    <div class="col-6 mt-3 ">
                                        <p> <span class="formspan">Date of Expiry</span>
                                            <input id="" name="expiredate" type="text" class="datepicker" 
                                                oninput="this.className = ''">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div style="overflow:auto;">
                                <div style="float:right;">
                                    <button type="button" class="btn btn-sm" id="prevBtn"
                                        onclick="nextPrev(-1)">Previous</button>
                                    <button type="button" class="btn btn-sm" id="nextBtn"
                                        onclick="nextPrev(1)">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="ttr-overlay"></div>
                    <script src="{{ asset('adminassets/js/passport.js') }}"></script>
                @endsection
