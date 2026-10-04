<?php include('includes/header.php'); ?>

<div class="container-fluid px-4 mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 mb-0 fw-lighter fs-4">Edit Project</h4>
            <a href="categories" class="btn btn-primary float-end"> Go Back</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php 
                // checkparamId function
                $paramValue = checkParamId('id');

                if (!is_numeric($paramValue)) {
                    echo '<h5>' . $paramValue . '</h5>';
                    return false;     
                }

                $category = getById('categories', $paramValue);

                if ($category['status'] == 200) {
                ?>
                <!-- Hidden id -->
                <input type="hidden" name="categoryId" value="<?= $category['data']['id']; ?>">
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bolder fs-6 mb-2">Model *</label>
                        <select name="name" class="form-control form-select" required>
                            <option value="">Select a model</option>
                            <option value="model1" <?= $category['data']['name'] == 'model1' ? 'selected' : ''; ?>>model1</option>
                            <option value="model2" <?= $category['data']['name'] == 'model2' ? 'selected' : ''; ?>>model2</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="block_lot" class="form-label fw-bolder fs-6 mb-2">Block/Lot No. *</label>
                        <input type="text" class="form-control" id="block_lot" name="block_lot" readonly required placeholder="Enter Block and Lot No." value="<?= htmlspecialchars($category['data']['block_lot']); ?>">
                    </div>

                    <!-- Floor Area -->
                    <div class="col-md-12 mb-3">
                        <label for="floorarea" class="form-label fw-bolder fs-6 mb-2">Description *</label>
                        <textarea class="form-control" id="floorarea" name="floorarea" required rows="6" placeholder="" maxlength="350" style="resize: none;"><?= htmlspecialchars($category['data']['floorarea']); ?></textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="checkbox" for="status-checkbox">
                            <input type="checkbox" name="status" value="1" <?= $category['data']['status'] == true ? 'checked' : ''; ?> id="status-checkbox">
                            <span class="checkmark"></span>
                            <span class="label">
                                <span class="">
                                    <span class="badge bg-success ms-1">Completed</span>
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="col-md-6 mb-1 mt-5 text-end"> <!--number of column margin 3-->
                        <button type="submit" name="UpdateCategory" class="btn btn-primary">Update</button>
                    </div>
                </div> 
                <?php 
                } else {
                    echo '<h5>' . $category['message'] . '</h5>';
                }
                ?>  
            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>
