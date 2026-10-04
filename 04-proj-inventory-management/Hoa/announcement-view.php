<?php 
include('hoainclude/header.php');
// Fetch announcements ordered by creation date in descending order
$announcements = fetchAll('announcement', '*', "ORDER BY id DESC");
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Announcements</h4>
            <a href="announcement-create" class="btn btn-primary mt-2 mt-md-0 ">Create Announcement</a>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <?php if ($announcements): // Check if there are announcements ?>
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Heading</th>
                            <th>Body</th>
                            <th class="text-center">Image</th>
                            <th>Date Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($announcements as $announcement): ?>
                        <tr>
                            <td><?= $announcement['id']; ?></td>
                            <td><?= htmlspecialchars($announcement['heading']); ?></td>
                            <td style="max-width: 150px;" class="text-truncate" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= htmlspecialchars($announcement['body']); ?>">
                                <?= htmlspecialchars($announcement['body']); ?></td>
                            <td style="text-align: center; vertical-align: middle;">
                                <?php 
                                // Get the images and use the first one as the representative image
                                $existingImages = explode(',', $announcement['image']);
                                $firstImage = $existingImages[0]; // Take the first image for display
                                ?>
                                <img src="../<?= htmlspecialchars($firstImage); ?>"
                                     alt="Announcement Image" 
                                     class="img-fluid" 
                                     style="width: 100px; height: 50px; object-fit: cover;">
                            </td>
                            <td><?= date('d M, Y h:i A', strtotime($announcement['hcreated_at'])); ?></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="announcement-edit?id=<?= $announcement['id']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                    <a href="#" 
                                       onclick="confirmDelete('announcement-delete?id=<?= $announcement['id']; ?>'); return false;" 
                                       class="btn btn-danger btn-sm">Delete</a> 
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <?php else: // If no announcements ?>
                    <tbody>
                        <tr>
                            <td colspan="6">No announcements found</td>
                        </tr>
                    </tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('hoainclude/footer.php'); ?>
