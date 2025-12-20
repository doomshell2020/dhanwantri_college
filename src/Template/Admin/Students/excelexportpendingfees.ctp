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
// Loop through columns and set their auto size
foreach (range('A', 'N') as $column) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->setAutoFilter('G1:I1');


// $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'S.No.');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Schloar No.');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Student Name');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Father Name');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'SMS Mobile');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Admission Date');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Batch');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Course');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Year/Semester');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Previous Year Fees');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Previous Year Paid');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', '1st Year Fees');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', '1st Year Paid');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', '2nd Year Fees');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', '2nd Year Paid');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', '3rd Year Fees');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', '3rd Year Paid');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', '4th Year Fees');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', '4th Year Paid');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Discount');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Balance');


$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'S.No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Schloar. No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Mobile');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Fathername');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'SMS Mobile');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Admission Date');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Batch');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Course');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Year/Semester');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Fee');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Discount');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Previous Year Due');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Paid Previous Year');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Balance');


$counter = 1;
if (isset($students_details) && !empty($students_details)) {
    foreach ($students_details as $i => $value) { //pr($value); die;  


        $getFeesDetails = $this->Comman->getstudenttotalfeesdetails($value);
        //    pr($getFeesDetails); die;

        // $total_batch_fee = $getFeesDetails['1st_year_total_fees']+$getFeesDetails['2nd_year_total_fees']+$getFeesDetails['3rd_year_total_fees']+$getFeesDetails['4th_year_total_fees']+$getFeesDetails['previous_year'];

        if($section == '1'){
            $total_batch_fee = $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['previous_year'];
         }elseif($section == '2'){
            $total_batch_fee = $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['previous_year'];
         }elseif($section == '3'){
            $total_batch_fee = $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['previous_year'];
         }else{
            $total_batch_fee = $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['previous_year'];
         }

        $total_batch_paid_fee =$getFeesDetails['1st_year_students_fee_deposite']+$getFeesDetails['2nd_year_students_fee_deposite']+$getFeesDetails['3rd_year_students_fee_deposite']+$getFeesDetails['4th_year_students_fee_deposite']+$getFeesDetails['previous_year_students_fee_deposite'];
        
        $total_balance= $total_batch_fee-$total_batch_paid_fee-$getFeesDetails['discount'];

        $ii = $i + 2;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enroll']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, ucfirst(strtolower($value['st_full_name'])));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $value['mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, ucfirst(strtolower($value['fathername'])));
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $value['sms_mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, date('d-m-Y', strtotime($value['created'])));
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['batch']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $value['class']['title']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $value['section']['title']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $total_batch_fee);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $ii, $getFeesDetails['discount']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $total_batch_paid_fee);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, $getFeesDetails['previous_year']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, $getFeesDetails['previous_year_students_fee_deposite']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, $total_balance);

        // $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        // $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enroll']);
        // $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, ucfirst(strtolower($value['st_full_name'])));
        // $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, ucfirst(strtolower($value['fathername'])));
        // $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['mobile']);
        // $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, date('d-m-Y', strtotime($value['created'])));
        // $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['batch']);
        // $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['class']['title']);
        // $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $value['section']['title']);
        // $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $getFeesDetails['previous_year']);
        // $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $getFeesDetails['previous_year_students_fee_deposite']);
        // $objPHPExcel->getActiveSheet()->setCellValue('L' . $ii, $getFeesDetails['1st_year_total_fees']);
        // $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $getFeesDetails['1st_year_students_fee_deposite']);
        // $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, $getFeesDetails['2nd_year_total_fees']);
        // $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, $getFeesDetails['2nd_year_students_fee_deposite']);
        // $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, $getFeesDetails['3rd_year_total_fees']);
        // $objPHPExcel->getActiveSheet()->setCellValue('Q' . $ii, $getFeesDetails['3rd_year_students_fee_deposite']);
        // $objPHPExcel->getActiveSheet()->setCellValue('R' . $ii, $getFeesDetails['4th_year_total_fees']);
        // $objPHPExcel->getActiveSheet()->setCellValue('S' . $ii, $getFeesDetails['4th_year_students_fee_deposite']);
        // $objPHPExcel->getActiveSheet()->setCellValue('T' . $ii, $getFeesDetails['discount']);
        // $objPHPExcel->getActiveSheet()->setCellValue('U' . $ii, $total_balance);


        // total previous year
        // $previous_year_total_fee += $getFeesDetails['previous_year'];
        // $previous_year_paid_fee += $getFeesDetails['previous_year_students_fee_deposite'];

        // // 1st year total fees footer
        // $first_year_total_fee += $getFeesDetails['1st_year_total_fees'];
        // $first_year_paid_fee += $getFeesDetails['1st_year_students_fee_deposite'];

        // // 2nd year total fees footer
        // $second_year_total_fee += $getFeesDetails['2nd_year_total_fees'];
        // $second_year_paid_fee += $getFeesDetails['2nd_year_students_fee_deposite'];

        // //3rd year total fees footer
        // $thred_year_total_fee += $getFeesDetails['3rd_year_total_fees'];
        // $thred_year_paid_fee += $getFeesDetails['3rd_year_students_fee_deposite'];

        // //4th year total fees footer
        // $fourth_year_total_fee += $getFeesDetails['4th_year_total_fees'];
        // $fourth_year_paid_fee += $getFeesDetails['4th_year_students_fee_deposite'];

        // // discount total
        // $total_discount += $getFeesDetails['discount'];

        // // balance total
        // $total += $total_balance;

         //total previous year

        $totalprevious += $getFeesDetails['previous_year'];
        $totalpreviouspaid += $getFeesDetails['previous_year_students_fee_deposite'];
        $batch_fee += $total_batch_fee;
        $batch_paid_fee += $total_batch_paid_fee;
        $total_discount += $getFeesDetails['discount'];
        $total += $total_balance;


    } //die;

    $totalcol = $counter + 1;
    $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('O' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('P' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('Q' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('R' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('T' . $totalcol)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('U' . $totalcol)->getFont()->setBold(true);

    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $totalcol, 'Total');
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $totalcol, sprintf('%.2f', $previous_year_total_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $totalcol, sprintf('%.2f', $previous_year_paid_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $totalcol, sprintf('%.2f', $first_year_total_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $totalcol, sprintf('%.2f', $first_year_paid_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $totalcol, sprintf('%.2f', $second_year_total_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $totalcol, sprintf('%.2f', $second_year_paid_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $totalcol, sprintf('%.2f', $thred_year_total_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $totalcol, sprintf('%.2f', $thred_year_paid_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $totalcol, sprintf('%.2f', $fourth_year_total_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $totalcol, sprintf('%.2f', $fourth_year_paid_fee));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T' . $totalcol, sprintf('%.2f', $total_discount));
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U' . $totalcol, sprintf('%.2f', $total));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $totalcol, 'Total');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $totalcol, sprintf('%.2f', $batch_fee));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $totalcol, sprintf('%.2f', $total_discount));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $totalcol, sprintf('%.2f', $batch_paid_fee));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $totalcol, sprintf('%.2f', $totalprevious));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $totalcol, sprintf('%.2f', $totalpreviouspaid));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $totalcol, sprintf('%.2f', $total));
}
$current_date = date("d-m-Y");
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "Students_Pending_Fees_Details($current_date).xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
