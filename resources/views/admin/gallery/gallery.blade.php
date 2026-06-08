@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    /* Hide any DataTables export buttons that may be injected globally */
    .dt-buttons{display:none !important;}
    /* Card view for Gallery */
    .gl-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .gl-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .gl-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .gl-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:border-color .15s,box-shadow .15s}
    .gl-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .gl-card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .gl-card:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
    .gl-photo{height:190px;background:#f3f4f6;overflow:hidden;position:relative;cursor:zoom-in}
    .gl-photo::after{content:"\f00e";font-family:"Font Awesome 5 Free";font-weight:900;position:absolute;top:10px;left:10px;background:rgba(0,0,0,.45);color:#fff;width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:13px;opacity:0;transition:.15s}
    .gl-card:hover .gl-photo::after{opacity:1}
    /* Lightbox */
    #glLightbox{position:fixed;inset:0;background:rgba(0,0,0,.9);display:none;align-items:center;justify-content:center;z-index:99999;padding:30px}
    #glLightbox img{max-width:95%;max-height:90%;border-radius:8px;box-shadow:0 10px 40px rgba(0,0,0,.5)}
    #glLightbox .gl-cap{position:absolute;bottom:22px;left:0;right:0;text-align:center;color:#fff;font-size:15px}
    #glLightbox .gl-close{position:absolute;top:18px;right:26px;color:#fff;font-size:34px;cursor:pointer;line-height:1}
    .gl-photo img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
    .gl-card:hover .gl-photo img{transform:scale(1.05)}
    .gl-body{padding:14px 16px;flex:1}
    .gl-body p{margin:0;font-size:14px;color:#333;line-height:1.45;font-weight:600}
    .gl-note{margin:8px 0 0;font-size:12.5px;color:#777;line-height:1.45;display:flex;gap:6px}
    .gl-note i{color:#f5a623;margin-top:2px}
    .gl-actions{display:flex;gap:8px;padding:12px 16px;border-top:1px solid #f3f3f3}
    .gl-actions .btn{flex:1;text-align:center}
    .gl-actions form{margin:0;flex:1}
    .gl-actions form .btn{width:100%}
    .gl-empty{padding:40px;text-align:center;color:#999;font-size:16px}
    .gl-count{background:#f54e18;color:#fff;font-size:13px;font-weight:600;padding:6px 14px;border-radius:20px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gallery</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Gallery</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="gl-toolbar">
                <div style="display:flex;align-items:center;gap:12px;">
                    <a href="{{ url('admin/gallery/create') }}" class="btn btn-primary">Add Image <i class="fa fa-plus"></i></a>
                    <span class="gl-count">{{ count($gallery) }} {{ \Illuminate\Support\Str::plural('Image', count($gallery)) }}</span>
                </div>
                <div class="gl-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="glSearch" placeholder="Search by caption…" autocomplete="off">
                </div>
            </div>

            <div class="row mt-4" id="glGrid">
                @forelse($gallery as $value)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 gl-item" data-search="{{ strtolower(trim($value->caption.' '.$value->note)) }}">
                    <div class="gl-card">
                        <div class="gl-photo gl-zoom" data-full="{{ asset('gallery/'.$value->image) }}" data-cap="{{ $value->caption }}">
                            <img src="{{ asset('gallery/'.$value->image) }}" alt="{{ $value->caption }}" style="object-position:{{ $value->focus_x ?? 50 }}% {{ $value->focus_y ?? 50 }}%" onerror="this.style.opacity=.3">
                        </div>
                        <div class="gl-body">
                            <p>{{ $value->caption ?: '—' }}</p>
                            @if(!empty($value->note))
                            <p class="gl-note"><i class="fa fa-sticky-note"></i> <span>{{ $value->note }}</span></p>
                            @endif
                        </div>
                        <div class="gl-actions">
                            <a href="{{ url('admin/gallery/edit', $value->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form method="POST" action="{{ url('/admin/gallery/delete', $value->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="GET">
                                <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="gl-empty">No images in the gallery yet.</div></div>
                @endforelse
            </div>
            <div class="gl-empty" id="glNoResults" style="display:none;">No images match your search.</div>
        </div>
    </div>
</main>

<!-- Full-size lightbox -->
<div id="glLightbox">
    <span class="gl-close">&times;</span>
    <img id="glLightboxImg" src="" alt="">
    <div class="gl-cap" id="glLightboxCap"></div>
</div>

<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('glSearch');
        var items = Array.prototype.slice.call(document.querySelectorAll('.gl-item'));
        var noResults = document.getElementById('glNoResults');
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

    // Full-size lightbox (view the original uncropped picture)
    (function () {
        var box = document.getElementById('glLightbox');
        var boxImg = document.getElementById('glLightboxImg');
        var boxCap = document.getElementById('glLightboxCap');
        if (!box) return;
        document.addEventListener('click', function (e) {
            var zoom = e.target.closest('.gl-zoom');
            if (zoom) {
                boxImg.src = zoom.getAttribute('data-full');
                boxCap.textContent = zoom.getAttribute('data-cap') || '';
                box.style.display = 'flex';
                return;
            }
            if (e.target.closest('#glLightbox')) {
                box.style.display = 'none';
                boxImg.src = '';
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { box.style.display = 'none'; boxImg.src = ''; }
        });
    })();
</script>
@endsection
