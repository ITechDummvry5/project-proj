<?php include 'includes/header.php'; ?>

<?php 
// Count Function
$totalPersonalInfo = getCount('personal');
$totalAccountInfo = getCount('account');
$totalActivityInfo = getCount('activity_logs');

$tableNames = [
    'soloparentcertificate',
    'franchising',
    'businessclearance',
    'buildingclearance',
    'barangayresidency',
    'barangayindigency',
    'barangayclearance',
    'barangaycertificate',
    'certificationoflegitimacy',
    'cohabitationletter',
    'certificationofsourceofincome',
    'certificationoflowincome',
    'certificateofgoodmoral',
    'certificationofesc',
    'certificationofcalamity',
];

// Get the total record count across all the tables
$totalRecords = getMultipleCount($tableNames);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <?php alertMessage(); ?>

        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Personal Information (insert) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="personal-create.php" class="text-decoration-none">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Personal Info (insert)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalPersonalInfo; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Document Insert Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="personal-view.php" class="text-decoration-none">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Document
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalRecords; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        
        <?php
   $percentage = $totalAccountInfo;  // 1 account = 1%
if ($percentage > 100) {
    $percentage = 100; // optional: cap at 100%
}

        ?>

        <!-- Account Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="account-view.php" class="text-decoration-none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Account</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            <?= round($percentage, 2); ?>%
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: <?= $percentage; ?>%" aria-valuenow="<?= $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Activity Logs (personal info) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="activity-logs.php" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Activity Logs
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalActivityInfo ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <!-- Content Row -->

    <div class="row">

    <?php 
 $tableNamescount = [
    'barangayclearance',
    'barangaycertificate',
    'barangayresidency',
    'barangayindigency',
    'businessclearance',
    'buildingclearance',
    'certificationoflegitimacy',
    'certificationofsourceofincome',
    'certificationoflowincome',
    'certificateofgoodmoral',
    'cohabitationletter',
    'franchising',
    'pwdcertificate',
    'soloparentcertificate',
    'certificationofesc',
    'certificationofcalamity',
];

// Get the total record count across all the tables
$totalRecords = getMultipleCount($tableNamescount);

// You could also break down counts by month if needed, but for simplicity, we're using the total count
// Example: Get a count for each table per month, and pass it to JavaScript as an array
$monthlyCounts = [];
foreach ($tableNamescount as $table) {
    // Fetch the count of records in each table by month (for example)
    // Assuming the table has a `created_at` date column
    $query = "SELECT MONTH(created_at) AS month, COUNT(*) AS count 
              FROM $table 
              GROUP BY MONTH(created_at) 
              ORDER BY MONTH(created_at)";
    $query_run = mysqli_query($conn, $query);
    $monthlyCounts[$table] = array_fill(0, 12, 0); // Initialize with zero counts

    while ($row = mysqli_fetch_assoc($query_run)) {
        $month = $row['month'] - 1; // Months in JS are 0-indexed (0 = Jan, 11 = Dec)
        $monthlyCounts[$table][$month] = $row['count'];
    }
}
   
    ?>
<!-- Area Chart -->
<div class="col-xl-8 col-lg-6 d-flex">
    <div class="card shadow mb-4 w-100">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Document Overview</h6>
    <div class="dropdown no-arrow">
        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
    <div class="dropdown-header">Select Document Type:</div>
    <?php 
        // Ensure 'barangayclearance' is the first option
        foreach ($tableNamescount as $table) {
            // Check if the current table is 'barangayclearance' and set it as default
            $activeClass = ($table == 'barangayclearance') ? 'active' : '';
            echo "<a class='dropdown-item $activeClass' href='#' onclick='updateChartData(\"$table\")'>$table</a>";
        }
    ?>
</div>


    </div>
</div>

        <!-- Card Body -->
        <div class="card-body d-flex flex-column">
            <div class="chart-area flex-grow-1">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Pie Chart -->
<div class="col-xl-4 col-lg-6 d-flex">
    <div class="card shadow mb-4 w-100">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Overview of Records</h6>
        </div>
        <div class="card-body d-flex flex-column">
            <div class="chart-pie pb-2 flex-grow-1">
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Dynamically inject PHP values into JavaScript object
    var chartData = [
        <?= $totalPersonalInfo; ?>, 
        <?= $totalRecords; ?>, 
        <?= round($percentage, 2); ?>, 
        <?= $totalActivityInfo; ?>
    ];
</script>

</div>


    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

        </div>

    </div>
</div>

</div>
<!-- End of Main Content -->

<?php include 'includes/footer.php'; ?>

<script>
// Get the monthly counts from PHP
var monthlyCounts = <?php echo json_encode($monthlyCounts); ?>;

// Define the months labels
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

// Prepare the data for the chart (initially, all datasets are visible)
var dataForChart = {
    labels: months,
    datasets: []
};

// Loop through each table's counts and prepare a dataset for each one
for (var table in monthlyCounts) {
    dataForChart.datasets.push({
        label: table, // Name of the table
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: monthlyCounts[table] // The count data for this table
    });
}

// Initialize the chart with all data
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: dataForChart,
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value, index, values) {
                        return value; // Just display the count (no currency needed)
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: true
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel + ' documents'; // Show the document count
                }
            }
        }
    }
});

// Function to update chart data based on the selected table
function updateChartData(selectedTable) {
    // Filter datasets to only show the selected table's data
    var filteredData = {
        labels: months,
        datasets: []
    };

    filteredData.datasets.push({
        label: selectedTable,
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: monthlyCounts[selectedTable] // The count data for the selected table
    });

    // Update the chart with the filtered data
    myLineChart.data = filteredData;
    myLineChart.update();
}

// Automatically update the chart for "barangayclearance" on page load
document.addEventListener("DOMContentLoaded", function() {
    updateChartData("barangayclearance");
});
</script>


<!-- Page level custom scripts -->
<!-- <script src="assets/js/demo/chart-area-demo.js"></script> -->
<script src="assets/js/demo/chart-pie-demo.js"></script>



