@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="{{ asset('new-assets/css/special-land-package.css') }}?v=1">

@php
  $addedDays  = json_decode(@$initial_info->added_days, true) ?: [];
  $totalDays  = 6 + count($addedDays);
  $totalNights = 5 + count($addedDays);
  $travellers = (int) (@$initial_info->total_persons ?: 1);
  $tierLabel  = str_replace(' Package', '', (string) @$initial_info->package_type);
  $grandTotal = (float) @$initial_info->total_price;

  $zellePhone = \App\Models\SiteSetting::get('pay_zelle_phone');
  $zelleName  = \App\Models\SiteSetting::get('pay_zelle_name');
  $zelleEmail = \App\Models\SiteSetting::get('pay_zelle_email');
  $zelleNote  = \App\Models\SiteSetting::get('pay_zelle_instructions');
@endphp

<div class="page-content bg-white">

  <!-- inner page banner -->
  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container" style="background-image: url({{asset('assets/images2/Inner-banner-01.png')}});background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
          <h1 class="inner-title" style="font-size: clamp(22px, 5.4vw, 58px) !important;">YOUR APPLICATION</h1>
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

        <div class="slp-steps">
          <span class="slp-step slp-step--done">
            <span class="slp-step-num"><i class="fas fa-check" aria-hidden="true"></i></span>
            <span class="slp-step-label">Journey</span>
          </span>
          <span class="slp-step-line" aria-hidden="true"></span>
          <span class="slp-step slp-step--on" aria-current="step">
            <span class="slp-step-num">2</span>
            <span class="slp-step-label">Traveller details</span>
          </span>
        </div>

        <h2 class="slp-title">Holy Journey to Nankana&nbsp;Sahib</h2>
        <p class="slp-lede">
          Enter each traveller exactly as their passport reads &mdash; these details go
          straight onto the visa application.
        </p>
      </div>
    </section>

    <div class="slp-band">
      <div class="slp-wrap">

        <!-- ============ What was configured on step one ============ -->
        <section class="slp-recap">
          <div class="slp-recap-head">
            <h3 class="slp-recap-title">Your journey</h3>
            <a href="{{ url('/special-package') }}" class="slp-recap-edit">Change journey</a>
          </div>

          <dl class="slp-recap-grid">
            <div class="slp-recap-item">
              <dt>Travellers</dt>
              <dd>{{ $travellers }}</dd>
            </div>
            <div class="slp-recap-item">
              <dt>Stay</dt>
              <dd>{{ $tierLabel ?: 'Land package' }}</dd>
            </div>
            <div class="slp-recap-item">
              <dt>Days &amp; nights</dt>
              <dd>{{ $totalDays }} days &middot; {{ $totalNights }} nights</dd>
            </div>
            <div class="slp-recap-item">
              <dt>Total</dt>
              <dd class="slp-recap-total">${{ number_format($grandTotal) }}</dd>
            </div>
          </dl>

          @if(count($addedDays))
          <p class="slp-recap-days">
            Extra days added: <b>{{ implode(', ', $addedDays) }}</b>
          </p>
          @endif
        </section>

        <form method="POST" action="{{ route('store-special-package') }}"
              enctype="multipart/form-data" id="slpApplyForm">
          @csrf

          @for($i = 0; $i < $travellers; $i++)
          @php $n = $i + 1; @endphp

          <section class="slp-applicant">
            <div class="slp-applicant-head">
              <span class="slp-applicant-num" aria-hidden="true">{{ $n }}</span>
              <div>
                <h3 class="slp-applicant-title">Traveller {{ $n }}</h3>
                <p class="slp-applicant-sub">
                  {{ $n === 1 ? 'The lead applicant we will contact about this booking.' : 'Travelling with the lead applicant.' }}
                </p>
              </div>
            </div>

            <input type="hidden" name="ticket_type_{{ $n }}" value="land_package">
            <input type="hidden" name="package_id_{{ $n }}" value="25">
            <input type="hidden" name="passport_type_{{ $n }}" value="Ordinary">

            <!-- ---- passport ---- -->
            <div class="slp-subsection">
              <h4 class="slp-subsection-title">Passport</h4>
              <div class="slp-grid slp-grid--2">

                <div class="slp-field">
                  <label class="slp-label" for="passport_{{ $n }}">Passport number <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="text" id="passport_{{ $n }}"
                         name="passport_{{ $n }}" placeholder="Enter passport number"
                         style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="issuing_authority_{{ $n }}">Issuing authority <span class="slp-req">*</span></label>
                  <input type="text" class="form-control slp-input" id="issuing_authority_{{ $n }}"
                         name="issuing_authority_{{ $n }}" placeholder="Enter issuing authority"
                         onkeydown="return /[a-z ]/i.test(event.key)" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="passport_country_{{ $n }}">Passport country <span class="slp-req">*</span></label>
                  <select class="form-control slp-input select2js passport_country" id="passport_country_{{ $n }}"
                          name="passport_country_{{ $n }}" required>
                    @foreach(@$countries as $key => $val)
                    <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="issue_date_{{ $n }}">Issue date <span class="slp-req">*</span></label>
                  <input class="form-control slp-input datepicker passport-datepicker" type="text"
                         id="issue_date_{{ $n }}" name="issue_date_{{ $n }}" placeholder="DD-MMM-YYYY" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="expiry_date_{{ $n }}">Expiry date <span class="slp-req">*</span></label>
                  <input class="form-control slp-input datepicker passport-datepicker" type="text"
                         id="expiry_date_{{ $n }}" name="expiry_date_{{ $n }}" placeholder="DD-MMM-YYYY"
                         min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="slp-field green_card_area">
                  <label class="slp-label" for="reference_no_{{ $n }}">Reference number <span class="slp-req">*</span></label>
                  <input class="form-control slp-input phone_us" type="text" id="reference_no_{{ $n }}"
                         name="reference_no_{{ $n }}" placeholder="Enter reference number" maxlength="11">
                </div>

                <div class="slp-field green_card_area">
                  <label class="slp-label" for="permanent_residence_country_{{ $n }}">Permanent residence country <span class="slp-req">*</span></label>
                  <select class="form-control slp-input select2js" id="permanent_residence_country_{{ $n }}"
                          name="permanent_residence_country_{{ $n }}">
                    @foreach(@$countries as $key => $val)
                    <option value="{{ @$val['nicename'] }}">{{ @$val['nicename'] }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="slp-field green_card_area">
                  <label class="slp-label" for="green_card_expiry_date_{{ $n }}">Green card expiry date</label>
                  <input class="form-control slp-input datepicker" type="text"
                         id="green_card_expiry_date_{{ $n }}" name="green_card_expiry_date_{{ $n }}"
                         placeholder="DD-MMM-YYYY">
                </div>
              </div>
            </div>

            <!-- ---- personal ---- -->
            <div class="slp-subsection">
              <h4 class="slp-subsection-title">Personal details</h4>
              <div class="slp-grid slp-grid--2">

                <div class="slp-field">
                  <label class="slp-label" for="first_name_{{ $n }}">First name <span class="slp-req">*</span></label>
                  <input type="text" class="form-control slp-input" id="first_name_{{ $n }}"
                         name="first_name_{{ $n }}" placeholder="Enter first name"
                         onkeydown="return /[a-z ]/i.test(event.key)"
                         style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="middle_name_{{ $n }}">Middle name <span class="slp-optional-tag">optional</span></label>
                  <input type="text" class="form-control slp-input" id="middle_name_{{ $n }}"
                         name="middle_name_{{ $n }}" placeholder="Enter middle name"
                         onkeydown="return /[a-z ]/i.test(event.key)"
                         style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()">
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="last_name_{{ $n }}">Last name <span class="slp-req">*</span></label>
                  <input type="text" class="form-control slp-input" id="last_name_{{ $n }}"
                         name="last_name_{{ $n }}" placeholder="Enter last name"
                         onkeydown="return /[a-z ]/i.test(event.key)"
                         style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="dob_{{ $n }}">Date of birth <span class="slp-req">*</span></label>
                  <input class="form-control slp-input dob-datepicker" type="text" id="dob_{{ $n }}"
                         name="dob_{{ $n }}" placeholder="DD-MMM-YYYY" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="place_birth_{{ $n }}">Place of birth <span class="slp-req">*</span></label>
                  <input type="text" class="form-control slp-input" id="place_birth_{{ $n }}"
                         name="place_birth_{{ $n }}" placeholder="Enter place of birth"
                         onkeydown="return /[a-z ]/i.test(event.key)"
                         style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="religion_{{ $n }}">Religion <span class="slp-req">*</span></label>
                  <select class="form-control slp-input select2js" id="religion_{{ $n }}" name="religion_{{ $n }}" required>
                    <option value="">Select</option>
                    <option value="Sikhism" selected>Sikhism</option>
                    <option value="Islam">Islam</option>
                    <option value="Christianity">Christianity</option>
                    <option value="Hinduism">Hinduism</option>
                    <option value="Buddhism">Buddhism</option>
                  </select>
                </div>

                <div class="slp-field slp-col-full">
                  <span class="slp-label">Gender <span class="slp-req">*</span></span>
                  <div class="slp-choices">
                    <label class="slp-choice">
                      <input type="radio" name="gender_{{ $n }}" value="male" required>
                      <span>Male</span>
                    </label>
                    <label class="slp-choice">
                      <input type="radio" name="gender_{{ $n }}" value="female" required>
                      <span>Female</span>
                    </label>
                  </div>
                </div>

                <div class="slp-field slp-col-full">
                  <span class="slp-label">Marital status <span class="slp-req">*</span></span>
                  <div class="slp-choices">
                    @foreach(['single' => 'Single', 'married' => 'Married', 'widowed' => 'Widowed', 'divorced' => 'Divorced', 'separated' => 'Separated'] as $val => $label)
                    <label class="slp-choice">
                      <input class="marital_status" type="radio" name="marital_status_{{ $n }}" value="{{ $val }}" required>
                      <span>{{ $label }}</span>
                    </label>
                    @endforeach
                  </div>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="email_{{ $n }}">Email address <span class="slp-req">*</span></label>
                  <input type="email" class="form-control slp-input" id="email_{{ $n }}"
                         name="email_{{ $n }}" placeholder="Enter email address"
                         style="text-transform:lowercase;" oninput="this.value=this.value.toLowerCase()" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="phone_{{ $n }}">Mobile number <span class="slp-req">*</span></label>
                  <input type="tel" class="form-control slp-input phone_us" maxlength="12"
                         id="phone_{{ $n }}" name="phone_{{ $n }}" placeholder="Enter mobile number" required>
                </div>
              </div>
            </div>

            <!-- ---- family ---- -->
            <div class="slp-subsection">
              <h4 class="slp-subsection-title">Family</h4>
              <div class="slp-grid slp-grid--2">

                <div class="slp-field">
                  <label class="slp-label" for="father_name_{{ $n }}">Father's name <span class="slp-req">*</span></label>
                  <input type="text" class="form-control slp-input" id="father_name_{{ $n }}"
                         name="father_name_{{ $n }}" placeholder="Enter father's name"
                         onkeydown="return /[a-z ]/i.test(event.key)"
                         style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="father_nationality_{{ $n }}">Father's nationality <span class="slp-req">*</span></label>
                  <select class="form-control slp-input select2js" id="father_nationality_{{ $n }}"
                          name="father_nationality_{{ $n }}" required>
                    @foreach(@$countries as $key => $val)
                    <option value="{{ @$val['nicename'] }}" @if(@$val['nicename'] == 'India') selected @endif>{{ @$val['nicename'] }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="mother_name_{{ $n }}">Mother's name <span class="slp-req">*</span></label>
                  <input type="text" class="form-control slp-input" id="mother_name_{{ $n }}"
                         name="mother_name_{{ $n }}" placeholder="Enter mother's name"
                         onkeydown="return /[a-z ]/i.test(event.key)"
                         style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="mother_nationality_{{ $n }}">Mother's nationality <span class="slp-req">*</span></label>
                  <select class="form-control slp-input select2js" id="mother_nationality_{{ $n }}"
                          name="mother_nationality_{{ $n }}" required>
                    @foreach(@$countries as $key => $val)
                    <option value="{{ @$val['nicename'] }}" @if(@$val['nicename'] == 'India') selected @endif>{{ @$val['nicename'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <!-- ---- documents ---- -->
            <div class="slp-subsection">
              <h4 class="slp-subsection-title">Documents</h4>
              <div class="slp-grid slp-grid--2">

                <div class="slp-field">
                  <label class="slp-label" for="photoFile_{{ $n }}">Photograph <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="file" name="photo_{{ $n }}" id="photoFile_{{ $n }}"
                         accept="image/*" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="passportFile_{{ $n }}">Passport <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="file" name="us_passport_{{ $n }}" id="passportFile_{{ $n }}"
                         accept="image/*,application/pdf" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="licenseFile_{{ $n }}">ID or driving licence <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="file" name="driving_license_{{ $n }}" id="licenseFile_{{ $n }}"
                         accept="image/*,application/pdf" required>
                </div>

                <div class="slp-field">
                  <label class="slp-label" for="greenCardFile_{{ $n }}">Green card <span class="slp-optional-tag">if you have one</span></label>
                  <input class="form-control slp-input" type="file" name="green_card_{{ $n }}" id="greenCardFile_{{ $n }}"
                         accept="image/*,application/pdf">
                </div>
              </div>
            </div>
          </section>
          @endfor

          <!-- ============ Payment ============ -->
          <section class="slp-applicant">
            <div class="slp-applicant-head">
              <span class="slp-applicant-num" aria-hidden="true"><i class="fas fa-wallet"></i></span>
              <div>
                <h3 class="slp-applicant-title">Payment</h3>
                <p class="slp-applicant-sub">Total for this booking: <b>${{ number_format($grandTotal) }}</b></p>
              </div>
            </div>

            <div class="slp-field">
              <span class="slp-label">How are you paying? <span class="slp-req">*</span></span>
              <div class="slp-choices">
                <label class="slp-choice">
                  <input class="payment_type" type="radio" name="payment_type" id="wire_transfer" value="Bank Wire Transfer" checked required>
                  <span>Bank wire transfer</span>
                </label>
                <label class="slp-choice">
                  <input class="payment_type" type="radio" name="payment_type" id="check" value="Check" required>
                  <span>Check</span>
                </label>
                <label class="slp-choice">
                  <input class="payment_type" type="radio" name="payment_type" id="cash" value="Cash" required>
                  <span>Cash</span>
                </label>
                <label class="slp-choice">
                  <input class="payment_type" type="radio" name="payment_type" id="zelle" value="Zelle" required>
                  <span>Zelle</span>
                </label>
                <label class="slp-choice">
                  <input class="payment_type" type="radio" name="payment_type" id="pay_later" value="Pay Later" required>
                  <span>Pay later</span>
                </label>
              </div>
            </div>

            <!-- wire transfer -->
            <div class="slp-pay-panel" id="wire_transfer_div">
              <div class="slp-grid slp-grid--2">
                <div class="slp-field">
                  <label class="slp-label" for="routing_number">Routing number <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="text" name="routing_number" id="routing_number" placeholder="Enter routing number">
                </div>
                <div class="slp-field">
                  <label class="slp-label" for="account_number">Account number <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="text" name="account_number" id="account_number" placeholder="Enter account number">
                </div>
                <div class="slp-field">
                  <label class="slp-label" for="amount">Amount <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="number" name="amount" id="amount"
                         placeholder="Enter amount" value="{{ $grandTotal > 0 ? (int) $grandTotal : '' }}">
                </div>
              </div>
            </div>

            <!-- check -->
            <div class="slp-pay-panel" id="check_div" style="display: none;">
              <div class="slp-grid slp-grid--2">
                <div class="slp-field">
                  <label class="slp-label" for="check_number">Check number <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="text" name="check_number" id="check_number" placeholder="Enter check number">
                </div>
                <div class="slp-field">
                  <label class="slp-label" for="date_of_check">Date of check <span class="slp-req">*</span></label>
                  <input class="form-control slp-input" type="date" name="date_of_check" id="date_of_check">
                </div>
              </div>
            </div>

            <!-- zelle -->
            <div class="slp-pay-panel slp-pay-panel--zelle" id="zelle_div" style="display: none;">
              <div class="slp-pay-head">
                <h4><i class="fas fa-mobile-alt" aria-hidden="true"></i> Pay by Zelle</h4>
                <img src="{{ asset('assets/images2/zelle-logo.svg') }}" alt="Zelle">
              </div>
              <div class="slp-pay-lines">
                @if(!empty($zelleName))<p><b>Recipient name:</b> {{ $zelleName }}</p>@endif
                @if(!empty($zellePhone))<p><b>Zelle phone number:</b> {{ $zellePhone }}</p>@endif
                @if(!empty($zelleEmail))<p><b>Zelle email:</b> {{ $zelleEmail }}</p>@endif
              </div>
              <p class="slp-callout">
                <b>Send $1 first.</b> Once we confirm it arrived, transfer the full or balance amount to the same number.
              </p>
              @if(!empty($zelleNote))<p class="slp-callout">{!! nl2br(e($zelleNote)) !!}</p>@endif
            </div>

            <!-- pay later -->
            <div class="slp-pay-panel" id="note" style="display: none;">
              <p class="slp-callout slp-callout--warn">
                <b>Pay within one month of this yatra.</b> Bookings that are not paid by then are cancelled.
              </p>
            </div>
          </section>

          <!-- ============ Confirm ============ -->
          <section class="slp-applicant">
            <label class="slp-consent">
              <input type="checkbox" name="terms" value="agree" required>
              <span>To the best of my knowledge and belief the information given in this application is correct.</span>
            </label>

            <label class="slp-consent">
              <input type="checkbox" name="terms" value="agree" required>
              <span>I agree to the <a href="#" data-toggle="modal" data-target="#exampleModal">terms &amp; conditions</a>.</span>
            </label>

            <p class="slp-callout">
              <b>Note:</b> your application is submitted once the payment process is completed.
            </p>

            <div class="slp-submit-row">
              <button class="slp-btn slp-btn-primary" id="submit_btn" type="submit">
                Submit application
                <i class="fas fa-arrow-right" aria-hidden="true"></i>
              </button>
              <p class="slp-section-note">Questions before you send this? Call +1 (718) 908-9464.</p>
            </div>
          </section>
        </form>
      </div>
    </div>
  </div>

  <!-- terms modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Terms &amp; Conditions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h3>What you can do</h3>
          <p>You can travel one way to Pakistan and go on to India (pay $600 less than the package price). If you carry two suitcases you pay an additional $35 luggage handling.</p>
          <p>You can go to India and use our land package to join the group. We can receive you at the Wagah Border, Lahore.</p>
          <h3>What you cannot do</h3>
          <ul>
            <li>You cannot change your assigned seat during the trip.</li>
            <li>You cannot exchange phone numbers with local people or government officials.</li>
            <li>No alcohol is allowed.</li>
            <li>You cannot go anywhere without prior permission of the group leader.</li>
          </ul>
          <p>You are responsible for all expenses of a private tour if the special police grant permission through the group leader.</p>
          <p>The price is guaranteed if the booking is made 3 months in advance and paid in full. Within 2 months of departure a different package price applies.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
  $(document).ready(function () {

    // Which payment fields are required depends on the chosen method.
    $(document).on("click", ".payment_type", function () {
      var type = $(this).val();
      var isWire  = (type === "Bank Wire Transfer");
      var isCheck = (type === "Check");

      $("#routing_number, #account_number, #amount").attr("required", isWire);
      $("#check_number, #date_of_check").attr("required", isCheck);

      $("#wire_transfer_div").toggle(isWire);
      $("#check_div").toggle(isCheck);
      $("#zelle_div").toggle(type === "Zelle");
      $("#note").toggle(type === "Pay Later");
    });

    // US phone formatting: 123-456-7890
    $('.phone_us').on('input', function () {
      var text = $(this).val().replace(/\D/g, '');
      if (text.length > 3) text = text.replace(/.{3}/, '$&-');
      if (text.length > 7) text = text.replace(/.{7}/, '$&-');
      $(this).val(text);
    });

    // Indian passport holders also give residence and green-card details.
    $(document).on('change', '.passport_country', function () {
      // Scoped to this traveller — the old handler toggled every applicant at once.
      var applicant = $(this).closest('.slp-applicant');
      applicant.find('.green_card_area').toggle($(this).val() === "India");
    });

    // Send the reader to the first field that failed, not the top of the page.
    $('#slpApplyForm').on('submit', function (e) {
      var firstInvalid = this.querySelector(':invalid');
      if (firstInvalid) {
        e.preventDefault();
        var card = firstInvalid.closest('.slp-applicant');
        if (card) card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        else firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        if (typeof toastr !== 'undefined') {
          toastr['error']("Please complete the highlighted field.", "Something is missing");
        }
      }
    });
  });
</script>

@endsection
