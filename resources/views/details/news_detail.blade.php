@extends('layouts.app')

@php
    $newsUrl  = route('news_detail', $news->id);
    // The `file` column holds either an image or an mp4; only images belong in
    // `image`, so video items fall back to no image rather than a broken one.
    $isVideo   = \Illuminate\Support\Str::contains(strtolower((string) $news->file_type), 'video');
    $newsImage = (!empty($news->file) && !$isVideo) ? asset('news_and_events/' . $news->file) : null;
    $newsBody  = \App\Support\Schema::text($news->description);

    $pageTitle = $news->title;
    $pageDescription = \Illuminate\Support\Str::limit($newsBody, 300);
    $pageImage = $newsImage;
    $pageType  = 'article';
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    [
        '@type'            => 'NewsArticle',
        '@id'              => $newsUrl . '#article',
        'headline'         => \Illuminate\Support\Str::limit($news->title, 110, ''),
        'name'             => $news->title,
        'description'      => $pageDescription,
        'url'              => $newsUrl,
        'image'            => $newsImage,
        'articleBody'      => $newsBody,
        'datePublished'    => \App\Support\Schema::date($news->created_at),
        'dateModified'     => \App\Support\Schema::date($news->updated_at ?: $news->created_at),
        'inLanguage'       => 'en-US',
        'author'           => !empty($news->reported_by)
            ? ['@type' => 'Person', 'name' => $news->reported_by]
            : ['@id' => \App\Support\Schema::orgId()],
        'publisher'        => ['@id' => \App\Support\Schema::orgId()],
        'mainEntityOfPage' => ['@id' => $newsUrl . '#webpage'],
    ],
    \App\Support\Schema::webPage([
        'type'          => 'ItemPage',
        'name'          => $news->title,
        'description'   => $pageDescription,
        'image'         => $newsImage,
        'url'           => $newsUrl,
        'datePublished' => $news->created_at,
        'dateModified'  => $news->updated_at,
        'primaryEntity' => $newsUrl . '#article',
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['News', url('/')],
        [$news->title, null],
    ]),
]) !!}
@endsection

@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url({{ asset('assets/images2/newbanner1.jpg') }});     background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">RECENT NEWS</h1>
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
                        <h5 class="dash-style">NEWS DETAIL</h5>
                        <h2>{{ @$news->title }}</h2>
                        <p>Stay updated with our RECENT NEWS section, bringing you the latest and most relevant information at your fingertips. Explore breaking stories, current events, and noteworthy updates in just a glance. Your go-to source for staying informed and connected.</p>
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
                                    <span>{{ date('d F Y', strtotime(@$news->created_at)) }}</span>
                                 </div>
                              </li>
                              <li>
                                 <span class="icon">
                                    <i class="fas fa-map-signs"></i>
                                 </span>
                                 <div class="details-content">
                                    <h4>Reported By</h4>
                                    <span>{{ @$news->reported_by }}</span>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="contact-detail-wrap">
                     @if(@$news->file_type == "video")
                        <video style="width: 100%; height: 400px !important; border-radius: 30px;" controls>
                           <source src="{{ asset('news_and_events/'.@$news->file) }}" type="video/mp4">
                        </video>
                     @else
                        <img src="{{ asset('news_and_events/'.@$news->file) }}" style="width: 100%; border-radius: 30px; height: 400px !important;">
                     @endif
                  <p class="mt-3">{{ @$news->description }}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- contact form html end -->
</main>

@endsection