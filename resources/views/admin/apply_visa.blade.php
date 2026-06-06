@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Visa</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Admin Can View Yatri Visa Detail's</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped" id="myTables">
                            <thead  bgcolor="#4c1864">
                                <tr>
                                <th scope="col">Name of Yatri</th>
                                <th scope="col">Type of Visa</th>
                                <th scope="col">Visa PDF</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visas as $visa)
                                <tr>
                                    <td>{{$visa->p_first_name}}</td>
                                    <td>{{$visa->visa_type}}</td>
                                    <td><a href="{{url('admin/pdf/mypdf')}}/{{Crypt::encrypt($visa->id)}}" target="blank" class="fa fa-file-pdf-o" style="background: rgb(30, 206, 39); color:white; padding:11px; font-weight:bold; border-radius:3px;"> Print</a></td>
                                    <td>
                                        <span style="display: flex;">
                                            <form method="POST" action="{{ route('apply-visa-delete', $visa->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="GET">
                                                <button type="submit" class="btn bg-danger show_confirm"  title='Delete' style="padding: 11px;"><i class=" text-white fa fa-trash"></i></button>
                                            </form>&nbsp;
                                            <a href="apply_visa/edit/{{Crypt::encrypt($visa->id)}}" target="blank" class="fa fa-edit bg-warning" style="color:white; padding:10px; font-weight:bold; border-radius:3px;"></a>
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
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
