@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Receivable</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/accounting') }}">Accounting</a></li>
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
                                <label class ="form_label_color">Account Head</label>
                                <select class="form-control require" name="account_head_id" required="">
                                    @foreach(@$account_head as $key => $val)
                                    <option value="{{@$val->id}}" @if($val['id'] == @$receivable['account_head_id']) selected @endif>{{@$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Amount</label>
                                <input type="text" class="form-control require" value="{{@$receivable->amount}}" name="amount" required=""/>
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