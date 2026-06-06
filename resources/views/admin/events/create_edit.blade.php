@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Events</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/events') }}">Events</a></li>
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
                                <label class="form_label_color">Title</label>
                                <input type="text" class="form-control require" value="{{@$events->title}}" name="title" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Location</label>
                                <input type="text" class="form-control require" value="{{@$events->location}}" name="location" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Event Date</label>
                                <input type="date" class="form-control require" value="{{@$events->event_date}}" name="event_date" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Event Time</label>
                                <input type="text" class="form-control require" value="{{@$events->event_time}}" name="event_time" />
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Description</label>
                                <textarea class="form-control require" name="description">{{@$events->description}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form_label_color">Upload Photo</label>
                                <input type="file" name="image" class="dropify" id="dropify-img" data-height="100" data-width="100">
                            </div>
                            @if(!empty(@$events->image))
                            <div class="form-group col-md-6">
                                <img src="{{ asset('news_and_events/'.@$events->image) }}" height="300" width="300">
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