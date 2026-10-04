<?php include('hoainclude/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Resident Billing</h4>
            <a href="create-cashband.php" class="btn btn-primary">Add Bill</a>
        </div>

        <div class="card-body">
            <?php alertMessage(); // Display alerts 
            ?>
            <form action="resident-code.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="mb-2">Select Resident Bill</label>
                        <select name="id_resident" class="form-select" required>
                            <option value="">--Select Resident--</option>
                            <?php
                            $residentbill = getAll('residents');
                            if ($residentbill && mysqli_num_rows($residentbill) > 0) {
                                foreach ($residentbill as $residentItem) {
                                    if ($residentItem['cost'] > 0) { // Only show residents with unpaid costs
                                        echo '<option value="' . htmlspecialchars($residentItem['id']) . '">' . htmlspecialchars($residentItem['rname']) . '</option>';
                                    }
                                }
                            } else {
                                echo '<option value="">No Resident Found</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="mb-2">Amount to Pay</label>
                        <input type="number" class="form-control" name="amount_paid" id="amount_paid" min="0" step="0.01" required />
                    </div>

                    <div class="col-md-12 text-end mt-3">
                        <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                        <a href="hoa-cashier.php" class="btn btn-danger">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Displaying Resident Orders -->
    <div class="card mt-3">
        <div class="card-header text-white bg-dark">
            <h5 class="fw-lighter fs-4">Process Resident Billing</h5>
        </div>
        <div class="card-body" id="residentArea">
            <?php if (isset($_SESSION['residentItems']) && !empty($_SESSION['residentItems'])): ?>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Resident Name</th>
                                <th>Total Amount Due</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($_SESSION['residentItems'] as $key => $item):
                                // Fetch the oldest pending payment for this resident
                                $query = "SELECT proof_image, status, gcash_number, resident_amountpaid, payment_date 
                                          FROM resident_pay 
                                          WHERE resident_id = " . $item['id_resident'] . " 
                                          AND status = 'pending' 
                                          ORDER BY payment_date ASC LIMIT 1";
                                $result = mysqli_query($conn, $query);
                                $proof_image = null;
                                $status = 'unpaid';
                                $gcash_number = null;
                                $resident_amountpaid = 0.00;
                                $payment_date = null;

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $payment = mysqli_fetch_assoc($result);
                                    $proof_image = $payment['proof_image'];
                                    $status = $payment['status'];
                                    $gcash_number = $payment['gcash_number'];
                                    $resident_amountpaid = $payment['resident_amountpaid'];
                                    $payment_date = $payment['payment_date'];
                                }

                                // Calculate remaining balance
                                $remaining_balance = $item['cost'] - (isset($item['amount_paid']) ? $item['amount_paid'] : 0);
                            ?>
                                <tr class="text-center">
                                    <td><?= htmlspecialchars($i++) ?></td>
                                    <td><?= htmlspecialchars($item['rname']) ?></td>
                                    <td><?= number_format($item['cost'], 2) ?></td>
                                    <td>
                                        <input type="number" disabled class="form-control text-center" name="amount_paid[<?= htmlspecialchars($key) ?>]" value="<?= isset($item['amount_paid']) ? $item['amount_paid'] : 0 ?>" step="0.01" min="0" />
                                    </td>
                                    <td><?= number_format($remaining_balance, 2) ?></td>
                                    <td>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal<?= htmlspecialchars($key) ?>">
                                        View Details
                                        </button>
                                        <a href="#" class="btn btn-danger" onclick="confirmDelete('remove-item-cashband-action.php?index=<?= htmlspecialchars($key); ?>')">Cancel</a>
                                    </td>
                                </tr>

                                <!-- Details Modal -->
                                <!-- Details Modal -->
                                <div class="modal fade" id="detailsModal<?= htmlspecialchars($key) ?>" tabindex="-1" aria-labelledby="detailsModalLabel<?= htmlspecialchars($key) ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title" id="detailsModalLabel<?= htmlspecialchars($key) ?>">Details for <?= htmlspecialchars($item['rname']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>Description Issue<input type="text" class="form-control mb-2" value="<?= htmlspecialchars($item['cash_bond_description']) ?: 'No description provided.' ?>" readonly /></div>
                                                <div>G-Ref Number<input type="text" class="form-control mb-2" value="<?= htmlspecialchars($gcash_number) ?: 'N/A' ?>" readonly /></div>
                                                <div>Amount Paid <input type="text" class="form-control mb-2" value="₱ <?= number_format($resident_amountpaid, 2) ?>" readonly /></div>
                                                <div>Payment Date<input type="text" class="form-control mb-2" value="<?= htmlspecialchars($payment_date) ?: 'N/A' ?>" readonly /></div>
                                                <div>Proof Image</strong>
                                                    <?php if ($proof_image): ?>
                                                        <img src="../<?= htmlspecialchars($proof_image) ?>" alt="Proof Image" class="img-fluid mb-2" style="max-width: 100%; height: auto;" />
                                                    <?php else: ?>
                                                        <input type="text" class="form-control mb-2" value="No proof image available." readonly />
                                                    <?php endif; ?>
                                                </div>
                                                <div>Total Amount to Pay <p class="form-control-plaintext mb-2">₱ <?= number_format($item['cost'], 2) ?></p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Payment Method Section -->
                <h6>Payment Method</h6>
                <div class="mt-2 mb-3">
                    <hr />
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="mb-1">Select Payment Method</label>
                            <select id="payment_mode" name="payment_mode" class="form-select" required>
                                <option value="">--Select Method--</option>
                                <option value="Cash Payment">Cash Payment</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>
                        </div>

                        <div class="col-md-6 text-end">
                            <br />
                            <button type="button" class="col-md-12 btn btn-warning proceedToPayment" style="color:white">Confirm Payment</button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <h5>No Resident Selected</h5>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
<div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Pending Payment</h4>
        </div>
    <?php
   // SQL query to fetch payments with resident name, proof_image, and status of pending
   $query = "SELECT 
    r.rname AS rname, 
    rp.gcash_number, 
    rp.resident_amountpaid, 
    rp.payment_date, 
    rp.proof_image, 
    rp.status
FROM 
    resident_pay rp
JOIN 
    residents r 
ON 
    rp.resident_id = r.id
WHERE 
    rp.proof_image IS NOT NULL AND rp.status = 'pending';
";


    $paymentResult = mysqli_query($conn, $query);

    if ($paymentResult && mysqli_num_rows($paymentResult) > 0): ?>
     <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
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
                            <td><?= htmlspecialchars($payment['rname']) ?: 'N/A' ?></td>
                            <td><?= htmlspecialchars($payment['gcash_number']) ?: 'N/A' ?></td>
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
                                <span class="badge bg-warning text-white"><?= ucfirst($payment['status']) ?></span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
     
        <h5 class="mb-4 px-3 mt-3">No pending payments</h5>
    <?php endif; ?>
     </div>
        </div>
<?php include('hoainclude/footer.php'); ?>