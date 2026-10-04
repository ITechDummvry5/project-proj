<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Create Documents</h4>
            <!-- Updated View button that triggers the modal -->
            <button type="button" class="btn btn-primary float-end" id="viewButton">Review</button>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="doc-code.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Personal Information Dropdown -->
                    <div class="col-md-12 mb-3">
                        <label for="personSelect" class="form-label fw-bolder fs-6">Select Personal Information</label>
                        <select name="personal_Id" id="personSelect" class="form-select form-control jsselect" required>
                            <option value="" class="fw-bolder fs-6">Select Personal Information</option>
                            <?php
// Fetch personal using getAll function
$personal = getAll('personal'); // Assuming you have a personal table
if ($personal) {
    while ($personalassociate = mysqli_fetch_assoc($personal)) {
        $displayName = htmlspecialchars($personalassociate['name']) . ' [ Cont. No: ' . htmlspecialchars($personalassociate['contnumber']) . ' ]';
        echo '<option class="fw-light fs-6" value="' . $personalassociate['id'] . '">' . $displayName . '</option>';
    }
} else {
    echo '<option value="">No Personal Found!</option>';
}

?>
                        </select>
                    </div>

                    <!-- Type Of Document Need -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bolder fs-6 mb-1">Types of Document</label>
                        <select name="documentcategory" class="form-select form-control jsselect" id="documentcategory" required>
                            <option value="" class="fw-bolder fs-6">Select Category</option>
                            <option value="barangaycertificate" class="fw-light fs-6">Barangay Certificate</option>
                            <option value="barangayclearance" class="fw-light fs-6">Barangay Clearance</option>
                            <option value="barangayindigency" class="fw-light fs-6">Barangay Indigency</option>
                            <option value="barangayresidency" class="fw-light fs-6">Barangay Residency</option>
                            <option value="pwdcertificate" class="fw-light fs-6">PWD Certificate</option>
                            <option value="soloparentcertificate" class="fw-light fs-6">Solo Parent Certificate</option>
                            <option value="franchising" class="fw-light fs-6">Franchising</option>
                            <option value="businessclearance" class="fw-light fs-6">Business Clearance</option>
                            <option value="buildingclearance" class="fw-light fs-6">Building Clearance</option>
                            <option value="cohabitationletter" class="fw-light fs-6">Cohabitation Letter</option>
                            <option value="certificationofesc" class="fw-light fs-6">Certification of Esc</option>
                            <option value="certificationoflowincome" class="fw-light fs-6">Certification of Low Income</option>
                            <option value="certificationofsourceofincome" class="fw-light fs-6">Certification of Source of Income</option>
                            <option value="certificationoflegitimacy" class="fw-light fs-6">Certification of Legitimacy</option>
                            <option value="certificateofgoodmoral" class="fw-light fs-6">Certificate Of Good Moral</option>
                            <option value="certificationofcalamity" class="fw-light fs-6">Certification of Calamity</option>
                        </select>
                    </div>

                    <!-- Dynamic Input Fields -->
                    <div id="additionalFields" class="col-md-12"></div>
                </div>
                <div class="col-mb-12 text-right">
                <button type="submit" name="saveddocument" class="btn btn-primary mt-3 ">Submit</button></div>
            </form>
        </div>
    </div>
</div>

<!-- Modal to View Selected Personal Information -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="viewModalLabel">Personal Information</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Modal Content will be populated via jQuery -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php include 'includes/footer.php'; ?>


