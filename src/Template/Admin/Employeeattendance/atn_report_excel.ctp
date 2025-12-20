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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'S.No.')
    ->setCellValue('B1', 'Date')
    ->setCellValue('C1', 'Teacher  Name')
    ->setCellValue('D1', 'A0')
    ->setCellValue('E1', 'A1')
    ->setCellValue('F1', 'A2')
    ->setCellValue('G1', 'A3')
    ->setCellValue('H1', 'A4')
    ->setCellValue('I1', 'A5')
    ->setCellValue('J1', 'A6')
    ->setCellValue('K1', 'A7')

;

$counter = 1;
$totalamt = '';
$totaldis = '';
$grandtotal = '';
//$date = date('d-m-Y');

if (isset($employees) && !empty($employees)) {
    //pr($employees);die;
    foreach ($employees as $i => $work) {
        //pr($work);
        $ii = $i + 2;
        $absent = array();
        $present = array();
        $att_exist = $this->Comman->findEmployeeAttendanceReport($work['id'], $date);
        //pr($att_exist);
        if (!empty($att_exist['absent_periods'])) {
            $absent = explode(',', $att_exist['absent_periods']);
        }
        if (!empty($att_exist['present_periods'])) {
            $present = explode(',', $att_exist['present_periods']);
        }
        if (in_array('A0', $absent)) {$a1 = "A";
        } else if (in_array('A0', $present)) {$a1 = "P";} else { $a1 = "N/A";}
        if (in_array('A1', $absent)) {$a2 = "A";
        } else if (in_array('A1', $present)) {$a2 = "P";} else { $a2 = "N/A";}
        if (in_array('A2', $absent)) {$a3 = "A";
        } else if (in_array('A2', $present)) {$a3 = "P";} else { $a3 = "N/A";}
        if (in_array('A3', $absent)) {$a4 = "A";
        } else if (in_array('A3', $present)) {$a4 = "P";} else { $a4 = "N/A";}
        if (in_array('A4', $absent)) {$a5 = "A";
        } else if (in_array('A4', $present)) {$a5 = "P";} else { $a5 = "N/A";}
        if (in_array('A5', $absent)) {$a6 = "A";
        } else if (in_array('A5', $present)) {$a6 = "P";} else { $a6 = "N/A";}
        if (in_array('A6', $absent)) {$a7 = "A";
        } else if (in_array('A6', $present)) {$a7 = "P";} else { $a7 = "N/A";}
        if (in_array('A7', $absent)) {$a8 = "A";
        } else if (in_array('A7', $present)) {$a8 = "P";} else { $a8 = "N/A";}

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $date);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, strtoupper($work['fname']) . "\x20" . strtoupper($work['miiddlename']) . strtoupper($work['lname']));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $a1);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $a2);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $a3);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $a4);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $a5);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $a6);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $a7);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $a8);

    }

}

$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "Daily_attendance_report(" . $date . ").xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;