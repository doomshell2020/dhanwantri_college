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
$objPHPExcel->getActiveSheet()->setAutoFilter('G1:H1');
$objPHPExcel->getActiveSheet()->setAutoFilter('K1:K1');
$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'S.No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Enroll No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Student Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Father Mobile');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Mother Mobile');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Admission Date');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Class');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Section');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Father Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Mother Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Branch Name');




$counter = 1;

if (isset($student_data) && !empty($student_data)) 
{
    foreach ($student_data as $i => $value) {     
           //pr($value); die;

        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['scholar_no']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $value['f_mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['m_mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, date('Y-m-d', strtotime($value['admission_date'])));
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['class']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['section']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, ucfirst(strtolower($value['fname'])));
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, ucfirst(strtolower($value['mname'])));
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $value['branch_name']);
      

      
    }

}

$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "Admission_Details.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
