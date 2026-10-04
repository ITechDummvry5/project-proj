<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Barangay soloparentcertificate</h4>
            <a href="soloparentcertificate.php" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">

        <div id="myArea">
            <?php

            // Fetch the soloparentcertificate ID from the URL
            $soloparentcertificateId = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($soloparentcertificateId <= 0) {
                echo '<h4>Invalid soloparentcertificate ID</h4>';
                return false;
            }

            // Query to fetch the specific soloparentcertificate details
            $query = "
                SELECT 
                    so.id AS soloparentcertificate_id, 
                     so.personal_Id, 
                so.since, 
                so.category,
                so.age,
                so.created_at,
                so.updated_at,
                so.children1, 
                so.children1_birthday, 
                so.children2, 
                so.children2_birthday, 
                so.children3, 
                so.children3_birthday, 
                so.children4, 
                so.children4_birthday,
                so.councilor,
                p.name,
                p.contnumber, 
                p.profile_image,
                p.address
                FROM 
                    soloparentcertificate so
                JOIN 
                    personal p ON so.personal_Id = p.id
                WHERE 
                    so.id = $soloparentcertificateId
            ";

            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<h4>No Data Found for this soloparentcertificate ID</h4>';
                return false;
            }

            $soloparentcertificate = mysqli_fetch_assoc($result);
            ?>
       <link rel="stylesheet" href="../design/solo.css">
  
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
                  <p style="font-size:12.0pt; font-family:'Times New Roman',sans-serif; ">Barangay Bañadero</p>
                  <p style="font-size:14.0pt; font-family:'Times New Roman',sans-serif;"><strong>OFFICE OF THE BARANGAY CHAIRMAN</strong></p>
              </div>
              <div class="header-right">
                  <img src="../assets/print/right.png" alt="Right Image" width="118" height="auto">
              </div>
          </div>

          <!-- TITLE SIDE -->
          <div class="TITLEPAGE">
          <p style="text-align: center; font-size:25.0pt; font-family: 'Impact', sans-serif; color:#0070C0; letter-spacing:3.0pt;">
    <strong>BARANGAY CERTIFICATION</strong>
</p>

              <br>
              <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify;">
              &nbsp;&nbsp; This is to certify that  <strong><?= ucfirst(htmlspecialchars($soloparentcertificate['name'])); ?></strong> , <strong><?= ucfirst(htmlspecialchars($soloparentcertificate['age'])); ?></strong> years old, a residency of  <strong><?= ucfirst(htmlspecialchars($soloparentcertificate['address'])); ?></strong>
               Barangay Bañadero Calamba City, Laguna, common law <strong><?= ucfirst(htmlspecialchars($soloparentcertificate['category'])); ?></strong>, (Please underline the Solo Parent category) is a bonified residence since <strong><?= ucfirst(htmlspecialchars($soloparentcertificate['since'])); ?></strong> up to present. He/ She identify in our Barangay as person who solely provides parental care and support of his / her children as follows:  
              </p>
             <br>
             <br>

             <div class="children-container">
    <div class="children-row">
        <div class="children-column">
            <label for="child1-name" class="form-label">Children Name</label>
            <div class="underline"><?= htmlspecialchars($soloparentcertificate['children1'] ?? ''); ?></div>
    <div class="underline"><?= htmlspecialchars($soloparentcertificate['children2'] ?? ''); ?></div>
    <div class="underline"><?= htmlspecialchars($soloparentcertificate['children3'] ?? ''); ?></div>
    <div class="underline"><?= htmlspecialchars($soloparentcertificate['children4'] ?? ''); ?></div>
        </div>
        <div class="children-column">
    <label for="child1-birthday" class="form-label">Birthday</label>
    <?php
function formatDate($date) {
    if ($date !== '0000-00-00' && !empty($date)) {
        return htmlspecialchars(date('M j, Y', strtotime($date))); // Formats as "Feb 2, 2025"
    }
    return ''; // Return empty if date is invalid
}
?>

<div class="underline">
    <?= formatDate($soloparentcertificate['children1_birthday']); ?>
</div>
<div class="underline">
    <?= formatDate($soloparentcertificate['children2_birthday']); ?>
</div>
<div class="underline">
    <?= formatDate($soloparentcertificate['children3_birthday']); ?>
</div>
<div class="underline">
    <?= formatDate($soloparentcertificate['children4_birthday']); ?>
</div>

</div>
   
    </div>
</div>

<div class="menu">
    <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: center; text-transform:capitalize; font-weight:bold">
        MGA ITINUTURING NA SOLO PARENTS:
    </p>
    <br>
    <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: justify; text-transform:capitalize; font-weight:bold">
        Code Category for each Solo Parent applicants to be reflected in the Solo Parent identification card (SPIC) template based on the IRR 11861 to be included: (please encircle the number code category to reflect his/her as Solo Parent)
    </p>
    <br>
    <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; letter-spacing:0.1pt; text-align: justify;">
        <strong>Code Category:</strong><br><br>
        A1 – Magulang na nagsilang ng bata na biktima ng panggagahasa<br>
        A2 – Biyuda/Biyudo<br>
        A3 – Asawa na nakakulong at / o hinatulang mabilanggo<br>
        A4 – May mental o pisikal na kapansanan ang asawa / partner<br>
        A6 – Napawalang-bisa o annulled ang kasal<br>
        A5 – Hiwalay sa asawa<br>
        A7 – Inabandona ng asawa o kinakasama<br>
        B – Asawa ng OFW/Solo Parent na kamag-anak ng OFW<br>
        C – Hindi kasal na piniling palakihin ang anak na mag-isa<br>
        D – Solong legal guardian, adoptive or foster parent<br>
        E – Sinumang miyembrong pamilya within 4th degree na tumatayo bilang head of the family ng mga bata<br>
        F – Babaeng buntis na mag-isa ng mangangalaga at susuporta sa isisilang pa lang na anak
    </p>
    <br>
    <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align: start; text-transform:capitalize; font-weight:bold">
        This certification is being issued upon request of the aforementioned for the Solo Parent Identification Card (ID) New/Renew.
    </p>
    <p style="font-size:9.0pt; font-family:'Calibri',sans-serif; letter-spacing:1.0pt; text-align:start; font-weight:bold">
    Signed this date of <?php echo date("F d, Y"); ?> at Barangay Bañadero Calamba City Laguna.
</p>

</div>


    </div>


        

         <!-- FOOTER SIDE -->
<div class="FOOTER">
    <img src="../assets/print/footer.png" alt="Footer Image" class="footer-image">
    <img src="assets/img/z-image.jfif" alt="New Footer Image" class="new-footer-image" height="180" width="361">

    <?php if (!empty($soloparentcertificate['councilor'])): ?>
    <div class="consilor-info">
        <p class="honorary"><strong><?= htmlspecialchars($soloparentcertificate['councilor']); ?></strong></p>
        <p class="position">Duty of the Day</p>
    </div>
<?php endif; ?>     

    <div class="center-content">
        <div class="divider">
            <div class="left-witness" style="padding-top: 35px; ">
                <p style="text-align: start; ">Witness:</p> <br>
                <div style="text-align: center;">
                    <div style="width: 200px; border-top: 2px solid black; margin: 0 auto;"></div>
                    <p style="margin: 0; padding-top: 5px;">Signature over Printed Name</p>
                </div>
            </div>

            <div class="right-certify">
                <p style="text-align: start; margin-bottom:3px;">Certify by:</p><br>
                <p><strong>HON. ARIES B. HIZON</strong><br>Punong Barangay</p> <br>
                <div style="text-align: center;"> 
                    <div style="width: 200px; border-top: 2px solid black; margin: 0 auto;"></div>
                    <p style="margin: 0; padding-top: 5px;">Signature over Printed Name</p>
                </div>
            </div>
        </div>

        <!-- Seal Notice -->
        <p class="seal-notice">Not Valid Without a Dry Seal</p>
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
    var contnumber = "<?= $soloparentcertificate['contnumber']; ?>";
</script>