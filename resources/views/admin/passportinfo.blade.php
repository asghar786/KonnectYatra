@extends('admin.layouts.app')
@section('content')
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
            <div class="db-breadcrumb">
                <h4 class="breadcrumb-title">Passport & NICOP</h4>
            </div>
            {{-- student-table --}}
            <div class="container-fluid mt-4 p-4">
                <div class="row p-3">
                    <div class="col-12">
                        <table  class="table table-striped" id="myTables">
                            <thead>
                                <tr bgcolor="#4c1864" >
                                <th scope="col"><font color="#fff">Name</font></th>
                                <th scope="col"><font color="#fff">CNIC</font></th>
                                <th scope="col"><font color="#fff">NICOP </font></th>
                                <th scope="col"><font color="#fff">Passport</font></th>
                                <th scope="col"><font color="#fff">Email</font></th>
                                <th scope="col"><font color="#fff">Action</font></th>
                                </tr>
                            </thead>
                            <tbody id="mytable">
                                @foreach($passports as $data)
                                <tr>
                                <td data-label="Name">{{$data->firstname}}</td>
                                <td data-label="nicpnumber">{{$data->nicpnumber}}</td>
                                <td data-label="nicopnumber">{{$data->nicopnumber}}</td>
                                <td data-label="passport">{{$data->passportnumber}}</td>
                                <td data-label="email">{{$data->email}}</td>
                                <td>
                                    <span style="display: flex;">
                                        <form method="POST" action="{{ route('passportinfo-delete', $data->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm"  title='Delete' style="padding: 11px;"><i class=" text-white fa fa-trash"></i></button>
                                        </form>&nbsp;
                                        <a href="passportedit/showdata/{{$data->id}}" class="btn bg-warning" style="padding: 11px;"><i class="text-white fa fa-edit"></i></a>
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
    <script src="{{asset('adminassets/js/passportinfo.js')}}"></script>
@endsection
