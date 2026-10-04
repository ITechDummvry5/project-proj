<?php 
include('includes/header.php'); 

// Retrieve form data from the session if it exists
$name = $_SESSION['form_data']['name'] ?? '';
$address = $_SESSION['form_data']['address'] ?? '';

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
    unset($_SESSION['error_message']);
}
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white">
            <h4 class="my-1 fw-lighter fs-4 ">Personal Information</h4>
            <a href="personal-view.php" class="btn btn-primary float-end">View Records</a> 
        </div>
        <div class="card-body">
            <!-- Display alert messages if there are any -->
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data"> <!-- Added enctype for file upload -->

<div class="row text-gray-900">
    <div class="col-md-6 mb-2">
        <label for="name" class="badge bg-primary bg-gradient rounded-1 mb-2">Fullname</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name); ?>" class="form-control" required>
    </div>

    <div class="col-md-6 mb-2">
        <label for="address" class="badge bg-primary bg-gradient rounded-1 mb-2">Sitio/Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($address); ?>" class="form-control" required>
    </div>

        <!-- Dropdown for Length of Years -->
        <div class="col-md-12 mb-2">
        <label for="length_of_years" class="badge bg-primary bg-gradient rounded-1 mb-2 ">Length of Years</label>
        <select name="length_of_years" id="length_of_years" class="form-control jsselect" required>
            <option value="">Select Years</option>
            <?php for ($i = 1; $i <= 200; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?> Year<?= ($i > 1) ? 's' : '' ?></option>
            <?php endfor; ?>
        </select>
    </div>



    <div class="col-md-12 mb-2">
        <label for="profileImg" class="badge bg-primary bg-gradient rounded-1 mb-2">Upload Image or Capture</label>
        <div class="custom-file">
            <!-- Hidden file input for image upload -->
            <input type="file" name="profileImg" class="custom-file-input" id="profileImg" accept="image/*" style="display:none;" onchange="previewImage(event)">
            <label class="custom-file-label" for="profileImg" onclick="document.getElementById('profileImg').click()">Choose profile or capture...</label>
        </div>
    </div>

    <!-- Button to open the camera -->
    <div class="col-md-6 mb-2">
        <button type="button" id="openCamera" class="btn btn-danger"><i class="fas fa-solid fa-camera"></i> <b> Open Camera</b></button>
    </div>

    <!-- Video for camera feed -->
    <div class="col-md-6 mb-2" id="cameraContainer" style="display: none;">
        <video id="video" width="100%" autoplay></video>
        <button type="button" id="captureButton" class="btn btn-secondary mt-3">Capture Photo</button>
    </div>
    <canvas id="canvas" style="display: block;"></canvas>
    <input type="hidden" name="capturedImage" id="capturedImage" />

</div>
<div class="mt-3 col-md-12 text-right">
    <button type="submit" name="personalInfo" class="btn btn-primary">Submit</button>
</div>
</form>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
// Open camera and display video feed
function openCamera() {
    document.getElementById('cameraContainer').style.display = 'block';
    document.getElementById('profileImg').style.display = 'none'; // Hide file upload when camera is open
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
            let video = document.getElementById('video');
            video.srcObject = stream;
            window.stream = stream; // To stop the stream later
        })
        .catch(function (err) {
            alert("Camera not accessible. Please allow camera access.");
            console.error(err);
        });
}

// Trigger camera access when 'Open Camera' button is clicked
document.getElementById('openCamera').addEventListener('click', openCamera);

// Capture the image from the video feed
document.getElementById('captureButton').addEventListener('click', function () {
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let context = canvas.getContext('2d');

    // Ensure the video feed has been initialized
    if (video.videoWidth && video.videoHeight) {
        // Set the canvas size to match the video feed
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw the current frame from the video to the canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Get the image data URL
        let imageData = canvas.toDataURL('image/png');
        
        // Set the captured image to the hidden profileImg input field
        document.getElementById('capturedImage').value = imageData;

        // Stop the camera feed after capturing
        if (window.stream) {
            window.stream.getTracks().forEach(track => track.stop());
        }

        // Hide the camera feed after capturing
        document.getElementById('cameraContainer').style.display = 'none';
    } else {
        alert("No video feed found. Please try again.");
    }
});

// Preview the uploaded image (optional)
function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function () {
        let output = document.createElement('img');
        output.src = reader.result;
        output.style.width = '100%';
        document.getElementById('cameraContainer').appendChild(output);
    }
    reader.readAsDataURL(event.target.files[0]);

    // Hide the camera when an image is uploaded
    document.getElementById('cameraContainer').style.display = 'none';
}

</script>
