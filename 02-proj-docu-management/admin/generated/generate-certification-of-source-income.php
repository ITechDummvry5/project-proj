<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Get certification ID from query string
$certificationsourceId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($certificationsourceId <= 0) die("Invalid certification ID.");

// Fetch certification data from the database
$query = "
    SELECT 
        csi.id AS certificationofsourceofincome_id, 
        csi.personal_Id, 
        csi.work, 
        csi.age, 
        csi.usedfor, 
        csi.income, 
        csi.councilor,
        p.name, 
        p.contnumber, 
        p.profile_image,
        p.address
    FROM 
        certificationofsourceofincome csi
    JOIN 
        personal p ON csi.personal_Id = p.id
    WHERE csi.id = '$certificationsourceId'
";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

// Fetch the data
$data = mysqli_fetch_assoc($result);

// Load Word template for Certificate of Source Income
$templatePath = __DIR__ . '/../template/certificate_of_source_income_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

// Create a TemplateProcessor instance
$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders in the template
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('age', htmlspecialchars($data['age']));
$templateProcessor->setValue('work', htmlspecialchars($data['work']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));
$templateProcessor->setValue('income', htmlspecialchars($data['income']));
$templateProcessor->setValue('usedfor', htmlspecialchars($data['usedfor']));
$templateProcessor->setValue('councilor', htmlspecialchars($data['councilor']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));


// Current date for certificate
$currentDate = date('F d, Y');
$templateProcessor->setValue('date', $currentDate);

// Ensure 'generated' folder exists
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Save the generated file
$outputFile = __DIR__ . '/generated/certificate_of_source_income_' . $data['certificationofsourceofincome_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Delete after download
unlink($outputFile);
exit;
?>
