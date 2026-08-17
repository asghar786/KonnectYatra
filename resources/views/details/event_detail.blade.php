@extends('layouts.app')

@php
    $eventUrl   = route('event_detail', $event->id);
    $eventImage = !empty($event->image) ? asset('news_and_events/' . $event->image) : null;

    // Combine the separate date and time columns into one ISO-8601 startDate.
    // Event requires a start date, so the node is only emitted when we have one.
    $eventStart = null;
    if (!empty($event->event_date)) {
        $stamp = strtotime(trim($event->event_date . ' ' . ($event->event_time ?: '')));
        $eventStart = $stamp
            ? date(!empty($event->event_time) ? \DateTime::ATOM : 'Y-m-d', $stamp)
            : null;
    }

    $pageTitle = $event->title;
    $pageDescription = \App\Support\Schema::text($event->description, 300);
    $pageImage = $eventImage;
@endphp

@section('schema')
{!! \App\Support\Schema::graph(array_filter([
    $eventStart ? [
        '@type'       => 'Event',
        '@id'         => $eventUrl . '#event',
        'name'        => $event->title,
        'url'         => $eventUrl,
        'description' => \App\Support\Schema::text($event->description, 500),
        'image'       => $eventImage,
        'startDate'   => $eventStart,
        'eventStatus' => 'https://schema.org/EventScheduled',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'location'    => !empty($event->location)
            ? ['@type' => 'Place', 'name' => $event->location,
               'address' => ['@type' => 'PostalAddress', 'name' => $event->location]]
            : null,
        'organizer'   => ['@id' => \App\Support\Schema::orgId()],
    ] : null,
    \App\Support\Schema::webPage([
        'type'          => 'ItemPage',
        'name'          => $event->title,
        'description'   => $pageDescription,
        'image'         => $eventImage,
        'url'           => $eventUrl,
        'dateModified'  => $event->updated_at,
        'primaryEntity' => $eventStart ? $eventUrl . '#event' : null,
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Events', url('/')],
        [$event->title, null],
    ]),
])) !!}
@endsection

@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url({{ asset('assets/images2/newbanner1.jpg') }});     background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">OUR UPCOMING EVENT</h1>
            </div>
         </div>
      </div>
      {{-- <div class="inner-shape"></div> --}}
   </section>
   <!-- Inner Banner html end-->
   <!-- contact form html start -->
   <div class="contact-page-section">
      <div class="contact-form-inner">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="contact-from-wrap">
                     <div class="section-heading">
                        <h5 class="dash-style">UPCOMING EVENT DETAIL</h5>
                        <h2>{{ @$event->title }}</h2>
                        <p>
                        Engage your intellect at upcoming Gurdwara events, nourishing your mind with enlightening experiences. Join us for enriching gatherings that stimulate thought and foster spiritual growth. Feed your brain with the wisdom and insights shared in these upcoming events at the Gurdwara.</p>
                     </div>
                     <div class="contact-detail-wrap pl-0">
                        <div class="details-list">
                           <ul>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Date</h4>
                                    <span>{{ date('d F Y', strtotime(@$event->event_date)) }}</span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Time</h4>
                                    <span>{{ @$event->event_time }}</span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Location</h4>
                                    <span>{{ @$event->location }}</span>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="contact-detail-wrap">
                     <img src="{{ asset('news_and_events/'.@$event->image) }}" style="width: 100%; border-radius: 30px; height: 400px !important;">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- contact form html end -->
</main>

@endsection