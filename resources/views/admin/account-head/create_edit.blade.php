@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Account Head</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/account-head') }}">Account Head</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-12">
                    <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Name of Account Head</label>
                                <input type="text" class="form-control require" value="{{@$account_head->name}}" name="name" required=""/>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Description</label>
                                <textarea class="form-control require" name="description" />{{@$account_head->description}}</textarea>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Account Head Type</label>
                                <select name="type" class="form-control">
                                    <option value="United States" @if(@$package->package_type == 'United States') selected @endif>United States</option>
                                    <option value="Pakistan" @if(@$package->package_type == 'Pakistan') selected @endif>Pakistan</option>
                                </select>
                            </div>
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