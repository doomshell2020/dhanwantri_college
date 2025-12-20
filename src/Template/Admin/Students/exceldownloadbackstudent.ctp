<?php
// pr($findStudent);exit;
$objPHPExcel = new PHPExcel();

$style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);
$colorstyle =  array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ffff33')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),        // BLACK
        )
    )
);


$objPHPExcel->setActiveSheetIndex(0)->getStyle("A:Z")->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle("A1:Z1")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:Z1")->applyFromArray($colorstyle);
$objPHPExcel->getActiveSheet()->freezePane('A2');

foreach (range('A', 'G') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}

// Set properties
$objSheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Sr.No.')
    ->setCellValue('B1', 'Scholar No.')
    ->setCellValue('C1', 'Enrolment No.')
    ->setCellValue('D1', 'Roll No.')
    ->setCellValue('E1', 'Full Name')
    ->setCellValue('F1', 'Batch')
    ->setCellValue('G1', 'BackLog Subjects');


$counter = 1;

if (isset($findStudent) && !empty($findStudent)) {
    foreach ($findStudent as $i => $people) {
        $ii = $i + 2;
        $result = $this->Comman->findBackStudentSubject($people['id']);

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $people["enroll"]);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $people["enrolment_no"]);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $people["roll_no"]);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $people["fname"] . ' ' . $people["middlename"] . ' ' . $people["lname"]);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $people["batch"]);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $result);
    }
}


// column B set lock 
$startRow = 2;
$highestRow = $objSheet->getHighestRow();

// Loop through each row and apply protection to the Scholar No. column (column B)
for ($row = $startRow; $row <= $highestRow; $row++) {
    $cell = 'B' . $row;
    $objSheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
}

// Loop through each row again and apply protection to other columns (except column B)
$columnsToExclude = range('A', 'Z'); // Exclude all columns except 'B'
foreach ($columnsToExclude as $excludeColumn) {
    if ($excludeColumn !== 'B') {
        for ($row = $startRow; $row <= $highestRow; $row++) {
            $cell = $excludeColumn . $row;
            $objSheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        }
    }
}

$objSheet->getProtection()->setSheet(true);


// Header Lock row
$headerRow = 1;
$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();

for ($col = 'A'; $col <= $highestColumn; $col++) {
    $cell = $objPHPExcel->getActiveSheet()->getCell($col . $headerRow);
    $cell->getStyle()->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
}

// Set worksheet protection to enable protection
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = 'BacklogStudent_' . date('d-m-Y') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
