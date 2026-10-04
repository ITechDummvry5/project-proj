<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // database connection only
use PhpOffice\PhpWord\TemplateProcessor;

// Get certificate ID from query string
$certificationId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($certificationId <= 0) die("Invalid certification ID.");

// Fetch certificate data from the database
$query = "
    SELECT 
        cgm.id AS certificateofgoodmoral_id, 
        cgm.personal_Id,
        cgm.usedfor, 
        cgm.councilor,
        p.name, 
        p.contnumber, 
        p.profile_image, 
        p.address
    FROM 
        certificateofgoodmoral cgm
    JOIN 
        personal p ON cgm.personal_Id = p.id
    WHERE cgm.id = '$certificationId'
";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

// Fetch the data
$data = mysqli_fetch_assoc($result);

// Load Word template for Certificate of Good Moral Character
$templatePath = __DIR__ . '/../template/certificate_of_good_moral_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

// Create a TemplateProcessor instance
$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in the template with actual data
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('usedfor', htmlspecialchars($data['usedfor']));
$templateProcessor->setValue('councilor', htmlspecialchars($data['councilor']));

// Get current date for the certificate
$currentDate = date('F d, Y');
$templateProcessor->setValue('date', $currentDate);

// Ensure the 'generated' folder exists
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Save the generated certificate file
$outputFile = __DIR__ . '/generated/certificate_of_good_moral_' . $data['certificateofgoodmoral_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download of the generated file
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete the file after download to keep the server clean
unlink($outputFile);
exit;
?>
