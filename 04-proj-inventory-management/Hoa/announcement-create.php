<!-- 4/25/2024 -->
<?php include('hoainclude/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center  text-white bg-dark">
                        <h4 class="my-1 fw-lighter fs-4">Post Announcement</h4>
                            <a href="announcement-view" class="btn btn-primary float-end">View Announcements</a>
                        
</div>
            <div class="card-body">
            <!-- alertMessage() function -->
               <?php alertMessage(); ?>
                <form action="resident-code.php" method="POST" enctype="multipart/form-data">
                
                <!-- GETall check function -->
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label for="heading" class="badge bg-primary bg-gradient rounded-1 mb-2">Heading</label>
                        <input type="text" name="heading"  id="heading" class="form-control"  required>
                    </div> 
                    
                    <div class="col-md-12 mb-3 w-80">     <!--product-->
                        <label for="body" class="badge bg-primary bg-gradient rounded-1 mb-2">Body</label>
                       <textarea name="body" cols="10" rows="4" id="body" class="form-control"></textarea>
                    </div>


                    <div class="col-md-12 mb-2 mt-1">
                    <label for="images" class="badge bg-primary bg-gradient rounded-1 mb-2">Images</label>
    <input type="file" name="images[]" class="form-control" multiple required>
    <small class="form-text text-muted">You can upload up to 3 images.</small>  <!--Configure This -->
                    </div> 

                    <!-- Event Calendar Toggle Button -->
                    <div class="col-md-12 mb-3">
                        <button type="button" id="showCalendarBtn" class="btn btn-secondary">Show Calendar</button>
                    </div>

                    <!-- Calendar Section (Initially Hidden) -->
                    <div class="col-md-12 mb-3" id="calendarSection" style="display: none;">
                        <label for="calendar" class="badge bg-primary bg-gradient rounded-1 mb-2">Select Event Date</label>
                        <div id="calendar"></div>
                    </div>

                    <!-- Hidden Inputs for Start and End Date -->
                    <input type="hidden" name="start_date" id="start_date">
                    <input type="hidden" name="end_date" id="end_date">

                    <!-- Reset Button (Initially Hidden) -->
                    <div class="col-md-12 mb-3 text-start" id="resetSection" style="display: none;">
                        <button type="button" id="resetDates" class="btn btn-warning">Reset Dates</button>
                    </div>

                    <div class=" col-md-12  mb-3 text-end">  <!--number of column margin 3-->
                    <button type="submit" name="saveAnnouncement" class="btn btn-primary">Save Announcement</button>
                    </div>
                </div>
          </form>
        </div>
    </div>
</div>


<?php include('hoainclude/footer.php'); ?>

<script>

$(document).ready(function() {
    var startDateSelected = false;
    var endDateSelected = false;
    var startDate = null;
    var endDate = null;

    // Fetch events from the database (PHP)
    $.ajax({
        url: 'fetch-announcements.php', // Your PHP file to fetch announcements
        method: 'GET',
        dataType: 'json',
        success: function(events) {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: events, // Pass the events to the calendar
                selectable: true,
                select: function(start, end) {
                    // Format the selected start and end dates without the time part (YYYY-MM-DD)
                    var formattedStartDate = moment(start).format('YYYY-MM-DD'); // Only date
                    var formattedEndDate = moment(end).format('YYYY-MM-DD'); // Only date

                    // If start date is not selected yet
                    if (!startDateSelected) {
                        $('#start_date').val(formattedStartDate); // Send only the date part
                        startDate = start;
                        startDateSelected = true;

                        // Add the start date to the calendar (green color for start date)
                        $('#calendar').fullCalendar('renderEvent', {
                            title: 'Start Date: ' + formattedStartDate,
                            start: start,
                            allDay: true,
                            backgroundColor: 'green',
                            borderColor: 'green'
                        });

                        // Show SweetAlert for Start Date Selection
                        Swal.fire({
                            title: 'Start Date Selected',
                            text: 'You selected the start date: ' + formattedStartDate,
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        });
                    }
                    // If start date is already selected, handle end date selection
                    else if (startDateSelected && !endDateSelected) {
                        // Check if the end date is valid (cannot be before start date)
                        if (start.isBefore(startDate)) {
                            Swal.fire({
                                title: 'Invalid End Date',
                                text: 'End date cannot be before the start date. Please select a valid date.',
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        } else {
                            $('#end_date').val(formattedEndDate); // Send only the date part
                            endDate = start;
                            endDateSelected = true;

                            // Add the end date to the calendar (red color for end date)
                            $('#calendar').fullCalendar('renderEvent', {
                                title: 'End Date: ' + formattedEndDate,
                                start: start,
                                allDay: true,
                                backgroundColor: 'red',
                                borderColor: 'red'
                            });

                            // Show SweetAlert for End Date Selection
                            Swal.fire({
                                title: 'End Date Selected',
                                text: 'You selected the end date: ' + formattedEndDate,
                                icon: 'success',
                                confirmButtonText: 'Okay'
                            });
                        }
                    }
                },
                eventClick: function(event) {
                    // This function is triggered when an event is clicked
                    var eventTitle = event.title;
                    var eventStartDate = moment(event.start).format('YYYY-MM-DD');
                    var eventEndDate = moment(event.end).format('YYYY-MM-DD');

                    // Show event details in SweetAlert2
                    Swal.fire({
                        title: eventTitle,
                        text: `Start Date: ${eventStartDate}\nEnd Date: ${eventEndDate}`,
                        icon: 'info',
                        confirmButtonText: 'Close'
                    });
                }
            });
        }
    });

    // Toggle the calendar visibility when the "Show Calendar" button is clicked
    $('#showCalendarBtn').click(function() {
        $('#calendarSection').toggle();  // Toggle the calendar section visibility
        $('#resetSection').toggle();    // Toggle the reset button visibility
        $(this).text(function(i, text) {
            return text === 'Show Calendar' ? 'Hide Calendar' : 'Show Calendar'; // Change button text based on visibility
        });
    });

    // Reset Dates Function
    $('#resetDates').click(function() {
        // Reset calendar and hidden input fields
        $('#start_date').val('');
        $('#end_date').val('');
        startDateSelected = false;
        endDateSelected = false;
        startDate = null;
        endDate = null;

        // Remove any events for start and end dates from the calendar
        $('#calendar').fullCalendar('removeEvents', function(event) {
            return event.backgroundColor === 'green' || event.backgroundColor === 'red';
        });

        // Show SweetAlert for Reset
        Swal.fire({
            title: 'Dates Reset',
            text: 'Start and End dates have been reset.',
            icon: 'info',
            confirmButtonText: 'Okay'
        });
    });

    // Show reset button after date selection
    $('#calendar').on('select', function() {
        if (startDateSelected && endDateSelected) {
            $('#resetSection').show(); // Show the reset button after both dates are selected
        }
    });
});

</script>
