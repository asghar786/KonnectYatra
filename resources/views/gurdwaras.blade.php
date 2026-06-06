@extends('layouts.app')
@section('content')

<main id="content" class="site-main">

    <section class="inner-banner-wrap pb-0">
      <div class="inner-baner-container" 
      style="background-image: url('{{ \App\Models\PageBanner::url('gurdwaras', asset('assets/images2/News-04.png')) }}');background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
           <h1 class="inner-title" style="font-size:65px !important;">GURDWARAS</h1>
       </div>
   </div>
</div>
</section>
<section class="package-section" style="margin-top:100px !important;">
    <div class="container">
        <div class="package-inner">
            <div class="row">
                @if(count(@$gurdwaras) > 0)
                @foreach(@$gurdwaras as $key => $value)
                <div class="col-lg-8 offset-lg-2 section-heading text-center">
                    <div class="">
                        <h2 style="margin-top:100px !important; font-size: 38px !important;">Gurdwaras of {{ $value['state'] }}</h2>
                    </div>
                </div>
                @foreach(@$value['gurdwaras'] as $k => $v)
                <div class="col-lg-4 col-md-6">
                    <div class="guide-content-wrap text-center">
                        <figure class="feature-image m-0">
                            <a href="">
                                <img src="{{ asset('gurdwara_images/'.@$v['gurdwara_image']) }}" style="height: 250px !important; width: 100%;" alt="">
                            </a>
                        </figure>
                        <div class="guide-content mt-0 mx-0" style="background-color: #ffffff; box-shadow: 0px 0px 35px 0px rgba(0, 0, 0, 0.05); padding: 30px;">
                            <h5 class="text-dark text-uppercase" style="font-weight: 700;">{{ @$v['gurdwara_name'] }}</h5>
                            <p>
                                {{ @$v['address'].', '.@$v['city'].', '.@$v['state'] }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforeach
                @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
