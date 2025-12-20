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
$objPHPExcel->getActiveSheet()->setAutoFilter('B1:AC1');

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
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:AC1")->applyFromArray($colorstyle);
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getFont()->setBold(true);

// Loop through columns and set their auto size
foreach (range('A', 'AC') as $column) {
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
    'Admission / Prospectus',
    'College Caution Money',
    'Uniform Fee',
    'Books',
    'Pocket Articles',
    'Library Fees',
    'Enrollment Fees',
    'Health Insurance',
    'Tuition Fee 1st Year',
    'Tuition Fee 2nd Year',
    'Tuition Fee 3rd Year',
    'Tuition Fee 4th Year',
    'Transport 1st Year',
    'Transport 2nd Year',
    'Transport 3rd Year',
    'Transport 4th Year',
    'Total Transport Fee',
    'Pending Transport Fees',
    'Total Fees',
    'Total Deposit Amount',
    'Total Pending Fees',
    'Discount'
);

// Loop through header labels and set them in the corresponding cells
for ($col = 'A', $i = 0; $col !== 'AD'; $col++, $i++) {
    $objPHPExcel->getActiveSheet()->setCellValue($col . '1', $headerLabels[$i]);
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}



$counter = 1;
$total_deposite = 0;
$discount = 0;
$tojtal_pendingfees = 0;
$allrecords = count($student_rec_all) + 2;
if (isset($student_rec_all) && !empty($student_rec_all)) {
    foreach ($student_rec_all as $i => $value) {
        // pr($value);exit;        
        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enrollno']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['batch']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $value['studentname']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['classtitle']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $value['fathername']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['admissionfee']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $value['collage_caution_money']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $value['uniform_money']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $value['book_money']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $ii, $value['pocketArticales_money']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $value['library_money']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, $value['enrollment_money']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, $value['health_money']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, $value['tution_fee_1st_year']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $ii, $value['tution_fee_2st_year']);
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $ii, $value['tution_fee_3st_year']);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $ii, $value['tution_fee_st_year']);
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $ii, $value['transport1_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $ii, $value['transport2_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('V' . $ii, $value['transport3_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('W' . $ii, $value['transport4_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('X' . $ii, $value['totaltransportfees']);
        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $ii, $value['pending_transport_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('Z' . $ii, $value['totalfees']);
        $objPHPExcel->getActiveSheet()->setCellValue('AA' . $ii, $value['total_deposite_amount']);
        $objPHPExcel->getActiveSheet()->setCellValue('AB' . $ii, $value['pending_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $ii, $value['discount']);
        $tojtal_pendingfees += $value['pending_fees'];
        // $total_deposite += $value['total_deposite_amount'];
        $total_fees += $value['totalfees'];
        // $discount += $value['discount'];
        $counter++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('Y' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('Z' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('AB' . $allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->getStyle('T' . $allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->getStyle('U' . $allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->setCellValue('S' . $allrecords, $total_deposite);
    $objPHPExcel->getActiveSheet()->setCellValue('Y' . $allrecords, "Total");
    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $allrecords, $total_fees);
    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $allrecords, $tojtal_pendingfees);
    // $objPHPExcel->getActiveSheet()->setCellValue('U' . $allrecords, $discount);
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
