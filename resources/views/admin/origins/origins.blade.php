@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .sl-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .sl-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .sl-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .sl-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .sl-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .sl-note{background:#fff7ed;border:1px solid #ffe0c2;color:#8a5a22;border-radius:10px;padding:10px 14px;font-size:13px;margin:14px 0 4px}
    .og-country{margin-top:22px;margin-bottom:10px;font-size:15px;font-weight:800;color:#2d1b69;display:flex;align-items:center;gap:8px}
    .og-country .cnt{font-size:11.5px;font-weight:700;color:#fff;background:#f54e18;border-radius:20px;padding:2px 10px}
    .og-table{width:100%;background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);border-collapse:separate;border-spacing:0}
    .og-table th{background:#faf7ff;color:#4b4170;font-size:12px;text-transform:uppercase;letter-spacing:.03em;font-weight:700;padding:12px 16px;text-align:left;border-bottom:1px solid #eee}
    .og-table td{padding:12px 16px;border-bottom:1px solid #f3f3f3;font-size:14px;color:#333;vertical-align:middle}
    .og-table tr:last-child td{border-bottom:0}
    .og-code{display:inline-block;font-weight:800;letter-spacing:.04em;background:#eef0ff;color:#2d1b69;border-radius:8px;padding:3px 10px;font-size:13px}
    .sl-badge{display:inline-block;font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:20px}
    .sl-badge.on{background:#e7f8ec;color:#1c9e44}
    .sl-badge.off{background:#fdecea;color:#d9534f}
    .og-actions{display:flex;gap:8px;justify-content:flex-end}
    .sl-empty{padding:40px;text-align:center;color:#999;font-size:16px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Departure Origins</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Departure Origins</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="sl-toolbar">
                <a href="{{ url('admin/origins/create') }}" class="btn btn-primary">Add Departure Origin <i class="fa fa-plus"></i></a>
                <div class="sl-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="ogSearch" placeholder="Search country, state, airport or code…" autocomplete="off">
                </div>
            </div>
            <div class="sl-note"><b>Note:</b> These power the <b>Country → State/City → Departure Airport</b> selector on the public packages page. The airport <b>Code</b> must match the package's <b>State&nbsp;Code</b> for that package to appear when the airport is chosen.</div>

            @php $grouped = $origins->groupBy('country'); @endphp
            <div id="ogWrap">
                @forelse($grouped as $country => $rows)
                <div class="og-group">
                    <div class="og-country"><i class="fa fa-globe"></i> {{ $country }} <span class="cnt">{{ count($rows) }}</span></div>
                    <table class="og-table">
                        <thead>
                            <tr>
                                <th style="width:30%">State / City</th>
                                <th style="width:34%">Departure Airport</th>
                                <th style="width:12%">Code</th>
                                <th style="width:10%">Status</th>
                                <th style="width:14%;text-align:right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $o)
                            <tr class="og-item" data-search="{{ strtolower($o->country.' '.$o->state.' '.$o->airport_name.' '.$o->airport_code) }}">
                                <td>{{ $o->state }}</td>
                                <td>{{ $o->airport_name }}</td>
                                <td><span class="og-code">{{ $o->airport_code }}</span></td>
                                <td>
                                    @if($o->status == 1)
                                        <span class="sl-badge on"><i class="fa fa-check-circle"></i> Active</span>
                                    @else
                                        <span class="sl-badge off"><i class="fa fa-times-circle"></i> Hidden</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="og-actions">
                                        <a href="{{ url('admin/origins/edit', $o->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="{{ url('admin/origins/delete', $o->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Delete this departure origin?')"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @empty
                <div class="sl-empty">No departure origins added yet.</div>
                @endforelse
            </div>
            <div class="sl-empty" id="ogNoResults" style="display:none;">No origins match your search.</div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('ogSearch');
        if (!input) return;
        var items = Array.prototype.slice.call(document.querySelectorAll('.og-item'));
        var groups = Array.prototype.slice.call(document.querySelectorAll('.og-group'));
        var noRes = document.getElementById('ogNoResults');
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim(), visible = 0;
            items.forEach(function (el) {
                var m = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = m ? '' : 'none';
                if (m) visible++;
            });
            // Hide a country group when none of its rows match.
            groups.forEach(function (g) {
                var any = g.querySelectorAll('.og-item:not([style*="display: none"])').length;
                g.style.display = any ? '' : 'none';
            });
            noRes.style.display = (visible === 0 && items.length) ? 'block' : 'none';
        });
    })();
</script>
@endsection
