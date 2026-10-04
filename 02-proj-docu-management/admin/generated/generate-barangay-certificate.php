<?php
require_once('../../vendor/autoload.php');
require_once '../../config/dbcon.php'; // database connection only
use PhpOffice\PhpWord\TemplateProcessor;

// Get certificate ID
$certificateId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($certificateId <= 0) die("Invalid certificate ID.");

// Fetch certificate data
$query = "SELECT bc.id AS certificate_id, bc.personal_Id, bc.since, bc.birthday, bc.age,
          bc.civilstatus, bc.birthplace, bc.services, bc.created_at, bc.optionaluse, bc.councilor,
          p.name, p.contnumber, p.profile_image, p.address
          FROM barangaycertificate bc
          JOIN personal p ON bc.personal_Id = p.id
          WHERE bc.id = '$certificateId'";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Load template
$templatePath = __DIR__ . '/../template/barangay_certificate_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('age', htmlspecialchars($data['age']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('date', date('F d, Y'));
$templateProcessor->setValue('civilstatus', htmlspecialchars($data['civilstatus']));
$templateProcessor->setValue('birthplace', htmlspecialchars($data['birthplace']));
$templateProcessor->setValue('since', htmlspecialchars($data['since']));
$templateProcessor->setValue('purpose', htmlspecialchars($data['optionaluse']));

// Ensure folder exists
if (!file_exists(__DIR__ . '/generated')) mkdir(__DIR__ . '/generated', 0777, true);

// Save and send the file
$outputFile = __DIR__ . '/generated/barangay_certificate_' . $data['certificate_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);
unlink($outputFile);
exit;
