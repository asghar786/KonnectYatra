@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Bus</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/bus') }}">Bus</a></li>
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
                                <label class="form_label_color">Bus Number</label>
                                <input type="text" class="form-control require" value="{{@$bus->bus_number}}" name="bus_number" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Driver Name</label>
                                <input type="text" class="form-control require" value="{{@$bus->driver_name}}" name="driver_name" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Driver Phone Number</label>
                                <input type="text" class="form-control require" value="{{@$bus->driver_phone}}" name="driver_phone" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">City From</label>
                                <input type="text" class="form-control require" value="{{@$bus->from}}" name="from" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">City To</label>
                                <input type="text" class="form-control require" value="{{@$bus->to}}" name="to" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Capacity</label>
                                <input type="number" class="form-control require" value="{{@$bus->capacity}}" name="capacity" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form_label_color">Upload File</label>
                                <input type="file" name="file" class="dropify" id="dropify-img" data-height="100" data-width="100">
                            </div>
                            @if(!empty(@$bus->file))
                            <div class="form-group col-md-6">
                                <img src="{{ asset("bus/".$bus->file) }}" style="width: 300px; height: 200px;">
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