<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Franchising</h4>
            <a href="franchising.php" class="btn btn-primary float-end">Go Back</a>
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
            // Fetch the franchising ID from the URL
            $franchisingId = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($franchisingId <= 0) {
                echo '<h4>Invalid franchising ID</h4>';
                return false;
            }

            // Query to fetch the specific franchising details
            $query = "
                SELECT 
                fs.id AS franchising_id, 
                fs.personal_Id, 
                fs.franchisingcode, 
                fs.drivername, 
                fs.license, 
                fs.platenumber, 
                fs.receiptnumber, 
                 fs.or_number,
                 fs.or_date,
                  fs.cedula_no,
                fs.issued_on,
                fs.created_at, 
                fs.updated_at,
                p.name, 
                p.contnumber, 
                p.profile_image,
                p.address
                FROM 
                    franchising fs
                JOIN 
                    personal p ON fs.personal_Id = p.id
                WHERE
                    Fs.id = $franchisingId
            ";

            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<h4>No Data Found for this franchising ID</h4>';
                return false;
            }

            $franchising = mysqli_fetch_assoc($result);
            ?>
             <link rel="stylesheet" href="../design/franchising.css">
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
                  <p style="text-align: center; font-size:24.0pt; font-family: 'Impact', sans-serif; color: white; padding-left: 20px; padding-top: 15px; letter-spacing:1.0pt;">CERTIFICATE OF REGISTRATION</p>
              </div>
              <div class="header-right">
                  <img src="../assets/print/right.png" alt="Right Image" width="118" height="auto">
              </div>
          </div>

      <!-- TITLE SIDE -->
<div class="TITLEPAGE">
    <b style="font-size:18.0pt; font-family:'Impact',sans-serif; letter-spacing:2.0pt; color:#2596be; padding-top:1px"> Tricycle Franchising Regulatory Committee</b>
    <br>
    <br>
    <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: center; padding-left:285px; color: red;">
        &nbsp; <strong>Control No : <?= htmlspecialchars($franchising['franchisingcode']); ?></strong>
        <br>
    </p>
    <br>

    <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt;">
        SA KINAUUKULAN
        <br>
        <br>
    </p>

    <!-- New Box with Outline -->
    <div class="outlined-box">
        <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; text-align: start; color: black;">
            Pangalan ng may – ari ng sasakyan: <strong><?= htmlspecialchars($franchising['name']); ?></strong>
        </p>
        <br>
        <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; text-align: start; color: black;">
            Naninirahan sa: <strong><?= htmlspecialchars($franchising['address']); ?></strong>
        </p>
        <br>
        <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; text-align: start; color: black;">
            Pangalan ng nagmamaneho:  <strong><?= htmlspecialchars($franchising['drivername']); ?></strong>
        </p>
        <br>
        <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; text-align: start; color: black;">
            Numero ng nagmamaneho: <strong><?= htmlspecialchars($franchising['license']); ?></strong>
        </p>
        <br>
        <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; text-align: start; color: black;">
            Plate Number ng sasakyan: <strong><?= htmlspecialchars($franchising['platenumber']); ?></strong>
        </p>
        <br>
        <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; text-align: start; color: black;">
            Official Receipt Number: <strong><?= htmlspecialchars($franchising['receiptnumber']); ?></strong>
        </p>
        <br>
        <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; text-align: start; color: black;">
            Ang pag papatunay na ito ay ipinagkaloob kay <strong><?= htmlspecialchars($franchising['drivername']); ?></strong> ngayong <b><?= $daySuffix ?></b> araw ng <b><?= $currentMonth ?> <?= $currentYear ?></b>
        </p>
    </div>
    <br> <br>
    <!-- New Section with 2 Columns -->
    <div class="two-column-section">
        <!-- Left Column -->
        <div class="left-column">
            <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; text-align: left; color: black;">
                O.R NO: 8669057
            </p>
            <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; text-align: left; color: black;">
                O.R DATE: 1/17/2025
            </p>
            <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; text-align: left; color: black;">
                CEDULA NO: 11666414
            </p>
            <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; text-align: left; color: black;">
                ISSUED AT: BRGY. BAÑADERO
            </p>
            <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; text-align: left; color: black;">
                ISSUED ON: 1/17/25
            </p>
            <br>
            <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; text-align: left; color: black;">
                <strong>Requirements:</strong>
                <br>
                Original Copy of O.R/C.R
                <br>
                Driver’s License
                <br>
                CEDULA
                <br>
                Certificate of
            </p>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <br><br>
            <p style="font-size:10.0pt; font-family:'Calibri',sans-serif; text-align: center; color: black; margin-top:10px; border-top: 2px solid black; padding-top: 5px;">
    <strong>Signature of the Subject Person</strong>
</p>

            <br>
            <p style="font-size:10.0pt; font-family:'Calibri',sans-serif; text-align: left; color: black;">
                <strong>Prepared By:</strong>
                <br>
                <br>
                <p style="font-size:10.0pt; font-family:'Calibri',sans-serif; text-align: center; color: black; margin-top:10px; border-top: 2px solid black; padding-top: 5px;">
                <strong>Mr. Rodelio M. Pizon</strong>
                <br>
                Barangay Secretary
                </p>
            </p>
        </div>
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
                          <input type="text" maxlength="10" class="text-center" style="text-align: center;" value=" <?= htmlspecialchars($franchising['contnumber']); ?>" />
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
    var contnumber = "<?= $franchising['franchisingcode']; ?>";
</script>