<!DOCTYPE html>
<html lang="en">

<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />

	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="{{asset('assets/images/favicon.ico" type="image/x-icon')}}" />
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.png')}}" />

	<!-- PAGE TITLE HERE ============================================= -->
	<title>KONNECT-YATRA Registrations </title>

	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->

	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/assets.css')}}">

	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/typography.css')}}">

	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/shortcodes/shortcodes.css')}}">

	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
	<link class="skin" rel="stylesheet" type="text/css" href="{{asset('assets/css/color/color-1.css')}}">
</head>
<body id="bg">
<div class="page-wraper">
	<div id="loading-icon-bx"></div>
	<div class="account-form">
		<div class="account-head " style="background-image:url({{ asset('assets/images2/banner-1.jpg') }});">
			<a href="{{route('home')}}"><img src="{{asset('assets/images2/newwhitelogo.png')}}" width="300" alt=""></a>
		</div>
		<div class="account-form-inner">
			<div class="account-container">
				<div class="heading-bx left">
					<h2 class="title-head">Sign Up <span>Now</span></h2>
					<p>Login Your Account <a href="{{route('login')}}">Click here</a></p>
				</div>
				<form class="contact-bx"  method="POST" action="#">
                    @csrf
					<div class="row placeani">
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group">
									<label for="name">Your Name</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" onkeydown="return /[a-z ]/i.test(event.key)" required autocomplete="off">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group">
									<label for="email">Your Email Address</label>
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group">
									<label for="password">Your Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>
							</div>
						</div>
                        <div class="col-lg-12">
							<div class="form-group">
								<div class="input-group">
									<label  for="password-confirm">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<p class="mb-0">Want to register as</p><br>
								<input id="user" type="radio" name="role" value="user" checked>
								<label for="user">Yatri</label>
								<input id="gurdwara" type="radio" name="role" class="ml-2" value="gurdwara">
								<label for="gurdwara">Gurdwara</label>
							</div>
						</div>
						<div class="col-lg-12 m-b30">
							<button name="submit" type="submit" value="Submit" class="btn button-md">Sign Up</button>
						</div>
						{{-- <div class="col-lg-12">
							<h6>Sign Up with Social media</h6>
							<div class="d-flex">
								<a class="btn flex-fill m-r5 facebook" href="#"><i class="fa fa-facebook"></i>Facebook</a>
								<a class="btn flex-fill m-l5 google-plus" href="#"><i class="fa fa-google-plus"></i>Google Plus</a>
							</div>
						</div> --}}
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- External JavaScripts -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendors/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('assets/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendors/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script src="{{asset('assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('assets/vendors/magnific-popup/magnific-popup.js')}}"></script>
<script src="{{asset('assets/vendors/counter/waypoints-min.js')}}"></script>
<script src="{{asset('assets/vendors/counter/counterup.min.js')}}"></script>
<script src="{{asset('assets/vendors/imagesloaded/imagesloaded.js')}}"></script>
<script src="{{asset('assets/vendors/masonry/masonry.js')}}"></script>
<script src="{{asset('assets/vendors/masonry/filter.js')}}"></script>
<script src="{{asset('assets/vendors/owl-carousel/owl.carousel.js')}}"></script>
<script src="{{asset('assets/js/functions.js')}}"></script>
<script src="{{asset('assets/js/contact.js')}}"></script>
<script src='{{asset('assets/vendors/switcher/switcher.js')}}'></script>
</body>

</html>
