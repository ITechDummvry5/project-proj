<?php include('includes/header.php'); ?>

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Business Clearance</h4>
            <a href="business-clearance.php" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">
            <div id="myArea">
                <?php
                // Fetch the business clearance ID from the URL
                $businessClearanceId = isset($_GET['id']) ? intval($_GET['id']) : 0;

                if ($businessClearanceId <= 0) {
                    echo '<h4>Invalid business clearance ID</h4>';
                    return false;
                }

                // Query to fetch the specific business clearance details
                $query = "
                    SELECT 
                        bsc.id AS businessclearance_id, 
                        bsc.personal_Id, 
                        bsc.businesscode, 
                        bsc.businessname,
                        bsc.manager,
                        bsc.location, 
                        bsc.created_at, 
                        bsc.updated_at,
                        bsc.address,
                        bsc.or_number,
                        p.name, 
                        p.contnumber, 
                        p.profile_image,
                        p.address AS persoal_address
                    FROM 
                        businessclearance bsc
                    JOIN 
                        personal p ON bsc.personal_Id = p.id
                    WHERE 
                        bsc.id = $businessClearanceId
                ";

                // Execute the query
                $result = mysqli_query($conn, $query);

                if (!$result || mysqli_num_rows($result) === 0) {
                    echo '<h4>No Data Found for this business clearance ID</h4>';
                    return false;
                }

                $businessClearance = mysqli_fetch_assoc($result);
                ?>
                  <link rel="stylesheet" href="../design/business.css">
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
                  <p style="text-align: center; font-size:36.0pt; font-family: 'Impact', sans-serif; color: white; padding-left: 20px; padding-top: 15px; letter-spacing:1.0pt;">BARANGAY CLEARANCE</p>
              </div>
              <div class="header-right">
                  <img src="../assets/print/right.png" alt="Right Image" width="118" height="auto">
              </div>
          </div>

          <!-- TITLE SIDE -->
          <div class="TITLEPAGE">
          <p style="text-align: left; font-size:28.0pt; font-family: 'Impact', sans-serif; color:#06b4f4; letter-spacing:3.0pt; padding-left: 10px;">
    <strong>TO OPERATE BUSINESS</strong>
</p>
<br>
              
              <p style="font-size:11.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt; text-align: center; padding-left:240px; color: red;">
              &nbsp; <strong>Control No : <?= htmlspecialchars($businessClearance['businesscode']); ?></strong>
              <br>
              </p>
              <p style="font-size:10.0pt; font-family:'Calibri',sans-serif; text-align: center;">
            This is to certify that the Business or Trade activity described below:
              </p><br>
             
             
              <div style="text-align: center;">
    <div style="font-size: 11.0pt; font-family: 'Calibri', sans-serif;">
        <strong>NAME</strong><br>
        <?= htmlspecialchars($businessClearance['businessname']); ?>
    </div><br>
    
    <div style="font-size: 11.0pt; font-family: 'Calibri', sans-serif;">
        <strong>ADDRESS</strong><br>
        <?= htmlspecialchars($businessClearance['location']); ?>
    </div><br>

    <div style="font-size: 11.0pt; font-family: 'Calibri', sans-serif;">
        <strong>NAME</strong><br>
        <?= htmlspecialchars($businessClearance['manager']); ?>

    </div><br>

    <div style="font-size: 11.0pt; font-family: 'Calibri', sans-serif;">
        <strong>ADDRESS</strong><br>
       <SPAn style="font-size: 10.0PT;" class="TEXT-MUTED"><?= htmlspecialchars($businessClearance['address']); ?></SPAn> 

    </div>
</div>
<br>
<br>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif;">
             Propose to be established in this Barangay and is being applied for a Barangay Clearance to be used in securing corresponding Mayor’s Permit has been found to be;

</p>
<br>
<p style="font-size:10.0pt; font-family:'Calibri',sans-serif;">
<label>
    <input type="checkbox" name="statement1" value="1" checked>
    In conformity with the provisions of existing Barangay Ordinances, Rules and Regulations being enforced in this Barangay;
  </label><br><br>
  
  <label>
    <input type="checkbox" name="statement2" value="2" checked>
    Not among those Business or Trade activities being banned to be established in this Barangay.
  </label><br><br>
  
  <label>
    <input type="checkbox" name="statement3" value="3" checked>
    In view of the foregoing, this Barangay through the undersigned – interposes NO OBJECTION for the issuance of the corresponding Mayor’s Permit being applied for.
  </label><br><br>

</p>
  
           
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
                          <input type="text" maxlength="10" style="text-align: center;" class="text-center" value=" <?= htmlspecialchars($businessClearance['contnumber']); ?>" />
                      </div>
                  </center>
              </div>                
          </div>
           <!-- SIDEBAR SIDE -->
        

          <!-- FOOTER SIDE -->
          <div class="FOOTER">
              <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">

              <div class="cedula-info">
                    <span style="font-size: 12.0pt; padding-top:18px">O.R: <?= htmlspecialchars($businessClearance['or_number']); ?></span>
                    <br>
                    <span>Requirement:</span>
                    <span>Original Copy of SEC or DTI Registration</span>
                    <span>Picture of Business</span>
                </div>

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
    var contnumber = "<?= $businessClearance['contnumber']; ?>";
</script>