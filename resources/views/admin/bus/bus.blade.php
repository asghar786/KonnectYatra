@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Bus</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Bus</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/bus/create') }}" class="btn btn-primary">
                Add Bus <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Photo</th>
                                <th scope="col">Bus Number</th>
                                <th scope="col">Driver Name</th>
                                <th scope="col">Driver Phone Number</th>
                                <th scope="col">Capacity</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($bus) > 0)
                            @foreach($bus as $bus)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset("bus/".$bus->file) }}" style="width: 130px; height: 100px;">
                                </td>
                                <td class="text-center">{{$bus->bus_number}}</td>
                                <td class="text-center">{{$bus->driver_name}}</td>
                                <td class="text-center">{{$bus->driver_phone}}</td>
                                <td class="text-center">{{$bus->capacity}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/bus/edit', $bus->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$bus->id}}"></a>
                                        <form method="POST" action="{{ url('/admin/bus/delete', $bus->id) }}">
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
                                <td colspan="7" class="text-center">No result found.</td>
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