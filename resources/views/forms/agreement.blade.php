@extends('layouts.app')
@section('content')

<style type="text/css">
  .btn-slider{
    background-color: white;
  }
  .btn-slider:hover{
    background-color: black !important;
  }
  ul , ol{
    margin-left: -22px !important;
  }
  input[type=text], input[type=email], input[type=url], input[type=password], input[type=string], input[type=search], input[type=number], input[type=tel], input[type=range], input[type=date], input[type=month], input[type=week], input[type=time], input[type=datetime], input[type=datetime-local], input[type=file], input[type=color] {
    height: 20px !important;
  }
</style>

<!-- Content -->
<div class="page-content bg-white">
  <section class="inner-banner-wrap pb-0">
    <div class="inner-baner-container" style="background-image: url({{asset('assets/images2/Inner-banner-01.png')}});background-position: center !important;">
      <div class="container">
        <div class="inner-banner-content">
          <h1 class="inner-title" style="font-size:65px !important;">AGREEMENT</h1>
        </div>
      </div>
    </div>
  </section>
  <!-- inner page banner -->
  <form action="{{ url("all-packages/".$id)}}" accept-charset="utf-8">

    <div class="page-banner contact-page section-sp2">
      <div class="container p-5">
        <div class="row py-3">
          <div class="col-4">
            <h3 class="text-center">Wahe Guru Ji ka Khalsa</h3>
          </div>
          <div class="col-4">
            <h4 class="text-center mt-2">(First Come First Serve)</h4>
          </div>
          <div class="col-4">
            <h3 class="text-center">Wahe Guru Ji ki Fateh</h3>
          </div>
          <div class="col-12 my-3 w-100">
            <div class="accordion w-100">
              <div class="card px-5 py-4">
                <h1 style="text-align: center;">Travel Agreement</h1>
                <p class="mt-3">
                  The responsibility of Konnect .us, Inc., as the religious tour operator Konnect yatra, 185-02 Hillside Avenue, Jamaica, NY 11432, USA., acts only an a religious tour operator for the passengers in the capacity of arranging Pilgrim Visa, Airline Ticket, Hotels in Pakistan, Transportation, Visit of sacred Gurdwaras in Punjab, Pakistan and any other services in connection with this arrangement and assumes no liability whatsoever for injury, damage, loss, accident, delay or irregularity which may be due to any defect, through the acts of defaults or any company or person engaged in covering passengers in carrying out the arrangements of the tour, or as a direct or indirect act of result of God, danger incident in the air, fire, breakdown in the machinery or equipment, acts of government or other authorities or defectors, wars, whether declared or not, hostilities, civil disturbance, strikes, riots, pilferage, epidemic quarantines, medical or custom's regulation, or from any causes beyond Konnect Yatra, control or from any loss of luggage or damage resulting from improper passports,  or other documents.
                </p>
                <p>
                  KY, will accept no responsibility for loss or additional expenses due to delay or any changes in the schedule or other causes, KY, shall not be liable or responsible for any inconveniences, delay due to heavy traffic, loss damage or injury arising in connection with such services. KY, will not be responsible for the failure to follow instructions, including check-in event of delay, it is the responsibility of the airline to determine exactly what procedure should be adopted, KY and its affiliates will not be responsible for any persons(s) missing any part of the program due to his/her negligence or delay or absenteeism for any time during the tour and will not be responsible for any additional expenses of the participant to rejoin the tour. Moreover, no changes in the schedule or change of hotel room, bus seat, aero plane seat or upgrade in the program chosen will be honored after departure as well as no refund will be given for any services rendered not utilized. No smoking No alcohol in the hotel premises or in the entire Holy Trip. These are company's policies.
                </p>
                <div class="d-flex justify-content-between mt-5">
                  <div>
                    <label class=" font-weight-bold">Name of Yatri:</label>
                    <input type="text" id="name" required style="border: 0px; border-bottom: 1px solid black !important; text-align: center;">
                  </div>
                  <div>
                    <div>
                      <div class="d-flex flex-column">
                        <input type="text" id="signature" required style="border: 0px; border-bottom: 1px solid black !important; text-align: center; font-family: 'FontAwesome';">
                        <label class="text-center mt-1 font-weight-bold">Signature of applicant</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-wrap d-flex justify-content-center ">
      <button type="submit" class="button-text  width-6 btn-slider mt-0"style="padding: 13px 50px !important;">Proceed</button>
    </div>
  </div>
  
</form>
@endsection

@section('script')
  
  <script type="text/javascript">
    $(document).on("keyup", "#name", function () {
      $("#signature").val($(this).val());
    });
  </script>

@endsection