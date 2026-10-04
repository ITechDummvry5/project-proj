<?php 
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header text-white bg-dark">
            <div class="row">
                <div class="col-md-5">
                    <h4 class="my-1 fw-lighter fs-4">Archived Products</h4>
                </div>
            </div>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            // Function to fetch archived products
            function getArchivedProducts()
            {
                global $conn;
                $query = "SELECT * FROM products WHERE is_archived = 1 ORDER BY id ASC";
                $result = mysqli_query($conn, $query);
                return $result;
            }

            // Fetch all archived products
            $archivedProducts = getArchivedProducts();

            if (!$archivedProducts) {
                echo '<h4 class="fw-bolder fs-4">Error fetching archived products!</h4>';
                return false;
            }
            ?>

            <!-- Display Archived Products Table -->
            <?php if (mysqli_num_rows($archivedProducts) > 0) : ?>
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <?php if ($_SESSION['loggedInUser']['role'] === 'admin') : ?>
                                    <th class="text-center">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($archivedProducts as $item) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td>
                                        <img src="../<?= htmlspecialchars($item['image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="product" />
                                    </td>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td>
                                        <?php if ($item['status'] == 1) : ?>
                                            <span class="badge bg-danger">Out Of Stock</span>
                                        <?php else : ?>
                                            <span class="badge bg-primary">In Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'admin') : ?>
                                        <td class="text-center">
                                        <a  href="#" 
             onclick="confirmRestore('products-restore-action?id=<?= $item['id']; ?>'); return false;" 
             class="btn btn-archive btn-sm">Restore</a>
                                        <a hidden href="#" onclick="confirmDelete('products-delete-action?id=<?= $item['id']; ?>'); return false;" class="btn btn-danger btn-sm">Delete</a>
                                         
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <h5 class="fw-bolder fs-4">No archived Material found</h5>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../assets/js/sweetalert2.min.js"></script>

<!-- Include footer -->
<?php include('includes/footer.php'); ?>


