@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .sl-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .sl-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .sl-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .sl-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .sl-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .sl-note{background:#fff7ed;border:1px solid #ffe0c2;color:#8a5a22;border-radius:10px;padding:10px 14px;font-size:13px;margin:14px 0 4px}
    .sl-card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .sl-card:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
    .sl-card.is-active{border-top:4px solid #2fbf4f}
    .sl-card.is-inactive{border-top:4px solid #e2e2e2}
    .sl-head{display:flex;align-items:center;gap:12px;padding:16px 16px 8px}
    .sl-ico{width:44px;height:44px;border-radius:12px;background:#fff4ef;color:#f54e18;display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0}
    .sl-sr{font-size:11px;color:#999;font-weight:600;text-transform:uppercase;letter-spacing:.04em}
    .sl-body{padding:4px 16px 14px;flex:1}
    .sl-body h5{margin:6px 0 10px;font-size:15.5px;font-weight:700;color:#222;line-height:1.35}
    .sl-badge{display:inline-block;font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:20px}
    .sl-badge.on{background:#e7f8ec;color:#1c9e44}
    .sl-badge.off{background:#fdecea;color:#d9534f}
    .sl-actions{display:flex;gap:8px;padding:10px 15px;border-top:1px solid #f3f3f3}
    .sl-actions .btn{flex:1;text-align:center}
    .sl-empty{padding:40px;text-align:center;color:#999;font-size:16px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Seasons</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Seasons</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="sl-toolbar">
                <a href="{{ url('admin/seasons/create') }}" class="btn btn-primary">Add Season <i class="fa fa-plus"></i></a>
                <div class="sl-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="slSearch" placeholder="Search season by name…" autocomplete="off">
                </div>
            </div>
            <div class="sl-note"><b>Note:</b> If none of the seasons below is active, new bookings will be created in the last season that you created.</div>

            <div class="row mt-3" id="slGrid">
                @forelse($seasons as $season)
                @php $isActive = $season->status == "1"; @endphp
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 sl-item" data-search="{{ strtolower($season->name) }}">
                    <div class="sl-card {{ $isActive ? 'is-active' : 'is-inactive' }}">
                        <div class="sl-head">
                            <div class="sl-ico"><i class="fa fa-calendar-alt"></i></div>
                            <div class="sl-sr">Season&nbsp;#{{ $season->id }}</div>
                        </div>
                        <div class="sl-body">
                            <h5>{{ $season->name }}</h5>
                            @if($isActive)
                                <span class="sl-badge on"><i class="fa fa-check-circle"></i> Active</span>
                            @else
                                <span class="sl-badge off"><i class="fa fa-times-circle"></i> In Active</span>
                            @endif
                        </div>
                        <div class="sl-actions">
                            <a href="{{ url('admin/seasons/edit', $season->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="sl-empty">No seasons added yet.</div></div>
                @endforelse
            </div>
            <div class="sl-empty" id="slNoResults" style="display:none;">No seasons match your search.</div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('slSearch');
        var items = Array.prototype.slice.call(document.querySelectorAll('.sl-item'));
        var noRes = document.getElementById('slNoResults');
        if (!input) return;
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim(), visible = 0;
            items.forEach(function (el) {
                var m = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = m ? '' : 'none';
                if (m) visible++;
            });
            noRes.style.display = (visible === 0 && items.length) ? 'block' : 'none';
        });
    })();
</script>
@endsection
