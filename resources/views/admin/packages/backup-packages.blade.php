@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Packages</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Admin Can Add Yatri Packages</li>
            </ul>
        </div>
        <div class="main-body">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Add package <i class="fa fa-plus"></i>
              </button>
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-12">
                    <div class="collapse" id="collapseExample">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('apply_packages')}}" enctype="multipart/form-data" class="admin_form">
                                    @csrf
                                    <div class="row">
                                        <div class=" col-lg-3 form-group">
                                            <label class="form_label_color">Gurdwara Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Gurdwara Name"  name="g_name" required/>
                                        </div>
                                        <div class=" col-lg-3 form-group">
                                            <label class="form_label_color">State</label>
                                            <input type="text" class="form-control require" placeholder="Enter State"  name="state" required/>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label class="form_label_color">Month</label>
                                            <select name="month" class="form-control">
                                                <option disabled selected>Chosse Your Month</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label class="form_label_color">Date </label>
                                            <input type="date"  class="form-control require"  name="date_1st"/>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2" style="float: right;">Submit</button>
                                    <div class="response"></div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped" id="myTables">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Name of Gurdwara </th>
                            <th scope="col">State</th>
                            <th scope="col">Month</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                            <tr>
                                <td>{{$package->g_name}}</td>
                                <td>{{$package->state}}</td>
                                <td>{{$package->month}}</td>
                                <td>
                                    <span style="display: flex;">
                                        <form method="POST" action="{{ route('apply-package-delete', $package->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm"  title='Delete' style="padding: 11px;"><i class=" text-white fa fa-trash"></i></button>
                                        </form>&nbsp;
                                        <a href="#" class="fa fa-edit bg-warning" style="color:white; padding:11px;"></a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- @endforeach --}}
                    </table>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Month Name</th>
                            <th scope="col">Single Price</th>
                            <th scope="col">Double Price</th>
                            <th scope="col">Triple Price</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($yatri_package as $yatri)
                            <tr>
                                <td class="text-center">{{$yatri->month}}</td>
                                <td class="text-center">${{$yatri->single_price}}</td>
                                <td class="text-center">${{$yatri->double_price}}</td>
                                <td class="text-center">${{$yatri->triple_price}}</td>
                                <td>
                                    <a class="fa fa-edit bg-warning show_edit" style="color:white; padding:11px;" data-id="{{$yatri->id}}"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- @endforeach --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Yatri Package</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" id="update_url" action="">
                        @csrf
                        <div class="form-group">
                            <label>Month</label>
                            <input class="form-control" name="month" type="text" id="yatri_month" value="">
                        </div>
                        <div class="form-group">
                            <label>Single</label>
                            <input class="form-control" name="single_price" type="text" id="yatri_single" value="">
                        </div>
                        <div class="form-group">
                            <label>Double</label>
                            <input class="form-control" name="double_price" type="text" id="yatri_double" value="">
                        </div>
                        <div class="form-group">
                            <label>Triple</label>
                            <input class="form-control" name="triple_price" type="text" id="yatri_triple" value="">
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    $('.show_edit').click(function(){
            var user_edit_id = $(this).attr('data-id');
            var update_url = $('#update_url').attr('action',"{{url('admin/yatri-visa-update')}}/"+user_edit_id+"")
            $.ajax({
                url: "{{url('admin/yatri-package-edit')}}/"+user_edit_id+"",
                type: "GET",
                cache: false,
                success: function (data) {
                    if('error' in data)
                    {
                        toastr.error(data.error);
                        $('#myModal').modal('hide');
                        // $('#myModal').on('hidden.bs.modal', function () {
                        //     $(this).modal('hide');
                        // });
                    }
                    else
                    {
                        $('#yatri_month').val(data.month);
                        $('#yatri_single').val(data.single_price);
                        $('#yatri_double').val(data.double_price);
                        $('#yatri_triple').val(data.triple_price);
                        $('#myModal').modal('show');
                    }
                },
            });
        });
</script>
@endsection
