<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // database connection only
use PhpOffice\PhpWord\TemplateProcessor;

// Get clearance ID from query string
$clearanceId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($clearanceId <= 0) die("Invalid clearance ID.");

// Fetch clearance data
$query = "
    SELECT 
        bce.id AS clearance_id, bce.personal_Id, bce.since, bce.age, bce.services, bce.optionaluse,
        bce.civilstatus, bce.birthplace, bce.created_at, bce.updated_at,
        p.name, p.contnumber, p.profile_image, p.address
    FROM 
        barangayclearance bce
    JOIN 
        personal p ON bce.personal_Id = p.id
    WHERE bce.id = '$clearanceId'
";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Load Word template
$templatePath = __DIR__ . '/../template/barangay_clearance_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in template
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('since', htmlspecialchars($data['since']));
$templateProcessor->setValue('age', htmlspecialchars($data['age']));
$templateProcessor->setValue('services', htmlspecialchars($data['services']));
$templateProcessor->setValue('purpose', htmlspecialchars($data['optionaluse']));
$templateProcessor->setValue('civilstatus', htmlspecialchars($data['civilstatus']));
$templateProcessor->setValue('birthplace', htmlspecialchars($data['birthplace']));
$templateProcessor->setValue('date', date('F d, Y'));

// Ensure generated folder exists
if (!file_exists(__DIR__ . '/generated')) mkdir(__DIR__ . '/generated', 0777, true);

// Save the generated file
$outputFile = __DIR__ . '/generated/barangay_clearance_' . $data['clearance_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete the file after download
unlink($outputFile);
exit;
