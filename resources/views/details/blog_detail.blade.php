@extends('layouts.app')

@php
    $postUrl   = route('blog_detail', $blog->slug);
    $postImage = ($blog->featured_image ?: $blog->image)
        ? asset('blog_images/' . ($blog->featured_image ?: $blog->image))
        : null;
    $postBody  = \App\Support\Schema::text($blog->body);

    $pageTitle = $blog->title;
    $pageDescription = \App\Support\Schema::text($blog->excerpt, 300) ?: \Illuminate\Support\Str::limit($postBody, 300);
    $pageImage = $postImage;
    $pageType  = 'article';
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    [
        '@type'            => 'BlogPosting',
        '@id'              => $postUrl . '#article',
        'headline'         => \Illuminate\Support\Str::limit($blog->title, 110, ''),
        'name'             => $blog->title,
        'description'      => $pageDescription,
        'url'              => $postUrl,
        'image'            => $postImage,
        'articleBody'      => $postBody,
        'wordCount'        => $postBody ? str_word_count($postBody) : null,
        'datePublished'    => \App\Support\Schema::date($blog->published_date ?: $blog->created_at),
        'dateModified'     => \App\Support\Schema::date($blog->updated_at ?: $blog->published_date ?: $blog->created_at),
        'inLanguage'       => 'en-US',
        // Named author when we have one; otherwise the organisation is the
        // author, which is honest and still satisfies the required property.
        'author'           => !empty($blog->author)
            ? ['@type' => 'Person', 'name' => $blog->author]
            : ['@id' => \App\Support\Schema::orgId()],
        'publisher'        => ['@id' => \App\Support\Schema::orgId()],
        'isPartOf'         => ['@id' => route('blogs') . '#blog'],
        'mainEntityOfPage' => ['@id' => $postUrl . '#webpage'],
    ],
    \App\Support\Schema::webPage([
        'type'          => 'WebPage',
        'name'          => $blog->title,
        'description'   => $pageDescription,
        'image'         => $postImage,
        'url'           => $postUrl,
        'datePublished' => $blog->published_date ?: $blog->created_at,
        'dateModified'  => $blog->updated_at,
        'primaryEntity' => $postUrl . '#article',
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Blog', route('blogs')],
        [$blog->title, null],
    ]),
]) !!}
@endsection

@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('blogs', asset('assets/images2/newbanner1.jpg')) }}'); background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">BLOG</h1>
            </div>
         </div>
      </div>
   </section>
   <!-- Inner Banner html end-->

   <div class="single-post-section" style="padding: 60px 0;">
      <div class="container">
         <div class="row">
            <div class="col-md-8">
               <article class="post">
                  @php $hero = $blog->featured_image ?: $blog->image; @endphp
                  @if(!empty($hero))
                  <div class="feature-image" style="margin-bottom:24px;">
                     <img src="{{ asset('blog_images/'.$hero) }}" style="width:100%; border-radius:16px;" alt="{{ $blog->title }}">
                  </div>
                  @endif
                  <div class="entry-meta" style="font-size:14px; color:#888; margin-bottom:10px;">
                     <span><i class="fas fa-calendar-alt"></i> {{ $blog->published_date ? date('d F Y', strtotime($blog->published_date)) : date('d F Y', strtotime($blog->created_at)) }}</span>
                     @if($blog->author)
                     &nbsp;|&nbsp; <span><i class="fas fa-user"></i> {{ $blog->author }}</span>
                     @endif
                  </div>
                  <h1 style="font-size:36px; margin-bottom:18px;">{{ $blog->title }}</h1>
                  @if($blog->excerpt)
                  <p style="font-size:18px; color:#555; font-style:italic;">{{ $blog->excerpt }}</p>
                  @endif
                  @if(!empty($blog->image) && $blog->image !== $hero)
                  <div style="margin:20px 0;">
                     <img src="{{ asset('blog_images/'.$blog->image) }}" style="width:100%; border-radius:16px;" alt="{{ $blog->title }}">
                  </div>
                  @endif
                  <div class="entry-content" style="margin-top:20px; line-height:1.8; color:#333;">
                     {!! $blog->body !!}
                  </div>
               </article>
            </div>
            <div class="col-md-4">
               <div class="sidebar">
                  <h4 style="margin-bottom:16px;">Recent Posts</h4>
                  @forelse($recent as $r)
                  <div style="display:flex; gap:12px; margin-bottom:16px;">
                     @php $rthumb = $r->featured_image ?: $r->image; @endphp
                     <a href="{{ route('blog_detail', $r->slug) }}">
                        <img src="{{ $rthumb ? asset('blog_images/'.$rthumb) : asset('assets/images2/newbanner1.jpg') }}" style="width:80px; height:60px; object-fit:cover; border-radius:8px;">
                     </a>
                     <div>
                        <a href="{{ route('blog_detail', $r->slug) }}" style="color:#222; font-weight:600;">{{ Str::limit($r->title, 50) }}</a>
                        <div style="font-size:12px; color:#999;">{{ $r->published_date ? date('d M Y', strtotime($r->published_date)) : date('d M Y', strtotime($r->created_at)) }}</div>
                     </div>
                  </div>
                  @empty
                  <p class="text-muted">No other posts.</p>
                  @endforelse
                  <a href="{{ route('blogs') }}" class="button-primary" style="margin-top:10px; display:inline-block;">All Blogs</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>

@endsection
