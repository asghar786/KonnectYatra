@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">SEO Settings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>SEO Settings</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card" style="border-radius:14px">
                        <div class="card-body">
                            <h5 style="font-weight:700"><i class="fas fa-magnifying-glass-chart text-success"></i> Website SEO</h5>
                            <p class="text-muted">These details are used across the whole website — they fill the page title, meta description, keywords and social-share (Open Graph) tags that Google and social networks read.</p>

                            <form method="POST" action="{{ url('admin/seo') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form_label_color">Meta Title</label>
                                    <input type="text" name="seo_title" class="form-control" maxlength="255" value="{{ $seo_title }}" placeholder="Konnect Yatra — Holy Yatra Tours to Pakistan">
                                    <small class="text-muted">Best kept under ~60 characters. Shown as the browser tab title and the headline in Google results.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Meta Description</label>
                                    <textarea name="seo_description" class="form-control" rows="3" maxlength="500" placeholder="Konnect Yatra arranges holy yatra tours to Nankana Sahib, Panja Sahib and Kartarpur Sahib...">{{ $seo_description }}</textarea>
                                    <small class="text-muted">~150–160 characters works best. This is the grey summary text in search results.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Meta Keywords</label>
                                    <input type="text" name="seo_keywords" class="form-control" maxlength="500" value="{{ $seo_keywords }}" placeholder="sikh yatra, nankana sahib, kartarpur, gurdwara tours">
                                    <small class="text-muted">Comma-separated. Optional and low impact, but kept for completeness.</small>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form_label_color">Social Share Image (Open Graph)</label>
                                    <input type="file" name="og_image" accept="image/*" class="form-control">
                                    <small class="text-muted">Shown when your link is shared on Facebook/WhatsApp/LinkedIn. Recommended 1200×630px.</small>
                                    @if(!empty($seo_og_image))
                                    <div class="mt-2"><img src="{{ asset($seo_og_image) }}" style="width:260px;max-height:140px;object-fit:cover;border-radius:8px"></div>
                                    @endif
                                </div>
                                <button class="btn btn-primary mt-3">Save SEO Settings</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="border-radius:14px;background:#f8f9fb">
                        <div class="card-body">
                            <h6 style="font-weight:700">Good to know</h6>
                            <ul style="font-size:13px;padding-left:18px;line-height:1.8">
                                <li>These act as the <strong>site-wide defaults</strong>. Individual blog posts already use their own title/description.</li>
                                <li>For <strong>Google Search Console verification</strong> and <strong>Microsoft Clarity</strong>, use <a href="{{ route('integrations') }}">Settings → Integrations</a>.</li>
                                <li>Google Analytics (GA4) is also under Integrations.</li>
                                <li>After saving, share a page link in WhatsApp/Facebook to preview the title, description and image.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
