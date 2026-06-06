@extends('layouts.app')
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
		<div class="home-slider">
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
			<div class="home-banner-items">
				<div class="banner-inner-wrap" style="background-image: url({{asset('assets/images2/44.jpg')}});"></div>
				<div class="banner-content-wrap">
					<div class="container">
						<div class="banner-content text-center">
							<p class="" style="font-size:30px;">A Holy Journey To</p>
							<h2 class="banner-title">KARTARPUR SAHIB</h2>
							<p>Konnect Yatra is proud to be part of seva for Sikh pilgrims to Nankana Sahib yatra and other sacred Gurdwaras in Pakistan.</p>
							<a href="{{url('all-packages')}}" class="button-primary">BOOK NOW</a>
							<a href="{{ url('our-info') }}" class="button-primary">READ MORE</a>
						</div>
					</div>
				</div>
				<div class="overlay"></div>
			</div>
			<div class="home-banner-items">
				<div class="banner-inner-wrap" style="background-image: url({{asset('assets/images2/88.jpg')}});"></div>
				<div class="banner-content-wrap">
					<div class="container">
						<div class="banner-content text-center">
							<p class="" style="font-size:30px;">A Holy Journey To</p>
							<h2 class="banner-title">PANJA SAHIB</h2>
							<p>Konnect Yatra is proud to be part of seva for Sikh pilgrims to Nankana Sahib yatra and other sacred Gurdwaras in Pakistan.</p>
							<a href="{{url('all-packages')}}" class="button-primary">BOOK NOW</a>
							<a href="{{ url('our-info') }}" class="button-primary">READ MORE</a>
						</div>
					</div>
				</div>
				<div class="overlay"></div>
			</div>
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
				<div class="col-lg-3 col-md-6">
					<div class="guide-content-wrap text-center">
						<figure class="guide-image m-0">
							<img style="height: 200px;" src="{{asset('gurdwara_images/'.@$value->gurdwara_image)}}" alt="">
						</figure>
						<div class="guide-content mt-0 mx-0" style="">
							<h5 class="text-dark text-uppercase">{{ @$value->gurdwara_name }}</h5>
							<p>
								{{ @$value->address.', '.@$value->city.', '.@$value->state }}
							</p>
							{{-- <div class="btn-wrap mt-4">
								<a href="#" class="button-text width-6 btn-slider1 mt-2" previewlistener="true">Explore More</a>
							</div> --}}
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
                                <img src="{{ asset('gallery/'.$value->image) }}" style="width: 100%; height: 400px;" class="img-fluid">
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
									<img src="{{asset('hotels/'.@$value->image)}}" style="width: 100%; border-radius: 30px; height: 220px !important;" alt="">
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
			<!-- Home contact details section html start -->
			<section class="contact-section" style="margin-top: 130px;">
				<div class="container">
					<div class="row">
						<div class="col-lg-4">
							<div class="contact-img" style="background-image: url({{ asset('assets/images2/z3.jpg') }});">
							</div>
						</div>
						<div class="col-lg-8">
							<div class="contact-details-wrap">
								<div class="row">
									<div class="col-sm-4">
										<div class="contact-details">
											<div class="contact-icon">
												<img src="assets/images/icon12.png" alt="">
											</div>
											<ul>
												<li>
													<a href="#"><span class="">rm@konnectyatra.org</span></a>
												</li>

											</ul>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="contact-details">
											<div class="contact-icon">
												<img src="assets/images/icon13.png" alt="">
											</div>
											<ul>
												<li>
													<a href="#">+1 718-908-9464</a>
												</li>

											</ul>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="contact-details">
											<div class="contact-icon">
												<img src="assets/images/icon14.png" alt="">
											</div>
											<ul>
												<li>
													18502 Hillside Avenue, Jamaica, NY 11432
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="contact-btn-wrap d-flex justify-content-center">
								<audio controls>
									<source src="horse.ogg" type="audio/ogg">
										<source src="{{ asset('assets/message.MP3')}}" type="audio/mpeg">
										</audio>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!--  contact details html end -->
				</main>

				<!-- Content END-->
				@endsection
