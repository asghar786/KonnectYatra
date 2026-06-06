@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Seasons</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Seasons</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/seasons/create') }}" class="btn btn-primary">
                Add Season <i class="fa fa-plus"></i>
            </a>
            <p class="mt-2"><b>Note: </b>If none of the below season is active, new bookings will be created in a last season that you created.</p>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr #</th>
                                <th scope="col">Season Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($seasons) > 0)
                            @foreach($seasons as $season)
                            <tr>
                                <td class="text-center">{{$season->id}}</td>
                                <td class="text-center">{{$season->name}}</td>
                                <td class="text-center">@if($season->status == "1") <span class="badge badge-success p-2">Active</span> @else <span class="badge badge-danger p-2">In Active</span> @endif</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/seasons/edit', $season->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$season->id}}"></a>
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