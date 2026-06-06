@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Profile</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Profile</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <form method="POST" action="{{ url('/admin/profile') }}" enctype="multipart/form-data" class="admin_form  ajax-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <label class="form_label_color">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ @$user->name }}" required />
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form_label_color">Email</label>
                                        <input type="email" class="form-control require" id="email" value="{{ @$user->email }}" disabled />
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form_label_color">Password</label>
                                        <input type="password" class="form-control require" id="password" name="password" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2" style="float: right;">Update</button>
                                <div class="response"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection