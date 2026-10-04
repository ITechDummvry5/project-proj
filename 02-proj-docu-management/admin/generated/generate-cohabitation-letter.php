<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // Database connection

use PhpOffice\PhpWord\TemplateProcessor;

// Get Cohabitation Letter ID from the query string
$cohabitationletterId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($cohabitationletterId <= 0) die("Invalid Cohabitation Letter ID.");

// Fetch Cohabitation Letter data from the database
$query = "
    SELECT 
        cl.id AS cohabitationletter_id, 
        cl.personal_Id, 
        cl.namefor, 
        cl.purposefor, 
        cl.councilor,
        p.name, 
        p.contnumber, 
        p.profile_image, 
        p.address
    FROM 
        cohabitationletter cl
    JOIN 
        personal p ON cl.personal_Id = p.id
    WHERE cl.id = '$cohabitationletterId'
";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

// Fetch the data
$data = mysqli_fetch_assoc($result);

// Get current date
$currentDate = date('F d, Y');

// Path to the template for the cohabitation letter
$templatePath = __DIR__ . '/../template/cohabitation_letter_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

// Create a TemplateProcessor instance
$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in the template with actual data
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('namefor', htmlspecialchars($data['namefor']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('namefor', htmlspecialchars($data['namefor']));
$templateProcessor->setValue('purposefor', htmlspecialchars($data['purposefor']));
$templateProcessor->setValue('councilor', htmlspecialchars($data['councilor']));
$templateProcessor->setValue('date', $currentDate);

// Ensure the 'generated' folder exists
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Save the generated letter to a file
$outputFile = __DIR__ . '/generated/cohabitation_letter_' . $data['cohabitationletter_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download of the generated file
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete the file after download to keep the server clean
unlink($outputFile);
exit;
?>
