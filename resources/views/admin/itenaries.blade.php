@extends('admin.layouts.app')
@section('content')
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb" >
                <h4 class="breadcrumb-title">Iternaries Information</h4>
			</div>
            <div class="container-fluid mt-4 p-4">
                <div class="row p-3">
                    <div class="col-12">
                        <table  class="table table-striped" id="myTables">
                            <thead>
                                <tr bgcolor="#4c1864"  >
                                <th scope="col"><font color="#fff">#</font></th>
                                <th scope="col"><font color="#fff">Name</font></th>
                                <th scope="col"><font color="#fff">Email</font></th>
                                <th scope="col"><font color="#fff">From</font></th>
                                <th scope="col"><font color="#fff">To</font></th>
                                <th scope="col"><font color="#fff">Passengers</font></th>
                                <th scope="col"><font color="#fff">Action</font></th>
                                </tr>
                            </thead>
                            <tbody id="mytable">
                            @foreach($itenaries as $itenary)
                                <tr>
                                <th scope="row">{{$itenary->id}}</th>
                                <td data-label="Name">{{$itenary->name}}</td>
                                <td data-label="email">{{$itenary->email}}</td>
                                <td data-label="from">{{$itenary->from}}</td>
                                <td data-label="to">{{$itenary->to}}</td>
                                <td data-label="passengers">{{$itenary->passengers}}</td>
                                <td style="text-align:center;">
                                    <span style="display: flex;">
                                        <form method="POST" action="{{ route('itenaries-delete',$itenary->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm"  title='Delete' style="padding: 11px;"><i class=" text-white fa fa-trash"></i></button>
                                        </form>&nbsp;
                                        <a href="itenaries/ticket/{{$itenary->id}}" class="btn bg-warning" style="padding: 11px;"><i class="text-white fa fa-user"></i></a>
                                    </span>
                                </td>
                                </tr>
                               @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
	<div class="ttr-overlay"></div>
    <script src="{{asset('adminassets/js/itenaries.js')}}"></script>
@endsection
