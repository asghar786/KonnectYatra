@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .it-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:14px}
    .it-count{background:#1c2b4a;color:#fff;font-size:13px;font-weight:600;padding:7px 16px;border-radius:20px}
    #itenaryTable thead th{background:#1c2b4a;color:#fff;font-size:12px;text-transform:uppercase;letter-spacing:.03em;border:0;white-space:nowrap}
    #itenaryTable td{vertical-align:middle;font-size:13.5px}
    .it-name{font-weight:700;color:#1c2b4a}
    .it-contact a{color:#1c2b4a;text-decoration:none}
    .it-contact .ph{color:#e8721e;font-weight:600}
    .it-route b{color:#e8721e}
    .it-when{white-space:nowrap}
    .it-when small{color:#98a2b5}
    .it-loc{white-space:nowrap}
    .it-loc small{color:#98a2b5;font-family:monospace}
    .it-muted{color:#aab}
    .it-actions{display:flex;gap:8px}
    .it-actions form{margin:0}
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

            <div class="table-responsive">
                <table class="table table-striped" id="itenaryTable" style="width:100%">
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
                            <th>Action</th>
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
                            <td>{{ $itenary->class ?: '—' }}</td>
                            <td>{{ $itenary->passengers ?: '—' }}</td>
                            <td class="it-loc">
                                {{ trim(($itenary->city ? $itenary->city.', ' : '').($itenary->country ?: '')) ?: '—' }}
                                @if($itenary->ip)<br><small>{{ $itenary->ip }}</small>@endif
                            </td>
                            <td>
                                <div class="it-actions">
                                    <a href="{{ url('admin/itenaries/ticket', $itenary->id) }}" class="btn btn-warning btn-sm" title="View"><i class="fa fa-user"></i></a>
                                    <form method="POST" action="{{ route('itenaries-delete', $itenary->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="GET">
                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
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
