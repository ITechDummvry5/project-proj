<?php
include('rinclude/header.php');

$resident_id = $_SESSION['rloggedInUser']['ruser_id'];
$condition = "WHERE resident_id = $resident_id ORDER BY id DESC";
$maintenanceRequests = rgetAll('request', '*', $condition);

// Check if there's any rejected request
$hasRejected = false;
foreach ($maintenanceRequests as $request) {
    if ($request['status'] !== 'Accepted') {
        $hasRejected = true;
        break;
    }
}
?>
<section class="py-5">
    <div class="container px-4">
        <h1 class="fw-bolder fs-5 mb-3 mt-4">Your Maintenance Requests Schedule</h1>

        <!-- Feedback Message -->
        <div id="feedback-message" class="alert alert-info d-none" role="alert">
            Feedback submitted successfully.
        </div>

        <div class="card border-0 shadow rounded-3 overflow-hidden">
            <div class="card-body">
                <?php alertMessage(); ?>
                <div class="table-responsive">
                    <table id="datatablesSimple" class="text-center table table-bordered table-hover">
                        <?php if ($maintenanceRequests): ?>
                        <thead class="table-light">
                            <tr>
                                <th hidden>ID</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Schedule</th>
                                <th>Reason To Reject</th>
                                <th>Feedback</th>
                                <?php if ($hasRejected): ?> <!-- Only show if there's a rejected request -->
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($maintenanceRequests as $request): ?>
                            <tr>
                                <td hidden><?= $request['id']; ?></td>
                                <td class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= htmlspecialchars($request['rdescription']); ?>">
                                    <?= htmlspecialchars($request['rdescription']); ?>
                                </td>
                                <td>
                                    <span class="badge <?= $request['status'] == 'Accepted' ? 'bg-success' : ($request['status'] == 'Pending' ? 'bg-warning' : 'bg-danger'); ?>">
                                        <?= htmlspecialchars($request['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($request['working_date']): ?>
                                        <div class="badge bg-white text-muted">
                                            <?= date('d M, Y', strtotime($request['working_date'])); ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">No Scheduled</span>
                                    <?php endif; ?>
                                </td>
                            
                                <td class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= htmlspecialchars($request['reason']); ?>">
                                    <?php if ($request['status'] !== 'Accepted' && $request['reason']): ?>
                                        <?= htmlspecialchars($request['reason']); ?>
                                    <?php else: ?>
                                        <span class="text-muted">No reason provided</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                   
                                        <?php if ($request['status'] === 'Accepted'): ?>
                                            <?php if (!empty($request['feedback'])): ?>
                                                <span class="text-success">Already Responded</span>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#feedbackModal" onclick="setRequestId(<?= $request['id']; ?>)">
                                                    Feedback
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Not yet accepted</span>
                                        <?php endif; ?>
                                   
                                </td>
                                <?php if ($hasRejected && $request['status'] !== 'Accepted'): ?> <!-- Show action button if rejected -->
                                    <td>
                                        <a href="#" 
                                           onclick="confirmDeletereject('maintenance-delete?id=<?= $request['id']; ?>'); return false;" 
                                           class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <?php else: ?>
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
</section>

<!-- Modal for Feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="feedbackModalLabel">Provide Your Feedback</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="feedbackForm" action="rcode.php" method="POST">
            <input type="hidden" id="requestId" name="requestId">
            
            <!-- Rating Section -->
            <div class="mb-3 text-start">
                <label for="rating" class="form-label badge bg-primary bg-gradient rounded-1">Rate the Work</label>
                <div id="rating" class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <input type="hidden" id="ratingValue" name="ratingValue" value="0">
            </div>
            
            <!-- Feedback Text -->
            <div class="mb-3">
                <label for="feedbackText" class="form-label badge bg-primary bg-gradient rounded-1">Your Feedback</label>
                <textarea class="form-control" id="feedbackText" name="feedbackText" rows="2" required></textarea>
            </div>
            
            <button type="submit" name="submitFeedback" class="btn btn-primary">Submit Feedback</button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
    .star {
    font-size: 25px; /* Adjust the size as needed */
    cursor: pointer;
}

</style>
<script>
// JavaScript to handle the star rating selection
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('ratingValue');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const rating = this.getAttribute('data-value');
            ratingInput.value = rating;

            // Update the star colors
            stars.forEach(s => s.style.color = '#ccc'); // Reset all stars to default
            for (let i = 0; i < rating; i++) {
                stars[i].style.color = 'gold'; // Highlight the selected stars
            }
        });
    });
});

function setRequestId(id) {
    document.getElementById('requestId').value = id;
}
</script>
