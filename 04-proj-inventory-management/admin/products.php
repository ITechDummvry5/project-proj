<?php 
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header text-white bg-dark">
            <div class="row">
                <div class="col-md-5">
                    <h4 class="my-1 fw-lighter fs-4">Material</h4>
                </div>

                <?php if ($_SESSION['loggedInUser']['role'] === 'admin') : ?>
                    <div class="col-md-7 text-end">
                        <a href="products-create.php" class="btn btn-primary float-end">Add Material</a>
                      

                    </div>
                <?php endif; ?>
            </div>
        </div>
            <!-- filter categories -->
  <!-- filter categories -->
<form id="categoryFilterForm" action="" method="GET">
    <div class="row g-1 mt-3 px-3">
        <div class="col-md-4">
            <!-- Category filter (project) -->
            <select name="category_id" class="form-control jsselect" id="categoryFilter">
                <option value="">Select Project</option>
                <?php
                // Fetch categories from the database including block_lot
                $categoryQuery = "SELECT id, name, block_lot FROM categories";
                $categoryResult = mysqli_query($conn, $categoryQuery);

                if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                    while ($category = mysqli_fetch_assoc($categoryResult)) {
                        $selected = isset($_GET['category_id']) && $_GET['category_id'] == $category['id'] ? 'selected' : '';
                        // Combine name with block_lot for display
                        $displayName = htmlspecialchars($category['name']) . ' (Blk & Lot: ' . htmlspecialchars($category['block_lot']) . ')';
                        echo "<option value='{$category['id']}' $selected>{$displayName}</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <!-- Material Category filter -->
            <select name="materialcategory" class="form-control jsselect" id="materialCategoryFilter">
                <option value="">Select Material Category</option>
                <option value="Concreating" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Concreating' ? 'selected' : ''; ?>>Concreating</option>
                <option value="Forms" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Forms' ? 'selected' : ''; ?>>Forms</option>
                <option value="Roof Framing" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Roof Framing' ? 'selected' : ''; ?>>Roof Framing</option>
                <option value="Roof Panels Long Span" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Roof Panels Long Span' ? 'selected' : ''; ?>>Roof Panels Long Span</option>
                <option value="Windows" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Windows' ? 'selected' : ''; ?>>Windows</option>
                <option value="Lockset" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Lockset' ? 'selected' : ''; ?>>Lockset</option>
                <option value="Waterline" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Waterline' ? 'selected' : ''; ?>>Waterline</option>
                <option value="SewerLine" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'SewerLine' ? 'selected' : ''; ?>>SewerLine</option>
                <option value="Electrical" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Electrical' ? 'selected' : ''; ?>>Electrical</option>
                <option value="Plumbing Fixture" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Plumbing Fixture' ? 'selected' : ''; ?>>Plumbing Fixture</option>
                <option value="Painting Works" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Painting Works' ? 'selected' : ''; ?>>Painting Works</option>
                <option value="Ceiling Works" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Ceiling Works' ? 'selected' : ''; ?>>Ceiling Works</option>
                <option value="Tile Works" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'Tile Works' ? 'selected' : ''; ?>>Tile Works</option>
                <option value="HandDrills & Railing Stairs" <?php echo isset($_GET['materialcategory']) && $_GET['materialcategory'] == 'HandDrills & Railing Stairs' ? 'selected' : ''; ?>>HandDrills & Railing Stairs</option>
            </select>
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Apply Filter</button>
            <a href="products.php" class="btn btn-danger me-5">Reset</a>
        </div>
    </div>
</form>
                <!-- end filter categories -->
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <?php
  
   // Function to fetch products based on user role and selected category, block, lot, and material category
   function getAllProducts($categoryId = '', $block = '', $lot = '', $materialCategory = '')
   {
       global $conn;
       $role = $_SESSION['loggedInUser']['role'];  // Get logged-in user role
   
       // Prepare query based on category, block, lot, material category, and role
       $query = "SELECT * FROM products WHERE 1=1 ";
       
       if ($categoryId) {
           $query .= "AND category_id = " . intval($categoryId) . " ";
       }
   
       if ($block) {
           $query .= "AND block LIKE '%" . mysqli_real_escape_string($conn, $block) . "%' ";
       }
   
       if ($lot) {
           $query .= "AND lot LIKE '%" . mysqli_real_escape_string($conn, $lot) . "%' ";
       }
   
       if ($materialCategory) {
           $query .= "AND materialcategory = '" . mysqli_real_escape_string($conn, $materialCategory) . "' ";
       }
   
       $query .= "ORDER BY id ASC";
   
       // Execute the query directly
       $result = mysqli_query($conn, $query);
       return $result;
   }
   
   // Fetch products based on selected filters
   $categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : '';
   $block = isset($_GET['block']) ? $_GET['block'] : '';
   $lot = isset($_GET['lot']) ? $_GET['lot'] : '';
   $materialCategory = isset($_GET['materialcategory']) ? $_GET['materialcategory'] : '';
   $products = getAllProducts($categoryId, $block, $lot, $materialCategory);
   
   



            if (!$products) {
                echo '<h4 class="fw-bolder fs-4">Error fetching products!</h4>';
                return false;
            }
            ?>
            <!-- Display Products Table -->
            <?php if (mysqli_num_rows($products) > 0) : ?>
                <div class="table-responsive">
                    <table class="text-center " id="datatablesSimple">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <?php if ($_SESSION['loggedInUser']['role'] === 'superadmin') : ?>
                                  
                                    <th class="border-start">Material Remark</th>
                                <?php endif; ?>
                                <?php if ($_SESSION['loggedInUser']['role'] === 'admin') : ?>
                                    <th class="text-center">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = mysqli_fetch_assoc($products)) : ?>
                                <tr class="<?= $item['quantity'] == 0 ? 'table-danger' : ($item['quantity'] <= 10 ? 'table-primary' : '') ?>">
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><?= htmlspecialchars($item['materialcategory']) ?></td>
                                    <td>
                                        <img src="../<?= htmlspecialchars($item['image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="product" />
                                    </td>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td>
    <?php 
    $description = $item['description'];
    preg_match('/\((.*?)\)/', $description, $matches);
    $extractedText = isset($matches[1]) ? $matches[1] : 'No text found';
    ?>
    <?= htmlspecialchars($extractedText); ?>
</td>
                                    <td>
                                        <?php if ($item['status'] == 1) : ?>
                                            <span class="badge bg-danger">Out Of Stock</span>
                                        <?php else : ?>
                                            <span class="badge bg-primary">In Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M, Y h:i A', strtotime($item['created_at']));  ?></td>

                                    
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
                                <!-- End of Modal -->

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
            <?php else : ?>
                <h5 class="fw-bolder fs-4">No Material Found</h5>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../assets/js/sweetalert2.min.js"></script>


<script>
    // Ensure that the script is applied after the page is loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Select all input fields for quantity adjustments
        const quantityInputs = document.querySelectorAll('[id^="quantityInput"]');

        quantityInputs.forEach(function(input) {
            input.addEventListener('input', function(event) {
                // Prevent 'e' or 'E' from being entered
                this.value = this.value.replace(/[eE]/g, '');
            });
        });
    });
</script>
<!-- Include footer -->
<?php include('includes/footer.php'); ?>
