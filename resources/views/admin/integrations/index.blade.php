@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Integrations</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Integrations</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card" style="border-radius:14px">
                        <div class="card-body">
                            <h5 style="font-weight:700"><i class="fab fa-google text-danger"></i> Google Analytics 4</h5>
                            <p class="text-muted">Add your GA4 Measurement ID to load Google's tracking tag on the public website alongside the built-in first-party analytics. Find it in GA4 → Admin → Data Streams → your web stream (looks like <code>G-XXXXXXX</code>).</p>

                            <p>Status:
                                @if(!empty($ga4_measurement_id))
                                    <span class="badge badge-success" style="font-size:13px">Active — {{ $ga4_measurement_id }}</span>
                                @else
                                    <span class="badge badge-secondary" style="font-size:13px">Not configured</span>
                                @endif
                            </p>

                            <form method="POST" action="{{ url('admin/integrations') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form_label_color">GA4 Measurement ID</label>
                                    <input type="text" name="ga4_measurement_id" class="form-control" placeholder="G-XXXXXXX" value="{{ $ga4_measurement_id }}">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">GA4 Property ID <span class="text-muted">(optional, for the Data API later)</span></label>
                                    <input type="text" name="ga4_property_id" class="form-control" placeholder="123456789" value="{{ $ga4_property_id }}">
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4" style="border-radius:14px">
                        <div class="card-body">
                            <h5 style="font-weight:700"><i class="fab fa-whatsapp" style="color:#25D366"></i> WhatsApp Chat Button</h5>
                            <p class="text-muted">Add your WhatsApp business number to show a floating chat button on the public website. Leave it empty to hide the button. Use international format (country code first), e.g. <code>+1 718 908 9464</code>.</p>

                            <p>Status:
                                @if(!empty($whatsapp_number))
                                    <span class="badge badge-success" style="font-size:13px">Active — {{ $whatsapp_number }}</span>
                                @else
                                    <span class="badge badge-secondary" style="font-size:13px">Not configured — button hidden</span>
                                @endif
                            </p>

                            <form method="POST" action="{{ url('admin/integrations') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form_label_color">WhatsApp Number</label>
                                    <input type="text" name="whatsapp_number" class="form-control" placeholder="+1 718 908 9464" value="{{ $whatsapp_number }}">
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4" style="border-radius:14px">
                        <div class="card-body">
                            <h5 style="font-weight:700"><i class="fas fa-share-nodes text-primary"></i> Social Media Links</h5>
                            <p class="text-muted">
                                Paste the full URLs of your social profiles. These power the social icons in the
                                website header, footer and Contact page &mdash; and they are published as
                                <code>sameAs</code> in your Schema.org data, which is how Google confirms this
                                website and your social pages are the same organisation.
                                <strong>Leave a field empty and that icon simply won't appear</strong> &mdash;
                                only profiles with a real URL are shown, so visitors never click a dead link.
                            </p>

                            <form method="POST" action="{{ url('admin/integrations') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form_label_color"><i class="fab fa-facebook-f" style="color:#1877F2"></i> Facebook URL</label>
                                    <input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/yourpage" value="{{ $facebook_url }}">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color"><i class="fab fa-twitter" style="color:#1DA1F2"></i> Twitter / X URL</label>
                                    <input type="url" name="twitter_url" class="form-control" placeholder="https://twitter.com/yourhandle" value="{{ $twitter_url }}">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color"><i class="fab fa-instagram" style="color:#E4405F"></i> Instagram URL</label>
                                    <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/yourhandle" value="{{ $instagram_url }}">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color"><i class="fab fa-linkedin" style="color:#0A66C2"></i> LinkedIn URL</label>
                                    <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/company/yourcompany" value="{{ $linkedin_url }}">
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4" style="border-radius:14px">
                        <div class="card-body">
                            <h5 style="font-weight:700"><i class="fas fa-magnifying-glass-chart text-success"></i> Search Console &amp; Clarity</h5>
                            <p class="text-muted">Verify your site with Google Search Console and add Microsoft Clarity for free heatmaps &amp; session recordings. Both are injected into every page automatically once saved.</p>

                            <form method="POST" action="{{ url('admin/integrations') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form_label_color"><i class="fab fa-google text-danger"></i> Google Search Console — Verification Code</label>
                                    <input type="text" name="google_site_verification" class="form-control" placeholder="content value of the google-site-verification meta tag" value="{{ $google_site_verification }}">
                                    <small class="text-muted">In Search Console choose the <b>HTML tag</b> method and paste only the <code>content="..."</code> value here (not the whole tag).</small>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color"><i class="fab fa-microsoft" style="color:#3C3C3C"></i> Microsoft Clarity — Project ID</label>
                                    <input type="text" name="clarity_project_id" class="form-control" placeholder="e.g. abcdef1234" value="{{ $clarity_project_id }}">
                                    <small class="text-muted">From Clarity → Settings → Setup, copy the Project ID (the short code in <code>clarity.ms/tag/<b>XXXX</b></code>).</small>
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="border-radius:14px;background:#f8f9fb">
                        <div class="card-body">
                            <h6 style="font-weight:700">How it works</h6>
                            <ul style="font-size:13px;padding-left:18px;line-height:1.8">
                                <li>Saving a Measurement ID injects the <code>gtag.js</code> tag site-wide — Google starts collecting immediately.</li>
                                <li>The built-in <a href="{{ url('admin/analytics') }}">Analytics dashboard</a> keeps working independently (your own data).</li>
                                <li><strong>Pulling GA metrics into this dashboard</strong> (GA4 Data API) is the next step — it needs a Google service-account key and the <code>google/apiclient</code> package. Add the Property ID above and let your developer enable it.</li>
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
