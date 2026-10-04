<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 mb-0 fw-lighter fs-4">Edit Material</h4>
            <a href="products" class="btn btn-primary float-end">Go Back</a>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">
                <?php 
                    $paramValue = checkParamId('id');
                    if (!is_numeric($paramValue)) {
                        echo '<h5> Id is not Int</h5>';
                        return false;
                    }
                    $product = getById('products', $paramValue);
                    if ($product && $product['status'] == 200) {
                ?>
                <!-- hidden Id -->
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['data']['id']); ?>">

                <div class="row">
                <div class="col-md-12 mb-2">
    <label class="form-label fw-bolder fs-6 mb-2">Select Project *</label>
    <select required name="category_id" class="form-select jsselect">
        <option value="" class="fw-bolder fs-6">Select Project</option>
        <?php  
            $categories = getAll('categories');
            if ($categories && mysqli_num_rows($categories) > 0) {
                foreach ($categories as $categoItem) {
                    // Combine category name and block_lot for display
                    $displayName = htmlspecialchars($categoItem['name']) . ' (Blk & Lot: ' . htmlspecialchars($categoItem['block_lot']) . ')';
        ?>
        <option class="fw-light fs-6" value="<?= htmlspecialchars($categoItem['id']); ?>"
            <?= $product['data']['category_id'] == $categoItem['id'] ? 'selected' : ''; ?>>
            <?= $displayName; ?>
        </option>
        <?php
                }
            } else {
                echo '<option value="">No Categories Found!</option>';
            }
        ?>
    </select>
</div>

<div class="col-md-12 mb-3 mt-1">
    <label class="form-label fw-bolder fs-6 mb-1">Category</label>
    <select name="materialcategory" class="form-select jsselect" required>
        <option value="" class="fw-bolder fs-6">Select Category</option>
        <option value="Concreating" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Concreating' ? 'selected' : ''; ?>>Concreating</option>
        <option value="Forms" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Forms' ? 'selected' : ''; ?>>Forms</option>
        <option value="Roof Framing" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Roof Framing' ? 'selected' : ''; ?>>Roof Framing</option>
        <option value="Roof Panels Long Span" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Roof Panels Long Span' ? 'selected' : ''; ?>>Roof Panels Long Span</option>
        <option value="Windows" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Windows' ? 'selected' : ''; ?>>Windows</option>
        <option value="Lockset" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Lockset' ? 'selected' : ''; ?>>Lockset</option>
        <option value="Waterline" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Waterline' ? 'selected' : ''; ?>>Waterline</option>
        <option value="SewerLine" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'SewerLine' ? 'selected' : ''; ?>>SewerLine</option>
        <option value="Electrical" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Electrical' ? 'selected' : ''; ?>>Electrical</option>
        <option value="Plumbing Fixture" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Plumbing Fixture' ? 'selected' : ''; ?>>Plumbing Fixture</option>
        <option value="Painting Works" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Painting Works' ? 'selected' : ''; ?>>Painting Works</option>
        <option value="Ceiling Works" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Ceiling Works' ? 'selected' : ''; ?>>Ceiling Works</option>
        <option value="Tile Works" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'Tile Works' ? 'selected' : ''; ?>>Tile Works</option>
        <option value="HandDrills & Railing Stairs" class="fw-light fs-6" <?= $product['data']['materialcategory'] == 'HandDrills & Railing Stairs' ? 'selected' : ''; ?>>HandDrills & Railing Stairs</option>
    </select>
</div>


<div class="col-md-4 mb-1">
    <label class="form-label fw-bolder fs-6 mb-2">Material Name *</label>
    <select name="name" class="form-select jsselect" required>
        <option value="" class="fw-bolder fs-6">Select Material</option>
        <option value="Cement" class="fw-light fs-6" <?= $product['data']['name'] == 'Cement' ? 'selected' : ''; ?>>Cement</option>
        <option value="Sand" class="fw-light fs-6" <?= $product['data']['name'] == 'Sand' ? 'selected' : ''; ?>>Sand</option>
        <option value="Gravel" class="fw-light fs-6" <?= $product['data']['name'] == 'Gravel' ? 'selected' : ''; ?>>Gravel</option>
        <option value="Steel Bars" class="fw-light fs-6" <?= $product['data']['name'] == 'Steel Bars' ? 'selected' : ''; ?>>Steel Bars</option>
        <option value="Wood" class="fw-light fs-6" <?= $product['data']['name'] == 'Wood' ? 'selected' : ''; ?>>Wood</option>
        <option value="Paint" class="fw-light fs-6" <?= $product['data']['name'] == 'Paint' ? 'selected' : ''; ?>>Paint</option>
        <option value="Tiles" class="fw-light fs-6" <?= $product['data']['name'] == 'Tiles' ? 'selected' : ''; ?>>Tiles</option>
        <option value="Bricks" class="fw-light fs-6" <?= $product['data']['name'] == 'Bricks' ? 'selected' : ''; ?>>Bricks</option>
        <option value="Pipes" class="fw-light fs-6" <?= $product['data']['name'] == 'Pipes' ? 'selected' : ''; ?>>Pipes</option>
        <option value="Electrical Wires" class="fw-light fs-6" <?= $product['data']['name'] == 'Electrical Wires' ? 'selected' : ''; ?>>Electrical Wires</option>
    </select>
</div>

                    

                    <div class="col-md-8 mb-1">
                        <label class="form-label fw-bolder fs-6 mb-2">Material Description *</label>
                        <div class="input-group mb-1">
                            <input type="text" name="description" id="description" value="<?= htmlspecialchars($product['data']['description']); ?>" class="form-control text-muted">
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
                        <input type="hidden" name="unit" id="unitInput" value="">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label fw-bolder fs-6 mb-1">Add Material Quantity *</label>
                        <input type="number" id="quantityAdd" name="quantity_add" value="" minlength="1" maxlength="4" max="1000" class="form-control text-muted">
                        <small class="form-text text-muted">Enter the quantity to add</small>
                    </div>

                    <div class="col-md-8 mb-2">
                        <label class="form-label fw-bolder fs-6 mb-1">Material Remark (Optional) *</label>
                        <input type="text" name="premark" value="<?= htmlspecialchars($product['data']['premark']); ?>" class="form-control text-muted">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="image" class="form-label fw-bolder fs-6 mb-1">Material Image *</label>
                        <input type="file" id="image" name="image" class="form-control text-muted">
                        <div class="mt-2">
                            <img src="../<?= htmlspecialchars($product['data']['image']); ?>" alt="product" class="img-fluid">
                        </div>
                    </div>

                    <div class="col-md-12 text-end">
                        <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                    } else {
                        echo '<h5>'.$product['message'].'</h5>';
                        return false;
                    }
                ?>
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
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('description');
    const unitDropdown = document.getElementById('unitDropdown');
    const unitInput = document.getElementById('unitInput');

    

    // Function to remove any existing unit (in parentheses) from the description
    function removeExistingUnit(description) {
        const units = [
            'Cu.m',
            'Pc/s',
            'Kl/s',
            'GL/s',
            'Set/s',
            'METERS/s',
            'GAL/s',
            'LTR/s',
            'BAG/s',
            'SET',
            'QTR.',
            'CAN',
            'PC',
            'BAGS',
            'BOX',
            'LITERS',
            'KL',
            'ROLL'
        ];

        units.forEach(unit => {
            const escapedUnit = unit.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'); // Escape special characters for regex
            const regex = new RegExp(`\\s*\\(${escapedUnit}\\)$`, 'i'); // Case-insensitive match
            description = description.replace(regex, '');
        });

        return description.trim();
    }

    // When the user selects a unit from the dropdown
    unitDropdown.addEventListener('click', function (event) {
        if (event.target.classList.contains('dropdown-item')) {
            event.preventDefault();

            const selectedUnit = event.target.getAttribute('data-unit');

            // Remove any existing unit from the description
            const currentDescription = textarea.value;
            const cleanedDescription = removeExistingUnit(currentDescription);

            // Update the description with the new unit
            textarea.value = `${cleanedDescription}${selectedUnit ? ` (${selectedUnit})` : ''}`;

            // Store the selected unit in the hidden input field
            unitInput.value = selectedUnit;

            // Update the character count
            updateCharCount();
        }
    });

    // Update character count on input
    textarea.addEventListener('input', updateCharCount);
});

    document.getElementById('quantityAdd').addEventListener('keydown', function(event) {
        // Check if the key pressed is 'e' or 'E'
        if (event.key === 'e' || event.key === 'E') {
            event.preventDefault(); // Prevent the letter 'e' from being entered
        }
    });
</script>

<?php include('includes/footer.php'); ?>
