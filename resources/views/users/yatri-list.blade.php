@extends('userslayouts.app')
@section('content')
<style type="text/css">
    .dt-buttons {
        display: none;
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">List of Yatri's</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/user/user_dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>List of Yatri's</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row" id="print-div" style="display: none;">
                <div class="col-lg-12 mb-3">
                    <h5>Yatri's List 11/2023</h5>
                </div>
                <div class="col-lg-12 d-flex justify-content-between mb-3">
                    <div>
                        <p class="mb-1"><b>Gurdwara Name:</b> <span>{{ $user->name }}</span></p>
                        <p class="mb-1"><b>Secretary:</b> <span>{{ $user->secretary }}</span></p>
                        <p class="mb-1"><b>Submission Date:</b> <span>{{ date("d, F Y") }}</span></p>
                    </div>
                    <div>
                        <p class="mb-1"><b>Chairman:</b> <span>{{ $user->chairman }}</span></p>
                        <p class="mb-1"><b>President:</b> <span>{{ $user->president }}</span></p>
                    </div>
                    <div>
                        <a href="#" class="mb-2"></a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Name of Yatri</th>
                                <th scope="col">Father Name</th>
                                <th scope="col">Citizenship</th>
                                <th scope="col">Passport No.</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col">Telephone No.</th>
                                <th scope="col">Date of Registration</th>
                                <th scope="col">Room Occupied</th>
                                <th scope="col">Check #</th>
                                <th scope="col">Check Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @if(count($yatries) > 0)
                            @foreach($yatries as $key => $package)
                            <tr>
                                <td>{{@$count}}</td>
                                <td>{{@$package->last_name.' '.@$package->first_name.' '.@$package->middle_name}}</td>
                                <td>{{@$package->father_name}}</td>
                                <td>{{@$package->nationality}}</td>
                                <td>{{@$package->passport}}</td>
                                <td>{{@$package->dob}}</td>
                                <td>{{@$package->telephone}}</td>
                                <td>{{date("Y-m-d", strtotime($package->created_at))}}</td>
                                <td>{{@$package->hotel->name}}</td>
                                <td>{{@$package->routing_number}}</td>
                                <td>{{@$package->amount}}</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @if(count($package->passenger) > 0)
                            @foreach($package->passenger as $k => $p)
                            <tr>
                                <td>{{@$count}}</td>
                                <td>{{@$p->last_name.' '.@$p->first_name.' '.@$p->middle_name}}</td>
                                <td>{{@$p->father_name}}</td>
                                <td>{{@$p->nationality}}</td>
                                <td>{{@$p->passport}}</td>
                                <td>{{@$p->dob}}</td>
                                <td>{{@$p->telephone}}</td>
                                <td>{{date("Y-m-d", strtotime($p->created_at))}}</td>
                                <td>{{@$p->hotel->name}}</td>
                                <td>{{@$package->routing_number}}</td>
                                <td>@if(!empty(@$package->amount)) ${{@$package->amount}} @endif</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @endforeach
                            @endif
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
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <h5>Yatri's List 11/2023</h5>
                </div>
                <div class="col-lg-12 d-flex justify-content-between mb-3">
                    <div>
                        <p class="mb-1"><b>Gurdwara Name:</b> <span>{{ $user->name }}</span></p>
                        <p class="mb-1"><b>Secretary:</b> <span>{{ $user->secretary }}</span></p>
                        <p class="mb-1"><b>Submission Date:</b> <span>{{ date("d, F Y") }}</span></p>
                    </div>
                    <div>
                        <p class="mb-1"><b>Chairman:</b> <span>{{ $user->chairman }}</span></p>
                        <p class="mb-1"><b>President:</b> <span>{{ $user->president }}</span></p>
                    </div>
                    <div>
                        <a href="{{ url("user/all-packages") }}" class="btn btn-primary mb-2">Add Booking <i class="fas fa-plus"></i></a>
                        <button type="button" class="btn btn-primary mb-2" onclick="printDiv('print-div')">Print</button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Name of Yatri</th>
                                <th scope="col">Father Name</th>
                                <th scope="col">Citizenship</th>
                                <th scope="col">Passport No.</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col">Telephone No.</th>
                                <th scope="col">Date of Registration</th>
                                <th scope="col">Room Occupied</th>
                                <th scope="col">Check #</th>
                                <th scope="col">Check Amount</th>
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
                                <td>{{@$package->telephone}}</td>
                                <td>{{date("Y-m-d", strtotime($package->created_at))}}</td>
                                <td>{{@$package->hotel->name}}</td>
                                <td>{{@$package->routing_number}}</td>
                                <td>@if(!empty(@$package->amount)) ${{@$package->amount}} @endif</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @if(count($package->passenger) > 0)
                            @foreach($package->passenger as $k => $p)
                            <tr>
                                <td>{{@$count}}</td>
                                <td>{{@$p->last_name.' '.@$p->first_name.' '.@$p->middle_name}}</td>
                                <td>{{@$p->father_name}}</td>
                                <td>{{@$p->nationality}}</td>
                                <td>{{@$p->passport}}</td>
                                <td>{{@$p->dob}}</td>
                                <td>{{@$p->telephone}}</td>
                                <td>{{date("Y-m-d", strtotime($p->created_at))}}</td>
                                <td>{{@$p->hotel->name}}</td>
                                <td>{{@$package->routing_number}}</td>
                                <td>@if(!empty(@$package->amount)) ${{@$package->amount}} @endif</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @endforeach
                            @endif
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
@section('js')
    <script type="text/javascript">
        function printDiv(divName) {

            var printContents = document.getElementById(divName).innerHTML;

            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

                // document.body.style.marginTop="-45px";

            window.print();

            document.body.innerHTML = originalContents;

        }
    </script>
@endsection