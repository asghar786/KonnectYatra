@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gallery</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/gallery') }}">Gallery</a></li>
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
                                <label class="form_label_color">Caption</label>
                                <input type="text" class="form-control require" value="{{@$gallery->caption}}" name="caption" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Image</label>
                                <input type="file" class="form-control require" name="image" @if(empty(@$gallery->image)) required="" @endif />
                            </div>
                            @if(!empty(@$gallery->image))
                            <div class="form-group col-md-6">
                                <img src="{{ asset('gallery/'.@$gallery->image) }}" height="300" width="300">
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