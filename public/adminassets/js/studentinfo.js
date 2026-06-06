$(document).ready(function(){
  
    $('#fname').attr("disabled","disabled");
    $('#mname').attr("disabled","disabled");
    $('#lname').attr("disabled","disabled");
    $('#city').attr("disabled","disabled");
    $('#address1').attr("disabled","disabled");
    $('#address2').attr("disabled","disabled");
    $('#email').attr("disabled","disabled");
    $('#phonenumber').attr("disabled","disabled");
    $('#zipcode').attr("disabled","disabled");
    $('#dob').attr("disabled","disabled");
    $('#state').attr("disabled","disabled");
    $('#gender').attr("disabled","disabled");
    $('#notes').attr("disabled","disabled");
    $('#dln').attr("disabled","disabled");
    $('#class').attr("disabled","disabled");
    $('#check').attr("disabled","disabled");
    $('#issuedate').attr("disabled","disabled");
    $('#ccd').attr("disabled","disabled");
    $('#sd').attr("disabled","disabled");

    $('#submit').hide();

$('.edit').click(function(){
   
    document.getElementById('fname').disabled=false;
    document.getElementById('mname').disabled=false;
    document.getElementById('lname').disabled=false;
    document.getElementById('city').disabled=false;
    document.getElementById('address1').disabled=false;
    document.getElementById('address2').disabled=false;
    document.getElementById('email').disabled=false;
    document.getElementById('phonenumber').disabled=false;
    document.getElementById('zipcode').disabled=false;
    document.getElementById('dob').disabled=false;
    document.getElementById('state').disabled=false;
    document.getElementById('gender').disabled=false;
    document.getElementById('notes').disabled=false;
    document.getElementById('dln').disabled=false;
    document.getElementById('class').disabled=false;
    document.getElementById('check').disabled=false;
    document.getElementById('issuedate').disabled=false;
    document.getElementById('ccd').disabled=false;
    document.getElementById('sd').disabled=false;
    $('#submit').show();
    
   
});
$('#submit').click(function(){
    // $('#fname').attr("disabled","disabled");
    // $('#mname').attr("disabled","disabled");
    // $('#lname').attr("disabled","disabled");
    // $('#city').attr("disabled","disabled");
    // $('#address1').attr("disabled","disabled");
    // $('#address2').attr("disabled","disabled");
    // $('#email').attr("disabled","disabled");
    // $('#phonenumber').attr("disabled","disabled");
    // $('#zipcode').attr("disabled","disabled");
    // $('#dob').attr("disabled","disabled");
    // $('#state').attr("disabled","disabled");
    // $('#gender').attr("disabled","disabled");
    // $('#notes').attr("disabled","disabled");
    // $('#dln').attr("disabled","disabled");
    // $('#class').attr("disabled","disabled");
    // $('#check').attr("disabled","disabled");
    // $('#issuedate').attr("disabled","disabled");
    // $('#ccd').attr("disabled","disabled");
    // $('#sd').attr("disabled","disabled");

    $('#submit').hide();
});

});