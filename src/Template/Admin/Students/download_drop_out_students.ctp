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
$objPHPExcel->getActiveSheet()->setAutoFilter('B1:AE1');

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
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:AE1")->applyFromArray($colorstyle);
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getFont()->setBold(true);

// Loop through columns and set their auto size
foreach (range('A', 'AE') as $column) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}

// Set header labels
$headerLabels = array(
    'S.No.',
    'Scholar. No.',
    'Student Type',
    'Student Name',
    'Academic Year',
    'Batch',
    'Roll Number',
    'Enrolment Number',
    'Course-Year',
    'Branch',
    'DOB',
    'Email',
    'Mobile No',
    'Gender',
    'Application Form/Date',
    'Date of Joining',
    'Aadhar No',
    'SMS Mobile',
    'Category',
    'Father Name',
    'Father Mobile No',
    'Father Occupation',
    'Mother Name',
    'Mother Mobile No',
    'Mother Occupation',
    'Residential Address',
    'Documents Uploaded',
    'Is Hostal',
    'Is Transport',
    'Description',
    'Status'
);

// Loop through header labels and set them in the corresponding cells
for ($col = 'A', $i = 0; $col !== 'AF'; $col++, $i++) {
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
        $stfullname = $value['fname'];
        if (trim($value['middlename'])) {
            $stfullname = $value['fname'] . ' ' . $value['middlename'];
        } else if (trim($value['lname'])) {
            $stfullname = $value['fname'] . ' ' . $value['middlename'] . ' ' . $value['lname'];
        }

        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enroll']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $value['mode']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $stfullname);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, $value['acedmicyear']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, $value['batch']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['roll_no']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['enrolment_no']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $value['class']['wordsc']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $value['board']['full_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, date('d-m-Y', strtotime($value['dob'])));
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $ii, $value['email']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $value['mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $ii, $value['gender']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $ii, $value['applocation_form_date']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $ii, (!empty($value['date_of_joining'])) ? date('d-m-Y', strtotime($value['date_of_joining'])) : '--');
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $ii, $value['adaharnumber']);
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $ii, $value['sms_mobile']);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $ii, $value['category']);
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $ii, $value['fathername']);
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $ii, $value['f_phone']);
        $objPHPExcel->getActiveSheet()->setCellValue('V' . $ii, $value['f_occupation']);
        $objPHPExcel->getActiveSheet()->setCellValue('W' . $ii, $value['mothername']);
        $objPHPExcel->getActiveSheet()->setCellValue('X' . $ii, $value['m_phone']);
        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $ii, $value['m_occupation']);
        $objPHPExcel->getActiveSheet()->setCellValue('Z' . $ii, $value['address']);
        $objPHPExcel->getActiveSheet()->setCellValue('AA' . $ii,  '--');
        $objPHPExcel->getActiveSheet()->setCellValue('AB' . $ii, ($value['is_hostel']) ? 'Y' : 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $ii, ($value['is_transport'] == 'Y') ? 'Y' : 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('AD' . $ii, $value['remarks']);
        $objPHPExcel->getActiveSheet()->setCellValue('AE' . $ii, $value['status']);
        $counter++;
    }
}


$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "Drop_Out_Students_List_" . date('d_m_Y') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
