<?php


// Require Composer's autoload file
require '../vendor/autoload.php'; 
require '../config/function.php';

// Include TCPDF properly
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');  
$dotenv->load();

// Ensure the user is logged in and has the role of either secretary or staff
if (!isset($_SESSION['loggedInUser']) || 
    ($_SESSION['loggedInUser']['role'] !== 'secretary' && $_SESSION['loggedInUser']['role'] !== 'staff')) {
    redirect('activity-logs.php', 'Unauthorized access.', 'error');
}

// Check if form is submitted with required fields
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'], $_POST['start_date'], $_POST['end_date'], $_POST['format'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'] . ' 23:59:59'; // Extend to end of the day
    $format = $_POST['format']; // sql, pdf, excel

    // Get all tables if "All" is selected
    if ($_POST['table'] === 'all') {
        $tables = [];
        $result = $conn->query("SHOW TABLES");
        while ($row = $result->fetch_array()) {
            if (!in_array($row[0], ['account', 'sessions', 'pwdcertificate', 'activity_logs'])) {
                $tables[] = $row[0];
            }
        }
    } else {
        $tables = [mysqli_real_escape_string($conn, $_POST['table'])];
    }

    if (empty($tables)) {
        redirect('activity-logs.php', 'No table selected.', 'error');
    }

    // Define backup directories
    $backup_base_dir = __DIR__ . "/backups";
    $sql_backup_dir   = "$backup_base_dir/sql";
    $pdf_backup_dir   = "$backup_base_dir/pdf";
    $excel_backup_dir = "$backup_base_dir/excel";

    foreach ([$sql_backup_dir, $pdf_backup_dir, $excel_backup_dir] as $dir) {
        if (!is_dir($dir)) mkdir($dir, 0777, true);
    }

    $timestamp_columns = ['created_at'];

    foreach ($tables as $table_name) {
        // Find timestamp column
        $found_column = null;
        foreach ($timestamp_columns as $column) {
            $check_column_sql = "SHOW COLUMNS FROM `$table_name` LIKE '$column'";
            if ($result = $conn->query($check_column_sql)) {
                if ($result->num_rows > 0) {
                    $found_column = $column;
                    break;
                }
            }
        }

        if (!$found_column) continue; // skip tables without timestamp

        // Check if table has personal_id
        $has_personal_id = false;
        $check_personal_sql = "SHOW COLUMNS FROM `$table_name` LIKE 'personal_id'";
        if ($result = $conn->query($check_personal_sql)) {
            if ($result->num_rows > 0) $has_personal_id = true;
        }

        // Build query
        if ($has_personal_id) {
            $sql = "SELECT t.*, p.name 
                    FROM `$table_name` t
                    LEFT JOIN personal p ON t.personal_id = p.id
                    WHERE t.`$found_column` BETWEEN '$start_date' AND '$end_date'";
        } else {
            $sql = "SELECT * FROM `$table_name` WHERE `$found_column` BETWEEN '$start_date' AND '$end_date'";
        }

        $result = $conn->query($sql);
        if ($result->num_rows == 0) continue;

        // Format dates for backup filename
        $start_date_formatted = date('Y-M-d', strtotime($start_date));
        $end_date_formatted   = date('Y-M-d', strtotime($end_date));

        // ===== SQL BACKUP =====
        if ($format === 'sql') {
            $backup_file = "$sql_backup_dir/{$table_name}-{$start_date_formatted}-to-{$end_date_formatted}.sql";
            $file = fopen($backup_file, 'w');
            if ($file) {
                while ($row = $result->fetch_assoc()) {
                    $columns = implode(', ', array_keys($row));
                    $values  = implode(', ', array_map(fn($value) => "'" . mysqli_real_escape_string($conn, $value) . "'", array_values($row)));
                    fwrite($file, "INSERT INTO `$table_name` ($columns) VALUES ($values);\n");
                }
                fclose($file);
            }
        }

        // ===== PDF BACKUP =====
        elseif ($format === 'pdf') {
            $backup_file = "$pdf_backup_dir/{$table_name}-{$start_date_formatted}-to-{$end_date_formatted}.pdf";
            $pdf = new TCPDF();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle("Backup Report - $table_name");
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 10);
            $first_row = $result->fetch_assoc();
            $headers = array_keys($first_row);

            $html = '<h2>Backup Report: ' . $table_name . '</h2>';
            $html .= '<table border="1" cellpadding="5">';
            $html .= '<thead><tr>';
            foreach ($headers as $header) {
                $html .= '<th>' . htmlspecialchars($header) . '</th>';
            }
            $html .= '</tr></thead><tbody>';
            do {
                $html .= '<tr>';
                foreach ($first_row as $value) {
                    $html .= '<td>' . htmlspecialchars($value) . '</td>';
                }
                $html .= '</tr>';
            } while ($first_row = $result->fetch_assoc());
            $html .= '</tbody></table>';

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output($backup_file, 'F');
        }

        // ===== EXCEL BACKUP =====
        elseif ($format === 'excel') {
            $backup_file = "$excel_backup_dir/{$table_name}-{$start_date_formatted}-to-{$end_date_formatted}.xlsx";
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $first_row = $result->fetch_assoc();
            $headers = array_keys($first_row);
            $sheet->fromArray([$headers], null, 'A1');
            $row_number = 2;
            do {
                $sheet->fromArray(array_values($first_row), null, "A$row_number");
                $row_number++;
            } while ($first_row = $result->fetch_assoc());
            $writer = new Xlsx($spreadsheet);
            $writer->save($backup_file);
        }
    }

    redirect('activity-logs.php', "Backup created successfully!", 'success');
}

$conn->close();
?>