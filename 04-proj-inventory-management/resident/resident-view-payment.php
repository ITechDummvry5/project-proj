<?php 
// Include the header and start the session
include('rinclude/header.php');

$resident_id = $_SESSION['rloggedInUser']['ruser_id'];
$query = "SELECT * FROM residents WHERE id = $resident_id ORDER BY rname";

$residentResult = mysqli_query($conn, $query);

$paymentQuery = "SELECT * FROM resident_pay WHERE resident_id = $resident_id AND status = 'pending' ORDER BY payment_date DESC";
$paymentResult = mysqli_query($conn, $paymentQuery);


?>
<section class="py-4">
    <div class="container px-5 card border-0 shadow-sm rounded-0 overflow-hidden">
        <h4 class="fw-bolder fs-5">My Billing Information</h4>
        <div class="card-body">
            <?php alertMessage(); ?>

            <!-- Responsive Table Container -->
            <?php if ($residentResult && mysqli_num_rows($residentResult) > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th hidden>Resident ID</th>
                                <th>Resident Name</th>
                                <th>Amount to Pay</th>
                                <th>Payment Description</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while($resident = mysqli_fetch_assoc($residentResult)): 
                            ?>
                                <tr>
                                    <td hidden><?= htmlspecialchars($resident['id']) ?></td>
                                    <td><?= htmlspecialchars($resident['rname']) ?></td>
                                    <td><?= htmlspecialchars($resident['cost']) ?></td>

                                    <td class="text-truncate" style="max-width: 150px;" data-bs-placement="bottom" data-bs-toggle="tooltip" title="<?= htmlspecialchars($resident['cash_bond_description']); ?>">
                                        <?php if ($resident['cost'] > 0): ?>
                                            <?= htmlspecialchars($resident['cash_bond_description']); ?>
                                        <?php else: ?>
                                            No Payment Description
                                        <?php endif; ?>
                                    </td>

                                    <td><?= htmlspecialchars($resident['rphone']) ?></td>
                                    <td>
                                        <?php if ($resident['cost'] > 0): ?>
                                            <span class="badge bg-danger">Unpaid</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
    <?php if ($resident['cost'] > 0): ?>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payModal<?= $resident['id'] ?>">
            Pay Online
        </button>
        <?php else: ?>
            No Payment Due                  
    <?php endif; ?>
</td></tr> 
                               <!-- Modal for Pay -->
<div class="modal fade" id="payModal<?= $resident['id'] ?>" tabindex="-1" aria-labelledby="payModalLabel<?= $resident['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="payModalLabel<?= $resident['id'] ?>">Pay Billing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="rcode.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="resident_id" value="<?= htmlspecialchars($resident['id']) ?>">
                    <input type="hidden" name="amount_to_pay" value="<?= htmlspecialchars($resident['cost']) ?>">
                    
                    <div class="mb-3">
                        <label for="gcash_number<?= $resident['id'] ?>" class="form-label">G-Reference Number</label>
                        <input type="text" name="gcash_number" class="form-control" id="gcash_number<?= $resident['id'] ?>" placeholder="REF- xxx xxx xxx xxx" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="amountPaid<?= $resident['id'] ?>" class="form-label">Amount Paid</label>
                        <input type="number" name="resident_amountpaid" class="form-control" id="resident_amountpaid<?= $resident['id'] ?>" placeholder="Enter amount paid" required min="0" max="<?= htmlspecialchars($resident['cost']) ?>" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="proofImage<?= $resident['id'] ?>" class="form-label">Upload Proof Image</label>
                        <input type="file" name="proof_image" class="form-control" id="proofImage<?= $resident['id'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Total Amount to Pay</label>
                        <p class="form-control-plaintext">₱ <?= number_format($resident['cost'], 2) ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_payment" class="btn btn-primary">Pay Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No resident found.</p>
            <?php endif; ?>

            <?php if ($paymentResult && mysqli_num_rows($paymentResult) > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Verify Reference Number</th>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
                                <th>Proof Image</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($payment = mysqli_fetch_assoc($paymentResult)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($payment['gcash_number']) ?></td>
                                    <td>₱ <?= number_format($payment['resident_amountpaid'], 2) ?></td>
                                    <td><?= date('d M, Y h:i A', strtotime($payment['payment_date'])) ?></td>
                                    <td>
                                        <?php if (!empty($payment['proof_image'])): ?>
                                            <a href="../<?= htmlspecialchars($payment['proof_image']) ?>" target="_blank">View Proof</a>
                                        <?php else: ?>
                                            No Proof Uploaded
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No pending payments found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php alertMessage(); ?>
<?php 
// Check if resident_id is set in the session
if (!isset($_SESSION['rloggedInUser']['ruser_id'])) {
    echo "<div class='alert alert-danger'>You must be logged in to view this page.</div>";

}

$resident_id = $_SESSION['rloggedInUser']['ruser_id']; // Get the logged-in resident ID

// Fetch payment records for the logged-in resident
$condition = "WHERE resident_id = $resident_id ORDER BY id DESC";
$payment_history = rgetAll('payments', '*', $condition);
?>
<section>
<div class="container px-5 card border-0 shadow rounded-0 overflow-hidden">
        <h4 class="fw-bolder fs-5">My Payment History</h4>
        <div class="card-body">
                <?php alertMessage(); // Assuming you have an alert function ?>

                <div class="table-responsive">
                    <table class="text-center table table-bordered table-hover" id="datatablesSimple">
                        <?php if ($payment_history && mysqli_num_rows($payment_history) > 0): ?>
                        <thead class="table-light">
                            <tr>
                                <th hidden>ID</th>
                                <th>Reference Number</th>
                                <th>Acknowledgment</th>
                                <th>Payment Date</th>
                                <th>Payment Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($payment_history)): ?>
                            <tr>
                                <td hidden><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['ref_number']) ?></td>
                                <td>
                                    <?php if (!empty($row['acknowledged'])): ?>
                                        <span class="badge bg-success">Acknowledged</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Not Yet Acknowledged</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d M, Y h:i A' , strtotime($row['payment_date'])); ?></td>
                                <td><?= htmlspecialchars($row['payment_mode']); ?></td>
                                <td>
                                    <a href='resident-receipt.php?receipt_id=<?= urlencode($row['id']); ?>' class='btn btn-outline-success btn-sm'>View Receipt</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <?php else: ?>
                        <tbody>
                            <tr>
                                <td colspan="5">No payment history found</td>
                            </tr>
                        </tbody>
                        <?php endif; ?> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Close the database connection
mysqli_close($conn);
?>
<script>
    // Tool tip
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>