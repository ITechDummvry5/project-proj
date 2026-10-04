// hoa.custom.js
$(document).ready(function () {
 

    function calculateTotalCost() {
        let totalCost = 0;
        $('.cost').each(function() {
            let cost = parseFloat($(this).text().replace(/[^0-9.-]+/g, ""));
            if (!isNaN(cost)) {
                totalCost += cost;
            }
        });
        return totalCost;
    }

    function calculateTotalPaid() {
        let totalPaid = 0;
        $('input[name^="amount_paid"]').each(function() {
            let paid = parseFloat($(this).val());
            if (!isNaN(paid)) {
                totalPaid += paid;
            }
        });
        return totalPaid;
    }

    function updateRemainingBalances() {
        $('.remaining-balance').each(function() {
            let $row = $(this).closest('tr');
            let cost = parseFloat($row.find('.cost').text().replace(/[^0-9.-]+/g, ""));
            let amountPaid = parseFloat($row.find('input[name^="amount_paid"]').val());
            let remainingBalance = cost - (isNaN(amountPaid) ? 0 : amountPaid);
            $(this).text(remainingBalance.toFixed(2));
        });
    }

    $(document).on('click', '.proceedToPayment', function () {
        let $button = $(this);
        let payment_mode = $('#payment_mode').val();
        let totalCost = calculateTotalCost();
        let totalPaid = calculateTotalPaid();

        if (payment_mode === '') {
            Swal.fire("Select Payment Method", "Please select a  payment method", "warning");
            return false;
        }

        if (totalPaid < totalCost) {
            Swal.fire("Insufficient Payment", "The total amount paid is less than the total cost.", "warning");
            return false;
        }

        let originalText = $button.html();
        $button.html('Processing... <span class="loading-spinner"></span>');
        $button.prop('disabled', true);

        let data = {
            'proceedToPaymentCashband': true,
            'payment_mode': payment_mode
        };

        $.ajax({
            type: "POST",
            url: "resident-code.php",
            data: data,
            success: function (response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status === 200) {
                        alertify.success(res.message);
                        Swal.fire({
                            title: 'Success!',
                            text: 'Payment has been processed successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "hoa-cashier.php";
                        });
                    } else {
                        alertify.error(res.message);
                    }
                } catch (e) {
                    Swal.fire("Error", "Failed to parse server response.", "error");
                }
            },
            error: function() {
                Swal.fire("Error", "An error occurred while processing your request. Please try again.", "error");
            },
            complete: function() {
                $button.html(originalText);
                $button.prop('disabled', false);
            }
        });
    });

    $(document).on('input', 'input[name^="amount_paid"]', function () {
        updateRemainingBalances();
    });

    updateRemainingBalances();
});

$(document).ready(function () {
    // Initialize Select2 for both selects
    $('.form-select').select2();

    const blockSelect = $('#blockSelect');
    const lotSelect = $('#lotSelect');

    // Define the starting and ending lot numbers for each block
    const blockLotRanges = {
        1: { start: 1, end: 23 }, // Blk 1 has lots 1 to 35
        2: { start: 1, end: 54 }, // Blk 2 has lots 36 to 44
        3: { start: 1, end: 40 }, // Blk 3 has lots 1 to 26
        4: { start: 1, end: 24 }  // Blk 4 has lots 1 to 44
    };

    blockSelect.on('change', function () {
        const selectedBlock = $(this).val();
        const { start, end } = blockLotRanges[selectedBlock] || { start: 0, end: 0 };

        // Clear current options in lot select
        lotSelect.empty();
        lotSelect.append('<option value="">Select Lot</option>');

        // Populate new options for lots based on the selected block
        for (let i = start; i <= end; i++) {
            lotSelect.append('<option value="' + i + '">Lot ' + i + '</option>');
        }
    });
});









