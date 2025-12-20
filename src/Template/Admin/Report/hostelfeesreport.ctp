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
$objPHPExcel->getActiveSheet()->setAutoFilter('B1:Q1');

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
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:Q1")->applyFromArray($colorstyle);
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

// Loop through columns and set their auto size
foreach (range('A', 'Q') as $column) {
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
    'Scheme',
    'CheckIn Date',
    'CheckOut Date',
    'Monthly',
    'Caution Money',
    'Total Fees To Pay',
    'Total Fee Paid',
    'Discount',
    'Total Pending Fees',
    'Description',
);

// Loop through header labels and set them in the corresponding cells
for ($col = 'A', $i = 0; $col !== 'R'; $col++, $i++) {
    $objPHPExcel->getActiveSheet()->setCellValue($col . '1', $headerLabels[$i]);
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}



$counter = 1;
$total_deposite = 0;
$discount = 0;
$tojtal_pendingfees = 0;
$allrecords = count($student_rec_all) + 3;
if (isset($student_rec_all) && !empty($student_rec_all)) {

    foreach ($student_rec_all as $i => $value) {

        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enrollno']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['batch']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $value['studentname']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['classtitle']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $value['fathername']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['hostelscheme']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $value['checkInDate']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $value['checkOutDate']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $value['hostelfeesmonthly']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $ii, $value['hostelcautionmoney']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $value['totalFeesToPay']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, $value['totalFeesPay']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, $value['discount']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, $value['totalPending']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $ii, $value['descriptions']);
        $totalFeesToPay += $value['totalFeesToPay'];
        $totalFeesPay += $value['totalFeesPay'];
        $discount += $value['discount'];
        $totalPending += $value['totalPending'];
        $counter++;
    }


    $objPHPExcel->getActiveSheet()->getStyle('I' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('O' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('P' . $allrecords)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $allrecords, "Total");
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $allrecords, $totalFeesToPay);
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $allrecords, $totalFeesPay);
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $allrecords, $discount);
    $objPHPExcel->getActiveSheet()->setCellValue('P' . $allrecords, $totalPending);
}


$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "Hostel_Fees_Details_" . date('d-m-Y') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
