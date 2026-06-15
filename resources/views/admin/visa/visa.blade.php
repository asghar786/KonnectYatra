@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .vs-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;margin-bottom:16px}
    .vs-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden;padding:8px}
    #myTables{width:100%;border-collapse:separate;border-spacing:0}
    #myTables thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:14px 14px;border:0;white-space:nowrap;text-align:left}
    #myTables thead th.tc{text-align:center}
    #myTables tbody td{padding:13px 14px;font-size:13.5px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    #myTables tbody tr:hover{background:#f9fafc}
    #myTables tbody td.tc{text-align:center}
    .vs-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .vs-yid{font-weight:600;color:#3949ab}
    .vs-name{font-weight:600;color:#1f2a44}
    .vs-sub{color:#6b7280;font-size:13px}
    .vs-badge{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap;background:#eef2ff;color:#3949ab}
    .vs-gender{display:inline-block;padding:3px 10px;border-radius:8px;font-size:12px;font-weight:600;background:#f1f2f6;color:#5a6273;text-transform:capitalize}

    .vs-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .vs-actions a{display:inline-flex;align-items:center;gap:6px;border-radius:9px;padding:7px 13px;font-size:12.5px;font-weight:600;text-decoration:none;transition:transform .12s,box-shadow .12s,background .12s;white-space:nowrap}
    .vs-actions a:hover{transform:translateY(-2px)}
    .vs-detail{background:#eaf2ff;color:#1a73e8}
    .vs-detail:hover{background:#1a73e8;color:#fff;box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .vs-cform{background:#fff4d6;color:#9a6b00}
    .vs-cform:hover{background:#f7b205;color:#1f2a44;box-shadow:0 6px 14px rgba(247,178,5,.35)}

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
            <h4 class="breadcrumb-title">Visa</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Visa</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="vs-toolbar">
                <a class="btn btn-info" target="_blank" href="https://visa.nadra.gov.pk/e-visa/authenticate"><i class="fa fa-external-link-alt"></i> Go to Nadra Website</a>
            </div>

            <div class="vs-card">
                <table class="table" id="myTables">
                    <thead>
                        <tr>
                            <th class="tc">Sr #</th>
                            <th class="tc">Yatri #</th>
                            <th>Applicant Name</th>
                            <th>Nationality</th>
                            <th>Date of Birth</th>
                            <th>Place of Birth</th>
                            <th class="tc">Gender</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($visa) > 0)
                        @php $count = 1; @endphp
                        @foreach($visa as $value)
                        <tr>
                            <td class="tc"><span class="vs-idx">{{ $count }}</span></td>
                            <td class="tc"><span class="vs-yid">{{ @$value->yatri_id }}</span></td>
                            <td><span class="vs-name">{{ trim(@$value->last_name.' '.@$value->first_name.' '.@$value->middle_name) }}</span></td>
                            <td>@if(@$value->passport_country)<span class="vs-badge">{{ $value->passport_country }}</span>@else <span class="vs-sub">—</span> @endif</td>
                            <td><span class="vs-sub">{{ @$value->dob ? date('d-m-Y', strtotime($value->dob)) : '—' }}</span></td>
                            <td><span class="vs-sub">{{ @$value->place_birth ?: '—' }}</span></td>
                            <td class="tc">@if(@$value->gender)<span class="vs-gender">{{ $value->gender }}</span>@else — @endif</td>
                            <td>@if(@$value->email)<a href="mailto:{{ $value->email }}" class="vs-sub">{{ $value->email }}</a>@else <span class="vs-sub">—</span> @endif</td>
                            <td><span class="vs-sub">{{ @$value->phone ?: '—' }}</span></td>
                            <td class="tc">
                                <div class="vs-actions">
                                    <a href="{{ url('admin/visa-detail', @$value->id) }}" class="vs-detail"><i class="fa fa-passport"></i> Visa Detail</a>
                                    @if($value->passport_country == 'India')
                                    <a href="{{ url('admin/foreigners_registration', @$value->id) }}" class="vs-cform"><i class="fa fa-file-lines"></i> C-Form</a>
                                    @endif
                                </div>
                            </td>
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
