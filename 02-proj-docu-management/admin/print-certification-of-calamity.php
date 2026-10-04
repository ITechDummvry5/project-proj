<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Barangay calamityItem</h4>
            <a href="certification-calamity.php" class="btn btn-primary float-end">Go Back</a>
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

            // Fetch the calamityItem ID from the URL
            $calamityItemId = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($calamityItemId <= 0) {
                echo '<h4>Invalid calamityItem ID</h4>';
                return false;
            }

            // Query to fetch the specific calamityItem details
            $query = "
            SELECT 
                ca.id AS certificationofcalamity_id, 
                ca.personal_Id, 
                ca.calamitytypes, 
                ca.calamitydate,
                ca.created_at,
                ca.updated_at,
                ca.purpose,
                ca.councilor,
                p.name,
                p.contnumber, 
                p.profile_image,
                p.address
            FROM 
                certificationofcalamity ca
            JOIN 
                personal p ON ca.personal_Id = p.id
            WHERE 
                ca.id = $calamityItemId
        ";
        

            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<h4>No Data Found for this calamityItem ID</h4>';
                return false;
            }

            $calamityItem = mysqli_fetch_assoc($result);
            ?>
       <link rel="stylesheet" href="../design/calamity.css">
  
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
                  <p style="font-size:10.0pt; font-family:'Times New Roman',sans-serif; padding-bottom:10px;">City of Calamba</p>
        
                  <p style="font-size:11.0pt; font-family:'Aptos Black',sans-serif; padding-bottom:3px;"><strong>BARANGAY NG BAÑADERO</strong> 
        
<br>

</p>
                  <p style="font-size:12.0pt; font-family:'Aptos Black',sans-serif; letter-spacing:3.0pt;"><strong>OFFICE OF THE PUNONG BARANGAY</strong></p>
              </div>
              <div class="header-right">
                  <img src="../assets/print/right.png" alt="Right Image" width="118" height="auto">
              </div>
          </div>

          <!-- TITLE SIDE -->
          <div class="TITLEPAGE">
          <p style="text-align: center; font-size:25.0pt; font-family: 'Impact', sans-serif; color:#0070C0; letter-spacing:1.0pt;">
    <strong>CERTIFICATION OF CALAMITY</strong>
    <br>
</p>
<br>

<br>      
              <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp;&nbsp; This is to certify that  <strong><?= htmlspecialchars($calamityItem['name'] ?? ''); ?></strong>  legal  of age, Filipino, is a bonifide resident of <strong><?= htmlspecialchars($calamityItem['address'] ?? ''); ?></strong> Barangay Bañadero Calamba City, Laguna
              </p>
             <br>
            <br>
            
             <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp;&nbsp; It is upon his / her request that we issue this certification that last  <strong><?= htmlspecialchars($calamityItem['calamitytypes'] ?? ''); ?></strong> brought to our Barangay affects their home that caused totally damaged last <strong>
    <?= htmlspecialchars(date('M D Y', strtotime($calamityItem['calamitydate'] ?? ''))) ?? ''; ?>
</strong>
.
              </p>
             <br>

             <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp;&nbsp; This certification has been issued for  <strong><?= htmlspecialchars($calamityItem['purpose'] ?? ''); ?></strong> purposes, this may serve him/her.
              </p>
             <br>
             
          
             <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:3.0pt;">
    Issued this <b><?= $daySuffix ?></b> day of <b><?= $currentMonth ?> <?= $currentYear ?></b> at the Office of the Punong Barangay, Barangay Banadero, Calamba City (LAGUNA) Philippines.
</p>
<br>

             

           
    </div>


        
          <!-- FOOTER SIDE -->
          <div class="FOOTER">
              <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">
            
    <?php if (!empty($calamityItem['councilor'])): ?>
    <div class="consilor-info">
        <p class="honorary"><strong><?= htmlspecialchars($calamityItem['councilor']); ?></strong></p>
        <p class="position">Duty of the Day</p>
    </div>
<?php endif; ?>          

              <div class="center-content">
                  <p class="honorary"><strong>HON. ARIES B. HIZON</strong></p>
                  <p class="position">Punong Barangay</p>
                  <br>
                  <em><p class="seal-notice">Not Valid Without a Dry Seal</p></em>
                  <br>
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
    var contnumber = "<?= $calamityItem['contnumber']; ?>";
</script>