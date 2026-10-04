<?php
require_once "../config/function.php";

// search.php
// Check if the search query is set
if (isset($_GET['query'])) {
    // Get the search term and sanitize it using the validate function
    $query = validate($_GET['query']); // Sanitize the query to avoid XSS or SQL injection

    // Check if the query is empty
    if (empty($query)) {
        // If the query is empty after sanitization, redirect back to search page with an error message
        redirect('index2.php', 'Please enter a valid search term.', 'error');
    }

    // List of predefined pages with keywords (more specific to partial matching)
    $pages = [
        'certificate' => 'barangay-certificate.php',
        'clearance' => 'barangay-clearance.php',
        'indigency' => 'barangay-indigency.php',
        'residency' => 'barangay-residency.php',
        'pwd' => 'pwdcertificate.php',
        'solo' => 'soloparentcertificate.php',
        'franchising' => 'franchising.php',
        'business' => 'business-clearance.php',
        'building' => 'building-clearance.php',
        'letter' => 'cohabitation-letter.php',
        'esc' => 'certification-of-esc.php',
        'lowincome' => 'certification-of-low-income.php',
        'source of income' => 'certification-of-source-of-income.php',
        'legitimacy' => 'certification-of-legitimacy.php',
        'good moral' => 'certificate-of-good-moral.php',
        'calamity' => 'certification-of-calamity.php'
    ];

    // Check for partial matches
    $matchFound = false;
    foreach ($pages as $key => $url) {
        if (stripos($key, $query) !== false) {  // Case-insensitive search
            // Redirect to the matching page
            redirect($url, 'Search for ' . $query . ' ', 'success');
            $matchFound = true;
            break; // Exit the loop once a match is found
        }
    }

    // If no match found, redirect back to the search page with an error message
    if (!$matchFound) {
        redirect('index2.php', 'No results found for your search.', 'error');
    }
} else {
    // No query was provided, redirect to search page with an error message
    redirect('index2.php', 'Please enter a search term.', 'error');
}
?>
