@extends('layouts.app')

@php
    $visaUrl = route('visa');

    $pageTitle = 'Pakistan Pilgrim Visa for Sikh Yatra';
    $pageDescription = 'Konnect Yatra processes the Pakistan pilgrim (yatra) visa for every '
        . 'traveller on our packages. What we need from you, what it costs, and how long it takes.';

    /*
     | FAQ content. Every answer below is drawn from copy already published
     | elsewhere on this site — the package notes on /all-packages/{id}, the
     | upload requirements on the apply form, and the Special Land Package
     | page — so the markup and the visible page agree with the rest of the
     | site. Review with Rashad before treating any of it as final policy.
     */
    $visaFaqs = [
        [
            'question' => 'Is the Pakistan visa included in a Konnect Yatra package?',
            'answer'   => 'Yes. Every Konnect Yatra package price includes the Pakistan pilgrim '
                        . 'visa and full security throughout the tour. You do not apply to the '
                        . 'consulate yourself — we file the group application for you.',
        ],
        [
            'question' => 'What documents do I need to upload for the visa?',
            'answer'   => 'Four things: a copy of your passport, a copy of your Driver&rsquo;s '
                        . 'License or State ID, a clear passport-size photograph (a selfie is '
                        . 'acceptable), and, where it applies, a copy of your Green Card. If a '
                        . 'photograph is rejected by the visa system we will ask you to upload a '
                        . 'replacement, so please send the clearest image you have.',
        ],
        [
            'question' => 'I hold an Indian passport. Is anything different?',
            'answer'   => 'Yes. Indian passport holders must upload two pages of the passport plus '
                        . 'the Green Card and Driver&rsquo;s License or State ID, and an additional '
                        . '$50 is added to the package price.',
        ],
        [
            'question' => 'Is the visa guaranteed?',
            'answer'   => 'No. The visa is issued by the Government of Pakistan, not by Konnect '
                        . 'Yatra. We prepare and file a complete application, but a visa cannot be '
                        . 'guaranteed &mdash; and it will not be granted where the application '
                        . 'contains a misstatement.',
        ],
        [
            'question' => 'Does the package price change depending on which state I live in?',
            'answer'   => 'The published prices are quoted for New York residents. Travellers from '
                        . 'other states should call us for the price for their departure city; '
                        . 'passengers flying out of IAD (Dulles) add $50 to the package price.',
        ],
        [
            'question' => 'What happens if I have to cancel?',
            'answer'   => 'The airline&rsquo;s applicable cancellation charges apply, plus a $100 '
                        . 'service charge from Konnect Yatra.',
        ],
        [
            'question' => 'How do I start my application?',
            'answer'   => 'Choose your departure city on the packages page and complete the online '
                        . 'booking form, uploading your documents as you go. If you would rather '
                        . 'talk it through first, call Rashad Mahmood on '
                        . \App\Support\Business::phone() . '.',
        ],
    ];
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    [
        '@type'       => 'Service',
        '@id'         => $visaUrl . '#service',
        'name'        => 'Pakistan pilgrim (yatra) visa processing',
        'serviceType' => 'Travel visa processing',
        'description' => $pageDescription,
        'url'         => $visaUrl,
        'provider'    => ['@id' => \App\Support\Schema::orgId()],
        'areaServed'  => array_map(fn ($c) => ['@type' => 'Country', 'name' => $c], config('schema.areas_served')),
        'audience'    => ['@type' => 'Audience', 'audienceType' => 'Sikh pilgrims travelling to Pakistan'],
        'offers'      => [
            '@type'       => 'Offer',
            'description' => 'Included in the price of every Konnect Yatra package.',
            'seller'      => ['@id' => \App\Support\Schema::orgId()],
        ],
    ],
    // Only valid because the same questions and answers are rendered below.
    \App\Support\Schema::faq($visaFaqs),
    \App\Support\Schema::webPage([
        'name'          => 'Pakistan Pilgrim Visa',
        'description'   => $pageDescription,
        'primaryEntity' => $visaUrl . '#service',
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Pilgrim Visa', null],
    ]),
]) !!}
@endsection

@section('content')
<style type="text/css">
    .vz{--brand:#f54e18;--ink:#1c2541;--muted:#6b7280}
    .vz-lede{max-width:760px;margin:0 auto 10px;text-align:center;color:#374151;font-size:17px;line-height:1.75}
    .vz-facts{display:flex;justify-content:center;gap:14px;flex-wrap:wrap;margin:28px 0 6px;padding:0;list-style:none}
    .vz-fact{background:#fff4ef;color:var(--brand);border:1px solid #ffd9c9;border-radius:30px;padding:8px 20px;font-weight:600;font-size:14.5px}
    .vz-card{background:#fff;border:1px solid #eef0f4;border-radius:18px;box-shadow:0 10px 30px rgba(28,37,65,.08);padding:28px 30px;height:100%}
    .vz-card h3{font-size:19px;font-weight:800;color:var(--ink);margin:0 0 14px}
    .vz-docs{list-style:none;padding:0;margin:0}
    .vz-docs li{display:flex;gap:12px;padding:11px 0;border-bottom:1px dashed #eef0f4;font-size:15px;color:#374151}
    .vz-docs li:last-child{border-bottom:none}
    .vz-docs li i{color:var(--brand);margin-top:4px}
    /* Numbered steps — a CSS counter, so no icon font is involved. */
    .vz-steps{counter-reset:vzstep}
    .vz-steps li{align-items:center}
    .vz-steps li::before{counter-increment:vzstep;content:counter(vzstep);flex:none;
        width:26px;height:26px;border-radius:50%;background:var(--brand);color:#fff;
        font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center}
    .vz-faq{margin-top:14px}
    .vz-faq details{border:1px solid #eef0f4;border-radius:14px;padding:16px 20px;margin-bottom:12px;background:#fff;box-shadow:0 6px 18px rgba(28,37,65,.05)}
    .vz-faq summary{cursor:pointer;font-weight:700;color:var(--ink);font-size:16px;list-style:none;display:flex;justify-content:space-between;align-items:center;gap:14px}
    .vz-faq summary::-webkit-details-marker{display:none}
    .vz-faq summary::after{content:'\002B';color:var(--brand);font-size:22px;line-height:1;flex:none}
    .vz-faq details[open] summary::after{content:'\2212'}
    .vz-faq .vz-answer{color:#374151;font-size:15px;line-height:1.75;margin:14px 0 0}
    .vz-cta{display:inline-flex;align-items:center;gap:10px;font-weight:700;font-size:16px;padding:13px 34px;border-radius:30px;background:var(--brand);color:#fff !important;text-decoration:none;box-shadow:0 8px 18px rgba(245,78,24,.3)}
</style>

<main id="content" class="site-main vz">
    <section class="inner-banner-wrap">
        <div class="inner-baner-container"
             style="background-image: url('{{ \App\Models\PageBanner::url('visa-form', asset('assets/images2/Inner-banner-01.png')) }}');background-position:center !important;">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title" style="font-size:56px !important;">PILGRIM VISA</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pilgrim Visa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>

    <section class="section-sp2">
        <div class="container">
            <p class="vz-lede">
                Every Konnect Yatra package includes the Pakistan pilgrim (yatra) visa. You upload
                your documents once, with your booking, and we file the group application on your
                behalf &mdash; there is no separate consulate appointment for you to make.
            </p>

            <ul class="vz-facts">
                <li class="vz-fact"><i class="fas fa-passport" aria-hidden="true"></i> Visa included in every package</li>
                <li class="vz-fact"><i class="fas fa-shield-alt" aria-hidden="true"></i> Full security throughout the tour</li>
                <li class="vz-fact"><i class="fas fa-users" aria-hidden="true"></i> Filed as a group application</li>
            </ul>

            <div class="row mt-5">
                <div class="col-lg-6 mb-4">
                    <div class="vz-card">
                        <h3>What we need from you</h3>
                        <ul class="vz-docs">
                            <li><i class="fas fa-check"></i><span>A copy of your <b>passport</b></span></li>
                            <li><i class="fas fa-check"></i><span>A copy of your <b>Driver&rsquo;s License or State ID</b></span></li>
                            <li><i class="fas fa-check"></i><span>A clear <b>passport-size photograph</b> (a selfie is acceptable)</span></li>
                            <li><i class="fas fa-check"></i><span>Your <b>Green Card</b>, where it applies</span></li>
                        </ul>
                        <p class="text-muted mt-3" style="font-size:14px;line-height:1.7">
                            Indian passport holders: upload <b>two pages</b> of the passport plus the
                            Green Card and Driver&rsquo;s License or State ID. An additional <b>$50</b>
                            is added to the package price.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="vz-card">
                        <h3>How it works</h3>
                        <ul class="vz-docs vz-steps">
                            <li><span>Pick your departure city on the <a href="{{ route('all_package') }}">packages page</a>.</span></li>
                            <li><span>Complete the booking form and upload your documents.</span></li>
                            <li><span>We check the paperwork and file the group visa application.</span></li>
                            <li><span>We confirm your visa and travel documents before departure.</span></li>
                        </ul>
                        <p class="text-muted mt-3" style="font-size:14px;line-height:1.7">
                            The visa is issued by the Government of Pakistan and cannot be guaranteed.
                            It will not be granted where an application contains a misstatement.
                        </p>
                    </div>
                </div>
            </div>

            <h2 class="text-center mt-5 mb-4" style="font-size:30px;font-weight:800;color:#1c2541">
                Frequently asked questions
            </h2>

            <div class="vz-faq" style="max-width:840px;margin:0 auto">
                @foreach($visaFaqs as $i => $faq)
                <details @if($i === 0) open @endif>
                    <summary>{{ $faq['question'] }}</summary>
                    <p class="vz-answer">{!! $faq['answer'] !!}</p>
                </details>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a class="vz-cta" href="{{ route('all_package') }}">
                    <i class="fa fa-plane"></i> See yatra packages
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
