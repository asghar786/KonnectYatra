@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Hotels</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/hotels') }}">Hotels</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-12">
                    <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Hotel Name</label>
                                <input type="text" class="form-control require" value="{{@$hotels->name}}" name="name" required="" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Hotel Price</label>
                                <input type="number" class="form-control require" value="{{@$hotels->price}}" name="price" required="" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Phone Number</label>
                                <input type="number" class="form-control require" value="{{@$hotels->phone}}" name="phone" required="" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Address</label>
                                <input type="text" class="form-control require" value="{{@$hotels->address}}" name="address" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">State</label>
                                <input type="text" class="form-control require" value="{{@$hotels->state}}" name="state" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">City</label>
                                <input type="text" class="form-control require" value="{{@$hotels->city}}" name="city" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Zip Code</label>
                                <input type="text" class="form-control require" value="{{@$hotels->zip}}" name="zip" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Hotel Image</label>
                                <input type="file" class="form-control require" name="image" @if(empty(@$hotels->image)) required="" @endif />
                            </div>
                            @if(!empty(@$hotels->image))
                            <div class="form-group col-md-6">
                                <img src="{{ asset('hotels/'.@$hotels->image) }}" height="300" width="300">
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