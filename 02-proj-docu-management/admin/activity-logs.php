<?php
require_once '../config/function.php';
// Add a check to restrict access to only secretarys
if ($_SESSION['loggedInUser']['role'] != 'secretary' && $_SESSION['loggedInUser']['role'] != 'staff') {
    // Redirect or show an access denied message
    alertMessage();
    redirect('index2.php', 'Access Denied: You do not have permission to access this page.', 'error');
}
// Clean up old sessions
$query = "DELETE FROM sessions WHERE login_time < NOW() - INTERVAL 1 WEEK";
mysqli_query($conn, $query);

// Clean up old activity_logs
$query = "DELETE FROM activity_logs WHERE action_date < NOW() - INTERVAL 1 WEEK";
mysqli_query($conn, $query);
?>
<?php include('includes/header.php'); ?>



    <div class="container-fluid px-4">
    <?php alertMessage(); ?>
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white">
            <h4 class="my-1 fw-lighter fs-4">    <i class="fas fa-database fa-sm fa-fw mr-2"></i> Back-Up Records</h4>
        </div>
        <div class="card-body">
    
            <form action="backup-code.php" method="POST">
    <div class="row align-items-center">
        <div class="col-md-3 mb-3"> 
            <label for="table" class="form-label">Select a Table:</label>
            <select name="table" class="form-select form-control" id="table" >
                            <option value="">Select Table</option>
                            <option value="all">All Tables</option> <!-- New option for all tables -->
                            <option value="barangaycertificate">Barangay Certificate</option>
                            <option value="barangayclearance">Barangay Clearance</option>
                            <option value="barangayindigency">Barangay Indigency</option>
                            <option value="barangayresidency">Barangay Residency</option>
                            <option value="buildingclearance">Building Clearance</option>
                            <option value="businessclearance">Business Clearance</option>
                            <option value="certificateofgoodmoral">Certificate of Good Moral</option>
                            <option value="certificationofcalamity">Certification of Calamity</option>
                            <option value="certificationofesc">Certification of ESC</option>
                            <option value="certificationoflegitimacy">Certification of Legitimacy</option>
                            <option value="certificationoflowincome">Certification of Low Income</option>
                            <option value="certificationofsourceofincome">Certification of Source of Income</option>
                            <option value="cohabitationletter">Cohabitation Letter</option>
                            <option value="franchising">Franchising</option>
                            <option value="soloparentcertificate">Solo Parent Certificate</option>
                            <option value="personal">Personal</option>
                        </select>
        </div>
        
        <div class="col-md-3 mb-3">
    <label for="format" class="form-label">Select Format:</label>
    <select name="format" class="form-select form-control" id="format" required>
        <option value="sql">SQL</option>
        <option value="csv">CSV</option>
        <option value="pdf">PDF</option>
        <option value="excel">Excel (.xlsx)</option> <!-- Excel option added -->
    </select>
</div>



        
        <div class="col-md-3 mb-3">
            <label for="start_date" class="form-label">Start Date:</label>
            <input type="date" name="start_date" class="form-control" id="start_date" required>
        </div>

        <div class="col-md-3 mb-3">
            <label for="end_date" class="form-label">End Date:</label>
            <input type="date" name="end_date" class="form-control" id="end_date" required>
        </div>

        <div class="col-md-12 text-right mt-2">
                <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                </button>
        </div>
    </div>
</form>

        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-danger text-white">
            <h4 class="my-1 fw-lighter fs-4"> <i class="fas fa-trash fa-sm fa-fw mr-2"></i> Delete Records </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <!-- Form to delete records -->
            <form action="delete-record.php" method="POST">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3">
                        <label for="table" class="form-label">Select a Table:</label>
                        <select name="table" class="form-select form-control" id="table" required>
                            <!-- List your table options here like in the backup form -->
                            <option value="">Select Table</option>
                            <option value="barangaycertificate">Barangay Certificate</option>
                            <option value="barangayclearance">Barangay Clearance</option>
                            <option value="barangayindigency">Barangay Indigency</option>
                            <option value="barangayresidency">Barangay Residency</option>
                            <option value="buildingclearance">Building Clearance</option>
                            <option value="businessclearance">Business Clearance</option>
                            <option value="certificateofgoodmoral">Certificate of Good Moral</option>
                            <option value="certificationofcalamity">Certification of Calamity</option>
                            <option value="certificationofesc">Certification of ESC</option>
                            <option value="certificationoflegitimacy">Certification of Legitimacy</option>
                            <option value="certificationoflowincome">Certification of Low Income</option>
                            <option value="certificationofsourceofincome">Certification of Source of Income</option>
                            <option value="cohabitationletter">Cohabitation Letter</option>
                            <option value="franchising">Franchising</option>
                            <option value="pwdcertificate">PWD Certificate</option>
                            <option value="soloparentcertificate">Solo Parent Certificate</option>
                            <option value="personal">Personal</option>
                            <!-- Other options as necessary -->
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" required>
                    </div>

                    <div class="col-md-2 text-right mt-2">
                        <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                            <i class="fas fa-trash fa-sm text-white-50"></i> Delete Records
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="container-fluid px-4">
<div class="card mt-4 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-success text-white">
        <h4 class="my-1 fw-lighter fs-4"><i class="fas fa-upload fa-sm fa-fw mr-2"></i> Import Back-Up</h4>
    </div>
    <div class="card-body">
        <form action="import-backup.php" method="POST" enctype="multipart/form-data">
            <div class="row align-items-center">
                <div class="col-md-7 mb-3">
                    <label for="sql_file" class="form-label">Select SQL File:</label>
                    <input type="file" name="sql_file" class="form-control" id="sql_file" accept=".sql" required>
                </div>
                <div class="col-md-5 text-right mt-2">
                    <button type="submit" class="btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-upload fa-sm text-white-50"></i> Import Backup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>



<?php if($_SESSION['loggedInUser']['role'] === 'secretary'): ?>


<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4"><i class="fas fa-tasks"></i></h4>
        </div>
        <div class="card-body">

            <!-- Logs Table -->
            <div class="table-responsive">
                <table id="dataTable7" class="table table-bordered table-striped">
                    <thead class="text-gray-900">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Years</th>
                       
                            <th>Action</th>
                          
                            <th>Date Performed</th>
                            <th>Modified By</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php
                        // Fetch activity logs
                        $query = "SELECT * FROM activity_logs ORDER BY action_date DESC";
                        $query_run = mysqli_query($conn, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $log) {
                                ?>
                                <tr>
                                    <td><?= $log['id']; ?></td>
                                    <td><?= htmlspecialchars($log['personal_id']); ?></td>
                                    <td><?= htmlspecialchars($log['name']); ?></td>
                                    <td><?= htmlspecialchars($log['address']); ?></td>
                                    <td><?= htmlspecialchars($log['length_of_years']); ?>Years</td>
                              
                                    <td>
    <span class="badge <?= $log['action_type'] == 'update' ? 'bg-success' : 'bg-primary'; ?>">
        <?= ucfirst($log['action_type']); ?>
    </span>
</td>

                                    <td><?= date("d M Y h:i A", strtotime($log['action_date'])); ?></td>
                                    <td><?= htmlspecialchars($log['performed_by']); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No Activity Logs Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4"><i class="fas fa-shoe-prints"></i></h4>
          
        </div>
        <div class="card-body">

<div class="row">
                <div class="col-md-12"> 
                    <div class="card-body table-responsive">
                        <table id="dataTable6" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Login </th>
                                    <th>Logout </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query active sessions from the database
                                $activeSessionsQuery = "SELECT sessions.id, sessions.user_id, sessions.session_id,
                                                         sessions.login_time, sessions.logout_time, account.name
                                                         FROM sessions
                                                         JOIN account ON sessions.user_id = account.id
                                                         ORDER BY sessions.login_time DESC
                                                         LIMIT 5";
                                $activeSessionsResult = mysqli_query($conn, $activeSessionsQuery);

                                // Check if query was successful and if there are active sessions
                                if ($activeSessionsResult && mysqli_num_rows($activeSessionsResult) > 0) {
                                    while ($session = mysqli_fetch_assoc($activeSessionsResult)) {
                                        // Display session information
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($session['id']); ?></td>
                                            <td><?= htmlspecialchars($session['name']); ?></td>
                                            <td><?= date('d M Y h:i A', strtotime($session['login_time'])); ?></td>
                                            <td><?= $session['logout_time'] ? date('d M Y h:i A', strtotime($session['logout_time'])) : 'Still logged in'; ?></td>
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
    </div>
</div>

<?php endif; ?>


                   
     

<?php include 'includes/footer.php'; ?>
