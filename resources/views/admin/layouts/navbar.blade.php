<!DOCTYPE html>
<html lang="en">
<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />

	<!-- DESCRIPTION -->
	<meta name="description" content="Konnect yatra" />

	<!-- OG -->
	<meta property="og:title" content="Konnect yatra" />
	<meta property="og:description" content="Konnect yatra" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="{{asset('assets/images2/planeicon.png')}}" type="image/x-icon"/>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images2/icon2-logo.jpeg')}}" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css"/>
	<!-- PAGE TITLE HERE ============================================= -->
	<title>KONNECT-YATRA Dashboard</title>

	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
	<script src="adminassets/js/html5shiv.min.js"></script>
	<script src="adminassets/js/respond.min.js"></script>
	<![endif]-->

	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('adminassets/css/assets.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminassets/css/form.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminassets/css/form2.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('adminassets/vendors/calendar/fullcalendar.css')}}">

	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('adminassets/css/typography.css')}}">

	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('adminassets/css/shortcodes/shortcodes.css')}}">

	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('adminassets/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('adminassets/css/dashboard.css')}}">
	<link class="skin" rel="stylesheet" type="text/css" href="{{asset('adminassets/css/color/color-1.css')}}">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
	<!-- Datatables ============================================= -->
	<link href="{{asset('adminassets/vendors/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
	<!-- Toastrs ============================================= -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Dropify ============================================= -->
	<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar">

	<!-- header start -->
	<header class="ttr-header">
		<div class="ttr-header-wrapper">
			<!--sidebar menu toggler start -->
			<div class="ttr-toggle-sidebar ttr-material-button">
				<i class="fas fa-close ttr-open-icon"></i>
				<i class="fas fa-bars ttr-close-icon"></i>
			</div>
			<!--sidebar menu toggler end -->
			<!--logo start -->
			<div class="ttr-logo-box">
				<div>
					<a href="#" class="ttr-logo">
						<img class="ttr-logo-mobile" alt="" src="{{asset('adminassets/images2/newwhitelogo.png')}}" width="130" height="50">
						<img class="ttr-logo-desktop" alt="" src="{{asset('adminassets/images2/newwhitelogo.png')}}" width="200" height="27">
					</a>
				</div>
			</div>
			<!--logo end -->
			<div class="ttr-header-menu">
				<!-- header left menu start -->
				<ul class="ttr-header-navigation">
					<li>
						<a href="{{route('dashboard')}}" class="ttr-material-button ttr-submenu-toggle">HOME</a>
					</li>
					<li>
						<a href="#" class="ttr-material-button ttr-submenu-toggle">QUICK MENU <i class="fa fa-angle-down"></i></a>
						<div class="ttr-header-submenu">
							<ul>
								<li><a href="{{ url("admin/yatri-visa") }}">Bookings</a></li>
								<li><a href="{{ url("admin/admin_gurdwara") }}">Gurdwaras</a></li>
								<li><a href="{{ url("admin/users") }}">Users</a></li>
							</ul>
						</div>
					</li>
				</ul>
				<!-- header left menu end -->
			</div>
			<div class="ttr-header-right ttr-with-seperator">
				<!-- header right menu start -->
				<ul class="ttr-header-navigation">
					<li>
						<a href="#" class="ttr-material-button ttr-search-toggle"><i class="fa fa-search"></i></a>
					</li>
					{{-- <li>
						<a href="#" class="ttr-material-button ttr-submenu-toggle"><i class="fa fa-bell"></i></a>
						<div class="ttr-header-submenu noti-menu">
							<div class="ttr-notify-header">
								<span class="ttr-notify-text-top">9 New</span>
								<span class="ttr-notify-text">User Notifications</span>
							</div>
							<div class="noti-box-list">
								<ul>
									<li>
										<span class="notification-icon dashbg-gray">
											<i class="fa fa-check"></i>
										</span>
										<span class="notification-text">
											<span>Sneha Jogi</span> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 02:14</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-yellow">
											<i class="fa fa-shopping-cart"></i>
										</span>
										<span class="notification-text">
											<a href="#">Your order is placed</a> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 7 Min</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-red">
											<i class="fa fa-bullhorn"></i>
										</span>
										<span class="notification-text">
											<span>Your item is shipped</span> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 2 May</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-green">
											<i class="fa fa-comments-o"></i>
										</span>
										<span class="notification-text">
											<a href="#">Sneha Jogi</a> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 14 July</span>
										</span>
									</li>
									<li>
										<span class="notification-icon dashbg-primary">
											<i class="fa fa-file-word-o"></i>
										</span>
										<span class="notification-text">
											<span>Sneha Jogi</span> sent you a message.
										</span>
										<span class="notification-time">
											<a href="#" class="fa fa-close"></a>
											<span> 15 Min</span>
										</span>
									</li>
								</ul>
							</div>
						</div>
					</li> --}}
					<li>
						<a href="#" class="ttr-material-button ttr-submenu-toggle"><span class="ttr-user-avatar"><img alt="" src="{{ !empty(optional(auth()->user())->avatar) ? asset(auth()->user()->avatar) : asset('assets2/images/pp.jpg') }}" onerror="this.src='{{ asset('assets2/images/pp.jpg') }}'" width="32" height="32" style="object-fit:cover;border-radius:50%;height:32px;"></span></a>
						<div class="ttr-header-submenu">
							<ul>
								<li><a href="{{ url("admin/profile") }}">My profile</a></li>
								<li><a href="{{route('admin_logout')}}">Logout</a></li>
							</ul>
						</div>
					</li>
					{{-- <li class="ttr-hide-on-mobile">
						<a href="#" class="ttr-material-button"><i class="fas fa-bars"></i></a>
						<div class="ttr-header-submenu ttr-extra-menu">
							<a href="#">
								<i class="fa fa-music"></i>
								<span>Musics</span>
							</a>
							<a href="#">
								<i class="fa-brands fa-youtube"></i>
								<span>Videos</span>
							</a>
							<a href="#">
								<i class="fa fa-envelope"></i>
								<span>Emails</span>
							</a>
							<a href="#">
								<i class="fa fa-book"></i>
								<span>Reports</span>
							</a>
							<a href="#">
								<i class="fa fa-smile-o"></i>
								<span>Persons</span>
							</a>
							<a href="#">
								<i class="fa fa-picture-o"></i>
								<span>Pictures</span>
							</a>
						</div>
					</li> --}}
				</ul>
				<!-- header right menu end -->
			</div>
			<!--header search panel start -->
			<div class="ttr-search-bar">
				<form class="ttr-search-form">
					<div class="ttr-search-input-wrapper">
						<input type="text" name="qq" placeholder="search something..." class="ttr-search-input">
						<button type="submit" name="search" class="ttr-search-submit"><i class="ti-arrow-right"></i></button>
					</div>
					<span class="ttr-search-close ttr-search-toggle">
						<i class="ti-close"></i>
					</span>
				</form>
			</div>
			<!--header search panel end -->
		</div>
	</header>
	<!-- header end -->
	@include('admin.layouts.sidebar')



