<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // database connection only
use PhpOffice\PhpWord\TemplateProcessor;

// Get certification ID from query string
$certificationlowId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($certificationlowId <= 0) die("Invalid certification ID.");

// Fetch certification data from the database
$query = "
    SELECT 
        ci.id AS certificationoflowincome_id, 
        ci.personal_Id, 
        ci.work, 
        ci.age, 
        ci.usedfor, 
        ci.income, 
        ci.created_at, 
        ci.updated_at,
        ci.councilor,
        p.name, 
        p.contnumber, 
        p.profile_image,
        p.address
    FROM 
        certificationoflowincome ci
    JOIN 
        personal p ON ci.personal_Id = p.id
    WHERE ci.id = '$certificationlowId'
";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

// Fetch the data
$data = mysqli_fetch_assoc($result);

// Load Word template for Certification of Low Income
$templatePath = __DIR__ . '/../template/certificate_of_low_income_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

// Create a TemplateProcessor instance
$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in the template with actual data
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('age', htmlspecialchars($data['age']));
$templateProcessor->setValue('work', htmlspecialchars($data['work']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('income', htmlspecialchars($data['income']));
$templateProcessor->setValue('usedfor', htmlspecialchars($data['usedfor']));
$templateProcessor->setValue('councilor', htmlspecialchars($data['councilor']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));

// Get current date for the certificate
$currentDate = date('F d, Y');
$templateProcessor->setValue('date', $currentDate);

// Ensure the 'generated' folder exists
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Save the generated certificate file
$outputFile = __DIR__ . '/generated/certificate_of_low_income_' . $data['certificationoflowincome_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download of the generated file
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete the file after download to keep the server clean
unlink($outputFile);
exit;
?>
