<?php
include('includes/header.php');

date_default_timezone_set('Asia/Manila');

$totalCategories = getCount('categories');
$totalProducts = getCount('products');
$totalAdmins = $_SESSION['loggedInUser']['role'] === 'superadmin' ? getCount('admins') : 0;
$totalContractors = getCount('customers');
$todayOrders = getTodayOrders();
$totalOrders = getCount('orders');

$recentWeekOrdersByDay = getRecentWeekOrdersByDay();
$weekLabels = json_encode(array_keys($recentWeekOrdersByDay)); // Days of the week
$weekData = json_encode(array_values($recentWeekOrdersByDay)); // Orders count

$monthlyOrders = getMonthlyOrderData();
$monthlyOrderLabels = json_encode(array_column($monthlyOrders, 'month'));
$monthlyOrderData = json_encode(array_column($monthlyOrders, 'total'));

$monthlyProducts = getMonthlyProductData();
$monthlyProductLabels = json_encode(array_column($monthlyProducts, 'month'));
$monthlyProductData = json_encode(array_column($monthlyProducts, 'total'));

$todayOrdersData = json_encode([$todayOrders]);
$recentWeekOrdersData = $weekData;
$monthlyOrdersData = $monthlyOrderData;

$recentActivities = getRecentActivitiesSystem(5); // Adjust the limit as needed
?>

<div class="container-fluid px-4">
    <div class="row mb-3 mt-4">
        <!-- Main Dashboard Stats -->
        <div class="col-md-8">
            <h1 class="mb-3 fw-bold">Dashboard</h1>
            <?php alertMessage(); ?>



            <!-- Stats Cards -->
            <div class="row mb-4">
              
              <div class="col-md-6 mb-2">
  <div class="box text-center p-3">
    <a href="products-folder" class="text-white text-decoration-none">
      <div class="img-section">
          <img src="../assets/image/undraw_system_1.svg" alt="Category Image">
      </div>
      <div class="box-desc">
          <div class="box-header">
              <div class="fw-bold box-title">Total Project</div>
          </div>
          <div class="box-time"><?= $totalCategories; ?></div>
      </div>
    </div>
</a>
</div>


            <!-- Total Products Box with Image -->
<div class="col-md-6 mb-2">
<a href="products-folder" class="text-white text-decoration-none">
  <div class="box text-center p-3">
      <div class="img-section">
          <img src="../assets/image/undraw_system_2.svg" alt="Products Image">
      </div>
      <div class="box-desc">
          <div class="box-header">
              <div class="fw-bold box-title">Total Material</div>
          </div>
          <div class="box-time"><?= $totalProducts; ?></div>
          
      </div>
  </div>
  </a>
</div>

<!-- Total Contractors Box with Image -->
<div class="col-md-6 mb-2">
<a href="customers" class="text-white text-decoration-none">
  <div class="box text-center p-3">
      <div class="img-section">
          <img src="../assets/image/undraw_system_3.svg" alt="Contractor Image">
      </div>
      <div class="box-desc">
          <div class="box-header">
              <div class="fw-bold box-title">Total Contractors</div>
          </div>
          </a>
          <div class="box-time"><?= $totalContractors; ?></div>
          
      </div>
  </div>
</div>

<div class="col-md-6 mb-2">
<a href="admins" class="text-white text-decoration-none">
  <div class="box text-center p-3">
      <div class="img-section">
          <img src="../assets/image/undraw_system_4.svg" alt="Admin Image">
      </div>
      <div class="box-desc">
          <div class="box-header">
              <div class="fw-bold box-title">Total Admins</div>
          </div>
          </a>
          <div class="box-time"><?= $totalAdmins; ?></div>
          
      </div>
  </div>
</div>
          </div>
            <!-- Combined Chart Section -->

            <h2 class="mb-3 fw-bold fs-4">Orders Overview</h2>
            <div class="row mb-2">
                <div class="col-md-12 mb-3">
                    <div class="card p-3 border-0 shadow-sm rounded">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold fs-6 mb-0">Orders</h5>
                            <select id="chartType" class="form-select" style="width: 200px;">
                                <option value="today" selected>Today</option>
                                <option value="week">One Week</option>
                                <option value="month">Monthly</option>
                            </select>
                        </div>
                        <canvas id="ordersOverviewChart" height="140"></canvas>
                        <div id="totalOrdersDisplay" class="mt-2 fs-5 fw-bold"></div>
                    </div>
                </div>
            </div>

            <!-- Total Products (Monthly) Card -->
            <div class="row mb-4">
                <div class="col-md-12 mb-3">
                    <div class="card p-3 border-0 shadow-sm rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-bold fs-6 mb-0">Total Materials (Monthly)</h5>
                            <span class="fs-4 fw-bold"><?= array_sum(array_column($monthlyProducts, 'total')); ?></span>
                        </div>
                        <canvas id="monthlyProductsChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>


<!-- Overview and Audit Log Section -->
<div class="col-md-4 mt-5">
            <div class="row mb-2">
                <div class="col-md-12 mb-3">
                    <div class="card p-3 mt-2  border-0 shadow-sm rounded">
                        <h5 class="fw-bold fs-4">Overview</h5>
                        <canvas id="overviewPieChart" height="200"></canvas>
                    </div>
                </div>
            </div>

          
            <div class="row">
                <div class="col-md-12"> 
                    <h5 class="mb-3 fw-bold fs-4 bg-primary text-white text-center">Audit Logs</h5>
                    <div class="card-body table-responsive">
                        <table id="datatablesSimple" class="table align-items-center justify-content-center table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Login </th>
                                    <th>Logout </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query active sessions from the database
                                $activeSessionsQuery = "SELECT active_sessions.user_id, active_sessions.session_id,
                                                         active_sessions.login_time, active_sessions.logout_time, admins.name
                                                         FROM active_sessions
                                                         JOIN admins ON active_sessions.user_id = admins.id
                                                         ORDER BY active_sessions.login_time DESC
                                                         LIMIT 25";
                                $activeSessionsResult = mysqli_query($conn, $activeSessionsQuery);

                                // Check if query was successful and if there are active sessions
                                if ($activeSessionsResult && mysqli_num_rows($activeSessionsResult) > 0) {
                                    while ($session = mysqli_fetch_assoc($activeSessionsResult)) {
                                        // Display session information
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($session['name']); ?></td>
                                            <td><?= htmlspecialchars($session['login_time']); ?></td>
                                            <td><?= htmlspecialchars($session['logout_time']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    // No active sessions found
                                    echo "<tr><td colspan='3'>No active sessions found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-activities">
    <h5 class="fw-bold fs-4 ">Recent Order Activities</h5>
    <ul class="list-group">
        <?php foreach ($recentActivities as $activity): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong><?= htmlspecialchars($activity['type']); ?>:</strong> <?= htmlspecialchars($activity['detail']); ?> 
                    (Tracking No: <?= htmlspecialchars($activity['invoice_no']); ?>)
                </div>
                <span class="text-muted"><?= date('Y-m-d H:i A', strtotime($activity['date'])); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


    </div>
</div>

<script src="assets/js/chart.min.js"></script>
<script>

    const todayOrdersData = <?= $todayOrdersData; ?>;
    const weekLabels = <?= $weekLabels; ?>;
    const weekData = <?= $recentWeekOrdersData; ?>;
    const monthlyOrderLabels = <?= $monthlyOrderLabels; ?>;
    const monthlyOrderData = <?= $monthlyOrderData; ?>;
    const monthlyProductLabels = <?= $monthlyProductLabels; ?>;
    const monthlyProductData = <?= $monthlyProductData; ?>;

    const ctx = document.getElementById('ordersOverviewChart').getContext('2d');

    let ordersOverviewChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Today'],
        datasets: [{
            label: 'Orders',
            data: todayOrdersData,
            fill: false,
            borderColor: '#2b7de0',
            tension: 0.1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true, // Start the y-axis from zero
                ticks: {
                    // Force y-axis to use whole numbers
                    stepSize: 1, // Set step size to 1
                    callback: function(value) {
                        if (Number.isInteger(value)) {
                            return value;
                        }
                    }
                }
            }
        }
    }
});


    function updateChart(type) {
    let labels, data, total;

    switch (type) {
        case 'today':
            labels = ['Today'];
            data = todayOrdersData.map(Number); // Convert to numbers
            total = data[0];
            break;
        case 'week':
            labels = weekLabels;
            data = weekData.map(Number); // Convert to numbers
            total = data.reduce((a, b) => a + b, 0);
            break;
        case 'month':
            labels = monthlyOrderLabels;
            data = monthlyOrderData.map(Number); // Convert to numbers
            total = data.reduce((a, b) => a + b, 0);
            break;
    }

    // Debug
    // console.log('Labels:', labels);
    // console.log('Data:', data);
    // console.log('Total:', total);

    ordersOverviewChart.data.labels = labels;
    ordersOverviewChart.data.datasets[0].data = data;
    ordersOverviewChart.data.datasets[0].label = type === 'today' ? "Today's Orders" : (type === 'week' ? 'Orders Last 7 Days' : 'Monthly Orders');
    ordersOverviewChart.update();

    document.getElementById('totalOrdersDisplay').textContent = ' ' + Number(total);

}



    document.getElementById('chartType').addEventListener('change', function() {
        updateChart(this.value);
    });

    // Initialize chart with default value
    updateChart('today');

    // Initialize Monthly Products Chart
    const monthlyProductsChartCtx = document.getElementById('monthlyProductsChart').getContext('2d');
    new Chart(monthlyProductsChartCtx, {
        type: 'line',
        data: {
            labels: monthlyProductLabels,
            datasets: [{
                label: 'Total Products',
                data: monthlyProductData,
                fill: false,
                borderColor: '#ea2e69',
                tension: 0.1
            }]
        }
    });

// Overview Pie Chart
const overviewPieChartCtx = document.getElementById('overviewPieChart').getContext('2d');

// Prepare labels and data
let labels = ['Projects', 'Materials', 'Orders', 'Contractors'];
let data = [
    <?= $totalCategories; ?>,
    <?= $totalProducts; ?>,
    <?= $totalOrders; ?>,
    <?= $totalContractors; ?>
];

// Check if the user is a superadmin
if (<?= $_SESSION['loggedInUser']['role'] === 'superadmin' ? 'true' : 'false'; ?>) {
    labels.push('Admins');
    data.push(<?= $totalAdmins; ?>);
}

// Create the pie chart
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

<style>
/* Card styling with enhanced shadow */
.card {
    background-color: #ffffff;
    color: #000000;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    margin-bottom: 1rem;
    /* Ensure cards have the same width */
    width: 100%;
}

/* Ensure proper alignment of canvas inside cards */
.card canvas {
    width: 100% !important;
    border-radius: 0.5rem;
}

/* Ensure the audit log table has a white background and dark text */
.table {
    background-color: #ffffff !important;
    color: #000000;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-hover tbody tr:hover {
    background-color: #f2f2f2;
}

/* Style the header of the table */
.thead-dark th {
    background-color: #343a40;
    color: #ffffff;
}

/* Card body to remain white */
.card-body {
    background-color: #ffffff !important;
    color: #000000;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .row {
        margin-right: 0;
        margin-left: 0;
    }

    .col-md-12 {
        width: 100%;
        margin-bottom: 1rem;
    }
}

/* Additional styling for flex layout in cards */
.d-flex {
    display: flex;
}

.justify-content-between {
    justify-content: space-between;
}

.align-items-center {
    align-items: center;
}

</style>



<?php include('includes/footer.php'); ?>


