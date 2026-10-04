<?php 
include('rinclude/header.php');  
?>
<section class="py-5">
    <div class="container px-4">
        <h1 class="fw-bolder fs-5 mb-3 mt-4">Maintenance Request Form</h1>
        <div class="card border-0 shadow rounded-3 px-2"> <!-- Added px-2 for padding -->
            <div class="card-body p-0">
                <div class="row gx-0">
                    <!-- Left Form -->
                    <div class="col-lg-7 col-xl-7 py-lg-3">
                        <div class="p-md-5">
                            <?php alertMessage(); ?>
                            <form action="rcode.php" method="POST">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="rservices" class="badge bg-primary bg-gradient rounded-1">Service Type</label>
                                        <select name="rservices" id="service" class="form-control form-select" required>
                                            <option value="">Select Service</option>
                                            <option value="plumbing">Plumbing</option>
                                            <option value="gate_fix">Gate Fix</option>
                                            <option value="electrical">Electrical</option>
                                            <option value="landscaping">Landscaping</option>
                                            <option value="painting">Painting</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="rdescription" class="form-label fw-bolder fs-6 mb-1">
                                        Description of the maintenance
                                    </label>
                                    <textarea class="form-control" id="rdescription" name="rdescription" required rows="5" style="resize: none;"></textarea>
                                    <small id="charCount" class="form-text text-muted mb-1">350 characters remaining</small>
                                </div>

                                <button type="submit" name="saveRequest" class="btn btn-primary text-white col-md-12">Submit Request</button>
                            </form>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="col-lg-5 col-xl-5 d-flex justify-content-center align-items-center"> <!-- Flexbox for centering -->
                        <div class="p-3"> <!-- Added padding around the image -->
                            <img src="../assets/image/undraw_resident_1.svg" class="img-fluid image-shadow" alt="maintenance request image" style="width: 100%; max-width: 300px; height: auto;"> <!-- Controlled width and height -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('rdescription');
    const charCount = document.getElementById('charCount');
    const maxLength = 350;

    // Initialize the character count
    function updateCharCount() {
        const remaining = maxLength - textarea.value.length;
        charCount.textContent = `${remaining} characters remaining`;
    }

    // Set initial character count
    updateCharCount();

    // Update character count on input
    textarea.addEventListener('input', updateCharCount);
});
</script>
