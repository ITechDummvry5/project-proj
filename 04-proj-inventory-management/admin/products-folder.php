<?php
include('includes/header.php'); 
?>
<div class="container-fluid px-4">
    <div class="card mt-4 border-0">
        <div class="card-header text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4 d-flex justify-content-between align-items-center">
            Project Materials  
            </h4>
        </div>
        <div class="card-body" id="categoriesSection">
            <div class="row g-2">
                <?php
                $projectQuery = "SELECT id, name, block_lot FROM categories ORDER BY 
                                    CAST(SUBSTRING_INDEX(block_lot, '-', 1) AS UNSIGNED) ASC, 
                                    CAST(SUBSTRING_INDEX(block_lot, '-', -1) AS UNSIGNED) ASC";
                $ProjectResult = mysqli_query($conn, $projectQuery);

                if ($ProjectResult && mysqli_num_rows($ProjectResult) > 0): 
                    while ($projects = mysqli_fetch_assoc($ProjectResult)):
                        $displayName = 'Blk & Lot: ' . htmlspecialchars($projects['block_lot']);
                        
                        $outOfStockCount = getOutOfStockCountByCategory($projects['id']);    
                        $remarkMessage = getcountremarkMessage($projects['id']);
                ?>
                    <div class="col-md-4 col-lg-3">
                        <a href="products-folder-detail.php?category_id=<?= $projects['id']; ?>" class="text-decoration-none text-muted">
                            <div class="card h-100 border-0">
                                <div class="card-body p-2 text-center">
                                    <div class="mt-3">
                                        <div class="bg-white py-1 px-3 rounded-md shadow-sm position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="56" height="46" viewBox="0 0 256 256" xml:space="preserve">

<defs>
</defs>
<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
	<circle cx="45" cy="45" r="45" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(32,196,203); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
	<path d="M 67.145 33.529 L 46.832 21.112 c -1.988 -1.215 -4.673 -1.215 -6.661 0 L 19.859 33.529 c -2.989 1.827 -2.945 5.096 -0.947 7.066 v 27.457 c 0 1.509 1.46 2.744 3.245 2.744 h 42.689 c 1.785 0 3.245 -1.235 3.245 -2.744 V 40.594 C 70.091 38.625 70.134 35.356 67.145 33.529 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(27,167,173); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
	<path d="M 70.141 30.533 L 49.828 18.116 c -1.988 -1.215 -4.673 -1.215 -6.661 0 L 22.855 30.533 c -2.989 1.827 -2.945 5.096 -0.947 7.066 v 27.457 c 0 1.509 1.46 2.744 3.245 2.744 h 42.689 c 1.785 0 3.245 -1.235 3.245 -2.744 V 37.599 C 73.086 35.629 73.13 32.36 70.141 30.533 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
</g>
</svg>
                                            <?php if ($outOfStockCount > 0) : ?>
                                                <span class="badge bg-danger position-absolute" style="top: -15px; right: 0;"><?= $outOfStockCount; ?></span>
                                            <?php endif; ?>
                                            <?php if ($remarkMessage > 0) : ?>
                                                <span class="badge bg-primary position-absolute" style="top: -15px; right: 25px;"><?= $remarkMessage; ?></span>
                                            <?php endif; ?>
                                            <p class="mb-0"><?= $displayName; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; else: ?>
                    <p>No projects or Projects found!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>
