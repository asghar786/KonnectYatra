@extends('userslayouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Profile</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/user/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Profile</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <form method="POST" action="{{ url('/user/profile') }}">
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
                                    @if(\Auth::user()->role == "gurdwara")
                                    <div class="col-lg-6 form-group">
                                        <label class="form_label_color">Chairman</label>
                                        <input type="text" class="form-control require" id="chairman" name="chairman" value="{{ @$user->chairman }}" />
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form_label_color">President</label>
                                        <input type="text" class="form-control require" id="president" name="president" value="{{ @$user->president }}" />
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form_label_color">Secretary</label>
                                        <input type="text" class="form-control require" id="secretary" name="secretary" value="{{ @$user->secretary }}" />
                                    </div>
                                    @endif
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