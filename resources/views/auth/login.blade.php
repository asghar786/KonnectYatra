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
	<meta name="description" content="EduChamp : Education HTML Template" />

	<!-- OG -->

	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="{{asset('assets/images/favicon.ico" type="image/x-icon')}}" />
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.png')}}" />

	<!-- PAGE TITLE HERE ============================================= -->
	<title>Konnect-Yatra Login</title>

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
					<h2 class="title-head">Login to your <span>Account</span></h2>
					<p>Don't have an account? <a href="{{route('register')}}">Create one here</a></p>
				</div>
				<form class="contact-bx" method="POST" action="{{ route('login') }}">
                    @csrf
					<div class="row placeani">
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group">
									<label for="email">Your Email</label>
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
							<div class="form-group form-forget">
								{{-- <div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="customControlAutosizing">
									<label class="custom-control-label" for="customControlAutosizing">Remember me</label>
								</div> --}}
							</div>
						</div>
						<div class="col-lg-12 m-b30">
							<button name="submit" type="submit" value="Submit" class="btn button-md">Login</button>
							<a href="{{ route('password.request') }}" class="ml-2">Forgot Password?</a>
						</div>
						{{-- <div class="col-lg-12">
							<h6>Login with Social media</h6>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
	@if(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
    @elseif(Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
    @endif
</script>
</body>

</html>




