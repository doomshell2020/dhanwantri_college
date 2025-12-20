<?php
$CourseName = $this->Comman->findclass($course_id);
// pr($CourseName);die;
class xtcpdf extends TCPDF {}
$this->set('pdf', new TCPDF('L', 'mm', 'A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();


//$pdf->setHeaderMargin(0);
// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetAutoPageBreak(TRUE, 10);
// $pdf->SetMargins(5, 0, 5, true);
// pr($examResultDate['exam_name']);exit;
$result_date = date("d-m-Y", strtotime($examResultDate['result_date']));
// $result_date_held=date("M-Y",strtotime($examResultDate['result_date']));

// pr($html);die;

$date = new DateTime(date("M-Y", strtotime($examResultDate['exam_date'])));
$result_date_held = $date->format("F , Y");

// pr($examResultDate['exam_name']);exit;

// pr($examResultDate);exit;

$subtitle1 = $this->Comman->findlogo();
// pr($subtitle1);die;
// <th  style="width: 09%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Eligible for Bsc.(N)-II</strong></th>

$pdf->SetFont('', '', 8, '', 'true');
TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);
$i = 1;
$html .= '
<h4 style="text-align:center; font-size: 8px;">' . $subtitle1['subtitle1'] . '</h4>
<h5 style="text-align:center; font-size: 8px;">2' . $subtitle1['address1'] . '</h5>
<p style="text-align:center; font-size: 8px;">Ph.No.: ' . $subtitle1['phone'] . '</p>


<h4 style="text-align:center; font-size: 8px;">Result of ' . $examResultDate['exam_name'] . ' on dated ' . $result_date . '</h4>
<h4 style="text-align:center; font-size: 8px;" >Exam held on ' . $result_date_held . '</h4>
<table cellspacing="0" cellpadding="5" style="font-size:8px;">
   <thead>
      <tr>
         <th  style="width: 04%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>No</strong></th>
         <th  style="width: 07%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Enroll</strong></th>
         <th  style="width: 07%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Roll No.</strong></th>
         <th  style="width: 08%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Batch</strong></th>
         <th  style="width: 12%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Name</strong></th>
         <th  style="width: 21%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Subject</strong></th>
         <th  style="width: 09.5%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Result</strong></th>
         <th  style="width: 08%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Obtain Marks</strong></th>
         <th  style="width: 24%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Fail in Subject</strong></th>
      </tr>
   </thead>
   <tbody>';
$totalStudent = count($studentsPdfData);

// pr($mResultDate);die;
// pr($result_date );die
// pr($totalStudent);die;

$RemandedStudent = [];
$PassStudent = []; 
$AbsentStudent = [];



foreach ($studentsPdfData as $value) {
   // pr($value); die;
 
   $findBatchEnroll = $this->Comman->find_enroll_batch($value['student_id']);

   // $first = $this->comman->round($value['student_id']);

 

  // pr($findBatchEnroll); die;

 

   if ($value['result'] == 'Pass') {
      $PassStudent[] = $value['id'];
   } elseif ($value['result'] == 'Absent') {
      $AbsentStudent[] = $value['id'];
   } else if ($value['result'] == 'Not Uploaded') {
      $NotUploadedStudentResult[] = $value['id'];
   } else {
      $RemandedStudent[] = $value['id'];
   }



   $html .= '
   <tbody>
      <tr>
         <th  style="width: 04%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $i . '</th>
         <td  style="width: 07%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $value['enrolment_no'] . '</td>
         <td  style="width: 07%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $value['roll_no'] . '</td>
         <td  style="width: 08%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $findBatchEnroll['batch'] . '</td>
         <td  style="width: 12%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $value['name'] . '</td>
         <td  style="width: 21%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $value['subject'] . '</td>
         <td  style="width: 09.5%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $value['result'] . '</td>
         <td  style="width: 08%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . (!empty($value['obtained_marks']) ? $value['obtained_marks'] : 0) . '</td>
         <td  style="width: 24%; font-size: 8px; border:0.3px solid #333; border-right:none;">
            ' . (!empty($value['fail_in_subject']) ?  $value['fail_in_subject'] : '
            <p style="text-align:center;">-</p>
            ') . '
         </td>
      </tr>
   </tbody>
   ';
   $i++;


}
// <td  style="width: 21%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $value['eligible_for'] . '</td>

                                                                                                         
$html .= '
   </tbody>
</table>
<br><br>';
$html .= '
<span style="font-size: 8px;">Note - The most of Remanded Students may count in Pass Candidate,they are on border line and they will be pass in Revaluation.</span>
<br><br><br>';
$html .= '
<table cellspacing="0" cellpadding="5" style="font-size:9px; width:100%">
   <thead>
      <tr>
         <th  style="width: 10%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Rank</strong></th>
         <th  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Enrolment</strong></th>
         <th  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Roll No.</strong></th>
         <th  style="width: 30%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Name of Student</strong></th>
         <th  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Obtained Marks</strong></th>
         <th  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>%</strong></th>
      </tr>
   </thead>
   <tbody>';
function romanNumerals($number)
{
   $numerals = [
      'M' => 1000,
      'CM' => 900,
      'D' => 500,
      'CD' => 400,
      'C' => 100,
      'XC' => 90,
      'L' => 50,
      'XL' => 40,
      'X' => 10,
      'IX' => 9,
      'V' => 5,
      'IV' => 4,
      'I' => 1
   ];
   $result = '';

   foreach ($numerals as $numeral => $value) {

      while ($number >= $value) {
         $result .= $numeral;
         $number -= $value;
        
      }
   }
 
   return $result;
}


$J = 1;


foreach ($top3Student as $optainMarks) {
   $romanNumeral = romanNumerals($J);

   $getPercentage = $optainMarks['obtained_marks'] / $optainMarks['total_marks'] * 100;
   $html .= '
   <tbody>
      <tr>
         <td style="width: 10%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $romanNumeral . '</td>
         <td  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $optainMarks['enrolment_no'] . '</td>
         <td  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $optainMarks['roll_no'] . '</td>
         <td  style="width: 30%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $optainMarks['name'] . '</td>
         <td  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $optainMarks['obtained_marks'] . '</td>
         <td  style="width: 15%; font-size: 8px; border:0.3px solid #333; border-right:none;">' . number_format($getPercentage, 2) . '%' . '</td>
      </tr>
   </tbody>
   ';
   $J++;
}
$html .= '
   </tbody>
</table>
<br><br><br><br><br><br>';
$html .= '
<table cellspacing="0" cellpadding="5" style="font-size:9px; width:65%">
   <thead>
      <tr>
         <th  style="border:0.5px solid #333; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Pass</strong></th>
         <th  style="border:0.5px solid #333; font-size: 8px; border:0.3px solid #333; border-right:none;"><strong>Remanded</strong></th>
         <th  style="border:0.5px solid #333; font-size: 8px;border:0.3px solid #333; border-right:none;"><strong>Absent</strong></th>
         <th  style="border:0.5px solid #333; font-size: 8px;border:0.3px solid #333; border-right:none;"><strong>Not Uploaded Student Result</strong></th>
         <th  style="border:0.5px solid #333; font-size: 8px;border:0.3px solid #333; border-right:none;"><strong>Total</strong></th>
      </tr>
   </thead>
   <tbody>';
$html .= '
   <tbody>
      <tr>
         <td  style="border:1px solid #333; font-size: 8px; border:0.3px solid #333; border-right:none;">' . count($PassStudent) . '</td>
         <td  style="border:1px solid #333; font-size: 8px; border:0.3px solid #333; border-right:none;">' . count($RemandedStudent) . '</td>
         <td  style="border:1px solid #333; font-size: 8px; border:0.3px solid #333; border-right:none;">' . count($AbsentStudent) . '</td>
         <td  style="border:1px solid #333; font-size: 8px; border:0.3px solid #333; border-right:none;">' . count($NotUploadedStudentResult) . '</td>
         <td  style="border:1px solid #333; font-size: 8px; border:0.3px solid #333; border-right:none;">' . $totalStudent . '</td>
      </tr>
   </tbody>
   ';
$html .= '
   </tbody>
</table>
';

   
$courseName = $this->Comman->findclass($course_id)['title'];
$sectionYear = $this->Comman->findsecti($section_id)['title'];
$pdf->writeHTMLCell(0, 0, '', '', utf8_encode($html), 0, 1, 0, true, '', true);
//$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output($courseName . ' ' . $sectionYear . ' ' . 'StudentResult.pdf');

exit;
