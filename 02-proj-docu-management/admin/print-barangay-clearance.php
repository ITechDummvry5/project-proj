<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Barangay Clearance</h4>
            <a href="barangay-clearance.php" class="btn btn-primary float-end">Go Back</a>
        </div>
    <div class="card-body">
      
        <div id="myArea">
        <?php
   
// Get the current date components
$currentDay = date('j'); // Day of the month without leading zeros (e.g., 7)
$currentMonth = date('F'); // Full month name (e.g., January)
$currentYear = date('Y'); // Year (e.g., 2025)

// Add suffix to the day (e.g., 7 -> 7th)
$daySuffix = date('jS'); // Outputs day with ordinal suffix (e.g., 7th)

// Fetch the clearance ID from the URL
$clearanceId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($clearanceId <= 0) {
    echo '<h4>Invalid clearance ID</h4>';
    return false;
}

// Query to fetch the specific clearance details
$query = "
    SELECT 
        bce.id AS clearance_id, 
        bce.personal_Id, 
        bce.since, 
        bce.birthday, 
        bce.age,
        bce.civilstatus, 
        bce.birthplace, 
        bce.services, 
        bce.created_at,
        bce.optionaluse,
        bce.councilor,
        p.name, 
        p.contnumber, 
        p.profile_image,
        p.address
    FROM 
        barangayclearance bce
    JOIN 
        personal p ON bce.personal_Id = p.id
    WHERE 
        bce.id = $clearanceId
";

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo '<h4>No Data Found for this clearance ID</h4>';
    return false;
}

$clearance = mysqli_fetch_assoc($result); ?>
        <link rel="stylesheet" href="../design/brgyclearance.css">
  
    <div class="parent">
        <div class="containers">
            
            <!-- HEADER SIDE -->
            <div class="HEADER">
                <div class="header-left">
                    <img src="../assets/print/left.png" alt="Left Image" width="118" height="auto">
                </div>
                <div class="header-text">
                    <p style="font-size:10.0pt; font-family:'Times New Roman',sans-serif;">Republic of the Philippines</p>
                    <p style="font-size:10.0pt; font-family:'Times New Roman',sans-serif;">Province of Laguna</p>
                    <p style="font-size:10.0pt; font-family:'Times New Roman',sans-serif;padding-bottom:10px;">City of Calamba</p>
                    
                    <p style="font-size:12.0pt; font-family:'Times New Roman',sans-serif;">Barangay Bañadero</p>
                    <p style="font-size:14.0pt; font-family:'Times New Roman',sans-serif;"><strong>OFFICE OF THE BARANGAY CHAIRMAN</strong></p>
                </div>
                <div class="header-right">
                    <img src="../assets/print/right.png" alt="Right Image" width="118" height="auto">
                </div>
            </div>

            <!-- TITLE SIDE -->
            <div class="TITLEPAGE">
                <p style="text-align: center; font-size:28.0pt; font-family:'Impact',sans-serif; color:#0070C0; letter-spacing:3.0pt;">
                    <strong>BARANGAY CLEARANCE</strong>
                </p>
                <br>
                <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: justify;">
                    This is to certify that the person whose name, picture, right thumb print, and signature appear hereon, a Filipino Citizen, is a resident of this Barangay.
                </p>
                <br>
                <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: justify;">
                    This also certifies that he/she is a person of good character, law-abiding citizen, and has never been convicted of any crime involving moral turpitude.
                </p>
                <br>
                <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt;">
    Issued this <b><?= $daySuffix ?></b> day of <b><?= $currentMonth ?> <?= $currentYear ?></b> at the Office of the Punong Barangay, Barangay Banadero, Calamba City (LAGUNA) Philippines.
</p>
                <br>
            </div>
            <!-- DATA1 SIDE -->
            <div class="DATA1">
            <div class="info-section" style="text-transform: uppercase; flex: 1; font-family:'Calibri',sans-serif;">
    <p class="fullname" style="font-size:10.0pt;">
        name:
        <span class="line name-line"><?= htmlspecialchars($clearance['name']); ?></span>
    </p>
    <p class="status" style="font-size:10.0pt;">
        status:
        <span class="line status-line"><?= htmlspecialchars($clearance['civilstatus']); ?></span>
    </p>
    <p class="sitio" style="font-size:10.0pt;">
        sitio:
        <span class="line sitio-line"><?= htmlspecialchars($clearance['address']); ?></span>
        BRGY. BAÑADERO
    </p>
    <p class="birthday-age" style="font-size:10.0pt;">
        birthday:
        <span class="line birthday-line"><?= date('d M Y', strtotime($clearance['birthday'])); ?></span>
        age:
        <span class="line age-line"><?= htmlspecialchars($clearance['age']); ?></span>
    </p>
    <p class="birthplace" style="font-size:10.0pt;">
        birthplace:
        <span class="line birthplace-line"><?= htmlspecialchars($clearance['birthplace']); ?></span>
    </p>
</div>
                
            </div>
            <!-- DATA1 SIDE -->
   <!-- SIGNATURE SIDE -->
            <div class="SIGNATURE">
                <div class="signature-container">
                    <p class="signature-text">Signature over Printed Name</p>
                    <p class="signature-subtext">of the Subject Person</p>
                  </div>                  
            </div>
            <!-- SIGNATURE SIDE -->

             <!-- SIDEBAR SIDE -->
            <div class="SIDEBAR">
                <div class="side">
                    <img src="../assets/print/side.png" alt="">
                    <div class="sidebar-text">
                        <p class="headers-text"><strong>HON. ARIES B. HIZON</strong><br></p>
                        <p class="smaller-text"><span> PUNONG BARANGAY</span></p>
                        <p class="smaller-text"><strong>BARANGAY KAGAWAD</strong></p>
                        <p class="smaller-text">
                            HON. RODRIGO M. ABESAMIS<br>
                            HON. JARREN O. MANZANERO<br>
                            HON. MARVIC L. PAJANUSTAN<br>
                            HON. MARVIN P. SUMADSAD<br>
                            HON. LEVY B. DIMAFELIX<br>
                            HON. ELSA E. PECHO<br>
                            HON. JOY ANN M. NATIVIDAD
                        </p>
                        <br>
                        <p class="smaller-text"><strong>SK CHAIRWOMAN</strong><br>HON. DIANNE Y. GRATELA</p>
                        <p class="smaller-text"><strong>BARANGAY TREASURER</strong><br>MRS. GLESILDA T. REBLANDO</p>
                        <p class="smaller-text"><strong>BARANGAY SECRETARY</strong><br>MR. RODELIO M. PIZON</p>
                    </div>
                    <center><img src="../assets/print/qrcode.png" alt="QR Code" width="128" height="auto"></center> 
                    <center><p class="muted-text"><em>This document is valid for one month from the date of issuance.</em></p></center>
                    <center>
                        <div class="controlno">
                            <input type="text" maxlength="10" class="text-center" style="text-align: center;" value="<?= htmlspecialchars($clearance['contnumber']); ?>" />
                        </div>
                    </center>
                </div>                
            </div>
             <!-- SIDEBAR SIDE -->

             <!-- PURPOSE SIDE -->
<div class="PURPOSE">
    <label style="font-size: larger;"><strong>Purpose:</strong></label><br><br>
    <input type="checkbox" id="purpose1" <?= in_array('school_sss_residential_id', $clearance) ? 'checked' : ''; ?>> School/SSS/Residential Identification <br>
    <input type="checkbox" id="purpose2" <?= in_array('local_overseas_employment', $clearance) ? 'checked' : ''; ?>> Local/Overseas Employment <br>
    <input type="checkbox" id="purpose3" <?= in_array('electrical_water_connection', $clearance) ? 'checked' : ''; ?>> Electrical/Water Connection <br>
    <input type="checkbox" id="purpose4" <?= in_array('bank_lending_transactions', $clearance) ? 'checked' : ''; ?>> Transactions with the Bank or Lending Institution <br>
    <input type="checkbox" id="purpose5" <?= in_array('firearms_drivers_license', $clearance) ? 'checked' : ''; ?>> Firearms Licensing/Driver's License <br>
    <input type="checkbox" id="purpose6" <?= in_array('financial_medical_burial_assistance', $clearance) ? 'checked' : ''; ?>> Financial/Medical/Burial Assistance <br>
    <input type="checkbox" id="purpose7" <?= in_array('travel_transfer_residence', $clearance) ? 'checked' : ''; ?>> Travel/Transfer of Residence <br>
    <input type="checkbox" id="purpose8" <?= in_array('others', $clearance) ? 'checked' : ''; ?>> Others <br>
    <p>Purpose: <span style="text-decoration: underline;"><?= htmlspecialchars($clearance['optionaluse']); ?></span></p>
</div>


              <!-- PURPOSE SIDE -->

              <!-- BOX SIDE -->
            <div class="BOX2">
                 <div class="container-box">
    <label for="picture">Picture</label>
    <div class="picture-box">
    <img src="../<?= htmlspecialchars($clearance['profile_image']); ?>"  
                             alt="Profile Image">
    </div>
  </div>
  <div class="container-box">
    <label for="thumbprint">Right Thumb</label>
    <div class="thumbprint-box">
    </div>
  </div>
            </div> 
            <!-- BOX SIDE -->

            <!-- FOOTER SIDE -->
            <div class="FOOTER">
                <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">

                <div class="cedula-info">
                    <span>Cedula No.:</span>
                    <span>Issued at :</span>
                    <span>Issue on  :</span>
                    <span>O.R. No.  :</span>
                </div>

                <?php if (!empty($clearance['councilor'])): ?>
    <div class="consilor-info">
        <p class="honorary"><strong><?= htmlspecialchars($clearance['councilor']); ?></strong></p>
        <p class="position">Duty of the Day</p>
    </div>
<?php endif; ?>

                
                <div class="center-content">
                    <p class="honorary"><strong>HON. ARIES B. HIZON</strong></p>
                    <p class="position">Punong Barangay</p>
                    <br>
                    <em><p class="seal-notice">Not Valid Without a Dry Seal</p></em>
                </div>
            </div>
             <!-- FOOTER SIDE -->

                    </div>
                 </div>
        </div>

        <div class="card-footer text-right">
            <button class="btn btn-primary" onclick="printMyArea()">Print</button>
        </div>
    </div>
        </div>
</div>
<?php include('includes/footer.php'); ?>


<script>
    var contnumber = "<?= $clearance['contnumber']; ?>";
</script>