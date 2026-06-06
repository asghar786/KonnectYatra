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
	        <h4 class="breadcrumb-title">Expenses</h4>
	        <ul class="db-breadcrumb-list">
	            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
	            <li>Expenses</li>
	        </ul>
	    </div>

	    <div class="main-body">
	      	<div class="row">
	      		{{-- <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
					<div class="widget-card widget-bg1" style="height: 100px !important;">
						<div class="wc-item pt-3" style="height: 100px;">
							<h4 class="wc-title">
								Total Charges
							</h4>
							<span class="wc-stats mt-3">
								${{ $total_charges }}
							</span>
							<div class="progress wc-progress">
								<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div> --}}
				<div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-12">
					<div class="widget-card widget-bg1" style="height: 100px !important;">
						<div class="wc-item pt-3" style="height: 100px;">
							<h4 class="wc-title">
								Total Yatri's
							</h4>
							<span class="wc-stats mt-3">
								{{ $total_yatri }}
							</span>
							<div class="progress wc-progress">
								<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
					<div class="widget-card widget-bg1" style="height: 100px !important;">
						<div class="wc-item pt-3" style="height: 100px;">
							<h4 class="wc-title">
								Charges Per Person
							</h4>
							<span class="wc-stats mt-3">
								@php
									$per_person_charge = 0;
									if ($total_charges > 0 && $total_yatri > 0) {
										$per_person_charge = $total_charges / $total_yatri;
									}
								@endphp
								${{ $per_person_charge }}
							</span>
							<div class="progress wc-progress">
								<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div> --}}
			</div>
			<div class="tabs">
				<div class="tabs-tags row">
					<span class="tabs-tags__tag col-md-2">New York</span>
					<span class="tabs-tags__tag col-md-2">Washington</span>
					<span class="tabs-tags__tag col-md-2">Los Angeles</span>
					<span class="tabs-tags__tag col-md-2">Chicago</span>
					<span class="tabs-tags__tag col-md-1">Miami</span>
					<span class="tabs-tags__tag col-md-1">Seattle</span>
					<span class="tabs-tags__tag col-md-1">Houston</span>
					<span class="tabs-tags__tag col-md-1">Torronto</span>
				</div>
				<div class="tabs-content">
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped myTables">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($new_york) > 0)
								        @foreach($new_york as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped myTables">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($washington) > 0)
								        @foreach($washington as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped myTables1">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($los_angeles) > 0)
								        @foreach($los_angeles as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped myTables2">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($chicago) > 0)
								        @foreach($chicago as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped myTables3">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($miami) > 0)
								        @foreach($miami as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped" id="myTables">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($seattle) > 0)
								        @foreach($seattle as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped" id="myTables">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($houston) > 0)
								        @foreach($houston as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="tabs-content__text">
						<a href="{{ url('admin/charges/create') }}" class="btn btn-primary mt-4" previewlistener="true">
			            	Add Expense <i class="fa fa-plus"></i>
			       	 	</a>
						<div class="row mt-4">
				      		<div class="col-lg-12">
				      			<table class="table table-striped" id="myTables">
								    <thead class="thead-dark">
								        <tr>
								            <th scope="col" class="text-center">#</th>
								            <th scope="col" class="text-center">Description</th>
								            <th scope="col" class="text-center">Amount</th>
								            <th scope="col" class="text-center">Per Person</th>
								            <th scope="col" class="text-center">Action</th>
								        </tr>
								    </thead>
								    <tbody>
								        @if(count($torronto) > 0)
								        @foreach($torronto as $key => $val)
								        <tr>
								            <td class="text-center">{{ ++$key }}</td>
								            <td class="text-center">{{$val->description}}</td>					            
								            <td class="text-center">${{$val->amount}}</td>
								            <td class="text-center">$ @if((int)$total_yatri > 0) {{(int)$val->amount / (int)$total_yatri}} @else 0 @endif</td>
								            <td style="width: 250px !important;">
								                <div style="display: flex;">
								                    <a href="{{ url('admin/charges/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
								                    <form method="POST" action="{{ url('/admin/charges/delete', $val->id) }}">
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
								            <td colspan="5" class="text-center">No result found.</td>
								        </tr>
								        @endif
								    </tbody>
								</table>		
							</div>
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
	function TabsManager(el) {
		this.tabsContainers = document.querySelectorAll(el);
		this.init();
	}

	TabsManager.prototype.init = function () {
		var self = this;

		document.body.addEventListener("click", function (event) {
			var target = event.target;

			while (target !== document.body) {
				if (target.matches(".tabs-tags__tag")) {
					self.handleTabClick(target);
					return;
				}

				target = target.parentNode;
			}
		});

		self.tabsContainers.forEach(function (tabsContainer) {
			if (tabsContainer) {
				var contentTexts = tabsContainer.querySelectorAll(".tabs-content__text");
				contentTexts.forEach(function (text, index) {
					if (index !== 0) {
						text.style.display = "none";
					}
				});
				tabsContainer.querySelector(".tabs-tags__tag").classList.add("active");
			}
		});
	};

	TabsManager.prototype.handleTabClick = function (clickedTab) {
		var self = this;
		var tabsContainer = clickedTab.closest(".tabs");

		if (tabsContainer) {
			var contentTexts = tabsContainer.querySelectorAll(".tabs-content__text");
			var tags = tabsContainer.querySelectorAll(".tabs-tags__tag");
			var index = Array.from(tags).indexOf(clickedTab);
			contentTexts.forEach(function (text) {
				text.style.display = "none";
			});
			contentTexts[index].style.display = "block";
			tags.forEach(function (t) {
				t.classList.remove("active");
			});
			clickedTab.classList.add("active");
		}
	};

// Инициализация объекта TabsManager
var tabsManager = new TabsManager(".tabs");

</script>

<script type="text/javascript">
	$('.myTables1').DataTable({
        dom: "Blfrtip",
        buttons: [{
                extend: 'pdfHtml5',
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-pdf-o mr-1 "></i> PDF</button>',

                title: 'pdf',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }

            },
            {
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-copy mr-1"></i> Copy</button>',
                extend: 'copyHtml5',
                title: 'Copy',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }
            },
            {
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-excel-o mr-1"></i> Excel</button>',
                extend: 'excelHtml5',
                title: 'Excel',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }
            },
            {
                extend: 'print',
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-print mr-1"></i> Print</button>',

                pageSize: 'A4',
                title: 'Print',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }

            },
        ]
    });
    $('.myTables2').DataTable({
            dom: "Blfrtip",
            buttons: [{
                    extend: 'pdfHtml5',
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-pdf-o mr-1 "></i> PDF</button>',

                    title: 'pdf',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }

                },
                {
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-copy mr-1"></i> Copy</button>',
                    extend: 'copyHtml5',
                    title: 'Copy',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }
                },
                {
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-excel-o mr-1"></i> Excel</button>',
                    extend: 'excelHtml5',
                    title: 'Excel',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }
                },
                {
                    extend: 'print',
                    text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-print mr-1"></i> Print</button>',

                    pageSize: 'A4',
                    title: 'Print',
                    exportOptions: {
                        columns: ':visible:not(.not-export)'
                    }

                },
            ]
        });
    $('.myTables3').DataTable({
        dom: "Blfrtip",
        buttons: [{
                extend: 'pdfHtml5',
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-pdf-o mr-1 "></i> PDF</button>',

                title: 'pdf',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }

            },
            {
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-copy mr-1"></i> Copy</button>',
                extend: 'copyHtml5',
                title: 'Copy',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }
            },
            {
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-file-excel-o mr-1"></i> Excel</button>',
                extend: 'excelHtml5',
                title: 'Excel',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }
            },
            {
                extend: 'print',
                text: '<button  class="btn  btn-primary w-100 px-3 "><i class="fa fa-print mr-1"></i> Print</button>',

                pageSize: 'A4',
                title: 'Print',
                exportOptions: {
                    columns: ':visible:not(.not-export)'
                }

            },
        ]
    });
</script>

@endsection