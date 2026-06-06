@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">List of All Gurdwaras</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>All Gurdwaras</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row my-3">
                <div class="col-lg-4">
                    <label>Select State</label>
                    <select class="form-control" name="state" id="state">
                        <option value="all">All</option>
                        @if(count(@$all_states) > 0)
                            @foreach(@$all_states as $key => $value)
                                <option value="{{ $value->state }}">{{ $value->state }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-4">
                    <label>Select Color</label>
                    <select class="form-control" name="color" id="color">
                        <option value="all">All</option>
                        <option value="Green">Green</option>
                            <option value="Yellow">Yellow</option>
                        <option value="Red">Red</option>
                    </select>
                </div>
                <div class="col-lg-4 d-flex justify-content-end">
                    <a href="{{ route("create-gurdwara") }}" class="btn btn-primary" style="height: fit-content;">
                        Add Gurdwara <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 pb-5">
                    <table class="table table-striped dataTable" id="myTables" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead  bgcolor="#4c1864" >
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                    style="width: 200px;">Name of Gurdwara
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="width: 150px;">Address
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                    style="width: 100px;">Name of Pardan
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 50px;">Mobile No. 
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 100px;">Name of Secretary 
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Start date: activate to sort column ascending"
                                    style="width: 50px;">Mobile No.
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gurdwaras as $gurdwara)
                            <tr role="row" @if($gurdwara->color == "Green") style="background: #35e93559 !important;" @elseif($gurdwara->color == "Yellow") style="background: #e6e93559 !important;" @elseif($gurdwara->color == "Red") style="background: #e94e3559 !important;" @endif>
                                <td>{{ $gurdwara->gurdwara_name }}</td>
                                <td>{{ $gurdwara->address }}</td>
                                <td>{{ $gurdwara->pardan_name ?? "N/A" }}</td>
                                <td>{{ $gurdwara->phone_no }}</td>
                                <td>{{ $gurdwara->secretary_name }}</td>
                                <td>{{ $gurdwara->secretary_phone_no }}</td>
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
        var url = window.location.href;
        if(url.indexOf("state=") > -1) {
            var state = url.split("state=")[1];
            state = state.split("&color=")[0];
            $("#state option[value='"+state+"']").attr("selected", true);
        }
        if(url.indexOf("color=") > -1) {
            var color = url.split("color=")[1];
            $("#color option[value='"+color+"']").attr("selected", true);
        }
        
        $(document).on("change", "#state,#color", function() {
            var state = $("#state").find("option:selected").val();
            var color = $("#color").find("option:selected").val();
            window.location.href = "https://konnectyatra.org/admin/admin_gurdwaras?state=" + state + "&color=" + color;
        });
        
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