<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <style>
            .signature{
                font-family: 'Allan';
                color:red;
                font-size: 13px;
            }
            </style>
    </head>
    <body>

<?php

function space($word,$total){
   // $total=strlen($total);
    $wrd=strlen($word);
    $data="";
    $space="";
    $loop=($total-$wrd);
    if($loop<=0){
        $data='<u>'.$word.'</u>';
    }else if($loop==1){
        $data='<u>&nbsp;'.$word.'</u>';
    }else{

        $loop=($loop-2);
        for($i=1;$i<=$loop;$i++){
        $space.="&nbsp;";
        }
        $data='<u>&nbsp;&nbsp;'.$word.$space.'</u>';
    }

    return $data;
}

function checkeven($number){
    if($number % 2 == 0){
        return true;
    }
    else{
        return false;
    }
}
function strl($word){
    $count=strlen($word);
    return $count;
}
?>


        @if($visa)
        <h3 style="text-align:center;">GOVERNMENT OF PAKISTAN<br>VISA APPLICATION FORM <br/>
        &lt;&gt;&lt;&gt;&lt;&gt;</h3>
        <b>(Please read these instructions carefully before filling in the application form)</b>
        <p style="line-height: 10px;">1. No column should be left blank. Incomplete forms with vague entries shall not be</p>
        <p style="line-height: 1px;">accepted. Where applicable copies of supportive documents should be submitted</p>
        <p style="line-height: 5px;">along with the application form.</p>
        <p style="line-height: 2px;">2. Applicants may use extra sheets, in case of insufficient space in the columns</p>
        <p style="line-height: 2px;">of the visa form.</p>
        <p style="line-height: 2px;">3. Two (02) passport size photographs should be attached with the visa form.</p>
        <p style="line-height: 2px;">4. Normal processing time for visa is 4-6 weeks.</p>
        <p style="line-height: 2px;">5. Applicants could be asked to appear for interview if required.</p>
        <p style="line-height: 2px;">6. On arrival, immigration formalities are mandatory. (Police registration is applicable in</p>
        <p style="line-height: 2px;">certain cases).</p>
        <p style="line-height: 2px;">7. Attach blank statement for business visit.</p>
        <p style="line-height: 2px;">8. Applicant’s family” includes spouse, son, daughter, father, mother,.</p>
        <p style="text-align:center; font-weight:bold;">PART l</p>
        <p>1. <b><u>Type of VIsa Applied For</u></b></p>
        <p>&nbsp; Diplomatic <input type="checkbox" value="Diplomatic" {{$visa->visa_type=='diplomatic'?'checked':''}} name="visa_type"> Official <input type="checkbox" value="official" {{$visa->visa_type=='official'?'checked':''}} name="visa_type">  Milatry <input type="checkbox" value="milatry" {{$visa->visa_type=='milatry'?'checked':''}} name="visa_type">  Business <input type="checkbox" value="business" {{$visa->visa_type=='business'?'checked':''}} name="visa_type"> Toursit <input type="checkbox" value="tourist" {{$visa->visa_type=='tourist'?'checked':''}} name="visa_type"></p><br>
        Family <input type="checkbox" {{$visa->visa_type=='family'?'checked':''}} value="family" name="visa_type"> Transit <input type="checkbox" value="transit" {{$visa->visa_type=='transit'?'checked':''}} name="visa_type"> Journalist <input type="checkbox" {{$visa->visa_type=='journalist'?'checked':''}} value="journalist" name="visa_type"> Others <input type="checkbox" {{$visa->visa_type=='others'?'checked':''}} value="others" name="visa_type"> (Specify __________
        <p>2. <b><u>Purpose of Visit </u> : </b><?php echo space($visa->visit_purpose,70) ;?></p>
        <p>3. <b><u>Duration of Stay </u> : </b><?php echo space($visa->duration_stay,70) ;?> </p>
        <p>4. <b><u>Visa required for</u> : </b>
        Less than 01 Month <input type="checkbox" value="Less than 01 Month" {{$visa->visa_require=='Less than 01 Month'?'checked':''}} name="visa_require"> 06 Months <input type="checkbox"  {{$visa->visa_require=='06 Months'?'checked':''}} value="06 Months" name="visa_require">  01 Year <input type="checkbox" value="01 Year" {{$visa->visa_require=='01 Year'?'checked':''}} name="visa_require">  02 Years <input type="checkbox" {{$visa->visa_require=='02 Years'?'checked':''}} value="02 Years" name="visa_require"> 05 Years <input type="checkbox" value="05 Years" {{$visa->visa_require=='05 Years'?'checked':''}} name="visa_require"></p>
        <p>5. <b><u>Visa Entry</u> : </b>
        Single Entry <input type="checkbox" value="Single Entry" {{$visa->visa_entry=='Single Entry'?'checked':''}} name="visa_entry"> Double Entry <input type="checkbox" value="Double Entry" {{$visa->visa_entry=='Double Entry'?'checked':''}} name="visa_entry">  Multiple Entry <input type="checkbox" value="Multiple Entry" {{$visa->visa_entry=='Multiple Entry'?'checked':''}} name="visa_entry"></p>
        <p>i. Port of Entry <?php echo space($visa->entry_port,35) ;?>  ii. Port of Departure <?php echo space($visa->departure_port,35) ;?></p>
        <p>iii. Place To be Visited in Pakistan</p>
        <p>a. <?php echo space($visa->visit_place1,20) ;?> b. <?php echo space($visa->visit_place2,20) ;?> c. <?php echo space($visa->visit_place3,20) ;?> d. <?php echo space($visa->visit_place4,20) ;?></p><br>
        <hr style="height:2px; background-color:black;">
        <p style="line-height:8px;">6. <b><u>SECTION l (APPLICANTS DETAILS)</u></b></p>
        <p style="line-height:6px;">i. Name as in Passport : <?php echo space($visa->p_first_name,23) ;?> <?php echo space($visa->p_middle_name,23) ;?>  <?php echo space($visa->p_last_name,23) ;?></p>
        <p style="line-height:6px;">ii. Date of Birth: <?php echo space($visa->applicant_dob,20) ;?></p>
        <p style="line-height:6px;">iii. Place of Birth:  City : <?php echo space($visa->applicant_city,20) ;?>  state : <?php echo space($visa->applicant_state,20) ;?>  Country : <?php echo space($visa->applicant_country,25) ;?> </p>
        <p>vi. Sex:  Male <input type="checkbox" {{$visa->sex_type=='Male'?'checked':''}} value="Male"> Female <input type="checkbox" {{$visa->sex_type=='Female'?'checked':''}} value="Female">  V.Blood Group : <?php echo space($visa->blood_group,20) ;?> </p></p>
    <p>v Martial Status:  Single <input type="checkbox" {{$visa->martial_status=='single'?'checked':''}} value="single" name="martial_status"> Married <input type="checkbox" value="married" {{$visa->martial_status=='married'?'checked':''}} name="martial_status"></p>
    <p>vi. Identification Mark <?php echo space($visa->identification_mark,20) ;?>  vii. Native Language <?php echo space($visa->native_language,20) ;?> </p>
    <p>ix. Nationality (a) Present <?php echo space($visa->pres_nationality,20) ;?> (b) Previous<?php echo space($visa->prev_nationality,20) ;?> (c) Dual <?php echo space($visa->dual_nationality,20) ;?></p>
    <p>x. Religion <?php echo space($visa->applicant_religion,30) ;?></p>
    <p>xi. <b><u>PASSPORT DETAILS:</u></b></p>
    <p>Type of Passport::  Diplomatic <input type="checkbox" {{$visa->passport_type=='diplomatic'?'checked':''}} value="diplomatic" name="passport_type"> Offcial / Service <input type="checkbox" {{$visa->passport_type=='official'?'checked':''}} value="official" name="passport_type"> Ordinary <input type="checkbox" value="ordinary" {{$visa->passport_type=='ordinary'?'checked':''}} name="passport_type"> UN Travel Document <input type="checkbox" {{$visa->passport_type=='un travel document'?'checked':''}} value="un travel document" name="passport_type"></p>
    <p>Passport Number: <?php echo space($visa->passport_number,25) ;?>  Place of Issue: <?php echo space($visa->place_issue,25) ;?></p>
    <p>Date of Issue: <?php echo space($visa->doi,30) ;?>  Date of Expiry: <?php echo space($visa->doe,30) ;?></p>
    <p>Issuing Authority: <?php echo space($visa->issuing_authority,50) ;?></p>
    <p style="line-height:10px;">xii. <b><u>ADDRESS & EMAIL:</u></b><br>
    <p>a. Abroad / Country of Origin. <?php echo space($visa->abroad_address,85) ;?> </p>
    <p style="line-height:2px;">_________________________________________________________________________</p>
    <p>Telephone: (i)Home: <?php echo space($visa->abroad_phone,30) ;?>(ii)Work: <?php echo space($visa->abroad_Work,30) ;?> (iii)Cell <?php echo space($visa->abroad_cell,30) ;?></u> </p>
    <p>b. In Pakistan. <?php echo space($visa->pak_address,80) ;?></p>
    <p style="line-height:2px;">_________________________________________________________________________</p>
    <p>Telephone: (i)Home: <?php echo space($visa->pak_home,30) ;?> (ii)Work: <?php echo space($visa->pak_Work,30) ;?> (iii)Cell <?php echo space($visa->pak_cell,30) ;?> </p>
    <p>xiii. Is your visit sponserd &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" {{$visa->sponserd=='yes'?'checked':''}} value="yes" name="sponserd"> &nbsp; &nbsp; &nbsp; No <input type="checkbox" value="no" {{$visa->sponserd=='no'?'checked':''}} name="sponserd"></p>
    <p>if yes, give details</p>
    <p style="border: 1px solid black;">
    <P><b> &nbsp; Name of Sponser &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Address &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Contact Number</b></P>
    <p> &nbsp; <?php echo space($visa->sponser_name,30) ;?> &nbsp; &nbsp; <?php echo space($visa->sponser_address,30) ;?> &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;  Home: <?php echo space($visa->sponser_contact,30) ;?></p>
    <p> &nbsp; _______________  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; __________________ &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;  Work: __________________</p>
    <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Cell: ___________________</p></p>
    <p>xiv. <b><u>DETAILS OF PROFESSION:</u></b></p>
    <p>a. &nbsp; &nbsp; Profession (Please specify Rank / Service, in case of Armed Forces / Uniform Personnel):</p>
    <hr style="height:2px; background-color:black;">
    <p><b><u>Note</u>:</b> In case of military services, Please fill in the attached Performa.</p>
    <p>b. &nbsp; &nbsp; &nbsp; Employer’s / Sponsor’s details ( in Pakistan / Abroad <b>(if Applicable)</b></p>
    <table style="border: 1px solid black; width:95%;">
    <tr>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th><b>Name</b></th>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th><b>Address</b></th>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th><b>Telephone</b></th>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th><b>Email</b></th>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp; <?php echo space($visa->profession_name,20) ;?></td>
        <td>&nbsp;&nbsp;&nbsp; <?php echo space($visa->profession_address,20) ;?></td>
        <td>&nbsp;&nbsp;&nbsp; <?php echo space($visa->profession_contact,20) ;?></td>
        <td>&nbsp;&nbsp;&nbsp; <?php echo space($visa->profession_email,20) ;?></td>
    </tr>
    <tr>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    </tr>
    <tr>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    <td>&nbsp;&nbsp;&nbsp; ________________</td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
</table>
<p>xv. <b><u>DETAILS OF JOB HELD IN THE PAST:</u></b></p>
<p>a. &nbsp; &nbsp; Designation: <?php echo space($visa->designation_name,30) ;?>  &nbsp; &nbsp; &nbsp; &nbsp; b. &nbsp; &nbsp; Department: <?php echo space($visa->designation_department,30) ;?></p>
<p>c. &nbsp; &nbsp; Duration (from-to): <?php echo space($visa->designation_duration,30) ;?>  &nbsp; &nbsp; &nbsp; &nbsp; d. &nbsp; &nbsp; Duties: <?php echo space($visa->designation_duties,30) ;?></p>
<p>e. &nbsp; &nbsp; Address & Phone No. <?php echo space($visa->designation_address,30) ;?><?php echo space($visa->designation_phone,30) ;?></p>
<p>f: &nbsp; &nbsp;  Name, address and contract numbers of immediate boss/head and any other colleague:</P>
<p style="line-height:2px;"> &nbsp; &nbsp; &nbsp; (use extra sheet if required)</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;_____________________________________________________________________</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;_____________________________________________________________________</p>
<p>xvi. Are you applying visa from a third country? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" value="yes" {{$visa->apply_FTC=='yes'?'checked':''}} name="apply_FTC"> &nbsp; &nbsp; &nbsp; No <input type="checkbox" {{$visa->apply_FTC=='no'?'checked':''}} value="no" name="apply_FTC"></p>
<p>If yes, please provide copy of residence / work permit of that country.</p>
<hr style="height:2px; background-color:black;">
<p></p>
<p>7. <b><u>SECTION II ( FAMILY DETAILS):</u></b></p>
<p>i. &nbsp; &nbsp; Name of Mother: <?php echo space($visa->mother_name,20) ;?> &nbsp; &nbsp; ii. &nbsp; &nbsp; Nationality of Mother <?php echo space($visa->mother_nationality,20) ;?></p>
<p>iii. &nbsp; Name of Father: <?php echo space($visa->father_name,20) ;?> &nbsp; &nbsp; iv. &nbsp; Nationality of Father <?php echo space($visa->father_nationality,20) ;?></p>
<p>v. &nbsp; &nbsp;  Spouse details :</p>
<p> &nbsp; &nbsp; Name : <?php echo space($visa->spous_name,30) ;?> &nbsp; &nbsp;  &nbsp; &nbsp; Nationality <?php echo space($visa->spous_nationality,30) ;?></p>
<p> &nbsp; &nbsp; Date and place of birth <?php echo space($visa->spous_dob,20) ;?><?php echo space($visa->spous_pob,20) ;?></p>
<p> &nbsp; &nbsp; Profession <?php echo space($visa->spous_profession,30) ;?></p>
<p> &nbsp; &nbsp; Name, Address and contact number of employer of spouse (if any) <?php echo space($visa->spous_contact,20) ;?></p>
<p>vi. Do you have any children? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" {{$visa->children=='yes'?'checked':''}} value="yes" name="children"> &nbsp; &nbsp; &nbsp; No <input type="checkbox" value="no" {{$visa->children=='no'?'checked':''}} name="children"></p>
<p>If yes, please provide details for each of your child. </p>
<p style="border: 1px solid black;"><p></p>
<P><b> &nbsp; &nbsp; &nbsp; Name  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Date of Birth</b></P>
@foreach($children as $child)
<p>&nbsp; &nbsp; &nbsp;<?php echo space($child->child_name,20) ;?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo space($child->child_dob,20);?></p>
@endforeach
</p>
<p>vii. Please list any of accompanying person / family member (including children) traveling with you to </p>
<p> &nbsp; &nbsp; Pakistan.</p>
<p style="border: 1px solid black;"><p></p>
<P><b> &nbsp; &nbsp; &nbsp; Full Name   &nbsp;  &nbsp; &nbsp; Date of Birth &nbsp; &nbsp; &nbsp;  Passport Number (if any) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; Address</b></P>

@foreach($members as $member)
<p> &nbsp; &nbsp; &nbsp; <?php echo space($member->TM_name,10) ;?> &nbsp;  &nbsp; <?php echo space($member->TM_dob,10) ;?> &nbsp; &nbsp; &nbsp;  <?php echo space($member->TM_passport,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($member->TM_address,10) ;?></p>
@endforeach
</p>

<p>viii. Do you have any bank account in Pakistan? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" value="yes" {{$visa->bank_account=='yes'?'checked':''}} name="bank_account"> &nbsp; &nbsp; &nbsp; No <input type="checkbox" {{$visa->bank_account=='no'?'checked':''}} value="no" name="bank_account"></p>
<p> &nbsp; &nbsp; Pakistan.</p>
<p style="border: 1px solid black;"><p></p>
<P><b> &nbsp; &nbsp; &nbsp; Bank Name  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Branch &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Passport A/C Number &nbsp; &nbsp; &nbsp; &nbsp;  Address &nbsp; &nbsp; Verifier details</b></P>
<p> &nbsp; &nbsp; &nbsp; <?php echo space($visa->bank_name,10) ;?> &nbsp; &nbsp; &nbsp; <?php echo space($visa->bank_branch,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visa->ac_number,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo space($visa->bank_Address,10) ;?></p>
</p>

<p>8. <b><u>TRAVEL HISTORY:</u></b></p>
<p>i. Have you ever visited Pakistan during last five years? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" value="yes"  {{$visa->visited_pakistan=='yes'?'checked':''}} name="visited_pakistan"> &nbsp; &nbsp; &nbsp; No <input type="checkbox"  {{$visa->visited_pakistan=='no'?'checked':''}} value="no" name="visited_pakistan"></p>
<p> &nbsp; if yes, please Provide details.</p>
<p style="border: 1px solid black;"><p></p>
<P><b> &nbsp; Date  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Destination / Address &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   Purpose &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Duration</b></P>
<?php
$i=1;

?>
@foreach($visits as $visit)
<p><b> &nbsp; <?php echo $i; $i++; ?>.</b><?php echo space($visit->visit_date,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visit->visit_designation,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visit->visited_purpose,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visit->visit_duration,10) ;?></p>
@endforeach
{{-- <p><b> &nbsp; 2.</b></p>
<p><b> &nbsp; 3.</b></p>
<p><b> &nbsp; 4.</b></p>
<p><b> &nbsp; 5.</b></p> --}}

</p>


<p>ii. Details of other countries visited, during last two years &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" value="yes" name="visa_type"> &nbsp; &nbsp; &nbsp; No <input type="checkbox" value="no" name="visa_type"></p>
<p> &nbsp; if yes, please Provide details.</p>
<p style="border: 1px solid black;"><p></p>
<P><b> &nbsp; Date  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Destination / Address &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   Purpose &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Duration</b></P>
<p><b> &nbsp; 1.</b></p>
<p><b> &nbsp; 2.</b></p>
<p><b> &nbsp; 3.</b></p>
<p><b> &nbsp; 4.</b></p>
<p><b> &nbsp; 5.</b></p>
</p>

<p>iii. Have you ever been refused a visa for any country, including Pakistan?  &nbsp; &nbsp; Yes <input type="checkbox" value="yes" {{$visa->refusal=='yes'?'checked':''}}  name="refusal"> &nbsp; &nbsp; No <input type="checkbox" value="no" {{$visa->refusal=='no'?'checked':''}} name="refusal"></p>
<p>iv. Have you ever been refused entry on arrival to Pakistan?  &nbsp; &nbsp; Yes <input type="checkbox" value="yes" {{$visa->refuse_entry=='yes'?'checked':''}} name="refuse_entry"> &nbsp; &nbsp; No <input type="checkbox" value="no" {{$visa->refuse_entry=='no'?'checked':''}} name="refuse_entry"></p>
<p> &nbsp; &nbsp; If yes, please provide details of refusa.</p><p></p><p></p>
<p style="border: 1px solid black;">
<p><br> &nbsp; &nbsp; {{$visa->refusal_message}}</p>
</p>

<p></p>
<p></p>
<p>v. Have you ever been deported, removed or otherwise required to leave any country, including</p>
<p> &nbsp; &nbsp; Pakistan?  &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" value="yes" {{$visa->deported=='yes'?'checked':''}} name="deported"> &nbsp; &nbsp; &nbsp; No <input type="checkbox" value="no" {{$visa->deported=='no'?'checked':''}} name="deported"></p>
<p> &nbsp; if yes, please Provide details.</p><p></p><p></p>
<p style="border: 1px solid black;"><p></p>
<P><b> &nbsp; Date  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Country &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; Reason  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; Duration &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; Reference Number (Pak)</b></P>
<p> <?php echo space($visa->deport_date,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visa->deport_country,10) ;?> &nbsp; &nbsp; &nbsp; <?php echo space($visa->deport_reason,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo space($visa->deport_ref_no,10) ;?></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
</p>

<p>vi. Do you have any criminal convictions or charged in any country? &nbsp; &nbsp; &nbsp; Yes <input type="checkbox" value="yes" {{$visa->criminal_case=='yes'?'checked':''}}  name="criminal_case"> &nbsp; &nbsp; &nbsp; No <input type="checkbox" value="no" {{$visa->criminal_case=='no'?'checked':''}} name="criminal_case"></p><p><br></p>
<p> &nbsp; if yes, please Provide details.</p><p><br></p>
<p style="border: 1px solid black;"><p></p>
<P><b> &nbsp; Date  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Country &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; Offence  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; Sentence </b></P>
<p> &nbsp; <?php echo space($visa->crime_date,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visa->crime_country,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visa->crime_offence,10) ;?> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo space($visa->crime_Sentence,10) ;?></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
</p>

<p><b><u>DECLARATION:</u></b></p><p><br></p>
<p>I declare that the information given in this form is correct to the best of my knowledge</p>
<p>and belief and if any of the particulars furnished above are found to be incorrect or </p>
<p>withheld the visa is liable to be rejected / cancelled at any time.</p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><b>Dated: </b><u>{{$visa->apply_date}}</u> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>Signature of Applicant : </b><font class="signature"><u>{{$visa->signature}}</u></font></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><br></p>


<p style="text-align: right;"><b>PART – II</b></p>
<h2 style="text-align:center;"><b><u>PROCESSING CERTIFICATION</u></b></h2>
<h3 style="text-align:center;"><b><u>(FOR OFFICIAL USE – NOT TO BE FILLED BY APPLICANT)</u></b></h3><p><br></p>
<p>1. &nbsp; &nbsp; Date of receipt of Visa Application: &nbsp; &nbsp; &nbsp; &nbsp; ________________________________ </p>
<p>2. &nbsp; &nbsp; Registration Number: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;________________________________ </p>
<p>3. &nbsp; &nbsp; Visa fee received: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ________________________________ </p>
<p>4. &nbsp; &nbsp; Additional Documents received: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ________________________________ </p>
<p>  &nbsp; &nbsp;  &nbsp; a.  ____________________________  &nbsp; &nbsp;  &nbsp; b.  ____________________________</p>
<p>  &nbsp; &nbsp;  &nbsp; c.  ____________________________  &nbsp; &nbsp;  &nbsp; d.  ____________________________</p>
<p>5. &nbsp; &nbsp; Particulars of official who checked the visa form for its correctness and supporting documents. </p>
<p>  &nbsp; &nbsp;  &nbsp; a. &nbsp; &nbsp;  &nbsp; Name ____________________  &nbsp; &nbsp;  &nbsp; b. &nbsp; &nbsp;  &nbsp; Designation ____________________</p>
<p>  &nbsp; &nbsp;  &nbsp; a. &nbsp; &nbsp;  &nbsp; Date _____________________  &nbsp; &nbsp;  &nbsp; b. &nbsp; &nbsp;  &nbsp; Signature ______________________</p>
<p>6. &nbsp; &nbsp; Details of clearance received from Ministry of Interior. </p>
<p>  &nbsp; &nbsp;  &nbsp; a. &nbsp; &nbsp;  &nbsp; No. ____________________  &nbsp; &nbsp;  &nbsp; b. &nbsp; &nbsp;  &nbsp; Dated ____________________</p>
<p>7. &nbsp; &nbsp; Decision by officer in-charge. </p>
<p> &nbsp; &nbsp; &nbsp; &nbsp; a. &nbsp; &nbsp; Accepted &nbsp; <input type="checkbox" value="Yes" name="visa_type"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; b. &nbsp; &nbsp; &nbsp; Regretted &nbsp;  <input type="checkbox" value="No" name="visa_type"></p>
<p> &nbsp; &nbsp; &nbsp; &nbsp; c. &nbsp; &nbsp; Type of Visa Issued. _________________________________________</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp; d. &nbsp; &nbsp; Duration. __________________________________________________</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp; e. &nbsp; &nbsp; Single Entry &nbsp; <input type="checkbox" value="Yes" name="visa_type"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; f. &nbsp; &nbsp; &nbsp; Multiple Entry  &nbsp; <input type="checkbox" value="No" name="visa_type"></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><b>Dated: </b>_______________ &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>Signature of Visa Issuing Authority : </b>_______________</p>
<p><br></p>
<p><br></p>

<hr style="height:2px; background-color:black;">
@endif
    </body>
</html>
