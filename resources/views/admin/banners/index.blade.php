@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .wc-hint{color:#8a91a0;font-size:13px;margin:4px 0 18px}
    .wc-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);overflow:hidden}
    .wc-table{width:100%;border-collapse:separate;border-spacing:0;margin:0}
    .wc-table thead th{background:#1f2a44;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding:15px 18px;text-align:left;white-space:nowrap;border:none}
    .wc-table tbody td{padding:16px 18px;font-size:14px;color:#2c3446;border-bottom:1px solid #f0f2f6;vertical-align:middle}
    .wc-table tbody tr:last-child td{border-bottom:none}
    .wc-table tbody tr{transition:background .12s}
    .wc-table tbody tr:hover{background:#f9fafc}
    .wc-page{font-weight:600;color:#1f2a44}
    .wc-thumb{width:230px;height:92px;border-radius:10px;object-fit:cover;background:#f1f2f6;display:block}
    .wc-sub{color:#9aa1ad;font-size:13px;font-style:italic}
    .wc-upload{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
    .wc-upload .form-control{max-width:300px;border-radius:8px}
    .wc-upload form{margin:0}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Page Banners</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Page Banners</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <p class="wc-hint">Upload the title/banner background image shown at the top of each public page. Recommended size: ~1920×500px.</p>

            <div class="wc-card">
                <table class="wc-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th>Current Banner</th>
                            <th>Upload New</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td><span class="wc-page">{{ $banner->label }}</span></td>
                            <td>
                                @if(!empty($banner->image))
                                <img class="wc-thumb" src="{{ asset('banners/'.$banner->image) }}" alt="{{ $banner->label }}">
                                @else
                                <span class="wc-sub">Using default image</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ url('admin/page-banners', $banner->id) }}" enctype="multipart/form-data" class="wc-upload">
                                    @csrf
                                    <input type="file" name="image" accept="image/*" class="form-control" required>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
