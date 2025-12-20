<?php
//pr($date);die;
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

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'SR.No.')
    ->setCellValue('B1', 'Emp. Id')
    ->setCellValue('C1', 'Name');
// $date = date("m-Y", strtotime("-1 months"));
$date="10-2019";
$mon = date('m', $date);
$date1 = explode('-', $date);
$mon = $date1[0];
$year = $date1[1];

$days = 1;
$startdate = $year . '-' . $mon . '-01';
$start_time = strtotime($startdate);
$end_time = strtotime("+1 month", $start_time);
$date_range = array();
$alph = "D";
for ($i = $start_time; $i < $end_time; $i += 86400) {
    $dayOfWeek = date("l", $i);
    $pre_date = date('Y-m-d', $i);
    $holiday = $this->Comman->findholidaymonth($pre_date);
    //pr($holiday);die;
    $objPHPExcel->getActiveSheet()->getColumnDimension($alph)->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($alph . '1', $days);
    if ($dayOfWeek != 'Sunday' && $holiday == 0) {
        $date_range[] = $pre_date;
    } else {
        if ($dayOfWeek == 'Sunday') {

            $date_range[] = 'hol';

        } else if ($holiday > 0) {

            $date_range[] = 'hol';

        }

    }

    $days++;
    $alph++;
}
// pr($date_range); die;

$count = 1;

$row = 2;
foreach ($emp as $emp_values) {
    $j_day = 0;
    $join_month = date("m-Y", strtotime($emp_values['joiningdate']));
    if (strtotime('1-' . $date) == strtotime('1-' . $join_month)) {
        $j_day = date("d", strtotime($emp_values['joiningdate']));
    } else if (strtotime('1-' . $date) <= strtotime('1-' . $join_month)) {
        $j_day = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
    }

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $row, $count);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B' . $row, $emp_values['id']);

    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C' . $row, strtoupper($emp_values['fname']) . "\x20" . strtoupper($emp_values['middlename']) . "\x20"
            . strtoupper($emp_values['lname']));
    $alph1 = "C";
    $P = 0;
    $PR = 0;
    $PL = 0;
    $d_cnt = 1;
    foreach ($date_range as $date_val) {
        if ($d_cnt <= $j_day) {
            $alph1++;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($alph1 . $row, '-');
            $d_cnt++;

            continue;}
        $status = '';
        $emp_atn = '';
        $alph1++;
        if ($date_val == 'hol') {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($alph1 . $row, 'H');
        } else {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($alph1 . $row, 'P');
        }

    }

    $alph1++;

    $count++;
    $row++;

}

// Rename sheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web $colser (Excel2007)
$filename = "Monthly_Attendance_report(" . $date . ").xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;