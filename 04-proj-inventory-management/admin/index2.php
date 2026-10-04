<?php
include('includes/header.php');

date_default_timezone_set('Asia/Manila');

$totalCategories = getCountComplete('categories');
$totalProducts = getCount('products');
$totalAdmins = $_SESSION['loggedInUser']['role'] === 'superadmin' ? getCount('admins') : 0;
$totalContractors = getCountComplete('customers');
$totalOrders = getCountOnly('orders');
$recentActivitiesstockman = getRecentActivitiesStockman(5);
?>

<div class="container-fluid px-4">
    <div class="row mb-3 mt-4">
        <!-- Main Dashboard Stats -->
        <div class="col-md-8">
            <h1 class="mb-3 fw-bold">Dashboard</h1>
            <?php alertMessage(); ?>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <!-- Total Categories stockBox -->
                <div class="col-md-6 mb-2">
                <a href="categories" class="text-white text-decoration-none">
                    <div class="stockbox text-center p-3">
                        <div class="img-section">
                            <img src="../assets/image/undraw_stockman_3.svg" alt="Category Image">
                        </div>
                        <div class="stockbox-desc">
                            <div class="stockbox-header">
                                <div class="fw-bold stockbox-title">Total Project</div>
                            </div>
                            <div class="stockbox-time"><?= $totalCategories; ?></div>
                        </div>
                    </div>
                    </a>
                </div>

                <!-- Total Products stockBox -->
                <div class="col-md-6 mb-2">
                    <a href="products" class="text-white text-decoration-none">
                    <div class="stockbox text-center p-3">
                        <div class="img-section">
                            <img src="../assets/image/undraw_stockman_2.svg" alt="Products Image">
                        </div>
                        <div class="stockbox-desc">
                            <div class="stockbox-header">
                                <div class="fw-bold stockbox-title">Total Material</div>
                            </div>
                            <div class="stockbox-time"><?= $totalProducts; ?></div>
                        </div>
                    </div>
                    </a>
                </div>

                <!-- Total Contractors stockBox -->
                <div class="col-md-6 mb-2">
                <a href="customers" class="text-white text-decoration-none">
                    <div class="stockbox text-center p-3">
                        <div class="img-section">
                            <img src="../assets/image/undraw_stockman_4.svg" alt="Contractor Image">
                        </div>
                        <div class="stockbox-desc">
                            <div class="stockbox-header">
                                <div class="fw-bold stockbox-title">Total Pending Contractor</div>
                            </div>
                            <div class="stockbox-time"><?= $totalContractors; ?></div>
                        </div>
                    </div>
                    </a>
                </div>

                <!-- Total Orders stockBox -->
                <div class="col-md-6 mb-2">
                <a href="orders" class="text-white text-decoration-none">
                    <div class="stockbox text-center p-3">
                        <div class="img-section">
                            <img src="../assets/image/undraw_stockman_1.svg" alt="Admin Image">
                        </div>
                        <div class="stockbox-desc">
                            <div class="stockbox-header">
                                <div class="fw-bold stockbox-title">Total Booked Orders</div>
                            </div>
                            <div class="stockbox-time"><?= $totalOrders; ?></div>
                        </div>
                    </div>
                </div>
</a>
            </div>

          
        </div>

        <!-- Overview Section -->
        <div class="col-md-4 mt-4"> <!-- Adjust margin-top if needed -->
            <div class="card p-3 mb-2 border-0 shadow-sm rounded">
                <h5 class="fw-bold fs-4">Overview</h5>
                <canvas id="overviewPieChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/chart.min.js"></script>
<script>
    const overviewPieChartCtx = document.getElementById('overviewPieChart').getContext('2d');
    const labels = ['Project', 'Material', 'Orders', 'Contractors'];
    const data = [
        <?= $totalCategories; ?>,
        <?= $totalProducts; ?>,
        <?= $totalOrders; ?>,
        <?= $totalContractors; ?>
    ];

    if (<?= $_SESSION['loggedInUser']['role'] === 'superadmin' ? 'true' : 'false'; ?>) {
        labels.push('Admins');
        data.push(<?= $totalAdmins; ?>);
    }

    new Chart(overviewPieChartCtx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#f9f871', '#ea2e69', '#2b7de0', '#8090bc', '#f5f9ff']
            }]
        }
    });
</script>

  <!-- Recent Activities Section -->
<!-- Recent Activities Section -->
<?php if ($_SESSION['loggedInUser']['role'] === 'admin'): ?>
    <div class="recent-activities mt-4 px-4">
        <h5 class="fw-bold fs-4">Recent Activities</h5>
        <ul class="list-group">
            <?php foreach ($recentActivitiesstockman as $activitystockman): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($activitystockman['type']); ?>:</strong>
                        <?= htmlspecialchars($activitystockman['detail']); ?>
                        
                        <?php if ($activitystockman['type'] === 'Material_Added'): ?>
                            (Quantity Added: <?= htmlspecialchars($activitystockman['quantity_added']); ?>)
                            By: <?= htmlspecialchars($activitystockman['added_by']); ?>
                        <?php elseif ($activitystockman['type'] === 'Category_Created'): ?>
                            (Block / Lot: <?= htmlspecialchars($activitystockman['block_lot'] ?? 'N/A'); ?>)
                        <?php endif; ?>
                    </div>
                    <span class="text-muted"><?= date('Y-m-d H:i A', strtotime($activitystockman['date'])); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<style>
.card {
    width: 100%; /* Ensure it takes full width */
    margin: 0; /* Remove any margins */
}

.card canvas {
    width: 100% !important; /* Force canvas to fill its container */
    height: auto; /* Adjust height automatically */
}

.recent-activities {
    width: 100%; /* Ensure it takes full width */
    margin-top: 20px; /* Add space between the chart and the activities */
}

.recent-activities h5 {
    margin-bottom: 15px; /* Space between title and list */
}

.recent-activities ul {
    padding: 0; /* Remove padding */
}

</style>

<?php include('includes/footer.php'); ?>
