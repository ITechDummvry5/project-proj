<?php include('includes/header.php'); ?>

<style>
 ::-webkit-scrollbar{ background: blue; width:0;}
</style>

<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="#">Add Contractor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
            <label for="c_name">Enter Company Name</label>
            <select class="form-select" id="c_name" required>
                <option value="">--Select Company--</option>
                <option value="Jp Luis Construction">Jp Luis Construction</option>
                <option value="Dexter Construction">Dexter Construction</option>
                <option value="Coxx Construction">Coxx Construction</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="c_phone">Enter Contractor Phone No.</label>
            <input type="tel" class="form-control" pattern="[0-9]{11}" minlength="11" maxlength="11" id="c_phone" required />
        </div>
        <div class="mb-3">
            <label for="c_email">Enter Contractor Email</label>
            <input type="text" class="form-control" id="c_email" required />
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveCustomer">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Withdrawal Process of Materials</h4>
     
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="orders-code.php" method="POST">
            <div class="row">
        <!-- Category Dropdown -->
        <div class="col-md-4 mb-3">
            <label>Select Category</label>
            <select name="category_id" id="categorySelect" class="form-select jsselect" required>
                <option value="">--Select Category--</option>
                <?php 
                // Fetch categories using getAll function
                $categories = getAll('categories'); // Assuming you have a categories table
                if ($categories) {
                    foreach ($categories as $category) {
                        // Combine name with block_lot for display
                        $displayName = htmlspecialchars($category['name']) . ' (Blk & Lot: ' . htmlspecialchars($category['block_lot']) . ')';
                        echo '<option value="' . $category['id'] . '">' . $displayName . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Products Dropdown -->
        <div class="col-md-4 mb-3">
            <label>Select materials order item</label>
            <select name="product_id" id="productSelect" class="form-select jsselect">
                <option value="">--Select Materials Items--</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Quantity</label>
            <input type="number" name="quantity" value="1" id="quantityInput" class="form-control">
        </div>

        <div class="col-md-12 mb-1 text-end">  
            <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
            <a href="order-create" class="btn btn-danger">Reset</a>
        </div>
    </div>
</form>
        </div>
    </div>

    <!-- Start order quantity -->
    <div class="card mt-3">
        <div class="card-header text-white bg-dark">  
            <?php 
            if (isset($_SESSION['productItems'])) {
                $sessionProducts = $_SESSION['productItems'];
                if (empty($sessionProducts)) {
                    unset($_SESSION['productItemIds']);
                    unset($_SESSION['productItems']);
                }
                ?> 
                <h4 class="mb-1 fw-lighter fs-4">Materials Quantity</h4> 
        </div>
        <div class="card-body" id="productArea">
            <div class="mb-3" id="productContent">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Material Name</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        foreach ($sessionProducts as $key => $item) : ?>
                        <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= $item['name'] ?></td>
                            <td>
                                <div class="input-group qtyBox">       
                                    <input type="hidden" value="<?= $item['product_id']; ?>" class="prodId" />
                                    <button class="input-group-text decrement">-</button>
                                    <input type="text" value="<?= $item['quantity'];?>" class="qty quantityInput"  disabled>
                                    <button class="input-group-text increment">+</button>
                                </div>
                            </td>
                            <td>
                                <?php
                                // Extract the portion inside parentheses at the end of the description
                                $description = $item['description'];
                                $unit = '';
                                if (preg_match('/\((.*?\(.*?\)|.*?)\)$/', $description, $matches)) {
                                    $unit = $matches[1]; // Extracts the unit, e.g., "Per Linear Meter (m)" or "Per Piece"
                                }
                                ?>
                                <?= $unit; ?>
                            </td>
                            <td>
                                <a href="#" 
                                   onclick="confirmDelete('order-item-delete-action.php?index=<?= $key; ?>'); return false;" 
                                   class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="mt-2 mb-1">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Enter Contractor Phone Number</label>
                            <input type="tel" id="cphone" minlength="11" maxlength="11" required class="form-control" value="">
                        </div>

                        <div class="col-md-6 text-end"><br /><hr />
                            <button type="button" class="col-md-12 btn btn-warning W-100 proceedToPlace fw-bolder fs-6" style="color:white">Proceed to place order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        } else { 
            echo '<h5>No items added</h5>';
        }
        ?> 
    </div>
</div>

<script src="../assets/js/sweetalert2.min.js"></script>
<script>
    document.getElementById('quantityInput').addEventListener('input', function(event) {
        // Remove any 'e' or 'E' character entered
        this.value = this.value.replace(/[eE]/g, '');
    });
</script>
<?php include('includes/footer.php'); ?>
