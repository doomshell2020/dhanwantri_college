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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)

    ->setCellValue('A1', 'S.No.')
    ->setCellValue('B1', 'Class')
    ->setCellValue('C1', 'Section')
    ->setCellValue('D1', 'Class Teacher')
    ->setCellValue('E1', 'Co Class Teacher');
   

$counter = 1;
$ii=2;
if (isset($classec) && !empty($classec)) {
    foreach ($classec as $i => $class) {
        $teacher=$this->classteachers($class["class_id"],$class["section_id"],1);
        $coteacher=$this->classteachers($class["class_id"],$class["section_id"],2);
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $classes[$class["class_id"]]);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $sections[$class["section_id"]]);
        $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('D' . $ii)->getDataValidation();
        $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
        $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
        $objValidation2->setShowErrorMessage(true);
        $objValidation2->setAllowBlank(false);
        $objValidation2->setShowInputMessage(true);
        $objValidation2->setShowDropDown(true);
        $objValidation2->setPromptTitle('Pick from list');
        $objValidation2->setPrompt('Please pick a value from the drop-down list.');
        $objValidation2->setErrorTitle('Input error');
        $objValidation2->setError('Value is not in list');
        $objValidation2->setFormula1('"'.implode('","', $employees).'"');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $teacher);
        $objValidation3 = $objPHPExcel->getActiveSheet()->getCell('E' . $ii)->getDataValidation();
        $objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
        $objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
        $objValidation3->setShowErrorMessage(true);
        $objValidation3->setAllowBlank(false);
        $objValidation3->setShowInputMessage(true);
        $objValidation3->setShowDropDown(true);
        $objValidation3->setPromptTitle('Pick from list');
        $objValidation3->setPrompt('Please pick a Teacher from the drop-down list.');
        $objValidation3->setErrorTitle('Input error');
        $objValidation3->setError('Value is not in list');
        $objValidation3->setFormula1('"'.implode('","', $employees).'"');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $coteacher);

        $ii++;
        }

}
// Rename sheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "EmployeePayroll_Settings.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;