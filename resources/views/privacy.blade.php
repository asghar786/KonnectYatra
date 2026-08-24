@extends('layouts.app')

@php
    $pageTitle = 'Privacy Policy';
    $pageDescription = 'How Konnect Yatra collects, uses and protects the information you share '
        . 'with us when you request a quote, book a yatra package, or apply for a Pakistan '
        . 'pilgrim visa.';
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    \App\Support\Schema::webPage([
        'type'          => 'WebPage',
        'name'          => 'Privacy Policy',
        'description'   => $pageDescription,
        'primaryEntity' => \App\Support\Schema::orgId(),
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Privacy Policy', null],
    ]),
]) !!}
@endsection

@section('content')
<style type="text/css">
    .pv{--brand:#f54e18;--ink:#1c2541}
    .pv-wrap{max-width:820px;margin:0 auto;padding:0 15px}
    .pv-updated{color:#6b7280;font-size:14px;margin-bottom:34px}
    .pv-wrap h2{font-size:22px;font-weight:800;color:var(--ink);margin:40px 0 14px}
    .pv-wrap h2:first-of-type{margin-top:0}
    .pv-wrap p,.pv-wrap li{color:#374151;font-size:15.5px;line-height:1.8}
    .pv-wrap ul{padding-left:20px;margin-bottom:16px}
    .pv-wrap li{margin-bottom:8px}
    .pv-wrap a{color:var(--brand);font-weight:600}
</style>

<main id="content" class="site-main pv">
    <section class="inner-banner-wrap">
        <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('privacy', asset('assets/images2/Inner-banner-01.png')) }}'); background-position:center;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:clamp(24px,4.2vw,48px) !important;">Privacy Policy</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="section-sp2">
        <div class="pv-wrap">
            <p class="pv-updated">Last updated: 24 August 2026</p>

            <p>
                Konnect Yatra USA ("Konnect Yatra", "we", "us") organises Sikh pilgrimage (yatra)
                tours from the United States and Canada to Nankana Sahib, Panja Sahib, Kartarpur
                Sahib and the other historic Gurdwaras of Pakistan. This page explains what
                information we collect through
                <a href="{{ url('/') }}">konnectyatra.org</a>, why we collect it, and how you can
                reach us about it.
            </p>

            <h2>Information we collect</h2>
            <ul>
                <li><b>Contact and quote requests</b> &mdash; your name, email, phone number and
                    message when you use the Contact form or the "Find Your Nearest Gurdwara
                    Sahib" popup, including the city, state, ZIP code and nearest Gurdwara Sahib
                    you tell us about.</li>
                <li><b>Newsletter</b> &mdash; the email address you give us to subscribe.</li>
                <li><b>Bookings and visa applications</b> &mdash; the details a Pakistan pilgrim
                    visa application requires: your legal name, date of birth, nationality,
                    passport details, and uploaded copies of your passport, Green Card and
                    Driver&rsquo;s License or State ID, plus a passport-style photograph.</li>
                <li><b>Wire-transfer payment details</b> &mdash; on the Special Land Package
                    application, the bank routing and account information you provide so we can
                    confirm your wire transfer.</li>
                <li><b>Site usage</b> &mdash; standard traffic data recorded automatically for
                    every visit (pages viewed, device and browser type, referring site, and IP
                    address) through our own first-party analytics. Where our team has enabled
                    Google Analytics 4 and/or Microsoft Clarity for this site, those services may
                    also collect data, governed by Google&rsquo;s and Microsoft&rsquo;s own privacy
                    policies.</li>
            </ul>

            <h2>How we use it</h2>
            <ul>
                <li>To prepare and file your Pakistan pilgrim visa application and arrange your
                    flights, hotels, ground transport and tour security.</li>
                <li>To respond to inquiries, quote requests, and questions about a booking already
                    in progress.</li>
                <li>To send trip-related updates and, if you subscribed, our newsletter.</li>
                <li>To understand how the site is used so we can keep it working well.</li>
            </ul>

            <h2>Who we share it with</h2>
            <p>
                We do not sell your information. We share what is necessary to run your trip with:
                the Pakistani immigration and consular authorities who issue the pilgrim visa; the
                airlines, hotels and ground-transport operators on your itinerary; and service
                providers who host this site or deliver our email on our behalf. Wire-transfer
                details are shared only with our bank, to confirm receipt of your payment.
            </p>

            <h2>Uploaded documents</h2>
            <p>
                Passport, Green Card, Driver&rsquo;s License/State ID and photo uploads are used
                solely to prepare your visa application and booking record, and are kept as part
                of that record. Contact us using the details below if you would like a copy of
                what we hold for you, or to ask that it be deleted once your trip is complete.
            </p>

            <h2>Cookies</h2>
            <p>
                We use a session cookie to keep you logged in during a booking, and a first-party
                cookie to recognise returning visitors for our own analytics. If Google Analytics
                4 or Microsoft Clarity is enabled for this site, those tools set their own cookies
                as described in their respective privacy policies.
            </p>

            <h2>Your choices</h2>
            <p>
                Every newsletter email includes a way to unsubscribe. For anything else &mdash;
                reviewing, correcting or deleting the personal information we hold about you
                &mdash; contact us using the details below. Some records tied to a visa application
                or completed booking may need to be kept for our own accounting and immigration
                recordkeeping.
            </p>

            <h2>Children</h2>
            <p>
                This site is not directed at children under 13, and we do not knowingly collect
                information from them.
            </p>

            <h2>Changes to this policy</h2>
            <p>
                We may update this page as the site or our services change. The date at the top
                shows when it was last revised.
            </p>

            <h2>Contact us</h2>
            <p>
                Questions about this policy or your information can be sent to
                <a href="mailto:{{ \App\Support\Business::email() }}">{{ \App\Support\Business::email() }}</a>,
                by phone at
                <a href="tel:{{ \App\Support\Business::phoneDigits() }}">{{ \App\Support\Business::phone() }}</a>,
                or by mail to {{ \App\Support\Business::addressLine() }}.
            </p>
        </div>
    </section>
</main>
@endsection
