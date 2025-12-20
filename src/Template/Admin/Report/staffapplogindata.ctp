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



$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('808080');
$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('D1:G1');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);


$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'S.No.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Employee Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Mobile No');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Branch Name');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Status');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'App Install Date');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'App Update Date');



$counter = 1;


if (isset($expload_branch_name) && !empty($expload_branch_name)) {

    foreach ($expload_branch_name as $i => $value) {

        $get_app_data = $this->Comman->getstaffapplogincount($value);
        foreach ($get_app_data as $i => $val) {  //pr($val); die;
            $data[] = $val;
        }
    }

    foreach ($data as $i => $datass) {  //pr($datass); die;

        $branch_name = explode('_', $datass['db']);
        $ii = $i + 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, ucwords(strtolower($datass['fname'])) . ' ' . ucwords(strtolower($datass['middlename'])) . ' ' . ucwords(strtolower($datass['lname'])));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $datass['mobile']);

        if ($datass['db'] == $this->request->session()->read('Auth.User.db')) {

            $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, ucfirst($datass['db']));
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, ucfirst($branch_name[1]));
        }

        if (empty($datass['install_date'])) {
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, "Pending");
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, "Installed");
        }
        if (!empty($datass['install_date'])) {
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, date("d-m-Y", strtotime($datass['install_date'])));
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, "--");
        }
        if (!empty($datass['last_login'])) {
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, date("d-m-Y", strtotime($datass['last_login'])));
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, "--");
        }
    }
}

$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$date = date('Y-m-d');
$filename = "Staff-App-Login-Details-($date).xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
