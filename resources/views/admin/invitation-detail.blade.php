@extends('admin.layouts.app')
@section('content')
<style>
.table td, .table th {
    vertical-align: top !important;
}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">ETPB List</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>ETPB List</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row my-4">
                <div class="col-lg-12 mb-4 text-center">
                    <h3>DETAILS REQUIRED FROM GROUPS/INDIVIDUALS</h3>
                </div>
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width: 5px !important;">Sr #</th>
                                <th class="text-center" style="width: 120px !important;">Name</th>
                                <th class="text-center" style="width: ;">Father Name</th>
                                <th class="text-center" style="width: ;">Passport No.</th>
                                <th class="text-center" style="width: ;">Nationality</th>
                                <th class="text-center" style="width: ;">PR Status/PR No. If any</th>
                                <th class="text-center" style="width: ;">Religion</th>
                                <th class="text-center" style="width: ;">Itinerary/Full Visit Schedule Hotel Booking</th>
                                <th class="text-center" style="width: ;">Previous Visits Detail</th>
                                <th class="text-center" style="width: ;">Reference in Pakistan (Name, Address & Number)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($detail) > 0)
                            @php
                                $count = 1;
                            @endphp
                            @foreach($detail as $value)
                            <tr>
                                <td class="text-center" style="">{{@$count}}</td>
                                <td class="text-center">{{@$value->last_name.' '.@$value->first_name.' '.@$value->middle_name}}</td>
                                <td class="text-center">{{@$value->father_name}}</td>
                                <td class="text-center">{{ @$value->passport }}</td>
                                <td class="text-center">{{@$value->passport_country}}</td>
                                <td class="text-center">@if(@$value->passport_country == "India") {{ @$value->reference_no }} @else N/A @endif</td>
                                <td class="text-center">{{@$value->religion}}</td>
                                <td class="text-center">@if(!empty(@$value->hotel->name)) {{@$value->hotel->name}} @else N/A @endif</td>
                                <td class="text-center">N/A</td>
                                <td class="text-center">Konnect Yatra USA</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        {{-- @endforeach --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection