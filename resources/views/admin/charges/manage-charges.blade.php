@extends('admin.layouts.app')
@section('content')
<style type="text/css">
	.tabs-tags__tag{
		padding: 20px;
    border-bottom: 3px solid black;
    text-align: center;
    color: black;
    font-size: 25px;
    font-weight: 700;
    cursor: pointer;
	}
	.active{
		border-bottom: 3px solid #f54e18;
		color: #f54e18;
	}
	.dt-buttons {
		display: none;
	}
</style>
<main class="ttr-wrapper">
  	<div class="container-fluid">
	    <div class="db-breadcrumb">
	        <h4 class="breadcrumb-title">Extra Charges</h4>
	        <ul class="db-breadcrumb-list">
	            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
	            <li>Extra Charges</li>
	        </ul>
	    </div>

	    <div class="main-body">
	      	<div class="row">
	      		<div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
					<div class="widget-card widget-bg1" style="height: 100px !important;">
						<div class="wc-item pt-3" style="height: 100px;">
							<h4 class="wc-title">
								Total Amount
							</h4>
							<span class="wc-stats mt-3">
								${{ $per_person_charge }}
							</span>
							<div class="progress wc-progress">
								<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
					<div class="widget-card widget-bg1" style="height: 100px !important;">
						<div class="wc-item pt-3" style="height: 100px;">
							<h4 class="wc-title">
								Paid Amount
							</h4>
							<span class="wc-stats mt-3">
								${{ $paid_amount }}
							</span>
							<div class="progress wc-progress">
								<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a href="{{ url('admin/manage-charges/create', $yatri_id) }}" class="btn btn-primary mt-4" previewlistener="true">
            	Pay Amount <i class="fa fa-plus"></i>
       	 	</a>
			<div class="row mt-4">
	      		<div class="col-lg-12">
	      			<table class="table table-striped myTables">
					    <thead class="thead-dark">
					        <tr>
					            <th scope="col">#</th>
					            <th scope="col">Amount</th>
					            <th scope="col">Action</th>
					        </tr>
					    </thead>
					    <tbody>
					        @if(count($charges_paid) > 0)
					        @foreach($charges_paid as $key => $val)
					        <tr>
					            <td class="text-center">{{ ++$key }}</td>
					            <td class="text-center">${{$val->amount}}</td>				            
					            <td style="width: 250px !important;">
					                <div style="display: flex;">
					                    <a href="{{ url('admin/manage-charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
					                    <form method="POST" action="{{ url('/admin/manage-charges/delete', $val->id) }}">
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
					            <td colspan="3" class="text-center">No result found.</td>
					        </tr>
					        @endif
					    </tbody>
					</table>		
				</div>
			</div> 
    	</div>
	</div>
</main>
<div class="ttr-overlay"></div>
@endsection