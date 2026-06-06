@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Yatri Packages</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Yatri Packages</li>
            </ul>
        </div>
        <div class="main-body">
            <a href="{{ url('admin/apply_packages/create') }}" class="btn btn-primary">
                Add Package <i class="fa fa-plus"></i>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table table-striped" id="">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col" style="width: 400px;">Name</th>
                            <th scope="col">5* Round Trip Price</th>
                            <th scope="col">5* One Way Price</th>
                            <th scope="col">5* Land Price</th>
                            <th scope="col">4* Round Trip Price</th>
                            <th scope="col">4* One Way Price</th>
                            <th scope="col">4* Land Price</th>
                            <th scope="col">Package Type</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($yatri_package as $yatri)
                            <tr>
                                {{-- @php
                                    $timestamp = strtotime($yatri->month_year);
                                    $new_date_format = date('F Y', $timestamp);
                                @endphp --}}
                                <td class="">{{$yatri->name}}</td>
                                <td class="text-center">${{$yatri->five_star_round_price}}</td>
                                <td class="text-center">${{$yatri->five_star_single_price}}</td>
                                <td class="text-center">${{$yatri->five_star_land_price}}</td>
                                <td class="text-center">${{$yatri->four_star_round_price}}</td>
                                <td class="text-center">${{$yatri->four_star_single_price}}</td>
                                <td class="text-center">${{$yatri->four_star_land_price}}</td>
                                <td class="text-center">{{$yatri->package_type}}</td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ url('admin/apply_packages/edit', $yatri->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$yatri->id}}"></a>
                                        <form method="POST" action="{{ url('/admin/apply_packages/delete', $yatri->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn bg-danger show_confirm" title='Delete' style="padding: 11px;"><i class="text-white fa fa-trash"></i></button>
                                        </form>
                                    </div>
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
