@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    /* Hide any DataTables export buttons that may be injected globally on this page */
    .dt-buttons{display:none !important;}
    /* Card view for Packages */
    .pkg-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .pkg-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .pkg-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .pkg-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:border-color .15s,box-shadow .15s}
    .pkg-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .pkg-card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .pkg-card:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
    /* Trip banner — show the whole image, zoomed out (no cropping) */
    .pkg-banner{position:relative;height:170px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;overflow:hidden}
    .pkg-banner img{max-width:100%;max-height:100%;width:auto;height:auto;object-fit:contain}
    .pkg-banner .pkg-noimg{color:#bbb;font-size:13px;text-align:center}
    .pkg-type{position:absolute;top:10px;right:10px;background:rgba(45,27,105,.9);color:#fff;font-size:11px;padding:3px 10px;border-radius:20px;font-weight:600;white-space:nowrap}
    .pkg-card-head{padding:14px 18px 4px}
    .pkg-card-head h5{margin:0;font-size:15px;font-weight:700;line-height:1.35;color:#222}
    .pkg-history{display:inline-flex;align-items:center;gap:6px;margin:8px 18px 0;padding:4px 12px;border-radius:20px;
        font-size:12px;font-weight:600;background:#eef2ff;color:#3b3f9e}
    .pkg-history.none{background:#f3f4f6;color:#8a8f9a}
    .pkg-history i{font-size:12px}
    .pkg-card-body{padding:8px 18px 14px;flex:1}
    .pkg-tier{font-size:12px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#f54e18;margin:10px 0 6px}
    .pkg-tier.four{color:#5b2a9e}
    .pkg-prices{list-style:none;padding:0;margin:0}
    .pkg-prices li{display:flex;justify-content:space-between;gap:10px;font-size:13px;padding:5px 0;border-bottom:1px dashed #f0f0f0}
    .pkg-prices li:last-child{border-bottom:none}
    .pkg-prices li span{color:#999}
    .pkg-prices li b{color:#222;text-align:right}
    /* Four equal action buttons. Grid tracks (not flex) because two of the four
       are wrapped in a <form>, whose inner button carries its own intrinsic
       width — with flex that made the wrapped pair narrower than the plain ones.
       minmax(0,1fr) stops a long label widening its own column. */
    .pkg-card-actions{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:8px;padding:12px 18px;border-top:1px solid #f3f3f3}
    .pkg-card-actions > .btn,.pkg-card-actions form{margin:0;min-width:0}
    .pkg-card-actions form .btn{width:100%}
    .pkg-card-actions .btn{padding-left:6px;padding-right:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    @media (max-width:420px){.pkg-card-actions{grid-template-columns:repeat(2,minmax(0,1fr))}}
    .pkg-empty{padding:40px;text-align:center;color:#999;font-size:16px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Packages</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Yatri Packages</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="pkg-toolbar">
                <a href="{{ url('admin/apply_packages/create') }}" class="btn btn-primary">
                    Add Package <i class="fa fa-plus"></i>
                </a>
                <div class="pkg-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="pkgSearch" placeholder="Search packages by name or type…" autocomplete="off">
                </div>
            </div>
            <div class="row mt-4" id="pkgGrid">
                @forelse($yatri_package as $yatri)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4 pkg-item" data-search="{{ strtolower(trim($yatri->name.' '.$yatri->package_type)) }}">
                    <div class="pkg-card">
                        <div class="pkg-banner">
                            @if(!empty($yatri->image))
                            <img src="{{ asset('assets/flyers/'.$yatri->image) }}" alt="{{ $yatri->name }}">
                            @else
                            <span class="pkg-noimg"><i class="fa fa-image fa-2x d-block mb-2"></i>No banner</span>
                            @endif
                            <span class="pkg-type">{{ $yatri->package_type ?: '—' }}</span>
                        </div>
                        <div class="pkg-card-head">
                            <h5>{{ $yatri->name }}</h5>
                        </div>
                        @php $booked = ($booking_counts[$yatri->id] ?? 0); @endphp
                        <span class="pkg-history {{ $booked > 0 ? '' : 'none' }}">
                            <i class="fa fa-users"></i>
                            {{ $booked > 0 ? $booked.' '.\Illuminate\Support\Str::plural('Yatri', $booked).' selected this package' : 'No one has selected this yet' }}
                        </span>
                        <div class="pkg-card-body">
                            <p class="pkg-tier"><i class="fa fa-star"></i> 5 Star</p>
                            <ul class="pkg-prices">
                                <li><span>Round Trip</span><b>{{ $yatri->five_star_round_price !== null && $yatri->five_star_round_price !== '' ? '$'.$yatri->five_star_round_price : '—' }}</b></li>
                                <li><span>One Way</span><b>{{ $yatri->five_star_single_price !== null && $yatri->five_star_single_price !== '' ? '$'.$yatri->five_star_single_price : '—' }}</b></li>
                                <li><span>Land Only</span><b>{{ $yatri->five_star_land_price !== null && $yatri->five_star_land_price !== '' ? '$'.$yatri->five_star_land_price : '—' }}</b></li>
                            </ul>
                            <p class="pkg-tier four"><i class="fa fa-star"></i> 4 Star</p>
                            <ul class="pkg-prices">
                                <li><span>Round Trip</span><b>{{ $yatri->four_star_round_price !== null && $yatri->four_star_round_price !== '' ? '$'.$yatri->four_star_round_price : '—' }}</b></li>
                                <li><span>One Way</span><b>{{ $yatri->four_star_single_price !== null && $yatri->four_star_single_price !== '' ? '$'.$yatri->four_star_single_price : '—' }}</b></li>
                                <li><span>Land Only</span><b>{{ $yatri->four_star_land_price !== null && $yatri->four_star_land_price !== '' ? '$'.$yatri->four_star_land_price : '—' }}</b></li>
                            </ul>
                        </div>
                        <div class="pkg-card-actions">
                            <a href="{{ url('admin/apply_packages/edit', $yatri->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <a href="{{ url('packages', $yatri->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
                            <form method="POST" action="{{ url('/admin/apply_packages/copy', $yatri->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm" title="Create a new package from this one — opens the copy ready to edit">
                                    <i class="fa fa-copy"></i> Copy
                                </button>
                            </form>
                            @if($booked > 0)
                                <button type="button" class="btn btn-secondary btn-sm" disabled
                                    title="Cannot delete — {{ $booked }} Yatri(s) have availed this package">
                                    <i class="fa fa-lock"></i> {{ $booked }} booked
                                </button>
                            @else
                                <form method="POST" action="{{ url('/admin/apply_packages/delete', $yatri->id) }}">
                                    @csrf
                                    <input name="_method" type="hidden" value="GET">
                                    <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="pkg-empty">No packages found.</div></div>
                @endforelse
            </div>
            <div class="pkg-empty" id="pkgNoResults" style="display:none;">No packages match your search.</div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('pkgSearch');
        var items = Array.prototype.slice.call(document.querySelectorAll('.pkg-item'));
        var noResults = document.getElementById('pkgNoResults');
        if (!input) return;
        input.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim();
            var visible = 0;
            items.forEach(function (el) {
                var match = el.getAttribute('data-search').indexOf(q) !== -1;
                el.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            noResults.style.display = (visible === 0 && items.length) ? 'block' : 'none';
        });
    })();
</script>
@endsection
