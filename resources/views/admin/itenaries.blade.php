@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .it-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:18px}
    .it-count{display:inline-flex;align-items:center;gap:8px;background:#1f2a44;color:#fff;font-size:13px;font-weight:600;padding:9px 18px;border-radius:24px}

    .wc-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden;padding:6px}
    #itenaryTable{width:100%;border-collapse:separate;border-spacing:0}
    #itenaryTable thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:14px 14px;border:0;white-space:nowrap}
    #itenaryTable tbody td{padding:13px 14px;font-size:13.5px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    #itenaryTable tbody tr:hover{background:#f9fafc}
    .it-name{font-weight:700;color:#1f2a44}
    .it-contact a{color:#1f2a44;text-decoration:none}
    .it-contact .ph{color:#e8721e;font-weight:600}
    .it-route b{color:#e8721e}
    .it-when{white-space:nowrap}
    .it-when small{color:#98a2b5}
    .it-loc{white-space:nowrap}
    .it-loc small{color:#98a2b5;font-family:monospace}
    .it-muted{color:#aab}
    .it-chip{display:inline-block;background:#eef1f6;color:#3a4458;border-radius:8px;padding:3px 10px;font-size:12px;font-weight:600;white-space:nowrap}

    .it-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .it-actions form{margin:0;display:inline}
    .it-btn{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:10px;border:none;cursor:pointer;font-size:13px;transition:transform .12s,box-shadow .12s,background .12s;text-decoration:none}
    .it-btn:hover{transform:translateY(-2px)}
    .it-btn.view{background:#fff4e8;color:#e8721e}
    .it-btn.view:hover{background:#e8721e;color:#fff;box-shadow:0 6px 14px rgba(232,114,30,.3)}
    .it-btn.del{background:#feeceb;color:#e23b2e}
    .it-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}

    /* DataTables controls */
    .dataTables_wrapper .dataTables_filter input{border:1px solid #e2e2e2;border-radius:20px;padding:6px 14px;outline:none}
    .dataTables_wrapper .dataTables_filter input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .dataTables_wrapper .dataTables_paginate .paginate_button.current{background:#1f2a44 !important;color:#fff !important;border-radius:8px;border:0}
    .dataTables_wrapper .dataTables_paginate .paginate_button{border-radius:8px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Itinerary Requests</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Itinerary Requests</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="it-toolbar">
                <span class="it-count"><i class="fa fa-plane-departure"></i> {{ count($itenaries) }} {{ \Illuminate\Support\Str::plural('Request', count($itenaries)) }}</span>
                <a href="{{ route('itenaries_export_pdf') }}" class="btn btn-primary"><i class="fa fa-file-pdf"></i> Export PDF</a>
            </div>

            <div class="wc-card">
                <div class="table-responsive">
                    <table class="table" id="itenaryTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Submitted</th>
                                <th>Inquirer</th>
                                <th>Contact</th>
                                <th>From &rarr; To</th>
                                <th>Travel Dates</th>
                                <th>Class</th>
                                <th>Passengers</th>
                                <th>Connected From</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itenaries as $itenary)
                            <tr>
                                <td>{{ $itenary->id }}</td>
                                <td class="it-when" data-order="{{ optional($itenary->created_at)->timestamp }}">
                                    {{ optional($itenary->created_at)->format('d M Y') ?: '—' }}<br>
                                    <small>{{ optional($itenary->created_at)->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <div class="it-name">{{ $itenary->name ?: '—' }}</div>
                                </td>
                                <td class="it-contact">
                                    @if($itenary->email)<div><i class="fa fa-envelope it-muted"></i> <a href="mailto:{{ $itenary->email }}">{{ $itenary->email }}</a></div>@endif
                                    @if($itenary->contact)<div class="ph"><i class="fa fa-phone"></i> <a href="tel:{{ $itenary->contact }}" class="ph">{{ $itenary->contact }}</a></div>@endif
                                    @if(!$itenary->email && !$itenary->contact)<span class="it-muted">No contact given</span>@endif
                                </td>
                                <td class="it-route">{{ $itenary->from ?: '—' }} <b>&rarr;</b> {{ $itenary->to ?: '—' }}</td>
                                <td class="it-when">
                                    {{ $itenary->depart ?: '—' }}
                                    @if($itenary->return)<br><small>ret {{ $itenary->return }}</small>@endif
                                </td>
                                <td>@if($itenary->class)<span class="it-chip">{{ $itenary->class }}</span>@else — @endif</td>
                                <td>@if($itenary->passengers)<span class="it-chip">{{ $itenary->passengers }}</span>@else — @endif</td>
                                <td class="it-loc">
                                    {{ trim(($itenary->city ? $itenary->city.', ' : '').($itenary->country ?: '')) ?: '—' }}
                                    @if($itenary->ip)<br><small>{{ $itenary->ip }}</small>@endif
                                </td>
                                <td>
                                    <div class="it-actions">
                                        <a href="{{ url('admin/itenaries/ticket', $itenary->id) }}" class="it-btn view" title="View"><i class="fa fa-user"></i></a>
                                        <form method="POST" action="{{ route('itenaries-delete', $itenary->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="it-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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
<script>
    $(function () {
        if ($.fn.DataTable) {
            $('#itenaryTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 25,
                columnDefs: [{ orderable: false, targets: [3, 9] }],
                language: { search: 'Search requests:' }
            });
        }
    });
</script>
@endsection
