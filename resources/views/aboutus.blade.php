@extends('layouts.app')

@php
    $pageTitle = 'About Konnect Yatra — Seva for Sikh Pilgrims';
    $pageDescription = 'Konnect Yatra takes pride in contributing to the seva for Sikh pilgrims '
        . 'embarking on the Nankana Sahib yatra and visiting the other sacred Gurdwaras in Pakistan.';
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    \App\Support\Schema::webPage([
        'type'          => 'AboutPage',
        'name'          => 'About Konnect Yatra',
        'description'   => $pageDescription,
        'primaryEntity' => \App\Support\Schema::orgId(),
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['About Us', null],
    ]),
]) !!}
@endsection

@section('content')
<style type="text/css">
    .about_map:hover {
        cursor: pointer;
        -ms-transform: scale(1.5);
        -webkit-transform: scale(1.5);
        transform: scale(1.1);
        filter: drop-shadow(0 0 0.25rem rgb(0, 0, 0));
    }
    .about_map {
        border-radius: 10px;
        transition: transform .2s;
    }
</style>
<main id="content" class="site-main">
    <section class="inner-banner-wrap">
        <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('aboutus', asset('assets/images2/g2.jpg')) }}'); background-position:center;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:65px !important;">ABOUT US</h1>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>
    <section class="about-section about-page-section">
        <div class="about-service-wrap">
            <div class="container">
                <div class="section-heading">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h5 class="dash-style">The mission of Konnect Yatra</h5>
                            <h2>what people say</h2>
                        </div>
                        <div class="col-lg-6">
                            <div class="section-disc">
                                <p>
                                    Konnect Yatra takes pride in contributing to the seva (service) for Sikh pilgrims embarking on the Nankana Sahib yatra and visiting other sacred Gurdwaras in Pakistan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="client-section">
            <div class="container">

                <div class="row align-items-center d-flex">
                    <div class="col-lg-4 col-md-12 heading-bx p-lr">
                        <div class="video-bx">
                            <img src="{{ asset('assets/images2/map-01_2.jpg') }}" class="about_map">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 heading-bx p-lr">
                        <div class="video-bx">
                            <img src="{{ asset('assets/images2/map-02_2.jpg') }}" class="about_map">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 heading-bx p-lr">
                        <div class="video-bx">
                            <img src="{{ asset('assets/images2/YATRA-MAP_3.jpg') }}" class="about_map">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 heading-bx p-lr mt-5">
                        <div class="video-bx">
                            <img src="{{ asset('assets/images2/welcome.png') }}" class="about_map">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 heading-bx p-lr mt-5">
                        <div class="video-bx">
                            <img src="{{ asset('assets/images2/ministry2.png') }}" class="about_map">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="client-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2 class=" text-center mb-5">Register online on <br/> KONNECT-YATRA</h2>
                            
                            <p>The first Gurdwara in the world was built by Guru Nanak in 1521-2 at Kartarpur. There are about 200 Gurdwaras in Britain.

                            The literal meaning of the Punjabi word Gurdwara is 'the residence of the Guru', or 'the door that leads to the Guru'.</p>

                            <p> In a modern Gurdwara, the Guru is not a person but the book of Sikh scriptures called the Guru Granth Sahib.It is the presence of the Guru Granth Sahib that gives the Gurdwara its religious status, so any building containing the book is a Gurdwara.Although a Gurdwara may be called the residence of the Guru (meaning the residence of God), Sikhs believe that God is present everywhere.</p>

                            <p>Before the time of Guru Arjan Dev, the place of Sikh religious activities was known as a Dharamsala, which means place of faith</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>

@endsection
