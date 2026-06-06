@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Blogs</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Blogs</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <a href="{{ url('admin/blogs/create') }}" class="btn btn-primary">
                Add Blog <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Featured Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Published</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($blogs) > 0)
                            @foreach($blogs as $value)
                            <tr>
                                <td class="text-center">
                                    @php $thumb = $value->featured_image ?: $value->image; @endphp
                                    @if(!empty($thumb))
                                    <img src="{{ asset('blog_images/'.$thumb) }}" style="width: 160px; height: 100px; object-fit: cover;">
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center" style="vertical-align: middle;">{{ $value->title }}</td>
                                <td class="text-center" style="vertical-align: middle;">{{ $value->author }}</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    {{ $value->published_date ? date('d M Y', strtotime($value->published_date)) : date('d M Y', strtotime($value->created_at)) }}
                                </td>
                                <td class="text-center" style="vertical-align: middle;">{{ ucfirst($value->status) }}</td>
                                <td style="vertical-align: middle;">
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/blogs/edit', $value->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;"></a>
                                        <a href="{{ url('admin/blogs/delete', $value->id) }}" class="btn bg-danger show_confirm" title='Delete' style="padding: 11px;" onclick="return confirm('Delete this blog?');"><i class="text-white fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">No blogs yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
