@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Home Slider</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Home Slider</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

            <a href="{{ url('admin/home-slider/create') }}" class="btn btn-primary mb-3">Add Slide <i class="fa fa-plus"></i></a>
            <p class="text-muted">These slides appear in the homepage hero slider. Recommended image size: ~1920×900px.</p>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width:60px;">Order</th>
                                <th scope="col" style="width:200px;">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Buttons</th>
                                <th scope="col" style="width:90px;">Status</th>
                                <th scope="col" style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($slides as $slide)
                            <tr>
                                <td style="vertical-align:middle;">{{ $slide->sort_order }}</td>
                                <td style="vertical-align:middle;">
                                    <img src="{{ asset($slide->image) }}" style="width:180px;height:80px;object-fit:cover;border-radius:6px;" onerror="this.style.display='none'">
                                </td>
                                <td style="vertical-align:middle;">
                                    <strong>{{ $slide->title }}</strong>
                                    @if($slide->eyebrow)<div class="text-muted" style="font-size:12px;">{{ $slide->eyebrow }}</div>@endif
                                </td>
                                <td style="vertical-align:middle;font-size:13px;">
                                    @if($slide->btn1_text)<span class="badge badge-primary">{{ $slide->btn1_text }}</span>@endif
                                    @if($slide->btn2_text)<span class="badge badge-secondary">{{ $slide->btn2_text }}</span>@endif
                                </td>
                                <td style="vertical-align:middle;">
                                    @if($slide->is_active)<span class="badge badge-success">Active</span>@else<span class="badge badge-secondary">Hidden</span>@endif
                                </td>
                                <td style="vertical-align:middle;">
                                    <div style="display:flex;gap:6px;">
                                        <a href="{{ url('admin/home-slider/edit', $slide->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="{{ url('/admin/home-slider/delete', $slide->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn btn-danger btn-sm show_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted" style="padding:30px;">No slides yet. Click "Add Slide" to create one.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
