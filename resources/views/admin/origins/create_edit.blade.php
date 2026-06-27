@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Departure Origin</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/origins') }}">Departure Origins</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-12">
                    <form method="POST" action="{{ @$action }}" class="admin_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Country</label>
                                <input type="text" class="form-control require" value="{{ old('country', @$origin->country) }}" name="country" placeholder="e.g. USA" required />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">State / City</label>
                                <input type="text" class="form-control require" value="{{ old('state', @$origin->state) }}" name="state" placeholder="e.g. California" required />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Departure Airport</label>
                                <input type="text" class="form-control require" value="{{ old('airport_name', @$origin->airport_name) }}" name="airport_name" placeholder="e.g. Los Angeles Intl" required />
                            </div>
                            <div class="col-lg-3 form-group">
                                <label class="form_label_color">Airport Code</label>
                                <input type="text" class="form-control require text-uppercase" value="{{ old('airport_code', @$origin->airport_code) }}" name="airport_code" placeholder="e.g. LAX" required />
                                <small class="text-muted">Must match the package's <b>State Code</b>.</small>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label class="form_label_color">Sort Order</label>
                                <input type="number" class="form-control" value="{{ old('sort_order', @$origin->sort_order ?? 0) }}" name="sort_order" placeholder="0" />
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color d-block">Status</label>
                                <input type="checkbox" value="1" name="status" @if(!isset($origin) || @$origin->status == 1) checked @endif /> Active (shown on the website)
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
