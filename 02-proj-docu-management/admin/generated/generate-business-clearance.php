<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Get ID
$businessClearanceId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($businessClearanceId <= 0) die("Invalid business clearance ID.");

// Fetch data
$query = "
    SELECT 
        bsc.id AS businessclearance_id,
        bsc.personal_Id,
        bsc.businesscode,
        bsc.businessname,
        bsc.manager,
        bsc.location,
        bsc.address AS business_address,
        bsc.created_at,
        bsc.or_number,
        p.name,
        p.contnumber,
        p.profile_image,
        p.address AS personal_address
    FROM businessclearance bsc
    JOIN personal p ON bsc.personal_Id = p.id
    WHERE bsc.id = $businessClearanceId
";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Path to .docx template
$templatePath = __DIR__ . '/../template/barangay_business_clearance_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders with dynamic values
$templateProcessor->setValue('businesscode', htmlspecialchars($data['businesscode']));
$templateProcessor->setValue('businessname', htmlspecialchars($data['businessname']));
$templateProcessor->setValue('manager', htmlspecialchars($data['manager']));
$templateProcessor->setValue('location', htmlspecialchars($data['location']));
$templateProcessor->setValue('business_address', htmlspecialchars($data['business_address']));
$templateProcessor->setValue('or_number', htmlspecialchars($data['or_number']));
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('personal_address', htmlspecialchars($data['personal_address']));

$imagePath = __DIR__ . '/../' . $data['profile_image'];

if (!file_exists($imagePath)) {
    die("Profile image not found: " . $imagePath);
}

$templateProcessor->setImageValue('profile_image', [
    'path' => $imagePath,
    'width' => 120,
    'height' => 120,
    'ratio' => false
]);


// Today's date
$templateProcessor->setValue('date', date('F d, Y'));


// Create output directory if missing
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Output filename (unique! - using business clearance ID)
$outputFile = __DIR__ . '/generated/business_clearance_' . $data['businessclearance_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Remove file after download
unlink($outputFile);
exit;
?>
