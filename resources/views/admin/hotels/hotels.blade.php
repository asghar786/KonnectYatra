@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Hotels</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Hotels</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/hotels/create') }}" class="btn btn-primary">
                Add Hotel <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Hotel Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Address</th>
                                <th scope="col">State</th>
                                <th scope="col">City</th>
                                <th scope="col">Zip Code</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($hotels) > 0)
                            @foreach($hotels as $hotel)
                            <tr>
                                <td class="text-center">{{$hotel->name}}</td>
                                <td class="text-center">{{$hotel->price}}</td>
                                <td class="text-center">{{$hotel->phone}}</td>
                                <td class="text-center">{{$hotel->address}}</td>
                                <td class="text-center">{{$hotel->state}}</td>
                                <td class="text-center">{{$hotel->city}}</td>
                                <td class="text-center">{{$hotel->zip}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/hotels/edit', $hotel->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$hotel->id}}"></a>
                                        <form method="POST" action="{{ url('/admin/hotels/delete', $hotel->id) }}">
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