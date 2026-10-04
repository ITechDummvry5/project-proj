<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Cohabitation Letter</h4>
            <a href="cohabitation-letter.php" class="btn btn-primary float-end">Go Back</a>
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

                // Fetch the cohabitation letter ID from the URL
                $cohabitationLetterId = isset($_GET['id']) ? intval($_GET['id']) : 0;

                if ($cohabitationLetterId <= 0) {
                    echo '<h4>Invalid Cohabitation Letter ID</h4>';
                    return false;
                }

                // Query to fetch the specific cohabitation letter details
                $query = "
                SELECT 
                    cl.id AS cohabitation_id, 
                    cl.namefor, 
                    cl.purposefor, 
                    cl.created_at, 
                    cl.updated_at,
                    cl.bornfor, 
                    cl.partnerbornfor, 
                    cl.yearslivein, 
                    cl.sincedateliving,
                    cl.councilor,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    cohabitationletter cl
                JOIN 
                    personal p ON cl.personal_Id = p.id
                WHERE
                    cl.id = $cohabitationLetterId
            ";
            

                // Execute the query
                $result = mysqli_query($conn, $query);

                if (!$result || mysqli_num_rows($result) === 0) {
                    echo '<h4>No Data Found for this Cohabitation Letter ID</h4>';
                    return false;
                }

                $cohabitationLetter = mysqli_fetch_assoc($result);
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
          <p style="text-align: center; font-size:24.0pt; font-family: 'Impact', sans-serif; color:#0070C0; letter-spacing:1.0pt;">
    <strong>CERTIFICATE OF COHABITATION</strong>
</p>
<br>
              <br>
              <p style="font-size:12.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp; <strong>TO WHOM IT MAY CONCERN:</strong>
              </p>
              <br>
              <br>
              <p style="font-size:12.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp; &nbsp; This is to certify that  <strong><?= ucfirst(htmlspecialchars($cohabitationLetter['name'])); ?></strong>, Born on  <strong><?= htmlspecialchars(date('M d, Y', strtotime($cohabitationLetter['bornfor'] ?? ''))) ?? ''; ?></strong>
              , and <strong><?= ucfirst(htmlspecialchars($cohabitationLetter['namefor'])); ?></strong>, Born on <strong><?= htmlspecialchars(date('M d, Y', strtotime($cohabitationLetter['partnerbornfor'] ?? ''))) ?? ''; ?></strong>, Have been Living as a Common Partner for almost <strong><?= ucfirst(htmlspecialchars($cohabitationLetter['yearslivein'])); ?></strong> years and taking on all of the task and responsibilities that follow with being in the said relationship, Cohabiting the same household 
              at <strong><?= ucfirst(htmlspecialchars($cohabitationLetter['address'])); ?></strong> Barangay Bañadero, Calamba City, and both holding themselves out of the community as Common Partner
    
              <?php
// Assuming $cohabitationLetter['sincedateliving'] is the date stored in the database (e.g., "2020-03-15")
$sincedateliving = $cohabitationLetter['sincedateliving'];

// Check if the sincedateliving value is valid and not empty
if ($sincedateliving) {
    $date = new DateTime($sincedateliving);  // Create a DateTime object from the stored date
    $monthName = strtoupper($date->format('F'));  // Get the full month name (e.g., MARCH), in uppercase
    $year = $date->format('Y');  // Get the year (e.g., 2020)

    // Get the current year
    $currentYear = date('Y');

    // Format the text as "since MARCH 2020 – 2025"
    $formattedDate = " " . $monthName . " " . $year . " – " . $currentYear;
} else {
    $formattedDate = "No living date provided";
}
?>
 since<strong><?= htmlspecialchars($formattedDate); ?></strong></p>


              </p>
             <br>
             <br>
              <p style="font-size:12.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp; &nbsp; This certification is issued upon the request of the above – named. For the Purpose of <strong><?= ucfirst(htmlspecialchars($cohabitationLetter['purposefor'])); ?></strong> FOR <strong><?= ucfirst(htmlspecialchars($cohabitationLetter['name'])); ?></strong>.
              </p>
             <br>
             <br>
             <p style="font-size:12.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
             &nbsp; &nbsp; &nbsp; Given this   <b><?= $daySuffix ?></b> day of <b><?= $currentMonth ?> <?= $currentYear ?></b> at the Office of the Punong Barangay Bañadero, Calamba City Laguna.
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
                          <input type="text" maxlength="10" class="text-center" style="text-align: center;" value=" <?= htmlspecialchars($cohabitationLetter['contnumber']); ?>" />
                      </div>
                  </center>
              </div>                
          </div>
           <!-- SIDEBAR SIDE -->
        

          <!-- FOOTER SIDE -->
          <div class="FOOTER">
              <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">
            
    <?php if (!empty($cohabitationLetter['councilor'])): ?>
    <div class="consilor-info">
        <p class="honorary"><strong><?= htmlspecialchars($cohabitationLetter['councilor']); ?></strong></p>
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
    var contnumber = "<?= $cohabitationLetter['contnumber']; ?>";
</script>
