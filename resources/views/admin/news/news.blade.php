@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">News</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>News</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/news/create') }}" class="btn btn-primary">
                Add News <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">File</th>
                                <th scope="col">News Title</th>
                                <th scope="col">Reported By</th>
                                <th scope="col">File Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($news) > 0)
                            @foreach($news as $value)
                            <tr>
                                <td class="text-center">
                                    @if($value->file_type == "video")
                                    <video style="width: 200px; height: 130px;" controls>
                                        <source src="{{ asset('news_and_events/'.@$value->file) }}" type="video/mp4">
                                        {{-- <source src="movie.ogg" type="video/ogg"> --}}
                                    </video>
                                    @else
                                    <img src="{{ asset("news_and_events/".$value->file) }}" style="width: 200px; height: 130px;">
                                    @endif
                                </td>
                                <td class="text-center">{{$value->title}}</td>
                                <td class="text-center">{{$value->reported_by}}</td>
                                <td class="text-center">{{ucfirst($value->file_type)}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/news/edit', $value->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$value->id}}"></a>
                                        <form method="POST" action="{{ url('/admin/news/delete', $value->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm" title='Delete' style="padding: 11px;"><i class="text-white fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center">No result found.</td>
                            </tr>
                            @endif
                        </tbody>
                        {{-- @endforeach --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection