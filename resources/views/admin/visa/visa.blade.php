@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Visa</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Visa</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row my-4">
                <div class="col-lg-12 d-flex justify-content-end" >
                    <a class="btn btn-info mb-3" target="_blank" href="https://visa.nadra.gov.pk/e-visa/authenticate">Go to Nadra Website</a>
                </div>
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">Sr #</th>
                                <th scope="col" class="text-center">Yatri #</th>
                                <th scope="col" class="text-center">Applicant Name</th>
                                <th scope="col" class="text-center">Nationality</th>
                                <th scope="col" class="text-center">Date of Birth</th>
                                <th scope="col" class="text-center">Place of Birth</th>
                                <th scope="col" class="text-center">Gender</th>
                                <th scope="col" class="text-center">Email Address</th>
                                <th scope="col" class="text-center">Phone Number</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($visa) > 0)
                            @php
                                $count = 1;
                            @endphp
                            @foreach($visa as $value)
                            <tr>
                                <td class="text-center">{{@$count}}</td>
                                <td class="text-center">{{@$value->yatri_id}}</td>
                                <td class="text-center">{{@$value->last_name.' '.@$value->first_name.' '.@$value->middle_name}}</td>
                                <td class="text-center">{{@$value->passport_country}}</td>
                                <td class="text-center">{{date("d-m-Y", strtotime(@$value->dob))}}</td>
                                <td class="text-center">{{@$value->place_birth}}</td>
                                <td class="text-center">{{@$value->gender}}</td>
                                <td class="text-center">{{@$value->email}}</td>
                                <td class="text-center">{{@$value->phone}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/visa-detail', @$value->id) }}" class="bg-info mr-2" style="color:white; padding:11px;">Visa Detail</a>
                                        @if($value->passport_country == 'India')
                                        <a href="{{ url('admin/foreigners_registration', @$value->id) }}" class=" mr-2" style="color:black; padding:11px;background-color: #f7b205;">C-Form</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @php
                                $count++;
                            @endphp
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