<?php
// Include database connection
include('../config/dbcon.php');

// Function to generate a random color in hexadecimal format
function generateRandomColor() {
    $r = rand(0, 255);
    $g = rand(0, 255);
    $b = rand(0, 255);
    return sprintf('#%02x%02x%02x', $r, $g, $b);
}

// Fetch events from the database
$sql = "SELECT heading,  body, start_date, end_date FROM announcement";
$result = mysqli_query($conn, $sql);
$events = [];

while ($row = mysqli_fetch_assoc($result)) {
    $start_date = date('Y-m-d', strtotime($row['start_date']));
    $end_date = date('Y-m-d', strtotime($row['end_date']));

    // Generate a random color for each event
    $eventColor = generateRandomColor();

    $events[] = [
        'title' => $row['heading'],
        'body' => $row['body'],
        'start' => $start_date,
        'end' => $end_date,
        'backgroundColor' => $eventColor, // Random background color
        'borderColor' => $eventColor      // Random border color
    ];
}

// Return events as JSON
echo json_encode($events);
?>
