<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Get ESC ID from URL
$escItemId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($escItemId <= 0) die("Invalid ESC ID.");

// Fetch ESC data from database
$query = "
SELECT 
    ce.id AS certificationofesc_id, 
    ce.personal_Id, 
    ce.father,
    ce.mother,
    ce.child,
    ce.school,
    ce.residentsince,
    ce.purpose,
    ce.councilor,
    p.name, 
    p.contnumber, 
    p.profile_image,
    p.address
FROM 
    certificationofesc ce
JOIN 
    personal p ON ce.personal_Id = p.id
WHERE 
    ce.id = $escItemId
";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No ESC data found.");

$data = mysqli_fetch_assoc($result);

// Path to Word template
$templatePath = __DIR__ . '/../template/certificateOFesc_template.docx';
if (!file_exists($templatePath)) die("ESC template not found.");

// Load template
$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in template
$templateProcessor->setValue('father', htmlspecialchars($data['father']));
$templateProcessor->setValue('mother', htmlspecialchars($data['mother']));
$templateProcessor->setValue('child', htmlspecialchars($data['child']));
$templateProcessor->setValue('school', htmlspecialchars($data['school']));
$templateProcessor->setValue('residentsince', date('Y', strtotime($data['residentsince'])));
$templateProcessor->setValue('purpose', htmlspecialchars($data['purpose']));
$templateProcessor->setValue('councilor', htmlspecialchars($data['councilor']));
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('date', date('F j, Y')); // today's date
$templateProcessor->setValue('daysuffix', date('jS')); // e.g., 7th

// Create output folder if not exists
if (!file_exists(__DIR__ . '/generated')) mkdir(__DIR__ . '/generated', 0777, true);

// Output filename
$outputFile = __DIR__ . '/generated/certificateOFesc_' . $data['certificationofesc_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete file after download
unlink($outputFile);
exit;
?>
