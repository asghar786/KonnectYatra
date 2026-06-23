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
    form button:hover {
        background-color: #000 !important;
    }
    .pay-card-head {
        background: #f54e18;
        color: #fff;
        font-weight: 700;
        margin: -1.25rem -1.25rem 1rem;
        padding: 14px 20px;
        border-radius: 12px 12px 0 0;
    }
</style>

<!-- Content -->
<div class="page-content bg-white">
    <!-- inner page banner -->
    <section class="inner-banner-wrap pb-0">
      <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('payment', asset('assets/images2/Inner-banner-01.png')) }}');background-position: center !important;">
          <div class="container">
            <div class="inner-banner-content">
                <h1 class="inner-title" style="font-size:65px !important;">PAYMENT</h1>
           </div>
       </div>
   </div>
</section>
<!-- inner page banner -->
<div class="page-banner contact-page section-sp2">
    <div class="container px-5 py-4 mt-4">
        <div class="row mb-3">
            <div class="col-12 text-center">
                <img src="{{ asset('assets/images2/newlogo11.png') }}" alt="KonnectYatra" style="max-height:90px;width:auto;">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-3" style="background:#fff4ef;border:1px solid #ffd9c9;border-radius:12px;">
                    <p class="mb-2" style="font-size:18px;color:#1c2541;font-weight:700;">
                        <i class="fas fa-phone"></i> Payment Contact: <span style="color:#f54e18;">+1 (718) 908-9464</span>
                    </p>
                    <p class="mb-0" style="color:#1c2541;">
                        <b>Important:</b> Kindly test the account by sending <b>$1</b> first to the number above.
                        Upon getting confirmation, then transfer the full / balance amount to the given number.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h3 class="text-center">Wahe Guru Ji ka Khalsa</h3>
            </div>
            <div class="col-4">
                <h4 class="text-center mt-2">(First Come First Serve)</h4>
            </div>
            <div class="col-4">
                <h3 class="text-center">Wahe Guru Ji ki Fateh</h3>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <form method="POST" action="{{ url('all-packages/payment', $id) }}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
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
                                    <label class="form-check-label" for="wire_transfer" style="cursor: pointer;"><b>Paid by Bank Wire Transfer</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="check" value="Check" required>
                                    <label class="form-check-label" for="check" style="cursor: pointer;"><b>Paid by Check</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="cash" value="Cash" required>
                                    <label class="form-check-label" for="cash" style="cursor: pointer;"><b>Paid by Cash</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="zelle" value="Zelle" required>
                                    <label class="form-check-label" for="zelle" style="cursor: pointer;"><b>Paid by Zelle</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input class="form-check-input payment_type" type="radio" name="payment_type" id="pay_later" value="Pay Later" required>
                                    <label class="form-check-label" for="pay_later" style="cursor: pointer;"><b>Pay Later</b></label>
                                    <div class="invalid-feedback">
                                        Please select payment type.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Amount due (taken from the selected package price) -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="p-3" style="background:#fff4ef;border:1px solid #ffd9c9;border-radius:12px;">
                                    <span style="font-size:18px;color:#1c2541;font-weight:600;">Amount Due (per person): </span>
                                    <span style="font-size:24px;font-weight:800;color:#f54e18;">${{ number_format(@$amount) }}</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="amount" value="{{ @$amount }}">

                        @php $payEmpty = '<span class="text-muted">Payment details will be shared shortly. Please call (718) 908-9464.</span>'; @endphp

                        <!-- Bank Wire Transfer -->
                        <div class="row my-3" id="wire_transfer_div">
                            <div class="col-12">
                                <div class="card" style="border:1px solid #eef0f4;border-radius:12px;">
                                    <div class="card-body">
                                        <h5 class="pay-card-head"><i class="fas fa-building-columns"></i> Bank Wire Transfer Details</h5>
                                        @if(!empty(@$pay['bank_name']) || !empty(@$pay['bank_account']))
                                        <div class="row align-items-center">
                                            <div class="col-lg-8 col-md-8">
                                                <table class="w-100" style="border:0;">
                                                    @if(!empty(@$pay['bank_name']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;width:200px;"><b>Bank Name</b></td><td style="border:0;text-align:left;">{{ $pay['bank_name'] }}</td></tr>@endif
                                                    @if(!empty(@$pay['bank_title']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Account Title</b></td><td style="border:0;text-align:left;">{{ $pay['bank_title'] }}</td></tr>@endif
                                                    @if(!empty(@$pay['bank_routing']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Routing Number</b></td><td style="border:0;text-align:left;">{{ $pay['bank_routing'] }}</td></tr>@endif
                                                    @if(!empty(@$pay['bank_account']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Account Number</b></td><td style="border:0;text-align:left;">{{ $pay['bank_account'] }}</td></tr>@endif
                                                    <tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Amount</b></td><td style="border:0;text-align:left;"><b style="color:#f54e18;">${{ number_format(@$amount) }}</b></td></tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-center mt-3 mt-md-0">
                                                <img src="{{ asset('assets/images2/bank-illustration.svg') }}" alt="Bank" style="max-width:170px;width:100%;height:auto;">
                                            </div>
                                        </div>
                                        @if(!empty(@$pay['bank_note']))<p class="mt-2 mb-0 text-muted">{!! nl2br(e($pay['bank_note'])) !!}</p>@endif
                                        @else
                                        {!! $payEmpty !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Check -->
                        <div class="row my-3" id="check_div" style="display:none;">
                            <div class="col-12">
                                <div class="card" style="border:1px solid #eef0f4;border-radius:12px;">
                                    <div class="card-body">
                                        <h5 class="pay-card-head"><i class="fas fa-money-check"></i> Pay by Check</h5>
                                        @if(!empty(@$pay['check_payable_to']) || !empty(@$pay['check_address']))
                                        <div class="row align-items-center">
                                            <div class="col-lg-8 col-md-8">
                                                <table class="w-100" style="border:0;">
                                                    @if(!empty(@$pay['check_payable_to']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;width:200px;"><b>Make Check Payable To</b></td><td style="border:0;text-align:left;">{{ $pay['check_payable_to'] }}</td></tr>@endif
                                                    @if(!empty(@$pay['check_account']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Account Number</b></td><td style="border:0;text-align:left;">{{ $pay['check_account'] }}</td></tr>@endif
                                                    @if(!empty(@$pay['check_address']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;vertical-align:top;"><b>Mail To</b></td><td style="border:0;text-align:left;">{!! nl2br(e($pay['check_address'])) !!}</td></tr>@endif
                                                    <tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Amount</b></td><td style="border:0;text-align:left;"><b style="color:#f54e18;">${{ number_format(@$amount) }}</b></td></tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-center mt-3 mt-md-0">
                                                <img src="{{ asset('assets/images2/cheque-illustration.svg') }}" alt="Check" style="max-width:230px;width:100%;height:auto;">
                                            </div>
                                        </div>
                                        @if(!empty(@$pay['check_note']))<p class="mt-2 text-muted">{!! nl2br(e($pay['check_note'])) !!}</p>@endif
                                        @else
                                        {!! $payEmpty !!}
                                        @endif
                                        <div class="row mt-3">
                                            <div class="col-lg-6 mb-2">
                                                <label>Check Number <span class="text-muted">(optional)</span></label>
                                                <input class="form-control" type="text" name="check_number" id="check_number" placeholder="Enter Check Number">
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <label>Date of Check <span class="text-muted">(optional)</span></label>
                                                <input class="form-control" type="date" name="date_of_check" id="date_of_check">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cash -->
                        <div class="row my-3" id="cash_div" style="display:none;">
                            <div class="col-12">
                                <div class="card" style="border:1px solid #eef0f4;border-radius:12px;">
                                    <div class="card-body">
                                        <h5 class="pay-card-head"><i class="fas fa-money-bill-wave"></i> Pay by Cash — Visit Our Office</h5>
                                        @if(!empty(@$pay['cash_address']))
                                        @php
                                            $cashAddr = $pay['cash_address'];
                                            $mapEmbed = 'https://www.google.com/maps?q=' . urlencode($cashAddr) . '&output=embed';
                                            $mapLink  = !empty($pay['cash_map_url']) ? $pay['cash_map_url'] : ('https://www.google.com/maps/search/?api=1&query=' . urlencode($cashAddr));
                                        @endphp
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <p class="mb-1"><b>Office Address:</b></p>
                                                <p class="mb-2">{!! nl2br(e($cashAddr)) !!}</p>
                                                @if(!empty(@$pay['cash_note']))<p class="text-muted mb-2">{!! nl2br(e($pay['cash_note'])) !!}</p>@endif
                                                <p class="mb-3"><b>Amount:</b> <b style="color:#f54e18;">${{ number_format(@$amount) }}</b></p>
                                                <a href="{{ $mapLink }}" target="_blank" rel="noopener" class="btn" style="background-color:#f54e18;color:#fff;border-radius:30px;">
                                                    <i class="fas fa-location-arrow"></i> Get Directions on Google Maps
                                                </a>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mt-3 mt-md-0">
                                                <a href="{{ $mapLink }}" target="_blank" rel="noopener" title="Open in Google Maps">
                                                    <iframe src="{{ $mapEmbed }}" width="100%" height="240" style="border:0;border-radius:12px;pointer-events:none;" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                                </a>
                                            </div>
                                        </div>
                                        @else
                                        {!! $payEmpty !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Zelle -->
                        <div class="row my-3" id="zelle_div" style="display:none;">
                            <div class="col-12">
                                <div class="card" style="border:1px solid #eef0f4;border-radius:12px;">
                                    <div class="card-body">
                                        <h5 class="pay-card-head"><i class="fas fa-mobile-screen-button"></i> Pay by Zelle</h5>
                                        @if(!empty(@$pay['zelle_phone']) || !empty(@$pay['zelle_email']))
                                        <div class="row align-items-start">
                                            <div class="col-lg-8 col-md-8">
                                                <table class="w-100" style="border:0;">
                                                    @if(!empty(@$pay['zelle_name']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;width:200px;"><b>Recipient Name</b></td><td style="border:0;text-align:left;">{{ $pay['zelle_name'] }}</td></tr>@endif
                                                    @if(!empty(@$pay['zelle_phone']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Zelle Phone Number</b></td><td style="border:0;text-align:left;"><b style="color:#f54e18;">{{ $pay['zelle_phone'] }}</b></td></tr>@endif
                                                    @if(!empty(@$pay['zelle_email']))<tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Zelle Email</b></td><td style="border:0;text-align:left;">{{ $pay['zelle_email'] }}</td></tr>@endif
                                                    <tr><td style="border:0;text-align:left;padding:6px 12px 6px 0;"><b>Amount</b></td><td style="border:0;text-align:left;"><b style="color:#f54e18;">${{ number_format(@$amount) }}</b></td></tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-center mt-2 mt-md-0">
                                                <img src="{{ asset('assets/images2/zelle-logo.svg') }}" alt="Zelle" style="max-width:120px;width:100%;height:auto;">
                                            </div>
                                        </div>
                                        <p class="mt-2 mb-0" style="color:#1c2541;"><b>Important:</b> Kindly test the account by sending <b>$1</b> first. Upon getting confirmation, then transfer the full / balance amount to the given number.</p>
                                        @if(!empty(@$pay['zelle_note']))<p class="mt-2 mb-0 text-muted">{!! nl2br(e($pay['zelle_note'])) !!}</p>@endif
                                        @else
                                        {!! $payEmpty !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pay Later -->
                        <div class="row my-3" id="note" style="display: none;">
                            <div class="col-12">
                                <div class="card" style="border:1px solid #eef0f4;border-radius:12px;">
                                    <div class="card-body">
                                        <h5 class="pay-card-head"><i class="fas fa-clock"></i> Pay Later</h5>
                                        @if(!empty(@$order_no))
                                        <p class="mb-2"><b>Your Order Number:</b> <b style="color:#f54e18;">{{ $order_no }}</b></p>
                                        @endif
                                        <p class="mb-2"><b>Amount:</b> <b style="color:#f54e18;">${{ number_format(@$amount) }}</b></p>
                                        @if(!empty(@$yatri_visa->email))
                                        <p class="mb-2">On submitting, your booking and payment instructions will be sent to your primary email: <b>{{ $yatri_visa->email }}</b>.</p>
                                        @endif
                                        <p class="mb-0"><b>Note:</b> This booking is valid for <b>30 days</b> (pay before <b>{{ @$valid_until }}</b>). Otherwise your booking will be <span style="color: red;">CANCELLED!</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center pt-3">
                        <button class="button-text width-6 btn-slider mt-0 py-3 px-4" style="background-color: #fff;">Submit</button>
                    </div>
                </form>
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

        $(document).on("click", ".payment_type", function () {
            var v = $(this).val();
            $("#wire_transfer_div, #check_div, #cash_div, #zelle_div, #note").hide();
            if (v == "Bank Wire Transfer") {
                $("#wire_transfer_div").fadeIn();
            } else if (v == "Check") {
                $("#check_div").fadeIn();
            } else if (v == "Cash") {
                $("#cash_div").fadeIn();
            } else if (v == "Zelle") {
                $("#zelle_div").fadeIn();
            } else {
                $("#note").fadeIn();
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
