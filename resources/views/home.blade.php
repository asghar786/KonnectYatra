@extends('layouts.app')

@php
    // /home renders the same page as / — point both at the root so the two
    // URLs consolidate into one indexed page.
    \App\Support\Schema::setCanonical(rtrim(url('/'), '/') . '/');

    $pageTitle = 'Sikh Yatra Tours to Nankana Sahib, Panja Sahib & Kartarpur Sahib';
    $pageDescription = 'Konnect Yatra organises Sikh pilgrimage tours from the USA and Canada to '
        . 'Nankana Sahib, Panja Sahib and Kartarpur Sahib in Pakistan — pilgrim visa, airline '
        . 'tickets, hotels, transport and full security included.';
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    \App\Support\Schema::webPage([
        'name'        => 'Konnect Yatra — Sikh Pilgrimage Tours to Pakistan',
        'description' => $pageDescription,
        'primaryEntity' => \App\Support\Schema::orgId(),
    ]),
    \App\Support\Schema::itemList(
        collect($gurdwaras)->map(fn ($g) => [
            'url'  => route('gurdwara_detail', $g->id),
            'name' => $g->gurdwara_name,
        ])->all(),
        'Top Gurdwaras'
    ),
]) !!}
@endsection

@section('content')
<!-- Content -->
<style>
.destinations-grids {
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.destinations-grids .caption h4 {
    font-size: 20px;
    font-weight: 600;
    color: #fff;
    letter-spacing: 1px;
}
h4.destination {
    text-transform: uppercase;
    font-size: 20px;
    letter-spacing: 3px;
}
.caption a {
    font-size: 15px;
    background: none;
    border: 1px solid #ccc;
    padding: 12px 20px;
    letter-spacing: 1px;
    color: #ccc;
    margin-top: 20px;
    display: inline-block;
}

.destinations-info {
    position: absolute;
    bottom: -227px;
    margin: 0;
    background: rgba(0, 0, 0, 0.8);
    padding: 30px 0px 10px;
    transition: .5s all;
    -webkit-transition: 0.5s all;
    -moz-transition: 0.5s all;
    -o-transition: 0.5s all;
    -ms-transition: 0.5s all;
	left: 10px;
	right:10px;
    text-align: center;
}

.destinations-grids:hover div.destinations-info {
    bottom: 0;
}

.caption {
    padding: 0px;
}

@media(max-width:991px) {
    .destinations-grids {
        padding: 0 5px;
    }

    .destinations-grids h4 {
        font-size: 18px;
    }
	.destinations-info {
		left: 5px;
		right: 5px;
	}
    .destinations-info {
        padding: 20px 0;
    }
}

@media(max-width:384px) {
    .destinations-grids {
        padding: 0 1em;
    }
}

</style>

<main id="content" class="site-main">
	<!-- Home slider html start -->
	<section class="home-slider-section">
		@php
			$heroLink = function ($link) {
				$link = trim((string) $link);
				if ($link === '') return '#';
				return \Illuminate\Support\Str::startsWith($link, ['http://', 'https://', '#']) ? $link : url($link);
			};
		@endphp
		<div class="home-slider">
			@forelse(@$heroSlides as $slide)
			<div class="home-banner-items">
				<div class="banner-inner-wrap" style="background-image: url({{ asset($slide->image) }});"></div>
				<div class="banner-content-wrap">
					<div class="container">
						<div class="banner-content text-center">
							@if($slide->eyebrow)<p class="" style="font-size:30px;">{{ $slide->eyebrow }}</p>@endif
							<h2 class="banner-title">{{ $slide->title }}</h2>
							@if($slide->description)<p>{{ $slide->description }}</p>@endif
							@if($slide->btn1_text)<a href="{{ $heroLink($slide->btn1_link) }}" class="button-primary">{{ $slide->btn1_text }}</a>@endif
							@if($slide->btn2_text)<a href="{{ $heroLink($slide->btn2_link) }}" class="button-primary">{{ $slide->btn2_text }}</a>@endif
						</div>
					</div>
				</div>
				<div class="overlay"></div>
			</div>
			@empty
			<div class="home-banner-items">
				<div class="banner-inner-wrap" style="background-image: url({{asset('assets/images2/96.jpg')}});"></div>
				<div class="banner-content-wrap">
					<div class="container">
						<div class="banner-content text-center">
							<p class="" style="font-size:30px;">A Holy Journey To</p>
							<h2 class="banner-title">NANKANA SAHIB</h2>
							<p>Konnect Yatra is proud to be part of seva for Sikh pilgrims to Nankana Sahib yatra and other sacred Gurdwaras in Pakistan.</p>
							<a href="{{url('all-packages')}}" class="button-primary">BOOK NOW</a>
							<a href="{{ url('our-info') }}" class="button-primary">READ MORE</a>
						</div>
					</div>
				</div>
				<div class="overlay"></div>
			</div>
			@endforelse
		</div>
	</section>
	<!-- slider html start -->

	<!-- Home packages section html start -->
	<section class="package-section" style="margin-top:100px !important;">
		<div class="container">
			<div class="section-heading">
				<div class="row align-items-end">
					<div class="col-lg-5">
						<h5 class="dash-style">EXPLORE GREAT GURDWARAS</h5>
						<h2>TOP GURDWARAS</h2>
					</div>
					<div class="col-lg-7">
						<div class="section-disc">
							Gurdwaras, sacred sites for Sikhs, epitomize principles such as equality, community service, and devotion. The following is a compilation of our top Gurdwaras, each representing the core tenets of Sikhism.
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				@if(!empty(@$gurdwaras) > 0)
				@foreach(@$gurdwaras as $key => $value)
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="guide-content-wrap text-center">
						<figure class="guide-image m-0">
							<a href="{{ route('gurdwara_detail', @$value->id) }}">
								<img style="height: 280px; width: 100%; object-fit: cover; border-radius: 20px;" src="{{asset('gurdwara_images/'.@$value->gurdwara_image)}}" alt="{{ @$value->gurdwara_name }}">
							</a>
						</figure>
						<div class="guide-content mt-0 mx-0" style="">
							<h5 class="text-dark text-uppercase"><a href="{{ route('gurdwara_detail', @$value->id) }}" class="text-dark">{{ @$value->gurdwara_name }}</a></h5>
							<p>
								{{ @$value->address.', '.@$value->city.', '.@$value->state }}
							</p>
							<div class="btn-wrap mt-4">
								<a href="{{ route('gurdwara_detail', @$value->id) }}" class="button-text width-6 btn-slider1 mt-2">Explore More</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				@endif 	
				<div class="d-flex justify-content-center w-100 btn-wrap">
					<a href="{{ url('gurdwaras') }}" class="button-text width-6 btn-slider mt-0">View All Gurdwaras <i class="fas fa-arrow-right ml-2"></i></a>
				</div>
			</div>

		</div>
	</section>
	<!-- packages html end -->

	<!-- Home activity section html start -->
	<section class="activity-section" style="margin-top:100px !important;">
		<div class="container">
			<div class="section-heading text-center">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<h5 class="dash-style">EXPLORE OUR Gallery</h5>
						<h2>Our Tour Gallery</h2>
						<p>Our Gallery features a collection of captivating photographs capturing the essence of our previous tours. Explore these memorable images that encapsulate the unique moments and experiences from our past journeys.</p>
					</div>
				</div>
			</div>
			<div class="activity-inner row">
				<div class="col-md-12">
					<div class="gallery-slider slick11">
						@if(count($gallery) > 0)
						@foreach($gallery as $key => $value)
						<div class="col-md-6 col-sm-6 col-6 destinations-grids text-center mb-4">
                            <h4 class="destination mb-3">{{ $value->name }}</h4>
                            <div class="image-position position-relative">
                                <img src="{{ asset('gallery/'.$value->image) }}" style="width: 100%; height: 400px; object-fit: cover; object-position: {{ $value->focus_x ?? 50 }}% {{ $value->focus_y ?? 50 }}%; border-radius: 20px;" class="img-fluid">
                            </div>
                            <div class="destinations-info">
                                <div class="caption mb-lg-3">
                                    <h4>{{ $value->caption }}</h4>
                                </div>
                            </div>
                        </div>
						@endforeach
						@endif
					</div>

					{{-- small screen carousal --}}


					<div class="d-flex justify-content-center w-100 btn-wrap mt-5">
						<a href="{{ route('gallery_page') }}" class="button-text width-6 btn-slider mt-0">View Full Gallery <i class="fas fa-arrow-right ml-2"></i></a>
					</div>

						<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="display:none">
						<div class="carousel-inner">
							@if(count($gallery) > 0)
							@foreach($gallery as $key => $value)
							<div class="carousel-item @if($key == 0) active @endif">
								<img class="d-block w-100" src="{{ asset('gallery/'.$value->image) }}" alt="Slide {{ $key }}">
							</div>
							@endforeach
							@endif
						</div>
						<!-- Controls -->
						<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>


					{{-- small screen carousal --}}

				</div>
			</div>
		</div>
	</section>
	<!-- activity html end -->
	<!-- Home special section html start -->

	<section class="package-section" style="margin-top:100px !important;">
		<div class="container">
			<div class="section-heading text-center">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<h5 class="dash-style">EXPLORE GREAT HOTELS</h5>
						<h2>POPULAR <span>HOTELS</span></h2>
						<p>We are connected with five stars hotels in pakistan for your better experience.Immerse yourself in the memories, capturing the essence of each journey and the unique moments that define our travel experiences. Travel back in time through these evocative images.</p>
					</div>
				</div>
			</div>
			<div class="package-inner">
				<div class="row">
					@if(!empty(@$hotels) > 0)
					@foreach(@$hotels as $key => $value)
					<div class="col-lg-4 col-md-6">
						<div class="package-wrap">
							<figure class="feature-image mx-0">
								<a href="{{ url('/hotel-detail', @$value->id) }}">
									<img src="{{asset('hotels/'.@$value->image)}}" style="width: 100%; border-radius: 20px; height: 220px !important; object-fit: cover;" alt="">
								</a>
							</figure>
							<div class="package-content-wrap">
								<div class="package-content" style="padding: 0 11px 0;">
									<h3 class="mt-4 text-left">
										<a href="{{ url('/hotel-detail', @$value->id) }}">{{ @$value->name }}</a>
									</h3>
									{{-- <div class="review-area">
										<span class="review-text">(25 reviews)</span>
										<div class="rating-start" title="Rated 5 out of 5">
											<span style="width: 60%"></span>
										</div>
									</div> --}}
									<p>{{ @$value->address.', '.@$value->city.', '.@$value->state }}</p>
									
									<div class="btn-wrap mt-4">
										<a href="{{ url('/hotel-detail', @$value->id) }}" class="button-text width-6 btn-slider1 mt-2" previewlistener="true">Explore More</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</div>
					<div class="d-flex justify-content-center w-100 btn-wrap mt-5"><a href="{{ route('pakistan_hotels') }}" class="button-text width-6 btn-slider mt-0">View All Hotels <i class="fas fa-arrow-right ml-2"></i></a></div>
		</section>

	<section class="package-section" style="margin-top:100px !important;">
		<div class="container">
			<div class="section-heading text-center">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<h5 class="dash-style">EXPLORE GREAT LOCATIONS</h5>
						<h2>POPULAR <span>LOCATIONS</span></h2>
						<p>These places widely recognized and frequented by people due to its significance, attractions, or accessibility. These locations often hold cultural, historical, or natural importance, drawing visitors from various regions.</p>
					</div>
				</div>
			</div>
			<div class="package-inner">
				<div class="row">
					@if(!empty(@$locations) > 0)
					@foreach(@$locations as $key => $value)
					<div class="col-lg-4 col-md-6">
						<div class="package-wrap">
							<figure class="feature-image mx-0">
								<a href="{{ url('/location-detail', @$value->id) }}">
									<img src="{{asset('locations/'.@$value->image)}}" style="width: 100%; border-radius: 30px; height: 220px !important;" alt="">
								</a>
							</figure>
							<div class="package-content-wrap">
								<div class="package-content" style="padding: 0 11px 0;">
									<h3 class="mt-4 text-left">
										<a href="{{ url('/location-detail', @$value->id) }}">{{ @$value->name }}</a>
									</h3>
									{{-- <div class="review-area">
										<span class="review-text">(25 reviews)</span>
										<div class="rating-start" title="Rated 5 out of 5">
											<span style="width: 60%"></span>
										</div>
									</div> --}}
									<p>{{ @$value->city.', '.@$value->state }}</p>
									<div class="btn-wrap mt-4">
										<a href="{{ url('/location-detail', @$value->id) }}" class="button-text width-6 btn-slider1 mt-2" previewlistener="true">Explore More</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					@endif
						<div class="d-flex justify-content-center w-100 btn-wrap mt-5"><a href="{{ route('popular_locations') }}" class="button-text width-6 btn-slider mt-0">View All Locations <i class="fas fa-arrow-right ml-2"></i></a></div>
				</div>
			</div>
		</div>
	</section>
	<section class="activity-section" style="margin-top:100px !important;">
		<div class="container">
			<div class="section-heading text-center">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<h5 class="dash-style">EXPLORE UPCOMING EVENTS</h5>
						<h2>Our UPCOMING EVENTS</h2>
						<p>Engage your intellect at upcoming Gurdwara events, nourishing your mind with enlightening experiences. Join us for enriching gatherings that stimulate thought and foster spiritual growth. Feed your brain with the wisdom and insights shared in these upcoming events at the Gurdwara.</p>
					</div>
				</div>
			</div>
			<div class="activity-inner row ">
				<div class="col-md-12">
					
					<div class="slick-slider slick11">
						@if(count($events) > 0)
						@foreach(@$events as $key => $value)

						<div class="element element-1 ml-3">
							<img style="height: 200px;width:100% !important;" src="{{ asset('news_and_events/'.$value->image) }}">
							<div class="info-bx row py-3 px-3">
								<!--  -->
								<div class="col-4 py-3 px-2 text-center bg-dark text-white">
									<div class="event-date" style="font-size:40px;"><b>{{ date('d', strtotime(@$value->event_date)) }}</b></div>
									<div class="event-month"><b>{{ date('F', strtotime(@$value->event_date)) }}</b></div>
								</div>
								<div class="col-8">
									<h4 class="event-title"><a href="{{ url('/event-detail', @$value->id) }}">{{ @$value->title }}</a></h4>
									<ul class="media-post m-0 p-0" style="list-style-type:none;">
										<li><a href="{{ url('/event-detail', @$value->id) }}"><i class="fa fa-clock-o"></i> {{ @$value->event_time }}</a></li>
										<li><a href="{{ url('/event-detail', @$value->id) }}"><i class="fa fa-map-marker"></i> {{ @$value->location }}</a></li>
									</ul>
								</div>
								<div class="col-12 mt-3">
									<p>{{ @$value->description }}</p>
									<div class="btn-wrap mt-4">
										<a href="{{ url('/event-detail', @$value->id) }}" class="button-text width-6 btn-slider1 mt-2" previewlistener="true">Explore More</a>
									</div>
								</div>

								<!--  -->
							</div>
						</div>

						@endforeach
						@endif
					</div>
					{{-- small screen slider --}}
					<div id="carouselExampleControls1" class="carousel slide" data-ride="carousel" style="display:none">
						<div class="carousel-inner">
							
							@foreach(@$events as $key => $value)
							<div class="carousel-item @if($key == 0) active @endif">
								<img class="d-block w-100" src="{{asset('news_and_events/'.@$value->image)}}" alt="Slide {{ $key }}">
								<div class="info-bx row py-3 px-3">
									<!--  -->
									<div class="col-4 py-3 px-2 text-center bg-dark text-white">
										<div class="event-date" style="font-size:40px;"><b>{{ date('d', strtotime(@$value->event_date)) }}</b></div>
										<div class="event-month"><b>{{ date('F', strtotime(@$value->event_date)) }}</b></div>
									</div>
									<div class="col-8">
										<h4 class="event-title"><a href="#">{{ @$value->title }}</a></h4>
										<ul class="media-post m-0 p-0" style="list-style-type:none;">
											<li><a href="#"><i class="fa fa-clock-o"></i> {{ @$value->event_time }}</a></li>
											<li><a href="#"><i class="fa fa-map-marker"></i> {{ @$value->location }}</a></li>
										</ul>
									</div>
									<div class="col-12 mt-3">
										<p>{{ @$value->description }}</p>
										<div class="btn-wrap mt-4">
											<a href="#" class="button-text width-6 btn-slider1 mt-2" previewlistener="true">Explore More</a>
										</div>
									</div>

									<!--  -->
								</div>
							</div>
							@endforeach
							
						</div>
						{{-- small screen slider End --}}
						<!-- Controls -->
						<a class="carousel-control-prev" href="#carouselExampleControls1" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleControls1" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="package-section">
		<div class="container">
			<div class="section-heading text-center">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<h5 class="dash-style">EXPLORE NEWS</h5>
						<h2>RECENT NEWS</h2>
						<p>Stay updated with our RECENT NEWS section, bringing you the latest and most relevant information at your fingertips. Explore breaking stories, current events, and noteworthy updates in just a glance. Your go-to source for staying informed and connected.</p>
					</div>
				</div>
			</div>
			<div class="package-inner">
				<div class="row">
					
					@foreach(@$news as $key => $value)
					<div class="col-lg-4 col-md-6">
						<div class="package-wrap">
							<figure class="feature-image mx-0 my-0" style="max-height: 215px;">
								<a href="{{ url('/news-detail', @$value->id) }}">
									@if(@$value->file_type == "video")
									<video style="width: 100%; height: 205px !important; border-radius: 30px;" controls>
										<source src="{{ asset('news_and_events/'.@$value->file) }}" type="video/mp4">
											{{-- <source src="movie.ogg" type="video/ogg"> --}}
											</video>
											@else
											<img src="{{asset('news_and_events/'.@$value->file)}}" style="width: 100%; border-radius: 30px; height: 205px !important;" alt="">
											@endif
										</a>
									</figure>
									<div class="package-content-wrap">
										<div class="package-meta text-center">
											<ul>
												<li>
													<i class="far fa-calendar"></i>
													{{ date('M d Y', strtotime(@$value->created_at)) }}
												</li>
												<li>
													<i class="fas fa-user"></i>
													By {{ @$value->reported_by }}
												</li>

											</ul>
										</div>
										<div class="package-content" style="padding: 0 11px 0;">
											<h3 class="mt-4 text-left">
												<a href="{{ url('/news-detail', @$value->id) }}">{{ @$value->title }}</a>
											</h3>
											<p class="">{{ @$value->description }}</p>
											<div class="btn-wrap mt-4">
												<a href="{{ url('/news-detail', @$value->id) }}" class="button-text width-6 btn-slider1 mt-2" previewlistener="true">Explore More</a>
											</div>
										</div>

									</div>
								</div>
							</div>
							@endforeach

						</div>
					</div>
				</div>
			</section>
			<!-- President's message section -->
			<section class="ky-president" id="president-message">
				<style>
					.ky-president{padding:90px 0;background:#f6f7f9;}
					.ky-president__card{display:flex;flex-wrap:wrap;align-items:stretch;background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 24px 60px rgba(15,23,42,.10);}
					.ky-president__media{flex:1 1 360px;position:relative;min-height:360px;background:#0f1c30;}
					.ky-president__media img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;}
					.ky-president__badge{position:absolute;left:22px;bottom:22px;display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:40px;background:rgba(255,255,255,.92);color:#0f1c30;font-size:13px;font-weight:700;letter-spacing:.02em;backdrop-filter:blur(4px);}
					.ky-president__badge svg{width:16px;height:16px;color:#ef6a2e;}
					.ky-president__content{flex:1 1 480px;padding:54px 48px;}
					.ky-president__eyebrow{display:inline-block;font-size:13px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#ef6a2e;margin-bottom:14px;}
					.ky-president__title{font-size:30px;line-height:1.22;font-weight:800;color:#15213a;margin:0 0 16px;}
					.ky-president__text{font-size:16px;line-height:1.75;color:#5b6472;margin:0 0 28px;max-width:560px;}
					.ky-president__audio{margin:0 0 34px;}
					.ky-president__audio audio{width:100%;max-width:540px;height:48px;}
					.ky-president__contacts{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:20px;border-top:1px solid #edeff3;padding-top:30px;}
					.ky-contact{display:flex;align-items:center;gap:14px;text-decoration:none;color:inherit;}
					.ky-contact__icon{flex:none;width:48px;height:48px;border-radius:13px;display:flex;align-items:center;justify-content:center;background:#fff1ea;color:#ef6a2e;transition:.2s;}
					.ky-contact__icon svg{width:22px;height:22px;}
					.ky-contact__meta{display:flex;flex-direction:column;line-height:1.4;min-width:0;}
					.ky-contact__label{font-size:11px;text-transform:uppercase;letter-spacing:.09em;color:#9aa1ad;font-weight:700;}
					.ky-contact__value{font-size:15px;color:#15213a;font-weight:600;word-break:break-word;}
					.ky-contact[href]:hover .ky-contact__icon{background:#ef6a2e;color:#fff;}
					.ky-contact[href]:hover .ky-contact__value{color:#ef6a2e;}
					@media (max-width:991px){.ky-president{padding:60px 0;}.ky-president__content{padding:38px 30px;}.ky-president__media{min-height:280px;flex-basis:100%;}.ky-president__title{font-size:26px;}}
					@media (max-width:575px){.ky-president__content{padding:30px 22px;}.ky-president__title{font-size:23px;}}
				</style>
				<div class="container">
					<div class="ky-president__card">
						<div class="ky-president__media">
							<img src="{{ asset('assets/images2/z3.jpg') }}" alt="Konnect Yatra — Dhan Guru Nanak Dev Ji" loading="lazy">
							<span class="ky-president__badge">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5 6 9H2v6h4l5 4V5z"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
								Audio message
							</span>
						</div>
						<div class="ky-president__content">
							<span class="ky-president__eyebrow">A Special Message</span>
							<h2 class="ky-president__title">A Message from Our President</h2>
							<p class="ky-president__text">Listen to a personal audio message from our President on our mission to connect pilgrims with the sacred Gurdwaras and make every yatra seamless, safe, and memorable.</p>
							<div class="ky-president__audio">
								<audio controls preload="none">
									<source src="{{ asset('assets/message.mp3') }}" type="audio/mpeg">
									Your browser does not support the audio element.
								</audio>
							</div>
							<div class="ky-president__contacts">
								<a class="ky-contact" href="mailto:rm@konnectyatra.org">
									<span class="ky-contact__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg></span>
									<span class="ky-contact__meta"><span class="ky-contact__label">Email</span><span class="ky-contact__value">rm@konnectyatra.org</span></span>
								</a>
								<a class="ky-contact" href="tel:+17189089464">
									<span class="ky-contact__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
									<span class="ky-contact__meta"><span class="ky-contact__label">Call us</span><span class="ky-contact__value">+1 (718) 908-9464</span></span>
								</a>
								<div class="ky-contact">
									<span class="ky-contact__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
									<span class="ky-contact__meta"><span class="ky-contact__label">Visit us</span><span class="ky-contact__value">148-36 Guy R Brewers Blvd. Suit #202A, Jamaica, NY 11434, USA</span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- President's message section end -->
				</main>

				<!-- Content END-->

				<!-- "Near Gurdwara Sahib" homepage popup -->
				<style type="text/css">
					.gwp{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
					.gwp-overlay{position:fixed;inset:0;background:rgba(20,26,45,.6);backdrop-filter:blur(2px);z-index:2000;
						display:none;align-items:center;justify-content:center;padding:16px;opacity:0;transition:opacity .2s}
					.gwp-overlay.open{display:flex;opacity:1}
					.gwp-modal{background:#fff;border-radius:20px;width:100%;max-width:600px;max-height:92vh;display:flex;flex-direction:column;
						overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.35);transform:translateY(14px);opacity:0;transition:transform .25s ease,opacity .25s ease}
					.gwp-overlay.open .gwp-modal{transform:translateY(0);opacity:1}
					.gwp-head{position:relative;background:linear-gradient(135deg,#2d1b69,#5b2a9e);color:#fff;padding:26px 30px}
					.gwp-head h4{margin:0 0 6px;font-size:21px;font-weight:800;color:#fff}
					.gwp-head p{margin:0;font-size:13.5px;opacity:.88;line-height:1.5}
					.gwp-close{position:absolute;top:14px;right:14px;color:#fff;background:rgba(255,255,255,.18);border:0;width:32px;height:32px;
						border-radius:50%;font-size:16px;cursor:pointer;line-height:1}
					.gwp-close:hover{background:rgba(255,255,255,.3)}
					.gwp-body{padding:22px 30px 26px;overflow-y:auto}
					.gwp-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
					.gwp-trio{grid-column:1 / -1;display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
					.gwp-field{margin-bottom:16px}
					.gwp-field--full{grid-column:1 / -1}
					.gwp-field label{display:block;font-weight:700;color:var(--ink);font-size:13.5px;margin-bottom:6px}
					.gwp-opt{font-weight:600;color:var(--muted);font-size:12px}
					.gwp-field input[type=text],.gwp-field input[type=tel],.gwp-field input[type=email],.gwp-field input[type=number]{width:100%;border:1px solid #e2e4ea;border-radius:12px;padding:11px 14px;font-size:14.5px;outline:none;transition:.15s;box-sizing:border-box}
					.gwp-field input:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(245,78,24,.12)}
					.gwp-pills{display:flex;flex-wrap:wrap;gap:10px}
					.gwp-pill{position:relative;display:inline-flex;align-items:center;border:1.5px solid #e2e4ea;border-radius:30px;padding:9px 18px;font-size:13.5px;font-weight:600;color:var(--ink);cursor:pointer;transition:.15s}
					.gwp-pill input{position:absolute;opacity:0;width:0;height:0}
					.gwp-pill:hover{border-color:var(--brand)}
					.gwp-pill.checked{background:var(--brand);border-color:var(--brand);color:#fff}
					.gwp-submit{display:block;width:100%;background:var(--brand);color:#fff;border:0;font-weight:700;font-size:16px;padding:14px;border-radius:30px;cursor:pointer;box-shadow:0 8px 18px rgba(245,78,24,.3);transition:.15s}
					.gwp-submit:hover{transform:translateY(-2px)}
					.gwp-submit:disabled{opacity:.7;cursor:not-allowed;transform:none}
					.gwp-error{display:none;background:#fdecea;color:#c0392b;border-radius:10px;padding:10px 14px;font-size:13.5px;margin-bottom:14px}
					.gwp-success{display:none;text-align:center;padding:30px 10px}
					.gwp-success i{font-size:44px;color:#1c9e44;margin-bottom:14px}
					.gwp-success h5{margin:0 0 8px;color:var(--ink);font-weight:800;font-size:19px}
					.gwp-success p{margin:0;color:var(--muted);font-size:14px}
					@media (max-width:575px){.gwp-grid,.gwp-trio{grid-template-columns:1fr}.gwp-head{padding:22px 22px}.gwp-body{padding:18px 22px 22px}}
				</style>
				<div class="gwp gwp-overlay" id="gwpPopup" role="dialog" aria-modal="true" aria-labelledby="gwpTitle">
					<div class="gwp-modal">
						<div class="gwp-head">
							<button type="button" class="gwp-close js-gwp-close" aria-label="Close">&times;</button>
							<h4 id="gwpTitle"><i class="fa fa-map-marker-alt"></i> Find Your Nearest Gurdwara Sahib</h4>
							<p>Share your details and we'll help connect you to your nearest Gurdwara Sahib and upcoming Yatra updates.</p>
						</div>
						<div class="gwp-body">
							<div class="gwp-error" id="gwpError"></div>
							<form id="gwpForm" autocomplete="off">
								<div class="gwp-grid">
									<div class="gwp-trio">
										<div class="gwp-field">
											<label for="gwp_first_name">First Name</label>
											<input type="text" id="gwp_first_name" name="first_name" required>
										</div>
										<div class="gwp-field">
											<label for="gwp_middle_name">Middle Name <span class="gwp-opt">(optional)</span></label>
											<input type="text" id="gwp_middle_name" name="middle_name">
										</div>
										<div class="gwp-field">
											<label for="gwp_last_name">Last Name</label>
											<input type="text" id="gwp_last_name" name="last_name" required>
										</div>
									</div>
									<div class="gwp-field gwp-field--full">
										<label for="gwp_father_name">Father's Name</label>
										<input type="text" id="gwp_father_name" name="father_name" required>
									</div>
									<div class="gwp-field">
										<label for="gwp_phone">Telephone</label>
										<input type="tel" id="gwp_phone" name="phone" required>
									</div>
									<div class="gwp-field">
										<label for="gwp_email">Email</label>
										<input type="email" id="gwp_email" name="email" required>
									</div>
									<div class="gwp-trio">
										<div class="gwp-field">
											<label for="gwp_city">City</label>
											<input type="text" id="gwp_city" name="city" required>
										</div>
										<div class="gwp-field">
											<label for="gwp_state">State</label>
											<input type="text" id="gwp_state" name="state" required>
										</div>
										<div class="gwp-field">
											<label for="gwp_zip">Zip Code</label>
											<input type="text" id="gwp_zip" name="zip_code" required>
										</div>
									</div>
									<div class="gwp-field">
										<label for="gwp_yatri_count">Number of Yatri Interested</label>
										<input type="number" id="gwp_yatri_count" name="yatri_count" min="1" max="999" step="1" required>
									</div>
									<div class="gwp-field">
										<label for="gwp_gurdwara">Name of Near Gurdwara Sahib</label>
										<input type="text" id="gwp_gurdwara" name="near_gurdwara" required>
									</div>
									<div class="gwp-field gwp-field--full">
										<label>How did you know about Konnect Yatra USA?</label>
										<div class="gwp-pills">
											<label class="gwp-pill"><input type="radio" name="heard_from" value="Facebook" required> Facebook</label>
											<label class="gwp-pill"><input type="radio" name="heard_from" value="Friends"> Friends</label>
											<label class="gwp-pill"><input type="radio" name="heard_from" value="Gurdwara Sahib"> Gurdwara Sahib</label>
											<label class="gwp-pill"><input type="radio" name="heard_from" value="Others"> Others</label>
										</div>
									</div>
								</div>
								<button type="submit" class="gwp-submit" id="gwpSubmitBtn"><i class="fa fa-paper-plane"></i> Submit</button>
							</form>
							<div class="gwp-success" id="gwpSuccess">
								<i class="fa fa-check-circle"></i>
								<h5>Thank you!</h5>
								<p>We have received your details and will be in touch soon.</p>
							</div>
						</div>
					</div>
				</div>
				<script>
					(function () {
						var STORAGE_KEY = 'ky_gwp_submitted';
						if (localStorage.getItem(STORAGE_KEY)) return;

						var overlay = document.getElementById('gwpPopup');
						if (!overlay) return;

						var openTimer = setTimeout(function () {
							overlay.classList.add('open');
							document.body.style.overflow = 'hidden';
						}, 1400);

						function closePopup() {
							clearTimeout(openTimer);
							overlay.classList.remove('open');
							document.body.style.overflow = '';
						}

						overlay.querySelectorAll('.js-gwp-close').forEach(function (btn) {
							btn.addEventListener('click', closePopup);
						});
						overlay.addEventListener('click', function (e) {
							if (e.target === overlay) closePopup();
						});
						document.addEventListener('keydown', function (e) {
							if (e.key === 'Escape') closePopup();
						});

						overlay.querySelectorAll('.gwp-pill input[type=radio]').forEach(function (radio) {
							radio.addEventListener('change', function () {
								overlay.querySelectorAll('.gwp-pill').forEach(function (pill) {
									pill.classList.remove('checked');
								});
								radio.closest('.gwp-pill').classList.add('checked');
							});
						});

						var form = document.getElementById('gwpForm');
						var errorBox = document.getElementById('gwpError');
						var successBox = document.getElementById('gwpSuccess');
						var submitBtn = document.getElementById('gwpSubmitBtn');

						form.addEventListener('submit', function (e) {
							e.preventDefault();
							errorBox.style.display = 'none';
							submitBtn.disabled = true;
							submitBtn.innerHTML = 'Submitting…';

							var heard = form.querySelector('input[name="heard_from"]:checked');
							var payload = {
								first_name: form.first_name.value.trim(),
								middle_name: form.middle_name.value.trim(),
								last_name: form.last_name.value.trim(),
								father_name: form.father_name.value.trim(),
								phone: form.phone.value.trim(),
								email: form.email.value.trim(),
								city: form.city.value.trim(),
								state: form.state.value.trim(),
								zip_code: form.zip_code.value.trim(),
								yatri_count: form.yatri_count.value.trim(),
								near_gurdwara: form.near_gurdwara.value.trim(),
								heard_from: heard ? heard.value : ''
							};

							fetch('{{ route("gurdwara-lead.store") }}', {
								method: 'POST',
								headers: {
									'Content-Type': 'application/json',
									'Accept': 'application/json',
									'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
								},
								body: JSON.stringify(payload)
							}).then(function (res) {
								return res.json().then(function (data) {
									return { ok: res.ok, data: data };
								});
							}).then(function (r) {
								submitBtn.disabled = false;
								submitBtn.innerHTML = '<i class="fa fa-paper-plane"></i> Submit';
								if (r.ok && r.data.success) {
									localStorage.setItem(STORAGE_KEY, '1');
									form.style.display = 'none';
									successBox.style.display = 'block';
									setTimeout(closePopup, 2600);
								} else {
									var msg = 'Please check the form and try again.';
									if (r.data && r.data.errors) {
										msg = Object.keys(r.data.errors).map(function (k) { return r.data.errors[k][0]; }).join(' ');
									} else if (r.data && r.data.message) {
										msg = r.data.message;
									}
									errorBox.textContent = msg;
									errorBox.style.display = 'block';
								}
							}).catch(function () {
								submitBtn.disabled = false;
								submitBtn.innerHTML = '<i class="fa fa-paper-plane"></i> Submit';
								errorBox.textContent = 'Something went wrong. Please try again.';
								errorBox.style.display = 'block';
							});
						});
					})();
				</script>
				@endsection
