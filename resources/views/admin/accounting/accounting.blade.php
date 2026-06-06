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
			<h4 class="breadcrumb-title">Accounting</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
				{{-- <li><a href="{{ url('/admin/yatri-visa') }}">Yatri Bookings</a></li> --}}
				<li>Accounting</li>
			</ul>
		</div>
		<div class="main-body">
			<div class="row mt-4">
				<div class="col-lg-12">
					<div class="tabs">
						<div class="tabs-tags row">
							<span class="tabs-tags__tag col-md-6">Account Payable</span>
							<span class="tabs-tags__tag col-md-6">Account Receivable</span>
						</div>
						<div class="tabs-content">
							<div class="tabs-content__text">
								<div class="row mt-4">
									{{-- <div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
										<div class="widget-card widget-bg1" style="height: 100px !important;">
											<div class="wc-item pt-3" style="height: 100px;">
												<h4 class="wc-title">
													Paid Total Amounts
												</h4>
												<span class="wc-stats mt-3">
													${{ $payable_paid }}
												</span>
												<div class="progress wc-progress">
													<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
										<div class="widget-card widget-bg1" style="height: 100px !important;">
											<div class="wc-item pt-3" style="height: 100px;">
												<h4 class="wc-title">
													Not Paid Total Amounts
												</h4>
												<span class="wc-stats mt-3">
													${{ $payable_notpaid }}
												</span>
												<div class="progress wc-progress">
													<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div> --}}
									<div class="col-md-6 col-lg-6 col-xl-6 col-sm-6 col-12">
										<div class="widget-card widget-bg1" style="height: 100px !important;">
											<div class="wc-item pt-3" style="height: 100px;">
												<h4 class="wc-title">
													Total Payable Amounts
												</h4>
												<span class="wc-stats mt-3">
													${{ $total_payable }}
												</span>
												<div class="progress wc-progress">
													<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<a href="{{ url('admin/payable/create') }}" class="btn btn-primary" previewlistener="true">
											Add Payable <i class="fa fa-plus"></i>
										</a>
									</div>
									<div class="col-lg-12 mt-3">
										<table class="table table-striped" id="">
											<thead class="thead-dark">
												<tr>
													<th scope="col">#</th>
													<th scope="col">Amount</th>
													<th scope="col">Account Head</th>
													<th scope="col">Date</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												@if(count($payable) > 0)
												@foreach($payable as $key => $val)
												<tr>
													<td class="text-center">{{ ++$key }}</td>
													<td class="text-center">{{$val->amount}}</td>
													<td class="text-center">{{@$val->account_head->name}}</td>
													<td class="text-center">{{ date('d-m-Y', strtotime($val->created_at)); }}</td>
													
													<td style="width: 250px !important;">
														<div style="display: flex;">
															<a href="{{ url('admin/payable/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
															<form method="POST" action="{{ url('/admin/payable/delete', $val->id) }}">
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
													<td colspan="7" class="text-center">No result found.</td>
												</tr>
												@endif
											</tbody>
										</table>
									</div>   
								</div>
							</div>
							<div class="tabs-content__text">
								<div class="row mt-4">
									{{-- <div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
										<div class="widget-card widget-bg1" style="height: 100px !important;">
											<div class="wc-item pt-3" style="height: 100px;">
												<h4 class="wc-title">
													Receivable Total Amounts
												</h4>
												<span class="wc-stats mt-3">
													${{ $receivable_received }}
												</span>
												<div class="progress wc-progress">
													<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
										<div class="widget-card widget-bg1" style="height: 100px !important;">
											<div class="wc-item pt-3" style="height: 100px;">
												<h4 class="wc-title">
													Not Receivable Total Amounts
												</h4>
												<span class="wc-stats mt-3">
													${{ $receivable_notreceived }}
												</span>
												<div class="progress wc-progress">
													<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div> --}}
									<div class="col-md-6 col-lg-6 col-xl-6 col-sm-6 col-12">
										<div class="widget-card widget-bg1" style="height: 100px !important;">
											<div class="wc-item pt-3" style="height: 100px;">
												<h4 class="wc-title">
													Total Receivable Amounts
												</h4>
												<span class="wc-stats mt-3">
													${{ $total_receivable }}
												</span>
												<div class="progress wc-progress">
													<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<a href="{{ url('admin/receivable/create') }}" class="btn btn-primary" previewlistener="true">
											Add Receivable <i class="fa fa-plus"></i>
										</a>
									</div>
									<div class="col-lg-12 mt-3">
										<table class="table table-striped" id="">
											<thead class="thead-dark">
												<tr>
													<th scope="col">#</th>
													<th scope="col">Amount</th>
													<th scope="col">Account Head</th>
													<th scope="col">Date</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												@if(count($receivable) > 0)
												@foreach($receivable as $key => $val)
												<tr>
													<td class="text-center">{{ ++$key }}</td>
													<td class="text-center">{{$val->amount}}</td>
													<td class="text-center">{{@$val->account_head->name}}</td>
													<td class="text-center">{{ date('d-m-Y', strtotime($val->created_at)); }}</td>
													
													<td style="width: 250px !important;">
														<div style="display: flex;">
															<a href="{{ url('admin/receivable/edit', $val->id) }}" class="fa fa-edit bg-info mr-2" style="color:white; padding:11px;" data-id="{{$val->id}}"></a>
															<form method="POST" action="{{ url('/admin/receivable/delete', $val->id) }}">
																@csrf
																<input name="_method" type="hidden" value="GET">
																<button type="submit" class="btn bg-danger show_confirm" title='Delete' style="padding: 11px;"><i class="text-white fa fa-trash"></i></button>
															</form>
															{{-- <a href="{{ url('admin/receivable/view', $val->id) }}"  class="fa-solid fa-download bg-info mr-2 ml-2" style="color:white; padding:11px;" data-id="{{$val->id}}" ></a> --}}
														</div>
													</td>
												</tr>
												@endforeach
												@else
												<tr>
													<td colspan="8" class="text-center">No result found.</td>
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

@endsection