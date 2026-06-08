@extends('admin.layouts.app')
@section('content')
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
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-12">
                    <form method="POST" action="{{ @$action }}" class="admin_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Caption</label>
                                <input type="text" class="form-control require" value="{{@$gallery->caption}}" name="caption" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Image</label>
                                <input type="file" class="form-control require" name="image" @if(empty(@$gallery->image)) required="" @endif />
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Note <span class="text-muted">(internal — not shown on the website)</span></label>
                                <textarea class="form-control" name="note" rows="3" placeholder="e.g. names of people in the photo, event date, where it was taken…">{{ @$gallery->note }}</textarea>
                            </div>

                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Thumbnail Focus <span class="text-muted">(click on the image to choose the part that stays visible in the card)</span></label>
                                <input type="hidden" name="focus_x" id="focus_x" value="{{ @$gallery->focus_x ?? 50 }}">
                                <input type="hidden" name="focus_y" id="focus_y" value="{{ @$gallery->focus_y ?? 50 }}">
                                <div style="display:flex;gap:26px;flex-wrap:wrap;align-items:flex-start;">
                                    <div>
                                        <div class="text-muted" style="font-size:13px;margin-bottom:6px;">Full image — click to set focus</div>
                                        <div id="focusWrap" style="position:relative;display:inline-block;max-width:520px;border:1px solid #e2e2e2;border-radius:10px;overflow:hidden;cursor:crosshair;line-height:0;">
                                            <img id="focusImg" src="{{ !empty(@$gallery->image) ? asset('gallery/'.$gallery->image) : '' }}" style="max-width:520px;width:100%;display:block;" alt="">
                                            <div id="focusNoImg" style="padding:60px 30px;color:#aaa;text-align:center;font-size:14px;@if(!empty(@$gallery->image))display:none;@endif">Choose an image above to set its focus.</div>
                                            <div id="focusMarker" style="position:absolute;width:26px;height:26px;border:3px solid #fff;border-radius:50%;box-shadow:0 0 0 2px rgba(245,78,24,.9),0 2px 8px rgba(0,0,0,.4);transform:translate(-50%,-50%);pointer-events:none;@if(empty(@$gallery->image))display:none;@endif"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-muted" style="font-size:13px;margin-bottom:6px;">Card preview</div>
                                        <div id="focusPreview" style="width:270px;height:190px;background:#f3f4f6 no-repeat center/cover;border-radius:12px;border:1px solid #e2e2e2;"></div>
                                        <div class="text-muted" style="font-size:12px;margin-top:6px;">This is exactly how the card thumbnail will look.</div>
                                    </div>
                                </div>
                            </div>

                            @if(!empty(@$gallery->image))
                            <div class="form-group col-md-6">
                                <img src="{{ asset('gallery/'.@$gallery->image) }}" height="300" width="300">
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: right;">{{ @$btn_text }}</button>
                        <div class="response"></div>
                    </form>
                </div>
            </div>
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
        var x = Math.min(100, Math.max(0, ((e.clientX - r.left) / r.width) * 100));
        var y = Math.min(100, Math.max(0, ((e.clientY - r.top) / r.height) * 100));
        fx.value = Math.round(x);
        fy.value = Math.round(y);
        render();
    });

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            var f = this.files && this.files[0];
            if (!f) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                img.onload = function () { render(); };
                img.src = ev.target.result;
                img.style.display = 'block';
                if (noImg) noImg.style.display = 'none';
                marker.style.display = 'block';
                fx.value = 50; fy.value = 50; // fresh image → centre
            };
            reader.readAsDataURL(f);
        });
    }

    if (hasImg()) { img.complete ? render() : (img.onload = render); }
})();
</script>
@endsection