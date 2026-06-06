<div style="height: 100%; display: table; margin:auto; background-color: #d5d5d5">
  <table style="width: 700px; min-width: 700px; max-width: 700px;" border="0" cellspacing="0" cellpadding="0">
    <thead style="background-color: #c97c64">
      <tr>
        <td style="text-align: left; padding: 20px;">
          <img src="{{ asset('assets/images2/newwhitelogo.png') }}" style="height: 70px;">
        </td>
        <td style="text-align: right; color:#000000; font-family: Halvetica, sans-serif; padding: 20px;">
          <h2 style="font-size:14px;margin:0px;">Konnect Yatra</h2>
          <div style="font-size: 12px;">New York</div>
          <div style="font-size: 12px;">(24/7 Support Line)</div>
          <div style="font-size: 12px;">
            <a href="mailto:konnectus.inc@gmail.com" style="color:#000000; text-decoration:none">konnectus.inc@gmail.com</a>
          </div>
        </td>
      </tr>
    </thead>
    <tbody style="background-color: #ffffff;">
      <tr>
        <td style="padding: 20px">
          <div style="margin-top: 20px;"></div>
          <div style="border-left: solid 6px #c97c64; font-size:14px; color:rgb(23,58,60); font-family: Halvetica, sans-serif; padding-left: 10px;">
            <div style="font-size: 14px;">Hello, Admin</div>
            <h2 style="font-size: 18px;font-weight:normal;margin:0px;">Following user contact us through our website.</h2>
            <div>
              <p style="font-size: 14px; color:rgb(23,58,60); text-decoration:none">Below are the details of the user</p>
            </div>
          </div>
        </td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <div style="width: 700px; min-width: 700px; max-width: 700px; display: block; margin: auto; background-color: #ffffff; padding-top: 30px; font-family: Halvetica, sans-serif; color:rgb(23,58,60);">
    <table align="center" style="width: 650px;" border="0" cellpadding="0" cellspacing="0">
      <thead>
        <tr style="font-size: 14px;">
          <td style="padding: 15px; background-color: rgb(237,222,201); text-align: center; font-size: 16px; border-bottom: 2px solid #ffffff;">NAME</td>
          <td style="padding: 15px; background-color: rgb(247,240,231); text-align: center; border-bottom: 2px solid #ffffff;">EMAIL</td>
          <td style="padding: 15px; background-color: rgb(237,222,201); text-align: center; border-bottom: 2px solid #ffffff;">PHONE</td>
          <td style="padding: 15px; background-color: rgb(247,240,231); text-align: center; border-bottom: 2px solid #ffffff;">SUBJECT</td>
          <td style="padding: 15px; background-color: rgb(237,222,201); text-align: center; border-bottom: 2px solid #ffffff;">MESSAGE</td>
        </tr>
      </thead>
      <tbody>
        <tr style="font-size: 14px;">
          <td style="padding: 15px; background-color: rgb(237,222,201); text-align: center; font-size: 16px;">{{ $data['name'] }}</td>
          <td style="padding: 15px; background-color: rgb(240,231,217); text-align: center;">{{ $data['email'] }}</td>
          <td style="padding: 15px; background-color: rgb(237,222,201); text-align: center;">{{ $data['phone'] }}</td>
          <td style="padding: 15px; background-color: rgb(240,231,217); text-align: center;">{{ $data['subject'] }}</td>
          <td style="padding: 15px; background-color: rgb(237,222,201); text-align: center;">{{ $data['message'] }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <table style="width: 700px; min-width: 700px; max-width: 700px;" border="0" cellspacing="0" cellpadding="0">
    <tbody style="background-color: #ffffff;">
      <tr>
        <td style="padding: 20px;">
          <div style="margin-top: 20px;"></div>
          <div style="border-left: solid 6px #c97c64; font-size:14px; color:rgb(23,58,60); font-family: Halvetica, sans-serif; padding-left: 10px;">
            <div>To check complete details. <a href="{{ url('/admin_login') }}" target="_blank">Click Here!</a></div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>