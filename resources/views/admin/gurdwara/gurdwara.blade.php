@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Gurdwara</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Gurdwara</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ route("create-gurdwara") }}" class="btn btn-primary">
                Add Gurdwara <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-12">
                    <div class="collapse" id="collapseExample">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('admin_gurdwara')}}" enctype="multipart/form-data" class="admin_form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Name of Gurdwara</label>
                                            <input type="text" class="form-control require" placeholder="Enter Gurdwara Name" name="gurdwara_name" required/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Address</label>
                                            <input type="text" class="form-control require" placeholder="Enter Street Address" name="address" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">City</label>
                                            <input type="text" class="form-control require" placeholder="Enter City" name="city" required/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">State</label>
                                            <input type="text" class="form-control require" placeholder="Enter State" name="state" required/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Zip</label>
                                            <input type="text" class="form-control require" placeholder="Enter Zip" name="zip" required/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Country</label>
                                            <input type="text" class="form-control require" placeholder="Enter Country" name="country" required/>
                                        </div>
                                        <div class=" col-lg-6 form-group">
                                            <label class="form_label_color">Email Address</label>
                                            <input type="email" class="form-control require" placeholder="Enter Email Address"  name="email_address" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Name of Pardan</label>
                                            <input type="text" class="form-control require" placeholder="Enter Pardan Name" name="pardan_name"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Phone Number</label>
                                            <input type="text" class="form-control require" placeholder="Enter Pardan Phone Number" name="phone_no"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Name of Secretary</label>
                                            <input type="text" class="form-control require" placeholder="Enter Secretary Name" name="secretary_name"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Phone Number</label>
                                            <input type="text" class="form-control require" placeholder="Enter Secretary Phone Number" name="secretary_phone_no"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Name of Head Garanti</label>
                                            <input type="text" class="form-control require" placeholder="Enter Head Garanti Name" name="head_garanti_name"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Phone Number</label>
                                            <input type="text" class="form-control require" placeholder="Enter Head Garanti Phone Number" name="head_garanti_phone_no"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Name of Chairman</label>
                                            <input type="text" class="form-control require" placeholder="Enter Chairman Name" name="chairman_name"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Phone Number</label>
                                            <input type="text" class="form-control require" placeholder="Enter Chairman Phone Number" name="chairman_phone_no"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Name of Manager</label>
                                            <input type="text" class="form-control require" placeholder="Enter Manager Name" name="manager_name"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Phone Number</label>
                                            <input type="text" class="form-control require" placeholder="Enter Manager Phone Number" name="manager_phone_no"/>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="form_label_color">Sangat</label><br>
                                            <input type="radio" value="Large" name="sangat" id="large" checked />
                                            <label for="large">Large</label>
                                            <input type="radio" value="Medium" name="sangat" id="medium" />
                                            <label for="medium">Medium</label>
                                            <input type="radio" value="Small" name="sangat" id="small" />
                                            <label for="small">Small</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form_label_color">Upload Photo</label>
                                            <input type="file" name="gurdwara_image" class="dropify" id="dropify-img" data-height="100" />
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
                                        <div class="response"></div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 pb-5">
                    <table class="table table-striped dataTable" id="myTables"  cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead  bgcolor="#4c1864" >
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                    style="width: 80px;">Image
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                    style="width: 220px;">Gurdwara
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="width: 150px;">Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 120px;">City 
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 40px;">State 
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 80px;">Country 
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 100px;">Phone 
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 150px;">Email 
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 50px;">Action 
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gurdwaras as $gurdwara)
                            <tr role="row" @if($gurdwara->color == "Green") style="background: #35e93559 !important;" @elseif($gurdwara->color == "Yellow") style="background: #e6e93559 !important;" @elseif($gurdwara->color == "Red") style="background: #e94e3559 !important;" @endif>
                                <td><img src="{{ asset("gurdwara_images/".$gurdwara->gurdwara_image) }}" style="width: 100px; height: 100px;"></td>
                                <td>{{$gurdwara->gurdwara_name}}</td>
                                <td>{{$gurdwara->address}}</td>
                                <td>{{$gurdwara->city}}</td>
                                <td>{{$gurdwara->state}}</td>
                                <td>{{$gurdwara->country}}</td>
                                <td>{{$gurdwara->phone_no}}</td>
                                <td>{{$gurdwara->email_address}}</td>
                                <td>
                                    <span style="display: flex;"> 
                                        <a href="{{route('edit-gurdwara',$gurdwara->id)}}" class="btn bg-warning" title='edit' style="padding:11px;"><i class=" text-white fa fa-edit"></i></a>&nbsp;
                                        <form method="POST" action="{{ route('delete-gurdwara', $gurdwara->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm"  title='Delete' style="padding: 11px;"><i class=" text-white fa fa-trash"></i></button>
                                        </form>
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
@section('js')
<script>
    $(document).ready(function () {
        // Initialize Dropify
        $('.dropify').dropify();
        // Get the original file name on file upload
        $('.dropify').on('change', function () {
            var input = $(this);
            var file_name = input[0].files[0].name;
            // $('#selected-image').val(file_name);
            // alert('Original file name: ' + file_name);
        });
    });
</script>
@endsection