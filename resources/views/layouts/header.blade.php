<!DOCTYPE html>
<html lang="en">

<head>

	@php $ga4 = \App\Models\SiteSetting::get('ga4_measurement_id'); @endphp
	@if(!empty($ga4))
	<!-- Google Analytics 4 (managed via Admin > Settings > Integrations) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4 }}"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '{{ $ga4 }}');
	</script>
	@endif

	@php
		$seoTitle = \App\Models\SiteSetting::get('seo_title');
		$seoDesc  = \App\Models\SiteSetting::get('seo_description');
		$seoKeys  = \App\Models\SiteSetting::get('seo_keywords');
		$seoOg    = \App\Models\SiteSetting::get('seo_og_image');
		$gsv      = \App\Models\SiteSetting::get('google_site_verification');
		$clarity  = \App\Models\SiteSetting::get('clarity_project_id');
		$ogImage  = !empty($seoOg) ? asset($seoOg) : asset('assets/images2/newlogo11.png');
		$metaDesc = $seoDesc ?: 'Konnect Yatra — holy yatra tours to Nankana Sahib, Panja Sahib and Kartarpur Sahib, Pakistan.';
	@endphp
	@if(!empty($gsv))<meta name="google-site-verification" content="{{ $gsv }}" />@endif
	@if(!empty($clarity))
	<!-- Microsoft Clarity (managed via Admin > Settings > Integrations) -->
	<script type="text/javascript">
		(function(c,l,a,r,i,t,y){
			c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
			t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
			y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
		})(window, document, "clarity", "script", "{{ $clarity }}");
	</script>
	@endif

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="{{ $seoKeys }}" />
	<meta name="author" content="" />
	<meta name="robots" content="index, follow" />
	<!-- DESCRIPTION -->
	<meta name="description" content="{{ $metaDesc }}" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- OG -->
	<meta property="og:type" content="website" />
	<meta property="og:title" content="{{ $seoTitle ?: 'Konnect Yatra' }}" />
	<meta property="og:description" content="{{ $metaDesc }}" />
	<meta property="og:image" content="{{ $ogImage }}" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="{{ $seoTitle ?: 'Konnect Yatra' }}" />
	<meta name="twitter:description" content="{{ $metaDesc }}" />
	<meta name="twitter:image" content="{{ $ogImage }}" />
	<meta name="format-detection" content="telephone=no">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css'>
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="{{asset('assets/images2/planeicon.png')}}" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images2/planeicon.png')}}" />

  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css"/>
	<!-- PAGE TITLE HERE ============================================= -->
	<title>@yield('titlename', !empty($seoTitle) ? $seoTitle.' | ' : '')KONNECT YATRA</title>
	<script src="https://kit.fontawesome.com/f5eb8f10bc.js" crossorigin="anonymous"></script>
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	{{-- New theme --}}
	<!-- favicon -->
	{{-- <link rel="icon" type="image/png" href="assets/images/favicon.png"> --}}
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{asset('new-assets/vendors/bootstrap/css/bootstrap.min.css')}}" media="all">
	<!-- Fonts Awesome CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('new-assets/vendors/fontawesome/css/all.min.css')}}">
	<!-- jquery-ui css -->
	<link rel="stylesheet" type="text/css" href="{{asset('new-assets/vendors/jquery-ui/jquery-ui.min.css')}}">
	<!-- modal video css -->
	<link rel="stylesheet" type="text/css" href="{{asset('new-assets/vendors/modal-video/modal-video.min.css')}}">
	<!-- light box css -->
	<link rel="stylesheet" type="text/css" href="{{asset('new-assets/vendors/lightbox/dist/css/lightbox.min.css')}}">
	<!-- slick slider css -->
	<link rel="stylesheet" type="text/css" href="{{asset('new-assets/vendors/slick/slick.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('new-assets/vendors/slick/slick-theme.css')}}">
	<!-- google fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&amp;family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&amp;display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('new-assets/style.css')}}">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css'>

	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script type="text/javascript">
		document.onkeydown = (e) => {
            if (e.key == 'F12') {
                e.preventDefault();
            }
            if (e.ctrlKey && e.shiftKey && e.key == 'I') {
                e.preventDefault();
            }
            if (e.ctrlKey && e.shiftKey && e.key == 'C') {
                e.preventDefault();
            }
            if (e.ctrlKey && e.shiftKey && e.key == 'J') {
                e.preventDefault();
            }
            if (e.ctrlKey && e.key == 'U') {
                e.preventDefault();
            }
        };
	</script>
	
</head>
<body id="bg" oncontextmenu="return false">
	<div id="siteLoader" class="site-loader" style="display: none;">
		<div class="preloader-content">
			<img src="{{asset('new-assets/images/loader1.gif')}}" alt="">
		</div>
	</div>
	<div id="page" class="full-page">
		<header id="masthead" class="site-header header-primary">
			<!-- header html start -->
			<div class="top-header">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 d-none d-lg-block">
							<div class="header-contact-info">
								<ul>
									<li>
										<a href="#"><i class="fas fa-phone"></i> +1 (718) 908-9464</a>
									</li>
									<li>
										<a href="mailto:rm@konnectyatra.org"><i class="fas fa-envelope"></i> <span class="__cf_email__">rm@konnectyatra.org</span></a>
									</li>
									<li>
										<i class="fas fa-map-marker-alt"></i> 148-36 Guy R Brewers Blvd. Suit #202A, Jamaica, NY 11434, USA
									</li>
								</ul>
							</div>
						</div>
						<div class="col-lg-4 d-flex justify-content-lg-end justify-content-between">
							<div class="header-social social-links">
								<ul>
									<li><a href="{{ \App\Models\SiteSetting::get('facebook_url') ?: '#' }}" target="_blank" rel="noopener"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
									<li><a href="{{ \App\Models\SiteSetting::get('twitter_url') ?: '#' }}" target="_blank" rel="noopener"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="{{ \App\Models\SiteSetting::get('instagram_url') ?: '#' }}" target="_blank" rel="noopener"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
									<li><a href="{{ \App\Models\SiteSetting::get('linkedin_url') ?: '#' }}" target="_blank" rel="noopener"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
								</ul>
							</div>
							<div class="header-search-icon">
								<button class="search-icon">
									<i class="fas fa-search"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bottom-header">
				<div class="container d-flex justify-content-between align-items-center">
					<div class="site-identity">
						<h1 class="site-title">
							<a href="{{ url("/") }}">
								<img class="white-logo" src="{{asset('assets\images2/newwhitelogo.png')}}" alt="logo">
								<img class="black-logo" src="{{asset('assets\images2/newlogo11.png')}}" alt="logo">
							</a>
						</h1>
					</div>
					<div class="main-navigation d-none d-lg-block">
						<nav id="navigation" class="navigation">
							<ul>
								<li><a href="{{route('home')}}">Home</a></li>
								<li class="add-mega-menu"><a href="{{url('all-packages')}}">All Packages</a></li>
								<li><a href="{{route('itinerary')}}">Airline Tickets <i class="#"></i></a></li>
								<li><a href="{{route('gurdwaras')}}">Gurdwaras</a></li>
								<li><a href="{{route('aboutus')}}">About<i class="#"></i></a></li>
								<li><a href="{{route('blogs')}}">Blogs<i class="#"></i></a></li>
								<li><a href="{{route('contactus')}}">Contact Us<i class="#"></i></a></li>
							</ul>
						</nav>
					</div>
                    {{-- <div class="header-btn">
                        <a href="#" class="button-primary">BOOK NOW</a>
                    </div> --}}
                </div>
            </div>
            <div class="mobile-menu-container"></div>
            <div class="header-search-form">
            	<div class="container">
            		<div class="header-search-container">
            			<form class="search-form" role="search" method="get" >
            				<input type="text" name="s" placeholder="Enter your text...">
            			</form>
            			<a href="#" class="search-close">
            				<i class="fas fa-times"></i>
            			</a>
            		</div>
            	</div>
            </div>
        </header>