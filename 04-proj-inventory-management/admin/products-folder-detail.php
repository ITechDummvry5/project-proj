<?php
include('includes/header.php');

// Validate and get category_id
if (isset($_GET['category_id']) && !empty($_GET['category_id'])): 
    $projectsId = intval($_GET['category_id']);
    
    // Fetch category name and block/lot details
    $projectsNameQuery = "SELECT name, block_lot FROM categories WHERE id = $projectsId LIMIT 1";
    $projectsNameResult = mysqli_query($conn, $projectsNameQuery);
    $projectsData = mysqli_fetch_assoc($projectsNameResult);
    $projectsName = htmlspecialchars($projectsData['name']);
    $projectsBlockLot = htmlspecialchars($projectsData['block_lot']);
    
    // Fetch products
    $products = getAllProductsfolder($projectsId);

    
?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
                <h4 class="my-1 fw-lighter fs-4">Material in "<?= $projectsName; ?>"</h4>
                <a href="products-folder" class="btn btn-primary float-end">Go Back</a>
            </div>

            <div class="card-body">
                <p><strong>Block & Lot: <?= $projectsBlockLot; ?></strong></p>
                <?php if (mysqli_num_rows($products) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="datatablesSimple">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                                        <th>Remark</th>
                                    <?php elseif ($_SESSION['loggedInUser']['role'] === 'admin'): ?>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = mysqli_fetch_assoc($products)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['id']); ?></td>
                                        <td><img src="../<?= htmlspecialchars($item['image']); ?>" style="width: 75px; height: 40px; object-fit: cover;"></td>
                                        <td><?= htmlspecialchars($item['name']); ?></td>
                                        <td><?= htmlspecialchars($item['quantity']); ?></td>
                                        <td>
    <?php 
    $description = $item['description'];
    preg_match('/\((.*?)\)/', $description, $matches);
    $extractedText = isset($matches[1]) ? $matches[1] : 'No text found';
    ?>
    <?= htmlspecialchars($extractedText); ?>
</td>

                                        <td>
                                            <?php if ($item['status'] == 1): ?>
                                                <span class="badge bg-danger">Out Of Stock</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary">In Stock</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M, Y h:i A', strtotime($item['created_at'])); ?></td>
                                        <?php if ($_SESSION['loggedInUser']['role'] === 'superadmin') : ?>
                                        <td class="border-start text-muted"><?= htmlspecialchars($item['premark']) ?></td>
                                    <?php endif; ?>

                                        <?php if ($_SESSION['loggedInUser']['role'] === 'admin') : ?>
                                            <td class="text-center">
                                                <a href="products-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#remarkModal<?= $item['id']; ?>">Remark</button>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#adjustQuantityModal<?= $item['id']; ?>">Adjust Quantity</button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>

                                    <!-- Modal for Remarks -->
                                    <div class="modal fade" id="remarkModal<?= $item['id']; ?>" tabindex="-1" aria-labelledby="remarkModalLabel<?= $item['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title" id="remarkModalLabel<?= $item['id']; ?>">Add Remark for <?= htmlspecialchars($item['name']); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="code.php" method="POST">
                                                        <div class="mb-3">
                                                            <label for="remarkInput<?= $item['id']; ?>" class="col-form-label">Remark:</label>
                                                            <textarea class="form-control" name="premark" id="remarkInput<?= $item['id']; ?>" placeholder="Enter remark..."><?= htmlspecialchars($item['premark']); ?></textarea>
                                                            <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="saveRemark" class="btn btn-primary">Save Remark</button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                                                    <!-- Modal for Quantity Adjustment -->
<div class="modal fade" id="adjustQuantityModal<?= $item['id']; ?>" tabindex="-1" aria-labelledby="adjustQuantityModalLabel<?= $item['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="adjustQuantityModalLabel<?= $item['id']; ?>">Adjust Quantity for <?= htmlspecialchars($item['name']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="stocktaking.php" method="POST">
                    <div class="mb-3">
                        <label for="quantityInput<?= $item['id']; ?>" class="col-form-label">Quantity:</label>
                        <input type="number" class="form-control" name="quantity" id="quantityInput<?= $item['id']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="reasonSelect<?= $item['id']; ?>" class="col-form-label">Reason:</label>
                        <select class="form-control" name="reason" id="reasonSelect<?= $item['id']; ?>">
                        <option value="lost">Lost</option>
                            <option value="expire">Expired</option>
                            <option value="damages">Damaged</option>
                            <option value="Adjustment/Shortage Reconciliation">Adjustment/Shortage Reconciliation</option>
                        </select>
                    </div>
                    <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="adjustQuantity" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
                  

                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No Materials found for this project.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php include('includes/footer.php'); ?>
