<?php 
include('hoainclude/header.php');

// Fetch archived maintenance requests ordered by creation date in descending order
$archivedRequests = fetchDataPosition('request', '*', 'is_archived = 1', 'created_at DESC', '10');
?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap text-white bg-dark">
            <h4 class="my-1 fw-light fs-4">List Of Completed Requests</h4>
            <a href="maintenance-view" class="btn  btn-primary mt-2 mt-md-0">Go Back</a>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="table-responsive">
                <table id="datatablesSimple" class="text-center">
                    <?php if ($archivedRequests): ?>
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Date Created</th>
                            <th>Name Id</th>
                            <th>Description</th>
                            <th class="text-center">Schedule</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($archivedRequests as $request): ?>
                        <tr>
                             <td class="text-center"><?= date('d M, Y', strtotime($request['created_at'])); ?></td>
                            <td><?= htmlspecialchars($request['resident_id']); ?></td>            
                            <td class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= htmlspecialchars($request['rdescription']); ?>"><?= htmlspecialchars($request['rdescription']); ?></td>
                            <td class="text-center">
                                <?php if ($request['working_date']): ?>
                                    <div class="badge bg-white text-muted">
                                        <?= date('d M, Y', strtotime($request['working_date'])); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">No Scheduled</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="#" 
             onclick="confirmRestore('maintenance-restore-action?id=<?= $request['id']; ?>'); return false;" 
             class="btn btn-archive btn-sm">Restore</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <?php else: ?>
                    <tbody>
                        <tr>
                            <td colspan="7">No archived requests found</td>
                        </tr>
                    </tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('hoainclude/footer.php'); ?>
