<?php 
include('rinclude/header.php');  
?>

<style>
    .carousel-item {
        height: 300px; /* Set a fixed height */
    }

    .carousel-item img {
        width: 100%; /* Make the image take the full width of the carousel item */
        height: 100%; /* Make the image take the full height of the carousel item */
        object-fit: cover; /* Ensure the image covers the entire area */
    }

    /* Custom Modal Backdrop Styling */
    .modal-backdrop.show {
        opacity: 0.7; /* Adjust the opacity */
        background-color: black; /* Set the background color */
        backdrop-filter: blur(5px); /* Optional blur effect */
    }
</style>

<section class="py-2 mt-4 page-3">
    <div class="container px-2" style="max-width: 1150px; margin: 0 auto;">
        <h1 class="fw-bolder fs-5 mb-2">Announcement</h1>
        <a href="calendar.php" class="btn btn-primary mb-2" target="_blank">View Calendar</a>
        <?php alertMessage(); ?>

        <?php  
        $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'DESC';
        $announcement = hgetAll('announcement', "ORDER BY id $sortOrder"); 

        if(!$announcement){
            echo '<h4>Error retrieving announcements!</h4>';
            return;
        }

        if(mysqli_num_rows($announcement) > 0) { 
            $charLimit = 200; 
            $count = 0; 
        ?>

        <div id="announcement-container">
            <?php while($content = mysqli_fetch_assoc($announcement)) : 
                $count++;
                $announcementBody = ($content['body']);
                $shortText = (strlen($announcementBody) > $charLimit) ? substr($announcementBody, 0, $charLimit) . '...' : $announcementBody;
                $fullText = (strlen($announcementBody) > $charLimit) ? $announcementBody : ''; 
                $displayStyle = $count > 3 ? 'display: none;' : '';
                $images = explode(",", $content['image']);
            ?>

            <div class="card border-0 shadow-sm mb-4 announcement-item" style="<?= $displayStyle ?>">
                <div class="row g-0">
                    <div class="col-lg-7">
                        <div class="card-body p-5">
                            <div class="badge bg-primary rounded-pill mb-1">News</div>
                            <h1 class="fw-bolder fs-3 mb-3"><?= htmlspecialchars($content['heading']) ?></h1>
                            <p id="short-text-<?= $content['id'] ?>" class="fs-6" style="white-space: pre-wrap;"><?= nl2br(htmlspecialchars($shortText)) ?></p>

                            <?php if ($fullText): ?>
                                <p id="full-text-<?= $content['id'] ?>" class="fs-6" style="display: none; white-space: pre-wrap;"><?= nl2br(htmlspecialchars($fullText)) ?></p>
                                <div class="d-flex">
                                    <a href="javascript:void(0);" onclick="toggleReadMore(<?= $content['id'] ?>)" id="read-more-link-<?= $content['id'] ?>" class="btn btn-primary btn-sm me-1">Read more</a>
                                    <a href="javascript:void(0);" onclick="toggleReadMore(<?= $content['id'] ?>)" id="read-less-link-<?= $content['id'] ?>" class="btn btn-secondary btn-sm" style="display: none;">Read less</a>
                                </div>
                            <?php endif; ?>

                            <p class="text-muted fs-7 mt-1">Published on: <?= date('F j, Y ', strtotime($content['hcreated_at'])) ?></p>
                        </div>
                    </div>
                    
                    <!-- Bootstrap Carousel for Image Slider -->
                    <div class="col-lg-5 bg-light d-flex justify-content-center align-items-center">
                        <div id="carousel-<?= $content['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($images as $index => $imagePath): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="../<?= htmlspecialchars($imagePath) ?>" class="d-block w-100 h-100" alt="announcement image" data-bs-toggle="modal" data-bs-target="#imagePreviewModal" onclick="showImagePreview('../<?= htmlspecialchars($imagePath) ?>')">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $content['id'] ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $content['id'] ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php endwhile; ?>
        </div>

        <?php if ($count > 3): ?>
            <div id="see-more-container">
                <svg id="see-more-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" onclick="seeMore()" style="cursor: pointer;">
                    <title>Arrow Down</title>
                    <path d="M12,24A12,12,0,1,1,24,12,12.013,12.013,0,0,1,12,24ZM12,2A10,10,0,1,0,22,12,10.011,10.011,0,0,0,12,2Z"/>
                    <polygon points="12 18.414 7.293 13.707 8.707 12.293 12 15.586 15.293 12.293 16.707 13.707 12 18.414"/>
                    <rect x="11" y="6" width="2" height="11"/>
                </svg>
            </div>
        <?php endif; ?>

        <?php 
        } else { 
        ?> 
            <h5 class="mb-0">Currently no Announcements!</h5> 
        <?php 
        }  
        ?>
    </div>
</section>

<!-- Modal for Image Preview -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="imagePreviewModalLabel">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="previewImage" src="" class="img-fluid" alt="Preview">
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to toggle between short and full text -->
<script>
function toggleReadMore(id) {
    var shortText = document.getElementById('short-text-' + id);
    var fullText = document.getElementById('full-text-' + id);
    var readMoreLink = document.getElementById('read-more-link-' + id);
    var readLessLink = document.getElementById('read-less-link-' + id);
    
    if (fullText.style.display === 'none') {
        shortText.style.display = 'none';
        fullText.style.display = 'block';
        readMoreLink.style.display = 'none';
        readLessLink.style.display = 'inline';

        // Send AJAX request to mark the announcement as read
        fetch('rcode.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `announcement_id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Announcement marked as read.");
            } else {
                console.error("Failed to mark announcement as read.");
            }
        })
        .catch(error => console.error("Error:", error));
    } else {
        shortText.style.display = 'block';
        fullText.style.display = 'none';
        readMoreLink.style.display = 'inline';
        readLessLink.style.display = 'none';
    }
}

let currentCount = 3;

function seeMore() {
    const allAnnouncements = document.querySelectorAll('.announcement-item');
    let displayedCount = 0;

    allAnnouncements.forEach((item, index) => {
        if (index >= currentCount && displayedCount < 3) {
            item.style.display = 'block';
            displayedCount++;
        }
    });

    currentCount += displayedCount;

    if (currentCount >= allAnnouncements.length) {
        document.getElementById('see-more-container').style.display = 'none';
    }
}

function showImagePreview(imageSrc) {
    document.getElementById('previewImage').src = imageSrc;
}
</script>

