@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Expenses</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/charges') }}">Expenses</a></li>
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
                                <label class="form_label_color">Description</label>
                                <input type="text" class="form-control require" name="description" value="{{@$charge->description}}" />
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Amount</label>
                                <input type="number" class="form-control require" value="{{@$charge->amount}}" name="amount" required=""/>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">State</label>
                                <select class="form-control require" name="state">
                                    <option value="New York" @if(@$charge->state == "New York") selected @endif>New York</option>
                                    <option value="Washington" @if(@$charge->state == "Washington") selected @endif>Washington</option>
                                    <option value="Los Angeles" @if(@$charge->state == "Los Angeles") selected @endif>Los Angeles</option>
                                    <option value="Chicago" @if(@$charge->state == "Chicago") selected @endif>Chicago</option>
                                    <option value="Miami" @if(@$charge->state == "Miami") selected @endif>Miami</option>
                                    <option value="Seattle" @if(@$charge->state == "Seattle") selected @endif>Seattle</option>
                                    <option value="Houston" @if(@$charge->state == "Houston") selected @endif>Houston</option>
                                    <option value="Toronto" @if(@$charge->state == "Toronto") selected @endif>Toronto</option>
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