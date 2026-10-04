<!-- 4/25/2024 -->
<?php include('hoainclude/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Edit Announcement</h4>
            <a href="announcement-view" class="btn btn-primary float-end">Go Back</a>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="resident-code.php" method="POST" enctype="multipart/form-data">
                <?php 
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not Int</h5>';
                    return false;
                }
                $announcement = getById('announcement', $paramValue);
                if ($announcement) {
                    if ($announcement['status'] == 200) { 
                ?>

                <!-- Hidden Id -->
                <input type="hidden" name="announcement_id" value="<?= $announcement['data']['id']; ?>">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="badge bg-primary bg-gradient rounded-1 mb-2">Heading *</label>
                        <input type="text" name="heading" value="<?= $announcement['data']['heading']; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3 w-80">
                        <label class="badge bg-primary bg-gradient rounded-1 mb-2">Body *</label>
                        <textarea name="body" id="body" cols="10" rows="6" class="form-control" required><?= $announcement['data']['body']; ?></textarea>
                     
                    </div>

<!-- 
                    <div class="col-md-8 mb-2 mt-0">
                        <label for="" class="badge bg-primary bg-gradient rounded-1 mb-2">Images (up to 4) *</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                        <div class="image-wrapper"> -->
                            <?php 
                            // // Display existing images
                            // $existingImages = explode(',', $announcement['data']['image']);
                            // foreach ($existingImages as $image) {
                            //     echo '<img src="../' . $image . '" alt="img-announcement" style="height: 100%; width: 50%;">';
                            // }
                            ?>
                        <!-- </div>
                    </div>
                     -->

                    <div class="col-md-8 mb-2 mt-0">
    <label for="" class="badge bg-primary bg-gradient rounded-1 mb-2">Images (up to 3) *</label>
    <input type="file" name="images[]" class="form-control" multiple>
    <div class="image-grid">
        <?php 
        // Display existing images
        $existingImages = explode(',', $announcement['data']['image']);
        foreach ($existingImages as $image) {
            echo '<div class="image-item">
                    <img src="../' . $image . '" alt="img-announcement">
                  </div>';
        }
        ?>
    </div>
</div>


                    <div class="col-md-4 mt-4 text-end">
                        <button type="submit" name="updateAnnouncement" class="btn btn-primary">Update</button>
                    </div>
                </div>

                <?php 
                    } else {
                        echo '<h5>' . $announcement['message'] . '</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>Something went wrong</h5>';
                    return false;
                }
                ?>
            </form>

        </div>
    </div>
</div>

<style>
.image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 5px;
}

.image-item {
    overflow: hidden;
    width: 100%;
    height: 100px; /* Adjust height as needed */
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f0f0; /* Background for spacing */
    border-radius: 4px; /* Optional for rounded corners */
}

.image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures images are uniformly cropped */
    border-radius: 4px;
}
</style>

<?php include('hoainclude/footer.php'); ?>
