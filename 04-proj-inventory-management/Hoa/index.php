<?php include('hoainclude/header.php'); ?>

<?php 

$totalAnnouncement = getCount('announcement');
$totalResidentAccount = getCount('residents');
$totalPayment = getCount('payments');
$totalPending = getCountifarchived('request');

$recentActivities = getRecentActivities(); // Ensure this line is included before the display section


// Fetch total and completed requests per month
$totalRequestsData = getMonthlyRequests('request', 0);  // Fetch total requests per month (is_archived = 0)
$completedRequestsData = getMonthlyRequests('request', 1);  // Fetch completed requests per month (is_archived = 1)

// Ensure all months are present in the chart (handle missing months)
$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$totalRequests = [];
$completedRequests = [];

foreach ($months as $month) {
    $totalRequests[] = $totalRequestsData[$month] ?? 0; // Use 0 if data for the month is missing
    $completedRequests[] = $completedRequestsData[$month] ?? 0; // Use 0 if data for the month is missing

    
}

?> 
<div class="container-fluid px-4">
    <div class="py-3">
        <h1 class="mb-3 fw-bold">DashBoard</h1>
        <?php alertMessage(); ?>
        <div class="row mb-4">
            <!-- Key Metrics Cards -->

      

            <div class="col-md-3 mb-3">
    <div class="box text-center p-3">
        <div class="img-section">
          <img src="../assets/image/undraw_hoa_1.svg" alt="">
        </div>
        <div class="box-desc">
            <div class="box-header">
                <div class="fw-bold box-title">Announcements</div>
            </div>
            <div class="box-time"><?= $totalAnnouncement ?></div>
            <p class="recent">TOTAL</p> <!-- Add your variable for last week's data -->
        </div>
    </div>
</div>

    <div class="col-md-3 mb-3">
        <div class="box text-center p-3">
            <div class="img-section">
                <img src="../assets/image/undraw_hoa_2.svg" alt="Residents Image">
            </div>
            <div class="box-desc">
                <div class="box-header">
                    <div class="fw-bold box-title">Residents</div>
                </div>
                <div class="box-time"><?= $totalResidentAccount ?></div>
                <p class="recent">TOTAL</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="box text-center p-3">
            <div class="img-section">
                <img src="../assets/image/undraw_hoa_3.svg" alt="Payments Image">
            </div>
            <div class="box-desc">
                <div class="box-header">
                    <div class="fw-bold box-title">Payments</div>
                </div>
                <div class="box-time"><?= $totalPayment ?></div>
                <p class="recent">TOTAL</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="box text-center p-3">
            <div class="img-section">
                <img src="../assets/image/undraw_hoa_4.svg" alt="Pending Requests Image">
            </div>
            <div class="box-desc">
                <div class="box-header">
                    <div class="fw-bold box-title">Pending Requests</div>
                </div>
                <div class="box-time"><?= $totalPending ?></div>
                <p class="recent">TOTAL</p>
            </div>
        </div>
    </div>
</div>

        <div class="row mb-4">
            <!-- Row for Overview and Maintenance Charts -->
            <div class="col-md-6 mb-2">
                <div class="card card-body p-3 rounded-lg d-flex align-items-center">
                    <p class="text-sm mb-0 fw-bold">Overview: Announcements, Residents, and Payments</p>
                    <canvas id="overviewChart" width="400" height="200" class="mt-3"></canvas> <!-- Overview Chart -->
                </div>
            </div>
            
            <div class="col-md-6 mb-2">
                <div class="card card-body p-3 rounded-lg d-flex align-items-center">
                    <p class="text-sm mb-0 fw-bold">Maintenance Requests</p>
                    <canvas id="maintenanceChart" width="400" height="200" class="mt-3"></canvas>
                </div>
            </div>
        </div>

        
        <?php      // Example usage to check the image count
// $getImage = getInimageCount(); 

// // Check if there are any residents with an uploaded image
// if ($getImage > 0) {
//     echo "Notification: $getImage resident(s) have uploaded images.";
// } else {
//     echo "No residents have uploaded images.";
// }
?>
<div class="row mb-4">
    <!-- Recent Activities Section -->
    <div class="col-12 mb-2">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Recent Activities</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentActivities)): ?>
                    <div class="text-center">No recent activities found.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Activity Type</th>
                                    <th>Details</th>
                                    <th class="text-end">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentActivities as $activity): 
                                    $activityDate = date('F j, Y, g:i A', strtotime($activity['date'])); ?>
                                    <tr>
                                        <td><strong class="fw-bold"><?= $activity['type'] ?></strong></td>
                                        <td class="text-truncate" style="max-width: 250px;">
                                            <?php if ($activity['type'] === 'Payments'): ?>
                                                Amount Paid Of ₱ <?= number_format($activity['detail'], 2) ?> <!-- Add Peso sign and format the amount -->
                                            <?php else: ?>
                                                <?= $activity['detail'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-muted small text-end"><?= $activityDate ?></td> <!-- Ensure date is right-aligned -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>




    </div>
</div>

<?php include('hoainclude/footer.php'); ?>

<!-- Include Chart.js -->
<script>
    // Data from PHP for charts
    var maintenanceMonths = <?= json_encode($months); ?>; // PHP array for months
    var totalRequestsData = <?= json_encode($totalRequests); ?>; // Total requests data from PHP
    var completedRequestsData = <?= json_encode($completedRequests); ?>; // Completed requests data from PHP
    var totalAnnouncement = <?= $totalAnnouncement; ?>;
    var totalResidentAccount = <?= $totalResidentAccount; ?>;
    var totalPayment = <?= $totalPayment; ?>;

    // Overview Chart: Bar chart for total Announcement, Resident, and Payment
    var overviewCtx = document.getElementById('overviewChart').getContext('2d');
    var overviewChart = new Chart(overviewCtx, {
        type: 'bar',
        data: {
            labels: ['Announcements', 'Residents', 'Payments'],
            datasets: [{
                label: 'Total Count',
                data: [totalAnnouncement, totalResidentAccount, totalPayment],
                backgroundColor: [
                    'rgba(13, 110, 253)',  // Announcements color
                    'rgba(255, 255, 25)',   // Residents color
                    'rgba(37, 192, 192)'    // Payments color
                ], 
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 255, 25)',
                    'rgba(37, 192, 192)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Overview'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Count'
                    },
                    beginAtZero: true
                }
            },
            responsive: true
        }
    });

    // Maintenance Chart with both total and completed requests
    var ctx = document.getElementById('maintenanceChart').getContext('2d');
    var maintenanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: maintenanceMonths,
            datasets: [
                {
                    label: 'Pending Requests',
                    data: totalRequestsData,
                    borderColor: 'rgba(255, 48, 92)',
                    backgroundColor: 'rgba(255, 150, 172)',
                    borderWidth: 3
                },
                {
                    label: 'Completed Requests',
                    data: completedRequestsData,
                    borderColor: 'rgba(54, 162, 235)', // Different color for completed requests
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Background color for completed requests
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Year Request'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Requests'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>
