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
	<meta name="description" content="Konnect Yatra" />

	<!-- OG -->
	<meta property="og:title" content="Konnect Yatra" />
	<meta property="og:description" content="Konnect Yatra" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="../error-404.html" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images2/planeicon.png')}}" />

	<!-- PAGE TITLE HERE ============================================= -->
	<title>Dashboard</title>

	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
	<script src="userassets/js/html5shiv.min.js"></script>
	<script src="userassets/js/respond.min.js"></script>
	<![endif]-->

	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('userassets/css/assets.css')}}">
	{{-- <link rel="stylesheet" type="text/css" href="{{asset('userassets/vendors/calendar/fullcalendar.css')}}"> --}}

	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('userassets/css/typography.css')}}">

	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('userassets/css/shortcodes/shortcodes.css')}}">

	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('userassets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('userassets/css/form.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('userassets/css/dashboard.css')}}">
	<link class="skin" rel="stylesheet" type="text/css" href="{{asset('userassets/css/color/color-1.css')}}">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
						<a href="#" class="ttr-material-button ttr-submenu-toggle">HOME</a>
					</li>
					<li>
						<a href="#" class="ttr-material-button ttr-submenu-toggle">QUICK MENU <i class="fa fa-angle-down"></i></a>
						<div class="ttr-header-submenu">
							<ul>
								<li><a href="#">Our Courses</a></li>
								<li><a href="#">New Event</a></li>
								<li><a href="#">Membership</a></li>
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
					<li>
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
					</li>
					<li>
						<a href="#" class="ttr-material-button ttr-submenu-toggle"><span class="ttr-user-avatar"><img alt="" src="{{asset('userassets/images2/default-user.jpeg')}}" width="32" height="32"></span></a>
						<div class="ttr-header-submenu">
							<ul>
								<li><a href="#">My profile</a></li>
								<li><a href="#">Activity</a></li>
								<li><a href="#">Messages</a></li>
								<li><a href="{{route('logout')}}">Logout</a></li>
							</ul>
						</div>
					</li>
					<li class="ttr-hide-on-mobile">
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
					</li>
				</ul>
				<!-- header right menu end -->
			</div>
			<!--header search panel start -->
			<div class="ttr-search-bar">
				<form class="ttr-search-form">
					<div class="ttr-search-input-wrapper">
						<input type="text" name="qq" placeholder="search something..." class="ttr-search-input">
						<button type="submit" name="search" class="ttr-search-submit"><i class="fas fa-arrow-right"></i></button>
					</div>
					<span class="ttr-search-close ttr-search-toggle">
						<i class="fas fa-close"></i>
					</span>
				</form>
			</div>
			<!--header search panel end -->
		</div>
	</header>
	<!-- header end -->
@include('userslayouts.sidebar')
<!-- External JavaScripts -->
<script src="{{asset('userassets/js/jquery.min.js')}}"></script>
<script src="{{asset('userassets/js/form.js')}}"></script>
<script src="{{asset('userassets/vendors/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('userassets/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('userassets/vendors/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script src="{{asset('userassets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('userassets/vendors/magnific-popup/magnific-popup.js')}}"></script>
<script src="{{asset('userassets/vendors/counter/waypoints-min.js')}}"></script>
<script src="{{asset('userassets/vendors/counter/counterup.min.js')}}"></script>
<script src="{{asset('userassets/vendors/imagesloaded/imagesloaded.js')}}"></script>
<script src="{{asset('userassets/vendors/masonry/masonry.js')}}"></script>
<script src="{{asset('userassets/vendors/masonry/filter.js')}}"></script>
<script src="{{asset('userassets/vendors/owl-carousel/owl.carousel.js')}}"></script>
<script src='{{asset('userassets/vendors/scroll/scrollbar.min.js')}}'></script>
<script src="{{asset('userassets/js/functions.js')}}"></script>
<script src="{{asset('userassets/vendors/chart/chart.min.js')}}"></script>
<script src="{{asset('userassets/js/admin.js')}}"></script>
</body>
</html>

