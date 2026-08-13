@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="{{ asset('new-assets/css/special-land-package.css') }}?v=1">

<div class="page-content bg-white">

  <!-- inner page banner -->
  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container" style="background-image: url({{asset('assets/images2/Inner-banner-01.png')}});background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
          <h1 class="inner-title" style="font-size: clamp(22px, 5.4vw, 58px) !important;">SPECIAL LAND PACKAGE</h1>
        </div>
      </div>
    </div>
  </section>
  <!-- inner page banner END -->

  <div class="slp">

    <!-- ============ Intro ============ -->
    <section class="slp-intro">
      <div class="slp-wrap">
        <p class="slp-salutation">
          <span>Wahe Guru Ji ka Khalsa</span><i></i><span>Wahe Guru Ji ki Fateh</span>
        </p>
        <h2 class="slp-title">Holy Journey to Nankana&nbsp;Sahib</h2>
        <p class="slp-lede">
          Six days on the road between the shrines of Punjab &mdash; Panja Sahib, Nankana Sahib
          and Kartarpur Sahib &mdash; travelling as one group, from Wagah Border and back.
        </p>
        <ul class="slp-facts">
          <li class="slp-fact"><i class="fas fa-passport" aria-hidden="true"></i> Visa included</li>
          <li class="slp-fact"><i class="fas fa-shield-alt" aria-hidden="true"></i> Full security</li>
          <li class="slp-fact"><i class="fas fa-hotel" aria-hidden="true"></i> Hotels, transport &amp; meals</li>
          <li class="slp-fact slp-fact--quiet"><i class="fas fa-info-circle" aria-hidden="true"></i> Places are first come, first serve</li>
        </ul>
      </div>
    </section>

    <!-- ============ Configurator ============ -->
    <div class="slp-band">
      <div class="slp-wrap">

        <form method="POST" action="{{ url('/save-initial-info') }}" class="form" id="slpForm">
          @csrf

          <div class="slp-layout">

            <!-- ---------- left: build the journey ---------- -->
            <div>

              <!-- Travellers -->
              <section class="slp-section">
                <fieldset class="slp-fieldset">
                  <legend class="slp-section-head">
                    <p class="slp-eyebrow slp-eyebrow--accent">Step one</p>
                    <h3 class="slp-section-title">Who is travelling?</h3>
                    <p class="slp-section-note">The price below is for everyone in your party.</p>
                  </legend>

                  <div class="slp-stepper-row">
                    <div class="slp-stepper">
                      <button type="button" id="slpMinus" aria-label="One traveller fewer">&minus;</button>
                      <label class="slp-sr" for="total_persons">Number of travellers</label>
                      <input type="number" id="total_persons" name="total_persons"
                             value="1" min="1" max="10" step="1" inputmode="numeric">
                      <button type="button" id="slpPlus" aria-label="One traveller more">+</button>
                    </div>
                    <p class="slp-stepper-hint">Up to 10 people on one application.<br>Travelling with a larger sangat? Call us.</p>
                  </div>
                </fieldset>
              </section>

              <!-- Tier -->
              <section class="slp-section">
                <fieldset class="slp-fieldset">
                  <legend class="slp-section-head">
                    <p class="slp-eyebrow slp-eyebrow--accent">Step two</p>
                    <h3 class="slp-section-title">Choose your stay</h3>
                    <p class="slp-section-note">Same route and same group either way &mdash; the difference is the hotels in Islamabad and Lahore.</p>
                  </legend>

                  <div class="slp-tiers">
                    <label class="slp-tier">
                      <input type="radio" name="package_type" class="package_type" value="4 Star Package"
                             data-price="750" data-extra="125" checked>
                      <span class="slp-tier-face">
                        <span class="slp-tier-check" aria-hidden="true"><i class="fas fa-check"></i></span>
                        <span class="slp-tier-stars" aria-hidden="true">
                          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </span>
                        <span class="slp-tier-name">4 Star Land Package</span>
                        <span class="slp-tier-detail">Four star hotels, breakfast and dinner, all transport.</span>
                        <span class="slp-tier-price"><b>$750</b> <span>per person &middot; 6 days</span></span>
                      </span>
                    </label>

                    <label class="slp-tier">
                      <input type="radio" name="package_type" class="package_type" value="5 Star Package"
                             data-price="950" data-extra="150">
                      <span class="slp-tier-face">
                        <span class="slp-tier-check" aria-hidden="true"><i class="fas fa-check"></i></span>
                        <span class="slp-tier-stars" aria-hidden="true">
                          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </span>
                        <span class="slp-tier-name">5 Star Land Package</span>
                        <span class="slp-tier-detail">Five star hotels, breakfast and dinner, all transport.</span>
                        <span class="slp-tier-price"><b>$950</b> <span>per person &middot; 6 days</span></span>
                      </span>
                    </label>
                  </div>
                </fieldset>
              </section>

              <!-- The route -->
              <section class="slp-section">
                <div class="slp-section-head">
                  <p class="slp-eyebrow slp-eyebrow--accent">Step three</p>
                  <h3 class="slp-section-title">The route</h3>
                  <p class="slp-section-note">These six days are included in every package.</p>
                </div>

                <ol class="slp-route">
                  <li class="slp-stop">
                    <span class="slp-marker" aria-hidden="true">1</span>
                    <div class="slp-stop-card">
                      <p class="slp-stop-day">Day 1</p>
                      <h4 class="slp-stop-title">Wagah Border to Islamabad</h4>
                      <ul class="slp-stop-list">
                        <li>Pickup from Wagah Border.</li>
                        <li>Travel to Islamabad.</li>
                      </ul>
                    </div>
                  </li>

                  <li class="slp-stop">
                    <span class="slp-marker" aria-hidden="true">2</span>
                    <div class="slp-stop-card">
                      <p class="slp-stop-day">Day 2</p>
                      <h4 class="slp-stop-title">Panja Sahib</h4>
                      <ul class="slp-stop-list">
                        <li>Departure from Islamabad to Panja Sahib.</li>
                        <li>Travel to Lahore.</li>
                      </ul>
                    </div>
                  </li>

                  <li class="slp-stop">
                    <span class="slp-marker" aria-hidden="true">3</span>
                    <div class="slp-stop-card">
                      <p class="slp-stop-day">Day 3</p>
                      <h4 class="slp-stop-title">Nankana Sahib</h4>
                      <ul class="slp-stop-list">
                        <li>Travel from Lahore to Nankana Sahib.</li>
                        <li>Travel back to Lahore.</li>
                      </ul>
                    </div>
                  </li>

                  <li class="slp-stop">
                    <span class="slp-marker" aria-hidden="true">4</span>
                    <div class="slp-stop-card">
                      <p class="slp-stop-day">Day 4</p>
                      <h4 class="slp-stop-title">Darshan across Lahore</h4>
                      <ul class="slp-stop-list">
                        <li>Visit Gurdwara Sahib 6ien Patshahi Temple Road, Lahore.</li>
                        <li>Visit Gurdwara Sahib Singh Singhnia.</li>
                        <li>Visit Gurdwara Sahib Guru Ram Das Ji.</li>
                        <li>Visit Gurdwara Dera Sahib.</li>
                        <li>Visit Qila Mahraja Ranjit Singh.</li>
                        <li>Shopping in Lahore.</li>
                      </ul>
                    </div>
                  </li>

                  <li class="slp-stop">
                    <span class="slp-marker" aria-hidden="true">5</span>
                    <div class="slp-stop-card">
                      <p class="slp-stop-day">Day 5</p>
                      <h4 class="slp-stop-title">Kartarpur Sahib</h4>
                      <ul class="slp-stop-list">
                        <li>Travel from Lahore to Kartarpur Sahib.</li>
                        <li>Travel back to Lahore.</li>
                      </ul>
                    </div>
                  </li>

                  <li class="slp-stop">
                    <span class="slp-marker" aria-hidden="true">6</span>
                    <div class="slp-stop-card">
                      <p class="slp-stop-day">Day 6</p>
                      <h4 class="slp-stop-title">Bebe Nanki Ji, then home</h4>
                      <ul class="slp-stop-list">
                        <li>Visit Darbar Saien Mian Mir Sahib.</li>
                        <li>Visit Gurdwara Sahib Bebe Nanki ji.</li>
                        <li>Departure to Wagah Border.</li>
                      </ul>
                      <p class="slp-stop-note">
                        <b>If you stay longer than 6 days</b> this departure moves to day 10, and day 6
                        becomes a Lahore tour with time for shopping.
                      </p>
                    </div>
                  </li>
                </ol>

                <!-- reveal -->
                <div class="slp-extend-cta" id="slpExtendCta" style="margin-top: 24px;">
                  <button type="button" class="slp-extend-toggle" id="add_days" aria-expanded="false" aria-controls="slpExtend">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                    Extend the journey &mdash; 4 more days available
                  </button>
                </div>

                <!-- optional days -->
                <div class="slp-extend" id="slpExtend" hidden>
                  <div class="slp-extend-head">
                    <span class="slp-marker" aria-hidden="true"><i class="fas fa-plus"></i></span>
                    <h4 class="slp-extend-title">Stay longer in Punjab</h4>
                    <p class="slp-extend-sub">Add any of these days. Each one is charged per traveller.</p>
                  </div>

                  @php
                    $extraDays = [
                      ['day' => 7,  'title' => 'Rohri Sahib &amp; Eminabad', 'items' => [
                        'Travel from Lahore to Rohri Sahib, Eminabad.',
                        'Visit Birthplace of Maharaja Ranjit Singh, Gujranwala.',
                        'Travel back to Lahore.',
                      ]],
                      ['day' => 8,  'title' => 'Sacha Sauda Sahib', 'items' => [
                        'Travel from Lahore to Sacha Sauda Sahib.',
                        'Travel from Sacha Sauda Sahib to Nankana Sahib (Al-widai Tour).',
                        'Travel back to Lahore.',
                      ]],
                      ['day' => 9,  'title' => 'Ber Sahib &amp; Baoli Sahib, Sialkot', 'items' => [
                        'Visit Gurdwara Bair Sahib also known as Gurdwara Babe Di Ber Sahib, Sialkot.',
                        'Visit Gurdwara Baoli Sahib, Sialkot.',
                        'Shopping in Lahore.',
                      ]],
                      ['day' => 10, 'title' => 'Bebe Nanki Ji, then home', 'items' => [
                        'Visit Darbar Saien Mian Mir Sahib.',
                        'Visit Gurdwara Sahib Bebe Nanki ji.',
                        'Departure to Wagah Border.',
                      ]],
                    ];
                  @endphp

                  <div class="slp-optional">
                    @foreach($extraDays as $d)
                    <label class="slp-opt">
                      <input type="checkbox" name="days[]" class="added_days" value="Day {{ $d['day'] }}">
                      <div class="slp-opt-face">
                        <span class="slp-marker" aria-hidden="true">{{ $d['day'] }}</span>
                        <div class="slp-opt-body">
                          <p class="slp-stop-day">Day {{ $d['day'] }}</p>
                          <h5 class="slp-stop-title">{!! $d['title'] !!}</h5>
                          <ul class="slp-stop-list">
                            @foreach($d['items'] as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                          </ul>
                        </div>
                        <div class="slp-opt-aside">
                          <span class="slp-opt-price">+$<span class="slp-day-rate">125</span> <span>each</span></span>
                          <span class="slp-opt-toggle">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            <span class="slp-opt-add">Add day</span>
                            <span class="slp-opt-added">Added</span>
                          </span>
                        </div>
                      </div>
                    </label>
                    @endforeach
                  </div>
                </div>
              </section>
            </div>

            <!-- ---------- right: the running total ---------- -->
            <aside class="slp-summary">
              <div class="slp-summary-card">
                <p class="slp-eyebrow slp-eyebrow--invert slp-summary-eyebrow">Your journey</p>

                <dl class="slp-summary-rows">
                  <div class="slp-summary-row">
                    <dt>Travellers</dt>
                    <dd id="slpSumTravellers">1</dd>
                  </div>
                  <div class="slp-summary-row">
                    <dt>Stay</dt>
                    <dd id="slpSumTier">4 star</dd>
                  </div>
                  <div class="slp-summary-row">
                    <dt>Days</dt>
                    <dd id="days">6</dd>
                  </div>
                  <div class="slp-summary-row">
                    <dt>Nights</dt>
                    <dd id="nights">5</dd>
                  </div>
                  <div class="slp-summary-row" id="slpSumExtraRow" hidden>
                    <dt>Added days</dt>
                    <dd id="slpSumExtra">&mdash;</dd>
                  </div>
                </dl>

                <div class="slp-summary-total">
                  <dt>Total</dt>
                  <dd id="price">$750</dd>
                </div>

                <p class="slp-summary-compact" id="slpCompact">6 days &middot; 5 nights &middot; 1 traveller</p>

                <input type="hidden" name="total_price" id="total_price" value="750">

                <button type="submit" class="slp-btn slp-btn-primary" id="save-data">
                  Proceed to application
                  <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </button>

                <p class="slp-summary-note">No payment on the next step &mdash; traveller details only.</p>
              </div>
            </aside>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  'use strict';

  var form       = document.getElementById('slpForm');
  if (!form) return;

  var persons    = document.getElementById('total_persons');
  var minus      = document.getElementById('slpMinus');
  var plus       = document.getElementById('slpPlus');
  var priceEl    = document.getElementById('price');
  var totalInput = document.getElementById('total_price');
  var daysEl     = document.getElementById('days');
  var nightsEl   = document.getElementById('nights');
  var tierEl     = document.getElementById('slpSumTier');
  var travEl     = document.getElementById('slpSumTravellers');
  var extraRow   = document.getElementById('slpSumExtraRow');
  var extraEl    = document.getElementById('slpSumExtra');
  var compactEl  = document.getElementById('slpCompact');
  var extend     = document.getElementById('slpExtend');
  var extendCta  = document.getElementById('slpExtendCta');
  var addDaysBtn = document.getElementById('add_days');

  var BASE_DAYS = 6, BASE_NIGHTS = 5, MIN = 1, MAX = 10;

  function tier() {
    return form.querySelector('.package_type:checked') || form.querySelector('.package_type');
  }
  function count() {
    var n = parseInt(persons.value, 10);
    if (isNaN(n)) n = MIN;
    return Math.min(MAX, Math.max(MIN, n));
  }
  function addedDays() {
    return form.querySelectorAll('.added_days:checked');
  }
  function plural(n, one, many) { return n + ' ' + (n === 1 ? one : many); }

  function recalc(animate) {
    var t       = tier();
    var base    = parseInt(t.getAttribute('data-price'), 10);
    var perDay  = parseInt(t.getAttribute('data-extra'), 10);
    var people  = count();
    var added   = addedDays();
    var extra   = added.length;
    var total   = (base + perDay * extra) * people;

    // per-day rate shown on each optional day follows the chosen tier
    Array.prototype.forEach.call(form.querySelectorAll('.slp-day-rate'), function (el) {
      el.textContent = perDay;
    });

    var totalDays   = BASE_DAYS + extra;
    var totalNights = BASE_NIGHTS + extra;

    daysEl.textContent   = totalDays;
    nightsEl.textContent = totalNights;
    travEl.textContent   = people;
    tierEl.textContent   = t.value.replace(' Package', '').replace('Star', 'star');

    if (extra) {
      extraRow.hidden = false;
      extraEl.textContent = Array.prototype.map.call(added, function (i) {
        return i.value.replace('Day ', '');
      }).join(', ');
    } else {
      extraRow.hidden = true;
    }

    priceEl.textContent = '$' + total.toLocaleString('en-US');
    totalInput.value    = total;

    compactEl.textContent = plural(totalDays, 'day', 'days') + ' · ' +
                            plural(totalNights, 'night', 'nights') + ' · ' +
                            plural(people, 'traveller', 'travellers');

    if (animate) {
      priceEl.classList.remove('slp-pulse');
      void priceEl.offsetWidth;
      priceEl.classList.add('slp-pulse');
    }

    minus.disabled = people <= MIN;
    plus.disabled  = people >= MAX;
  }

  function step(by) {
    persons.value = Math.min(MAX, Math.max(MIN, count() + by));
    recalc(true);
  }

  minus.addEventListener('click', function () { step(-1); });
  plus.addEventListener('click',  function () { step(1); });

  persons.addEventListener('input',  function () { recalc(false); });
  persons.addEventListener('change', function () {
    persons.value = count();
    recalc(true);
  });

  form.addEventListener('change', function (e) {
    if (e.target.classList.contains('package_type') || e.target.classList.contains('added_days')) {
      recalc(true);
    }
  });

  addDaysBtn.addEventListener('click', function () {
    extend.hidden = false;
    extend.classList.add('slp-reveal');
    extendCta.hidden = true;
    addDaysBtn.setAttribute('aria-expanded', 'true');
    extend.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  });

  recalc(false);
})();
</script>

@endsection
