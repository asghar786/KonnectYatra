@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .ll-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .ll-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .ll-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .ll-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .ll-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .ll-card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .ll-card:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
    .ll-photo{height:170px;background:#f3f4f6;overflow:hidden;position:relative}
    .ll-photo img{width:100%;height:100%;object-fit:cover}
    .ll-pics{position:absolute;bottom:10px;left:10px;background:rgba(0,0,0,.55);color:#fff;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px}
    .ll-body{padding:13px 15px;flex:1}
    .ll-body h5{margin:0 0 6px;font-size:15px;font-weight:700;color:#222}
    .ll-meta{list-style:none;padding:0;margin:0}
    .ll-meta li{display:flex;gap:8px;font-size:12.5px;color:#555;padding:3px 0}
    .ll-meta li i{color:#f54e18;width:14px;text-align:center;margin-top:2px}
    .ll-geo{color:#28a745 !important}
    .ll-actions{display:flex;gap:8px;padding:10px 15px;border-top:1px solid #f3f3f3}
    .ll-actions .btn{flex:1;text-align:center}
    .ll-actions form{margin:0;flex:1}
    .ll-actions form .btn{width:100%}
    .ll-empty{padding:40px;text-align:center;color:#999;font-size:16px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Locations</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Locations</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="ll-toolbar">
                <a href="{{ url('admin/locations/create') }}" class="btn btn-primary">Add Location <i class="fa fa-plus"></i></a>
                <div class="ll-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="llSearch" placeholder="Search by name, city or state…" autocomplete="off">
                </div>
            </div>

            <div class="row mt-4" id="llGrid">
                @forelse($locations as $loc)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 ll-item" data-search="{{ strtolower(trim($loc->name.' '.$loc->city.' '.$loc->state)) }}">
                    <div class="ll-card">
                        <div class="ll-photo">
                            <img src="{{ asset('locations/'.$loc->image) }}" alt="{{ $loc->name }}" onerror="this.style.opacity=.3">
                            @if($loc->images && $loc->images->count())<span class="ll-pics"><i class="fa fa-images"></i> {{ $loc->images->count() }}</span>@endif
                        </div>
                        <div class="ll-body">
                            <h5>{{ $loc->name }}</h5>
                            <ul class="ll-meta">
                                <li><i class="fa fa-location-dot"></i><span>{{ trim(collect([$loc->city, $loc->state])->filter()->implode(', ')) ?: '—' }}</span></li>
                                <li><i class="fa fa-map-pin {{ ($loc->latitude && $loc->longitude) ? 'll-geo' : '' }}"></i><span>{{ ($loc->latitude && $loc->longitude) ? 'Geo location set' : 'No geo location' }}</span></li>
                            </ul>
                        </div>
                        <div class="ll-actions">
                            <a href="{{ url('admin/locations/edit', $loc->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form method="POST" action="{{ url('/admin/locations/delete', $loc->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="GET">
                                <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="ll-empty">No locations added yet.</div></div>
                @endforelse
            </div>
            <div class="ll-empty" id="llNoResults" style="display:none;">No locations match your search.</div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('llSearch');
        var items = Array.prototype.slice.call(document.querySelectorAll('.ll-item'));
        var noRes = document.getElementById('llNoResults');
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
