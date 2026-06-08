@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .hl-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .hl-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .hl-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .hl-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .hl-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .hl-card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .hl-card:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
    .hl-photo{height:160px;background:#f3f4f6;overflow:hidden;position:relative}
    .hl-photo img{width:100%;height:100%;object-fit:cover}
    .hl-price{position:absolute;top:10px;right:10px;background:rgba(245,78,24,.95);color:#fff;font-size:12px;font-weight:700;padding:3px 10px;border-radius:20px}
    .hl-pics{position:absolute;bottom:10px;left:10px;background:rgba(0,0,0,.55);color:#fff;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px}
    .hl-body{padding:13px 15px;flex:1}
    .hl-body h5{margin:0 0 6px;font-size:15px;font-weight:700;color:#222}
    .hl-meta{list-style:none;padding:0;margin:0}
    .hl-meta li{display:flex;gap:8px;font-size:12.5px;color:#555;padding:3px 0}
    .hl-meta li i{color:#f54e18;width:14px;text-align:center;margin-top:2px}
    .hl-geo{color:#28a745 !important}
    .hl-actions{display:flex;gap:8px;padding:10px 15px;border-top:1px solid #f3f3f3}
    .hl-actions .btn{flex:1;text-align:center}
    .hl-actions form{margin:0;flex:1}
    .hl-actions form .btn{width:100%}
    .hl-empty{padding:40px;text-align:center;color:#999;font-size:16px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Hotels</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Hotels</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="hl-toolbar">
                <a href="{{ url('admin/hotels/create') }}" class="btn btn-primary">Add Hotel <i class="fa fa-plus"></i></a>
                <div class="hl-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="hlSearch" placeholder="Search by name, city or state…" autocomplete="off">
                </div>
            </div>

            <div class="row mt-4" id="hlGrid">
                @forelse($hotels as $hotel)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 hl-item" data-search="{{ strtolower(trim($hotel->name.' '.$hotel->city.' '.$hotel->state)) }}">
                    <div class="hl-card">
                        <div class="hl-photo">
                            <img src="{{ asset('hotels/'.$hotel->image) }}" alt="{{ $hotel->name }}" onerror="this.style.opacity=.3">
                            @if(!empty($hotel->price))<span class="hl-price">${{ $hotel->price }}/night</span>@endif
                            @if($hotel->images && $hotel->images->count())<span class="hl-pics"><i class="fa fa-images"></i> {{ $hotel->images->count() }}</span>@endif
                        </div>
                        <div class="hl-body">
                            <h5>{{ $hotel->name }}</h5>
                            <ul class="hl-meta">
                                <li><i class="fa fa-location-dot"></i><span>{{ trim(collect([$hotel->city, $hotel->state])->filter()->implode(', ')) ?: '—' }}</span></li>
                                @if(!empty($hotel->phone))<li><i class="fa fa-phone"></i><span>{{ $hotel->phone }}</span></li>@endif
                                <li><i class="fa fa-map-pin {{ ($hotel->latitude && $hotel->longitude) ? 'hl-geo' : '' }}"></i><span>{{ ($hotel->latitude && $hotel->longitude) ? 'Geo location set' : 'No geo location' }}</span></li>
                            </ul>
                        </div>
                        <div class="hl-actions">
                            <a href="{{ url('admin/hotels/edit', $hotel->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form method="POST" action="{{ url('/admin/hotels/delete', $hotel->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="GET">
                                <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="hl-empty">No hotels added yet.</div></div>
                @endforelse
            </div>
            <div class="hl-empty" id="hlNoResults" style="display:none;">No hotels match your search.</div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('hlSearch');
        var items = Array.prototype.slice.call(document.querySelectorAll('.hl-item'));
        var noRes = document.getElementById('hlNoResults');
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
