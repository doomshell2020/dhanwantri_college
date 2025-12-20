<?php
/*
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
$objPHPExcel->getActiveSheet()->setAutoFilter('C1:C1');

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
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Enroll No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Student Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Class-Section');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Father Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Mobile');

foreach ($qtrwise as $qtrwise_data) {

    if ($qtrwise_data == 'Quater1') {
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Q1 Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Q1 Collected');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Q1 Transport Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Q1 Transport Collected');
    } elseif ($qtrwise_data == 'Quater2') {
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Q2 Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Q2 Collected');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Q2 Transport Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Q2 Transport Collected');
    }elseif ($qtrwise_data == 'Quater3') {
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Q3 Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Q3 Collected');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Q3 Transport Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Q3 Transport Collected');
    }elseif ($qtrwise_data == 'Quater4') {

        $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Q4 Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Q4 Collected');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Q4 Transport Due');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Q4 Transport Collected');

    }




// $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Q1 Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Q1 Collected');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Q1 Transport Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Q1 Transport Collected');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Q2 Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Q2 Collected');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Q2 Transport Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Q2 Transport Collected');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Q3 Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Q3 Collected');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Q3 Transport Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Q3 Transport Collected');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Q4 Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Q4 Collected');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Q4 Transport Due');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Q4 Transport Collected');

// $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'TransportFees3');
// $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'TransportFees4');

$counter = 1;
$total_deposite = 0;
$discount = 0;

$allrecords = count($student_rec_all) + 3;
if (isset($student_rec_all) && !empty($student_rec_all)) {
    foreach ($student_rec_all as $i => $value) {
        //   pr($value); die; 

        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $value['enrollno']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, ucfirst(strtolower($value['studentname'])));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['classtitle']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, Ucfirst($value['fathername']));
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['mobile']);
        if ($qtrwise_data == 'Quater1') {
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $value['qu1_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['qu1_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['transport1_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $value['transport1_fees']);
    } elseif ($qtrwise_data == 'Quater2') {
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $value['qu2_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $value['qu2_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $ii, $value['transport2_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $value['transport2_fees']);
    }elseif ($qtrwise_data == 'Quater3') {
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, $value['qu3_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, $value['qu3_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, $value['transport3_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $ii, $value['transport3_fees']);
    }elseif ($qtrwise_data == 'Quater4') {
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $ii, $value['qu4_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $ii, $value['qu4_fees']);
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $ii, $value['transport4_fees_due']);
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $ii, $value['transport4_fees']);

    }
}
        $tojtal_pendingfees += $value['pending_fees'];
        $total_deposite += $value['total_deposite_amount'];
        $total_fees += $value['totalfees'];
        $discount += $value['discount'];
        $counter++;
    }

    // $objPHPExcel->getActiveSheet()->getStyle('Q'.$allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->getStyle('R'.$allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->getStyle('S'.$allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->getStyle('T'.$allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->getStyle('U'.$allrecords)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->setCellValue('Q'.$allrecords, "Total"); 
    // $objPHPExcel->getActiveSheet()->setCellValue('R'.$allrecords, $total_fees);
    // $objPHPExcel->getActiveSheet()->setCellValue('S'.$allrecords, $total_deposite);
    // $objPHPExcel->getActiveSheet()->setCellValue('T'.$allrecords, $tojtal_pendingfees);
    // $objPHPExcel->getActiveSheet()->setCellValue('U'.$allrecords, $discount);

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


*/ ?>
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
$objPHPExcel->getActiveSheet()->setAutoFilter('C1:C1');
$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, 'Enroll No.');
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 1, 'Student Name');
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, 1, 'Class-Section');
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, 1, 'Father Name');
$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, 1, 'Mobile');


$col_index = 5; // start with column F
$ii = 2; // start with row 2
$clmn = 6;
foreach ($qtrwise as $qtrwise_datas) {

    if ($qtrwise_datas == "Quater1") {
        $qtrwise_data = array(
            array('label' => 'Q1 Due', 'column' => chr($clmn + 64)), //F6
            array('label' => 'Q1 Collected', 'column' => chr($clmn + 64 + 1)), //G7
            array('label' => 'Q1 Transport Due', 'column' => chr($clmn + 64 + 2)), //H8
            array('label' => 'Q1 Transport Collected', 'column' => chr($clmn + 64 + 3)), //I9
            array('label' => 'Discount', 'column' => chr($clmn + 64 + 4)) //J9
        );
        $clmn = $clmn + 4;
    }

    if ($qtrwise_datas == "Quater2") {
        $qtrwise_data = array(
            array('label' => 'Q2 Due', 'column' => chr($clmn + 64)),
            array('label' => 'Q2 Collected', 'column' => chr($clmn + 64 + 1)),
            array('label' => 'Q2 Transport Due', 'column' => chr($clmn + 64 + 2)),
            array('label' => 'Q2 Transport Collected', 'column' => chr($clmn + 64 + 3))
        );
        $clmn = $clmn + 4;
    }
    if ($qtrwise_datas == "Quater3") {
        $qtrwise_data = array(
            array('label' => 'Q3 Due', 'column' => chr($clmn + 64)),
            array('label' => 'Q3 Collected', 'column' => chr($clmn + 64 + 1)),
            array('label' => 'Q3 Transport Due', 'column' => chr($clmn + 64 + 2)),
            array('label' => 'Q3 Transport Collected', 'column' => chr($clmn + 64 + 3))
        );
        $clmn = $clmn + 4;
    }
    if ($qtrwise_datas == "Quater4") {
        $qtrwise_data = array(
            array('label' => 'Q4 Due', 'column' => chr($clmn + 64)),
            array('label' => 'Q4 Collected', 'column' => chr($clmn + 64 + 1)),
            array('label' => 'Q4 Transport Due', 'column' => chr($clmn + 64 + 2)),
            array('label' => 'Q4 Transport Collected', 'column' => chr($clmn + 64 + 3))
        );
        $clmn = $clmn + 4;
    }

    // Loop through quarter-wise data to set cell values
    foreach ($qtrwise_data as $key => $data) {
        // pr($qtrwise_datas); 

        $label = $data['label'];
        $column = $data['column'] . '1';
        $objPHPExcel->setActiveSheetIndex()->setCellValue($column, $label);
    }
}

$counter = 1;
$total_deposite = 0;
$discount = 0;


$allrecords = count($student_rec_all) + 3;
if (isset($student_rec_all) && !empty($student_rec_all)) {
    foreach ($student_rec_all as $i => $value) {
        // pr($value); die;

        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $value['enrollno']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, ucfirst(strtolower($value['studentname'])));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['classtitle']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, Ucfirst($value['fathername']));
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['mobile']);

        $col_num = 5; // starting column number
        // Set the cell values for the quarters included in $qtrwise
        foreach ($qtrwise as $qtrwise_data) {
            switch ($qtrwise_data) {
                case 'Quater1':
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu1_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu1_fees']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport1_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport1_fees']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['discount']);
                    $col_num++;
                    break;
                case 'Quater2':
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu2_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu2_fees']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport2_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport2_fees']);
                    $col_num++;
                    break;
                case 'Quater3':
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu3_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu3_fees']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport3_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport3_fees']);
                    $col_num++;
                    break;
                case 'Quater4':
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu4_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['qu4_fees']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport4_fees_due']);
                    $col_num++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['transport4_fees']);
                    $col_num++;
                    break;
                default:
                    // do nothing
            }
        }
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['total_fees_due']);
        $col_num++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_num, $ii, $value['total_fees']);
        $col_num++;
    }
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
