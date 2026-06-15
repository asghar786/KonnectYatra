@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .gl-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin-bottom:8px}
    .gl-search{position:relative;flex:1;min-width:240px;max-width:420px}
    .gl-search i{position:absolute;top:50%;left:14px;transform:translateY(-50%);color:#aaa;font-size:14px}
    .gl-search input{width:100%;padding:11px 14px 11px 38px;border:1px solid #e2e2e2;border-radius:30px;font-size:14px;outline:none;transition:.15s}
    .gl-search input:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .gl-card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,.07);height:100%;display:flex;flex-direction:column;transition:transform .15s,box-shadow .15s}
    .gl-card:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
    .gl-card.c-green{border-top:4px solid #2fbf4f}
    .gl-card.c-yellow{border-top:4px solid #e8c220}
    .gl-card.c-red{border-top:4px solid #e94e35}
    .gl-photo{height:180px;background:#f3f4f6;overflow:hidden;position:relative}
    .gl-photo img{width:100%;height:100%;object-fit:cover;display:block}
    .gl-sangat{position:absolute;top:10px;left:10px;background:rgba(0,0,0,.55);color:#fff;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px}
    .gl-body{padding:14px 16px;flex:1}
    .gl-body h5{margin:0 0 8px;font-size:15.5px;font-weight:700;color:#222;line-height:1.3}
    .gl-meta{list-style:none;padding:0;margin:0}
    .gl-meta li{display:flex;gap:8px;font-size:12.5px;color:#555;padding:3px 0;word-break:break-word}
    .gl-meta li i{color:#f54e18;width:14px;text-align:center;margin-top:2px;flex-shrink:0}
    .gl-actions{display:flex;gap:8px;padding:10px 15px;border-top:1px solid #f3f3f3}
    .gl-actions .btn{flex:1;text-align:center}
    .gl-actions form{margin:0;flex:1}
    .gl-actions form .btn{width:100%}
    .gl-empty{padding:40px;text-align:center;color:#999;font-size:16px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gurdwara</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Gurdwara</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="gl-toolbar">
                <a href="{{ route('create-gurdwara') }}" class="btn btn-primary">Add Gurdwara <i class="fa fa-plus"></i></a>
                <div class="gl-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="glSearch" placeholder="Search by name, city or state…" autocomplete="off">
                </div>
            </div>

            <div class="row mt-4" id="glGrid">
                @forelse($gurdwaras as $gurdwara)
                @php
                    $colorClass = $gurdwara->color == 'Green' ? 'c-green' : ($gurdwara->color == 'Yellow' ? 'c-yellow' : ($gurdwara->color == 'Red' ? 'c-red' : ''));
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 gl-item" data-search="{{ strtolower(trim($gurdwara->gurdwara_name.' '.$gurdwara->city.' '.$gurdwara->state.' '.$gurdwara->address)) }}">
                    <div class="gl-card {{ $colorClass }}">
                        <div class="gl-photo">
                            <img src="{{ asset('gurdwara_images/'.$gurdwara->gurdwara_image) }}" alt="{{ $gurdwara->gurdwara_name }}" onerror="this.src='{{ asset('assets/images2/News-04.png') }}'">
                            @if(!empty($gurdwara->sangat))<span class="gl-sangat">{{ $gurdwara->sangat }} Sangat</span>@endif
                        </div>
                        <div class="gl-body">
                            <h5>{{ $gurdwara->gurdwara_name }}</h5>
                            <ul class="gl-meta">
                                <li><i class="fa fa-location-dot"></i><span>{{ trim(collect([$gurdwara->address, $gurdwara->city, $gurdwara->state, $gurdwara->country])->filter()->implode(', ')) ?: '—' }}</span></li>
                                @if(!empty($gurdwara->phone_no))<li><i class="fa fa-phone"></i><span>{{ $gurdwara->phone_no }}</span></li>@endif
                                @if(!empty($gurdwara->email_address))<li><i class="fa fa-envelope"></i><span>{{ $gurdwara->email_address }}</span></li>@endif
                            </ul>
                        </div>
                        <div class="gl-actions">
                            <a href="{{ route('edit-gurdwara', $gurdwara->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form method="POST" action="{{ route('delete-gurdwara', $gurdwara->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="GET">
                                <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><div class="gl-empty">No gurdwaras added yet.</div></div>
                @endforelse
            </div>
            <div class="gl-empty" id="glNoResults" style="display:none;">No gurdwaras match your search.</div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('glSearch');
        var items = Array.prototype.slice.call(document.querySelectorAll('.gl-item'));
        var noRes = document.getElementById('glNoResults');
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
