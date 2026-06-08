@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .gle-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 26px rgba(28,37,65,.07);overflow:hidden}
    .gle-card .hd{padding:16px 22px;border-bottom:1px solid #f1f2f6;font-weight:700;color:#1c2541;display:flex;align-items:center;gap:8px}
    .gle-card .bd{padding:22px}
    .gle-label{font-weight:600;color:#333;margin-bottom:6px;display:block}
    .gle-label small{font-weight:400;color:#9aa0ac}
    .gle-drop{border:2px dashed #d8dbe2;border-radius:12px;padding:18px;text-align:center;color:#9aa0ac;cursor:pointer;transition:.15s}
    .gle-drop:hover{border-color:#f54e18;color:#f54e18}
    .gle-drop input{display:none}
    /* Focus picker */
    .gle-focus{display:flex;gap:26px;flex-wrap:wrap;align-items:flex-start}
    #focusWrap{position:relative;display:inline-block;max-width:560px;border:1px solid #e2e2e2;border-radius:12px;overflow:hidden;cursor:crosshair;line-height:0;background:#f3f4f6}
    #focusImg{max-width:560px;width:100%;display:block}
    #focusMarker{position:absolute;width:28px;height:28px;border:3px solid #fff;border-radius:50%;box-shadow:0 0 0 2px rgba(245,78,24,.95),0 2px 10px rgba(0,0,0,.45);transform:translate(-50%,-50%);pointer-events:none}
    #focusPreview{width:280px;height:200px;background:#f3f4f6 no-repeat center/cover;border-radius:14px;border:1px solid #e2e2e2;box-shadow:0 6px 18px rgba(0,0,0,.08)}
    .gle-hint{font-size:12.5px;color:#9aa0ac;margin-top:7px;line-height:1.5}
    .gle-tag{display:inline-block;background:#fff4ef;color:#f54e18;border:1px solid #ffd9c9;border-radius:20px;font-size:12px;font-weight:600;padding:3px 12px;margin-bottom:10px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gallery</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/gallery') }}">Gallery</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="focus_x" id="focus_x" value="{{ @$gallery->focus_x ?? 50 }}">
                <input type="hidden" name="focus_y" id="focus_y" value="{{ @$gallery->focus_y ?? 50 }}">

                <div class="row">
                    <!-- Left: details -->
                    <div class="col-lg-5 mb-4">
                        <div class="gle-card">
                            <div class="hd"><i class="fa fa-info-circle text-info"></i> Image Details</div>
                            <div class="bd">
                                <div class="form-group">
                                    <label class="gle-label">Caption</label>
                                    <input type="text" class="form-control" value="{{ @$gallery->caption }}" name="caption" placeholder="Shown on the website">
                                </div>
                                <div class="form-group">
                                    <label class="gle-label">Note <small>(internal — not shown on the website)</small></label>
                                    <textarea class="form-control" name="note" rows="4" placeholder="e.g. names of people in the photo, event date, where it was taken…">{{ @$gallery->note }}</textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="gle-label">{{ !empty(@$gallery->image) ? 'Replace Image' : 'Upload Image' }}</label>
                                    <label class="gle-drop" id="gleDrop">
                                        <i class="fa fa-cloud-upload-alt fa-2x d-block mb-2"></i>
                                        <span id="gleDropText">Click to choose an image{{ !empty(@$gallery->image) ? ' (leave empty to keep current)' : '' }}</span>
                                        <input type="file" name="image" accept="image/*" @if(empty(@$gallery->image)) required @endif>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: focus picker -->
                    <div class="col-lg-7 mb-4">
                        <div class="gle-card">
                            <div class="hd"><i class="fa fa-crosshairs text-danger"></i> Thumbnail Focus</div>
                            <div class="bd">
                                <span class="gle-tag">The full image is always kept — this only picks what the card/thumbnail frames</span>
                                <div class="gle-focus">
                                    <div>
                                        <div class="gle-label" style="font-weight:500;font-size:13px;">Full image — click the part to keep visible</div>
                                        <div id="focusWrap">
                                            <img id="focusImg" src="{{ !empty(@$gallery->image) ? asset('gallery/'.$gallery->image) : '' }}" alt="">
                                            <div id="focusNoImg" style="padding:70px 30px;color:#aaa;text-align:center;font-size:14px;@if(!empty(@$gallery->image))display:none;@endif">Choose an image to set its focus.</div>
                                            <div id="focusMarker" style="@if(empty(@$gallery->image))display:none;@endif"></div>
                                        </div>
                                        <div class="gle-hint">Tip: click on the faces (or the main subject). The picker keeps the full picture for the lightbox — it only changes the thumbnail.</div>
                                    </div>
                                    <div>
                                        <div class="gle-label" style="font-weight:500;font-size:13px;">Card preview</div>
                                        <div id="focusPreview"></div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="focusReset"><i class="fa fa-undo"></i> Center</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ url('admin/gallery') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">{{ @$btn_text }}</button>
                </div>
            </form>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
(function () {
    var wrap = document.getElementById('focusWrap');
    if (!wrap) return;
    var img = document.getElementById('focusImg');
    var marker = document.getElementById('focusMarker');
    var preview = document.getElementById('focusPreview');
    var noImg = document.getElementById('focusNoImg');
    var fx = document.getElementById('focus_x');
    var fy = document.getElementById('focus_y');
    var fileInput = document.querySelector('input[name="image"]');
    var dropText = document.getElementById('gleDropText');
    var resetBtn = document.getElementById('focusReset');

    function hasImg() { return img.getAttribute('src') && img.getAttribute('src') !== ''; }

    function render() {
        var x = parseFloat(fx.value); if (isNaN(x)) x = 50;
        var y = parseFloat(fy.value); if (isNaN(y)) y = 50;
        marker.style.left = x + '%';
        marker.style.top = y + '%';
        if (hasImg()) {
            preview.style.backgroundImage = 'url("' + img.src + '")';
            preview.style.backgroundPosition = x + '% ' + y + '%';
        }
    }

    wrap.addEventListener('click', function (e) {
        if (!hasImg()) return;
        var r = img.getBoundingClientRect();
        fx.value = Math.round(Math.min(100, Math.max(0, ((e.clientX - r.left) / r.width) * 100)));
        fy.value = Math.round(Math.min(100, Math.max(0, ((e.clientY - r.top) / r.height) * 100)));
        render();
    });

    if (resetBtn) resetBtn.addEventListener('click', function () { fx.value = 50; fy.value = 50; render(); });

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            var f = this.files && this.files[0];
            if (!f) return;
            if (dropText) dropText.textContent = f.name;
            var reader = new FileReader();
            reader.onload = function (ev) {
                img.onload = function () { render(); };
                img.src = ev.target.result;
                img.style.display = 'block';
                if (noImg) noImg.style.display = 'none';
                marker.style.display = 'block';
                fx.value = 50; fy.value = 50;
            };
            reader.readAsDataURL(f);
        });
    }

    if (hasImg()) { img.complete ? render() : (img.onload = render); }
})();
</script>
@endsection
