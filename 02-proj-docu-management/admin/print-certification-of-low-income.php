<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Certification of Low Income</h4>
            <a href="certification-low.php" class="btn btn-primary float-end">Go Back</a>
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

            // Fetch the certification ID from the URL
            $certificationlowId = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($certificationlowId <= 0) {
                echo '<h4>Invalid certification ID</h4>';
                return false;
            }

            // Query to fetch the specific certification details (for low income or source of income)
            $query = "
                SELECT 
                    ci.id AS certificationoflowincome_id, 
                    ci.personal_Id, 
                    ci.work, 
                    ci.age, 
                    ci.usedfor, 
                    ci.income, 
                    ci.created_at, 
                    ci.updated_at,
                    ci.councilor,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    certificationoflowincome ci
                JOIN 
                    personal p ON ci.personal_Id = p.id
                WHERE
                    ci.id = $certificationlowId
            ";

            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<h4>No Data Found for this certification ID</h4>';
                return false;
            }

            $certificationlow = mysqli_fetch_assoc($result);
            ?>
             <link rel="stylesheet" href="../design/brgyindigency.css">
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
          <p style="text-align: center; font-size:22.0pt; font-family: 'Impact', sans-serif; color:#0070C0; letter-spacing:3.0pt;">
    <strong>CERTIFICATE OF LOW INCOME</strong>
</p>
<br>
              <br>
              <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: justify;">
              &nbsp; <strong>TO WHOM IT MAY CONCERN:</strong>
              </p>
              <br>
              <br>
              <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: justify;">
              &nbsp; &nbsp; This is to certify that <strong><?= ucfirst(htmlspecialchars($certificationlow['name'])); ?></strong> <strong><?= ucfirst(htmlspecialchars($certificationlow['age'])); ?></strong> of age, <strong><?= ucfirst(htmlspecialchars($certificationlow['work'])); ?></strong>, Filipino, citizen is a bonifide resident of Barangay Bañadero, <strong><?= ucfirst(htmlspecialchars($certificationlow['address'])); ?></strong>, she have a <strong><?= ucfirst(htmlspecialchars($certificationlow['work'])); ?></strong> earnings <strong>PHP <?= ucfirst(htmlspecialchars($certificationlow['income'])); ?> Pesos.</strong>
Known to be a good moral character. Law abiding citizen, she/he has no liabilities and accountabilities whatsoever in this Barangay.
              </p>
             <br>
             <br>
              <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: justify;">
              &nbsp; &nbsp;This is certifies that she is a <strong><?= ucfirst(htmlspecialchars($certificationlow['work'])); ?></strong> and is receiving a monthly income in the amount of PHP <strong><?= ucfirst(htmlspecialchars($certificationlow['income'])); ?></strong>Pesos Only. .
              </p>
             <br>
             <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: justify;">
              &nbsp; &nbsp; This certification is issued upon the request of the above named person for <strong><?= ucfirst(htmlspecialchars($certificationlow['usedfor'])); ?></strong>
              </p>
             <br>   
             <br>
             <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt;">
             &nbsp; &nbsp; &nbsp; Issued this  <b><?= $daySuffix ?></b> day of <b><?= $currentMonth ?> <?= $currentYear ?></b> at the Office of the Punong Barangay Bañadero, Calamba City Laguna.
</p>
  
           
          </div>
        
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
                          <input type="text" maxlength="10" class="text-center" style="text-align: center;" value=" <?= htmlspecialchars($certificationlow['contnumber']); ?>" />
                      </div>
                  </center>
              </div>                
          </div>
           <!-- SIDEBAR SIDE -->
        

          <!-- FOOTER SIDE -->
          <div class="FOOTER">
              <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">
            
    <?php if (!empty($certificationlow['councilor'])): ?>
    <div class="consilor-info">
        <p class="honorary"><strong><?= htmlspecialchars($certificationlow['councilor']); ?></strong></p>
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

        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary" onclick="printMyArea()">Print</button>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
    var contnumber = "<?= $certificationlow['contnumber']; ?>";
</script>
