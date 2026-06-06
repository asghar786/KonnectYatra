@extends('admin.layouts.app')
@section('content')
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">

			<div class=" search row db-breadcrumb" >
                    <h4 class="breadcrumb-title">Passport & NICOP Information</h4>
			</div>
			<div class="container-fluid student-information" >
            @foreach($passports as $passport)
                <form action="{id}" method="POST">
                @endforeach
                    @csrf
                    <div class="row mt-3 p-4">
                        <div class="col-12">
                        <h4><i class="fa fa-user"></i> Client Information</h4>
                        <hr>
                        </div>
                        @foreach($passports as $passport)
                        <input type="hidden" class="form-control hidden" name="id"  value="{{$passport->id}}">
                        <div class="col-6 mt-2">
                        <label >First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" value="{{$passport->firstname}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="mname" value="{{$passport->middlename}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >Last name</label>
                        <input type="text" class="form-control" name="lname" id="lname" value="{{$passport->lastname}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >City</label>
                        <input type="text" class="form-control" name="city" id="city" value="{{$passport->city}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >Address</label>
                        <input type="text" class="form-control" name="address" id="address1" value="{{$passport->address}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >Apt</label>
                        <input type="text" class="form-control" name="apt" id="address2" value="{{$passport->apt}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{$passport->email}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >Phone Number</label>
                        <input type="number" class="form-control" name="phonenumber" id="phonenumber" value="{{$passport->phonenumber}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >Zip Code</label>
                        <input type="number" class="form-control" name="zipcode" id="zipcode" value="{{$passport->zipcode}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >Date of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob" value="{{$passport->dob}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >State</label>
                        <input type="text" class="form-control" name="state" id="state" value="{{$passport->state}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >Gender</label>
                        <input type="text" class="form-control" name="gender" id="gender" value="{{$passport->gender}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >Notes</label>
                        <input type="text" class="form-control" name="notes" id="notes" value="{{$passport->notes}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >Passport Number</label>
                        <input type="text" class="form-control" name="passportnumber" id="dln" value="{{$passport->passportnumber}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >Passport Issue</label>
                        <input type="date" class="form-control" name="pdoi" id="class" value="{{$passport->pdoi}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >Passport Expire</label>
                        <input type="text" class="form-control" name="pdoe" id="check" value="{{$passport->pdoe}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >NICOP Issue</label>
                        <input type="date" class="form-control" name="issuedate" id="issuedate" value="{{$passport->issuedate}}">
                        </div>
                        <div class="col-6 mt-2">
                        <label >NICOP Expire</label>
                        <input type="date" class="form-control" name="expiredate" id="ccd" value="{{$passport->expiredate}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >CNIC Number</label>
                        <input type="text" class="form-control" name="nicpnumber" id="sd" value="{{$passport->nicpnumber}}" >
                        </div>
                        <div class="col-6 mt-2">
                        <label >NICOP Number</label>
                        <input type="text" class="form-control" name="nicopnumber" id="sd" value="{{$passport->nicopnumber}}"  >
                        </div>
                        @endforeach
                        <div class="col-12">
                            <button type="submit" id="submit" class="float-right btn btn-sm mt-2 mb-2">Update</button>
                        </div>
                    </div>
                </form>
            </div>
	<div class="ttr-overlay"></div>
@endsection
