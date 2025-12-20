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
$objPHPExcel->getActiveSheet()->setAutoFilter('B1:K1');

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
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:K1")->applyFromArray($colorstyle);
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);

// Loop through columns and set their auto size
foreach (range('A', 'K') as $column) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}

// Set header labels
$headerLabels = array(
    'Sr.No.',
    'Scholar. No.',
    'Batch',
    'Student Name',
    'Course-Year',
    'Father',
    'Mobile',
    'Total Fees To Pay',
    'Total Fee Pay',
    'Discount',
    'Total Pending Fees'
);

// Loop through header labels and set them in the corresponding cells
for ($col = 'A', $i = 0; $col !== 'L'; $col++, $i++) {
    $objPHPExcel->getActiveSheet()->setCellValue($col . '1', $headerLabels[$i]);
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}



$counter = 1;
$total_deposite = 0;
$discount = 0;
$tojtal_pendingfees = 0;
$allrecords = count($students) + 3;
if (isset($students) && !empty($students)) {

    foreach ($students as $i => $value) {

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

        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enroll']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['batch']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $value['st_full_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['class']['title'] . '/' . $value['section']['title']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $value['fathername']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $total_batch_fee);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $otal_batch_paid_fee);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $getFeesDetails['discount']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $total_balance);

        $totalFeesToPay += $total_batch_fee;
        $totalFeesPay += $otal_batch_paid_fee;
        $discount += $getFeesDetails['discount'];
        $totalPending += $total_balance;
        $counter++;
    }


    $objPHPExcel->getActiveSheet()->getStyle('G' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('H' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $allrecords, "Total");
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $allrecords, $totalFeesToPay);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $allrecords, $totalFeesPay);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $allrecords, $discount);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $allrecords, $totalPending);
}


$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "Fees_Details_" . date('d-m-Y') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
