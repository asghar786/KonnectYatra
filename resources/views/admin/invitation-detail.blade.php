@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .ep-heading{font-family:Archivo,sans-serif;font-weight:800;font-size:18px;letter-spacing:.04em;color:#1f2a44;text-transform:uppercase;margin:0 0 18px;text-align:center}
    .ep-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden;padding:8px}
    #myTables{width:100%;border-collapse:separate;border-spacing:0}
    #myTables thead th{background:#1f2a44;color:#fff;font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.03em;padding:13px 12px;border:0;text-align:left;vertical-align:middle}
    #myTables thead th.tc{text-align:center}
    #myTables tbody td{padding:12px 12px;font-size:13px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:top}
    #myTables tbody tr:hover{background:#f9fafc}
    #myTables tbody td.tc{text-align:center}
    .ep-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .ep-name{font-weight:600;color:#1f2a44}
    .ep-sub{color:#6b7280}
    .ep-pass{font-family:monospace;font-weight:600;color:#3949ab}
    .ep-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#eef2ff;color:#3949ab;white-space:nowrap}
    .ep-muted{color:#9aa1ad}

    /* Top export button group (DataTables) */
    .dt-buttons{display:inline-flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
    .dt-buttons .dt-button{padding:0 !important;background:none !important;border:0 !important;margin:0 !important}
    .dt-buttons .dt-button button,.dt-buttons .btn{
        width:auto !important;border:1px solid #e3e6ec !important;background:#fff !important;color:#3a4458 !important;
        border-radius:10px !important;padding:8px 16px !important;font-size:13px !important;font-weight:600 !important;
        box-shadow:none !important;transition:all .12s !important;
    }
    .dt-buttons .dt-button button:hover,.dt-buttons .btn:hover{background:#1f2a44 !important;color:#fff !important;border-color:#1f2a44 !important}
    .dataTables_wrapper .dataTables_filter input{border:1px solid #e2e2e2;border-radius:20px;padding:6px 14px;outline:none}
    .dataTables_wrapper .dataTables_filter input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .dataTables_wrapper .dataTables_paginate .paginate_button.current{background:#1f2a44 !important;color:#fff !important;border-radius:8px;border:0}
    .dataTables_wrapper .dataTables_paginate .paginate_button{border-radius:8px}
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
            <h3 class="ep-heading">Details Required From Groups / Individuals</h3>

            <div class="ep-card">
                <div class="table-responsive">
                    <table class="table" id="myTables">
                        <thead>
                            <tr>
                                <th class="tc">Sr #</th>
                                <th>Name</th>
                                <th>Father Name</th>
                                <th>Passport No.</th>
                                <th>Nationality</th>
                                <th>PR Status / PR No.</th>
                                <th>Religion</th>
                                <th>Itinerary / Hotel Booking</th>
                                <th>Previous Visits</th>
                                <th>Reference in Pakistan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($detail) > 0)
                            @php $count = 1; @endphp
                            @foreach($detail as $value)
                            <tr>
                                <td class="tc"><span class="ep-idx">{{ $count }}</span></td>
                                <td><span class="ep-name">{{ trim(@$value->last_name.' '.@$value->first_name.' '.@$value->middle_name) }}</span></td>
                                <td><span class="ep-sub">{{ @$value->father_name ?: '—' }}</span></td>
                                <td><span class="ep-pass">{{ @$value->passport ?: '—' }}</span></td>
                                <td>@if(@$value->passport_country)<span class="ep-badge">{{ $value->passport_country }}</span>@else <span class="ep-muted">—</span> @endif</td>
                                <td><span class="ep-sub">@if(@$value->passport_country == "India"){{ @$value->reference_no ?: 'N/A' }}@else N/A @endif</span></td>
                                <td><span class="ep-sub">{{ @$value->religion ?: '—' }}</span></td>
                                <td><span class="ep-sub">{{ !empty(@$value->hotel->name) ? $value->hotel->name : 'N/A' }}</span></td>
                                <td><span class="ep-muted">N/A</span></td>
                                <td><span class="ep-sub">Konnect Yatra USA</span></td>
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
