@extends('layouts.app')
@section('content')
<style type="text/css">
    .galp{--brand:#f54e18;--ink:#1c2541}
    .galp-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
    .galp-item{position:relative;border-radius:20px;overflow:hidden;cursor:zoom-in;box-shadow:0 10px 30px rgba(28,37,65,.10);background:#f1f2f6}
    .galp-item img{width:100%;height:280px;object-fit:cover;display:block;transition:transform .35s}
    .galp-item:hover img{transform:scale(1.06)}
    .galp-cap{position:absolute;left:0;right:0;bottom:0;padding:34px 16px 14px;color:#fff;font-size:14px;font-weight:600;
        background:linear-gradient(to top,rgba(0,0,0,.75),rgba(0,0,0,0));opacity:0;transition:.2s}
    .galp-item:hover .galp-cap{opacity:1}
    .galp-zoomic{position:absolute;top:12px;right:12px;background:rgba(0,0,0,.45);color:#fff;width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;opacity:0;transition:.2s}
    .galp-item:hover .galp-zoomic{opacity:1}
    .galp-empty{padding:60px 20px;text-align:center;color:#9aa0ac;font-size:18px}
    @media (max-width:991px){.galp-grid{grid-template-columns:repeat(2,1fr)}}
    @media (max-width:575px){.galp-grid{grid-template-columns:1fr}.galp-item img{height:240px}}
    /* Lightbox */
    #galpLb{position:fixed;inset:0;background:rgba(0,0,0,.92);display:none;align-items:center;justify-content:center;z-index:99999;padding:30px}
    #galpLb img{max-width:94%;max-height:88%;border-radius:10px;box-shadow:0 12px 50px rgba(0,0,0,.6)}
    #galpLb .cap{position:absolute;bottom:24px;left:0;right:0;text-align:center;color:#fff;font-size:16px;padding:0 20px}
    #galpLb .cls{position:absolute;top:18px;right:28px;color:#fff;font-size:38px;cursor:pointer;line-height:1}
    #galpLb .nav{position:absolute;top:50%;transform:translateY(-50%);color:#fff;font-size:42px;cursor:pointer;user-select:none;padding:10px 18px;opacity:.8}
    #galpLb .nav:hover{opacity:1}
    #galpLb .prev{left:10px}#galpLb .next{right:10px}
</style>

<main id="content" class="site-main galp">
    <section class="inner-banner-wrap pb-0">
        <div class="inner-baner-container"
            style="background-image: url('{{ \App\Models\PageBanner::url('gallery', asset('assets/images2/News-04.png')) }}');background-position:center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:60px !important;">OUR TOUR GALLERY</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="section-sp2">
        <div class="container">
            <div class="section-heading text-center" style="margin-bottom:36px">
                <h5 class="dash-style" style="color:var(--brand)">EXPLORE OUR GALLERY</h5>
                <h2 style="font-weight:700;color:var(--ink)">Moments From Our Tours</h2>
                <p class="text-muted" style="max-width:720px;margin:8px auto 0">
                    A collection of captivating photographs capturing the essence of our previous tours — the unique moments and experiences from our journeys.
                </p>
            </div>

            @if(count($gallery) > 0)
            <div class="galp-grid">
                @foreach($gallery as $value)
                <div class="galp-item" data-full="{{ asset('gallery/'.$value->image) }}" data-cap="{{ $value->caption }}">
                    <img src="{{ asset('gallery/'.$value->image) }}" alt="{{ $value->caption }}"
                         style="object-position:{{ $value->focus_x ?? 50 }}% {{ $value->focus_y ?? 50 }}%">
                    <span class="galp-zoomic"><i class="fa fa-search-plus"></i></span>
                    @if(!empty($value->caption))<div class="galp-cap">{{ $value->caption }}</div>@endif
                </div>
                @endforeach
            </div>
            @else
            <div class="galp-empty">No images in the gallery yet.</div>
            @endif
        </div>
    </section>
</main>

<!-- Lightbox -->
<div id="galpLb">
    <span class="cls">&times;</span>
    <span class="nav prev">&#10094;</span>
    <img id="galpLbImg" src="" alt="">
    <span class="nav next">&#10095;</span>
    <div class="cap" id="galpLbCap"></div>
</div>

<script>
(function () {
    var items = Array.prototype.slice.call(document.querySelectorAll('.galp-item'));
    var lb = document.getElementById('galpLb');
    var lbImg = document.getElementById('galpLbImg');
    var lbCap = document.getElementById('galpLbCap');
    if (!lb) return;
    var current = -1;

    function show(i) {
        if (i < 0) i = items.length - 1;
        if (i >= items.length) i = 0;
        current = i;
        lbImg.src = items[i].getAttribute('data-full');
        lbCap.textContent = items[i].getAttribute('data-cap') || '';
        lb.style.display = 'flex';
    }
    function close() { lb.style.display = 'none'; lbImg.src = ''; }

    items.forEach(function (el, i) { el.addEventListener('click', function () { show(i); }); });
    lb.querySelector('.cls').addEventListener('click', close);
    lb.querySelector('.prev').addEventListener('click', function (e) { e.stopPropagation(); show(current - 1); });
    lb.querySelector('.next').addEventListener('click', function (e) { e.stopPropagation(); show(current + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) {
        if (lb.style.display !== 'flex') return;
        if (e.key === 'Escape') close();
        else if (e.key === 'ArrowLeft') show(current - 1);
        else if (e.key === 'ArrowRight') show(current + 1);
    });
})();
</script>
@endsection
