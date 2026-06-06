@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Remarks</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/yatri-visa') }}">Yatri Bookings</a></li>
                <li>Remarks</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Remarks</h4>
                        </div>
                        <div class="card-body row mx-0" id="scroll-div" style="max-height: 600px; overflow-y: auto;">
                            @php
                                $date = "";
                            @endphp
                            @if(count(@$remarks) > 0)
                            @foreach(@$remarks as $key => $value)
                            @if(date("Y-m-d", strtotime(@$value->created_at)) !== $date)
                            <div class="offset-lg-5 col-lg-2 text-center p-2 mb-3" style="border-radius: 10px; background-color: #eee;">
                                {{ date("d M Y", strtotime(@$value->created_at)) }}
                                @php
                                    $date = date("Y-m-d", strtotime(@$value->created_at));
                                @endphp
                            </div>
                            @endif
                            <div class="col-lg-12 alert alert-info">
                                {{ @$value->remarks }}
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="card-footer">
                            <form method="POST" action="{{ url('admin/add-remarks', $id) }}" class="add-remarks w-100 d-flex justify-content-between">
                                @csrf
                                <input type="text" name="remarks" class="form-control" placeholder="Add remarks here..." required>
                                <button class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection

@section('js')

    <script type="text/javascript">
        $(document).ready(function () {
            const scrollSmoothlyToBottom = (id) => {
                const element = $(`#${id}`);
                element.animate({
                    scrollTop: element.prop("scrollHeight")
                }, 500);
            }

            scrollSmoothlyToBottom("scroll-div");
        });
    </script>

@endsection