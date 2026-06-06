var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
    // This function will display the specified tab of the form ...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    // ... and run a function that displays the correct step indicator:
    fixStepIndicator(n)
}

function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= x.length) {
        //...the form gets submitted:
        document.getElementById("regForm").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}

function validateForm() {
    // This function deals with validation of the form fields
    var valid = true;
    if (currentTab == 0) {

        var fname = document.getElementById('fname').value;
        var lname = document.getElementById('lname').value;
        var city = document.getElementById('city').value;
        var address1 = document.getElementById('address1').value;
        // var address2 = document.getElementById('address2').value;
        var phone = document.getElementById('phonenumber').value;
        var zipcode = document.getElementById('zipcode').value;
        var dob = document.getElementById('dob').value;
        var state = document.getElementById('state').value;
        if (fname == "") {
            document.getElementById("error").innerHTML = "Please enter first name";
            valid = false;
        }
        if (lname == "") {
            document.getElementById("error2").innerHTML = "Please enter last name";
            valid = false;
        }
        if (city == "") {
            document.getElementById("error3").innerHTML = "Please enter city";
            valid = false;
        }
        if (address1 == "") {
            document.getElementById("error4").innerHTML = "Please enter address";
            valid = false;
        }
        // if (address2 == "") {
        //     document.getElementById("error5").innerHTML = "Please enter apartment";
        //     valid = false;
        // }
        if (phone == "") {
            document.getElementById("error6").innerHTML = "Please enter phone";
            valid = false;
        }
        if (zipcode == "") {
            document.getElementById("error7").innerHTML = "Please enter zipcode";
            valid = false;
        }
        if (dob == "") {
            document.getElementById("error8").innerHTML = "Please enter date of birth";
            valid = false;
        }
        if (state == "") {
            document.getElementById("error9").innerHTML = "Please enter state";
            valid = false;
        }
    }

    if (currentTab == 1) {
        var notes = document.getElementById('notes').value;
        var dln = document.getElementById('dln').value;
        var doi = document.getElementById('pdoi').value;
        var doe = document.getElementById('pdoe').value;

        if (notes == "") {
            document.getElementById("error10").innerHTML = "Please enter notes";
            valid = false;
        }
        if (dln == "") {
            document.getElementById("error11").innerHTML = "Please enter passport number";
            valid = false;
        }
        if (doi == "") {
            document.getElementById("error12").innerHTML = "Please enter date of issue";
            valid = false;
        }
        if (doe == "") {
            document.getElementById("error121").innerHTML = "Please enter date of expiry";
            valid = false;
        }
    }

    if (currentTab == 2) {
        var issuedate = document.getElementById('dissuedate').value;
        var nic = document.getElementById('nicnum').value;
        var nicop = document.getElementById('nicopnum').value;
        if (issuedate == "") {
            document.getElementById("error13").innerHTML = "Please enter date of issue ";
            valid = false;
        }
        if (nic == "") {
            document.getElementById("error14").innerHTML = "Please enter NIC number";
            valid = false;
        }
        if (nicop == "") {
            document.getElementById("error15").innerHTML = "Please enter NICOP number";
            valid = false;
        }
    }


    if (valid) {
        document.getElementById("error").innerHTML = "";
        document.getElementById("error2").innerHTML = "";
        document.getElementById("error3").innerHTML = "";
        document.getElementById("error4").innerHTML = "";
        // document.getElementById("error5").innerHTML = "";
        document.getElementById("error6").innerHTML = "";
        document.getElementById("error7").innerHTML = "";
        document.getElementById("error8").innerHTML = "";
        document.getElementById("error9").innerHTML = "";
        document.getElementById("error10").innerHTML = "";
        document.getElementById("error11").innerHTML = "";
        document.getElementById("error12").innerHTML = "";
        document.getElementById("error13").innerHTML = "";
        document.getElementById("error14").innerHTML = "";
        document.getElementById("error15").innerHTML = "";
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class to the current step:
    x[n].className += " active";
}


