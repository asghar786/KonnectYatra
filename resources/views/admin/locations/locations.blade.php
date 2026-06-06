@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Locations</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Locations</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/locations/create') }}" class="btn btn-primary">
                Add Location <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Location Name</th>
                                <th scope="col">State</th>
                                <th scope="col">City</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($locations) > 0)
                            @foreach($locations as $location)
                            <tr>
                                <td class="text-center"><img src="{{ asset("locations/".$location->image) }}" style="width: 100px; height: 100px;"></td>
                                <td class="text-center">{{$location->name}}</td>
                                <td class="text-center">{{$location->state}}</td>
                                <td class="text-center">{{$location->city}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/locations/edit', $location->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$location->id}}"></a>
                                        <form method="POST" action="{{ url('/admin/locations/delete', $location->id) }}">
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
                                <td colspan="5" class="text-center">No result found.</td>
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