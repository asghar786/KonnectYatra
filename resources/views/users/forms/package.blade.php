@extends('userslayouts.app')
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
        input, select {
            border-color: #a8a8a8 !important;
        }
    </style>

    <!-- Content -->
    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <h4 class="breadcrumb-title">Package Details</h4>
                <ul class="db-breadcrumb-list">
                    <li><a href="{{ url('/user/user_dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                    <li><a href="{{ url('/user/all-packages') }}">All Packages</a></li>
                    <li>Package Details</li>
                </ul>
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
                <div class="container px-5 py-4 mt-4" style="border: 1px solid #aaa; background-color: #eeeeee4a; border-radius: 10px;">
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4 class="mb-2 text-center">Holy Journey to Nankana Sahib (Guru Nanak Dev Ji’s Birthday)</h4>
                            <h5 class="mb-4 text-center text-danger">INCLUDES VISA AND FULL SECURITY</h5>
                            <div class="row g-3">
                                @php
                                    $timestamp = strtotime(@$packages->month_year);
                                    $new_date_format = date('F Y', $timestamp);
                                @endphp
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center my-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="package_id" type="hidden" value="dc1" id="package_1">
                                        <label class="form-check-label" for="flexCheckDefault" style="font-size: 20px; color: #000;">
                                            {{ @$packages->round_way_description }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3 px-0">
                                    <table class="w-100" style="background-color: #fff;">
                                        <thead>
                                            <tr>
                                                @if(!empty(@$packages->round_single_price))
                                                <td class="text-center"><b style="color: #000;">Single Occupancy</b></td>
                                                @endif
                                                @if(!empty(@$packages->round_double_price))
                                                <td class="text-center"><b style="color: #000;">Double Occupancy</b></td>
                                                @endif
                                                @if(!empty(@$packages->round_triple_price))
                                                <td class="text-center"><b style="color: #000;">Triple Occupancy</b></td>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if(!empty(@$packages->round_single_price))
                                                <td class="text-center"><b>${{ @$packages->round_single_price }}</b></td>
                                                @endif
                                                @if(!empty(@$packages->round_double_price))
                                                {{-- <td class="text-center"><b>${{ @$packages->round_double_price }}</b></td> --}}
                                                <td class="text-center"><b>(Less $100 in Double Occupancy for 2nd Person) If wife and husband traveling</b></td>
                                                @endif
                                                @if(!empty(@$packages->round_triple_price))
                                                <td class="text-center"><b>${{ @$packages->round_triple_price }}</b></td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="package_id" type="hidden" value="dc1" id="package_1">
                                        <label class="form-check-label" for="flexCheckDefault" style="font-size: 20px; color: #000;">
                                            {{ @$packages->one_way_description }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3 px-0">
                                    <table class="w-100" style="background-color: #fff;">
                                        <thead>
                                            <tr>
                                                @if(!empty(@$packages->one_single_price))
                                                <td class="text-center"><b style="color: #000;">Single Occupancy</b></td>
                                                @endif
                                                @if(!empty(@$packages->one_double_price))
                                                <td class="text-center"><b style="color: #000;">Double Occupancy</b></td>
                                                @endif
                                                @if(!empty(@$packages->one_triple_price))
                                                <td class="text-center"><b style="color: #000;">Triple Occupancy</b></td>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if(!empty(@$packages->one_single_price))
                                                <td class="text-center"><b>${{ @$packages->one_single_price }}</b></td>
                                                @endif
                                                @if(!empty(@$packages->one_double_price))
                                                {{-- <td class="text-center"><b>${{ @$packages->one_double_price }}</b></td> --}}
                                                <td class="text-center"><b>(Less $100 in Double Occupancy for 2nd Person) If wife and husband traveling</b></td>
                                                @endif
                                                @if(!empty(@$packages->one_triple_price))
                                                <td class="text-center"><b>${{ @$packages->one_triple_price }}</b></td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-12 mt-3">
                                    {!! @$packages->description !!}
                                </div>

                                {{-- <div class="col-4 mt-3">
                                    <div class="video-bx">
                                        @if(@$id == "1")
                                        <img src="{{ asset('assets/images2/flyer-3.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                                        @elseif(@$id == "2")
                                        <img src="{{ asset('assets/images2/flyer-2.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                                        @elseif(@$id == "3")
                                        <img src="{{ asset('assets/images2/flyer-1.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                                        @else(@$id == "4")
                                        <img src="{{ asset('assets/images2/flyer-4.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <p class="text-center mb-1">For further information please call at <b>718-908-9464</b> or book now at </p>
                                    <h5 class="text-center"><a href="{{ url('/') }}">konnectyatra.org</a></h5>
                                    <p class="mt-3">Konnect.us, Inc. presents Konnect Yatra Holy Package to Nankana Sahib</p>
                                    <p>Check payable to Konnect us, Inc. 18502 Hillside Ave, Jamaica, NY 11432</p>
                                    <p><b>Documents needed:</b> Copy of Valid Passport, Copy of Driver’s License or State ID and 1 Photographs</p>
                                </div>
                                <div class="col-12">
                                    <a href="{{ url("user/all-packages/".@$id."/apply") }}" class="btn btn-primary px-5">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- inner page banner END -->
        </div>
    </main>
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
