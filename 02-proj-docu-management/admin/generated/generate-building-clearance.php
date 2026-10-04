<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // database connection only
use PhpOffice\PhpWord\TemplateProcessor;

// Get building clearance ID from query string
$buildingclearanceId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($buildingclearanceId <= 0) die("Invalid building clearance ID.");

// Fetch building clearance data
$query = "
    SELECT 
        bui.id AS buildingclearance_id,
        bui.personal_id,
        bui.buildingcode,
        bui.floorarea,
        bui.construction,
        bui.created_at,
        bui.usedfor,
        bui.location,
        bui.or_number,
        bui.or_date,
        bui.cedula_no,
        bui.issued_at,
        bui.issued_on,
        p.name,
        p.contnumber,
        p.profile_image,
        p.address
    FROM buildingclearance bui
    JOIN personal p ON bui.personal_id = p.id
    WHERE bui.id = $buildingclearanceId
";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Load Word template
$templatePath = __DIR__ . '/../template/barangay_building_clearance_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders with actual data
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('buildingcode', htmlspecialchars($data['buildingcode']));
$templateProcessor->setValue('floorarea', htmlspecialchars($data['floorarea']));
$templateProcessor->setValue('construction', htmlspecialchars($data['construction']));
$templateProcessor->setValue('usedfor', htmlspecialchars($data['usedfor']));
$templateProcessor->setValue('location', htmlspecialchars($data['location']));
$templateProcessor->setValue('or_number', htmlspecialchars($data['or_number']));
$templateProcessor->setValue('or_date', htmlspecialchars($data['or_date']));
$templateProcessor->setValue('cedula_no', htmlspecialchars($data['cedula_no']));
$templateProcessor->setValue('issued_at', htmlspecialchars($data['issued_at']));
$templateProcessor->setValue('issued_on', htmlspecialchars($data['issued_on']));

// Auto-fill today's date
$templateProcessor->setValue('date', date('F d, Y'));

// Ensure generated folder exists
if (!file_exists(__DIR__ . '/generated')) mkdir(__DIR__ . '/generated', 0777, true);

// Save the generated file
$outputFile = __DIR__ . '/generated/barangay_building_clearance_' . $data['buildingclearance_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete file after sending
unlink($outputFile);
exit;
?>
