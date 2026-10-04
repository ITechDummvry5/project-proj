$(document).ready(function () {
    // Initialize Select2 for both selects
    $('.jsselect').select2();

    // Handle the viewButton click event
    $('#viewButton').on('click', function () {
        var personalId = $('#personSelect').val();

        if (personalId != '') {
            $.ajax({
                url: 'fetch_personal_info.php',
                type: 'GET',
                data: { personal_Id: personalId },
                success: function(response) {
                    $('#modalContent').html(response);
                    $('#viewModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to fetch personal information. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No Record Selected',
                text: 'Please select a personal record to view.',
                confirmButtonText: 'OK'
            });
        }
    });

    // Listen for changes in the document category
    $('#documentcategory').on('change', function () {
        var selectedValue = $(this).val(); // Get the selected value
        var additionalFields = $('#additionalFields');
        additionalFields.empty(); // Clear previous fields

   // Function to generate random code
function generateRandomCode(prefix) {
    // Generate a random number between 100 and 999
    const randomNumber = Math.floor(100 + Math.random() * 900);
    // Return the code with the prefix and the formatted number
    return prefix + '-' + randomNumber.toString().padStart(3, '0');
}

        // Add relevant input fields based on the selected category
        if (['barangaycertificate', 'barangayclearance'].includes(selectedValue)) {
            additionalFields.html(`
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <label for="since" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Residence since</label>
                        <input type="number" class="form-control" id="since" name="since"  required>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" required min="1900-01-01" max="${new Date().toISOString().split('T')[0]}">
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                        <input type="text" class="form-control" id="age" name="age" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="civilstatus" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Civil Status</label>
<select class="form-control" id="civilstatus" name="civilstatus" required>
    <option value="">Select Civil Status</option>
    <option value="single">Single</option>
    <option value="married">Married</option>
    <option value="widow">Widow</option>
    <option value="separated">Separated</option>
</select>

                    </div>
                    <div class="col-md-6 mb-1 ">
                        <label for="birthplace" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthplace</label>
                        <input type="text" class="form-control" id="birthplace" name="birthplace" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="services" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Service/Purpose</label>
                        <select class="form-control" id="services" name="services">
                            <option value="school_sss_residential_id">School/SSS/Residential Identification</option>
    <option value="local_overseas_employment">Local/Overseas Employment</option>
    <option value="electrical_water_connection">Electrical/Water Connection</option>
    <option value="bank_lending_transactions">Transactions with the Bank or Lending Institution</option>
    <option value="firearms_drivers_license">Firearms Licensing/Driver's License</option>
    <option value="financial_medical_burial_assistance">Financial/Medical/Burial Assistance</option>
    <option value="travel_transfer_residence">Travel/Transfer of Residence</option>
    <option value="others" selected>Others</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-1 ">
        <label for="optionaluse" class="badge bg-primary bg-gradient rounded-1 mb-2">Please Specify The Service Purpose</label>
        <input type="text" name="optionaluse" id="optionaluse" class="form-control">
    </div>


                </div>
            `);
        } else if (selectedValue === 'businessclearance') {
            additionalFields.html(`
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="businesscode" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Business Control No.</label>
                        <input type="text" class="form-control" id="businesscode" name="businesscode" placeholder= "2025-xxxx" value="2025-" maxlength="9">
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="businessname" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Business Name</label>
                        <input type="text" class="form-control" id="businessname" name="businessname" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="location" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="manager" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Operation/Manager</label>
                        <input type="text" class="form-control" id="manager" name="manager" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="address" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Address/Business</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="or_number" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R Number</label>
                        <input type="text" class="form-control" id="or_number" name="or_number" required>
                    </div>
                </div>
            `);
        }   else if (selectedValue === 'buildingclearance') {
            additionalFields.html(`    
                 <div class="row">             
<div class="col-md-6 mb-2">
<label for="buildingcode" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Business Control No.</label>
<input type="text" class="form-control" id="buildingcode" name="buildingcode" value="2025-" placeholder= "2025-xxxx" maxlength="9" required>
</div>

<div class="col-md-6 mb-2">
<label for="floorarea" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Floor Area</label>
<input type="text" class="form-control" id="floorarea" name="floorarea"  required>
</div>

<div class="col-md-6 mb-2">
<label for="construction" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Construction</label>
<input type="text" class="form-control" id="construction" name="construction" required>
</div>

   <div class="col-md-6 mb-1">
                        <label for="location" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    
                       <div class="col-md-6 mb-1">
                        <label for="usedfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select document whom used for</label>
                        <input type="text" class="form-control" id="usedfor" name="usedfor">
                    </div>

                    <div class="col-md-6 mb-1 ">
        <label for="or_number" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R. Number</label>
        <input type="text" class="form-control" id="or_number" name="or_number">
    </div>

    <div class="col-md-6 mb-1">
        <label for="or_date" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R. Date</label>
        <input type="date" class="form-control" id="or_date" name="or_date">
    </div>

    <div class="col-md-6 mb-1">
        <label for="cedula_no" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Cedula Number</label>
        <input type="text" class="form-control" id="cedula_no" name="cedula_no" maxlength="20">
    </div>

    <div class="col-md-6 mb-1">
        <label for="issued_at" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Issued At</label>
        <input type="text" class="form-control" id="issued_at" name="issued_at">
    </div>

    <div class="col-md-6 mb-1">
        <label for="issued_on" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Issued On</label>
        <input type="date" class="form-control" id="issued_on" name="issued_on">
    </div>
    </div>
    
            `);
        } else if (selectedValue === 'franchising') {
            additionalFields.html(`
                <div class="row">
<div class="col-md-12 mb-1">
<label for="franchisingcode" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Franchising Cont No.</label>
<input type="text" class="form-control" id="franchisingcode" name="franchisingcode" value="2025-" maxlength="9">
</div>

<div class="col-md-6 mb-1">
<label for="drivername" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Drivers Fullname</label>
<input type="text" class="form-control" id="drivername" name="drivername" required>
</div>

<div class="col-md-6 mb-1">
    <label for="license" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Driver's License Number</label>
    <input type="text" class="form-control" id="license" name="license"  required  maxlength="13" placeholder="xxx–xx–xxxxxx">
</div>

<div class="col-md-6 mb-1">
<label for="platenumber" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Plate Number</label>
<input type="text" class="form-control"  id="platenumber" name="platenumber" required maxlength="7">
</div>

<div class="col-md-6 mb-1">
    <label for="receiptnumber" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Official Receipt Number</label>
    <input type="text" class="form-control" id="receiptnumber" name="receiptnumber" required>
</div>
<div class="col-md-6 mb-1">
    <label for="or_number" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R Number</label>
    <input type="text" class="form-control" id="or_number" name="or_number" 
           required>
</div>

<div class="col-md-6 mb-1">
    <label for="or_date" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R Date</label>
    <input type="date" class="form-control" id="or_date" name="or_date" 
         required>
</div>

<div class="col-md-6 mb-1">
    <label for="cedula_no" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Cedula Number</label>
    <input type="text" class="form-control" id="cedula_no" name="cedula_no" 
         required>
</div>

<div class="col-md-6 mb-1">
    <label for="issued_on" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Issued On</label>
    <input type="date" class="form-control" id="issued_on" name="issued_on" 
 required>
</div>

</div>
            `);
        }  else if (selectedValue === 'certificationoflegitimacy') {
            additionalFields.html(`  
<div class="row">
                <div class="col-md-6 mb-1">
<label for="work" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Job</label>
<input type="text" class="form-control" id="work" name="work"  required>
</div>
                 <div class="col-md-6 mb-1">
                        <label for="yearsofwork" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Length of work (Years)</label>
                        <input type="number" class="form-control" id="yearsofwork" name="yearsofwork"  required>
                    </div>
                    
                         <div class="col-md-6 mb-1">
                        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                        <input type="number" class="form-control" id="age" name="age">
                    </div>

                            <div class="col-md-6 mb-1">
                        <label for="usedfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select document whom used for</label>
                        <input type="text" class="form-control" id="usedfor" name="usedfor">
                    </div>
</div>
                    `);
        }else if (selectedValue === 'cohabitationletter') {
            additionalFields.html(`
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="namefor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Name Of Partner</label>
                        <input type="text" class="form-control" id="namefor" name="namefor" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="bornfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Born</label>
                        <input type="date" class="form-control" id="bornfor" name="bornfor" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="partnerbornfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Partner Born</label>
                        <input type="date" class="form-control" id="partnerbornfor" name="partnerbornfor" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="yearslivein" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Years Live In</label>
                        <input type="number" class="form-control" id="yearslivein" name="yearslivein" min="0" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="sincedateliving" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Since Date Living</label>
                        <input type="date" class="form-control" id="sincedateliving" name="sincedateliving" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="purposefor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Purpose For</label>
                        <input type="text" class="form-control" id="purposefor" name="purposefor" required>
                    </div>
                </div>
            `);
        
        }  else if (['certificationoflowincome','certificationofsourceofincome'].includes(selectedValue)) {
            additionalFields.html(`  
<div class="row">
    <div class="col-md-6 mb-1">
        <label for="work" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Job</label>
        <input type="text" class="form-control" id="work" name="work"  required>
    </div>

    <div class="col-md-6 mb-1">
        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
        <input type="number" class="form-control" id="age" name="age">
    </div>

    <div class="col-md-6 mb-1">
        <label for="usedfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select document whom used for</label>
        <input type="text" class="form-control" id="usedfor" name="usedfor">
    </div>

    <div class="col-md-6 mb-1">
        <label for="income" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Monthly Income</label>
        <input type="text" class="form-control" id="income" name="income">
    </div>
</div>
                    `); 
                }  else if  (selectedValue === 'certificateofgoodmoral') {
                        additionalFields.html(`  
            <div class="row">
                <div class="col-md-12 mb-1">
                    <label for="usedfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Document Whom Used For</label>
                    <input type="text" class="form-control" id="usedfor" name="usedfor">
                </div>
            </div>

                                `); }

               else if (['barangayindigency', 'barangayresidency'].includes(selectedValue)) {
                    additionalFields.html(`   
                          <div class="row">
                    <div class="col-md-12 mb-1">
                        <label for="since" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1" >Residence since</label>
                        <input type="number" class="form-control" id="since" name="since" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" required min="1900-01-01" max="${new Date().toISOString().split('T')[0]}">
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                        <input type="text" class="form-control" id="age" name="age" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-1">
                          <label for="civilstatus" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Civil Status</label>
<select class="form-control" id="civilstatus" name="civilstatus" required>
    <option value="">Select Civil Status</option>
    <option value="single">Single</option>
    <option value="married">Married</option>
    <option value="widow">Widow</option>
    <option value="separated">Separated</option>
</select>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label for="birthplace" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthplace</label>
                        <input type="text" class="form-control" id="birthplace" name="birthplace" required>
                    </div>
                </div>

<div class="row">
                    <div class="col-md-12 mb-1">
        <label for="optionaluse" class=" mb-2 badge bg-primary bg-gradient rounded-1">Document Whom Used For</label>
        <input type="text" name="optionaluse" id="optionaluse" class="form-control" required>
    </div>
                </div>
                `);
               } else if (selectedValue === 'pwdcertificate') {
                additionalFields.html(`
<div class="row">
                        <div class="col-md-12 mb-1">

                  Not Yet Available
                  </div>
                </div>


                `);
            } 

            else if (selectedValue === 'soloparentcertificate') {
                additionalFields.html(`  
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label for="since" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Residence Since</label>
                            <input type="number" class="form-control" id="since" name="since"required>
                        </div>
                    
                        <div class="col-md-6 mb-1">
                            <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                            <input type="text" class="form-control" id="age" name="age">
                        </div>
            
<div class="col-md-12 mb-1">
    <label for="category" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Common Law</label>
    <select class="form-control" id="category" name="category" required>
        <option value="a1">a1 - Magulang na nagsilang ng bata na biktima ng panggagahasa</option>
        <option value="a2">a2 - Biyuda/Biyudo</option>
        <option value="a3">a3 - Asawa na nakakulong at / ohinatulang mabilango</option>
        <option value="a4">a4 - May mental o pisikal na kapansanan ang asawa / partner</option>
        <option value="a5">a5 - Hiwalay sa asawa</option>
        <option value="a6">a6 - Napawalang-bisa o annulled ang kasal</option>
        <option value="a7">a7 - Inabandona ng asawa o kinakasama</option>
        <option value="b">b - Asawa ng OFW/Solo Parent na kamag-anak ng OFW</option>
        <option value="c">c - Hindi kasal na piniling palakihin ang anak na mag-isa</option>
        <option value="d">d - Solong legal guardian, adoptive or foster parent</option>
        <option value="e">e - Sinumang miyembrong pamilya within 4th degree na tumatayo bilang head of the family ng mga bata</option>
        <option value="f">f - Babaeng buntis na mag-isa ng mangangalaga at susuporta sa isisilang pa lang na anak</option>
    </select>
</div>

            
                        <!-- Children Information -->
                        <div class="col-md-6 mb-1">
                            <label for="children1" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 1 Name</label>
                            <input type="text" class="form-control" id="children1" name="children1" >
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="children1_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 1 Birthday</label>
                            <input type="date" class="form-control" id="children1_birthday" name="children1_birthday">
                        </div>
            
                        <div class="col-md-6 mb-1">
                            <label for="children2" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 2 Name</label>
                            <input type="text" class="form-control" id="children2" name="children2" >
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="children2_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 2 Birthday</label>
                            <input type="date" class="form-control" id="children2_birthday" name="children2_birthday">
                        </div>
            
                        <div class="col-md-6 mb-1">
                            <label for="children3" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 3 Name</label>
                            <input type="text" class="form-control" id="children3" name="children3">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="children3_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 3 Birthday</label>
                            <input type="date" class="form-control" id="children3_birthday" name="children3_birthday">
                        </div>
            
                        <div class="col-md-6 mb-1">
                            <label for="children4" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 4 Name</label>
                            <input type="text" class="form-control" id="children4" name="children4" >
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="children4_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 4 Birthday</label>
                            <input type="date" class="form-control" id="children4_birthday" name="children4_birthday">
                        </div>
                    </div>
                `);
            } else if (selectedValue === 'certificationofcalamity') {
                additionalFields.html(`  
    <div class="row">
                    <div class="col-md-6 mb-1">
    <label for="calamitytypes" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Calamity Name</label>
    <input type="text" class="form-control" id="calamitytypes" name="calamitytypes" required maxlength="40">
    </div>
                  <div class="col-md-6 mb-1">
                            <label for="calamitydate" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Calamity Date</label>
                            <input type="date" class="form-control" id="calamitydate" name="calamitydate">
                        </div>
   
    <div class="col-md-12 mb-1">
        <label for="purpose" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Purpose</label>
        <input type="text" class="form-control" id="purpose" name="purpose" required maxlength="100">
    </div>
</div>
                        `); }
                        else if (selectedValue === 'certificationofesc') {
                            additionalFields.html(`  
                             <div class="row">
    <div class="col-md-6 mb-1">
        <label for="residentsince" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Resident Since</label>
        <input type="date" class="form-control" id="residentsince" name="residentsince" required>
    </div>

       <div class="col-md-6 mb-1">
        <label for="purpose" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Purpose</label>
        <input type="text" class="form-control" id="purpose" name="purpose" required maxlength="100">
    </div>

    <div class="col-md-6 mb-1">
        <label for="father" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Father</label>
        <input type="text" class="form-control" id="father" name="father" maxlength="40">
    </div>

    <div class="col-md-6 mb-1">
        <label for="mother" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Mother</label>
        <input type="text" class="form-control" id="mother" name="mother" maxlength="40">
    </div>

    <div class="col-md-6 mb-1">
        <label for="child" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child</label>
        <input type="text" class="form-control" id="child" name="child" required maxlength="40">
    </div>

    <div class="col-md-6 mb-1">
        <label for="school" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">School</label>
        <input type="text" class="form-control" id="school" name="school" required maxlength="100">
    </div>

 
</div>

                            `);
                        }
                        
                  

                  // Reinitialize Select2 after dynamic content update
               $('.jsselect').select2();
       
               // Calculate age based on the birthday input
               function calculateAge(birthday) {
                   const birthDate = new Date(birthday);
                   const today = new Date();
                   let age = today.getFullYear() - birthDate.getFullYear();
                   const monthDiff = today.getMonth() - birthDate.getMonth();
       
                   if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                       age--;
                   }
                   return age;
               }
               $('#birthday').on('input', function () {
                   const birthday = $(this).val();
                   const ageInput = $('#age');
                   if (birthday) {
                       ageInput.val(calculateAge(birthday));
                   } else {
                       ageInput.val('');
                   }
               });
    });
});

function printMyArea() {
    var divContents = document.getElementById("myArea").innerHTML;
    var a = window.open('', '');
    a.document.write('<html><title>' +  contnumber + '</title>');
    a.document.write('<body style="font-family:fangsong;">');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print(); }
