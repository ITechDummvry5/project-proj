<!--Date 4/24/2024-->

</main>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; ITDumvry IMS 2024</div>
            <div>
                <!-- <a href="#">Privacy Policy</a> -->
                &middot;
                <!-- <a href="#">Terms &amp; Conditions</a> -->
            </div>
        </div>
    </div>
</footer>

</div>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebar.min.js"></script>
<script src="../assets/js/font-awesome.min.js" ></script>
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/sweetalert2.min.js"></script>
<script src="../assets/js/data-table-library.js"></script>
<script src="../assets/js/data-table-start-demo.js"></script>
<script src="../assets/js/select.min.js"></script>

<script src="assets/js/moment.min.js"></script>
<script src="assets/js/fullcalendar.min.js"></script>
<script src="assets/js/alertify.min.js"></script>
<script src="assets/js/hoa.custom.js"></script>
<script src="assets/js/chart.min.js"></script>


<script>
function confirmDelete(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Cancel!',
                text: 'Your input has been cancel.',
                icon: 'success'
            }).then(() => {
                // Redirect to the delete URL
                window.location.href = url;
            });
        }
    });
}

function confirmArchive(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You Done with this Request!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#6f42c1',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Complete Task!',
                text: 'Resident Request has been Done.',
                icon: 'success'
            }).then(() => {
                // Redirect to the delete URL
                window.location.href = url;
            });
        }
    });
}
function confirmRestore(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You Restoring this Request!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#6f42c1',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Restored!',
                text: 'The record has been restored.',
                icon: 'success'
            }).then(() => {
                // Redirect to the restore URL
                window.location.href = url;
            });
        }
    });
}

//hover tooltip
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
            </script>
</body>
</html>