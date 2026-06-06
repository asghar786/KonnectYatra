@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Bookings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Admin Can View Yatri Applied Bookings</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row pb-5">
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Yatri #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Passport #</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Paid Amount</th>
                                <th scope="col">Pending Amount</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $count = 1;
                            @endphp
                            @foreach($yatries as $package)
                            <tr>
                                <td>{{@$count}}</td>
                                <td>{{@$package->yatri_id}}</td>
                                <td>{{@$package->first_name.' '.@$package->middle_name.' '.@$package->last_name}}</td>
                                <td>{{@$package->passport}}</td>
                                <td>{{@$package->package_type}}</td>
                                <td style="color: green;">${{(int)str_replace("$", "", @$package->package_type) - (int)@$package->pending_amount}}</td>
                                <td style="color: red;">{{(@$package->pending_amount > 0) ? '$'.@$package->pending_amount : "$0"}}</td>
                                <td>
                                    {{-- <span @if(@$package->payment_status == "pending") class="badge badge-warning p-2" @elseif(@$package->payment_status == "paid") class="badge badge-success p-2" @else class="badge badge-danger p-2" @endif style="font-size: 16px;">{{ucfirst($package->payment_status)}}</span> --}}
                                    <span @if(@$package->pending_amount > 0) class="badge badge-danger p-2" @else class="badge badge-success p-2" @endif style="font-size: 16px;">@if(@$package->pending_amount > 0) Unpaid @else Paid @endif</span>
                                </td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a href="{{route('yatri-visa-edit',$package->id)}}" class="dropdown-item" style="font-size: 15px;">Edit</a>
                                            <a href="{{url('admin/yatri-visa-delete/'.$package->id)}}" class="dropdown-item" style="font-size: 15px;">Delete</a>
                                            @if(@$package->payment_status == "pending")
                                            <a href="{{url('admin/payment', $package->id)}}" class="dropdown-item" style="font-size: 15px;">Add Payment</a>
                                            @endif
                                            <a href="{{url('admin/booking-detail', $package->id)}}" class="dropdown-item" style="font-size: 15px;">Details</a>
                                            <a href="{{ url('admin/add-remarks', $package->id) }}" class="dropdown-item" style="font-size: 15px;">Remarks</a>
                                            <a href="{{url('admin/add-balance/'.$package->id)}}" class="dropdown-item" style="font-size: 15px;">Manage Balance</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                            $count++;
                            @endphp
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
