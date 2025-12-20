<?php
class xtcpdf extends TCPDF
{
}
$this->set('pdf', new TCPDF('L', 'mm', 'A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// Grade convert 
function gradecalculation($marks, $maxnumber, $number)
{
	if ($marks != 0) {

		$totalgrade = NULL;
		$totalgrade = round($marks / $maxnumber * $number);

		if ($totalgrade > 90 && $totalgrade < 101)
			$ss1 = "A1";
		elseif ($totalgrade == 90)
			$ss1 = "A2";
		elseif ($totalgrade > 80  && $totalgrade < 90)
			$ss1 = "A2";
		elseif ($totalgrade == 80)
			$ss1 = "B1";
		elseif ($totalgrade > 70  && $totalgrade < 80)
			$ss1 = "B1";
		elseif ($totalgrade == 70)
			$ss1 = "B2";
		elseif ($totalgrade > 60 && $totalgrade < 70)
			$ss1 = "B2";
		elseif ($totalgrade == 60)
			$ss1 = "C1";
		elseif ($totalgrade > 50  &&  $totalgrade < 60)
			$ss1 = "C1";
		elseif ($totalgrade == 50)
			$ss1 = "C2";
		elseif ($totalgrade > 40 && $totalgrade < 50)
			$ss1 = "C2";
		elseif ($totalgrade == 40)
			$ss1 = "D";
		elseif ($totalgrade > 32 && $totalgrade < 40)
			$ss1 = "D";
		elseif ($totalgrade == 32)
			$ss1 = "E";
		elseif ($totalgrade > 20 && $totalgrade < 32)
			$ss1 = "E";
		elseif ($totalgrade == 20)
			$ss1 = "E";
		elseif ($totalgrade >= 0 && $totalgrade < 20)
			$ss1 = "E";
	} else {
		$ss1 = "N/A";
	}
	return $ss1;
}


// pr($studentsj);die;
foreach ($studentsj as $f => $students) {
	// pr($students);die;
	// if (!empty($s_id) && $students['stud_id'] != $s_id) {
	// 	continue;
	// }

	if($students['marks']=='0' || $students['marks']=='0.00'){	
		//pr('if');die;
		continue;
		}

	$pdf->AddPage();

	$fhosue = $this->Comman->findhouse($students['student']['h_id']);
	$classt = $this->Comman->findclass($students['class_id']);
	$sect = $this->Comman->findsectionsss($students['sect_id']);


	$html = '<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


	$html .= '</head>
<body style="font-family:"Times New Roman", Times, serif">

<br><br><br><br><br><br> <br><br> <br><br> 

<h2 style="font-weight:bold; font-size:16px; text-align:center;">
<span style="font-size:18px; display:inline-block;">Report Card</span><br>   
 Academic Session ' . $rolepresentyear . '<br>
 <span style="display:block; text-align:center; font-size:14px;">Class - ' . $classt['title'] . ' - ' . $sect['title'] . '</span>


</h2>


<table width="100%" style="font-size:11px;">
<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
	$studentn = "Scholar No.";

	$html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . $students['student']['enroll'] . '
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
	$studentn = "Student's Name";

	$html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['fname'])) . '&nbsp;' . ucwords(strtolower($students['student']['middlename'])) . '&nbsp;' . ucwords(strtolower($students['student']['lname'])) . '
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
	$studentn = "Mother's Name";

	$html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['mothername'])) . '
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
	$studentn = "Father's Name";

	$html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['fathername'])) . '
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
	$studentn = "Date of Birth";

	$html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . date('d-m-Y', strtotime($students['student']['dob'])) . '
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
	$studentn = "House";

	$html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . $fhosue['name'] . '
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
	$studentn = "Class / Section";

	$html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . $classt['title'] . ' - ' . $sect['title'] . '
</td>

</tr>
</table>

<br><br>
<table width="100%" border=".5" cellpadding="3" align="center">';

$findroleexamtype1 = $this->Comman->findexamtypesclass($students['class_id'], 1);

$html .= '<tr>
<td align="left" width="16%" style="font-weight:bold;">Scholastic Areas</td>
<td colspan="6" align="center" width="42%" style="font-weight:bold;">Term-1 (100 Marks)</td>
<td colspan="6" align="center" width="42%" style="font-weight:bold;">Term-2 (100 Marks)</td>
</tr>
<tr>
  <th style="font-weight:bold" width="16%" align="left">Name of Subject</th>';


	$cbg = 0;
	foreach ($findroleexamtype1 as $key => $item) {
		$html .= '<th style="font-weight:bold" width="7%">' . $item['examprint'] . '<br>(' . $item['maxnumber'] . ')</th>';
		$cbg += $item['maxnumber'];
	}


	$html .= '<th style="font-weight:bold" width="8%">Marks Obtained<br>(100)</th>
  			 <th style="font-weight:bold" width="6%">Grade</th>';

	$findroleexamtype2 = $this->Comman->findexamtypesclass($students['class_id'], 2);
	$cbg2 = 0;
	foreach ($findroleexamtype2 as $key => $item) {

		$html .= '<th style="font-weight:bold" width="7%">' . $item['examprint'] . '<br>(' . $item['maxnumber'] . ')</th>';
	}

	$html .= '<th style="font-weight:bold" width="8%">Marks Obtained<br>(100)</th>
				<th style="font-weight:bold" width="6%">Grade</th>
				</tr>';

	$subject = $this->Comman->find_examsubjectsnnupdated($students['class_id']);
	$nontheorysub = $this->Comman->find_nontheorysubject($students['class_id']);
	// pr($nontheorysub);die;

	// student Attendence 
	$attendnc = $this->Comman->findstuattendetails($students['student']['id'], $students['class_id'], $students['sect_id'], $students['term']);

	$subjectcnt = 0;
	foreach ($subject as $key => $name) {
		$subjectcnt++;

		$html .= '<tr>
  		<th align="left" style="font-weight:bold">' . $name['exprint'] . '</th>';
		$findroleexamtype = $this->Comman->findeexamtsype3s($students['sect_id'], $students['class_id'], 1);
		$ter = 0;
		foreach ($findroleexamtype as $er) {

			$newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $er['etype_id'], $name['id'], 1);
			//   pr($newmarks);die;
			if ($newmarks['marks'] != '') {

				$html .= '<th align="center">' . $newmarks['marks'] . '</th>';
				$ter += $newmarks['marks'];
			} else {
				$html .= '<th align="center">--</th>';
			}
		}
		$html .= '<th align="center">' . round($ter) . '</th>';

		$getgrade = gradecalculation($ter, 100, 100.0);

		$html .= '<th style="font-weight:bold" align="center">' . $getgrade . '</th>';

		$findroleexamtype2 = $this->Comman->findeexamtsype3s($students['sect_id'], $students['class_id'], 2);


		$ter2 = 0;
		foreach ($findroleexamtype2 as $er) {


			$newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $er['etype_id'], $name['id'], 2);


			if ($newmarks['marks'] != '') {

				$html .= '<th align="center">' . $newmarks['marks'] . '</th>';

				$ter2 += $newmarks['marks'];
			} else {
				$html .= '<th align="center">--</th>';
			}
		}

		$html .= '<th align="center">' . round($ter2) . '</th>';

		$getgrade = gradecalculation($ter2, 100, 100.0);
		$html .= '<td style="font-weight:bold" align="center">' . $getgrade . '</td>';
		$html .= '</tr>';
	}

$html .= '
</table>

<br><br>
<table width="100%" align="center" cellpadding="3" >
<tr>
<td align="center" style=" text-transform:uppercase; font-size:10px; font-weight:bold; text-decoration:underline;">Co-Scholastic Areas: Term 1 [on a 3-Point(A-C) grading scale]</td>
</tr>
</table>
<br>
<br>

<table width="50%" border=".5" cellpadding="3">';

//Co subject and marks 
$nonsub = 0;
foreach ($nontheorysub as $key => $name) {
        $gtotals1 = 0;
        $findroleexamtyp1s = $this->Comman->findexamtypesclass($students['class_id'], 1);
        foreach ($findroleexamtyp1s as $k => $item) {
            $newmarkss = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $item['id'], $name['id'], 1);
            if ($newmarkss['marks'] != '') {
				$gtotals1 = $newmarkss['marks'];
            } else {
				$gtotals1=0;
            }
        }
		// pr($gtotals1);

			$findroleexamtyp1s=$this->Comman->findexamtypesclass($students['class_id'],2);
			foreach($findroleexamtyp1s as $k=>$item){
			$newmarkss=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$item['id'],$name['id'],2);
			if($newmarkss['marks']!='' ){										
			$gtotals2 =$newmarkss['marks'];	
		}else{
			$gtotals1=0;
		}
		
	}
	$to=$gtotals1+$gtotals2;				
	$getgrade = gradecalculation($to, 200, 100.0);

$html.='<tr>
<td colspan="2" width="100%" style="text-align:right; font-weight:bold;">Grade</td>
</tr>
<tr>
<td width="80%" style="text-align:left; font-weight:bold">' . $name['exprint'] . '</td>
<td width="20%" style="text-align:right; font-weight:bold">' . $getgrade . '</td>
</tr>';
}


$html.='</table>
<br>
<br>
<table width="100%" style=" font-size:12px;">
<tr>';
//Attendence
if(!empty($attendnc['present'])){
    $html.='<td width="25%" style="font-weight:700;">Attendance</td>
	<td width="5%">:</td>
	<td width="70%" style="font-weight:bold;">
    &nbsp;' . $attendnc['present'] . ' / ' . $attendnc['total'] . '
    </td></tr>';
}else{
    $html.='<td width="25%" style="font-weight:bold;">Attendance</td>
	<td width="5%">:</td>
	<td width="70%">
    &nbsp;100 / Absent
    </td></tr>';
}

$html.='<tr>
<td width="25%" style="font-weight:bold;">Class Teachers Remarks</td>
<td width="5%">:</td>
<td width="70%" style="font-weight:bold;">' . $attendnc['remarks'] . ' and promoted to Next Class</td>
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
