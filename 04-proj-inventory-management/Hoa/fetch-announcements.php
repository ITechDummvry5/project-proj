<?php
// Include database connection
include('../config/dbcon.php');

// Function to generate a random color in hexadecimal format
function generateRandomColor() {
    // Generate random values for Red, Green, and Blue components
    $r = rand(0, 255); // Random value between 0 and 255 for red
    $g = rand(0, 255); // Random value between 0 and 255 for green
    $b = rand(0, 255); // Random value between 0 and 255 for blue
    
    // Return the color in hexadecimal format
    return sprintf('#%02x%02x%02x', $r, $g, $b);
}

// Fetch announcements from the database
$sql = "SELECT heading, start_date, end_date FROM announcement";
$result = mysqli_query($conn, $sql);
$events = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Ensure dates are formatted properly and no time component is affecting comparison
    $today = date('Y-m-d');  // Current date in 'YYYY-MM-DD' format

    // Normalize the start and end dates to 'YYYY-MM-DD' format (without time component)
    $start_date = date('Y-m-d', strtotime($row['start_date']));
    $end_date = date('Y-m-d', strtotime($row['end_date']));

    // Generate a random color for each event
    $eventColor = generateRandomColor();

    // Append the event to the array
    $events[] = [
        'title' => $row['heading'],
        'start' => $start_date,
        'end' => $end_date,
        'backgroundColor' => $eventColor, // Apply event color
        'borderColor' => $eventColor      // Apply border color
    ];
}

// Return events as JSON
echo json_encode($events);
?>
