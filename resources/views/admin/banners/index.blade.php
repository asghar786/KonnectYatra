@extends('admin.layouts.app')
@section('content')
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
            <p class="text-muted">Upload the title/banner background image shown at the top of each public page. Recommended size: ~1920×500px.</p>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Page</th>
                                <th scope="col">Current Banner</th>
                                <th scope="col">Upload New</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                            <tr>
                                <td style="vertical-align: middle;"><strong>{{ $banner->label }}</strong></td>
                                <td style="vertical-align: middle;">
                                    @if(!empty($banner->image))
                                    <img src="{{ asset('banners/'.$banner->image) }}" style="width: 220px; height: 90px; object-fit: cover; border-radius: 6px;">
                                    @else
                                    <span class="text-muted">Using default image</span>
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">
                                    <form method="POST" action="{{ url('admin/page-banners', $banner->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div style="display:flex; gap:10px; align-items:center;">
                                            <input type="file" name="image" accept="image/*" class="form-control" required style="max-width: 320px;">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
