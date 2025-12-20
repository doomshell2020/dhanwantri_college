<?php

$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Your Name")
    ->setLastModifiedBy("Your Name")
    ->setTitle("Fee Report")
    ->setSubject("Fee Report Document")
    ->setDescription("Test document for Fee Report, generated using PHP classes.")
    ->setKeywords("fees excel report")
    ->setCategory("Test result file");

// Set column widths
$columns = ['A' => 15, 'B' => 20, 'C' => 20, 'D' => 20, 'E' => 20, 'F' => 20, 'G' => 20];
foreach ($columns as $col => $width) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth($width);
}

// Set sheet and title
$sheet = $objPHPExcel->setActiveSheetIndex(0);
$monthYear = date('F Y', strtotime($month));
$sheet->setCellValue('A1', "Monthly Fee Report - $monthYear");

// Merge cells for title and style it
$sheet->mergeCells('A1:G1');
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ]
]);

// Header starts from row 2 now
$sheet->setCellValue('A2', 'Date');

$colIndex = 1; // Column B starts at index 1
foreach ($mode as $payment_mode) {
    $sheet->setCellValueByColumnAndRow($colIndex, 2, strtoupper($payment_mode));
    $colIndex++;
}
$sheet->setCellValueByColumnAndRow($colIndex, 2, 'Total');


// Apply color to header row
$highestCol = PHPExcel_Cell::stringFromColumnIndex($colIndex);
$sheet->getStyle("A2:{$highestCol}2")->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => '4F81BD']
    ],
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ]
]);

// Freeze header row
$sheet->freezePane('A3');

// Initialize totals
$row = 3;
$overall_total = 0;
$mode_totals = array_fill_keys($mode, 0);

$current_date = $start_date;

while (strtotime($current_date) <= strtotime($end_date)) {
    $daily_total = 0;
    $sheet->setCellValueByColumnAndRow(0, $row, date('d-m-Y', strtotime($current_date)));

    $colIndex = 1;
    foreach ($mode as $payment_mode) {
        $amount = isset($allFees[$current_date][$payment_mode]) ? $allFees[$current_date][$payment_mode] : 0;
        $sheet->setCellValueByColumnAndRow($colIndex, $row, $amount);
        $daily_total += $amount;
        $mode_totals[$payment_mode] += $amount;
        $overall_total += $amount;
        $colIndex++;
    }

    // Total per row
    $sheet->setCellValueByColumnAndRow($colIndex, $row, $daily_total);

    $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
    $row++;
}


// Final Totals Row
$sheet->setCellValueByColumnAndRow(0, $row, 'Grand Total');
$colIndex = 1;
foreach ($mode as $payment_mode) {
    $sheet->setCellValueByColumnAndRow($colIndex, $row, $mode_totals[$payment_mode]);
    $colIndex++;
}
$sheet->setCellValueByColumnAndRow($colIndex, $row, $overall_total);

// Apply bold styling to the entire Grand Total row
$lastCol = PHPExcel_Cell::stringFromColumnIndex($colIndex);
$sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
    'font' => ['bold' => true],
    'fill' => [
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => 'D9D9D9'] // Light gray background
    ]
]);

// Align "Grand Total" label center
$sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Right align the amounts
$sheet->getStyle("B{$row}:{$lastCol}{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// Output Excel
$filename = "Fee_Report_" . date('F_Y', strtotime($month)) . "_" . date('h_i_s') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
