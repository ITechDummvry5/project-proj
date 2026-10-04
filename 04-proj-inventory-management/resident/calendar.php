<?php include('rinclude/header.php'); ?>

<div class="container mt-4 py-2">
    <h1 class="text-center">Resident Event Calendar</h1>
    <div class="card border-0 shadow-sm mb-4">
        <div class="col-md-12">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    // Initialize the FullCalendar
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        // Fetch events dynamically from the PHP script
        events: function(info, successCallback, failureCallback) {
            $.ajax({
                url: 'fetch_events.php', // The PHP script that fetches events
                dataType: 'json',
                success: function(data) {
                    // Pass the fetched events to the calendar
                    successCallback(data);
                },
                error: function() {
                    failureCallback();
                }
            });
        },
        eventClick: function(info) {
            // Format the start and end dates to display only the date without the time
            var startDate = new Date(info.event.start).toLocaleDateString();
            var endDate = info.event.end ? new Date(info.event.end).toLocaleDateString() : 'N/A';

            // Access the 'body' content from the event's extendedProps
            var eventBody = info.event.extendedProps.body;

            // Using SweetAlert2 to display event details in a popup
            Swal.fire({
    title: 'Calendar Event Details',
    html: `
        <div style="text-align: left;">
            <strong>Event:</strong> ${info.event.title}<br>
            <strong>Body:</strong> ${eventBody}<br> <br>
            <strong>Start:</strong> ${startDate}<br>
            <strong>End:</strong> ${endDate}<br>
        </div>
    `,
    icon: 'info',
    confirmButtonText: 'Close',
    width: '90%' // Use a percentage for responsive behavior
});
        },
        editable: true, // Allows you to drag and drop events (optional)
        droppable: true // Allows you to drop events (optional)
    });

    calendar.render();
});

</script>

