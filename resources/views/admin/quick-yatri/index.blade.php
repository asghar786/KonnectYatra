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
    .qy-chip.wc{background:#eaf2ff; color:#1a3fa0}
    .qy-pp{font-variant-numeric:tabular-nums}

    .qy-actions{display:flex; gap:8px; justify-content:center; align-items:center}
    .qy-btn{display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:10px; border:none; cursor:pointer; font-size:14px; transition:transform .12s, box-shadow .12s, background .12s; text-decoration:none}
    .qy-btn:hover{transform:translateY(-2px)}
    .qy-btn.prn{background:#eef0ff; color:#2d1b69}
    .qy-btn.prn:hover{background:#2d1b69; color:#fff; box-shadow:0 6px 14px rgba(45,27,105,.3)}
    .qy-btn.edt{background:#eaf2ff; color:#1a73e8}
    .qy-btn.edt:hover{background:#1a73e8; color:#fff; box-shadow:0 6px 14px rgba(26,115,232,.3)}
    .qy-btn.del{background:#feeceb; color:#e23b2e}
    .qy-btn.del:hover{background:#e23b2e; color:#fff; box-shadow:0 6px 14px rgba(226,59,46,.3)}
    .qy-empty{padding:40px; text-align:center; color:#999; font-size:15px}
    .qy-blank-picker{display:inline-flex; align-items:center; gap:8px}
    .qy-blank-picker select{border:1px solid #d4e2ff; border-radius:24px; padding:9px 14px; font-size:13px; color:#1a3fa0; background:#eaf2ff; outline:none; max-width:190px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Quick Yatri</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Quick Yatri</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="qy-toolbar">
                <div class="qy-toolbar-left">
                    <a href="{{ route('quick-yatri-create') }}" class="qy-cta add"><i class="fa fa-plus"></i> Add New</a>
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
                            <th class="tc">#</th>
                            <th>Applicant</th>
                            <th>Contact</th>
                            <th>Passport</th>
                            <th>Trip</th>
                            <th>Amount</th>
                            <th>Options</th>
                            <th>Entered On</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $i => $r)
                        <tr class="qy-row" data-search="{{ strtolower(trim($r->applicant_name.' '.$r->father_name.' '.$r->cell_phone.' '.$r->email.' '.$r->passport_no.' '.$r->city.' '.$r->state_zip.' '.$r->nearest_gurdwara)) }}">
                            <td class="tc"><span class="qy-idx">{{ $i + 1 }}</span></td>
                            <td>
                                <span class="qy-name">{{ $r->applicant_name }}
                                    @if($r->father_name)<small>S/o {{ $r->father_name }}</small>@endif
                                </span>
                            </td>
                            <td>
                                @if($r->cell_phone)<a class="qy-link" href="tel:{{ $r->cell_phone }}"><i class="fa fa-phone"></i> {{ $r->cell_phone }}</a>@endif
                                @if($r->email)<a class="qy-link mail" href="mailto:{{ $r->email }}"><i class="fa fa-envelope"></i> {{ $r->email }}</a>@endif
                                @if(!$r->cell_phone && !$r->email)<span class="qy-sub">&mdash;</span>@endif
                            </td>
                            <td>
                                @if($r->passport_no)
                                    <span class="qy-pp">{{ $r->passport_no }}</span>
                                    @if($r->date_of_expiry)<small class="qy-sub" style="display:block">exp {{ $r->stamp('date_of_expiry') }}</small>@endif
                                @else
                                    <span class="qy-sub">&mdash;</span>
                                @endif
                            </td>
                            <td>@if($r->trip_option)<span class="qy-trip">{{ $r->tripLabel() }}</span>@else <span class="qy-sub">&mdash;</span> @endif</td>
                            <td>
                                @if($r->total_amount !== null)
                                    <span class="qy-amt">${{ number_format($r->total_amount) }}
                                        @if($r->wheelchair_full_trip)<small>incl. +$300</small>@endif
                                    </span>
                                @else
                                    <span class="qy-sub">&mdash;</span>
                                @endif
                            </td>
                            <td>
                                @if($r->wheelchair_airport)<span class="qy-chip wc">Wheelchair &mdash; airport</span>@endif
                                @if($r->wheelchair_full_trip)<span class="qy-chip wc">Wheelchair &mdash; full trip</span>@endif
                                @if($r->meal_vegetarian)<span class="qy-chip">Vegetarian</span>@endif
                                @if(!$r->wheelchair_airport && !$r->wheelchair_full_trip && !$r->meal_vegetarian)<span class="qy-sub">&mdash;</span>@endif
                            </td>
                            <td><span class="qy-sub">{{ optional($r->created_at)->format('d M Y, h:i A') ?: '—' }}</span></td>
                            <td class="tc">
                                <div class="qy-actions">
                                    <a href="{{ route('quick-yatri-print', $r->id) }}" target="_blank" rel="noopener" class="qy-btn prn" title="Print / Save as PDF"><i class="fa fa-print"></i></a>
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
        var input = document.getElementById('qySearch');
        var rows = Array.prototype.slice.call(document.querySelectorAll('.qy-row'));
        var noRes = document.getElementById('qyNoResults');
        if (!input) return;
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim(), visible = 0;
            rows.forEach(function (el) {
                var m = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = m ? '' : 'none';
                if (m) visible++;
            });
            noRes.style.display = (visible === 0 && rows.length) ? '' : 'none';
        });
    })();
</script>
@endsection
