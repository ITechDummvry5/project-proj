<!-- 4/25/2024 -->
<?php include('includes/header.php');
?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm" >
                        <div class="card-header d-flex justify-content-between align-items-center  text-white bg-dark">
                        <h4 class="my-1 fw-lighter fs-4">Add Contractor</h4>
                        <a href="customers.php" class="btn btn-primary float-end">View Contractor</a>            
</div>

            <div class="card-body">
            <!-- alertMessage() function -->
               <?php alertMessage(); ?>
                <form action="code.php" method="POST">

                <!-- form email check function -->
                <div class="row">
                <!-- Change the "Company Name" input field to a dropdown -->
<div class="col-md-6 mb-1">
    <label class="badge bg-primary bg-gradient rounded-1">Company Name</label>
    <select name="name" class="form-select" required>
        <option value="Jp Luis Construction">Jp Luis Construction</option>
        <option value="Dexter Construction">Dexter Construction</option>
        <option value="Coxx Construction">Coxx Construction</option>
    </select>
</div>


                    <div class="col-md-6 mb-2 ">
                        <label class="badge bg-primary bg-gradient rounded-1">Email</label>
                        <input type="email" name="email"  class="form-control"  required>
                    </div>
<div class="col-md-6 mb-2">     <!-- default null.number of column margin 3-->
                        <label class="badge bg-primary bg-gradient rounded-1">Phone</label>
                        <input type="tel" name="phone" minlength="11" maxlength="11" class="form-control" required>
                    </div>

                    <div class="col-md-6 mt-2">
  <label class="checkbox" for="status-checkbox" style="display: none;">
    <input type="checkbox" name="status" id="status-checkbox">
    <span class="checkmark"></span>
    <span class="label">
      <span class="">
        Unchecked <span class="badge bg-secondary">Pending</span> 
        <br>
        Checked <span class="badge bg-primary">Completed</span>
      </span>
    </span>
  </label>
</div>


<div class=" col-md-12 mb-1 text-end">  <!--number of column margin 3-->
                    <button type="submit" name="savedCustomers" class="btn btn-primary">Save</button>
                    </div>
                </div>
          </form>

</div>
</div>
</div>

<?php include('includes/footer.php'); ?>