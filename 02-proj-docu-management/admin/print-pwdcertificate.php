<?php include('includes/header.php'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Print Barangay pwdcertificate</h4>
            <a href="pwdcertificate.php" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">

        <div id="myArea">
            <?php

            // Fetch the pwdcertificate ID from the URL
            $pwdcertificateId = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($pwdcertificateId <= 0) {
                echo '<h4>Invalid pwdcertificate ID</h4>';
                return false;
            }

            // Query to fetch the specific pwdcertificate details
            $query = "
                SELECT 
                    pw.id AS pwdcertificate_id, 
                    pw.personal_Id, 
                    pw.since, 
                    pw.birthday, 
                    pw.age,
                    pw.civilstatus, 
                    pw.birthplace, 
                    pw.created_at,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    pwdcertificate pw
                JOIN 
                    personal p ON pw.personal_Id = p.id
                WHERE 
                    pw.id = $pwdcertificateId
            ";

            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result || mysqli_num_rows($result) === 0) {
                echo '<h4>No Data Found for this pwdcertificate ID</h4>';
                return false;
            }

            $pwdcertificate = mysqli_fetch_assoc($result);
            ?>
            <table class="table table-bordered">
                <tr>
                    <th>pwdcertificate ID</th>
                    <td><?= htmlspecialchars($pwdcertificate['pwdcertificate_id']); ?></td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td><?= htmlspecialchars($pwdcertificate['name']); ?></td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td><?= htmlspecialchars($pwdcertificate['contnumber']); ?></td>
                </tr>
                <tr>
                    <th>pwrthday</th>
                    <td><?= date('d M Y', strtotime($pwdcertificate['birthday'])); ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?= htmlspecialchars($pwdcertificate['age']); ?></td>
                </tr>
                <tr>
                    <th>Civil Status</th>
                    <td><?= htmlspecialchars($pwdcertificate['civilstatus']); ?></td>
                </tr>
                <tr>
                    <th>pwrthplace</th>
                    <td><?= htmlspecialchars($pwdcertificate['birthplace']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?= htmlspecialchars($pwdcertificate['address']); ?></td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td><?= date('d M Y', strtotime($pwdcertificate['created_at'])); ?></td>
                </tr>
                <tr>
                    <th>Profile Image</th>
                    <td>
                        <img src="../<?= htmlspecialchars($pwdcertificate['profile_image']); ?>" 
                             style="width: 100px; height: 100px; object-fit: cover;" 
                             alt="Profile Image">
                    </td>
                </tr>
            </table>
        </div>

        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary" onclick="printMyArea()">Print</button>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>


<script>
    var contnumber = "<?= $pwdcertificate['contnumber']; ?>";
</script>