@extends('layouts.app')

@php
    $pageTitle = 'Our Info — Gallery, Events and Gurdwaras';
    $pageDescription = 'Konnect Yatra at a glance: tour gallery, upcoming events and the Gurdwara '
        . 'Sahibs we work with across the United States.';
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    \App\Support\Schema::webPage([
        'type'          => 'AboutPage',
        'name'          => 'Our Info',
        'description'   => $pageDescription,
        'primaryEntity' => \App\Support\Schema::orgId(),
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Our Info', null],
    ]),
]) !!}
@endsection

@section('content')

<main id="content" class="site-main">
    <section class="inner-banner-wrap">
        <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('our-info', asset('assets/images2/Inner-banner-01.png')) }}'); background-position:center;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:65px !important;">OUR INFO</h1>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="activity-section" style="margin-top:100px !important;">
        <div class="container">
            <div class="section-heading text-center">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h5 class="dash-style">EXPLORE GREAT Gallery</h5>
                        <h2>Our Gallery</h2>
                        <p>Our Gallery includes all our memorable pictures of our old tours.
                        Immerse yourself in the memories, capturing the essence of each journey and the unique moments that define our travel experiences. Travel back in time through these evocative images.</p>
                    </div>
                </div>
            </div>
            <div class="activity-inner row">
                <div class="col-md-12">
                    

                    <div class="slick-slider">
                        @if(count($gallery) > 0)
                        @foreach($gallery as $key => $value)
                        <div class="element element-1 ml-3"><img src="{{ asset('gallery/'.$value->image) }}"></div>
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
                    <!-- <div class="row slick">
                        @foreach(@$events as $key => $value)

                        <div class="col-lg-6 col-md-6 heading-bx p-lr mb-5" style="box-shadow: 1x 2px 3px black !important;">
                            <div class="action-box">
                                <img src="{{asset('news_and_events/'.@$value->image)}}" style="height: 400px; border-radius: 10px;" alt="">
                            </div>

                            <div class="info-bx d-flex py-3">
                                <div>
                                    <div class="event-time mt-4">
                                        <div class="event-date">{{ date('d', strtotime(@$value->event_date)) }}</div>
                                        <div class="event-month">{{ date('F', strtotime(@$value->event_date)) }}</div>
                                    </div>
                                </div>
                                <div class="event-info">
                                    <h4 class="event-title"><a href="#">{{ @$value->title }}</a></h4>
                                    <ul class="media-post">
                                        <li><a href="#"><i class="fa fa-clock-o"></i> {{ @$value->event_time }}</a></li>
                                        <li><a href="#"><i class="fa fa-map-marker"></i> {{ @$value->location }}</a></li>
                                    </ul>
                                    <p>{{ @$value->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div> -->
                    <div class="slick-slider">
                        @if(count($events) > 0)
                        @foreach(@$events as $key => $value)

                        <div class="element element-1 ml-3"><img style="height: 200px;" src="{{ asset('news_and_events/'.$value->image) }}">
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
                        @endif
                    </div>
                    {{-- small screen slider --}}
                    <div id="carouselExampleControls1" class="carousel slide" data-ride="carousel" style="display:none">
                        <div class="carousel-inner">
                            
                            @foreach(@$events as $key => $value)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <img class="d-block w-100" src="{{asset('news_and_events/'.@$value->image)}}" alt="Slide {{ $key }}">
                                <div class="info-bx d-flex py-3">
                                    <div>
                                        <div class="event-time mt-4">
                                            <div class="event-date">{{ date('d', strtotime(@$value->event_date)) }}</div>
                                            <div class="event-month">{{ date('F', strtotime(@$value->event_date)) }}</div>
                                        </div>
                                    </div>
                                    <div class="event-info mt-4">
                                        <h4 class="event-title"><a href="#">{{ @$value->title }}</a></h4>
                                        <ul class="media-post">
                                            <li><a href="#"><i class="fa fa-clock-o"></i> {{ @$value->event_time }}</a></li>
                                            <li><a href="#"><i class="fa fa-map-marker"></i> {{ @$value->location }}</a></li>
                                        </ul>
                                        <p>{{ @$value->description }}</p>
                                    </div>

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
    
</main>

@endsection
