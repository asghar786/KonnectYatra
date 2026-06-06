@extends('layouts.app')
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
  .pkg-checkbox {
    border: 1px solid #000;
    border-radius: 10px;
    padding: 10px 50px;
    cursor: pointer;
  }
  .pkg-checkbox.active {
    background-color: #101f46;
    color: #fff;
  }
  .pkg-type {
    border-bottom: 1px solid #000;
    width: 100%;
    margin-bottom: 5px;
    padding-bottom: 5px;
    font-size: 18px;
  }
  .pkg-checkbox.active .pkg-type {
    border-bottom: 1px solid #fff;
  }
  .pkg-days {
    border: 1px solid #000;
    border-radius: 10px;
    padding: 30px;
    cursor: pointer;
  }
  .pkg-days.disabled {
    background-color: #3d5d7c;
    color: #fff;
    cursor: default;
  }
  .days {
    border-bottom: 1px solid #000;
    width: 100%;
    margin-bottom: 20px;
    padding-bottom: 15px;
    font-size: 20px;
  }
  .pkg-days.disabled .days, .pkg-days-checkbox.active .days {
    border-bottom: 1px solid #fff;
  }
  .add-days-section {
      display: none;
  }
  .pkg-days-checkbox.active {
    background-color: #101f46;
    color: #fff;
  }
  .bootstrap-select {
      display: none;
  }
</style>

<!-- Content -->
<div class="page-content bg-white">
  <!-- inner page banner -->

  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container" style="background-image: url({{asset('assets/images2/Inner-banner-01.png')}});background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
          <h1 class="inner-title" style="font-size:65px !important;">SPECIAL LAND PACKAGE</h1>
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
          <h2 class="my-4 text-center" style="font-size: 35px !important;">Holy Journey to Nankana Sahib</h2>
          <h5 class="mb-4 text-center text-danger">INCLUDES VISA AND FULL SECURITY</h5>
          <form method="POST" action="{{ url('/save-initial-info') }}" class="row g-3 form">
            @csrf
            <div class="col-lg-12 mt-4">
                <b>Number of Persons</b>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-center my-3">
                <select class="form-control" name="total_persons" id="total_persons">
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>
            <div class="col-lg-12 my-5 text-center">
                <hr>
            </div>
            <div class="col-lg-12 mt-4">
                <b>Select Package Type</b>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 text-center my-3">
                <div class="pkg-checkbox active" data-price="750">
                    <p class="pkg-type" style="font-size: 20px;"><b>4 Star Land Package</b></p>
                    <p style="margin-bottom: 0px; font-size: 14px;">6 Days starting from <b>$750</b></p>
                    <input type="radio" name="package_type" class="package_type" value="4 Star Package" style="display: none;" checked />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 text-center my-3">
                <div class="pkg-checkbox" data-price="950">
                    <p class="pkg-type" style="font-size: 20px;"><b>5 Star Land Package</b></p>
                    <p style="margin-bottom: 0px; font-size: 14px;">6 Days starting from <b>$950</b></p>
                    <input type="radio" name="package_type" class="package_type" value="5 Star Package" style="display: none;" />
                </div>
            </div>
            <div class="col-lg-12 my-5 text-center">
                <hr>
            </div>
            <div class="col-lg-12">
                <b>Basic Package Days</b>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3">
                <div class="pkg-days disabled">
                    <p class="days"><b>Day 1</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Pickup from Wagah Border.</li>
                            <li>Travel to Islamabad.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3">
                <div class="pkg-days disabled">
                    <p class="days"><b>Day 2</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Departure from Islamabad to Panja Sahib.</li>
                            <li>Travel to Lahore.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3">
                <div class="pkg-days disabled">
                    <p class="days"><b>Day 3</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Travel from Lahore to Nankana Sahib.</li>
                            <li>Travel back to Lahore.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3">
                <div class="pkg-days disabled">
                    <p class="days"><b>Day 4</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Visit Gurdwara Sahib 6ien Patshahi Temple Road, Lahore.</li>
                            <li>Visit Gurdwara Sahib Singh Singhnia.</li>
                            <li>Visit Gurdwara Sahib Guru Ram Das Ji.</li>
                            <li>Visit Gurdwara Dera Sahib.</li>
                            <li>Visit Qila Mahraja Ranjit Singh.</li>
                            <li>Shopping in Lahore.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3">
                <div class="pkg-days disabled">
                    <p class="days"><b>Day 5</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Travel from Lahore to Kartarpur Sahib.</li>
                            <li>Travel back to Lahore.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3">
                <div class="pkg-days disabled">
                    <p class="days"><b>Day 6</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Visit Darbar Saien Mian Mir Sahib.</li>
                            <li>Visit Gurdwara Sahib Bebe Nanki ji.</li>
                            <li>Departure to Wagah Border.</li>
                        </ul>
                        <p style="margin-top: 10px;"><b>Note:</b> If you are staying more than 6 days, this program will be shifted on 10th Day of your stay and on 6th Day you will have Lahore Tour and Shoping.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 my-5 text-center">
                <button type="button" class="button-primary" id="add_days" style="background-color: #36ab65;">+ Add more days</button>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3 add-days-section">
                <div class="pkg-days pkg-days-checkbox">
                    <p class="days"><b>Day 7</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Travel from Lahore to Rohri Sahib, Eminabad.</li>
                            <li>Visit Birthplace of Maharaja Ranjit Singh, Gujranwala.</li>
                            <li>Travel back to Lahore.</li>
                        </ul>
                    </div>
                    <input type="checkbox" name="days[]" class="added_days" value="Day 7" style="display: none;" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3 add-days-section">
                <div class="pkg-days pkg-days-checkbox">
                    <p class="days"><b>Day 8</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Travel from Lahore to Sacha Sauda Sahib.</li>
                            <li>Travel from Sacha Sauda Sahib to Nankana Sahib (Al-widai Tour).</li>
                            <li>Travel back to Lahore.</li>
                        </ul>
                    </div>
                    <input type="checkbox" name="days[]" class="added_days" value="Day 8" style="display: none;" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3 add-days-section">
                <div class="pkg-days pkg-days-checkbox">
                    <p class="days"><b>Day 9</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Visit Gurdwara Bair Sahib also known as Gurdwara Babe Di Ber Sahib, Sialkot.</li>
                            <li>Visit Gurdwara Baoli Sahib, Sialkot.</li>
                            <li>Shopping in Lahore.</li>
                        </ul>
                    </div>
                    <input type="checkbox" name="days[]" class="added_days" value="Day 9" style="display: none;" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 text-center my-3 add-days-section">
                <div class="pkg-days pkg-days-checkbox">
                    <p class="days"><b>Day 10</b></p>
                    <div class="text-left">
                        <ul style="margin: 0px; padding-left: 25px;">
                            <li>Visit Darbar Saien Mian Mir Sahib.</li>
                            <li>Visit Gurdwara Sahib Bebe Nanki ji.</li>
                            <li>Departure to Wagah Border.</li>
                        </ul>
                    </div>
                    <input type="checkbox" name="days[]" class="added_days" value="Day 10" style="display: none;" />
                </div>
            </div>
            <div class="col-lg-12 my-5 text-center">
                <hr>
            </div>
            <div class="offset-lg-8 col-lg-4">
                <div class="d-flex justify-content-between">
                    <p class="mb-2">Total Days</p>
                    <p class="mb-2" id="days">6</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-0">Total Nights</p>
                    <p class="mb-0" id="nights">5</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="mb-0" style="font-size: 18px;"><b>Total Price</b></p>
                    <input type="hidden" name="total_price" id="total_price" value="750" />
                    <p class="mb-0" id="price" style="font-size: 18px; font-weight: bold;">$750</p>
                </div>
                <hr>
            </div>
            <div class="col-lg-12 mt-5 text-right">
                <a href="javascript:void()" id="save-data" class="button-primary" previewlistener="true">Proceed Next</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- inner page banner END -->
  </div>
  <!-- Content END-->
  <style>
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
    $(document).ready(function() {
        $(document).on("click", "#save-data", function() {
            $(".form").submit();
        });
        
      // Attach click event listener to each checkbox
      $("#package_1, #package_2, #package_3").click(function() {
        // If a checkbox is checked, enable the other two
        if ($(this).is(":checked")) {
          $("#package_1, #package_2, #package_3").not(this).prop("disabled", true);
        }
        // If a checkbox is unchecked, enable the other two
        else {
          $("#package_1, #package_2, #package_3").prop("disabled", false);
        }
      });
        $(document).on("click", ".pkg-checkbox", function() {
            $(".pkg-checkbox").removeClass("active");
            $(".pkg-checkbox input").attr("checked", false);
            $(this).addClass("active");
            $(this).find("input").attr("checked", true);
            var total_persons = $("#total_persons").find("option:selected").val();
            $("#price").text("$" + ($(this).data("price") * total_persons));
            $("#total_price").val($(this).data("price") * total_persons);
            
            var type = $(this).find("input").val();
            var price = 950;
            var added_price = 150;
            if(type == "4 Star Package") {
                price = 750;
                added_price = 125;
            }
            var count = $(".added_days:checked").length;
            if(count > 0) {
                $("#price").text("$" + ((price + (added_price * count)) * total_persons));
                $("#total_price").val((price + (added_price * count)) * total_persons);
            }
        });
        $(document).on("click", ".pkg-days-checkbox", function() {
            if($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this).find("input").attr("checked", false);
            } else {
                $(this).addClass("active");
                $(this).find("input").attr("checked", true);
            }
            
            var type = $(".package_type:checked").val();
            var total_persons = $("#total_persons").find("option:selected").val();
            var price = 950;
            var added_price = 150;
            if(type == "4 Star Package") {
                price = 750;
                added_price = 125;
            }
            var count = $(".added_days:checked").length;
            if(count > 0) {
                $("#price").text("$" + ((price + added_price * count) * total_persons));
                $("#total_price").val((price + added_price * count) * total_persons);
            } else {
                $("#price").text("$" + (price * total_persons));
                $("#total_price").val(price * total_persons);
            }
            $("#days").text(6 + count);
            $("#nights").text(5 + count);
        });
        $(document).on("change", "#total_persons", function() {
            var type = $(".package_type:checked").val();
            var total_persons = $(this).find("option:selected").val();
            var price = 950;
            var added_price = 150;
            if(type == "4 Star Package") {
                price = 750;
                added_price = 125;
            }
            var count = $(".added_days:checked").length;
            if(count > 0) {
                $("#price").text("$" + ((price + added_price * count) * total_persons));
                $("#total_price").val((price + added_price * count) * total_persons);
            } else {
                $("#price").text("$" + (price * total_persons));
                $("#total_price").val(price * total_persons);
            }
        });
        $(document).on("click", "#add_days", function() {
            $(".add-days-section").fadeIn();
        });
    });
  </script>
  <script>
    // Add event listeners to all the package checkboxes
    $("input[type='checkbox']").change(function() {
      var checked = $(this).is(":checked");
      var container = $(this).closest(".col-lg-4");
      container.find("input[type='radio']").prop("disabled", !checked);
      container.find("input[type='radio']").prop("required", true);
    });
  </script>
  <script>
    $(document).ready(function() {
      // Attach click event listener to radio buttons
      $('input[name="first_visit"]').on('click', function() {
        // If yes is selected, show the div
        if ($(this).val() === 'yes') {
          $('#previous-visit').prop('required', false);
          $('#entry-port').prop('required', false);
          $('#first-visit').hide();
        }
        // If no is selected, hide the div
        else {
          $('#previous-visit').prop('required', true);
          $('#entry-port').prop('required', true);
          $('#first-visit').show();
        }
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Attach click event listener to radio buttons
      $('input[name="us_passport"]').on('click', function() {
        // If yes is selected, show the div
        if ($(this).val() === 'yes') {
          $('#green-card').prop('required', true);
        }
        // If no is selected, hide the div
        else {
          $('#green-card').prop('required', false);
        }
      });
    });
  </script>
  @endsection
