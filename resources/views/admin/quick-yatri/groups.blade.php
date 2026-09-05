{{-- Group Manifest — every applicant with a departure airport and both travel
     dates, split into one printable block per departure city.

     Fully automatic: same departure_date + return_date + departure_airport_code
     is the same group. Nobody is assigned by hand, so a group re-forms on its
     own when any of those three is edited on the sheet.

     Printed from the browser, like the rest of Quick Yatri — one group per
     printed page. --}}
@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .gm-head{display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:14px; background:#fff; border:1px solid #eef0f4; border-radius:14px; box-shadow:0 6px 20px rgba(28,37,65,.06); padding:16px 22px; margin-bottom:18px}
    .gm-head .ttl{font-family:Archivo,sans-serif; font-weight:800; font-size:18px; color:#1f2a44; margin:0}
    .gm-head .sub{font-size:13px; color:#8a91a0; margin:3px 0 0}
    .gm-actions{display:flex; gap:10px; flex-wrap:wrap}
    .gm-btn{display:inline-flex; align-items:center; gap:8px; border:none; border-radius:24px; padding:10px 20px; font-size:13.5px; font-weight:600; text-decoration:none; cursor:pointer; transition:transform .12s}
    .gm-btn:hover{transform:translateY(-2px)}
    .gm-btn.print{background:#f54e18; color:#fff; box-shadow:0 6px 16px rgba(245,78,24,.26)}
    .gm-btn.print:hover{color:#fff}
    .gm-btn.back{background:#eef1f6; color:#5a6273}
    .gm-btn.back:hover{color:#5a6273}

    /* One group = one block, and one printed page. */
    .gm-group{background:#fff; border:1px solid #d7dce6; border-radius:10px; overflow:hidden; margin-bottom:22px}
    .gm-title{background:#1a3fa0; color:#fff; text-align:center; font-family:Archivo,sans-serif; font-weight:800; font-size:15px; letter-spacing:.02em; padding:11px 14px; text-transform:uppercase}
    .gm-contact{text-align:center; font-size:12.5px; color:#1f2a44; background:#eef2fb; padding:8px 14px; border-bottom:1px solid #d7dce6}
    .gm-contact b{color:#1a3fa0}
    .gm-count{display:inline-block; background:#fff; border:1px solid #c9d4ea; border-radius:20px; padding:1px 10px; font-size:11.5px; font-weight:700; color:#1a3fa0; margin-left:8px}

    .gm-table{width:100%; border-collapse:collapse; font-size:12.5px}
    .gm-table th{background:#f2f5fa; color:#1f2a44; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.03em; padding:9px 8px; border:1px solid #c9d4ea; white-space:nowrap; text-align:left}
    .gm-table td{padding:8px; border:1px solid #d7dce6; color:#2c3446; vertical-align:middle; white-space:nowrap}
    .gm-table tbody tr:nth-child(even){background:#fafbfd}
    .gm-sr{text-align:center; font-weight:700; color:#5a6273; width:46px}
    .gm-pass{font-family:monospace; font-weight:600; color:#3949ab}
    .gm-sector{font-weight:700; color:#1a3fa0; font-size:12px}
    .gm-muted{color:#9aa1ad}

    .gm-empty{background:#fff; border:1px dashed #d7dce6; border-radius:12px; padding:40px; text-align:center; color:#8a91a0; font-size:14.5px; line-height:1.6}
    .gm-empty b{color:#5a6273}

    /* The applications that cannot be grouped yet, so the gaps are visible
       without hunting through the list for them. */
    .gm-missing{background:#fff8ec; border:1px solid #f3ddb8; border-radius:12px; padding:16px 20px; margin-bottom:22px; font-size:13px; color:#7a5410}
    .gm-missing h6{margin:0 0 8px; font-size:13.5px; font-weight:700; color:#8a5a08}
    .gm-missing ul{margin:0; padding-left:18px; line-height:1.7}
    .gm-missing a{color:#8a5a08; text-decoration:underline}

    @media print {
        .ttr-sidebar, .ttr-header, .db-breadcrumb, .gm-head, .gm-missing, .ttr-overlay { display:none !important; }
        .ttr-wrapper, .main-body, .container-fluid { margin:0 !important; padding:0 !important; }
        .gm-group{border:none; margin:0; page-break-after:always; break-after:page}
        .gm-group:last-of-type{page-break-after:auto; break-after:auto}
        .gm-title{-webkit-print-color-adjust:exact; print-color-adjust:exact}
        .gm-contact{-webkit-print-color-adjust:exact; print-color-adjust:exact}
        .gm-table th{-webkit-print-color-adjust:exact; print-color-adjust:exact}
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Group Manifest</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ route('quick-yatri-dashboard') }}">Quick Yatri</a></li>
                <li>Group Manifest</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="gm-head">
                <div>
                    <h4 class="ttl">Group Manifest</h4>
                    <p class="sub">
                        Everyone travelling together, grouped by the city they fly from &mdash;
                        {{ $groups->count() }} {{ $groups->count() === 1 ? 'group' : 'groups' }},
                        {{ $groups->sum(function ($g) { return $g['rows']->count(); }) }} {{ $groups->sum(function ($g) { return $g['rows']->count(); }) === 1 ? 'traveller' : 'travellers' }}.
                    </p>
                </div>
                <div class="gm-actions">
                    <a href="{{ route('quick-yatri-dashboard') }}" class="gm-btn back"><i class="fa fa-arrow-left"></i> Back</a>
                    <button type="button" class="gm-btn print" onclick="window.print()"><i class="fa fa-print"></i> Print / Save as PDF</button>
                </div>
            </div>

            @if($missing->count())
                <div class="gm-missing">
                    <h6><i class="fa fa-exclamation-triangle"></i> {{ $missing->count() }} {{ $missing->count() === 1 ? 'application is' : 'applications are' }} not in any group yet</h6>
                    <p style="margin:0 0 8px">A traveller joins a group automatically once their sheet has a departure airport <em>and</em> both travel dates. These are missing at least one:</p>
                    <ul>
                        @foreach($missingShown as $row)
                            @php
                                $needs = [];
                                if (!$row->departure_airport_code) { $needs[] = 'departure airport'; }
                                if (!$row->departure_date) { $needs[] = 'departure date'; }
                                if (!$row->return_date) { $needs[] = 'return date'; }
                            @endphp
                            <li><a href="{{ route('quick-yatri-edit', $row->id) }}">{{ $row->applicant_name ?: 'Unnamed application #' . $row->id }}</a> &mdash; needs {{ implode(', ', $needs) }}</li>
                        @endforeach
                        @if($missing->count() > $missingShown->count())
                            <li>&hellip; and {{ $missing->count() - $missingShown->count() }} more, on the <a href="{{ route('quick-yatri') }}">applications list</a>.</li>
                        @endif
                    </ul>
                </div>
            @endif

            @forelse($groups as $group)
                <div class="gm-group">
                    <div class="gm-title">
                        {{ $group['city'] }} ({{ $group['airport_code'] }}) Group
                        leaving {{ $group['departure_date']->format('j F') }}
                        and returning {{ $group['return_date']->format('j F') }}
                    </div>
                    <div class="gm-contact">
                        EMAIL ADDRESS: <b>{{ \App\Models\QuickYatri::CONTACT_EMAIL }}</b>
                        &nbsp; Tel: <b>{{ \App\Models\QuickYatri::CONTACT_PHONE }}</b>
                        &nbsp; Pakistan No. <b>{{ $pakistanContact }}</b>
                        <span class="gm-count">{{ $group['rows']->count() }} {{ $group['rows']->count() === 1 ? 'traveller' : 'travellers' }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="gm-table">
                            <thead>
                                <tr>
                                    <th class="gm-sr">SR#</th>
                                    <th>First Name</th>
                                    <th>Middle</th>
                                    <th>Last</th>
                                    <th>Date of Birth</th>
                                    <th>Citizenship</th>
                                    <th>Passport #</th>
                                    <th>Sector</th>
                                    <th>Sector</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- SR# restarts at 1 in every group: it numbers the
                                     travellers on this flight, not the report. --}}
                                @foreach($group['rows'] as $i => $row)
                                    @php $parts = $row->nameParts(); @endphp
                                    <tr>
                                        <td class="gm-sr">{{ $i + 1 }}</td>
                                        <td>{{ $parts['first'] }}</td>
                                        <td>{{ $parts['middle'] ?: '' }}</td>
                                        <td>{{ $parts['last'] ?: '' }}</td>
                                        <td>{{ $row->stamp('date_of_birth') ?: '' }}</td>
                                        <td>{{ $row->citizenship ?: '' }}</td>
                                        <td class="gm-pass">{{ $row->passport_no ?: '' }}</td>
                                        <td class="gm-sector">{{ $row->outboundSector() }}</td>
                                        <td class="gm-sector">{{ $row->returnSector() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="gm-empty">
                    <p style="margin:0 0 6px"><b>No groups yet.</b></p>
                    <p style="margin:0">A traveller appears here once their sheet carries a departure airport and both travel dates &mdash; the three fields on the &ldquo;Travelling from&rdquo; line. Fill those in on an application and it joins a group automatically.</p>
                </div>
            @endforelse
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
