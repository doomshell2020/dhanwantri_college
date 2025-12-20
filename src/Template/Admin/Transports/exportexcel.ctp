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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:H1');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
 
$objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A1', 'S.No.')
     ->setCellValue('B1', 'Enroll No.')
     ->setCellValue('C1', 'Student Name')
     ->setCellValue('D1', 'Class')
     ->setCellValue('E1', 'Section')
     ->setCellValue('F1', 'Locations')
     ->setCellValue('G1', 'Bus')
     ->setCellValue('H1', 'Academic Year');
    //  ->setCellValue('I1', 'Quater2')
    //  ->setCellValue('J1', 'Quater3')
    //  ->setCellValue('K1', 'Quater4')
    //  ->setCellValue('L1', 'Academic Year')
    // //  ->setCellValue('M1', 'Status')
    //  ->setCellValue('M1', 'Created');		
			
			
    $counter=1;
    if(isset($studnetdata) && !empty($studnetdata)){ 
        foreach($studnetdata as $i=>$value){
	        $ii = $i+2;

            // $findsubquater = $this->Comman->findtransportfees($value['location_id'],$value['acadamic_year']);
            // $fee_sub_q1 = date('Y-m-d', strtotime($findsubquater['fee_sub_q1']));
            // $feesdateq1 = $value['qu1_fees'].'-('.$fee_sub_q1.')';

            // $fee_sub_q2 = date('Y-m-d', strtotime($findsubquater['fee_sub_q2']));
            // $feesdateq2 = $value['qu2_fees'].'-('.$fee_sub_q2.')';

            // $fee_sub_q3 = date('Y-m-d', strtotime($findsubquater['fee_sub_q3']));
            // $feesdateq3 = $value['qu3_fees'].'-('.$fee_sub_q3.')';

            // $fee_sub_q4 = date('Y-m-d', strtotime($findsubquater['fee_sub_q4']));
            // $feesdateq4 = $value['qu4_fees'].'-('.$fee_sub_q4.')';
            // if($value['status']=='Y'){
            // $status = 'Active';
            // }else{
            // $status = 'Deactive';
            // }
  
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, $counter++);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $value['enroll']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, ucfirst(strtolower($value['fname'] . ' ' . $value['middlename'] . ' ' . $value['lname'])));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, ucfirst(strtolower($value['class']['title'])));
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, ucfirst(strtolower($value['section']['title'])));
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $ii, ucfirst(strtolower($value['location']['name'])));
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $ii, $value['bus_number']);

            // $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $feesdateq1);
            // $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, $feesdateq2);
            // $objPHPExcel->getActiveSheet()->setCellValue('J' . $ii, $feesdateq3);
            // $objPHPExcel->getActiveSheet()->setCellValue('K' . $ii, $feesdateq4);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $ii, $value['acedmicyear']);
            // $objPHPExcel->getActiveSheet()->setCellValue('M' . $ii, $status);
            // $objPHPExcel->getActiveSheet()->setCellValue('I' . $ii, date('Y-m-d', strtotime($findsubquater['created'])));  

        }

    }

// Rename sheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
$filename = "All_Student_Transport_List-".date('d-m-Y').".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
