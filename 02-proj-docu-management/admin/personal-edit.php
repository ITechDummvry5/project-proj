<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Personal Information</h4>
            <a href="personal-view.php" class="btn btn-primary float-end">View Records</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
            <?php 
                // Fetch contractor ID from URL and check if it's valid
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch personal data from the database based on the contractor ID
                $personal = getById('personal', $paramValue);
                
                // Check if personal data is successfully retrieved
                if ($personal['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store personal ID -->
                    <input type="hidden" name="personalId" value="<?= htmlspecialchars($personal['data']['id']); ?>">
                 <!-- Name input -->
<div class="col-md-6 mb-3">
    <label class="badge bg-primary bg-gradient rounded-1">Fullname *</label>
    <input type="text" name="name" value="<?= htmlspecialchars($personal['data']['name']); ?>" 
           class="form-control text-muted" 
           <?= ($_SESSION['loggedInUser']['role'] === 'secretary' || $_SESSION['loggedInUser']['role'] === 'staff') ? '' : 'readonly'; ?>>
</div>

<!-- Address input -->
<div class="col-md-6 mb-3">
    <label class="badge bg-primary bg-gradient rounded-1">Address *</label>
    <input type="text" name="address" value="<?= htmlspecialchars($personal['data']['address']); ?>" 
           class="form-control text-muted" 
           <?= ($_SESSION['loggedInUser']['role'] === 'secretary' || $_SESSION['loggedInUser']['role'] === 'staff') ? '' : 'readonly'; ?>>
</div>


                

                     <!-- Length of Years input -->
                     <div class="col-md-6 mb-3">
                        <label for="length_of_years" class="badge bg-primary bg-gradient rounded-1">Length of Years *</label>
                        <select name="length_of_years" id="length_of_years" class="form-control jsselect">
                            <option value="">Select Years</option>
                            <?php for ($i = 1; $i <= 200; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i == $personal['data']['length_of_years']) ? 'selected' : '' ?>><?= $i ?> Year<?= ($i > 1) ? 's' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                      <!-- Count. No input -->
                      <div class="col-md-6 mb-3">
                        <label class="badge bg-primary bg-gradient rounded-1">Count. No*</label>
                        <input type="name" name="tracking_number" value="<?= htmlspecialchars($personal['data']['contnumber']); ?>" class="form-control text-muted" readonly>
                    </div>

<!-- Profile Image: Webcam Capture or File Upload -->
<div class="col-md-12 mb-2">
    <label for="profileImg" class="badge bg-primary bg-gradient rounded-1 mb-2">Profile Image</label>
    <div class="custom-file">
        <input type="file" name="profileImg" class="custom-file-input" id="profileImg">
        <label class="custom-file-label" for="profileImg">Choose profile ...</label>
    </div>
    <div class="row">

        <!-- Left: Preview Image Section -->
        <div class="col-md-6 ">
            <div class="text-center mt-4">
                <img src="../<?= htmlspecialchars($personal['data']['profile_image']); ?>" alt="profile image" id="profile-preview" width="320" height="240"> 
            </div>
        </div>

        <!-- Right: Webcam capture section -->
        <div id="webcam-container" class="col-md-6 text-center" style="display:none;">
            <video id="webcam-video" width="320" height="280" autoplay></video>
            <canvas id="webcam-canvas" width="320" height="280" style="display:none;"></canvas>
            <br>
            <button type="button" id="capture-image" class="btn btn-success mt-2">Capture Image</button>
        </div>

    </div>

    <!-- Center the Open Camera button -->
    <div class="d-flex justify-content-center mt-3">
        <button type="button" id="start-camera" class="btn btn-danger"><i class="fas fa-solid fa-camera"></i> <b> Open Camera</b></button>
    </div>
    
    <input type="hidden" name="capturedProfileImage" id="capturedProfileImage">
</div>  





                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatePersonalinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the personal data was not found, display an error message
                    echo '<h5>'.$personal['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<script>
    const startCameraBtn = document.getElementById('start-camera');
    const captureImageBtn = document.getElementById('capture-image');
    const webcamContainer = document.getElementById('webcam-container');
    const webcamVideo = document.getElementById('webcam-video');
    const webcamCanvas = document.getElementById('webcam-canvas');
    const capturedImageInput = document.getElementById('capturedProfileImage');
    const profilePreview = document.getElementById('profile-preview');

    let videoStream;

    // Start webcam stream
    startCameraBtn.addEventListener('click', async () => {
        try {
            videoStream = await navigator.mediaDevices.getUserMedia({ video: true });
            webcamVideo.srcObject = videoStream;
            webcamContainer.style.display = 'block';
            startCameraBtn.style.display = 'none';
            captureImageBtn.style.display = 'inline-block';
        } catch (err) {
            alert('Error accessing webcam: ' + err.message);
        }
    });

    // Capture image from webcam
    captureImageBtn.addEventListener('click', () => {
        webcamCanvas.getContext('2d').drawImage(webcamVideo, 0, 0, webcamCanvas.width, webcamCanvas.height);
        const dataUrl = webcamCanvas.toDataURL('image/png');
        profilePreview.src = dataUrl;
        capturedImageInput.value = dataUrl;  // Save captured image data to hidden field
    });
</script>

<?php include('includes/footer.php'); ?>
