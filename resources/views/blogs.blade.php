@extends('layouts.app')
@section('content')

<main id="content" class="site-main">
   <!-- Inner Banner html start-->
   <section class="inner-banner-wrap">
      <div class="inner-baner-container" style="background-image: url('{{ \App\Models\PageBanner::url('blogs', asset('assets/images2/newbanner1.jpg')) }}'); background-position: center !important;">
         <div class="container">
            <div class="inner-banner-content">
               <h1 class="inner-title" style="font-size:65px !important;">BLOGS</h1>
            </div>
         </div>
      </div>
   </section>
   <!-- Inner Banner html end-->

   <div class="blog-page-section" style="padding: 60px 0;">
      <div class="container">
         <div class="row">
            @if(count($blogs) > 0)
               @foreach($blogs as $blog)
               <div class="col-md-4 col-sm-6 mb-4">
                  <div class="post-item" style="border:1px solid #eee; border-radius:12px; overflow:hidden; height:100%; box-shadow:0 4px 14px rgba(0,0,0,.06);">
                     <div class="feature-image">
                        @php $thumb = $blog->featured_image ?: $blog->image; @endphp
                        <a href="{{ route('blog_detail', $blog->slug) }}">
                           <img src="{{ $thumb ? asset('blog_images/'.$thumb) : asset('assets/images2/newbanner1.jpg') }}" style="width:100%; height:220px; object-fit:cover;" alt="{{ $blog->title }}">
                        </a>
                     </div>
                     <div class="post-item-content" style="padding:20px;">
                        <div class="entry-meta" style="font-size:13px; color:#888; margin-bottom:8px;">
                           <span><i class="fas fa-calendar-alt"></i> {{ $blog->published_date ? date('d M Y', strtotime($blog->published_date)) : date('d M Y', strtotime($blog->created_at)) }}</span>
                           @if($blog->author)
                           &nbsp;|&nbsp; <span><i class="fas fa-user"></i> {{ $blog->author }}</span>
                           @endif
                        </div>
                        <h3 style="font-size:20px; margin-bottom:10px;">
                           <a href="{{ route('blog_detail', $blog->slug) }}" style="color:#222;">{{ $blog->title }}</a>
                        </h3>
                        <p style="color:#666;">{{ $blog->excerpt ?: Str::limit(strip_tags($blog->body), 120) }}</p>
                        <a href="{{ route('blog_detail', $blog->slug) }}" class="button-primary" style="margin-top:8px; display:inline-block;">Read More</a>
                     </div>
                  </div>
               </div>
               @endforeach
            @else
               <div class="col-12 text-center" style="padding:60px 0;">
                  <h3>No blog posts yet. Please check back soon.</h3>
               </div>
            @endif
         </div>
      </div>
   </div>
</main>

@endsection
