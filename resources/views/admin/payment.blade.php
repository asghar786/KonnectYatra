@extends('admin.layouts.app')
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
    form button:hover {
        background-color: #000 !important;
    }
</style>
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
            <div class="row mt-4">
                <div class="col-12">
                    <form method="POST" action="{{ url('admin/payment', $id) }}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="col-12 mt-4">
                            {{-- <h4 class="text-center">Payment</h4> --}}
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <h4 class="my-4">Payment Type</h4>
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
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label>Receipt # <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="rased_number" id="rased_number" placeholder="Enter Rased Number">
                                    <div class="invalid-feedback">
                                        Please provide R # number.
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label>Amount <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="amount" id="" placeholder="Enter Amount">
                                    <div class="invalid-feedback">
                                        Please provide amount.
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
                        <div class="col-12 pt-2">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- inner page banner END -->
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
