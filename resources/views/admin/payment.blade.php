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
    /* Payment Type — selectable cards (matches the frontend payment page) */
    .payment-type-grid { display: flex; flex-wrap: wrap; gap: 12px; }
    .payment-option {
        flex: 1 1 170px; display: flex; align-items: center; gap: 10px; margin: 0;
        border: 2px solid #e6e6e6; border-radius: 12px; padding: 14px 16px;
        cursor: pointer; background: #fff; transition: border-color .15s ease, background .15s ease, box-shadow .15s ease;
    }
    .payment-option:hover { border-color: #f5a48a; }
    .payment-option input { position: absolute; opacity: 0; width: 0; height: 0; }
    .payment-option .po-icon {
        flex: 0 0 38px; width: 38px; height: 38px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #f3f4f6; color: #777; font-size: 16px; transition: all .15s ease;
    }
    .payment-option .po-text { font-weight: 600; color: #333; font-size: 14px; line-height: 1.2; }
    .payment-option:has(input:checked), .payment-option.selected {
        border-color: #f54e18; background: #fff5f1; box-shadow: 0 2px 10px rgba(245,78,24,.15);
    }
    .payment-option:has(input:checked) .po-icon, .payment-option.selected .po-icon { background: #f54e18; color: #fff; }
    @media (max-width: 575px) { .payment-option { flex: 1 1 100%; } }
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
                                    <div class="payment-type-grid">
                                        <label class="payment-option">
                                            <input class="payment_type" type="radio" name="payment_type" id="wire_transfer" value="Bank Wire Transfer" checked required>
                                            <span class="po-icon"><i class="fas fa-university"></i></span>
                                            <span class="po-text">Bank Wire Transfer</span>
                                        </label>
                                        <label class="payment-option">
                                            <input class="payment_type" type="radio" name="payment_type" id="check" value="Check" required>
                                            <span class="po-icon"><i class="fas fa-money-check-alt"></i></span>
                                            <span class="po-text">Check</span>
                                        </label>
                                        <label class="payment-option">
                                            <input class="payment_type" type="radio" name="payment_type" id="cash" value="Cash" required>
                                            <span class="po-icon"><i class="fas fa-money-bill-wave"></i></span>
                                            <span class="po-text">Cash</span>
                                        </label>
                                        <label class="payment-option">
                                            <input class="payment_type" type="radio" name="payment_type" id="zelle" value="Zelle" required>
                                            <span class="po-icon"><i class="fas fa-bolt"></i></span>
                                            <span class="po-text">Zelle</span>
                                        </label>
                                        <label class="payment-option">
                                            <input class="payment_type" type="radio" name="payment_type" id="pay_later" value="Pay Later" required>
                                            <span class="po-icon"><i class="fas fa-clock"></i></span>
                                            <span class="po-text">Pay Later</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="base_fields">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label>Receipt # <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="rased_number" id="rased_number" placeholder="Enter Rased Number" required>
                                    <div class="invalid-feedback">
                                        Please provide R # number.
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label>Amount <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="amount" id="amount" placeholder="Enter Amount" required>
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

        function applyPaymentType(v) {
            // Reset everything.
            $("#wire_transfer_div, #check_div").hide();
            $("#routing_number, #account_number, #check_number, #date_of_check, #amount, #rased_number").attr("required", false);

            if (v === "Pay Later") {
                // No payment captured — hide the receipt/amount block.
                $("#base_fields").hide();
            } else {
                $("#base_fields").show();
                $("#amount, #rased_number").attr("required", true);
            }

            if (v === "Bank Wire Transfer") {
                $("#wire_transfer_div").show();
                $("#routing_number, #account_number").attr("required", true);
            } else if (v === "Check") {
                $("#check_div").show();
                $("#check_number, #date_of_check").attr("required", true);
            }
            // Cash & Zelle: only the Receipt # + Amount block (already shown).
        }

        $(document).on("click", ".payment_type", function () {
            $(".payment-option").removeClass("selected");
            $(this).closest(".payment-option").addClass("selected");
            applyPaymentType($(this).val());
        });

        // Initial state (Bank Wire Transfer is checked by default).
        $(".payment_type:checked").closest(".payment-option").addClass("selected");
        applyPaymentType($(".payment_type:checked").val());
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
