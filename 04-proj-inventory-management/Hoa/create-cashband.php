<!-- create-cashband.php -->
<?php
include('hoainclude/header.php');
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="fw-lighter fs-4">Residents and Billing Status</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <?php alertMessage(); // Display alerts ?>
                <!-- Filter Dropdown -->
                <form method="GET" action="" class="row mb-3 align-items-end">
                    <div class="col-md-2">
                        <label for="status_filter" class="form-label">Filter by Status:</label>
                    </div>
                    <div class="col-md-4">
                        <select name="status" id="status_filter" class="form-select">
                            <option value="paid" <?= isset($_GET['status']) && $_GET['status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                            <option value="unpaid" <?= !isset($_GET['status']) || $_GET['status'] === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                            <option value="all" <?= !isset($_GET['status']) || $_GET['status'] === 'all' ? 'selected' : '' ?>>All</option>
                        </select>
                    </div>
                    <div class="col-md-2 float-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>

                <?php
                // Determine the filter status
                $status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

                // Build the query based on the filter
                $query = "SELECT * FROM residents";
                if ($status_filter === 'paid') {
                    $query .= " WHERE cost = 0";
                } elseif ($status_filter === 'unpaid') {
                    $query .= " WHERE cost > 0";
                }

                $query .= " ORDER BY rname";

                $residentResult = mysqli_query($conn, $query);
                ?>

                <!-- Table to Display Residents -->
                <?php if ($residentResult && mysqli_num_rows($residentResult) > 0): ?>
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Resident ID</th>
                                <th>Resident Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php while($resident = mysqli_fetch_assoc($residentResult)): ?>
        <tr>
            <td><?= htmlspecialchars($resident['id']) ?></td>
            <td><?= htmlspecialchars($resident['rname']) ?></td>
            <td><?= htmlspecialchars($resident['remail']) ?></td>
            <td><?= htmlspecialchars($resident['rphone']) ?></td>
            <td>
                <?php if ($resident['cost'] > 0): ?>
                    <span class="badge bg-danger">Unpaid</span>
                <?php else: ?>
                    <span class="badge bg-success">Paid</span>
                <?php endif; ?>
            </td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cashBondModal" 
                        data-id="<?= htmlspecialchars($resident['id']) ?>" 
                        data-name="<?= htmlspecialchars($resident['rname']) ?>"
                        data-cost="<?= htmlspecialchars($resident['cost']) ?>"
                        data-description="<?= htmlspecialchars($resident['cash_bond_description']) ?>"> <!-- Removed proof image -->
                    Add Bill
                </button>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>
                    </table>
                <?php else: ?>
                    <p>No residents found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Cash Bond Modal -->
<div class="modal fade" id="cashBondModal" tabindex="-1" aria-labelledby="cashBondModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="cashBondModalLabel">Add Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="cashBondForm" method="POST" action="resident-code.php" enctype="multipart/form-data">
                    <input type="hidden" name="resident_id" id="resident_id" value="">

                    <div class="mb-3">
                        <label for="current_cost" class="form-label badge bg-primary bg-gradient rounded-1">Current Cost</label>
                        <input type="number" class="form-control" name="current_cost" id="current_cost" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="new_cost" class="form-label badge bg-primary bg-gradient rounded-1">New Cost</label>
                        <input type="number" class="form-control" name="cost" id="new_cost">
                    </div>
                    <div class="mb-3">
                        <label for="cash_bond_description" class="form-label badge bg-primary bg-gradient rounded-1">Description</label>
                        <textarea class="form-control" name="cash_bond_description" id="cash_bond_description" required></textarea>
                    </div>

                    <button type="submit" name="addResidentCash" class="btn btn-primary float-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript to handle modal data population
var cashBondModal = document.getElementById('cashBondModal');
cashBondModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal
    var residentId = button.getAttribute('data-id');
    var currentCost = button.getAttribute('data-cost');
    var description = button.getAttribute('data-description');

    // Update the modal's content
    cashBondModal.querySelector('#resident_id').value = residentId;
    cashBondModal.querySelector('#current_cost').value = currentCost;
    cashBondModal.querySelector('#cash_bond_description').value = description;
});
</script>

<?php
include('hoainclude/footer.php');
?>
