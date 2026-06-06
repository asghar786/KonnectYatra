@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .dt-buttons {
        display: none;
    }
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gallery</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Gallery</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/gallery/create') }}" class="btn btn-primary">
                Add Image <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12 pb-5">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Caption</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($gallery) > 0)
                            @foreach($gallery as $value)
                            <tr>
                                <td class="text-center"><img src="{{ asset("gallery/".$value->image) }}" style="width: 150px; height: 100px;"></td>
                                <td class="text-center">{{$value->caption}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/gallery/edit', $value->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$value->id}}"></a>
                                        <form method="POST" action="{{ url('/admin/gallery/delete', $value->id) }}">
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
                                <td colspan="3" class="text-center">No result found.</td>
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