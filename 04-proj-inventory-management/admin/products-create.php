<!-- 4/25/2024 -->
<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Create Material</h4>
            <a href="products" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <div class="row mt-2">
                    <!-- Category Selection -->
                    <div class="col-md-12 mb-3 mt-1">
                        <select name="category_id" class="form-select jsselect" required>
                            <option value="" class="fw-bolder fs-6">Select Project</option>
                            <?php
                            $categories = getAll('categories');
                            if ($categories) {
                                while ($categoItem = mysqli_fetch_assoc($categories)) {
                                    $displayName = htmlspecialchars($categoItem['name']) . ' (Blk & Lot: ' . htmlspecialchars($categoItem['block_lot']) . ')';
                                    echo '<option class="fw-light fs-6" value="' . htmlspecialchars($categoItem['id']) . '">' . $displayName . '</option>';
                                }
                            } else {
                                echo '<option value="">No Categories Found!</option>';
                            }
                            ?>
                        </select>
                    </div>

                      <!-- Category Selection (New Category Dropdown) -->
                      <div class="col-md-12 mb-3 mt-1">
                        <label class="form-label fw-bolder fs-6 mb-1">Category Material</label>
                        <select name="materialcategory" class="form-select jsselect" required>
                            <option value="" class="fw-bolder fs-6">Select Category</option>
                            <option value="Concreating" class="fw-light fs-6">Concreating</option>
                            <option value="Forms" class="fw-light fs-6">Forms</option>
                            <option value="Roof Framing" class="fw-light fs-6">Roof Framing</option>
                            <option value="Roof Panels Long Span" class="fw-light fs-6">Roof Panels Long Span</option>
                            <option value="Windows" class="fw-light fs-6">Windows</option>
                            <option value="Lockset" class="fw-light fs-6">Lockset</option>
                            <option value="Waterline" class="fw-light fs-6">Waterline</option>
                            <option value="SewerLine" class="fw-light fs-6">SewerLine</option>
                            <option value="Electrical" class="fw-light fs-6">Electrical</option>
                            <option value="Plumbing Fixture" class="fw-light fs-6">Plumbing Fixture</option>
                            <option value="Painting Works" class="fw-light fs-6">Painting Works</option>
                            <option value="Ceiling Works" class="fw-light fs-6">Ceiling Works</option>
                            <option value="Tile Works" class="fw-light fs-6">Tile Works</option>
                            <option value="HandDrills & Railing Stairs" class="fw-light fs-6">HandDrills & Railing Stairs</option>
                        </select>
                    </div>

                       <!-- Material Name Dropdown -->
                       <div class="col-md-4 mb-3">
                        <label class="form-label fw-bolder fs-6 mb-1">Material Name</label>
                        <select name="name" class="form-select jsselect"  required>
                            <option value="" class="fw-bolder fs-6">Select Material</option>
                            <option value="Cement" class="fw-light fs-6">Cement</option>
                            <option value="Sand" class="fw-light fs-6">Sand</option>
                            <option value="Gravel" class="fw-light fs-6">Gravel</option>
                            <option value="Steel Bars" class="fw-light fs-6">Steel Bars</option>
                            <option value="Wood" class="fw-light fs-6">Wood</option>
                            <option value="Paint" class="fw-light fs-6">Paint</option>
                            <option value="Tiles" class="fw-light fs-6">Tiles</option>
                            <option value="Bricks" class="fw-light fs-6">Bricks</option>
                            <option value="Pipes" class="fw-light fs-6">Pipes</option>
                            <option value="Electrical Wires" class="fw-light fs-6">Electrical Wires</option>
                        </select>
                    </div>

                    <div class="col-md-8 mb-1">
                        <label class="form-label fw-bolder fs-6 mb-1">Material Description</label>
                        <div class="input-group mb-3">
                            <input type="text" name="description" id="description" class="form-control" aria-label="Text input with dropdown button" required>
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Select Unit</button>
                            <ul class="dropdown-menu dropdown-menu-end" id="unitDropdown">
                                <li><a class="dropdown-item" href="#" data-unit="Cu.m">Cu.m</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="Pc/s">Pc/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="Kl/s">Kl/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="GL/s">GL/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="Set/s">Set/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="METERS/s">METERS/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="GAL/s">GAL/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="LTR/s">LTR/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="BAG/s">BAG/s</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="SET">SET</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="QTR.">QTR.</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="CAN">CAN</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="PC">PC</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="BAGS">BAGS</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="BOX">BOX</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="LITERS">LITERS</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="KL">KL</a></li>
                                <li><a class="dropdown-item" href="#" data-unit="ROLL">ROLL</a></li>
                            </ul>
                        </div>
                        <input type="hidden" name="unit" id="unit">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bolder fs-6 mb-1">Material Quantity</label>
                        <input type="number" name="quantity" min="1" max="1000" class="form-control" required>
                    </div>
                    
                    <div class="col-md-8 mb-3 d-none">
                        <label class="form-label fw-bolder fs-6 mb-1">Material Remark (Optional)</label>
                        <input type="text" name="premark" class="form-control">
                    </div>

                    <div class="col-md-8 mb-2">
                        <label class="form-label fw-bolder fs-6 mb-1">Material Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-12 text-end">
                        <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
  /* Limit dropdown height and make it scrollable without showing scroll indicators */
#unitDropdown {
    max-height: 200px; /* Adjust this value as needed */
    overflow-y: scroll; /* Enable scrolling */
    scrollbar-width: none; /* For Firefox to hide the scrollbar */
    -ms-overflow-style: none; /* For Internet Explorer and Edge to hide the scrollbar */
}

#unitDropdown::-webkit-scrollbar {
    display: none; /* For Webkit browsers (Chrome, Safari, etc.) to hide the scrollbar */
}

/* Style to visually show the top 5 items initially */
#unitDropdown .dropdown-item:nth-child(n+6) {
    display: none;
}

/* When the dropdown is open, display all items */
#unitDropdown.showAll .dropdown-item:nth-child(n+6) {
    display: block;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const descriptionInput = document.getElementById('description');
    const unitInput = document.getElementById('unit');
    const unitDropdown = document.getElementById('unitDropdown');

    // Handle unit selection from the dropdown
    const unitOptions = document.querySelectorAll('.dropdown-item');
    unitOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedUnit = this.getAttribute('data-unit');

            // Update the hidden input with the selected unit
            unitInput.value = selectedUnit;

            // Append the selected unit to the description field
            const currentDescription = descriptionInput.value;
            const updatedDescription = currentDescription.replace(/\s*\(.*?\)$/, '') + (selectedUnit ? ` (${selectedUnit})` : '');
            descriptionInput.value = updatedDescription;
        });
    });

    // Toggle to show all dropdown items when expanded
    const toggleDropdown = () => {
        unitDropdown.classList.toggle('showAll');
    };

    // Trigger the toggle when the dropdown button is clicked
    const dropdownButton = document.querySelector('.dropdown-toggle');
    dropdownButton.addEventListener('click', toggleDropdown);
});
</script>

<?php include('includes/footer.php'); ?>
