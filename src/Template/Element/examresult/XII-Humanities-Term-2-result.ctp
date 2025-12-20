<?php 
class xtcpdf extends TCPDF {
 
}
$this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

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
<span style="font-size:18px; display:inline-block;">Yearly Report Card</span><br>   
 Academic Session '.$rolepresentyear.'<br>
 <span style="display:block; text-align:center; font-size:14px;">Class - '.$classt['title'].' - '.$sect['title'].'</span>


</h2>


<table width="100%" style="font-size:11px;">
<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Scholar No.";

$html.=$studentn.'
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp;'.$students['student']['enroll'].'
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Student's Name";

$html.=$studentn.'
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp;'.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Mother's Name";

$html.=$studentn.'
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp;'.ucwords(strtolower($students['student']['mothername'])).'
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name";

$html.=$studentn.'
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp;'.ucwords(strtolower($students['student']['fathername'])).'
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Date of Birth";

$html.=$studentn.'
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp;'.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="House";

$html.=$studentn.'
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp;'.$fhosue['name'].'
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Class / Section";

$html.=$studentn.'
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp;'.$classt['title'].' - '.$sect['title'].'
</td>


</tr>
</table>



<br><br>
<table width="100%">
<tr>
<td align="left" width="20%"  style="height:20px; line-height:20px;border-top:1px solid #000; border-left:1px solid #000;  border-right:1px solid #000;"><h2 style=" font-size:10px; font-weight:bold; ">&nbsp; Scholastic Areas:</h2></td>

<td align="center" width="80%" style=" border-top:1px solid #000; height:20px; line-height:20px;  font-weight:bold; border-right:1px solid #000;">
<table width="100%" border="1">
<tr>
<th colspan="2">Final Report Card</th>
</tr>

<tr>
<td width="25%">Term 1</td>
<td width="75%">Term 2</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="100%" style="border-bottom:1px solid #000;">';

$findroleexamtype1=$this->Comman->findexamtypesclass($students['class_id'],1);
// pr($findroleexamtype1);die;

$html.='<tr style="font-size:11px;">
<td width="20%" style="border-top:1px solid #000; border-left:1px solid #000;  height:32px; line-height:32px;  border-right:1px solid #000; text-align:left;  font-weight:bold; " align="left">&nbsp; Subject</td>';

$cbg=0;
foreach($findroleexamtype1 as $key=>$item){

// $html.='<td width="7%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">'.$item['examprint'].'<br>('.$item['maxnumber'].')</td>';
$cbg +=$item['maxnumber'];
}

$html.='
<td width="20%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">UT1<br>(50)</td>';

$findroleexamtype2=$this->Comman->findexamtypesclass($students['class_id'],2);
$cbg2=0;
foreach($findroleexamtype2 as $key=>$item){
$html.='<td width="15%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">'.$item['examprint'].'</td>';
$cbg2 +=$item['maxnumber'];
}


$html.='<td width="15%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">MO<br>(150)</td>
<td width="15%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold; border-right:1px solid #000; text-align:center;" align="center">Grade</td>
</tr>';
$subject=$this->Comman->find_examsubjectsnnupdated($students['class_id'],$students['student']['enroll']); 
$nontheorysub = $this->Comman->find_nontheorysubject($students['class_id']);

// student Attendence 
$attendnc = $this->Comman->findstuattendetails($students['student']['enroll'],$students['class_id'],$students['sect_id'],$students['term']);

$subjectcnt=0;
 foreach($subject as $key=>$name){
	$subjectcnt++;

$html.='<tr style="font-size:11px; border-bottom:1px solid #000;">
<td width="20%" style="border-top:1px solid #000; border-left:1px solid #000;  height:20px; line-height:20px;  border-right:1px solid #000; text-align:left; font-weight:bold;   " align="left">&nbsp;'.$name['exprint'].'</td>';

$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],1);
$ter=0; 
	   foreach($findroleexamtype as $er){  		   
		   
	 $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],1);
// if($newmarks['marks']!=''){

// $html.='<td width="7%" style="border-top:1px solid #000;  height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">'.$newmarks['marks'].'</td>';
$ter +=$newmarks['marks'];
// }else{
	// $html.='<td width="7%" style="border-top:1px solid #000;  height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">--</td>';
// }

}
$html.='<td width="20%" style="border-top:1px solid #000;  height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">'.$ter.'</td>';

$grades=0;
$ss1="";
if($ter!=0){
	$grades=$ter*100/100; 


	  if ($grades > 90 && $grades < 101)
	$ss1="A1";
	elseif ($grades == 90)
	$ss1="A2";
elseif ($grades > 80  && $grades < 90)
	$ss1="A2";
	elseif ($grades == 80)
	$ss1= "B1";
elseif ($grades > 70  && $grades < 80)
	$ss1= "B1";
	elseif ($grades == 70)
$ss1= "B2";
elseif ($grades > 60 && $grades < 70)
	$ss1="B2";
	elseif ($grades == 60)
$ss1="C1";
elseif ($grades > 50  &&  $grades < 60)
	$ss1="C1";
	elseif ($grades == 50)
	$ss1="C2";
elseif ($grades > 40 && $grades < 50)
	$ss1="C2";
elseif ($grades == 40)
	$ss1= "D";	
elseif ($grades > 32 && $grades < 40)
	$ss1= "D";
	elseif ($grades == 32)
	$ss1="E";
elseif ($grades > 20 && $grades < 32)
	$ss1="E";
	elseif ($grades == 20)
	$ss1="E";
elseif ($grades >= 0 && $grades < 20)
	$ss1="E";
	
	

}

// $html.='<td width="7%" style="border-top:1px solid #000;  height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">'.$ss1.'</td>';

$findroleexamtype2=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],2);


$ter2=0; 
	   foreach($findroleexamtype2 as $er){  	   
		   
	 $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],2);
	
if($newmarks['marks']!='' ){
$html.='<td width="15%" style="border-top:1px solid #000;  height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">'.$newmarks['marks'].'</td>';
$ter2 +=$newmarks['marks'];
}else{
    // pr($newmarks);
	$html.='<td width="15%" style="border-top:1px solid #000;  height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">--</td>';
}

}

$totalmarks=$ter+$ter2;

$html.='<td width="15%" style="border-top:1px solid #000;  height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">'.$totalmarks.'</td>';


$grade=0;
$ss="";
if($totalmarks!=0){
	$grade=$ter2*100/100; 


	  if ($grade > 90 && $grade < 101)
	$ss="A1";
	elseif ($grade == 90)
	$ss="A2";
elseif ($grade > 80  && $grade < 90)
	$ss="A2";
	elseif ($grade == 80)
	$ss= "B1";
elseif ($grade > 70  && $grade < 80)
	$ss= "B1";
	elseif ($grade == 70)
$ss= "B2";
elseif ($grade > 60 && $grade < 70)
	$ss="B2";
	elseif ($grade == 60)
$ss="C1";
elseif ($grade > 50  &&  $grade < 60)
	$ss="C1";
	elseif ($grade == 50)
	$ss="C2";
elseif ($grade > 40 && $grade < 50)
	$ss="C2";
elseif ($grade == 40)
	$ss= "D";	
elseif ($grade > 32 && $grade < 40)
	$ss= "D";
	elseif ($grade == 32)
	$ss="E";
elseif ($grade > 20 && $grade < 32)
	$ss="E";
	elseif ($grade == 20)
	$ss="E";
elseif ($grade >= 0 && $grade < 20)
	$ss="E";
	
	

}

$html.='<td width="15%" style="border-top:1px solid #000; height:20px; line-height:20px;    border-right:1px solid #000;  text-align:center;" align="center">'.$ss.'</td>';
$html.='</tr>';

} 

$html.='
</table>
<br><br>
<table width="100%">

<tr>
<td align="center" style="height:20px;"><h5 style=" text-transform:uppercase; font-size:10px; font-weight:bold; text-decoration:underline;">Co-Scholastic Areas: Term 1 [on a 3-Point(A-C) grading scale]</h5></td>
</tr>
</table>

<table width="100%">
<tr>
<td width="50%">
<table width="100%" style="font-size:11px;">
<tr>
<th style="height:16px;  font-weight:bold; line-height:16px;  border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;" width="70%">&nbsp; Grade</th>

<th style="height:16px;  font-weight:bold; line-height:16px;   border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; text-align:center;" width="30%">Grade</th>
</tr>';
//Co subject and marks 
$nonsub = 0;
foreach ($nontheorysub as $key => $name) {
        $gtotals1 = 0;
        $findroleexamtyp1s = $this->Comman->findexamtypesclass($students['class_id'], 1);
        foreach ($findroleexamtyp1s as $k => $item) {

            $newmarkss = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $item['id'], $name['id'], 1);
            if ($newmarkss['marks'] != '') {

                $gtotals1 += $newmarkss['marks'];
            } else {
            }
        }

			$findroleexamtyp1s=$this->Comman->findexamtypesclass($students['class_id'],2);
			foreach($findroleexamtyp1s as $k=>$item){

			$newmarkss=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$item['id'],$wrkeduid['id'],2);
			if($newmarkss['marks']!='' ){										
			$gtotals1 +=$newmarkss['marks'];								
			}else{
					
			}

			}

        $grades1 = 0;
        $sss = '';
		if($gtotals1!=0){
	
			$subjectotal=0;
			//echo $subjectotal;
			$grades1=$gtotals1*100/200;			
			if($grades1 > 80 && $grades1 < 101)
			$sss="A";
			elseif ($grades1 == 80)
			$sss= "B";
		elseif ($grades1 > 60  && $grades1 < 80)
			$sss= "B";
			elseif ($grades1 == 60)
		$sss="C";
		elseif ($grades1 > 40  &&  $grades1 < 60)
			$sss="C";
		elseif ($grades1 == 40)
			$sss= "D";	
		elseif ($grades1 < 40)
			$sss= "E";
		
		}
		$workeduidsr=$sss;
        $nonsub++;


		$html .= '<tr>
<td style="height:16px;  font-weight:bold; line-height:16px; border-left:1px solid #000;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="70%">
&nbsp;' . $name['exprint'] . '
</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="30%" align="center">
&nbsp;' . $workeduidsr . '
</td>
</tr>';
}


$html.='</table>
</td>
<td width="50%">

</td>
</tr>
</table>
<br>
<br>
<table>

<tr>
<td style="height:16px; line-height:16px; font-size:11px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; Attendence
</td>

<td style="height:16px; line-height:16px; font-size:11px;   text-transform:uppercase;" width="5%">:</td>';

//Attendence
if(!empty($attendnc['present'])){
    $html.='<td style="height:16px; line-height:16px; font-size:11px; text-transform:uppercase; text-align:left;  " width="30%">
    &nbsp;' . $attendnc['present'] . ' / ' . $attendnc['total'] . '
    </td></tr>
    </table>
    <br><br>';
}else{
    $html.='<td style="height:16px; line-height:16px; font-size:11px; text-transform:uppercase; text-align:left;  " width="30%">
    &nbsp;100 / Absent
    </td></tr>
    </table>
    <br><br>';
}

//Remarks
//  if(!empty($attendnc['remarks'])){
$html.='<table width="100%">
<tr>
<th width="30%" style="height:32px; font-weight:bold;  border-left:1px solid #000;  border-right:1px solid #000;  border-top:1px solid #000;  border-bottom:1px solid #000;">&nbsp; Class Teacher Remarks:</th>
<td width="2%" style="  border-top:1px solid #000;  border-bottom:1px solid #000;"> </td>
<td width="68%" style="height:32px; line-height:12px;   border-right:1px solid #000;  border-top:1px solid #000;  border-bottom:1px solid #000;">' . $attendnc['remarks'] . '. </td>
</tr>
</table></body>
</html>';
//  }else{
    // $html.='<table width="100%">
    // <tr>
    // <th width="30%" style="height:32px; font-weight:bold;  border-left:1px solid #000;  border-right:1px solid #000;  border-top:1px solid #000;  border-bottom:1px solid #000;">&nbsp; Class Teacher Remarks:</th>
    // <td width="2%" style="  border-top:1px solid #000;  border-bottom:1px solid #000;"> </td>
    // <td width="68%" style="height:32px; line-height:12px;   border-right:1px solid #000;  border-top:1px solid #000;  border-bottom:1px solid #000;">Regularly Contributes to Class Discussions. Expresses ideas Clearly, both Verbally and Through
    // Writing. Excellent Performance! Keep Up the Good Work. </td>
    // </tr>
    // </table></body>
    // </html>';
//  }
$pdf->SetFont('times', '', 9, '', 'false');
// pr($html);die;

$pdf->WriteHTML($html, true, false, true, false, '');

}
ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
?>
