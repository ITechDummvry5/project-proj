<?php
require_once '../../vendor/autoload.php';
require_once '../../config/dbcon.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Get ID
$franchisingId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($franchisingId <= 0) die("Invalid franchising ID.");

// Fetch data
$query = "
    SELECT 
        fs.id AS franchising_id,
        fs.personal_Id,
        fs.franchisingcode,
        fs.drivername,
        fs.license,
        fs.platenumber,
        fs.receiptnumber,
        fs.or_number,
        fs.or_date,
        fs.cedula_no,
        fs.issued_on,
        p.name,
        p.contnumber,
        p.address
    FROM franchising fs
    JOIN personal p ON fs.personal_Id = p.id
    WHERE fs.id = $franchisingId
";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) die("No data found.");

$data = mysqli_fetch_assoc($result);

// Path to .docx template
$templatePath = __DIR__ . '/../template/franchising_template.docx';
if (!file_exists($templatePath)) die("Template not found.");

// Load template
$templateProcessor = new TemplateProcessor($templatePath);

// Replace placeholders with dynamic values
$templateProcessor->setValue('franchisingcode', htmlspecialchars($data['franchisingcode']));
$templateProcessor->setValue('drivername', htmlspecialchars($data['drivername']));
$templateProcessor->setValue('license', htmlspecialchars($data['license']));
$templateProcessor->setValue('platenumber', htmlspecialchars($data['platenumber']));
$templateProcessor->setValue('receiptnumber', htmlspecialchars($data['receiptnumber']));
$templateProcessor->setValue('or_number', htmlspecialchars($data['or_number']));
$templateProcessor->setValue('or_date', htmlspecialchars($data['or_date']));
$templateProcessor->setValue('cedula_no', htmlspecialchars($data['cedula_no']));
$templateProcessor->setValue('issued_on', htmlspecialchars($data['issued_on']));
$templateProcessor->setValue('name', htmlspecialchars($data['name']));
$templateProcessor->setValue('contnumber', htmlspecialchars($data['contnumber']));
$templateProcessor->setValue('address', htmlspecialchars($data['address']));

// Today's date
$templateProcessor->setValue('date', date('F d, Y'));

// Create output directory if missing
if (!file_exists(__DIR__ . '/generated')) {
    mkdir(__DIR__ . '/generated', 0777, true);
}

// Output filename
$outputFile = __DIR__ . '/generated/franchising_' . $data['franchising_id'] . '.docx';
$templateProcessor->saveAs($outputFile);

// Force download
header("Content-Disposition: attachment; filename=" . basename($outputFile));
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
readfile($outputFile);

// Remove file after download
unlink($outputFile);
exit;
?>
