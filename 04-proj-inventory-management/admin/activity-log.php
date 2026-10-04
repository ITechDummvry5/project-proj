<!-- 5/19/2024 -->
<?php include('includes/header.php');?>


<?php if ($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header  bg-dark text-white">
            <h4 class="fw-lighter fs-4">Audit Logs 
                <a href="index.php" class="btn btn-primary float-end">Go Back</a>
            </h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table align-items-center justify-content-center table-dark table-hover ">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query active sessions from the database
                    $activeSessionsQuery = " SELECT  active_sessions.user_id, active_sessions.session_id,
                     active_sessions.login_time,active_sessions.logout_time,admins.name    
                    FROM  active_sessions 
                    JOIN  admins 
                    ON  active_sessions.user_id = admins.id 
                    ORDER BY  active_sessions.login_time DESC 
                    LIMIT 5";
                
                    $activeSessionsResult = mysqli_query($conn, $activeSessionsQuery);

                    // Check if query was successful and if there are active sessions
                    if ($activeSessionsResult && mysqli_num_rows($activeSessionsResult) > 0) {
                        while ($session = mysqli_fetch_assoc($activeSessionsResult)) {
                            // Display session information
                            ?>
                              <tr>
                                <td><?= htmlspecialchars($session['user_id']); ?></td>
                                <td><?= htmlspecialchars($session['name']); ?></td>
                                <td><?= htmlspecialchars($session['login_time']); ?></td>
                                <td><?= htmlspecialchars($session['logout_time']); ?></td>
                            </tr>
                            <?php
                        }
                    } else { 
                        // No active sessions found
                        echo "<tr><td colspan='4'>No active sessions found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>