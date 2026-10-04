<?php
require_once('../../vendor/autoload.php');
require_once '../../config/dbcon.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Get certificate ID
$soloparentId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($soloparentId <= 0) die("Invalid Solo Parent certificate ID.");

// Fetch solo parent certificate data
$query = "SELECT 
            so.id AS certificate_id,
            so.personal_Id,
            so.since,
            so.category,
            so.age,
            so.children1,
            so.children1_birthday,
            so.children2,
            so.children2_birthday,
            so.children3,
            so.children3_birthday,
            so.children4,
            so.children4_birthday,
            so.councilor,
            so.created_at,

            p.name,
            p.address,
            p.contnumber
          FROM soloparentcertificate so
          JOIN personal p ON so.personal_Id = p.id
          WHERE so.id = '$soloparentId'";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Helper: format dates
function formatDate($date) {
    if ($date !== '0000-00-00' && !empty($date)) {
        return date('F j, Y', strtotime($date));
    }
    return "";
}

// Load template (.docx)
$templatePath = __DIR__ . '/../template/solo_parent_certificate_template.docx';

if (!file_exists($templatePath)) {
    die("Solo Parent template file not found.");
}

$template = new TemplateProcessor($templatePath);

// Replace fields in the DOCX template
$template->setValue('name', htmlspecialchars($data['name']));
$template->setValue('age', htmlspecialchars($data['age']));
$template->setValue('address', htmlspecialchars($data['address']));
$template->setValue('since', htmlspecialchars($data['since']));
$template->setValue('category', htmlspecialchars($data['category']));
$template->setValue('date_today', date('F d, Y'));
$template->setValue('councilor', htmlspecialchars($data['councilor']));

// Child names
$template->setValue('child1', htmlspecialchars($data['children1']));
$template->setValue('child2', htmlspecialchars($data['children2']));
$template->setValue('child3', htmlspecialchars($data['children3']));
$template->setValue('child4', htmlspecialchars($data['children4']));

// Child birthdays
$template->setValue('child1_bday', formatDate($data['children1_birthday']));
$template->setValue('child2_bday', formatDate($data['children2_birthday']));
$template->setValue('child3_bday', formatDate($data['children3_birthday']));
$template->setValue('child4_bday', formatDate($data['children4_birthday']));

// Ensure folder exists
$generatedPath = __DIR__ . '/generated';
if (!file_exists($generatedPath)) mkdir($generatedPath, 0777, true);

// Save file
$outputFile = $generatedPath . '/solo_parent_certificate_' . $data['certificate_id'] . '.docx';
$template->saveAs($outputFile);

// Send to user
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete file after download
unlink($outputFile);
exit;
?>
