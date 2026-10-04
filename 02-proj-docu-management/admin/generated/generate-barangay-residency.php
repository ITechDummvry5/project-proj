<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php'; // database connection only
use PhpOffice\PhpWord\TemplateProcessor;

// Get residency ID from query string
$residencyId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($residencyId <= 0) die("Invalid residency ID.");

// Fetch residency data
$query = "
    SELECT 
         br.id AS residency_id,  br.personal_Id, 
                    br.since, 
                    br.birthday, 
                    br.age,
                    br.civilstatus, 
                    br.birthplace, 
                    br.created_at,
                    br.optionaluse,
                    br.councilor,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
    FROM 
          barangayresidency br
    JOIN 
        personal p ON br.personal_Id = p.id
    WHERE   br.id = '$residencyId'
";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Load Word template
$templatePath = __DIR__ . '/../template/barangay_residency_template.docx';
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
$outputFile = __DIR__ . '/generated/barangay_residency_' . $data['residency_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete the file after download
unlink($outputFile);
exit;
