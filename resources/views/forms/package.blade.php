@extends('layouts.app')

@php
    // Packages hidden from /all-packages (status != 1) stay reachable by direct
    // link but must not be indexed, and must not publish prices for something
    // the business has withdrawn.
    $pageRobots = ((int) ($packages->status ?? 0) === 1) ? 'index, follow' : 'noindex, follow';

    // --- Structured data source values -------------------------------------
    $pkgUrl   = route('package', $packages->id);
    $pkgImage = !empty($packages->image) ? asset('assets/flyers/' . $packages->image) : null;
    $pkgMonth = (!empty($packages->month_year) && strtotime($packages->month_year))
        ? date('F Y', strtotime($packages->month_year))
        : null;

    $pkgDesc = \App\Support\Schema::text($packages->sdescription, 400)
        ?: \App\Support\Schema::text($packages->round_way_description, 400)
        ?: 'Sikh pilgrimage package from ' . $packages->state . ' to Nankana Sahib, Panja Sahib and '
           . 'Kartarpur Sahib, including pilgrim visa, hotels, transport, meals and security.';

    $pageTitle = trim($packages->name) . ($pkgMonth ? ' — ' . $pkgMonth : '');
    $pageDescription = $pkgDesc;
    $pageImage = $pkgImage;
    $pageType  = 'product';

    // The stops advertised in the package's own "Package Included" list. Only
    // the "Visit ..." bullets are real places — the rest are meals/transport.
    $pkgStops = collect();
    if (!empty($packages->sdescription)) {
        preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $packages->sdescription, $m);
        $pkgStops = collect($m[1] ?? [])
            ->map(fn ($li) => \App\Support\Schema::text($li, 120))
            ->filter(fn ($t) => $t && stripos($t, 'visit ') === 0)
            ->map(fn ($t) => trim(preg_replace('/^visit\s+/i', '', $t)))
            ->unique()->values();
    }

    // Six published price points: 5-star and 4-star, each round trip / one way /
    // land package. Anything not priced is skipped rather than published as 0.
    $pkgOffers = array_filter([
        \App\Support\Schema::offer($packages->five_star_round_price,  '5-star hotel package, round trip',   $pkgUrl),
        \App\Support\Schema::offer($packages->five_star_single_price, '5-star hotel package, one way',      $pkgUrl),
        \App\Support\Schema::offer($packages->five_star_land_price,   '5-star hotel package, land only',    $pkgUrl),
        \App\Support\Schema::offer($packages->four_star_round_price,  '4-star hotel package, round trip',   $pkgUrl),
        \App\Support\Schema::offer($packages->four_star_single_price, '4-star hotel package, one way',      $pkgUrl),
        \App\Support\Schema::offer($packages->four_star_land_price,   '4-star hotel package, land only',    $pkgUrl),
    ]);
@endphp

@section('schema')
{!! \App\Support\Schema::graph([
    [
        '@type' => 'TouristTrip',
        // Lets Product-consuming parsers read the same node instead of us
        // publishing a second, competing entity for the same package.
        'additionalType' => 'https://schema.org/Product',
        '@id'         => $pkgUrl . '#trip',
        'name'        => $packages->name,
        'description' => $pkgDesc,
        'url'         => $pkgUrl,
        'image'       => $pkgImage,
        'touristType' => ['Sikh pilgrims', 'Religious travellers'],
        'provider'    => ['@id' => \App\Support\Schema::orgId()],
        'departureLocation' => !empty($packages->state) ? [
            '@type' => 'Place',
            'name'  => $packages->state,
            'address' => ['@type' => 'PostalAddress', 'addressRegion' => $packages->state, 'addressCountry' => 'US'],
        ] : null,
        'arrivalLocation' => [
            '@type'   => 'Place',
            'name'    => 'Pakistan',
            'address' => ['@type' => 'PostalAddress', 'addressCountry' => 'PK'],
        ],
        'itinerary' => $pkgStops->count() ? [
            '@type' => 'ItemList',
            'numberOfItems' => $pkgStops->count(),
            'itemListElement' => $pkgStops->values()->map(fn ($stop, $i) => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'item'     => ['@type' => 'Place', 'name' => $stop],
            ])->all(),
        ] : null,
        'offers' => \App\Support\Schema::aggregateOffer($pkgOffers, $pkgUrl),
    ],
    \App\Support\Schema::webPage([
        'type'          => 'ItemPage',
        'name'          => $packages->name,
        'description'   => $pkgDesc,
        'image'         => $pkgImage,
        'url'           => $pkgUrl,
        'dateModified'  => $packages->updated_at,
        'primaryEntity' => $pkgUrl . '#trip',
        'breadcrumb'    => \App\Support\Schema::canonical() . '#breadcrumb',
    ]),
    \App\Support\Schema::breadcrumb([
        ['Home', url('/')],
        ['Yatra Packages', route('all_package')],
        [$packages->name, null],
    ]),
]) !!}
@endsection

@section('content')

<style type="text/css">
  .owl-prev, .owl-next, .back-to-top, .btn {
    background-color: #f54e18 !important;
    color: #fff !important;
  }
  .title-head {
    border-color: #f54e18 !important;
  }
  .btn.dropdown-toggle.btn-default {
    color: #000 !important;
  }
  input, select {
    border-color: #a8a8a8 !important;
  }
</style>

<!-- Content -->
<div class="page-content bg-white">
  <!-- inner page banner -->

  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container" style="background-image: url({{asset('assets/images2/Inner-banner-01.png')}});background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
          <h1 class="inner-title" style="font-size:65px !important;">PACKAGES</h1>
        </div>
      </div>
    </div>
  </section>
  <!-- inner page banner -->
  <div class="page-banner contact-page section-sp2">
    <div class="container p-4 mt-5">
      <div class="row">
        <div class="col-4">
          <h3 class="text-center">Wahe Guru Ji ka Khalsa</h3>
        </div>
        <div class="col-4">
          <h4 class="text-center mt-2">(First Come First Serve)</h4>
        </div>
        <div class="col-4">
          <h3 class="text-center">Wahe Guru Ji ki Fateh</h3>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <h2 class="my-4 text-center " style="font-size: 35px !important;">Holy Journey to Nankana Sahib</h2>
          <h5 class="mb-4 text-center text-danger">INCLUDES VISA AND FULL SECURITY</h5>
          <div class="row g-3">
            @php
            $timestamp = strtotime(@$packages->month_year);
            $new_date_format = date('F Y', $timestamp);
            @endphp
            <div class="col-lg-12 col-md-12 col-sm-12 text-center my-3">
              <div class="form-check">
                <input class="form-check-input" name="package_id" type="hidden" value="dc1" id="package_1">
                <label class="form-check-label" for="flexCheckDefault" style="font-size: 20px; color: #000;">
                  {{ @$packages->round_way_description }}
                </label>
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
              <table class="w-100" style="background-color: #fff;">
                <thead>
                  <tr>
                    <td colspan="3" class="text-center p-2"><b style="color: #fff;">{{ @$packages->state }} 5* Hotel package (per person)</b></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    @if(!empty(@$packages->five_star_round_price))
                    <td style="width: 33.33%;" class="text-center p-2 text-dark"><b>Round trip</b></td>
                    @endif
                    @if(!empty(@$packages->five_star_single_price))
                    <td style="width: 33.33%;" class="text-center p-2 text-dark"><b>One Way</b></td>
                    @endif
                    @if(!empty(@$packages->five_star_land_price))
                    <td style="width: 33.33%;" class="text-center p-2 text-dark"><b>Land Package</b></td>
                    @endif
                  </tr>
                  <tr>
                    @if(!empty(@$packages->five_star_round_price))
                    <td style="width: 33.33%;" class="text-center p-2">
                      <input class="form-check-input pkg-opt" type="radio" name="package_type" id="opt_5_rt" value="${{ @$packages->five_star_round_price }}" data-type="round_trip">
                      <label class="form-check-label text-dark" for="opt_5_rt" style="cursor:pointer;"><b>${{ @$packages->five_star_round_price }}</b></label>
                    </td>
                    @endif
                    @if(!empty(@$packages->five_star_single_price))
                    <td style="width: 33.33%;" class="text-center p-2">
                      <input class="form-check-input pkg-opt" type="radio" name="package_type" id="opt_5_ow" value="${{ @$packages->five_star_single_price }}" data-type="one_way">
                      <label class="form-check-label text-dark" for="opt_5_ow" style="cursor:pointer;"><b>${{ @$packages->five_star_single_price }}</b></label>
                    </td>
                    @endif
                    @if(!empty(@$packages->five_star_land_price))
                    <td style="width: 33.33%;" class="text-center p-2">
                      <input class="form-check-input pkg-opt" type="radio" name="package_type" id="opt_5_land" value="${{ @$packages->five_star_land_price }}" data-type="land_package">
                      <label class="form-check-label text-dark" for="opt_5_land" style="cursor:pointer;"><b>${{ @$packages->five_star_land_price }}</b></label>
                    </td>
                    @endif
                  </tr>
                </tbody>
              </table>
              @if(!empty(@$packages->four_star_round_price) || !empty(@$packages->four_star_single_price) || !empty(@$packages->four_star_land_price))
              <table class="w-100 mt-4" style="background-color: #fff;">
                <thead>
                  <tr>
                    <td colspan="3" class="text-center p-2"><b style="color: #fff;">{{ @$packages->state }} 4* Hotel package (per person)</b></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    @if(!empty(@$packages->four_star_round_price))
                    <td style="width: 33.33%;" class="text-center p-2 text-dark"><b>Round trip</b></td>
                    @endif
                    @if(!empty(@$packages->four_star_single_price))
                    <td style="width: 33.33%;" class="text-center p-2 text-dark"><b>One Way</b></td>
                    @endif
                    @if(!empty(@$packages->four_star_land_price))
                    <td style="width: 33.33%;" class="text-center p-2 text-dark"><b>Land Package</b></td>
                    @endif
                  </tr>
                  <tr>
                    @if(!empty(@$packages->four_star_round_price))
                    <td style="width: 33.33%;" class="text-center p-2">
                      <input class="form-check-input pkg-opt" type="radio" name="package_type" id="opt_4_rt" value="${{ @$packages->four_star_round_price }}" data-type="round_trip">
                      <label class="form-check-label text-dark" for="opt_4_rt" style="cursor:pointer;"><b>${{ @$packages->four_star_round_price }}</b></label>
                    </td>
                    @endif
                    @if(!empty(@$packages->four_star_single_price))
                    <td style="width: 33.33%;" class="text-center p-2">
                      <input class="form-check-input pkg-opt" type="radio" name="package_type" id="opt_4_ow" value="${{ @$packages->four_star_single_price }}" data-type="one_way">
                      <label class="form-check-label text-dark" for="opt_4_ow" style="cursor:pointer;"><b>${{ @$packages->four_star_single_price }}</b></label>
                    </td>
                    @endif
                    @if(!empty(@$packages->four_star_land_price))
                    <td style="width: 33.33%;" class="text-center p-2">
                      <input class="form-check-input pkg-opt" type="radio" name="package_type" id="opt_4_land" value="${{ @$packages->four_star_land_price }}" data-type="land_package">
                      <label class="form-check-label text-dark" for="opt_4_land" style="cursor:pointer;"><b>${{ @$packages->four_star_land_price }}</b></label>
                    </td>
                    @endif
                  </tr>
                </tbody>
              </table>
              @endif
            </div>
              {{-- <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" name="package_id" type="hidden" value="dc1" id="package_1">
                  <label class="form-check-label" for="flexCheckDefault" style="font-size: 20px; color: #000;">
                    {{ @$packages->one_way_description }}
                  </label>
                </div>
              </div> --}}
              {{-- <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                <table class="w-100" style="background-color: #fff;">
                  <thead>
                    <tr>
                      @if(!empty(@$packages->one_single_price))
                      <td class="text-center p-2"><b style="color: #fff;">Single Occupancy</b></td>
                      @endif
                      @if(!empty(@$packages->one_double_price))
                      <td class="text-center p-2"><b style="color: #fff;">Double Occupancy</b></td>
                      @endif
                      @if(!empty(@$packages->one_triple_price))
                      <td class="text-center p-2"><b style="color: #fff;">Triple Occupancy</b></td>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      @if(!empty(@$packages->one_single_price))
                      <td class="text-center p-2 text-dark"><b>${{ @$packages->one_single_price }}</b></td>
                      @endif
                      @if(!empty(@$packages->one_double_price))
                      <td class="text-center p-2 text-dark"><b>(Less $100 in Double Occupancy for 2nd Person) If wife and husband traveling</b></td>
                      @endif
                      @if(!empty(@$packages->one_triple_price))
                      <td class="text-center p-2 text-dark"><b>${{ @$packages->one_triple_price }}</b></td>
                      @endif
                    </tr>
                  </tbody>
                </table>
              </div> --}}
              
              <div class="col-8 mt-3 mb-4">
                {!! @$packages->description !!}
                <div class="mt-4">
                  <p class="text-center mb-1">For further information please call at <b>(718) 908-9464</b> or book now at </p>
                  <h5 class="text-center"><a href="{{ url('/') }}">konnectyatra.org</a></h5>
                  <p class="mt-5">Konnect.us, Inc. presents Konnect Yatra Holy Package to Nankana Sahib</p>
                  <p>Check payable to Konnect us, Inc. 18502 Hillside Ave, Jamaica, NY 11432</p>
                  <p><b>Documents needed:</b> Copy of Valid Passport, Copy of Driver’s License or State ID and 1 Photographs</p>
                </div>
                <div class="mb-3 text-center" style="margin-top:50px !important;">
                  <a href="{{ url("all-packages/".@$id."/apply") }}" id="detail_book_now" class="button-text width-6 px-5 py-3 btn-slider1">Book Now</a>
                </div>
              </div>

              {{-- <div class="col-4 mt-3">
                <div class="video-bx">
                  @if(@$id == "1")
                  <img src="{{ asset('assets/images2/flyer-3.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                  @elseif(@$id == "2")
                  <img src="{{ asset('assets/images2/flyer-2.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                  @elseif(@$id == "3")
                  <img src="{{ asset('assets/images2/flyer-1.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                  @else(@$id == "4")
                  <img src="{{ asset('assets/images2/flyer-4.jpeg') }}" style="height: 500px; border-radius: 15px;" class="about_map">
                  @endif
                </div>
              </div> --}}

              <div class="col-4">
                @if(!empty(@$packages->image))
                <div id="brochureZoom" style="position:relative; cursor:zoom-in;" data-toggle="modal" data-target="#brochureModal">
                  <img id="brochureImg" src="{{ asset("assets/flyers/".@$packages->image) }}" style="width: 100%; height: auto; border-radius: 30px; display:block;">
                  <span id="brochureLens" class="brochure-lens"></span>
                  <span style="position:absolute; bottom:12px; right:12px; background:rgba(0,0,0,.6); color:#fff; padding:6px 12px; border-radius:20px; font-size:13px; pointer-events:none;">
                    <i class="fa fa-search-plus"></i> Click to zoom
                  </span>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- inner page banner END -->
  </div>
  <!-- Content END-->

  @if(!empty(@$packages->image))
  <!-- Brochure zoom modal -->
  <div class="modal fade" id="brochureModal" tabindex="-1" role="dialog" aria-labelledby="brochureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="background:transparent; border:0;">
        <div class="modal-header border-0 p-1" style="background:transparent;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1; text-shadow:0 1px 4px rgba(0,0,0,.6); font-size:34px;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center p-0">
          <img src="{{ asset("assets/flyers/".@$packages->image) }}" alt="{{ @$packages->name }}" style="max-width:100%; max-height:80vh; height:auto; border-radius:10px; box-shadow:0 10px 40px rgba(0,0,0,.4);">
        </div>
      </div>
    </div>
  </div>
  @endif

  <style>
    .brochure-lens {
      display: none;
      position: absolute;
      width: 170px;
      height: 170px;
      border-radius: 50%;
      border: 3px solid #fff;
      box-shadow: 0 0 14px rgba(0, 0, 0, .45);
      background-repeat: no-repeat;
      pointer-events: none;
      z-index: 5;
    }
    table {
      border: 1px solid black;
      height: auto;
      width: auto;
    }

    th {

      padding: 0px;
      width: auto;
      height: auto;
      text-align: center;
    }

    td {
      border: 1px solid black;
      padding: 0px;
      width: auto;
      height: auto;
      text-align: center;
    }
  </style>
  <script>
    (function() {
      'use strict';

      var forms = document.querySelectorAll('.needs-validation');

      Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            var firstInvalidElement = form.querySelector(':invalid');
            firstInvalidElement.scrollIntoView({
              behavior: 'smooth',
              block: 'center'
            });
          }

          form.classList.add('was-validated');
        }, false);
      });
    })();
  </script>
  <script>
    $(document).ready(function () {
      var base = "{{ url('all-packages/'.@$id.'/apply') }}";

      // Carry the chosen tier/ticket type to the apply page via the Book Now link.
      function updateBookNow() {
        var $sel = $('input[name="package_type"]:checked');
        var price = $sel.val() || '';        // e.g. "$3050"
        var type  = $sel.data('type') || ''; // round_trip | one_way | land_package
        var url = base + '?package_type=' + encodeURIComponent(price) + '&ticket_type=' + encodeURIComponent(type);
        $('#detail_book_now').attr('href', url);
      }

      // Default to the first available option.
      if (!$('input[name="package_type"]:checked').length) {
        $('input[name="package_type"]').first().prop('checked', true);
      }
      updateBookNow();
      $('input[name="package_type"]').on('change', updateBookNow);

      // Magnifier lens: show a zoomed circle of the brochure under the cursor.
      (function () {
        var box  = document.getElementById('brochureZoom');
        var img  = document.getElementById('brochureImg');
        var lens = document.getElementById('brochureLens');
        if (!box || !img || !lens) return;
        var ZOOM = 2.5;

        function move(e) {
          var rect = img.getBoundingClientRect();
          var x = e.clientX - rect.left;
          var y = e.clientY - rect.top;
          if (x < 0 || y < 0 || x > rect.width || y > rect.height) { lens.style.display = 'none'; return; }
          var lensSize = lens.offsetWidth || 170;
          lens.style.display = 'block';
          lens.style.backgroundImage = "url('" + img.src + "')";
          lens.style.backgroundSize = (rect.width * ZOOM) + 'px ' + (rect.height * ZOOM) + 'px';
          lens.style.backgroundPosition = '-' + (x * ZOOM - lensSize / 2) + 'px -' + (y * ZOOM - lensSize / 2) + 'px';
          lens.style.left = (x - lensSize / 2) + 'px';
          lens.style.top  = (y - lensSize / 2) + 'px';
        }

        box.addEventListener('mousemove', move);
        box.addEventListener('mouseleave', function () { lens.style.display = 'none'; });
      })();
    });
  </script>
  @endsection
