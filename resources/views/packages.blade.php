@extends('layouts.app')
@section('content')

    <style type="text/css">
        .owl-prev, .owl-next, .back-to-top, .btn {
            background-color: #f54e18 !important;
            color: #fff !important;
        }
        .title-head {
            border-color: #f54e18 !important;
        }
        .btn.dropdown-toggle.btn-default {
            color: #000 !important;
        }
    </style>

    <!-- Content -->
    <div class="page-content bg-white">
        <!-- inner page banner -->
        <div class="page-banner ovbl-light" style="background-image:url({{ asset('assets/images2/Inner-banner-01.png') }});">
            <div class="container">
                <div class="page-banner-entry">
                    <h1 class="text-white">Packages <i class="fa fa-plane"></i></h1>
                </div>
            </div>
        </div>
        <!-- Breadcrumb row -->
        <div class="breadcrumb-row">
            <div class="container">
                <ul class="list-inline">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Packages</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb row END -->
        <div class="container">
            <div class="row">
                <div class="col-12 mt-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-4">
                    <h6 class="text-center">Wahe Guru Ji ka Khalsa</h6>
                </div>
                <div class="col-4">
                    <h3 class="text-center">(First Come First Serve)</h3>
                </div>
                <div class="col-4">
                    <h6 class="text-center">Wahe Guru Ji ki Fateh</h6>
                </div>
            </div>
        </div>
        <!-- inner page banner -->
        <div class="page-banner contact-page section-sp2" style="margin-top: -80px;">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-4 text-center"> Holy Yatra Tour to Nanakana Sahib – Panja Sahib – Kartarpur Sahib and other Gurdwaras in Pakistan </h6>
                        <div class="row g-3">
                            @php
                                $timestamp = strtotime(@$packages->month_year);
                                $new_date_format = date('F Y', $timestamp);
                            @endphp
                            <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="package_id" type="hidden" value="{{ $packages->id }}" id="package_1">
                                    <label class="form-check-label" for="flexCheckDefault" style="font-size: 22px;">
                                        {{ $new_date_format }}
                                    </label>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center mb-3" style="border: 1px solid black; border-right: 0px;">
                                <div class="form-check p-2" style="border-bottom: 1px solid black;">
                                    {{-- <input class="form-check-input" type="radio" name="package_type" value="Single ${{ $packages->single_price }}" id="package_type_1"> --}}
                                    <label class="form-check-label" for="package_type_1"> Single Occupancy </label>
                                </div>
                                <div class="form-check p-2">
                                    {{-- <input class="form-check-input" type="radio" name="package_type" value="Single ${{ $packages->single_price }}" id="package_type_1"> --}}
                                    <label class="form-check-label" for="package_type_1"> ${{ $packages->single_price }} </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center mb-3" style="border: 1px solid black;">
                                <div class="form-check p-2" style="border-bottom: 1px solid black;">
                                    {{-- <input class="form-check-input" type="radio" name="package_type" value="Single ${{ $packages->single_price }}" id="package_type_1"> --}}
                                    <label class="form-check-label" for="package_type_1"> Double Occupancy </label>
                                </div>
                                <div class="form-check p-2">
                                    {{-- <input class="form-check-input" type="radio" name="package_type" value="Double ${{ $packages->double_price }}" id="package_type_2"> --}}
                                    <label class="form-check-label" for="package_type_2"> ${{ $packages->double_price }} </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center mb-3" style="border: 1px solid black; border-left: 0px;">
                                <div class="form-check p-2" style="border-bottom: 1px solid black;">
                                    {{-- <input class="form-check-input" type="radio" name="package_type" value="Single ${{ $packages->single_price }}" id="package_type_1"> --}}
                                    <label class="form-check-label" for="package_type_1"> Triple Occupancy </label>
                                </div>
                                <div class="form-check p-2">
                                    {{-- <input class="form-check-input" type="radio" name="package_type" value="Triple ${{ $packages->triple_price }}" id="package_type_3"> --}}
                                    <label class="form-check-label" for="package_type_3"> ${{ $packages->triple_price }} </label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                {!! $packages->description !!}
                            </div>
                            <div class="col-12">
                                <p><b>Note</b>: Above price is valid for New York residents, for all other states please
                                    call for the price. <b>IAD PAX add $50</b> in the package price</p>
                                <p>For Business Class prices please call <b style="font-size: 16px;">RASHAD MAHMOOD @ +1
                                        718-908-9464 </b></p>
                                <p>Cancellation of Trip: Airline applicable cancellation charges and $100 service charges
                                    applies. </p>
                            </div>
                            <div class="col-12">
                                <a class="btn" href="{{ url('packages/apply', $packages->id) }}">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                @foreach ($packages as $package)
                <div class="col-lg-6">
                    <div class="">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5>Gurdwara Name : {{$package->g_name}}</h5><h6>State : {{$package->state}}</h6>
                                </div>
                                <div class="col-lg-6">
                                    <h6>{{$package->month}} {{$package->year}}</h6>
                                </div>
                            </div>
                            <table class="table table-striped pj_table" id="mytable">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Departure</th>
                                    <th scope="col">No.Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$package->date_1st}}</td>
                                        <td>{{$package->day_1st}}</td>
                                        <td class="text-success">{{$package->dep_1st}}</td>
                                        <td class="text-danger">{{$package->no_1day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_2nd}}</td>
                                        <td>{{$package->day_2nd}}</td>
                                        <td>{{$package->dep_2nd}}</td>
                                        <td class="text-danger">{{$package->no_2day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_3rd}}</td>
                                        <td>{{$package->day_3rd}}</td>
                                        <td class="text-success">{{$package->dep_3rd}}</td>
                                        <td>{{$package->no_3day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_4rth}}</td>
                                        <td>{{$package->day_4rth}}</td>
                                        <td>{{$package->dep_4rth}}</td>
                                        <td>{{$package->no_4day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_5th}}</td>
                                        <td>{{$package->day_5th}}</td>
                                        <td>{{$package->dep_5th}}</td>
                                        <td>{{$package->no_5day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_6th}}</td>
                                        <td>{{$package->day_6th}}</td>
                                        <td>{{$package->dep_6th}}</td>
                                        <td>{{$package->no_6day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_7th}}</td>
                                        <td>{{$package->day_7th}}</td>
                                        <td>{{$package->dep_7th}}</td>
                                        <td>{{$package->no_7day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_8th}}</td>
                                        <td>{{$package->day_8th}}</td>
                                        <td>{{$package->dep_8th}}</td>
                                        <td>{{$package->no_8day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_9th}}</td>
                                        <td>{{$package->day_9th}}</td>
                                        <td>{{$package->dep_9th}}</td>
                                        <td>{{$package->no_9day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_10th}}</td>
                                        <td>{{$package->day_10th}}</td>
                                        <td>{{$package->dep_10th}}</td>
                                        <td>{{$package->no_10day}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{$package->date_last}}</td>
                                        <td>{{$package->day_last}}</td>
                                        <td class="text-danger">{{$package->dep_last}}</td>
                                        <td class="text-danger">{{$package->no_lday}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> --}}
            </div>
        </div>
        <!-- inner page banner END -->
    </div>
    <!-- Content END-->
    <style>
        table {
            border: 1px solid black;
            height: auto;
            width: auto;
        }

        th {

            padding: 0px;
            width: auto;
            height: auto;
            text-align: center;
        }

        td {
            border: 1px solid black;
            padding: 0px;
            width: auto;
            height: auto;
            text-align: center;
        }
    </style>
    <script>
        (function() {
            'use strict';

            var forms = document.querySelectorAll('.needs-validation');

            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        var firstInvalidElement = form.querySelector(':invalid');
                        firstInvalidElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
    <script>
        $(document).ready(function() {
            // Attach click event listener to each checkbox
            $("#package_1, #package_2, #package_3").click(function() {
                // If a checkbox is checked, enable the other two
                if ($(this).is(":checked")) {
                    $("#package_1, #package_2, #package_3").not(this).prop("disabled", true);
                }
                // If a checkbox is unchecked, enable the other two
                else {
                    $("#package_1, #package_2, #package_3").prop("disabled", false);
                }
            });
        });
    </script>
    <script>
        // Add event listeners to all the package checkboxes
        $("input[type='checkbox']").change(function() {
            var checked = $(this).is(":checked");
            var container = $(this).closest(".col-lg-4");
            container.find("input[type='radio']").prop("disabled", !checked);
            container.find("input[type='radio']").prop("required", true);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Attach click event listener to radio buttons
            $('input[name="first_visit"]').on('click', function() {
                // If yes is selected, show the div
                if ($(this).val() === 'yes') {
                    $('#previous-visit').prop('required', false);
                    $('#entry-port').prop('required', false);
                    $('#first-visit').hide();
                }
                // If no is selected, hide the div
                else {
                    $('#previous-visit').prop('required', true);
                    $('#entry-port').prop('required', true);
                    $('#first-visit').show();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Attach click event listener to radio buttons
            $('input[name="us_passport"]').on('click', function() {
                // If yes is selected, show the div
                if ($(this).val() === 'yes') {
                    $('#green-card').prop('required', true);
                }
                // If no is selected, hide the div
                else {
                    $('#green-card').prop('required', false);
                }
            });
        });
    </script>
@endsection
