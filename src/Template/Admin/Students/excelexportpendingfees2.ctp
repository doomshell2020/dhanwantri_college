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
foreach (range('A', 'Z') as $column) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}


$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->setAutoFilter('G1:Z1');


$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'S No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Schloar No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Name(Fathername)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Mobile');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Batch');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Course/Year');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Prev Fees');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Prev Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', '1stYr Fees');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', '1stYr Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', '1stYr Trans Fee');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', '1stYr Trans Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', '2ndYr Fees');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', '2ndYr Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', '2ndYr Trans Fee');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', '2ndYr Trans Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', '3rdYr Fees');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', '3rdYr Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', '3rdYr Trans Fee');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', '3rdYr Trans Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', '4thYr Fees');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', '4thYr Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', '4thYr Trans Fee');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', '4thYr Trans Paid');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'Discount');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'Balance');


$ii = 2;
$counter = 1;
if (isset($students_details) && !empty($students_details)) {
    foreach ($students_details as $i => $value) {
        $getFeesDetails = $this->Comman->getstudenttotalfeesdetails($value);

        $section_id = $value['section_id'];

        if ($section_id == 1) {
            $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
            $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
            $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
        } elseif ($section_id == 2) {
            $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
            $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
            $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
        } elseif ($section_id == 3) {
            $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
            $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
            $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
        } else {
            $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
            $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
            $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
        }

        $total_balance = $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];

        if ($total_balance == 0) {
            if ($no_dues == 1) {
            } else {
                continue;
            }
        }

        for ($col = 'G'; $col <= 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()->getStyle($col . $ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enroll']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['st_full_name'] . '(' . $value['fathername'] . ')');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $value['mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['batch']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $value['class']['title'] . '/' . $value['section']['title']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $getFeesDetails['previous_year']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $getFeesDetails['previous_year_students_fee_deposite']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $getFeesDetails['1st_year_total_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $getFeesDetails['1st_year_students_fee_deposite']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $getFeesDetails['1st_year_transport_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $ii, $getFeesDetails['1st_year_students_transport_deposite']);

        if ($section_id == 2 || $section_id == 3 || $section_id == 4) {
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $getFeesDetails['2nd_year_total_fees']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, $getFeesDetails['2nd_year_students_fee_deposite']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, $getFeesDetails['2nd_year_transport_fees']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, $getFeesDetails['2nd_year_students_transport_deposite']);
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, 'NA');
        }

        if ($section_id == 3 || $section_id == 4) {
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $ii, $getFeesDetails['3rd_year_total_fees']);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $ii, $getFeesDetails['3rd_year_students_fee_deposite']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $ii, $getFeesDetails['3rd_year_transport_fees']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $ii, $getFeesDetails['3rd_year_students_transport_deposite']);
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $ii, 'NA');
        }

        if ($section_id == 4) {
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $ii, $getFeesDetails['4th_year_total_fees']);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $ii, $getFeesDetails['4th_year_students_fee_deposite']);
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $ii, $getFeesDetails['4th_year_transport_fees']);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $ii, $getFeesDetails['4th_year_students_transport_deposite']);
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $ii, 'NA');
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $ii, 'NA');
        }
        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $ii, $getFeesDetails['discount']);
        $objPHPExcel->getActiveSheet()->setCellValue('Z' . $ii, $total_balance);


        // total previous year
        $previous_year_total_fee += $getFeesDetails['previous_year'];
        $previous_year_paid_fee += $getFeesDetails['previous_year_students_fee_deposite'];

        // 1st year total  fees footer
        $first_year_total_fee += $getFeesDetails['1st_year_total_fees'];
        $first_year_paid_fee += $getFeesDetails['1st_year_students_fee_deposite'];
        $first_year_transport_total_fee += $getFeesDetails['1st_year_transport_fees'];
        $first_year_transport_paid_fee += $getFeesDetails['1st_year_students_transport_deposite'];

        // 2nd year total fees footer
        if ($section_id == 2 || $section_id == 3 || $section_id == 4) {
            $second_year_total_fee += $getFeesDetails['2nd_year_total_fees'];
            $second_year_paid_fee += $getFeesDetails['2nd_year_students_fee_deposite'];
            $second_year_transport_total_fee += $getFeesDetails['2nd_year_transport_fees'];
            $second_year_transport_paid_fee += $getFeesDetails['2nd_year_students_transport_deposite'];
        }

        //3rd year total fees footer
        if ($section_id == 3 || $section_id == 4) {
            $third_year_total_fee += $getFeesDetails['3rd_year_total_fees'];
            $third_year_paid_fee += $getFeesDetails['3rd_year_students_fee_deposite'];
            $third_year_transport_total_fee += $getFeesDetails['3rd_year_transport_fees'];
            $third_year_transport_paid_fee += $getFeesDetails['3rd_year_students_transport_deposite'];
        }

        //4th year total fees footer
        if ($section_id == 4) {
            $fourth_year_total_fee += $getFeesDetails['4th_year_total_fees'];
            $fourth_year_paid_fee += $getFeesDetails['4th_year_students_fee_deposite'];
            $fourth_year_transport_total_fee += $getFeesDetails['4th_year_transport_fees'];
            $fourth_year_transport_paid_fee += $getFeesDetails['4th_year_students_transport_deposite'];
        }

        // discount total
        $total_discount += $getFeesDetails['discount'];
        // balance total
        $total += $total_balance;
        $counter++;
        $ii++;

    }

    $totalcol = $counter + 1;
    $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);

    // Helper function to set cell value and make text bold
    function setBoldCellValue($objPHPExcel, $column, $row, $value)
    {
        $cell = $column . $row;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell, $value);
        $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
    }

    setBoldCellValue($objPHPExcel,'C', $totalcol, 'Total');
    setBoldCellValue($objPHPExcel,'G', $totalcol, sprintf('%.2f', $previous_year_total_fee));
    setBoldCellValue($objPHPExcel,'H', $totalcol, sprintf('%.2f', $previous_year_paid_fee));
    setBoldCellValue($objPHPExcel,'I', $totalcol, sprintf('%.2f', $first_year_total_fee));
    setBoldCellValue($objPHPExcel,'J', $totalcol, sprintf('%.2f', $first_year_paid_fee));
    setBoldCellValue($objPHPExcel,'K', $totalcol, sprintf('%.2f', $first_year_transport_total_fee));
    setBoldCellValue($objPHPExcel,'L', $totalcol, sprintf('%.2f', $first_year_transport_paid_fee));

    setBoldCellValue($objPHPExcel,'M', $totalcol, sprintf('%.2f', $second_year_total_fee));
    setBoldCellValue($objPHPExcel,'N', $totalcol, sprintf('%.2f', $second_year_paid_fee));
    setBoldCellValue($objPHPExcel,'O', $totalcol, sprintf('%.2f', $second_year_transport_total_fee));
    setBoldCellValue($objPHPExcel,'P', $totalcol, sprintf('%.2f', $second_year_transport_paid_fee));

    setBoldCellValue($objPHPExcel,'Q', $totalcol, sprintf('%.2f', $third_year_total_fee));
    setBoldCellValue($objPHPExcel,'R', $totalcol, sprintf('%.2f', $third_year_paid_fee));
    setBoldCellValue($objPHPExcel,'S', $totalcol, sprintf('%.2f', $third_year_transport_total_fee));
    setBoldCellValue($objPHPExcel,'T', $totalcol, sprintf('%.2f', $third_year_transport_paid_fee));

    setBoldCellValue($objPHPExcel,'U', $totalcol, sprintf('%.2f', $fourth_year_total_fee));
    setBoldCellValue($objPHPExcel,'V', $totalcol, sprintf('%.2f', $fourth_year_paid_fee));
    setBoldCellValue($objPHPExcel,'W', $totalcol, sprintf('%.2f', $fourth_year_transport_total_fee));
    setBoldCellValue($objPHPExcel,'X', $totalcol, sprintf('%.2f', $fourth_year_transport_paid_fee));

    setBoldCellValue($objPHPExcel,'Y', $totalcol, sprintf('%.2f', $total_discount));
    setBoldCellValue($objPHPExcel,'Z', $totalcol, sprintf('%.2f', $total));

}
$current_date = date("d-m-Y");
$file = $students_details[0]['class']['title'] . '/' . $students_details[0]['batch'] . '_Pending_fee(' . $current_date . ')';
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "$file.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
