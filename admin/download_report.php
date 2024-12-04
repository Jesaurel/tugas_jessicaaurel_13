<?php
// download_report.php
session_start();

// Include database connection
include_once '.../config/db.php';
include_once '.../config/config.php';

// Get query parameters (start_date, end_date, category) from the URL
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$category = $_GET['category'] ?? '';

// Prepare SQL query based on filters
$query = "SELECT * FROM sales WHERE 1=1";

if ($start_date) {
    $query .= " AND date >= '$start_date'";
}
if ($end_date) {
    $query .= " AND date <= '$end_date'";
}
if ($category) {
    $query .= " AND category = '$category'";
}

// Execute query to fetch the data
$result = mysqli_query($conn, $query);

// Include PHPExcel library (make sure the path is correct)
require_once 'PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);

// Set column headers
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Order ID');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Quantity');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Price');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Total');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Date');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Category');

// Fill the data into the Excel sheet
$row = 2;
while ($data = mysqli_fetch_assoc($result)) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row, $data['order_id']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row, $data['product_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row, $data['quantity']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row, $data['price']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row, $data['total']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row, $data['date']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row, $data['category']);
    $row++;
}

// Set headers for downloading the Excel file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="sales_report.xlsx"');
header('Cache-Control: max-age=0');

// Write the Excel file to output
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>