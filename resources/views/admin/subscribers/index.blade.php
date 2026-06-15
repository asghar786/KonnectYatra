@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .sb-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:18px}
    .sb-total{display:inline-flex;align-items:center;gap:8px;background:#1f2a44;color:#fff;font-size:13px;font-weight:600;padding:9px 18px;border-radius:24px}
    .sb-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .sb-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .sb-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .sb-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}

    .sb-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .sb-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .sb-table thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:15px 18px;text-align:left;white-space:nowrap;border:none}
    .sb-table thead th.tc{text-align:center}
    .sb-table tbody td{padding:14px 18px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .sb-table tbody tr:last-child td{border-bottom:none}
    .sb-table tbody tr:hover{background:#f9fafc}
    .sb-table tbody td.tc{text-align:center}
    .sb-idx{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eef1f6;color:#5a6273;font-size:12px;font-weight:700}
    .sb-email{display:inline-flex;align-items:center;gap:9px;font-weight:600;color:#1f2a44}
    .sb-email i{color:#f54e18}
    .sb-email a{color:#1f2a44;text-decoration:none}
    .sb-email a:hover{color:#1a73e8}
    .sb-badge{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11.5px;font-weight:600;background:#eef2ff;color:#3949ab;white-space:nowrap;text-transform:capitalize}
    .sb-sub{color:#6b7280;font-size:13px}

    .sb-actions{display:flex;gap:8px;justify-content:center;align-items:center}
    .sb-actions form{margin:0;display:inline}
    .sb-btn{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;border:none;cursor:pointer;font-size:14px;transition:transform .12s,box-shadow .12s,background .12s}
    .sb-btn:hover{transform:translateY(-2px)}
    .sb-btn.del{background:#feeceb;color:#e23b2e}
    .sb-btn.del:hover{background:#e23b2e;color:#fff;box-shadow:0 6px 14px rgba(226,59,46,.3)}
    .sb-empty{padding:40px;text-align:center;color:#999;font-size:15px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Newsletter Subscribers</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Subscribers</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <div class="sb-toolbar">
                <span class="sb-total"><i class="fa fa-envelope"></i> {{ count($subscribers) }} Subscribers</span>
                <div class="sb-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="sbSearch" placeholder="Search by email or source…" autocomplete="off">
                </div>
            </div>

            <div class="sb-card">
                <table class="sb-table">
                    <thead>
                        <tr>
                            <th class="tc">#</th>
                            <th>Email</th>
                            <th>Source</th>
                            <th>Subscribed On</th>
                            <th class="tc">Action</th>
                        </tr>
                    </thead>
                    <tbody id="sbBody">
                        @forelse($subscribers as $i => $sub)
                        <tr class="sb-row" data-search="{{ strtolower(trim($sub->email.' '.$sub->source)) }}">
                            <td class="tc"><span class="sb-idx">{{ $i + 1 }}</span></td>
                            <td class="sb-email"><i class="fa fa-envelope"></i> <a href="mailto:{{ $sub->email }}">{{ $sub->email }}</a></td>
                            <td>@if($sub->source)<span class="sb-badge">{{ $sub->source }}</span>@else <span class="sb-sub">—</span> @endif</td>
                            <td><span class="sb-sub">{{ optional($sub->created_at)->format('d M Y, h:i A') ?: '—' }}</span></td>
                            <td class="tc">
                                <div class="sb-actions">
                                    <form method="POST" action="{{ url('/admin/subscribers/delete', $sub->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="GET">
                                        <button type="submit" class="sb-btn del show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="sb-empty">No subscribers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="sb-empty" id="sbNoResults" style="display:none;">No subscribers match your search.</div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('sbSearch');
        var rows = Array.prototype.slice.call(document.querySelectorAll('.sb-row'));
        var noRes = document.getElementById('sbNoResults');
        if (!input) return;
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim(), visible = 0;
            rows.forEach(function (el) {
                var m = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = m ? '' : 'none';
                if (m) visible++;
            });
            noRes.style.display = (visible === 0 && rows.length) ? 'block' : 'none';
        });
    })();
</script>
@endsection
