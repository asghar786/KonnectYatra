@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Edit Balance</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Edit Balance</li>
            </ul>
        </div>
        {{-- @dd($balance1); --}}
        <div class="main-body">
            <form action="{{url('admin/balance-update/'.$balance->id)}}" method="post">
                @csrf
                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Amount:</label>
                            <input type="text" class="form-control" value="{{$balance->amount}}"  name="amount"/>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>R #:</label>
                            <input type="text" class="form-control" value="{{$balance->raseed_no}}"  name="raseed_no"/>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Payment Date :</label>
                            <input type="text" class="form-control datepicker" value="{{ $balance->payment_date }}" placeholder="mm-dd-yyyy" name="payment_date"/>
                        </div>    
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection