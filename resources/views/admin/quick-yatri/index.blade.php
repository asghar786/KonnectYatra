{{-- Quick Yatri — every application captured from the Konnect.US sheet. --}}
@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .qy-toolbar{display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:14px; margin-bottom:18px}
    .qy-toolbar-left{display:flex; align-items:center; gap:10px; flex-wrap:wrap}
    .qy-total{display:inline-flex; align-items:center; gap:8px; background:#1f2a44; color:#fff; font-size:13px; font-weight:600; padding:9px 18px; border-radius:24px}
    .qy-cta{display:inline-flex; align-items:center; gap:8px; border:none; border-radius:24px; padding:10px 20px; font-size:13.5px; font-weight:600; text-decoration:none; cursor:pointer; transition:transform .12s, box-shadow .12s}
    .qy-cta:hover{transform:translateY(-2px)}
    .qy-cta.add{background:#f54e18; color:#fff; box-shadow:0 6px 16px rgba(245,78,24,.26)}
    .qy-cta.add:hover{color:#fff}
    .qy-cta.dl{background:#eaf2ff; color:#1a3fa0; border:1px solid #d4e2ff}
    .qy-cta.dl:hover{background:#1a3fa0; color:#fff}
    .qy-search{position:relative; flex:1; min-width:240px; max-width:380px}
    .qy-search i{position:absolute; top:50%; left:14px; transform:translateY(-50%); color:#aaa; font-size:14px}
    .qy-search input{width:100%; padding:11px 14px 11px 38px; border:1px solid #e2e2e2; border-radius:30px; font-size:14px; outline:none; transition:.15s}
    .qy-search input:focus{border-color:#f54e18; box-shadow:0 0 0 3px rgba(245,78,24,.12)}

    .qy-card{background:#fff; border:1px solid #eef0f4; border-radius:16px; box-shadow:0 8px 28px rgba(28,37,65,.07); overflow:hidden}
    .qy-table{width:100%; border-collapse:separate; border-spacing:0; margin:0}
    .qy-table thead th{background:#1f2a44; color:#fff; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:.04em; padding:15px 18px; text-align:left; white-space:nowrap; border:none}
    .qy-table thead th.tc{text-align:center}
    /* Sortable headers. The caret is always in the box — faint until the column
       is the one being sorted on — so a click never changes the header's width
       and shunts the whole table sideways. */
    .qy-table thead th.srt{cursor:pointer; user-select:none}
    .qy-table thead th.srt:hover{background:#27334f}
    .qy-table thead th.srt:focus-visible{outline:2px solid #f54e18; outline-offset:-2px}
    {{-- The arrows are the characters themselves, not CSS \XXXX escapes. An
         escape here is one mangled backslash away from printing its own hex
         digits in the header — which is exactly what shipped earlier today,
         where every column read "95" and the sorted one read "91". The file
         is UTF-8 and the layout declares it, so the glyph is the safer literal. --}}
    .qy-table thead th.srt::after{content:'↕'; margin-left:7px; font-size:11px; opacity:.4}
    .qy-table thead th.srt[aria-sort=ascending]::after{content:'↑'; opacity:1}
    .qy-table thead th.srt[aria-sort=descending]::after{content:'↓'; opacity:1}
    .qy-table thead th.srt[aria-sort]{background:#27334f}
    .qy-table tbody td{padding:14px 18px; font-size:14px; color:#2c3446; border-bottom:1px solid #f0f2f6; vertical-align:middle}
    .qy-table tbody tr:last-child td{border-bottom:none}
    .qy-table tbody tr:hover{background:#f9fafc}
    .qy-table tbody td.tc{text-align:center}
    .qy-idx{display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:8px; background:#eef1f6; color:#5a6273; font-size:12px; font-weight:700}
    .qy-name{font-weight:600; color:#1f2a44}
    .qy-name small{display:block; color:#9aa0ac; font-size:11.5px; font-weight:400}
    .qy-link{display:flex; width:fit-content; align-items:center; gap:7px; color:#1f2a44; text-decoration:none}
    .qy-link i{color:#f54e18}
    .qy-link:hover{color:#1a73e8}
    .qy-link.mail{color:#6b7280; font-size:12.5px; margin-top:3px}
    .qy-sub{color:#6b7280; font-size:13px}
    .qy-trip{display:inline-block; font-weight:700; color:#2d1b69; background:#eef0ff; border-radius:20px; padding:4px 12px; font-size:12px; white-space:nowrap}
    .qy-amt{font-weight:700; color:#1f2a44; font-variant-numeric:tabular-nums; white-space:nowrap}
    .qy-amt small{display:block; font-weight:400; color:#9aa0ac; font-size:11px}
    .qy-chip{display:inline-block; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; background:#e7f8ec; color:#157f3d; margin:1px 2px 1px 0; white-space:nowrap}
    /* The option pills sit directly under the Trip pill, so they are teal and
       green against its purple — three chips in one cell have to be tellable
       apart at a glance, not read as one run. */
    .qy-chip.wc{background:#d9f2ee; color:#0f766e}
    .qy-chip.veg{background:#e7f8ec; color:#157f3d}
    .qy-opts{display:block; margin-top:5px}
    /* Travelling From: the airport code leads, its city and the travel dates
       sit under it. A row with no dates cannot be grouped yet, so it says so
       here rather than only on the Group Manifest. */
    .qy-from{display:inline-block; font-family:monospace; font-weight:700; font-size:12.5px; letter-spacing:.04em; color:#1a3fa0; background:#eef2fb; border:1px solid #d7e2f5; border-radius:7px; padding:2px 9px}
    .qy-dates{display:block; margin-top:3px; font-size:11.5px; color:#5a6273; white-space:nowrap}
    .qy-nodates{display:block; margin-top:3px; font-size:11px; font-weight:600; color:#a97708; white-space:nowrap}
    .qy-pp{font-variant-numeric:tabular-nums}

    .qy-actions{display:flex; gap:8px; justify-content:center; align-items:center}
    .qy-btn{display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:10px; border:none; cursor:pointer; font-size:14px; transition:transform .12s, box-shadow .12s, background .12s; text-decoration:none}
    .qy-btn:hover{transform:translateY(-2px)}
    .qy-btn.prn{background:#eef0ff; color:#2d1b69}
    .qy-btn.prn:hover{background:#2d1b69; color:#fff; box-shadow:0 6px 14px rgba(45,27,105,.3)}
    .qy-btn.fc{background:#fff3d6; color:#a16207}
    .qy-btn.fc:hover{background:#a16207; color:#fff; box-shadow:0 6px 14px rgba(161,98,7,.3)}
    .qy-btn.edt{background:#eaf2ff; color:#1a73e8}
    .qy-btn.edt:hover{background:#1a73e8; color:#fff; box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .qy-btn.del{background:#feeceb; color:#e23b2e}
    .qy-btn.del:hover{background:#e23b2e; color:#fff; box-shadow:0 6px 14px rgba(226,59,46,.3)}
    .qy-empty{padding:40px; text-align:center; color:#999; font-size:15px}
    .qy-blank-picker{display:inline-flex; align-items:center; gap:8px}
    .qy-blank-picker select{border:1px solid #d4e2ff; border-radius:24px; padding:9px 14px; font-size:13px; color:#1a3fa0; background:#eaf2ff; outline:none; max-width:190px}

    /* The price grid, live in the toolbar: OW / RT / LP as they stand today,
       with the button that opens the modal to move them. */
    .qy-prices{display:inline-flex; align-items:center; background:#fff; border:1px solid #e3e7ef; border-radius:24px; padding:3px 3px 3px 4px; box-shadow:0 2px 10px rgba(28,37,65,.07)}
    .qy-prices .p{display:inline-flex; align-items:baseline; gap:6px; padding:6px 12px; white-space:nowrap; border-right:1px solid #eef0f4}
    .qy-prices .p em{font-style:normal; font-size:10.5px; font-weight:700; letter-spacing:.07em; color:#9aa0ac}
    .qy-prices .p b{font-size:13.5px; font-weight:700; color:#1f2a44; font-variant-numeric:tabular-nums}
    .qy-prices .upd{border:none; cursor:pointer; background:#1f2a44; color:#fff; border-radius:20px; padding:7px 15px; font-size:11.5px; font-weight:700; letter-spacing:.06em; margin-left:6px; transition:background .12s}
    .qy-prices .upd:hover{background:#f54e18}

    /* The Amount cell is the way in to one applicant's own price. */
    .qy-amt-btn{border:none; background:none; padding:0; cursor:pointer; text-align:left; display:flex; align-items:center; gap:7px; border-radius:8px; transition:opacity .12s}
    .qy-amt-btn:hover{opacity:.65}
    .qy-chip.custom{background:#fff3e6; color:#a24a06}
    .qy-note-sm{display:block; color:#9aa0ac; font-size:11px; margin-top:3px; max-width:190px}

    /* Self-contained modal — the Quick Yatri screens are hand-styled rather
       than themed, and this must not depend on the admin theme's Bootstrap. */
    .qy-modal{position:fixed; inset:0; z-index:2000; display:none; align-items:center; justify-content:center; padding:20px}
    .qy-modal.open{display:flex}
    .qy-modal-back{position:absolute; inset:0; background:rgba(18,24,40,.55)}
    .qy-modal-box{position:relative; width:100%; max-width:530px; max-height:90vh; display:flex; flex-direction:column; background:#fff; border-radius:16px; box-shadow:0 26px 60px rgba(15,23,42,.3); overflow:hidden}
    .qy-modal-head{display:flex; align-items:flex-start; justify-content:space-between; gap:14px; padding:20px 22px 14px; border-bottom:1px solid #f0f2f6}
    .qy-modal-head h5{margin:0; font-size:17px; font-weight:700; color:#1f2a44}
    .qy-modal-head p{margin:5px 0 0; font-size:12.5px; color:#8b93a3; line-height:1.45}
    .qy-modal-x{border:none; background:#f2f4f8; color:#5a6273; width:30px; height:30px; border-radius:9px; cursor:pointer; font-size:15px; line-height:1; flex:none}
    .qy-modal-x:hover{background:#e6e9f0}
    .qy-modal-body{padding:18px 22px; overflow:auto}
    .qy-modal-foot{display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:14px 22px 18px; border-top:1px solid #f0f2f6; flex-wrap:wrap}
    .qy-fld{display:flex; align-items:center; gap:12px; padding:9px 0; border-bottom:1px dashed #eef0f4}
    .qy-fld:last-of-type{border-bottom:none}
    .qy-fld label{flex:1; font-size:13.5px; color:#2c3446; font-weight:600; margin:0}
    .qy-fld label small{display:block; font-weight:400; color:#9aa0ac; font-size:11.5px; margin-top:2px}
    .qy-money{position:relative; flex:none; width:132px}
    .qy-money span{position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9aa0ac; font-size:13.5px}
    .qy-money input{width:100%; padding:9px 12px 9px 25px; border:1px solid #e2e6ee; border-radius:10px; font-size:14px; font-weight:600; color:#1f2a44; outline:none; font-variant-numeric:tabular-nums}
    .qy-money input:focus{border-color:#f54e18; box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .qy-text{width:100%; padding:10px 12px; border:1px solid #e2e6ee; border-radius:10px; font-size:13.5px; color:#2c3446; outline:none}
    .qy-text:focus{border-color:#f54e18; box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .qy-area{min-height:84px; resize:vertical; line-height:1.5; font-family:inherit}
    .qy-note-hint{margin:8px 0 0; font-size:12px; color:#9aa0ac; line-height:1.5}
    .qy-note-hint b{color:#5a6273; font-variant-numeric:tabular-nums}
    .qy-note-hint.over b{color:#c0392b}
    .qy-lbl{display:block; font-size:12px; font-weight:700; letter-spacing:.04em; text-transform:uppercase; color:#8b93a3; margin:16px 0 7px}
    .qy-tickline{display:flex; align-items:flex-start; gap:9px; margin-top:16px; background:#f7f9fc; border:1px solid #eef1f6; border-radius:10px; padding:11px 13px}
    .qy-tickline input{margin-top:2px; flex:none}
    .qy-tickline span{font-size:12.5px; color:#5a6273; line-height:1.45}
    .qy-mbtn{border:none; border-radius:10px; padding:10px 20px; font-size:13.5px; font-weight:600; cursor:pointer; transition:transform .12s}
    .qy-mbtn:hover{transform:translateY(-1px)}
    .qy-mbtn.save{background:#f54e18; color:#fff; box-shadow:0 6px 16px rgba(245,78,24,.26)}
    .qy-mbtn.ghost{background:#eef1f6; color:#5a6273}
    .qy-mbtn.reset{background:#fff; color:#a24a06; border:1px solid #f3d9c0; margin-right:auto}
    .qy-std{background:#f7f9fc; border:1px solid #eef1f6; border-radius:10px; padding:10px 13px; font-size:12.5px; color:#5a6273; line-height:1.5}
    .qy-std b{color:#1f2a44}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Applications</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ route('quick-yatri-dashboard') }}">Quick Yatri</a></li>
                <li>Applications</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="qy-toolbar">
                <div class="qy-toolbar-left">
                    <a href="{{ route('quick-yatri-create') }}" class="qy-cta add"><i class="fa fa-plus"></i> Add New</a>
                    <a href="{{ route('quick-yatri-groups') }}" class="qy-cta dl"><i class="fa fa-users"></i> Group Manifest</a>
                    <div class="qy-blank-picker">
                        <select id="qyBlankAirport" title="Pre-fill the departure airport on the blank form">
                            <option value="">Blank (write in)</option>
                            @foreach($airportGroups as $state => $airports)
                                <optgroup label="{{ $state }}">
                                    @foreach($airports as $code => $airport)
                                        <option value="{{ $code }}">{{ $code }} &mdash; {{ $airport[0] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <a href="{{ route('quick-yatri-blank') }}" target="_blank" rel="noopener" id="qyBlankLink" class="qy-cta dl"><i class="fa fa-download"></i> Download Blank Form</a>
                    </div>
                    <span class="qy-total"><i class="fa fa-bolt"></i> {{ count($rows) }} Applications</span>
                    <div class="qy-prices">
                        <span class="p"><em>OW</em><b>{{ \App\Models\QuickYatri::money($prices['one_way_5star']['amount']) }}</b></span>
                        <span class="p"><em>RT</em><b>{{ \App\Models\QuickYatri::money($prices['round_trip_5star']['amount']) }}</b></span>
                        <span class="p"><em>LP</em><b>{{ \App\Models\QuickYatri::money($prices['round_trip_land']['amount']) }}</b></span>
                        <button type="button" class="upd" id="qyPricesOpen">UPDATE</button>
                    </div>
                </div>
                <div class="qy-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="qySearch" placeholder="Search by name, phone, email, passport, city&hellip;" autocomplete="off">
                </div>
            </div>

            <div class="qy-card">
                <table class="qy-table">
                    <thead>
                        <tr>
                            {{-- # is the position in the table, not a value, so it
                                 renumbers after a sort rather than being sortable
                                 itself. Action holds no data at all. --}}
                            <th class="tc">#</th>
                            <th class="srt" data-type="text" tabindex="0" role="columnheader">Applicant</th>
                            <th class="srt" data-type="text" tabindex="0" role="columnheader">Contact</th>
                            <th class="srt" data-type="text" tabindex="0" role="columnheader">Passport</th>
                            <th class="srt" data-type="text" tabindex="0" role="columnheader">Trip</th>
                            <th class="srt" data-type="num" tabindex="0" role="columnheader">Amount</th>
                            <th class="srt" data-type="text" tabindex="0" role="columnheader">Travelling From</th>
                            <th class="srt" data-type="num" tabindex="0" role="columnheader" aria-sort="ascending">Entered On</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $i => $r)
                        {{-- The departure airport and its city are searchable too, so
                             "PHL" or "philadelphia" pulls up everyone on that flight. --}}
                        <tr class="qy-row" data-search="{{ strtolower(trim($r->applicant_name.' '.$r->father_name.' '.$r->cell_phone.' '.$r->email.' '.$r->passport_no.' '.$r->city.' '.$r->state_zip.' '.$r->nearest_gurdwara.' '.$r->departure_airport_code.' '.($r->departure_airport_code ? \App\Support\UsAirports::city($r->departure_airport_code) : ''))) }}">
                            <td class="tc"><span class="qy-idx">{{ $i + 1 }}</span></td>
                            {{-- Each cell carries the key it sorts on, because what
                                 it prints will not sort: a name sits under a father's
                                 name, an amount under a "$", a date under "25 Aug 2026".
                                 The header script reads data-sort and falls back to the
                                 cell's own text. --}}
                            <td data-sort="{{ $r->applicant_name }}">
                                <span class="qy-name">{{ $r->applicant_name }}
                                    @if($r->father_name)<small>{{ $r->parentPrefix() }} {{ $r->father_name }}</small>@endif
                                </span>
                            </td>
                            <td data-sort="{{ trim($r->cell_phone.' '.$r->email) }}">
                                @if($r->cell_phone)<a class="qy-link" href="tel:{{ $r->cell_phone }}"><i class="fa fa-phone"></i> {{ $r->cell_phone }}</a>@endif
                                @if($r->email)<a class="qy-link mail" href="mailto:{{ $r->email }}"><i class="fa fa-envelope"></i> {{ $r->email }}</a>@endif
                                @if(!$r->cell_phone && !$r->email)<span class="qy-sub">&mdash;</span>@endif
                            </td>
                            <td data-sort="{{ $r->passport_no }}">
                                @if($r->passport_no)
                                    <span class="qy-pp">{{ $r->passport_no }}</span>
                                    @if($r->date_of_expiry)<small class="qy-sub" style="display:block">exp {{ $r->stamp('date_of_expiry') }}</small>@endif
                                @else
                                    <span class="qy-sub">&mdash;</span>
                                @endif
                            </td>
                            {{-- The trip, and under it whatever this applicant asked
                                 for on the sheet's three option bars — the options
                                 had a column of their own until 2026-09-05, but it
                                 was empty on nearly every row while the Trip column
                                 had space going spare. Different colours from the
                                 trip pill above them, so the two do not read as one
                                 run of chips. --}}
                            <td data-sort="{{ $r->trip_option ? $r->tripLabel() : '' }}">
                                @if($r->trip_option)<span class="qy-trip">{{ $r->tripLabel() }}</span>@else <span class="qy-sub">&mdash;</span> @endif
                                @if($r->wheelchair_airport || $r->wheelchair_full_trip || $r->meal_vegetarian)
                                    <span class="qy-opts">
                                        @if($r->wheelchair_airport)<span class="qy-chip wc">&#9855; Wheelchair &mdash; airport</span>@endif
                                        @if($r->wheelchair_full_trip)<span class="qy-chip wc">&#9855; Wheelchair &mdash; full trip</span>@endif
                                        @if($r->meal_vegetarian)<span class="qy-chip veg">&#127860; Vegetarian</span>@endif
                                    </span>
                                @endif
                            </td>
                            <td data-sort="{{ $r->total_amount !== null ? (int) round($r->total_amount) : '' }}">
                                {{-- Click the amount to price this applicant on their own terms —
                                     group size, departure airport, a rate agreed at an event. --}}
                                <button type="button" class="qy-amt-btn qy-price-row"
                                        data-id="{{ $r->id }}"
                                        data-name="{{ $r->applicant_name }}"
                                        data-trip="{{ $r->trip_option ? $r->tripLabel() : '' }}"
                                        data-standard="{{ $r->trip_option && isset($prices[$r->trip_option]) ? (int) round($prices[$r->trip_option]['amount']) : '' }}"
                                        data-amount="{{ $r->package_amount !== null ? (int) round($r->package_amount) : '' }}"
                                        data-note="{{ $r->price_note }}"
                                        data-custom="{{ $r->custom_price ? 1 : 0 }}"
                                        title="Set this applicant&rsquo;s price">
                                    @if($r->total_amount !== null)
                                        <span class="qy-amt">${{ number_format($r->total_amount) }}
                                            @if($r->wheelchair_full_trip)<small>incl. wheelchair</small>@endif
                                        </span>
                                    @else
                                        <span class="qy-sub">&mdash;</span>
                                    @endif
                                    @if($r->custom_price)<span class="qy-chip custom">Custom</span>@endif
                                </button>
                                @if($r->custom_price && $r->price_note)<small class="qy-note-sm">{{ $r->price_note }}</small>@endif
                            </td>
                            {{-- Where and when they fly — the three values the Group
                                 Manifest buckets on. Sorted by airport then departure
                                 date, so the list clusters into the same groups the
                                 manifest prints. Replaced the Options column
                                 (wheelchair / vegetarian) on 2026-09-05: the
                                 wheelchair surcharge still shows under Amount, and
                                 nothing was ticked on any application. --}}
                            <td data-sort="{{ trim(($r->departure_airport_code ?: 'ZZZ') . ' ' . ($r->departure_date ? $r->departure_date->format('Y-m-d') : '')) }}">
                                @if($r->departure_airport_code)
                                    <span class="qy-from">{{ strtoupper($r->departure_airport_code) }}</span>
                                    <small class="qy-sub" style="display:block; margin-top:3px">{{ \App\Support\UsAirports::city($r->departure_airport_code) }}</small>
                                    @if($r->departure_date && $r->return_date)
                                        <small class="qy-dates">{{ $r->departure_date->format('j M') }} &rarr; {{ $r->return_date->format('j M Y') }}</small>
                                    @else
                                        <small class="qy-nodates">no travel dates</small>
                                    @endif
                                @else
                                    <span class="qy-sub">&mdash;</span>
                                @endif
                            </td>
                            <td data-sort="{{ optional($r->created_at)->getTimestamp() }}"><span class="qy-sub">{{ optional($r->created_at)->format('d M Y, h:i A') ?: '—' }}</span></td>
                            <td class="tc">
                                <div class="qy-actions">
                                    <a href="{{ route('quick-yatri-print', $r->id) }}" target="_blank" rel="noopener" class="qy-btn prn" title="Print / Save as PDF"><i class="fa fa-print"></i></a>
                                    {{-- Only a yatri on an Indian passport carries Form 'C'. --}}
                                    @if($r->needsFormC())
                                        <a href="{{ route('quick-yatri-form-c', $r->id) }}" class="qy-btn fc" title="Download Form C (Indian passport)"><i class="fa fa-id-card"></i></a>
                                    @endif
                                    <a href="{{ route('quick-yatri-edit', $r->id) }}" class="qy-btn edt" title="Edit"><i class="fa fa-pen"></i></a>
                                    <a href="{{ route('quick-yatri-delete', $r->id) }}" class="qy-btn del" title="Delete" onclick="return confirm('Delete this application? This cannot be undone.')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="qy-empty">No applications yet. Use <strong>Add New</strong> to key one in, or <strong>Download Blank Form</strong> to print a sheet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="qy-empty" id="qyNoResults" style="display:none;">No applications match your search.</div>
            </div>
        </div>
    </div>
</main>

{{-- Update the grid: One-Way / Round Trip / Land Package, and the one
     surcharge the sheet carries. Saved to site_settings, so the office moves a
     fare without a deploy and the printed blank sheet picks it up at once. --}}
<div class="qy-modal" id="qyPricesModal" role="dialog" aria-modal="true" aria-labelledby="qyPricesTitle">
    <div class="qy-modal-back" data-qy-close></div>
    <div class="qy-modal-box">
        <form method="POST" action="{{ route('quick-yatri-prices') }}">
            @csrf
            <div class="qy-modal-head">
                <div>
                    <h5 id="qyPricesTitle">Update prices</h5>
                    <p>The standard price of each row of the sheet&rsquo;s grid &mdash; new applications are priced from these, and the printed blank form shows them straight away. The sheet&rsquo;s first printed condition is edited here too.</p>
                </div>
                <button type="button" class="qy-modal-x" data-qy-close aria-label="Close">&times;</button>
            </div>
            <div class="qy-modal-body">
                <div class="qy-fld">
                    <label>OW &mdash; One-Way Trip<small>5-Star Package</small></label>
                    <div class="qy-money"><span>$</span><input type="number" step="1" min="0" max="99999" name="one_way_5star" value="{{ (int) round($prices['one_way_5star']['amount']) }}"></div>
                </div>
                <div class="qy-fld">
                    <label>RT &mdash; Round Trip<small>5-Star Package</small></label>
                    <div class="qy-money"><span>$</span><input type="number" step="1" min="0" max="99999" name="round_trip_5star" value="{{ (int) round($prices['round_trip_5star']['amount']) }}"></div>
                </div>
                <div class="qy-fld">
                    <label>LP &mdash; Land Package<small>Round Trip</small></label>
                    <div class="qy-money"><span>$</span><input type="number" step="1" min="0" max="99999" name="round_trip_land" value="{{ (int) round($prices['round_trip_land']['amount']) }}"></div>
                </div>
                <div class="qy-fld">
                    <label>Wheelchair throughout the trip<small>Added on top of the price above</small></label>
                    <div class="qy-money"><span>$</span><input type="number" step="1" min="0" max="99999" name="wheelchair_full_trip" value="{{ (int) round($wheelchairFee) }}"></div>
                </div>

                <label class="qy-tickline">
                    <input type="checkbox" name="apply_existing" value="1">
                    <span>Also re-price the <b>{{ $standardCount }}</b> saved {{ $standardCount === 1 ? 'application' : 'applications' }} still on standard pricing. Anyone given their own agreed price keeps it either way. Leave unticked to only price new applications going forward.</span>
                </label>

                {{-- Not a price, but it lives in this dialog on purpose: it is
                     the other thing on the printed footer that the office
                     rewrites season to season, and it was asked for here. --}}
                <span class="qy-lbl">First condition printed on the sheet</span>
                <textarea class="qy-text qy-area" name="validity_note" id="qyValidityNote"
                          maxlength="{{ \App\Models\QuickYatri::VALIDITY_NOTE_MAX }}"
                          placeholder="{{ \App\Models\QuickYatri::VALIDITY_NOTE }}">{{ $validityNote }}</textarea>
                <p class="qy-note-hint" id="qyNoteHint">Bullet one in the box at the foot of page&nbsp;1 &mdash; the date the application is good until, and the late fee after it. <b><span id="qyNoteCount">0</span>/{{ \App\Models\QuickYatri::VALIDITY_NOTE_MAX }}</b> characters: page&nbsp;1 is a fixed page, and a longer sentence would push the sheet onto a third printed one. Leave it empty to go back to the standard wording.</p>

                {{-- Also not a price, and here for the same reason as the
                     sentence above: it is office contact detail that should
                     never need a developer to change. --}}
                <span class="qy-lbl">Pakistan contact number</span>
                <input type="text" class="qy-text" name="pakistan_contact" maxlength="30"
                       value="{{ \App\Models\QuickYatri::pakistanContact() }}"
                       placeholder="{{ \App\Models\QuickYatri::PAKISTAN_CONTACT }}">
                <p class="qy-note-hint">Printed on every group&rsquo;s header in the <a href="{{ route('quick-yatri-groups') }}">Group Manifest</a>, beside the US number. Leave it empty to go back to {{ \App\Models\QuickYatri::PAKISTAN_CONTACT }}.</p>
            </div>
            <div class="qy-modal-foot">
                <button type="button" class="qy-mbtn ghost" data-qy-close>Cancel</button>
                <button type="submit" class="qy-mbtn save"><i class="fa fa-save"></i> Save prices</button>
            </div>
        </form>
    </div>
</div>

{{-- One applicant's own price. Two yatris on the same trip option are not
     always quoted the same thing, so a row can carry its own amount and why. --}}
<div class="qy-modal" id="qyRowModal" role="dialog" aria-modal="true" aria-labelledby="qyRowTitle">
    <div class="qy-modal-back" data-qy-close></div>
    <div class="qy-modal-box">
        <form method="POST" action="" id="qyRowForm">
            @csrf
            <input type="hidden" name="reset" value="0" id="qyRowReset">
            <div class="qy-modal-head">
                <div>
                    <h5 id="qyRowTitle">Price for this applicant</h5>
                    <p id="qyRowWho"></p>
                </div>
                <button type="button" class="qy-modal-x" data-qy-close aria-label="Close">&times;</button>
            </div>
            <div class="qy-modal-body">
                <div class="qy-std" id="qyRowStd"></div>

                <span class="qy-lbl">Price for this applicant</span>
                <div class="qy-money" style="width:100%"><span>$</span><input type="number" step="1" min="0" max="99999" name="package_amount" id="qyRowAmount" placeholder="Leave blank to use the standard price"></div>

                <span class="qy-lbl">Why this price</span>
                <input type="text" class="qy-text" name="price_note" id="qyRowNote" maxlength="255" placeholder="e.g. Group of 6 &mdash; family rate, or Departing MIA">
                <p style="margin:8px 0 0; font-size:12px; color:#9aa0ac; line-height:1.5">Shown on this applicant&rsquo;s printed sheet and in the list, so anyone picking the file up later can see why the price differs.</p>
            </div>
            <div class="qy-modal-foot">
                <button type="submit" class="qy-mbtn reset" id="qyRowResetBtn" style="display:none">Use standard price</button>
                <button type="button" class="qy-mbtn ghost" data-qy-close>Cancel</button>
                <button type="submit" class="qy-mbtn save"><i class="fa fa-save"></i> Save price</button>
            </div>
        </form>
    </div>
</div>

<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        // Rewrites the Download link's ?airport= so the printed blank sheet
        // shows that departure airport (e.g. "MIA/FL") instead of a line to
        // write in — for handing out sheets at one region's signup event.
        var picker = document.getElementById('qyBlankAirport');
        var link = document.getElementById('qyBlankLink');
        var baseHref = link ? link.getAttribute('href') : '';
        if (picker && link) {
            picker.addEventListener('change', function () {
                link.setAttribute('href', this.value ? (baseHref + '?airport=' + encodeURIComponent(this.value)) : baseHref);
            });
        }
    })();
    (function () {
        // The two price dialogs. Plain DOM rather than the theme's Bootstrap:
        // the Quick Yatri screens are hand-styled, and this page must not break
        // if the theme's modal plugin moves.
        var open = null;

        function show(el) {
            close();
            open = el;
            el.classList.add('open');
            document.body.style.overflow = 'hidden';
            var first = el.querySelector('input:not([type=hidden]), button.upd');
            if (first) first.focus();
        }

        function close() {
            if (!open) return;
            open.classList.remove('open');
            document.body.style.overflow = '';
            open = null;
        }

        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-qy-close]')) { e.preventDefault(); close(); }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') close();
        });

        var pricesBtn = document.getElementById('qyPricesOpen');
        var pricesModal = document.getElementById('qyPricesModal');
        if (pricesBtn && pricesModal) {
            pricesBtn.addEventListener('click', function () { show(pricesModal); });
        }

        // One applicant's own price: the row's amount cell fills the form in.
        var rowModal = document.getElementById('qyRowModal');
        var rowForm = document.getElementById('qyRowForm');
        var rowUrl = @json(route('quick-yatri-row-price', '__ID__'));
        if (rowModal && rowForm) {
            Array.prototype.forEach.call(document.querySelectorAll('.qy-price-row'), function (btn) {
                btn.addEventListener('click', function () {
                    var d = btn.dataset;
                    rowForm.setAttribute('action', rowUrl.replace('__ID__', d.id));
                    document.getElementById('qyRowReset').value = '0';

                    document.getElementById('qyRowWho').textContent =
                        d.name + (d.trip ? ' \u2014 ' + d.trip : ' \u2014 no trip option ticked yet');

                    // What the grid says today, so the difference is visible
                    // while the new number is being typed.
                    var std = document.getElementById('qyRowStd');
                    std.innerHTML = d.standard
                        ? 'Standard price for this trip option: <b>$' + Number(d.standard).toLocaleString() + '</b>.'
                          + (d.custom === '1'
                                ? ' This applicant is currently on their own price.'
                                : ' This applicant is on the standard price.')
                        : 'No trip option is ticked on this sheet yet, so there is no standard price to compare against. Anything set here becomes this applicant\u2019s price.';

                    document.getElementById('qyRowAmount').value = d.custom === '1' ? d.amount : '';
                    document.getElementById('qyRowNote').value = d.note || '';
                    document.getElementById('qyRowResetBtn').style.display = d.custom === '1' ? '' : 'none';

                    show(rowModal);
                });
            });

            // "Use standard price" posts the same form with the reset flag, so
            // clearing a price and setting one are one round trip either way.
            var resetBtn = document.getElementById('qyRowResetBtn');
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    document.getElementById('qyRowReset').value = '1';
                });
            }
        }
    })();
    (function () {
        // The sentence prints into a page with no spare height, so the budget
        // is shown while it is being typed rather than only enforced on save.
        var box  = document.getElementById('qyValidityNote');
        var out  = document.getElementById('qyNoteCount');
        var hint = document.getElementById('qyNoteHint');
        if (!box || !out) return;
        var max = parseInt(box.getAttribute('maxlength'), 10) || 0;

        function count() {
            out.textContent = box.value.length;
            // Empty is not "nothing printed" — it is the standard wording
            // coming back, which the hint says, so only the ceiling warns.
            if (hint) hint.classList.toggle('over', max > 0 && box.value.length >= max);
        }

        box.addEventListener('input', count);
        count();
    })();
    (function () {
        // Search and column sorting share the table, so they share one place:
        // filtering hides rows, sorting reorders every row including the hidden
        // ones, and the # column is renumbered down whatever is left showing.
        var input = document.getElementById('qySearch');
        var table = document.querySelector('.qy-table');
        var rows  = Array.prototype.slice.call(document.querySelectorAll('.qy-row'));
        var noRes = document.getElementById('qyNoResults');
        if (!table || !rows.length) return;

        var tbody   = table.tBodies[0];
        var headers = Array.prototype.slice.call(table.querySelectorAll('thead th'));

        // # counts the rows actually on screen, so a filtered table reads 1..n
        // rather than keeping the gaps where the hidden rows were.
        function renumber() {
            var n = 0;
            rows.forEach(function (el) {
                if (el.style.display === 'none') return;
                var idx = el.querySelector('.qy-idx');
                if (idx) idx.textContent = ++n;
            });
            return n;
        }

        function filter() {
            var q = input ? input.value.toLowerCase().trim() : '';
            rows.forEach(function (el) {
                el.style.display = el.getAttribute('data-search').indexOf(q) !== -1 ? '' : 'none';
            });
            if (noRes) noRes.style.display = renumber() === 0 ? '' : 'none';
        }

        // What a cell sorts on: the key it was given, or failing that whatever
        // it prints. An em dash is a cell with no answer in it, not a value.
        function key(row, column) {
            var cell = row.children[column];
            if (!cell) return '';
            var raw = cell.hasAttribute('data-sort')
                ? cell.getAttribute('data-sort')
                : cell.textContent;

            return raw.replace(/—/g, '').trim();
        }

        function sortBy(th) {
            var column = headers.indexOf(th);
            var numeric = th.getAttribute('data-type') === 'num';
            // Third click is not "off" — the table always has an order, so a
            // header only ever toggles between the two directions.
            var dir = th.getAttribute('aria-sort') === 'ascending' ? -1 : 1;

            headers.forEach(function (h) { h.removeAttribute('aria-sort'); });
            th.setAttribute('aria-sort', dir === 1 ? 'ascending' : 'descending');

            var decorated = rows.map(function (row, i) {
                var raw = key(row, column);
                return {
                    row: row,
                    i: i,                        // keeps equal rows in their entered order
                    empty: raw === '',           // "—" rows sit at the foot either way
                    value: numeric ? parseFloat(raw.replace(/[$,\s]/g, '')) : raw.toLowerCase()
                };
            });

            decorated.sort(function (a, b) {
                // An unanswered cell is not a small value, it is a missing one,
                // so it goes last whichever way the column is pointing rather
                // than crowding the top of a descending sort.
                if (a.empty !== b.empty) return a.empty ? 1 : -1;
                if (a.empty) return a.i - b.i;

                var cmp = numeric
                    ? (a.value - b.value)
                    : a.value.localeCompare(b.value, undefined, { numeric: true, sensitivity: 'base' });

                return cmp ? cmp * dir : a.i - b.i;
            });

            var frag = document.createDocumentFragment();
            decorated.forEach(function (d) { frag.appendChild(d.row); });
            tbody.appendChild(frag);

            rows = decorated.map(function (d) { return d.row; });
            renumber();
        }

        headers.forEach(function (th) {
            if (!th.classList.contains('srt')) return;
            th.addEventListener('click', function () { sortBy(th); });
            th.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    sortBy(th);
                }
            });
        });

        if (input) input.addEventListener('input', filter);
    })();
</script>
@endsection
