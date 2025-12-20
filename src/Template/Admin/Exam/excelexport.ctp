<?php
$objPHPExcel = new PHPExcel();
$style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, ), );
$colorstyle = array(
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
foreach (range('B', 'P') as $columnID) {
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
    ->setCellValue('F1', 'Batch');
$columnIndex = 6;
foreach ($course_subject as $subject) {
    $columnLetter = PHPExcel_Cell::stringFromColumnIndex($columnIndex);
    $subjectLabel = $subject['subject'];
    $objPHPExcel->getActiveSheet()->setCellValue($columnLetter . '1', $subjectLabel);
    $columnIndex++;
}
// Set 'Total Marks' header
$columnLetter = PHPExcel_Cell::stringFromColumnIndex($columnIndex);
$objPHPExcel->getActiveSheet()->setCellValue($columnLetter . '1', 'Total Marks');
$columnIndex++;
// Set 'Marks Obtained' header
$columnLetter = PHPExcel_Cell::stringFromColumnIndex($columnIndex);
$objPHPExcel->getActiveSheet()->setCellValue($columnLetter . '1', 'Marks Obtained');
$counter = 1;

// pr($data);die;
$lockedShell = [];
if (isset($data) && !empty($data)) {
    foreach ($data as $i => $people) {
        $findBatchEnroll = $this->Comman->find_enroll_batch($people['student_id']);

        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $findBatchEnroll["enroll"]);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $people["enrolment_no"]);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $people["roll_no"]);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $people["name"]);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $findBatchEnroll["batch"]);


        // pr( $people);die;
        $secondColumnIndex = 6;
        $total_subject_marks = 0;
        foreach ($course_subject as $subject) {
            $subject_id = $subject['id'];
            // to get result of particular subject
            $result = $this->Comman->findstudentid($people['student_id'], $subject['id'], $exam_name['id']);
            // to get total marks base on subject
            $total_subject_marks += $this->Comman->findsubjectmarks($people['student_id'], $subject_id, $id);

            $columnLetter = PHPExcel_Cell::stringFromColumnIndex($secondColumnIndex);
            $objPHPExcel->getActiveSheet()->setCellValue($columnLetter . $ii, $result);

            if($result == 'NA'){
                    $cell = $columnLetter . $ii;
                    $objSheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                    $lockedShell[] = $cell;
            }
            $secondColumnIndex++;

            // pr($subject);die;
        }

        // to get obtain marks
        $studentOptainMarks = $this->Comman->findTotalOptainMarks($people['student_id'], $course_id, $id);

        $columnLetter = PHPExcel_Cell::stringFromColumnIndex($secondColumnIndex);
        $objPHPExcel->getActiveSheet()->setCellValue($columnLetter . $ii, $total_subject_marks);
        $secondColumnIndex++;

        $columnLetter = PHPExcel_Cell::stringFromColumnIndex($secondColumnIndex);
        $objPHPExcel->getActiveSheet()->setCellValue($columnLetter . $ii, $studentOptainMarks);
        $secondColumnIndex++;
    }//die;
}
$startRow = 2;
$highestRow = $objSheet->getHighestRow();

// Loop through each row and apply protection to the Scholar No. column (column B)
for ($row = $startRow; $row <= $highestRow; $row++) {
    $cell = 'B' . $row;
    $objSheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
}

$markscolumnLetter = chr(ord($columnLetter) - 1);
for ($row = $startRow; $row <= $highestRow; $row++) {
    $cell = $markscolumnLetter . $row;
    $objSheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
}


// Loop through each row again and apply protection to other columns (except column B)
$columnsToExclude = range('A', 'Z'); // Exclude all columns except 'B'
foreach ($columnsToExclude as $excludeColumn) {
    if ($excludeColumn !== 'B' && $excludeColumn !== $markscolumnLetter) {
        for ($row = $startRow; $row <= $highestRow; $row++) {
            $cell = $excludeColumn . $row;
            if(in_array($cell,$lockedShell)){
                continue;
            }
            $objSheet->getStyle($cell)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        }
    }

   
}

// pr($excludeColumn);die;

$objSheet->getProtection()->setSheet(true);
//  only for single header lock 
// $headerRow = 1;
// $highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
// for ($col = 'A'; $col <= $highestColumn; $col++) {
// 	$cell = $objPHPExcel->getActiveSheet()->getCell($col . $headerRow);
// 	$cell->getStyle()->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
// }
// // Unprotect all other rows
// $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
// for ($row = 2; $row <= $highestRow; $row++) {
// 	for ($col = 'A'; $col <= $highestColumn; $col++) {
// 		$cell = $objPHPExcel->getActiveSheet()->getCell($col . $row);
// 		$cell->getStyle()->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
// 	}
// }
// // Set worksheet protection to enable protection
// $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
// excel name find
$examName = $exam_name['exam_name'];
$courseName = $this->Comman->findclass($course_id)['title'];
$sectionYear = $this->Comman->findsecti($section_id)['title'];
$examName = preg_replace('/[^a-zA-Z0-9]+/', '_', $examName);
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = $examName . '(' . $courseName . '-' . $sectionYear . ')_' . date('d-m-Y') . ".xlsx";
// pr($filename);
// exit;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
