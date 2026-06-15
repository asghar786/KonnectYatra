@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .al-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden;padding:8px}
    #myTables{width:100%;border-collapse:separate;border-spacing:0}
    #myTables thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:14px 14px;border:0;white-space:nowrap;text-align:left}
    #myTables thead th.tc{text-align:center}
    #myTables tbody td{padding:13px 14px;font-size:13.5px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    #myTables tbody tr:hover{background:#f9fafc}
    #myTables tbody td.tc{text-align:center}
    .al-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .al-name{font-weight:600;color:#1f2a44}
    .al-sub{color:#6b7280;font-size:13px}
    .al-pass{font-family:monospace;font-weight:600;color:#3949ab}

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
            <h4 class="breadcrumb-title">Airline List</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Airline List</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="al-card">
                <table class="table" id="myTables">
                    <thead>
                        <tr>
                            <th class="tc">Sr #</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Passport No.</th>
                            <th>Date of Birth</th>
                            <th>Special Request</th>
                            <th>Food Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($yatri) > 0)
                        @php $count = 1; @endphp
                        @foreach($yatri as $value)
                        <tr>
                            <td class="tc"><span class="al-idx">{{ $count }}</span></td>
                            <td><span class="al-name">{{ @$value->last_name ?: '—' }}</span></td>
                            <td><span class="al-sub">{{ @$value->first_name ?: '—' }}</span></td>
                            <td><span class="al-sub">{{ @$value->middle_name ?: '—' }}</span></td>
                            <td><span class="al-pass">{{ @$value->passport ?: '—' }}</span></td>
                            <td><span class="al-sub">{{ @$value->dob ? date('d-m-Y', strtotime($value->dob)) : '—' }}</span></td>
                            <td><span class="al-sub">{{ @$value->special_request ?: '—' }}</span></td>
                            <td><span class="al-sub">{{ @$value->food_type ?: '—' }}</span></td>
                        </tr>
                        @php $count++; @endphp
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
