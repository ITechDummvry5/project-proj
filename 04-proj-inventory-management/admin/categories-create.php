<?php include('includes/header.php'); ?>
<div class="container-fluid px-4 hide-overflow">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Create Project</h4>
            <a href="categories" class="btn btn-primary float-end">Go Back</a>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <div class="row mt-2">

                    <!-- Model Selection -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label fw-bolder fs-6 mb-1">Model</label>
                        <select name="name" id="modelSelect" class="form-control form-select" required>
                            <option value="">Select a model</option>
                            <option value="Model1">Model 1</option>
                            <option value="Model2">Model 2</option>
                            <!-- <option value="Model3">Model 3</option> -->
                        </select>
                    </div>

                    <!-- Block Selection -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bolder fs-6 mb-1">Select Block</label>
                        <select name="block" id="blockSelect" class="form-control form-select jsselect" required>
                            <option value="">--Select Block--</option>
                            <option value="1">Blk 1</option>
                            <option value="2">Blk 2</option>
                            <option value="3">Blk 3</option>
                            <option value="4">Blk 4</option>
                            <!-- <option value="5">Blk 5</option> -->
                        </select>
                    </div>

                    <!-- Lot Selection -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bolder fs-6 mb-1">Select Lot</label>
                        <select name="lot" id="lotSelect" class="form-control form-select jsselect" required>
                            <option value="">--Select Lot--</option>
                            <!-- Lots for each block will be dynamically updated -->
                        </select>
                    </div>

                    <!-- Automatically Included Description -->
                    <div class="col-md-12 mb-3">
                        <label for="includedDescription" class="form-label fw-bolder fs-6 mb-1">Description</label>
                        <textarea name="floorarea" id="includedDescription" class="form-control" rows="5" readonly style="resize: none;"></textarea>
                    </div>

                    <!-- Optional Fence and Gate Dropdown -->
                    <div class="col-md-12 mb-3">
                        <label for="fenceOption" class="form-label fw-bolder fs-6 mb-1">Optional Fence and Gate</label>
                        <select name="fence_option" id="fenceOption" class="form-control form-select" required>
                            <option value="">--Select Option--</option>
                            <option value="With Fence and Gate">With Fence and Gate</option>
                            <option value="Without Fence and Gate">Without Fence and Gate</option>
                        </select>
                    </div>

                    <!-- Save Button -->
                    <div class="col-md-12 mb-1 mt-3 text-end">
                        <button type="submit" name="savedCategory" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    
const modelSelect = document.getElementById('modelSelect');
const includedDescription = document.getElementById('includedDescription');
const blockSelect = document.getElementById('blockSelect');
const lotSelect = document.getElementById('lotSelect');
const fenceOption = document.getElementById('fenceOption');

// Model Descriptions
const modelDescriptions = {
    "Model1": `Floor Area: 32.35 sq.m.
Min Lot Area: 80 sq.m.
Provision for 2 Bedrooms, 1 T&B
Provision for carport`,

    "Model2": `Floor Area: 49.54 sq.m. (Inner/End Unit)
48.54 sq.m. (Corner Unit)
Minimum Lot Area: 60 sq.m.
Provision for 2 Bedrooms, 1 T&B
Provision for carport`,

// "Model3": `Floor Area: 69.54 sq.m.
// 50.54 sq.m. (Corner Unit)
// Minimum Lot Area: 70 sq.m.
// Provision for 4 Bedrooms, 2 T&B
// Provision for carport`
};


// Update Model Description
modelSelect.addEventListener('change', function () {
    const selectedModel = modelSelect.value;
    if (selectedModel) {
        // Update floor area and description based on model selection
        includedDescription.value = modelDescriptions[selectedModel];
    } else {
        includedDescription.value = ''; // Reset if no model selected
    }
});

// Update Lot Options Based on Selected Block
blockSelect.addEventListener('change', function () {
    const selectedBlock = blockSelect.value;
    lotSelect.innerHTML = '<option value="">--Select Lot--</option>'; // Clear previous lots

    if (selectedBlock && blockLots[selectedBlock]) {
        const maxLots = blockLots[selectedBlock];
        for (let i = 1; i <= maxLots; i++) {
            lotSelect.innerHTML += `<option value="${i}">Lot ${i}</option>`;
        }
    }
});

// Update Description on Fence Option Change (No Append)
fenceOption.addEventListener('change', function () {
    const selectedModel = modelSelect.value;
    if (selectedModel) {
        // Update description with the base model description only
        includedDescription.value = modelDescriptions[selectedModel];
    } else {
        includedDescription.value = ''; // Reset if no model selected
    }
});



</script>

<?php include('includes/footer.php'); ?>
