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
    </style>

    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <h4 class="breadcrumb-title">Payment</h4>
                <ul class="db-breadcrumb-list">
                    <li><a href="{{ url('/user/user_dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                    <li>Payment</li>
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
                <div class="container px-5 py-4 mt-4" style="border: 1px solid #aaa; background-color: #eee6; border-radius: 10px;">
                    <div class="row mt-4">
                        <div class="col-12">
                            <form method="POST" action="{{ url('user/all-packages/payment', $id) }}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                @csrf
                                <div class="col-12">
                                    <h4 class="text-center">Payment</h4>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label>Payment Type</label>
                                            <div class="form-check">
                                                <input class="form-check-input payment_type" type="radio" name="payment_type" id="wire_transfer" value="Bank Wire Transfer" checked required>
                                                <label class="form-check-label" for="wire_transfer">Paid by Bank Wire Transfer</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input payment_type" type="radio" name="payment_type" id="check" value="Check" required>
                                                <label class="form-check-label" for="check">Paid by Check</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input payment_type" type="radio" name="payment_type" id="cash" value="Cash" required>
                                                <label class="form-check-label" for="cash">Paid by Cash</label>
                                                <div class="invalid-feedback">
                                                    Please select payment type.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3" id="wire_transfer_div">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label>Routing Number <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="routing_number" id="routing_number" placeholder="Enter Routing Number">
                                            <div class="invalid-feedback">
                                                Please provide routing number.
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label>Account Number <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="account_number" id="account_number" placeholder="Enter Account Number">
                                            <div class="invalid-feedback">
                                                Please provide account number.
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label>Amount <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="amount" id="amount" placeholder="Enter Amount">
                                            <div class="invalid-feedback">
                                                Please provide amount.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3" id="check_div" style="display: none;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label>Check Number <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="check_number" id="check_number" placeholder="Enter Check Number">
                                            <div class="invalid-feedback">
                                                Please provide check number.
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label>Date of Check <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="date_of_check" id="date_of_check">
                                            <div class="invalid-feedback">
                                                Please provide account number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                            @if(empty(@$status))
                            <div class="row g-3">
                                <div class="col-12 mt-5">
                                    <h4 class="text-center">Pay Later</h4>
                                </div>
                                <div class="col-12">
                                    <p>You can pay now or pay later as well. But you must have to pay before 3 months of the Yatra otherwise you have to pay some extra charges of the late payment.</p>
                                    <p><b>Note: </b>If you pay the amount before 3 months of the Yatra, you will have to pay the actual amount only otherwise you will be charged some extra amount with the actual amount as well.</p>
                                    <p>For pay later, please click on the button below:</p>
                                    <a href="{{ url("thank-you") }}" class="btn btn-primary">Pay Later</a>
                                </div>
                            </div>
                            @endif
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

            $(document).on("click", ".payment_type", function () {
                if ($(this).val() == "Bank Wire Transfer") {
                    $("#routing_number").attr("required", true);
                    $("#account_number").attr("required", true);
                    $("#amount").attr("required", true);
                    $("#check_number").attr("required", false);
                    $("#date_of_check").attr("required", false);
                    $("#check_div").fadeOut();
                    $("#wire_transfer_div").fadeIn();
                } else if ($(this).val() == "Check") {
                    $("#routing_number").attr("required", false);
                    $("#account_number").attr("required", false);
                    $("#amount").attr("required", false);
                    $("#check_number").attr("required", true);
                    $("#date_of_check").attr("required", true);
                    $("#check_div").fadeIn();
                    $("#wire_transfer_div").fadeOut();
                } else {
                    $("#routing_number").attr("required", false);
                    $("#account_number").attr("required", false);
                    $("#amount").attr("required", false);
                    $("#check_number").attr("required", false);
                    $("#date_of_check").attr("required", false);
                    $("#check_div").fadeOut();
                    $("#wire_transfer_div").fadeOut();
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
