@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Visa Packages</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Admin Can View Yatri Applied Visa Packages</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Month</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($yatries as $package)
                            <tr>
                                <td>{{@$package->last_name.' '.@$package->first_name.' '.@$package->middle_name}}</td>
                                <td>{{$package->package_month}}</td>
                                <td>{{$package->package_type}}</td>
                                <td>
                                    <span style="display: flex;">
                                        <form method="POST" action="{{ route('apply-package-delete', $package->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm"  title='Delete' style="padding: 11px;"><i class=" text-white fa fa-trash"></i></button>
                                        </form>&nbsp;
                                        <a href="{{route('yatri-visa-view',$package->id)}}" class="fa fa-eye bg-primary" style="color:white; padding:11px;"></a>
                                        {{-- <a href="{{route('yatri-visa-edit',$package->id)}}" class="fa fa-edit bg-warning" style="color:white; padding:11px;"></a> --}}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
