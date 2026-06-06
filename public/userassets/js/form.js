function Sponserd(sponsercheck) {
    var check = document.getElementById("check");
    check.style.display = sponsercheck.checked ? "block" : "none";
}


function Sponserdthird(sponserthirdcheck) {
    var checkthird = document.getElementById("checkthird");
    checkthird.style.display = sponserthirdcheck.checked ? "block" : "none";
}


function Sponserdadd(sponseraddcheck) {
    var checkthird = document.getElementById("checkadd");
    checkadd.style.display = sponseraddcheck.checked ? "block" : "none";
}

function Sponserdtravel(sponsertravelcheck) {
    var checktravel = document.getElementById("checktravel");
    checktravel.style.display = sponsertravelcheck.checked ? "block" : "none";
}

function Sponserdbank(sponserbankcheck) {
    var checkbank = document.getElementById("checkbank");
    checkbank.style.display = sponserbankcheck.checked ? "block" : "none";
}

function Sponserdhistory(sponserhistorycheck) {
    var checkhistory = document.getElementById("checkhistory");
    checkhistory.style.display = sponserhistorycheck.checked ? "block" : "none";
}

function Sponserdrefuse(sponserrefusecheck) {
    var checkrefuse = document.getElementById("checkrefuse");
    checkrefuse.style.display = sponserrefusecheck.checked ? "block" : "none";
}

function Sponserddeported(sponserdeportedcheck) {
    var checkdeported = document.getElementById("checkdeported");
    checkdeported.style.display = sponserdeportedcheck.checked ? "block" : "none";
}

function Sponserdcriminal(sponsercriminalcheck) {
    var checkcriminal = document.getElementById("checkcriminal");
    checkcriminal.style.display = sponsercriminalcheck.checked ? "block" : "none";
}


function showform2() {
    var visa_type = document.forms["visaform"]["visa_type"];
    var v_purpose = document.getElementById("vp").value;
    var duration = document.getElementById("dos").value;
    var visa_require = document.forms["visaform"]["visa_require"];
    var visa_entry = document.forms["visaform"]["visa_entry"];
    var p_entry = document.getElementById("poe").value;
    var p_departure = document.getElementById("pod").value;
    var p1 = document.getElementById("p1").value;
    var p2 = document.getElementById("p2").value;
    var p3 = document.getElementById("p3").value;
    var p4 = document.getElementById("p4").value;
    if (visa_type[0].checked == false && visa_type[1].checked == false && visa_type[2].checked == false && visa_type[3].checked == false && visa_type[4].checked == false && visa_type[5].checked == false && visa_type[6].checked == false && visa_type[7].checked == false && visa_type[8].checked == false) {
        document.getElementById("visatypeError").innerHTML = "**Please Select Your Visa Type <br>";
        return false;
    }
    if (v_purpose == "") {
        document.getElementById("visitpurposeError").innerHTML = " **Please Enter Visit Purpose <br>";
        return false;
    }
    if (duration == "") {
        document.getElementById("durationError").innerHTML = "**Please Enter Duration <br>";
        return false;
    }
    if (visa_require[0].checked == false && visa_require[1].checked == false && visa_require[2].checked == false && visa_require[3].checked == false && visa_require[4].checked == false) {
        document.getElementById("visarequireError").innerHTML = "**Please Select Your Visa Require <br>";
        return false;
    }
    if (visa_entry[0].checked == false && visa_entry[1].checked == false && visa_entry[2].checked == false) {
        document.getElementById("visaentryError").innerHTML = "**Please Select Your Visa Entry <br>";
        return false;
    }
    if (p_entry == "") {
        document.getElementById("portentryError").innerHTML = " **Please Enter Port Entry <br>";
        return false;
    }
    if (p_departure == "") {
        document.getElementById("portdepartureError").innerHTML = " **Please Enter Departure <br>";
        return false;
    }
    if (p1 == "") {
        document.getElementById("p1Error").innerHTML = " **Enter Place To Visit <br>";
        return false;
    }
    if (p2 == "") {
        document.getElementById("p2Error").innerHTML = " **Enter Place To Visit <br>";
        return false;
    }
    if (p3 == "") {
        document.getElementById("p3Error").innerHTML = " **Enter Place To Visit <br>";
        return false;
    }
    if (p4 == "") {
        document.getElementById("p4Error").innerHTML = " **Enter Place To Visit <br>";
        return false;
    }
    document.getElementById('welcomeform2').style.display = "block";
}

function showform3() {
    var passname1 = document.getElementById("pname1").value;
    var passname3 = document.getElementById("pname3").value;
    var date = document.getElementById("date1").value;
    var sex_type = document.forms["visaform"]["sex_type"];
    var applicant_city = document.getElementById("app_city").value;
    var applicant_state = document.getElementById("app_state").value;
    var applicant_country = document.getElementById("app_country").value;
    var martial = document.forms["visaform"]["martial_status"];
    var religion = document.getElementById("religion").value;
    var native = document.getElementById("native").value;
    var present = document.getElementById("p_nationality").value;
    var previous = document.getElementById("pre_nationality").value;
    var dual = document.getElementById("duall_nationality").value;
    if (passname1 == "") {
        document.getElementById("pname1Error").innerHTML = "**Please Enter First Name <br>";
        return false;
    }
    if (passname3 == "") {
        document.getElementById("pname3Error").innerHTML = "**Please Enter Last Name <br>";
        return false;
    }
    if (date == "") {
        document.getElementById("date1Error").innerHTML = "**Please Enter Date <br>";
        return false;
    }
    if (sex_type[0].checked == false && sex_type[1].checked == false) {
        document.getElementById("sextype1Error").innerHTML = "**Please Select Your Sex <br>";
        return false;
    }
    if (applicant_city == "") {
        document.getElementById("app_cityError").innerHTML = "**Please Enter City <br>";
        return false;
    }
    if (applicant_state == "") {
        document.getElementById("app_stateError").innerHTML = "**Please Enter State <br>";
        return false;
    }
    if (applicant_country == "") {
        document.getElementById("app_countryError").innerHTML = "**Please Enter Country <br>";
        return false;
    }
    if (martial[0].checked == false && martial[1].checked == false) {
        document.getElementById("martial_statusError").innerHTML = "**Please Select Your Status <br>";
        return false;
    }
    if (religion == "") {
        document.getElementById("religionError").innerHTML = "**Please Enter Your Religion <br>";
        return false;
    }
    if (native == "") {
        document.getElementById("nativeError").innerHTML = "**Please Enter Native Language <br>";
        return false;
    }
    if (present == "") {
        document.getElementById("p_nError").innerHTML = "**Enter Present Nationality <br>";
        return false;
    }
    if (previous == "") {
        document.getElementById("pre_nError").innerHTML = "**Enter Previous Nationality <br>";
        return false;
    }
    if (dual == "") {
        document.getElementById("dual_nError").innerHTML = "**Enter Dual Nationality <br>";
        return false;
    }
    document.getElementById('welcomeform3').style.display = "block";
}

function showform4() {
    var passtype = document.forms["visaform"]["passport_type"];
    var auth = document.getElementById("iss_auth").value;
    var passnum = document.getElementById("pass_number").value;
    var place_isse = document.getElementById("pla_issu").value;
    var doi_is = document.getElementById("doi_issue").value;
    var doe_iss = document.getElementById("doe_issue").value;

    if (passtype[0].checked == false && passtype[1].checked == false && passtype[2].checked == false && passtype[3].checked == false) {
        document.getElementById("passtypeError").innerHTML = "**Please Select Your Type <br>";
        return false;
    }
    if (auth == "") {
        document.getElementById("authorityError").innerHTML = "**Please Enter Authority Name <br>";
        return false;
    }
    if (passnum == "") {
        document.getElementById("passportError").innerHTML = "**Please Enter Passport Number <br>";
        return false;
    }
    if (place_isse == "") {
        document.getElementById("placeissueError").innerHTML = "**Please Enter Place <br>";
        return false;
    }
    if (doi_is == "") {
        document.getElementById("doiError").innerHTML = "**Please Enter Date of Issue <br>";
        return false;
    }
    if (doe_iss == "") {
        document.getElementById("doeError").innerHTML = "**Please Enter Date of Expiry <br>";
        return false;
    }

    document.getElementById('welcomeform4').style.display = "block";
}

function showform5() {
    var jobdesig = document.getElementById("job_desig").value;
    var jobdepart = document.getElementById("job_depart").value;
    var jobdura = document.getElementById("job_dura").value;
    var jobduties = document.getElementById("job_duties").value;
    var jobadd = document.getElementById("job_add").value;
    var jobphone = document.getElementById("job_phone").value;
    var applyftc = document.forms["visaform"]["apply_FTC"];
    var image = document.getElementById("img").value;

    if (jobdesig == "") {
        document.getElementById("desigError").innerHTML = "**Please Enter Job Designation <br>";
        return false;
    }
    if (jobdepart == "") {
        document.getElementById("departError").innerHTML = "**Please Enter Job Department <br>";
        return false;
    }
    if (jobdura == "") {
        document.getElementById("duraError").innerHTML = "**Please Enter Job Duration <br>";
        return false;
    }
    if (jobduties == "") {
        document.getElementById("dutiesError").innerHTML = "**Please Enter Job Duty <br>";
        return false;
    }
    if (jobadd == "") {
        document.getElementById("addresError").innerHTML = "**Please Enter Job Address <br>";
        return false;
    }
    if (jobphone == "") {
        document.getElementById("phonError").innerHTML = "**Please Enter Phone Number <br>";
        return false;
    }
    if (applyftc[0].checked == false && applyftc[1].checked == false) {
        document.getElementById("appvisaError").innerHTML = "**Please Mark the check box <br>";
        return false;
    } else if (applyftc[0].checked == true && image == "") {
        document.getElementById("resid_imgError").innerHTML = "**Please Upload image <br>";
        return false;
    }
    document.getElementById('welcomeform5').style.display = "block";
}

function showform6() {
    var mothername = document.getElementById("mname").value;
    var mothernationality = document.getElementById("mnation").value;
    var fathername = document.getElementById("fname").value;
    var fathernationality = document.getElementById("fnation").value;
    var spousname = document.getElementById("spousname").value;
    var spousnationality = document.getElementById("spousnatioon").value;
    var spousdob = document.getElementById("spousdob").value;
    var spouspob = document.getElementById("spouspob").value;
    var spousprofession = document.getElementById("spousproff").value;
    var spouscontact = document.getElementById("spousnumber").value;
    var children = document.forms["visaform"]["children"];
    var travelwith = document.forms["visaform"]["travel_with"];
    var bank_account = document.forms["visaform"]["bank_account"];
    var visitedpakistan = document.forms["visaform"]["visited_pakistan"];
    var refusal = document.forms["visaform"]["refusal"];
    var refuseentry = document.forms["visaform"]["refuse_entry"];
    var deported = document.forms["visaform"]["deported"];
    var criminalcase = document.forms["visaform"]["criminal_case"];
    if (mothername == "") {
        document.getElementById("mnameError").innerHTML = "**Please Enter Mother Name <br>";
        return false;
    }
    if (mothernationality == "") {
        document.getElementById("mnationError").innerHTML = "**Please Enter Mother Nationality <br>";
        return false;
    }
    if (fathername == "") {
        document.getElementById("fnameError").innerHTML = "**Please Enter Father Name <br>";
        return false;
    }
    if (fathernationality == "") {
        document.getElementById("fnationError").innerHTML = "**Please Enter Father Nationality <br>";
        return false;
    }
    if (spousname == "") {
        document.getElementById("spousnError").innerHTML = "**Please Enter Spous Name <br>";
        return false;
    }
    if (spousnationality == "") {
        document.getElementById("spousnationError").innerHTML = "**Please Enter Spous Nationality <br>";
        return false;
    }
    if (spousdob == "") {
        document.getElementById("spousdobError").innerHTML = "**Please Enter Date of Birth <br>";
        return false;
    }
    if (spouspob == "") {
        document.getElementById("spouspobError").innerHTML = "**Please Enter Place of Birth <br>";
        return false;
    }
    if (spousprofession == "") {
        document.getElementById("spousprofError").innerHTML = "**Please Enter Spous Profession <br>";
        return false;
    }
    if (spouscontact == "") {
        document.getElementById("spousnumError").innerHTML = "**Please Enter Spous Contact <br>";
        return false;
    }
    if (children[0].checked == false && children[1].checked == false) {
        document.getElementById("childError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    if (travelwith[0].checked == false && travelwith[1].checked == false) {
        document.getElementById("membertravelError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    if (bank_account[0].checked == false && bank_account[1].checked == false) {
        document.getElementById("accountError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    if (visitedpakistan[0].checked == false && visitedpakistan[1].checked == false) {
        document.getElementById("pakdurationError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    if (refusal[0].checked == false && refusal[1].checked == false) {
        document.getElementById("refusalError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    if (refuseentry[0].checked == false && refuseentry[1].checked == false) {
        document.getElementById("arivalrefusalError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    if (deported[0].checked == false && deported[1].checked == false) {
        document.getElementById("deportError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    if (criminalcase[0].checked == false && criminalcase[1].checked == false) {
        document.getElementById("crimeError").innerHTML = "**Please Mark the check box <br>";
        return false;
    }
    document.getElementById('welcomeform6').style.display = "block";
}




$(document).ready(function() {
    // Add smooth scrolling to all links
    $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 500, function() {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
});