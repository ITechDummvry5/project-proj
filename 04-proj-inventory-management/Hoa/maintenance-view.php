<?php 
include('hoainclude/header.php');
// Fetch maintenance requests ordered by creation date in descending order
$maintenanceRequests = fetchDataPosition('request', '*', 'is_archived = 0', 'created_at DESC', '10');
?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4 mb-0">Maintenance Requests</h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="table-responsive">
                <table id="datatablesSimple" class="text-center table table-bordered table-hover">
                    <?php if ($maintenanceRequests): // Check if there are maintenance requests ?>
                    <thead class="table-dark">
                        <tr>
                            <th>Resident Name Id</th>
                            <th>Description</th>
                            <th>Date Created</th>
                            <th>Reason to Reject</th>
                            <th class="text-center">Schedule</th> 
                            <th class="text-center">Status</th>
                            <th class="text-center">Feedback</th>
                            <th class="text-center">Rating</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($maintenanceRequests as $request): ?>
                        <tr>
                            <td><?= htmlspecialchars($request['resident_id']); ?></td>
                        
                            <td class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= htmlspecialchars($request['rdescription']); ?>"><?= htmlspecialchars($request['rdescription']); ?></td>
                            <td><?= date('d M, Y', strtotime($request['created_at'])); ?></td>
                            <td>
    <?php if (!empty($request['reason'])): ?>
        <?= htmlspecialchars($request['reason']); ?>
    <?php else: ?>
        <span class="text-muted">No reason provided</span>
    <?php endif; ?>
</td>

                            <td class="text-center">
                                <?php if ($request['working_date']): ?>
                                    <div class="badge bg-white text-muted"><?= date('d M, Y', strtotime($request['working_date'])); ?></div>
                                <?php else: ?>
                                    <span class="text-muted">No Scheduled</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <span class="badge <?= $request['status'] == 'Accepted' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?= htmlspecialchars($request['status']); ?>
                                </span>
                            </td>

                            <!-- Feedback Column -->
                            <td class="text-center">
                                <?php if ($request['feedback']): ?>
                                    <span><?= htmlspecialchars($request['feedback']); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">No Feedback</span>
                                <?php endif; ?>
                            </td>

                            <!-- Rating Column -->
                            <td class="text-center">
                                <?php if ($request['rating']): ?>
                                    <?php 
                                    // Assuming rating is a number from 1 to 5
                                    $rating = $request['rating'];
                                    // Display stars based on the rating
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<span class="star filled">&#9733;</span>'; // Filled star
                                        } else {
                                            echo '<span class="star">&#9734;</span>'; // Empty star
                                        }
                                    }
                                    ?>
                                    <br>
                                    <span><?= htmlspecialchars($rating); ?> / 5</span>
                                <?php else: ?>
                                    <span class="text-muted">No Rating</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if ($request['status'] == 'Pending'): ?>
                                    <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#acceptModal<?= htmlspecialchars($request['id']); ?>">Accept</button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?= htmlspecialchars($request['id']); ?>">Reject</button>
                                <?php elseif ($request['status'] == 'Accepted'): ?>
                                    <a href="maintenance-action.php?id=<?= htmlspecialchars($request['id']); ?>&action=reopen" class="btn btn-warning btn-sm">Reopen</a>
                                    <a href="#" onclick="confirmArchive('maintenance-archive-action?id=<?= $request['id']; ?>'); return false;" class="btn btn-archive btn-sm">Done</a>
                                <?php elseif ($request['status'] == 'Rejected'): ?>
                                    <a href="maintenance-action.php?id=<?= htmlspecialchars($request['id']); ?>&action=reopen" class="btn btn-warning btn-sm">Reopen</a>
                                <?php endif; ?>
                            </td>

                            <!-- Modal for Rejecting Request -->
                            <div class="modal fade" id="rejectModal<?= htmlspecialchars($request['id']); ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= htmlspecialchars($request['id']); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="rejectModalLabel<?= htmlspecialchars($request['id']); ?>">Rejection Reason</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="maintenance-action.php?id=<?= htmlspecialchars($request['id']); ?>&action=reject">
                                                <div class="mb-3">
                                                    <label for="rejection_reason<?= htmlspecialchars($request['id']); ?>" class="form-label">Reason for Rejection:</label>
                                                    <textarea name="rejection_reason" id="rejection_reason<?= htmlspecialchars($request['id']); ?>" class="form-control" required><?= htmlspecialchars($request['reason']); ?></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Submit Rejection</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for Accepting Request and Inputting Working Date -->
                            <div class="modal fade" id="acceptModal<?= htmlspecialchars($request['id']); ?>" tabindex="-1" aria-labelledby="acceptModalLabel<?= htmlspecialchars($request['id']); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="acceptModalLabel<?= htmlspecialchars($request['id']); ?>">Set Schedule</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="maintenance-action.php?id=<?= htmlspecialchars($request['id']); ?>&action=accept">
                                                <div class="mb-3">
                                                    <label for="working_date<?= htmlspecialchars($request['id']); ?>" class="form-label">Working Date:</label>
                                                    <?php 
                                                        // Get today's date in the required format
                                                        $todayDate = date('Y-m-d');
                                                    ?>
                                                    <input type="date" name="working_date" id="working_date<?= htmlspecialchars($request['id']); ?>" class="form-control" min="<?= $todayDate; ?>" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal -->

                        <?php endforeach; ?>
                    </tbody>
                    <?php else: // If no maintenance requests ?>
                    <tbody>
                        <tr>
                            <td colspan="7">No maintenance requests found</td>
                        </tr>
                    </tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('hoainclude/footer.php'); ?>

<!-- Add this CSS to style the stars -->
<style>
    .star {
        font-size: 2.5rem; /* Size of the star */
        color: #FFD700; /* Default color for stars */
    }

    .star.filled {
        color: #FFD700; /* Filled star color */
    }

    .star {
        color: #ccc; /* Empty star color */
    }
</style>
