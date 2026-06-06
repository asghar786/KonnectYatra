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
        var clas = document.getElementById('class').value;

        if (notes == "") {
            document.getElementById("error10").innerHTML = "Please enter notes";
            valid = false;
        }
        if (dln == "") {
            document.getElementById("error11").innerHTML = "Please enter license number";
            valid = false;
        }
        if (clas == "") {
            document.getElementById("error12").innerHTML = "Please enter class date";
            valid = false;
        }
    }

    if (currentTab == 2) {
        var issuedate = document.getElementById('issuedate').value;
        var cc = document.getElementById('ccdate').value;
        // var sc = document.getElementById('scdate').value;
        var file = document.getElementById('file').value;
        if (issuedate == "") {
            document.getElementById("error13").innerHTML = "Please enter issue date";
            valid = false;
        }
        if (cc == "") {
            document.getElementById("error14").innerHTML = "Fill this first";
            valid = false;
        }
        // if (sc == "") {
        //     document.getElementById("error15").innerHTML = "Fill this first";
        //     valid = false;
        // }
        if (file == "") {
            document.getElementById("error16").innerHTML = "Upload File";
            valid = false;
        }
    }


    if (valid) {
        document.getElementById("error").innerHTML = "";
        document.getElementById("error2").innerHTML = "";
        document.getElementById("error3").innerHTML = "";
        document.getElementById("error4").innerHTML = "";
        
        document.getElementById("error6").innerHTML = "";
        document.getElementById("error7").innerHTML = "";
        document.getElementById("error8").innerHTML = "";
        document.getElementById("error9").innerHTML = "";
        document.getElementById("error10").innerHTML = "";
        document.getElementById("error11").innerHTML = "";
        document.getElementById("error12").innerHTML = "";
        document.getElementById("error13").innerHTML = "";
        document.getElementById("error14").innerHTML = "";
        // document.getElementById("error15").innerHTML = "";
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

function myissuedate() {
    dateissue = document.getElementById("issuedate").value;
    var date = new Date(dateissue);
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + 1095);
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var expiredate = y + '-' + mm + '-' + dd;
    if (!expiredate == "") {
        document.getElementById('ccdate').value = expiredate;
    }


}

var tele = document.querySelector('#phonenumber');
tele.addEventListener('keyup', function(e){
  if (event.key != 'Backspace' && (tele.value.length === 3 || tele.value.length === 7)){
  tele.value += '-';
  }
});

