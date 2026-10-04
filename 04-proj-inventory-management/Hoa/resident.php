<!-- 4/25/2024 -->
<?php include('hoainclude/header.php');?> 
<div class="container-fluid px-4">
                <div class="card mt-4 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
                        <h4 class="my-1 fw-lighter fs-4">Resident</h4>
                            <a href="resident-create" class="btn btn-primary float-end">Add Resident</a>        

</div>
            <div class="card-body">
            <!-- alertMessage() function  -->
            <?php alertMessage(); ?>
           
           <?php 
    $residents = getAll('residents');
    if(!$residents){
        echo '<h4>Something Went ERROR</h4>';
        return false;
    }
    if(mysqli_num_rows($residents) > 0) { ?>
   
                <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-bordered table-hover compact">
                            <thead class="table-dark">
                                    <tr>
                                        <th class="text-start">ID</th>
                                        <th class="text-start">Name</th>
                                        <th class="text-start">Address</th>
                                        <th class="text-start">Email</th>
                                        <th class="text-start">Phone</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>

                                       
                                    </tr>
                            </thead>
                            <tbody>  
    <!-- getAll function -->
     <?php   foreach($residents as $residentItem) : ?>
   
    <tr>
        <td class="text-start"><?= $residentItem['id']?></td>
        <td class="text-start"><?= $residentItem['rname']?></td>
        <td class="text-start"><?= $residentItem['address']?></td>
        <td class="text-start"><?= $residentItem['remail']?></td>
        <td class="text-start"><?= $residentItem['rphone']?></td>

        
        <td class="text-center">
        <?php 
        if($residentItem['ban_resident'] == 1){
            echo '<span class="badge bg-secondary">Inactive</span>';
        }else { 
            echo '<span class="badge bg-primary">Active</span>';
        }
        ?>

        </td>
        <td class="datatables-empty">
            <a href="resident-edit?id=<?= $residentItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
         
            <a hidden href="#" 
             onclick="confirmDelete('resident-delete.php?id=<?= $residentItem['id']; ?>'); return false;" 
             class="btn btn-danger btn-sm">Delete</a> 
    </td>
    </tr>
    <!-- /HTML -->
    <?php endforeach; ?>
    </tbody> 
    </table>
    </div> 

    <?php 
    }else { 
        ?> 
        <tr>
            <h4 class="mb-0">NO RESIDENT RECORD FOUND</h4> 
    </tr>   
            <?php 
    }  
            ?>
       
</div>                     
</div>
</div>

<?php include('hoainclude/footer.php'); ?>