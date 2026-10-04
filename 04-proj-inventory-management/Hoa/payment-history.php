<?php
// Include database connection and header
include('hoainclude/header.php');

// Fetch all payment records
// $payment_history = getAll('payments'); // Assuming the table is named 'payments'
$payment_history = getAllDesc('payments', NULL, 'payment_date DESC');
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="fw-lighter fs-4">Payment History</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <h2></h2>
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th hidden>ID</th>
                            <th>Reference Number</th>
                            <th>Amount Paid</th>
                            <th>Payment Date</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($payment_history) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($payment_history)): ?>
                                <tr>
                                    <td hidden><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['ref_number']) ?></td>
                                    <td><?= number_format($row['amount_paid'], 2) ?></td>
                                    <td><span class='badge bg-white text-muted'><?= date('F j, Y, g:i A', strtotime($row['payment_date'])) ?></span></td>
                                    <td><?= htmlspecialchars($row['payment_mode']) ?></td>
                                    <td>
                                        <?php if (!empty($row['acknowledged'])): ?>
                                            <span class='badge bg-success'>Acknowledged</span>
                                        <?php else: ?>
                                            <span class='badge bg-danger'>Not Yet Acknowledged</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="receipt.php?receipt_id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-outline-primary btn-sm">View Receipt</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No payment history found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Close the database connection if needed
mysqli_close($conn);

// Include footer
include('hoainclude/footer.php');
?>
