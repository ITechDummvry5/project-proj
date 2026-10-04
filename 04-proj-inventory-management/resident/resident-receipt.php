<?php include('rinclude/header.php'); ?>

<?php
// Get receipt_id from URL and sanitize input
$receipt_id = isset($_GET['receipt_id']) ? intval($_GET['receipt_id']) : 0;

// Fetch receipt details including cost, acknowledgment status, acknowledgment date, and proof image
$result = $conn->query("
    SELECT payments.*, residents.rname, payments.proof_image
    FROM payments 
    JOIN residents ON payments.resident_id = residents.id 
    WHERE payments.id = $receipt_id 
    LIMIT 1
");

if ($result && $result->num_rows === 0) {
    echo "<h2>Receipt not found.</h2>";
    exit();
}

$receipt = $result->fetch_assoc();
?>

<div class="container-fluid px-5 py-2">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="fw-bolder fs-5 mb-0">Acknowledgement Receipt</h4>
           
            <a class="btn btn-primary" href="resident-view-payment.php">Go Back</a>
        </div>
        <div id="BillingArea">
            <div class="card-body px-4 py-4">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="fw-1 fs-6 text-muted d-none">Receipt Number: <?= htmlspecialchars($receipt['id']) ?></h5>
                        <h5 class="fw-1 fs-6 text-muted"><?= htmlspecialchars($receipt['ref_number']) ?></h5>
                        <p>Resident <strong><?= htmlspecialchars($receipt['rname']) ?></strong> paid on <strong><?= date('F j, Y, g:i a', strtotime($receipt['payment_date'])) ?></strong> for an 
                        Amount Paid: <strong><u><?= number_format($receipt['amount_paid'], 2) ?></u></strong> via 
                        <strong><?= htmlspecialchars($receipt['payment_mode']) ?></strong>. 
                        After this payment, the resident's unpaid balance is <strong><u><?= number_format($receipt['remaining_balance'], 2) ?></u></strong> for  
                        <u><strong><?= htmlspecialchars($receipt['cash_bond_description']) ?></strong></u>. By fulfilling this obligation, the resident ensures compliance with
                        community regulations and contributes to the upkeep of shared facilities, promoting a safe and 
                        enjoyable environment for all residents.</p>

                        <div id="acknowledge-area">
                            <?php if (empty($receipt['acknowledged'])): ?>
                                <button type="button" id="acknowledge-button" class="btn btn-primary mt-4" data-id="<?= $receipt_id ?>">Acknowledge Receipt</button>
                            <?php else: ?>
                                <p class="text-success mt-4">
                                    Receipt has already been acknowledged on 
                                    <strong><?= date('F j, Y, g:i a', strtotime($receipt['acknowledged_date'])) ?></strong>.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <h6>Proof of Payment:</h6>
                        <?php if (!empty($receipt['proof_image'])): ?>
                            <img src="../<?= htmlspecialchars($receipt['proof_image']) ?>" alt="Proof of Payment" class="img-fluid" style="max-width: 100%; max-height: 250px;">
                        <?php else: ?>
                            <p>No proof of payment uploaded.</p>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            <button class="btn btn-danger float-end" onclick="downloadPDF()">PDF</button>
        </div>
    </div>
</div>

<?php mysqli_close($conn); ?>
<script>
document.getElementById('acknowledge-button')?.addEventListener('click', function () {
    const receiptId = this.dataset.id;

    // Send AJAX request to update acknowledgment
    fetch('acknowledge-receipt.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ receipt_id: receiptId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const acknowledgeArea = document.getElementById('acknowledge-area');
            acknowledgeArea.innerHTML = `
                <p class="text-success mt-4">
                    Receipt has been acknowledged on <strong>${data.acknowledged_date}</strong>.
                </p>
            `;
        } else {
            alert('Failed to acknowledge receipt. Please try again.');
        }
    })
    .catch(error => console.error('Error:', error));
});

function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const elementHTML = document.getElementById("BillingArea");

    html2canvas(elementHTML, { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL("image/jpeg");
        const pdfWidth = 297;
        const pdfHeight = 210;

        const docPDF = new jsPDF({
            orientation: "landscape",
            unit: "mm",
            format: "a4"
        });

        const aspectRatio = canvas.height / canvas.width;
        const imageHeight = pdfWidth * aspectRatio;

        docPDF.addImage(imgData, 'PNG', 10, 12, pdfWidth - 20, imageHeight);
        docPDF.save('Receipt_<?= htmlspecialchars($receipt['id']) ?>.pdf');
    }).catch(error => {
        console.error("Error generating PDF:", error);
    });
}
</script>
