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
</style>
<main class="ttr-wrapper">
  	<div class="container-fluid">
	    <div class="db-breadcrumb">
	        <h4 class="breadcrumb-title">Account Head</h4>
	        <ul class="db-breadcrumb-list">
	            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
	            <li>Account Head</li>
	        </ul>
	    </div>

	    <div class="main-body">
	    	<a href="{{ url('admin/account-head/create') }}" class="btn btn-primary" previewlistener="true">
            	Add Account Head <i class="fa fa-plus"></i>
       	 	</a>
	      	<div class="row mt-4">
	      		
	      		<div class="col-lg-12">
	      			<table class="table table-striped" id="">
					    <thead class="thead-dark">
					        <tr>
					            <th scope="col">#</th>
					            <th scope="col">Name</th>
					            <th scope="col">Description</th>
					            <th scope="col">Type</th>
					            <th scope="col">Payable</th>
					            <th scope="col">Receivable</th>
					            <th scope="col">Action</th>
					        </tr>
					    </thead>
					    <tbody>
					        @if(count($account_head) > 0)
					        @foreach($account_head as $key => $val)
					        <tr>
					            <td class="text-center">{{ ++$key }}</td>
					            <td class="text-center">{{$val->name}}</td>
					            <td class="text-center">{{$val->description}}</td>
					            <td class="text-center">{{$val->type}}</td>
					            <td class="text-center">${{$val->total_payable}}</td>					            
					            <td class="text-center">${{$val->total_receiveable}}</td>					            
					            <td style="width: 250px !important;">
					                <div style="display: flex;">
					                    <a href="{{ url('admin/account-head/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
					                    <form method="POST" action="{{ url('/admin/account-head/delete', $val->id) }}">
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
					            <td colspan="9" class="text-center">No result found.</td>
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