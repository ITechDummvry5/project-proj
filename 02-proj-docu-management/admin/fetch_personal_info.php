<?php
// fetch_personal_info.php
include('../config/function.php'); // Assuming your database connection is here

if (isset($_GET['personal_Id'])) {
    $personalId = $_GET['personal_Id'];

    // Query to fetch personal data
    $query = "SELECT * FROM personal WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $personalId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $personalData = $result->fetch_assoc();

        // Display the fetched personal data in a table
        echo "<table class='table' style='width: 400px; border-collapse: collapse;'>";
        echo "<tr><th style='width: 150px;'>Name</th><td>" . htmlspecialchars($personalData['name']) . "</td></tr>";
        echo "<tr><th>Address</th><td>" . htmlspecialchars($personalData['address']) . "</td></tr>";
        echo "<tr><th>Length of Years</th><td>" . htmlspecialchars($personalData['length_of_years']) . "</td></tr>";

        if (!empty($personalData['profile_image'])) {
            echo "<tr><th>Profile Image</th><td>
                    <img src='../" . htmlspecialchars($personalData['profile_image']) . "' 
                         alt='Profile Image' 
                         class='img-fluid' 
                         style='width: 250px; height: 150px; object-fit: cover; border-radius: 5px;'>
                  </td></tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No personal data found.</p>";
    }
} else {
    echo "<p style='text-align: center;'>Invalid request.</p>";
}
?>
