<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Certification of ESC</h4>
            <a href="certification-esc.php" class="btn btn-primary float-end">Go Back</a>
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

            // Fetch the escItem ID from the URL
            $escItemId = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($escItemId <= 0) {
                echo '<h4>Invalid escItem ID</h4>';
                return false;
            }

          // Query to fetch the specific escItem details
$query = "
SELECT 
    ce.id AS certificationofesc_id, 
    ce.personal_Id, 
    ce.father,
    ce.mother,
    ce.child,
    ce.school,
    ce.residentsince,
    ce.purpose,
    ce.created_at,
    ce.updated_at,
    ce.councilor,
    p.name, 
    p.contnumber, 
    p.profile_image,
    p.address
FROM 
    certificationofesc ce
JOIN 
    personal p ON ce.personal_Id = p.id
WHERE 
    ce.id = $escItemId
";

        

            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<h4>No Data Found for this escItem ID</h4>';
                return false;
            }

            $escItem = mysqli_fetch_assoc($result);
            ?>
       <link rel="stylesheet" href="../design/esc.css">
  
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
                  <p style="font-size:12.0pt; font-family:'Aptos Black',sans-serif; letter-spacing:1.0pt;"><strong>TANGGAPAN NG SANGGUNIANG BARANGAY</strong></p>
              </div>
              <div class="header-right">
                  <img src="../assets/print/right.png" alt="Right Image" width="118" height="auto">
              </div>
          </div>

          <!-- TITLE SIDE -->
          <div class="TITLEPAGE">
          <p style="text-align: center; font-size:25.0pt; font-family: 'Impact', sans-serif; color:#0070C0; letter-spacing:1.0pt;">
    <strong>P A G P A P A T U N A Y /
S E R T I P I K A SY O N
</strong>
</p>
<br>
    
              <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp;&nbsp; <b>Sa kinauukulan;</b>
              </p>
             <br>
            <br>
            
             <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp;&nbsp; Ang kalatas na ito ay pagpapatunay na si <strong><?= htmlspecialchars($escItem['father'] ?? ''); ?></strong>
<?php if (!empty($escItem['father']) && !empty($escItem['mother'])): ?>
    at
<?php endif; ?>
<strong><?= htmlspecialchars($escItem['mother'] ?? ''); ?></strong>

<?php if (!empty($escItem['father']) || !empty($escItem['mother'])): ?>
    ay anak si
<?php endif; ?>
<strong><?= htmlspecialchars($escItem['child'] ?? ''); ?></strong>
na kasalukuyang nag aaral sa <strong><?= htmlspecialchars($escItem['school'] ?? ''); ?></strong> at lihitimong mamamayan at naninirahan sa  <strong><?= htmlspecialchars($escItem['address'] ?? ''); ?></strong>, Barangay Banadero Lungsod ng Calamba simula pa noong <strong><?= htmlspecialchars(date('Y', strtotime($escItem['residentsince'] ?? ''))); ?></strong>.

              </p>
             <br>

             <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp;&nbsp; at gayun din naman pinatutunayan na si <strong><?= htmlspecialchars($escItem['child'] ?? ''); ?></strong> ay kabilang sa pamilyang sapat lang ang kakayahan at may karaniwang hanap-buhay o pinagkakakitaan hanggang sa kasalukuyan.
              </p>
             <br>
             
          
             <p style="font-size:14.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt;">
             Ang pagpapatunay na ito ay ipinagkaloob kay <strong><?= htmlspecialchars($escItem['child'] ?? ''); ?></strong> ngayong  ika-<b><?= $daySuffix ?></b> ng <b><?= $currentMonth ?> <?= $currentYear ?></b> upang magamit bilang isa sa kailangang dokumento sa  EDUCATIONAL SUBSIDY CONTRACTING /<strong><?= htmlspecialchars($escItem['purpose'] ?? ''); ?></strong> ,SA <strong><?= htmlspecialchars($escItem['school'] ?? ''); ?></strong>.
</p>
<br>

             

           
    </div>


        
          <!-- FOOTER SIDE -->
          <div class="FOOTER">
              <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">
            
    <?php if (!empty($escItem['councilor'])): ?>
    <div class="consilor-info">
        <p class="honorary"><strong><?= htmlspecialchars($escItem['councilor']); ?></strong></p>
        <p class="position">Duty of the Day</p>
    </div>
<?php endif; ?>     
          

              <div class="center-content">
                <p>Approved By,</p> <br>
                  <p class="honorary"><strong>HON. ARIES B. HIZON</strong></p>
                  <p class="position">Barangay Chairman</p>
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
    var contnumber = "<?= $escItem['contnumber']; ?>";
</script>