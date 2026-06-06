@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Add Balance</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/yatri-visa') }}">Yatri Booking</a></li>
                <li>Add Balance</li>
            </ul>
        </div>
        {{-- @dd($balance1); --}}
        <div class="main-body">
            <h3>Pending Amount: {{ (@$pending_amount > 0) ? '$'.@$pending_amount : "$0" }}</h3>
            @if($pending_amount > 0)
            <form action="{{url('admin/insert_balance')}}" method="post">
                @csrf
                <input type="hidden" value="{{ @$visa->id }}" name="visa_id">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Amount:</label>
                            <input type="text" class="form-control" name="amount" required="" />
                        </div>    
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Amount Type:</label><br>
                            <input type="radio" name="amount_type" value="cash" checked="" required="" /> Cash
                            <input type="radio" name="amount_type" style="margin-left: 10px;" value="check" required="" /> Check
                        </div>    
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Receipt #:</label>
                            <input type="text" class="form-control" name="raseed_no" required="" />
                        </div>    
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date of Payment:</label>
                            <input type="date" class="form-control" name="payment_date" required="" />
                        </div>    
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            @endif
        </div>
        <div class="main_body mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">Sr #</th>
                                <th scope="col" class="text-center">Name</th>
                                <th scope="col" class="text-center">Passport #</th>
                                <th scope="col" class="text-center">R #</th>
                                <th scope="col" class="text-center">Amount</th>
                                <th scope="col" class="text-center">Amount Type</th>
                                <th scope="col" class="text-center">Payment Date</th> 
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($balance as $key => $value)
                            <tr>
                                <td class="text-center">{{@++$key}}</td>
                                <td class="text-center">{{@$value->visa->first_name.' '.@$value->visa->middle_name.' '.@$value->visa->last_name}}</td>
                                <td class="text-center">{{@$value->visa->passport}}</td>
                                <td class="text-center">{{@$value->raseed_no}}</td>
                                <td class="text-center">${{@$value->amount}}</td>
                                <td class="text-center">{{ucfirst(@$value->amount_type)}}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime(@$value->payment_date)) }}</td>
                                <td class="text-center">
                                    <a href="{{url('admin/balance-edit',@$value->id)}}" class="fa fa-edit bg-warning ml-2" style="color:white; padding:11px;"></a>
                                    <a href="{{url('admin/balance-delete/'.@$value->id)}}" class="bg-danger ml-2" style="color:white; padding:9px; padding-top: 12px;"><i class=" text-white fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>
</main>
<div class="ttr-overlay"></div>
@endsection