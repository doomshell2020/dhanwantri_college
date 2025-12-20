<?php 
class xtcpdf extends TCPDF {
 
}


 $subject=$this->Comman->findexamsubjectsresult($students['id'],$students['class']['id'],$students['section']['id'],$students['acedmicyear']); 
 
  $countexamcategory=$this->Comman->findexamsubjectsresult2($students['id'],$students['class']['id'],$students['section']['id'],$students['acedmicyear']); 

 foreach($countexamcategory as $h=>$rt){
 
 $ecategory=$rt['exam']['e_type_id'];
 
  $findcatname=$this->Comman->findsubjectstotalssname($ecategory,'1');
  
  foreach($findcatname as $jj=>$hhh){

 $arr[$ecategory]=$hhh['id'];
 
 }
 }




   $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();


$pdf->SetFont('', '', 9, '', 'false');

$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html.='</head>
<body>
<table width="100%">

<tr>
<td colspan="3" style="text-align:center"><img src="'.SITE_URL.'images/sanskarlogoresult.png" alt="" border="0" style="display:block;"></td></tr>

<tr>
<td width="20%"><img src="'.SITE_URL.'images/cbse-logo.png" alt="" border="0" style="display:block;"></td>

<td width="60%" style="text-align:center; font-size:10px; color: #000; font-style:italic;"><p style="text-transform:capitalize;"> 
Affilitaion no : 1730236 <br>Vishwamitra marg , Hanuman Nagar Ext, sirsi road , jaipur-302012 <br>
E-mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com<br> Phone:0141-2246189, 2357844 | fax:2245602
</p></td>



<td style="text-align:right" width="20%"><img src="'.SITE_URL.'images/schoolaward.png" border="0" style="display:block;"></td>
</tr>

</table>';



if($students['photo']=="NOIMAGE.JPG"){

if($students['gender']=="Male"){ 

$html.='<img src="'.SITE_URL.'stu/male.png" width="750%"  border="0" style="display:block; text-align:center;">';

}else{


$html.='<img src="'.SITE_URL.'stu/female.png" width="750%"  border="0" style="display:block; text-align:center;">';

}


}else{

$html.='<img src="'.SITE_URL.'stu/'.$students['photo'].'" width="650%" border="0" style="display:block; text-align:center;">';


}

$fhosue=$this->Comman->findhouse($students['h_id']);


$html.='<br><h2 style="font-size:16px; font-weight:normal; text-align:center; margin:0; padding:0; line-height:10px;">Report Card</h2>
<p style="font-size:10px; font-weight:normal; text-align:center;line-height:5px;">(Issued by school as per directives of Central Board of Secondary Education, Delhi)</p>
<h3 style="font-size:14px; font-weight:normal; text-align:center; line-height:5px;">Class: '.$students['class']['title'].' - '.$students['section']['title'].'</h3>
<h4 style="font-size:12px; font-weight:normal; text-align:center;">Session: '.$students['acedmicyear'].'</h4>

<h5 style="font-size:15px; font-weight:500; text-align:left;">Student Profile:</h5>

<table width="100%" style="line-height:15px;">
<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Name Of Student:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.ucwords(strtolower($students['fname'])).'&nbsp;'.ucwords(strtolower($students['middlename'])).'&nbsp;'.ucwords(strtolower($students['lname'])).'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Class and Section:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.$students['class']['title'].' - '.$students['section']['title'].'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">House:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.ucwords(strtolower($fhosue['name'])).'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Date Of Birth:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.date('d-m-Y',strtotime($students['dob'])).'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Admission no:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.$students['formno'].'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Roll no:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.$students['enroll'].'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Mothers Name:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.ucwords(strtolower($students['mothername'])).'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Fathers Name/ Guardians Name:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.ucwords(strtolower($students['fathername'])).'</td>
</tr>


<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Residential Address :</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.ucwords(strtolower($students['address'])).'</td>
</tr>

<tr>
<td width="40%" style="font-weight:bold; font-size:12px; border:none;">Contact No.:</td>
<td width="60%" style="font-size:12px; border:1px solid #000;">'.$students['sms_mobile'].'</td>
</tr>

</table><br>
<h5 style="font-size:15px; font-weight:500; text-align:left;"><b>Attendance</b>:</h5>
<table width="100%" border="1"  style="line-height:20px">
<tr>
<td width="30%" style="font-size:10px;">Term 1</td>
<td width="30%" style="font-size:10px;">'.$total_attendence.' Out Of '.$totalworkingday.'</td>
<td width="30%" style="font-size:10px;">Upto '.date('d-m-Y').'</td>
</tr>


</table><br><br><br><br><br>


<h4 style="font-size:10px; font-weight:normal; color:#000"><b>Part-1:Scholastic Areas</b></h4>

<table width="100%" style="line-height:14px; text-align:center; font-size:8px;" border="1px">
<tr>

<td rowspan="2" width="21%" style="text-align:center"><div style="line-height:60px;"><b>Subjects</b></div></td>

<td width="79%"> <div style="line-height:13px; padding:0px;"><b>Term-1(100 Marks)</b></div></td>


<!--<td width="32%"><div style="line-height:25px;">Term-1(100 Marks)</div></td>-->



</tr>
<tr><td >
<table width="100%">

<tr>';

foreach($arr as $h=>$nm){

if($nm!='4'){
 $findcatname=$this->Comman->findsubjectstotalssname($nm,'1');
  foreach($findcatname as $jj=>$hhh){
 
 $tol +=$hhh['maxnumber'];
$html.='
<td style="border-right:1px solid #000;"><b><div>'.$hhh['name'].'</div>('.$hhh['maxnumber'].')</b></td>';

}
}


}






$html.='<td style="border-right:1px solid #000;"><b><div>Total</div>('.$tol.')</b></td>';



$findcatname=$this->Comman->findsubjectstotalssname('4','1');

  foreach($findcatname as $jj=>$hhh){
 
 $tol +=$hhh['maxnumber'];
$html.='
<td style="border-right:1px solid #000;" ><b><div>'.$hhh['name'].'</div>('.$hhh['maxnumber'].')</b></td>';

}





$html.='
<td width="14%" style="border-right:1px solid #000;"><b>Marks Obt. ('.$tol.')
(Total + Half
Yearly)</b></td>
<td style=""><b>Grade</b></td>
</tr>


</table>
</td></tr>';

if(isset($subject)){ 
	$rnh=0;

	$sum1=0;
	$s=0;
	$s1=0;
	$s2=0;
	$s3=0;
	$s4=0;
	$s5=0;
	$s6=0;
	$sum56=0;
	$g1=0;
	$totalcgpa=0;
	$totalcgpas=0;
	$cgpa=0;
	
$rts=0;
	
	foreach($subject as $key=>$value){
	$totalcgpas++;
	$summarkkk=0;
		$sum=0;
	
$html.='<tr style="line-height:20px">

<td style="text-align:left">'.$value['subject']['name'].'</td>';



$html.='<td><table width="100%">

<tr>';

foreach($arr as $h=>$nm){
if($nm!='4'){
$findexam=$this->Comman->findexam($nm,$students['class_id'],$students['acedmicyear']);
$maxmarks=$findexam['Examdetails'][0]['max_marks'];

$exams=$this->Comman->findexamdetail($findexam['id'],$value['subject']['id'],$students['id'],$students['class']['id'],$students['section']['id'],$students['acedmicyear']); $summarks=0; 
$summarks=0;

  foreach($exams as $key=>$iteam){
	$summarks+=$iteam['marks'];
	}
	
	//echo $summarks;
$summarkkk +=$summarks;

$html.='<td style="border-right:1px solid #000;">'.$summarks.'</td>';
}
}



$html.='<td  style="border-right:1px solid #000;">'.$summarkkk.'</td>';

$findexam=$this->Comman->findexam('4',$students['class_id'],$students['acedmicyear']);
$maxmarks=$findexam['Examdetails'][0]['max_marks'];

$exams=$this->Comman->findexamdetail($findexam['id'],$value['subject']['id'],$students['id'],$students['class']['id'],$students['section']['id'],$students['acedmicyear']); $summarks=0; 
$summarks=0;

  foreach($exams as $key=>$iteam){
	$summarks+=$iteam['marks'];
	}
	
	//echo $summarks;
$summarkkk +=$summarks;

$html.='<td style="border-right:1px solid #000;">'.$summarks.'</td>';


$html.='';







$html.='';




if($summarkkk){  $grade=$summarkkk*100/$tol; 


	  if ($grade > 90.9 && $grade < 101)
	$ss="A1";
	elseif ($grade == 90)
	$ss="A2";
elseif ($grade > 80.9  && $grade < 90)
	$ss="A2";
	elseif ($grade == 80)
	$ss= "B1";
elseif ($grade > 70.9  && $grade < 80)
	$ss= "B1";
	elseif ($grade == 70)
$ss= "B2";
elseif ($grade > 60.9 && $grade < 70)
	$ss="B2";
	elseif ($grade == 60)
$ss="C1";
elseif ($grade > 50.9  &&  $grade < 60)
	$ss="C1";
	elseif ($grade == 50)
	$ss="C2";
elseif ($grade > 40.9 && $grade < 50)
	$ss="C2";
elseif ($grade == 40)
	$ss= "D";	
elseif ($grade > 32.9 && $grade < 40)
	$ss= "D";
	elseif ($grade == 32)
	$ss="E1";
elseif ($grade > 20.9 && $grade < 32)
	$ss="E1";
	elseif ($grade == 20)
	$ss="E2";
elseif ($grade > 0 && $grade < 20)
	$ss="E2";
	
	

}
$rts +=$summarkkk;
$html.='<td style="border-right:1px solid #000;">'.$summarkkk.'</td>
<td style="">'.$ss.'</td>
</tr>


</table>
</td>


</tr>';
  
}

}
  $trttt= $totalcgpas*$tol; 
$html.='</table>
<h4 style="font-size:10px; font-weight:normal; color:#000"><b>Part-2:Co-Scholastic Activites</b><span style="font-size:8px; color:#333">( to be assessed on a 3 point scale)</span></h4>

<table width="100%" style="line-height:15px; text-align:center;" border="1px">
<tr><td colspan="4">Term-1</td>
</tr>
<tr>
<td width="70%">Activites</td>
<td width="30%">Grade</td>

</tr>
<tr style="text-align:left">
<td>Work Education(or pre-vocational education)</td>
<td>';
$findcoart=$this->Comman->findcoactivityresultpdf($students['class']['id'],$students['section']['id'],"Term1","WorkEducation",$students['id'],$students['acedmicyear']);


if($findcoart['marks']){   

 $gradess=number_format($findcoart['marks'],2); 
    
       if ($gradess=='3')
	$ss4="A";
	elseif ($gradess =='2')
	$ss4="B";

	elseif ($gradess =='1')
	$ss4="C";

	
	

}

$html.=$ss4.'</td>


</tr>



<tr style="text-align:left">
<td>Art Education(visual & performing Arts)</td>
<td>';


$findcoartss=$this->Comman->findcoactivityresultpdf($students['class']['id'],$students['section']['id'],"Term1","ArtEducation",$students['id'],$students['acedmicyear']);


if($findcoartss['marks']){   

 $gradessds=number_format($findcoartss['marks'],2); 
    
       if ($gradessds=='3')
	$ss4as="A";
	elseif ($gradessds =='2')
	$ss4as="B";

	elseif ($gradessds =='1')
	$ss4as="C";

	
	

}



$html.=$ss4as.'</td>


</tr>


<tr style="text-align:left">
<td>Health & Physical Education( Sports/Martial Arts/Yoga/NCC etc.)</td>
<td>';


$findcoartssjhs=$this->Comman->findcoactivityresultpdf($students['class']['id'],$students['section']['id'],"Term1","Health&Physical",$students['id'],$students['acedmicyear']);


if($findcoartssjhs['marks']){   

 $gradesklssds=number_format($findcoartssjhs['marks'],2); 
    
       if ($gradesklssds=='3')
	$ss4assk="A";
	elseif ($gradesklssds =='2')
	$ss4assk="B";

	elseif ($gradesklssds =='1')
	$ss4assk="C";

	
	

}



$html.=$ss4assk.'</td>


</tr>





</table>

<h4 style="font-size:10px; font-weight:normal; color:#000"><b>Part-3:Discipline</b><span style="font-size:8px; color:#333">( to be assessed on a 3 point scale)</span></h4>


<table width="100%" style="line-height:15px; text-align:center;" border="1px">
<tr><td colspan="4">Term-1</td>
</tr>
<tr>
<td width="70%">Activites</td>
<td width="30%">Grade</td>
</tr>
<tr style="text-align:left">
<td>Discipline</td>
<td>';


$findcoartssjdhsks=$this->Comman->findcoactivityresultpdf($students['class']['id'],$students['section']['id'],"Term1","Discipline",$students['id'],$students['acedmicyear']);

if($findcoartssjdhsks['marks']){   

 $gradesklsssgds=number_format($findcoartssjdhsks['marks'],2); 
    
       if ($gradesklsssgds=='3')
	$ss4assksf="A";
	elseif ($gradesklsssgds =='2')
	$ss4assksf="B";

	elseif ($gradesklsssgds =='1')
	$ss4assksf="C";

	
	

}



$html.=$ss4assksf.'</td>


</tr>

</table>

<br><br><br>
<table width="100%" border="1" style="line-height:12px;">
<tr>
<td rowspan="3" width="20%" style="line-height:20px;">Remarks</td>
<td width="80%"></td>
</tr>
<tr>

<td></td>
</tr>
<tr>

<td></td>
</tr></table>

<br><br>

<table width="100%" style="line-height:20px;">
<tr>

<td style="text-align:left">Date</td>
<td style="text-align:center">Class Teacher</td>
<td style="text-align:right">Principal</td>
</tr>


</table>
<br><br>
<table width="100%" border="1px" style="line-height:15px;">

<tr>
<td style="text-align:center"><b>Grading system</b></td>
</tr>
<tr>
<td>&nbsp;&nbsp;
<table>
<tr>
<td width="5%"></td>
<td style="text-align:center font-size:8px;" width="35%"><p>Scholastic Areas:Part1(Grading on 8 point Scale)</p>
<table width="100%" border="1" style="font-size:8px;">
<tr><td>GRADE</td><td>MARKS RANGE</td></tr>
<tr><td>A1</td><td>91-100</td></tr>
<tr><td>A2</td><td>81-90</td></tr>
<tr><td>B1</td><td>71-80</td></tr>
<tr><td>B2</td><td>61-70</td></tr>
<tr><td>C1</td><td>51-60</td></tr>
<tr><td>C2</td><td>41-50</td></tr>
<tr><td>D</td><td>33-40</td></tr>
<tr><td>E(Need Improvement)</td><td>32&Below</td></tr>
</table>
<div></div>
</td>

<td width="10%"></td>
<td style="text-align:center" width="45%">
<p><b>Co-Scholastic Areas:Part2</b></p>
<p style="font-size:8px; line-height:5px;"><b>Descipline:Part 3</b></p>
<p style="font-size:8px; line-height:5px;">(Grading on 3 point Scale)</p>

<table width="100%" border="1" style="font-size:8px;">
<tr>
<td>GRADE</td>
<td><div>GRADE</div>POINTS</td>
<td><div>GRADE</div>ACHIEVEMENTS</td>
</tr>

<tr>
<td>A</td>
<td>3</td>
<td>OUTSTANDING</td>
</tr>

<tr>
<td>B</td>
<td>2</td>
<td>Very Good</td>
</tr>

<tr>

<td>c</td>
<td>1</td>
<td>Fair</td>
</tr>


</table>

</td>

<td width="5%"></td>

</tr></table>




</td>

</tr>





</table>

</body>
</html>';
//echo $html; die;
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
