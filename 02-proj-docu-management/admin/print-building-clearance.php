<?php include('includes/header.php'); ?>

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Building Clearance</h4>
            <a href="building-clearance.php" class="btn btn-primary float-end">Go Back</a>
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

                // Fetch the Building clearance ID from the URL
                $buildingclearanceId = isset($_GET['id']) ? intval($_GET['id']) : 0;

                if ($buildingclearanceId <= 0) {
                    echo '<h4>Invalid Building clearance ID</h4>';
                    return false;
                }

                // Query to fetch the specific Building clearance details
                $query = "
                   SELECT 
                bui.id AS buildingclearance_id,   
                bui.personal_id,                  
                bui.buildingcode, 
                bui.floorarea, 
                bui.construction, 
                bui.created_at, 
                bui.usedfor,
                bui.location,
                 bui.or_number,
        bui.or_date,
        bui.cedula_no,
        bui.issued_at,
        bui.issued_on,
                p.name, 
                p.contnumber, 
                p.profile_image,
                p.address
            FROM 
                buildingclearance bui  
            JOIN 
                personal p ON bui.personal_id = p.id
            WHERE
                bui.id = $buildingclearanceId";

                // Execute the query
                $result = mysqli_query($conn, $query);

                if (!$result || mysqli_num_rows($result) === 0) {
                    echo '<h4>No Data Found for this building clearance ID</h4>';
                    return false;
                }

                $buildingclearance = mysqli_fetch_assoc($result);
                ?>
  <link rel="stylesheet" href="../design/building.css">
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
                  <p style="font-size:10.0pt; font-family:'Times New Roman',sans-serif;">City of Calamba</p>
                  <p style="font-size:12.0pt; font-family:'Times New Roman',sans-serif;">Barangay Bañadero</p>
                  <p style="font-size:14.0pt; font-family:'Times New Roman',sans-serif;"><strong>OFFICE OF THE BARANGAY CHAIRMAN</strong></p>
                  <p style="text-align: center; font-size:36.0pt; font-family: 'Impact', sans-serif; color: white; padding-left: 20px; padding-top: 15px; letter-spacing:1.0pt;">BARANGAY BUILDING</p>
              </div>
              <div class="header-right">
                  <img src="../assets/print/right.png" alt="Right Image" width="118" height="auto">
              </div>
          </div>

          <!-- TITLE SIDE -->
          <div class="TITLEPAGE">
          <p style="text-align: left; font-size:36.0pt; font-family: 'Impact', sans-serif; color:#06b4f4; letter-spacing:1.0pt; padding-left: 80px;">
    <strong>CLEARANCE</strong>
</p>
<br>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
Clearance is hereby granted to the proposed <strong><?= ucfirst(htmlspecialchars($buildingclearance['construction'])); ?></strong>
              <br>
              <br>
              <p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              With a TOTAL AREA OF <strong><?= ucfirst(htmlspecialchars($buildingclearance['floorarea'])); ?></strong> square meters (Floor area) located at <strong><?= ucfirst(htmlspecialchars($buildingclearance['address'])); ?></strong> of Barangay Bañadero Calamba City, Laguna Philippines.
              </p>
              <br>
              <p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              This clearance is being issued upon request of <strong><?= ucfirst(htmlspecialchars($buildingclearance['name'])); ?></strong> for <strong><?= ucfirst(htmlspecialchars($buildingclearance['construction'])); ?></strong> at the office of Barangay Bañadero, for the purpose of securing <strong><?= ucfirst(htmlspecialchars($buildingclearance['usedfor'])); ?></strong> and for whatever legal purpose it may serve.
              </p>
             <br>
             <p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
             This certification is being issued upon the request of the subject for <strong><?= ucfirst(htmlspecialchars($buildingclearance['usedfor'])); ?></strong> purposes it may serve him/her best.
              </p>
              <br>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
    Issued this <b><?= $daySuffix ?></b> day of <b><?= $currentMonth ?> <?= $currentYear ?></b> at the Office of the Punong Barangay, Barangay Banadero, Calamba City (LAGUNA) Philippines.
</p>
<br>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
    O.R NO: <b><?= htmlspecialchars($buildingclearance['or_number'] ?? ''); ?></b>
</p>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
    O.R DATE: <b><?= htmlspecialchars(($buildingclearance['or_date'] !== '0000-00-00' && !empty($buildingclearance['or_date'])) ? $buildingclearance['or_date'] : ''); ?></b>
</p>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
    CEDULA NO: <b><?= htmlspecialchars($buildingclearance['cedula_no'] ?? ''); ?></b>
</p>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
    ISSUED AT: <b><?= htmlspecialchars($buildingclearance['issued_at'] ?? ''); ?></b>
</p>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
    ISSUED ON: <b><?= htmlspecialchars(($buildingclearance['issued_on'] !== '0000-00-00' && !empty($buildingclearance['issued_on'])) ? $buildingclearance['issued_on'] : ''); ?>
    </b>
</p>
<br>
<div class="requirements" style=" font-size: 7.0pt; letter-spacing:1.0pt;
    font-family: 'Calibri', sans-serif;
    ">
    <p>Requirments:</p>
  <p>Original Copy of Land Title/Deed of Sale/Lease </p>
  <p>of Purchase Agreement</p>
  <p>Deed of Transfer or any Proof of Ownership</p>
</div>


                   
                 
                 
                   
                    

  
           
          </div>
        
           <!-- SIDEBAR SIDE -->
          <div class="SIDEBAR">
              <div class="side">
                  <img src="../assets/print/side.png" alt="">
                  <div class="sidebar-text">
                      <p class="headers-text"><strong>HON. ARIES B. HIZON</strong></p>
                      <p class="smaller-text"><span> PUNONG BARANGAY</span></p>
                      <p class="smaller-text"><strong>BARANGAY KAGAWAD</strong></p>
                      <p class="smaller-text">
                          HON. RODRIGO M. ABESAMIS
                          HON. JARREN O. MANZANERO
                          HON. MARVIC L. PAJANUSTAN
                          HON. MARVIN P. SUMADSAD
                          HON. LEVY B. DIMAFELIX
                          HON. ELSA E. PECHO
                          HON. JOY ANN M. NATIVIDAD
                      </p>
                      
                      <p class="smaller-text"><strong>SK CHAIRWOMAN</strong>HON. DIANNE Y. GRATELA</p>
                      <p class="smaller-text"><strong>BARANGAY TREASURER</strong>MRS. GLESILDA T. REBLANDO</p>
                      <p class="smaller-text"><strong>BARANGAY SECRETARY</strong>MR. RODELIO M. PIZON</p>
                  </div>
                  <center><img src="../assets/print/qrcode.png" alt="QR Code" width="128" height="auto"></center> 
                  <center><p class="muted-text"><em>This document is valid for one month from the date of issuance.</em></p></center>
                  <center>
                      <div class="controlno">
                          <input type="text" maxlength="10" class="text-center" style="text-align: center;" value=" <?= htmlspecialchars($buildingclearance['contnumber']); ?>" />
                      </div>
                  </center>
              </div>                
          </div>
           <!-- SIDEBAR SIDE -->
        

          <!-- FOOTER SIDE -->
          <div class="FOOTER">
              <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">


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

        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary" onclick="printMyArea()">Print</button>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
    var contnumber = "<?= $buildingclearance['contnumber']; ?>";
</script>
