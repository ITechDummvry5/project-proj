<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Get ID
$calamityItemId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($calamityItemId <= 0) die("Invalid calamity ID.");

// Fetch data
$query = "
    SELECT 
                ca.id AS certificationofcalamity_id, 
                ca.personal_Id, 
                ca.calamitytypes, 
                ca.calamitydate,
                ca.created_at,
                ca.updated_at,
                ca.purpose,
                ca.councilor,
                p.name,
                p.contnumber, 
                p.profile_image,
                p.address
            FROM 
                certificationofcalamity ca
            JOIN 
                personal p ON ca.personal_Id = p.id
            WHERE 
                ca.id = $calamityItemId
";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Path to .docx template
$templatePath = __DIR__ . '/../template/certificateOFcalamity_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

// Load template
$templateProcessor = new TemplateProcessor($templatePath);

$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('calamitytypes', htmlspecialchars($data['calamitytypes']));
$templateProcessor->setValue('calamitydate', date('F d, Y', strtotime($data['calamitydate'])));
$templateProcessor->setValue('purpose', htmlspecialchars($data['purpose']));
$templateProcessor->setValue('councilor', htmlspecialchars($data['councilor']));

// Today's date
$templateProcessor->setValue('date', date('F d, Y'));

// Create output directory if missing
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Output filename
$outputFile = __DIR__ . '/generated/certificateOFcalamity_' . $data['certificationofcalamity_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Remove file after download
unlink($outputFile);
exit;
?>
