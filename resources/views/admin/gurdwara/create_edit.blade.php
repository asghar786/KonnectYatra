@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gurdwara</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/admin_gurdwara') }}">Gurdwara</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-3 mb-5 justify-content-center">
                <div class="col-lg-12">
                    <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Name of Gurdwara</label>
                                <input type="text" class="form-control require" placeholder="Enter Gurdwara Name" value="{{@$gurdwara->gurdwara_name}}" name="gurdwara_name"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Color</label>
                                <select class="form-control" name="color" id="color">
                                    <option value=""></option>
                                    <option value="Green" @if(@$gurdwara->color == "Green") selected @endif>Green</option>
                                    <option value="Yellow" @if(@$gurdwara->color == "Yellow") selected @endif>Yellow</option>
                                    <option value="Red" @if(@$gurdwara->color == "Red") selected @endif>Red</option>
                                </select>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Address</label>
                                <input type="text" class="form-control require" placeholder="Enter Street Address" value="{{@$gurdwara->address}}" name="address"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">City</label>
                                <input type="text" class="form-control require" placeholder="Enter City" value="{{@$gurdwara->city}}" name="city"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">State</label>
                                <input type="text" class="form-control require" placeholder="Enter State" value="{{@$gurdwara->state}}" name="state"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Zip</label>
                                <input type="text" class="form-control require" placeholder="Enter Zip" value="{{@$gurdwara->zip}}" name="zip"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Country</label>
                                <input type="text" class="form-control require" placeholder="Enter Country" value="{{@$gurdwara->country}}" name="country"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Email Address</label>
                                <input type="email" class="form-control require" placeholder="Enter Email Address" value="{{@$gurdwara->email_address}}" name="email_address"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Sangat</label><br>
                                <input type="radio" value="Large" name="sangat" id="large" checked />
                                <label for="large">Large</label>
                                <input type="radio" value="Medium" name="sangat" id="medium" style="margin-left: 10px;" />
                                <label for="medium">Medium</label>
                                <input type="radio" value="Small" name="sangat" id="small" style="margin-left: 10px;" />
                                <label for="small">Small</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Name of Pardan</label>
                                <input type="text" class="form-control require" placeholder="Enter Pardan Name" value="{{@$gurdwara->pardan_name}}" name="pardan_name"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Phone Number</label>
                                <input type="text" class="form-control require" placeholder="Enter Pardan Phone Number" value="{{@$gurdwara->phone_no}}" name="phone_no"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Name of Secretary</label>
                                <input type="text" class="form-control require" placeholder="Enter Secretary Name" value="{{@$gurdwara->secretary_name}}" name="secretary_name"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Phone Number</label>
                                <input type="text" class="form-control require" placeholder="Enter Secretary Phone Number" value="{{@$gurdwara->secretary_phone_no}}" name="secretary_phone_no"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Name of Head Garanti</label>
                                <input type="text" class="form-control require" placeholder="Enter Head Garanti Name" value="{{@$gurdwara->head_garanti_name}}" name="head_garanti_name"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Phone Number</label>
                                <input type="text" class="form-control require" placeholder="Enter Head Garanti Phone Number" value="{{@$gurdwara->head_garanti_phone_no}}" name="head_garanti_phone_no"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Name of Chairman</label>
                                <input type="text" class="form-control require" placeholder="Enter Chairman Name" value="{{@$gurdwara->chairman_name}}" name="chairman_name"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Phone Number</label>
                                <input type="text" class="form-control require" placeholder="Enter Chairman Phone Number" value="{{@$gurdwara->chairman_phone_no}}" name="chairman_phone_no"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Name of Manager</label>
                                <input type="text" class="form-control require" placeholder="Enter Manager Name" value="{{@$gurdwara->manager_name}}" name="manager_name"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Phone Number</label>
                                <input type="text" class="form-control require" placeholder="Enter Manager Phone Number" value="{{@$gurdwara->manager_phone_no}}" name="manager_phone_no"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form_label_color">Upload Photo</label>
                                <input type="file" name="gurdwara_image" class="dropify" id="dropify-img" data-height="100" data-width="100">
                            </div>
                            @if(!empty(@$gurdwara->gurdwara_image))
                            <div class="form-group col-md-6">
                                <img src="{{asset('gurdwara_images')}}/{{@$gurdwara->gurdwara_image}}" height="300" width="300">
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: right;">{{ @$btn_text }}</button>
                        <div class="response"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        // Initialize Dropify
        $('.dropify').dropify();
        // Get the original file name on file upload
        $('.dropify').on('change', function () {
            var input = $(this);
            var file_name = input[0].files[0].name;
            // $('#selected-image').val(file_name);
            // alert('Original file name: ' + file_name);
        });
    });
</script>
@endsection