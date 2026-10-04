<?php
// Include database connection and header
include('hoainclude/header.php');

// Get receipt_id from URL and sanitize input
$receipt_id = isset($_GET['receipt_id']) ? intval($_GET['receipt_id']) : 0;

// Fetch receipt details including cost, acknowledgment status, and proof image
$result = $conn->query("
    SELECT payments.*, residents.rname 
    FROM payments 
    JOIN residents ON payments.resident_id = residents.id 
    WHERE payments.id = $receipt_id 
    LIMIT 1
");


if ($result && $result->num_rows === 0) {
    echo "<h2>Receipt not found.</h2>";
    include('hoainclude/footer.php');
    exit();
}

$receipt = $result->fetch_assoc();
?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Acknowledgement Receipt</h4>
            <a href="payment-history.php" class="btn btn-primary">Go back</a>
        </div>
        <div class="card-body px-4 py-4">
            <div class="row">
                <div class="col-md-8">
                    <p class="fs-5" style="line-height: 1.6;">
                        <h5 class="fw-1 fs-6 text-muted d-none">Receipt Number: <?= htmlspecialchars($receipt['id']) ?>
                        <br>Resident ID: <?= htmlspecialchars($receipt['resident_id']) ?>
                        <br></h5>
                        <h5 class="fw-1 fs-6 text-muted"><?= htmlspecialchars($receipt['ref_number']) ?></h5>

                        Resident <u><strong><?= htmlspecialchars($receipt['rname']) ?></strong></u> 
paid on <u><strong><?= date('F j, Y, g:i a', strtotime($receipt['payment_date'])) ?></strong></u> for an 
Amount Paid: <strong><u><?= number_format($receipt['amount_paid'], 2) ?></u></strong> via 
<u><strong><?= htmlspecialchars($receipt['payment_mode']) ?></strong></u>. 
After this payment, the resident's unpaid balance is 
<strong><u><?= number_format($receipt['remaining_balance'], 2) ?></u></strong> for 
<u><strong><?= htmlspecialchars($receipt['cash_bond_description']) ?></strong></u>. By fulfilling this obligation, the resident ensures compliance with
                        community regulations and contributes to the upkeep of shared facilities, promoting a safe and 
                        enjoyable environment for all residents.


                        <br><br>
                        <p class="fs-6 <?= !empty($receipt['acknowledged']) ? 'text-success' : 'text-danger' ?>" style="line-height: 1.5;">
                            Resident confirmation: 
                            <strong>
                                <?= !empty($receipt['acknowledged']) ? 'Acknowledged' : 'Not Yet Acknowledged' ?>
                            </strong>
                        </p>
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <h6>Proof of Payment:</h6>
                    <?php if (!empty($receipt['proof_image'])): ?>
                        <img src="../<?= htmlspecialchars($receipt['proof_image']) ?>" alt="Proof of Payment" class="img-fluid" style="max-width: 80%; max-height: 400px;">
                    <?php else: ?>
                        <p>No proof of payment uploaded.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!-- // var_dump($receipt); -->
 
<?php
// Close the database connection
mysqli_close($conn);

// Include footer
include('hoainclude/footer.php');
?>
