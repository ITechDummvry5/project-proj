<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // database connection only
use PhpOffice\PhpWord\TemplateProcessor;

// Get indigency ID from query string
$indigencyId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($indigencyId <= 0) die("Invalid indigency ID.");

// Fetch indigency data
$query = "
    SELECT 
        bi.id AS indigency_id, bi.personal_Id, bi.since, bi.birthday, bi.age, bi.optionaluse,
        bi.civilstatus, bi.birthplace, bi.created_at, bi.updated_at,
        p.name, p.contnumber, p.profile_image, p.address
    FROM 
        barangayindigency bi
    JOIN 
        personal p ON bi.personal_Id = p.id
    WHERE bi.id = '$indigencyId'
";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Load Word template
$templatePath = __DIR__ . '/../template/barangay_indigency_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in template
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('since', htmlspecialchars($data['since']));
$templateProcessor->setValue('birthday', htmlspecialchars($data['birthday']));
$templateProcessor->setValue('age', htmlspecialchars($data['age']));
$templateProcessor->setValue('civilstatus', htmlspecialchars($data['civilstatus']));
$templateProcessor->setValue('birthplace', htmlspecialchars($data['birthplace']));
$templateProcessor->setValue('purpose', htmlspecialchars($data['optionaluse']));



$templateProcessor->setValue('date', date('F d, Y'));

// Ensure generated folder exists
if (!file_exists(__DIR__ . '/generated')) mkdir(__DIR__ . '/generated', 0777, true);

// Save the generated file
$outputFile = __DIR__ . '/generated/barangay_indigency_' . $data['indigency_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete the file after download
unlink($outputFile);
exit;
