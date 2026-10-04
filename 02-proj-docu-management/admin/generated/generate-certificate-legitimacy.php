<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // Database connection
use PhpOffice\PhpWord\TemplateProcessor;

// Get the legitimacy ID from the query string
$legitimacyId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($legitimacyId <= 0) {
    die("Invalid legitimacy ID.");
}

// Fetch the legitimacy details from the database
$query = "
    SELECT 
        c.id AS certificationlegitimacy_id, 
        c.work, 
        c.yearsofwork, 
        c.usedfor, 
        c.created_at, 
        c.updated_at,
        c.age,
        c.councilor,
        p.name, 
        p.contnumber, 
        p.profile_image,
        p.address
    FROM 
        certificationoflegitimacy c
    JOIN 
        personal p ON c.personal_Id = p.id
    WHERE
        c.id = $legitimacyId
";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    die("No data found.");
}

$legitimacy = mysqli_fetch_assoc($result);

// Load the Word template
$templatePath = __DIR__ . '/../template/certification_legitimacy_template.docx';
if (!file_exists($templatePath)) {
    die("Template file not found.");
}

$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in the template with actual data
$templateProcessor->setValue('name', htmlspecialchars($legitimacy['name']));
$templateProcessor->setValue('age', htmlspecialchars($legitimacy['age']));
$templateProcessor->setValue('address', htmlspecialchars($legitimacy['address']));
$templateProcessor->setValue('work', htmlspecialchars($legitimacy['work']));
$templateProcessor->setValue('yearsofwork', htmlspecialchars($legitimacy['yearsofwork']));
$templateProcessor->setValue('usedfor', htmlspecialchars($legitimacy['usedfor']));
$templateProcessor->setValue('date', date('F d, Y'));
$templateProcessor->setValue('contnumber', htmlspecialchars($legitimacy['contnumber']));
$templateProcessor->setValue('councilor', htmlspecialchars($legitimacy['councilor']));

// Create the generated folder if it doesn't exist
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Save the generated certificate file
$outputFile = __DIR__ . '/generated/certificate_of_legitimacy_' . $legitimacy['certificationlegitimacy_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force the download of the generated file
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete the file after download to keep the server clean
unlink($outputFile);
exit;
?>
