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
        /* ===== Professional package detail ===== */
        .pkgx{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
        .pkgx-blessing{display:flex;align-items:center;justify-content:center;gap:18px;flex-wrap:wrap;margin:26px 0 8px}
        .pkgx-blessing span{color:var(--brand);font-weight:600;font-size:15px;white-space:nowrap}
        .pkgx-fcfs{display:inline-block;background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:30px;padding:6px 22px;font-weight:700;font-size:15px;letter-spacing:.02em}
        .pkgx-title{text-align:center;color:var(--ink);font-weight:700;font-size:26px;line-height:1.3;max-width:880px;margin:18px auto 6px}
        .pkgx-month{display:inline-flex;align-items:center;gap:8px;background:var(--ink);color:#fff;border-radius:30px;padding:7px 20px;font-weight:600;font-size:15px}
        .pkgx-card{background:#fff;border:1px solid #eef0f4;border-radius:18px;box-shadow:0 10px 30px rgba(28,37,65,.08);overflow:hidden}
        .pkgx-flyer{background:#f3f4f6;display:flex;align-items:center;justify-content:center;min-height:100%;padding:14px}
        .pkgx-flyer img{max-width:100%;height:auto;border-radius:12px;display:block}
        .pkgx-flyer .pkgx-noimg{color:#b8bcc6;text-align:center;font-size:14px;padding:60px 10px}
        .pkgx-pad{padding:28px 30px}
        .pkgx-sec-label{text-transform:uppercase;letter-spacing:.08em;font-size:12px;font-weight:700;color:var(--muted);margin-bottom:14px}
        .pkgx-prices{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:8px}
        .pkgx-price{border:1px solid #eef0f4;border-radius:14px;text-align:center;padding:18px 10px;transition:transform .15s,box-shadow .15s,border-color .15s}
        .pkgx-price:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(245,78,24,.12);border-color:#ffd9c9}
        .pkgx-price .occ{font-size:13px;color:var(--muted);font-weight:600;margin-bottom:8px}
        .pkgx-price .amt{font-size:24px;font-weight:800;color:var(--ink);line-height:1.1}
        .pkgx-price .amt small{font-size:14px;font-weight:700;color:var(--brand);vertical-align:top}
        .pkgx-price .call{font-size:15px;font-weight:700;color:var(--brand)}
        .pkgx-desc{color:#374151;font-size:15px;line-height:1.7}
        .pkgx-notes{background:#fafbfc;border:1px solid #eef0f4;border-left:4px solid var(--brand);border-radius:10px;padding:16px 18px;margin-top:18px}
        .pkgx-notes p{margin:0 0 10px;font-size:14px;color:#374151;line-height:1.6}
        .pkgx-notes p:last-child{margin-bottom:0}
        .pkgx-cta{display:inline-flex;align-items:center;gap:10px;font-weight:700;font-size:16px;padding:13px 34px;border-radius:30px;box-shadow:0 8px 18px rgba(245,78,24,.3)}
        @media (max-width:575px){.pkgx-prices{grid-template-columns:1fr}.pkgx-title{font-size:21px}}
    </style>

    <!-- Content -->
    <div class="page-content bg-white pkgx">
        <!-- inner page banner -->
        <section class="inner-banner-wrap">
            <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('packages', asset('assets/images2/Inner-banner-01.png')) }}'); background-position:center;">
                <div class="container">
                    <div class="inner-banner-content">
                        <h1 class="inner-title">PACKAGES <i class="fa fa-plane"></i></h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Packages</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="inner-shape"></div>
        </section>
        <!-- inner page banner END -->
        <div class="container section-sp2">
            <div class="row">
                <div class="col-12">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
            </div>

            @php
                $hasMonth = !empty(@$packages->month_year) && strtotime($packages->month_year) > 0;
                $monthLabel = $hasMonth ? date('F Y', strtotime($packages->month_year)) : null;
                $fmt = function ($v) {
                    return ($v !== null && $v !== '' && (float) $v > 0)
                        ? '<span class="amt"><small>$</small>'.number_format((float) $v).'</span>'
                        : '<span class="call">Call for Price</span>';
                };
            @endphp

            <!-- Blessing + First Come First Serve -->
            <div class="pkgx-blessing">
                <span>Wahe Guru Ji ka Khalsa</span>
                <span class="pkgx-fcfs">First Come First Serve</span>
                <span>Wahe Guru Ji ki Fateh</span>
            </div>

            <h2 class="pkgx-title">Holy Yatra Tour to Nanakana Sahib – Panja Sahib – Kartarpur Sahib and other Gurdwaras in Pakistan</h2>

            @if($hasMonth)
            <div class="text-center mb-4">
                <span class="pkgx-month"><i class="fa fa-calendar"></i> {{ $monthLabel }}</span>
            </div>
            @endif

            <!-- Main card -->
            <div class="pkgx-card mt-2">
                <div class="row g-0">
                    @if(!empty(@$packages->image))
                    <div class="col-lg-5">
                        <div class="pkgx-flyer">
                            <img src="{{ asset('assets/flyers/'.$packages->image) }}" alt="{{ $packages->name }}">
                        </div>
                    </div>
                    <div class="col-lg-7">
                    @else
                    <div class="col-12">
                    @endif
                        <div class="pkgx-pad">
                            <input name="package_id" type="hidden" value="{{ $packages->id }}">

                            <p class="pkgx-sec-label">Package Pricing</p>
                            <div class="pkgx-prices">
                                <div class="pkgx-price">
                                    <div class="occ">Single Occupancy</div>
                                    {!! $fmt(@$packages->single_price) !!}
                                </div>
                                <div class="pkgx-price">
                                    <div class="occ">Double Occupancy</div>
                                    {!! $fmt(@$packages->double_price) !!}
                                </div>
                                <div class="pkgx-price">
                                    <div class="occ">Triple Occupancy</div>
                                    {!! $fmt(@$packages->triple_price) !!}
                                </div>
                            </div>

                            @if(!empty(@$packages->description))
                            <div class="pkgx-desc mt-4">
                                {!! $packages->description !!}
                            </div>
                            @endif

                            <div class="pkgx-notes">
                                <p><b>Note:</b> Above price is valid for New York residents; for all other states please call for the price. <b>IAD PAX add $50</b> in the package price.</p>
                                <p>For Business Class prices please call <b>RASHAD MAHMOOD @ +1 718-908-9464</b>.</p>
                                <p><b>Cancellation of Trip:</b> Airline applicable cancellation charges and $100 service charges applies.</p>
                            </div>

                            <div class="mt-4">
                                <a class="btn pkgx-cta" href="{{ route('package-apply', $packages->id) }}"><i class="fa fa-plane"></i> Book Now</a>
                            </div>
                        </div>
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
