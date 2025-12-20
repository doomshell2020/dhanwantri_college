<?php
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");
// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0);

// Set headers
$objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Course');
$objPHPExcel->getActiveSheet()->setCellValue('C1', '1st Year');
$objPHPExcel->getActiveSheet()->setCellValue('D1', '2nd Year');
$objPHPExcel->getActiveSheet()->setCellValue('E1', '3rd Year');
$objPHPExcel->getActiveSheet()->setCellValue('F1', '4th Year');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Academic Year');

// Populate data from HTML table
$counter = 1;
if (isset($classfee) && !empty($classfee)) {
    foreach ($classfee as $i => $value) {
        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);

        // Extracting Course
        $course = '';
        $srts = $this->Comman->issuedCountstudents($value['slab']);
        foreach ($srts as $rty => $rgh) {
            $srts = $this->Comman->findclass123($rgh['class_id']);
            $course .= $srts['title'] . "\n"; // Using newline for Excel cell wrapping
        }
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $course);

        // Extracting fees for each year
        $years = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
        for ($j = 0; $j < count($years); $j++) {
            $fees = '';
            $srt = $this->Comman->findfeeheadsclassfee($value['class_id'], $value['academic_year']);
            foreach ($srt as $ss => $rt) {
                $fee = '';
                switch ($j) {
                    case 0:
                        $fee = $rt['qu1_fees'];
                        break;
                    case 1:
                        $fee = $rt['qu2_fees'];
                        break;
                    case 2:
                        $fee = $rt['qu3_fees'];
                        break;
                    case 3:
                        $fee = $rt['qu4_fees'];
                        break;
                }
                if ($fee) {
                    $fees .=  $rt['feeshead']['name'] . "-" . $fee; // Adjusting formatting
                }
            }
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $fees); // Writing fees data in corresponding columns
        }

        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['academic_year']);
    }
}

// Output Excel file
$filename = "Parent_Login_Details.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
