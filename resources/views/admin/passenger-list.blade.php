@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .dt-buttons {
        display: none;
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Reports</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Reports</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row" id="print-div" style="display: none;">
                <div class="col-lg-12 text-center mb-3">
                    <h4>Konnect Yatra (USA Group)</h4>
                </div>
                <div class="col-lg-12">
                    <p class="mb-0">State: <span id="state_info">All</span></p>
                </div>
                <div class="col-lg-12 mb-3">
                    <p>Ticket Type: <span id="ticket_info">All</span></p>
                </div>
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables1">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Father Name</th>
                                <th scope="col">Citizenship</th>
                                <th scope="col">Passport #</th>
                                <th scope="col">Date of Expiry</th>
                                <th scope="col">Place of Birth</th>
                                <th scope="col">Date of Arrival</th>
                                <th scope="col">Port of Arrival</th>
                                <th scope="col">Date of Departure</th>
                                <th scope="col">Port of Departure</th>
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
                                <td>{{@$package->passport_country}}</td>
                                <td>{{@$package->passport}}</td>
                                <td>{{date("m-d-Y", strtotime(@$package->expiry_date))}}</td>
                                <td>{{@$package->place_birth}}</td>
                                <td>{{@$package->package->package_details->day_1}}</td>
                                <td>Islamabad</td>
                                <td>{{@$package->package->package_details->day_8}}</td>
                                <td>Lahore</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h4>Konnect Yatra (USA Group)</h4>
                </div>
                <div class="col-lg-12 d-flex justify-content-between mb-3">
                    <p>Date of Submission: <span>{{ date("d, F Y") }}</span></p>
                    <button type="button" class="btn btn-primary mb-2" onclick="printDiv('print-div')">Print</button>
                </div>
                <div class="col-lg-12 mb-3">
                    <form method="GET" action="{{ url('admin/reports') }}" class="row filter-form">
                        <div class="col-lg-4">
                            <label for="state">Select State</label>
                            <select class="form-control" name="state" id="state">
                                <option value="all">-- All --</option>
                                {{-- <option value="New York" @if(@$state == 'New York') selected @endif>New York</option>
                                <option value="Washington DC" @if(@$state == 'Washington DC') selected @endif>DC / VA / MD</option>
                                <option value="Los Angeles" @if(@$state == 'Los Angeles') selected @endif>Los Angeles</option>
                                <option value="Miami" @if(@$state == 'Miami') selected @endif>Miami</option>
                                <option value="Chicago" @if(@$state == 'Chicago') selected @endif>Chicago</option>
                                <option value="Toronto" @if(@$state == 'Toronto') selected @endif>Toronto</option> --}}
                                @php
                                    $all_state = [];
                                @endphp
                                @if(count($packages) > 0)
                                @foreach(@$packages as $key => $value)
                                @if (!in_array($value['state'], $all_state))
                                @if($value['state'] == @$state)
                                <option value="{{ $value['state'] }}" selected>@if($value['state'] == 'Washington DC') DC / VA /MD @else {{ $value['state'] }} @endif</option>
                                @else
                                <option value="{{ $value['state'] }}">@if($value['state'] == 'Washington DC') DC / VA /MD @else {{ $value['state'] }} @endif</option>
                                @endif
                                @php
                                    array_push($all_state, $value['state']);
                                @endphp
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="ticket_type">Select Ticket Type</label>
                            <select class="form-control" name="ticket_type" id="ticket_type">
                                <option value="all">-- All --</option>
                                <option value="round_trip" @if(@$ticket_type == "round_trip") selected @endif>Round Trip</option>
                                <option value="one_way" @if(@$ticket_type == "one_way") selected @endif>One Way</option>
                                <option value="land_package" @if(@$ticket_type == "land_package") selected @endif>Land Package</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 mb-5">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Father Name</th>
                                <th scope="col">Citizenship</th>
                                <th scope="col">Passport #</th>
                                <th scope="col">Date of Expiry</th>
                                <th scope="col">Place of Birth</th>
                                <th scope="col">Date of Arrival</th>
                                <th scope="col">Port of Arrival</th>
                                <th scope="col">Date of Departure</th>
                                <th scope="col">Port of Departure</th>
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
                                <td><a href="{{url('admin/booking-detail',$package->id)}}">{{@$package->last_name.' '.@$package->first_name.' '.@$package->middle_name}}</a></td>
                                <td>{{@$package->father_name}}</td>
                                <td>{{@$package->passport_country}}</td>
                                <td>{{@$package->passport}}</td>
                                <td>{{@$package->expiry_date}}</td>
                                <td>{{@$package->place_birth}}</td>
                                <td>{{@$package->package->package_details->day_1}}</td>
                                <td>Islamabad</td>
                                <td>{{@$package->package->package_details->day_8}}</td>
                                <td>Lahore</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @endforeach
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
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#state_info").text($("#state option:selected").text());
            $("#ticket_info").text($("#ticket_type option:selected").text());

            $(document).on("change", "#state, #ticket_type", function () {
                $(".filter-form").submit();
                $("#state_info").text($("#state option:selected").val());
                $("#ticket_info").text($("#ticket_type option:selected").val());
            });
        });
        function printDiv(divName) {

            var printContents = document.getElementById(divName).innerHTML;

            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

                // document.body.style.marginTop="-45px";

            window.print();

            document.body.innerHTML = originalContents;

            location.reload();

        }
    </script>
@endsection