@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">News</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/news') }}">News</a></li>
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
                                <input type="text" class="form-control require" value="{{@$news->title}}" name="title"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Reported By</label>
                                <input type="text" class="form-control require" value="{{@$news->reported_by}}" name="reported_by"/>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Description</label>
                                <textarea class="form-control require" name="description">{{@$news->description}}</textarea>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">File Type</label>
                                <select class="form-control" name="file_type">
                                    <option value="image" @if(@$news->file_type == "image") selected @endif>Image</option>
                                    <option value="video" @if(@$news->file_type == "video") selected @endif>Video</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form_label_color">Upload File</label>
                                <input type="file" name="file" class="dropify" id="dropify-img" data-height="100" data-width="100">
                            </div>
                            @if(!empty(@$news->file))
                            <div class="form-group col-md-6">
                                @if($news->file_type == "video")
                                <video style="width: 300px; height: 200px;" controls>
                                    <source src="{{ asset('news_and_events/'.@$news->file) }}" type="video/mp4">
                                    {{-- <source src="movie.ogg" type="video/ogg"> --}}
                                </video>
                                @else
                                <img src="{{ asset("news_and_events/".$news->file) }}" style="width: 300px; height: 200px;">
                                @endif
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