<?php 
class xtcpdf extends TCPDF {
}
$this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);


// function percentage($marks, $maxnumber, $number)
// {
	
//     if ($marks != 0) {
//         $totalgrade = NULL;
//         $totalgrade = round($marks / $maxnumber * $number);
// 		// pr($totalgrade);die;
//     } else {
//         $totalgrade = "00";
//     }
//     return $totalgrade;
// }

function percentageOf( $marks, $maxnumber, $decimals = 2 ){
    return round( $marks / $maxnumber * 100, $decimals );
}


foreach($studentsj as $f=>$students){
	// pr($students);die;
// 	if(!empty($s_id) && $students['stud_id']!=$s_id){
// continue;
// 	}

if($students['marks']=='0' || $students['marks']=='0.00'){	
	//pr('if');die;
	continue;
	}

$pdf->AddPage();

$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);

$html='<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html.='</head>
<body style="font-family:"Times New Roman", Times, serif">
<br><br><br><br><br><br> <br><br> <br><br> 
<h2 style="font-weight:bold; font-size:16px; text-align:center;">
<span style="font-size:18px; display:inline-block;">Report Card</span><br>
 <span style="display:block; text-align:center; font-size:14px;">Class - '.$classt['title'].' - '.$sect['title'].'</span><br>   
 Academic Session '.$rolepresentyear.'
</h2>

<table width="100%" cellpadding="5"  style="font-size:10px; border: 1px solid #333;">
<tr>
<td width="15%">Student Name</td>
<td width="5%">:</td>
<td width="30%">'.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'</td>
<td width="15%">Class</td>
<td width="5%">:</td>
<td width="30%">'.$classt['title'].' - '.$sect['title'].'</td>
</tr>
<tr>
<td width="15%">Mother Name</td>
<td width="5%">:</td>
<td width="30%">'.ucwords(strtolower($students['student']['mothername'])).'</td>
<td width="15%">ADM. No.</td>
<td width="5%">:</td>
<td width="30%">'.$students['student']['enroll'].'</td>
</tr>
<tr>
<td width="15%">Father Name</td>
<td width="5%">:</td>
<td width="30%">'.ucwords(strtolower($students['student']['fathername'])).'</td>
<td width="15%">Date of Birth</td>
<td width="5%">:</td>
<td width="30%">'.date('d-m-Y',strtotime($students['student']['dob'])).'</td>
</tr>

<tr>
<td width="15%">House</td>
<td width="5%">:</td>
<td colspan="4" width="80%">'.$fhosue['name'].'</td>
</tr>
</table>
<br><br>
<table width="100%" cellpadding="3" align="center" style="font-size:12px;">
<tr>
<td style="font-size:12px; text-decoration:underline;">Academic Performance</td>
</tr>
</table>
<br><br>
<table width="100%" border=".5" cellpadding="3" align="center" style="font-size:8px;">
<tr>
<td rowspan="2" align="left" width="14%" style="font-weight:bold;">SUBJECT</td>
<td rowspan="2" align="center" width="7%" style="font-weight:bold;">UT 1<br>(25)</td>
<td rowspan="2" align="center" width="7%" style="font-weight:bold;">UT 2<br>(25)</td>
<td colspan="3" align="center" width="18%" style="font-weight:bold;">TERM I<br>(50)</td>
<td rowspan="2" align="center" width="7%" style="font-weight:bold;">TOTAL<br>(100)</td>
<td rowspan="2" align="center" width="7%" style="font-weight:bold;">UT 3<br>(25)</td>
<td colspan="3" align="center" width="18%" style="font-weight:bold;">FINAL<br>(50)</td>
<td rowspan="2" align="center" width="7%" style="font-weight:bold;">TOTAL<br>(100)</td>
<td rowspan="2" align="center" width="7%" style="font-weight:bold;">GRAND<br>TOTAL<br>(200)</td>
<td rowspan="2" align="center" width="8%" style="font-weight:bold;">OVERALL<br>(%)</td>
</tr>
<tr>
<td align="center" width="6%" style="font-weight:bold;">Th.</td>
<td align="center" width="6%" style="font-weight:bold;">Pr.</td>
<td align="center" width="6%" style="font-weight:bold;">Total</td>
<td align="center" width="6%" style="font-weight:bold;">Th.</td>
<td align="center" width="6%" style="font-weight:bold;">Pr.</td>
<td align="center" width="6%" style="font-weight:bold;">Total</td>
</tr>';

// pr($students);die;
$subject=$this->Comman->find_examsubjectsnnupdated($students['class_id'],$students['student']['enroll']); 
$nontheorysub = $this->Comman->find_nontheorysubject($students['class_id']);

// student Attendence 
$attendnc = $this->Comman->findstuattendetails($students['student']['id'],$students['class_id'],$students['sect_id'],$students['term']);
// pr($attendnc);die;

$subjectcnt=0;
$grandtotals=0;
$term1totalpercentage=0;
$term2totalpercentage=0;
$overalltotals=0;
$term1total=0;
$term2total=0;

foreach($subject as $key=>$name){
	$subjectcnt++;
$html .='<tr>
<td align="center" width="14%" style="text-align:left" >'.$name['exprint'].'</td>';

$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],1);
$ter=0; 
$totalthpr=0;
$submarkscnt =0;
foreach($findroleexamtype as $er){  
	$newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],1);
	
	if($newmarks['marks']!=''){
		// pr($ter);die;
		if($submarkscnt==2 || $submarkscnt==3){
			// pr('if');
			$html.='<td align="center" width="6%" >'.$newmarks['marks'].'</td>';

			$totalthpr +=$newmarks['marks'];
			
		}else{
			// pr('else');
			$html.='<td align="center" width="7%" >'.$newmarks['marks'].'</td>';
		}
		
		$ter +=$newmarks['marks'];
		
	}else{
		
		$html.='<td align="center" width="7%" >--</td>';
	}
	$submarkscnt++;
}
// pr($ter);die;
$term1total+=$ter;
$html .='<td align="center" width="6%" >'.$totalthpr.'</td>
<td align="center" width="7%" >'.$ter.'</td>';

$findroleexamtype2=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],2);
$ter2=0; 
$totalthpr2=0;
$submarkscnt2 =0;
foreach($findroleexamtype2 as $er){  	
	$newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],2);

	if($newmarks['marks']!=''){

		if($submarkscnt2==1 || $submarkscnt2==2){
			// pr('if');
			$html.='<td align="center" width="6%" >'.$newmarks['marks'].'</td>';

			$totalthpr2 +=$newmarks['marks'];
			
		}else{
			// pr('else');
			$html.='<td align="center" width="7%" >'.$newmarks['marks'].'</td>';
		}
	// $html.='<td  align="center" width="7%" >'.$newmarks['marks'].'</td>';

	$ter2 +=$newmarks['marks'];

	}else{

		$html.='<td width="7%" align="center">--</td>';
	}
	$submarkscnt2++;
}
$term2total+=$ter2;
// pr($)
$grandtotal = $ter+$ter2;
$getpercentage = percentageOf($grandtotal, 200, 100.0);

$html .='<td align="center" width="6%" >'.$totalthpr2.'</td>
<td align="center" width="7%" >'.$ter2.'</td>
<td align="center" width="7%" >'.$grandtotal.'</td>
<td align="center" width="8%" >'.$getpercentage.'</td>';
$html .='</tr>';
}
$grandtotals = $term1total+$term2total;
$term1totalpercentage = percentageOf($term1total, 500, 100.0);
$term2totalpercentage = percentageOf($term2total, 500, 100.0);
$overalltotals = percentageOf($grandtotals, 1000, 100.0);

$attendencecount = $this->Comman->getstudentattendence($students['stud_id']);
// pr($students['stud_id']);die;
$attendence = $attendencecount[0]['count(*)'];
$attendencepercentage = percentageOf($attendence, 100, 100.0);


$html .='<tr>
<td align="center" width="14%" style="text-align:left" >Total</td>
<td colspan="5" align="center" width="32%" ></td>

<td align="center" width="7%" >'.$term1total.'</td>
<td colspan="4" align="center" width="25%" ></td>

<td align="center" width="7%" >'.$term2total.'</td>
<td align="center" width="7%" >'.$grandtotals.'</td>
<td align="center" width="8%" >'.$overalltotals.'</td>
</tr>

<tr>
<td align="center" width="14%" style="text-align:left" >Percentage</td>
<td colspan="5" align="center" width="32%" ></td>

<td align="center" width="7%" >'.$term1totalpercentage.'</td>
<td colspan="4" align="center" width="25%" ></td>

<td align="center" width="7%" >'.$term2totalpercentage.'</td>
<td align="center" width="7%" >'.$overalltotals.'</td>
<td align="center" width="8%" >--</td>
</tr>
</table>
<br><br>
<table width="50%" align="center" border=".5" cellpadding="3" >
<tr>
<td width="50%" align="left">Attendance</td>
<td width="50%" align="left">'.$attendencepercentage.'%</td>
</tr>
</table>
<br><br>
<table width="100%" align="center" cellpadding="3" >
<tr>
<td width="100%" align="left">Remark: '.$attendnc['remarks'].'</td>
</tr>
</table>

</body>
</html>';
$pdf->SetFont('times', '', 9, '', 'false');
$pdf->WriteHTML($html, true, false, true, false, '');
}
ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
?>