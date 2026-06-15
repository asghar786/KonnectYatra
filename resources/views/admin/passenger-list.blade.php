@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .dt-buttons { display: none; }

    .rp-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;background:#fff;border:1px solid #eef0f4;border-radius:14px;box-shadow:0 6px 20px rgba(28,37,65,.06);padding:16px 22px;margin-bottom:18px}
    .rp-head .ttl{font-family:Archivo,sans-serif;font-weight:800;font-size:18px;color:#1f2a44;margin:0}
    .rp-head .sub{font-size:13px;color:#8a91a0;margin:2px 0 0}
    .rp-filters{display:flex;flex-wrap:wrap;gap:16px;margin-bottom:18px}
    .rp-filters .fld{flex:1;min-width:220px}
    .rp-filters label{font-size:12px;font-weight:600;color:#5a6273;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px;display:block}
    .rp-filters .form-control{border:1px solid #e2e2e2;border-radius:10px;height:42px}

    .rp-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden;padding:8px}
    #myTables{width:100%;border-collapse:separate;border-spacing:0}
    #myTables thead th{background:#1f2a44;color:#fff;font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.03em;padding:13px 12px;border:0;text-align:left;white-space:nowrap}
    #myTables thead th.tc{text-align:center}
    #myTables tbody td{padding:12px 12px;font-size:13px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    #myTables tbody tr:hover{background:#f9fafc}
    #myTables tbody td.tc{text-align:center}
    .rp-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .rp-name{font-weight:600;color:#1a73e8;text-decoration:none}
    .rp-name:hover{text-decoration:underline}
    .rp-sub{color:#6b7280}
    .rp-pass{font-family:monospace;font-weight:600;color:#3949ab}
    .rp-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#eef2ff;color:#3949ab;white-space:nowrap}
    .rp-port{display:inline-block;padding:3px 9px;border-radius:8px;font-size:11.5px;font-weight:600;background:#f1f2f6;color:#5a6273;white-space:nowrap}
    .rp-muted{color:#9aa1ad}

    .dataTables_wrapper .dataTables_filter input{border:1px solid #e2e2e2;border-radius:20px;padding:6px 14px;outline:none}
    .dataTables_wrapper .dataTables_filter input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .dataTables_wrapper .dataTables_paginate .paginate_button.current{background:#1f2a44 !important;color:#fff !important;border-radius:8px;border:0}
    .dataTables_wrapper .dataTables_paginate .paginate_button{border-radius:8px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Reports</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Reports</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row" id="print-div" style="display: none;">
                <div class="col-lg-12 text-center mb-3">
                    <h4>Konnect Yatra (USA Group)</h4>
                </div>
                <div class="col-lg-12">
                    <p class="mb-0">State: <span id="state_info">All</span></p>
                </div>
                <div class="col-lg-12 mb-3">
                    <p>Ticket Type: <span id="ticket_info">All</span></p>
                </div>
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables1">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Father Name</th>
                                <th scope="col">Citizenship</th>
                                <th scope="col">Passport #</th>
                                <th scope="col">Date of Expiry</th>
                                <th scope="col">Place of Birth</th>
                                <th scope="col">Date of Arrival</th>
                                <th scope="col">Port of Arrival</th>
                                <th scope="col">Date of Departure</th>
                                <th scope="col">Port of Departure</th>
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
                                <td>{{@$package->passport_country}}</td>
                                <td>{{@$package->passport}}</td>
                                <td>{{date("m-d-Y", strtotime(@$package->expiry_date))}}</td>
                                <td>{{@$package->place_birth}}</td>
                                <td>{{@$package->package->package_details->day_1}}</td>
                                <td>Islamabad</td>
                                <td>{{@$package->package->package_details->day_8}}</td>
                                <td>Lahore</td>
                                @php
                                    $count++;
                                @endphp
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="rp-head">
                <div>
                    <h4 class="ttl">Konnect Yatra (USA Group)</h4>
                    <p class="sub">Date of Submission: {{ date("d, F Y") }}</p>
                </div>
                <button type="button" class="btn btn-primary" onclick="printDiv('print-div')"><i class="fa fa-print"></i> Print</button>
            </div>

            <form method="GET" action="{{ url('admin/reports') }}" class="rp-filters filter-form">
                <div class="fld">
                    <label for="state">Select State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="all">-- All --</option>
                        @php $all_state = []; @endphp
                        @if(count($packages) > 0)
                        @foreach(@$packages as $key => $value)
                        @if (!in_array($value['state'], $all_state))
                        @if($value['state'] == @$state)
                        <option value="{{ $value['state'] }}" selected>@if($value['state'] == 'Washington DC') DC / VA /MD @else {{ $value['state'] }} @endif</option>
                        @else
                        <option value="{{ $value['state'] }}">@if($value['state'] == 'Washington DC') DC / VA /MD @else {{ $value['state'] }} @endif</option>
                        @endif
                        @php array_push($all_state, $value['state']); @endphp
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="fld">
                    <label for="ticket_type">Select Ticket Type</label>
                    <select class="form-control" name="ticket_type" id="ticket_type">
                        <option value="all">-- All --</option>
                        <option value="round_trip" @if(@$ticket_type == "round_trip") selected @endif>Round Trip</option>
                        <option value="one_way" @if(@$ticket_type == "one_way") selected @endif>One Way</option>
                        <option value="land_package" @if(@$ticket_type == "land_package") selected @endif>Land Package</option>
                    </select>
                </div>
            </form>

            <div class="rp-card mb-5">
                <div class="table-responsive">
                    <table class="table" id="myTables">
                        <thead>
                            <tr>
                                <th class="tc">Sr #</th>
                                <th>Name</th>
                                <th>Father Name</th>
                                <th>Citizenship</th>
                                <th>Passport #</th>
                                <th>Date of Expiry</th>
                                <th>Place of Birth</th>
                                <th>Date of Arrival</th>
                                <th>Port of Arrival</th>
                                <th>Date of Departure</th>
                                <th>Port of Departure</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($yatries) > 0)
                            @php $count = 1; @endphp
                            @foreach($yatries as $key => $package)
                            <tr>
                                <td class="tc"><span class="rp-idx">{{ $count }}</span></td>
                                <td><a href="{{ url('admin/booking-detail', $package->id) }}" class="rp-name">{{ trim(@$package->last_name.' '.@$package->first_name.' '.@$package->middle_name) }}</a></td>
                                <td><span class="rp-sub">{{ @$package->father_name ?: '—' }}</span></td>
                                <td>@if(@$package->passport_country)<span class="rp-badge">{{ $package->passport_country }}</span>@else <span class="rp-muted">—</span> @endif</td>
                                <td><span class="rp-pass">{{ @$package->passport ?: '—' }}</span></td>
                                <td><span class="rp-sub">{{ @$package->expiry_date ?: '—' }}</span></td>
                                <td><span class="rp-sub">{{ @$package->place_birth ?: '—' }}</span></td>
                                <td><span class="rp-sub">{{ @$package->package->package_details->day_1 ?: '—' }}</span></td>
                                <td><span class="rp-port">Islamabad</span></td>
                                <td><span class="rp-sub">{{ @$package->package->package_details->day_8 ?: '—' }}</span></td>
                                <td><span class="rp-port">Lahore</span></td>
                            </tr>
                            @php $count++; @endphp
                            @endforeach
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
        $(document).ready(function () {
            $("#state_info").text($("#state option:selected").text());
            $("#ticket_info").text($("#ticket_type option:selected").text());

            $(document).on("change", "#state, #ticket_type", function () {
                $(".filter-form").submit();
                $("#state_info").text($("#state option:selected").val());
                $("#ticket_info").text($("#ticket_type option:selected").val());
            });
        });
        function printDiv(divName) {

            var printContents = document.getElementById(divName).innerHTML;

            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

                // document.body.style.marginTop="-45px";

            window.print();

            document.body.innerHTML = originalContents;

            location.reload();

        }
    </script>
@endsection