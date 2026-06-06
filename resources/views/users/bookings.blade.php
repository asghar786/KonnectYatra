@extends('userslayouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Bookings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url("/user/user_dashboard") }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Yatri Bookings</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row pb-5">
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Father Name</th>
                                <th scope="col">Nationality</th>
                                <th scope="col">Passport No.</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($yatries) > 0)
                            @php
                                $count = 1;
                            @endphp
                            @foreach($yatries as $key => $package)
                            <tr>
                                <td>{{@$count}}</td>
                                <td>{{@$package->last_name.' '.@$package->first_name.' '.@$package->middle_name}}</td>
                                <td>{{@$package->father_name}}</td>
                                <td>{{@$package->nationality}}</td>
                                <td>{{@$package->passport}}</td>
                                <td>{{@$package->dob}}</td>
                                <td>
                                    @if(@$package->payment_status == "paid")
                                    <span class="badge badge-success" style="font-size: 16px;">Paid</span>
                                    @else
                                    <a href="{{ url("user/payment/".@$package->id."?status=pay_later") }}" class="btn btn-success">Pay {{ @$package->package_type }}</a>
                                    @endif
                                </td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="11" class="text-center">No result found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
