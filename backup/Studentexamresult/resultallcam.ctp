<?php 
class xtcpdf extends TCPDF {
 
}




  $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

 $pdf->SetAutoPageBreak(TRUE, 0);


foreach($studentsj as $f=>$students){
	if(!empty($s_id) && $students['stud_id']!=$s_id){
		continue;
				}
$pdf->AddPage();
$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html.='</head>
<body>

<body>

<table width="100%" align="center">
<tr>
<td style="text-align:left; line-height:70px;" width="20%" >
<?php /*<img src="images/schoolaward.png" alt="" border="0" style="display:inline-block;">*/ ?>
<img src="'.SITE_URL.'images/cambridge-2.png" alt="" border="0" style="display:block; " height="60px" width="200px">
</td>

<td style="text-align:center" width="60%" align="center">
<img src="'.SITE_URL.'images/logo.png" alt="" border="0" style="display:inline-block; width:170px;" height="100px">

</td>

<td style="text-align:right; line-height:10px;" width="20%" align="right"><br><br><br>';
$filename2 = WWW_ROOT.'stu/CAM'.$students['student']['enroll'].'.JPG';

if (file_exists($filename2)) {



$html.='<img src="'.SITE_URL.'stu/CAM'.$students['student']['enroll'].'.JPG"  border="0" style="display:inline-block; height:80px; width:80px">';
}else{
if($students['gender']=="Male"){ 

$html.='<img src="'.SITE_URL.'stu/male.png"   border="0" style="display:inline-block; height:80px; width:80px">';

}else{


$html.='<img src="'.SITE_URL.'stu/female.png"  border="0" style="display:inline-block; height:80px; width:80px">';

}






}$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);

$html.='</td>
</tr>
<tr>
<td colspan="3" height="15px"></td>
</tr>
<tr>

<td colspan="3">
<p style="color:#000;  text-align:center; font-size:10px;"> Accredition No : IN 276<br>
Vishwamitra Marg , Hanuman Nagar Ext, Sirsi Road , Jaipur-302012<br>
<i>E-Mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com | www.sanskarjpr.com</i><br>
 <i>Phone:0141-2246189, 2357844 | Fax:2245602</i></p>
</td>
</tr>
</table>

<table width="100%">
<br>
<tr>
<td align="center" width="100%">
<h2 style="font-size:18px; font-weight:400; line-height:20px;">
Report Card <br>Mid Term</h2></td></tr>
<tr>
<td align="center" width="100%" >';
if($students['class_id']=='23') {
$html.='<h3 style="font-size:16px; font-weight:400; line-height:15px;">

Cambridge Lower Secondary-Stage 7</h3>';

} else if($students['class_id']=='24') {
	$html.='<h3 style="font-size:16px; font-weight:400; line-height:15px;">

Cambridge Lower Secondary-Stage 8</h3>';
}else if($students['class_id']=='28') {
	$html.='<h3 style="font-size:16px; font-weight:400; line-height:15px;">

Cambridge Lower Secondary-Stage 9</h3>';
}

	$html.='</td></tr>
<tr>
<td align="center" width="100%" >
<h3 style="font-size:14px; font-weight:400; line-height:15px;">
GRADE : '.$classt['title'].' - '.$sect['title'].'</h3></td></tr>
<tr>
<td align="center" width="100%">
<h4 style="font-size:13px; font-weight:400; line-height:15px;">
Session : '.$students['student']['acedmicyear'].'</h4>
</td>
</tr>
</table>
<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:13px; font-weight:bold; text-transform:uppercase;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%" style="border-top:1px solid #000; border-left:1px solid #000;  border-bottom:1px solid #000; border-right:1px solid #000;">
<table width="100%">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="25%">
&nbsp; Admission No.
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="25%">
&nbsp; '.$students['student']['enroll'].'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="25%">
&nbsp; ';
$studentn="Student's Name";
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase; border-bottom:1px solid #a8a8a8;  " width="25%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="25%">
&nbsp; ';
$studentn="Father's Name";
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="25%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="25%">
&nbsp; ';
$studentn="Mother's Name";
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-bottom:1px solid #a8a8a8; " width="25%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8;" width="25%">
&nbsp; Date of Birth
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8;" width="25%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8;" width="25%">
&nbsp; Grade/ House
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase;  border-right:1px solid #000" width="25%">
&nbsp; '.$classt['title'].' - '.$sect['title'].' /'.ucwords(strtolower($fhosue['name'])).'
</td>
</tr>
</table>

</td>

</tr>

</table>

<br><br>
<table width="100%">
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:13px; font-weight:bold; text-transform:uppercase;">Scholastic Areas:</h2></td>
</tr>
</table>
<table width="100%">';
$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],$students['term']);
$html.='<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000;  height:38px; line-height:38px;  border-right:1px solid #000;  font-weight:bold; " align="left">&nbsp; Subject Name</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Unit<br> Assessment 1<br>(10 marks)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Unit <br>Assessment 2<br>(10 marks)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Mid Term<br>(80 marks)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Total<br>(100 marks)</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold; border-right:1px solid #000;" align="center">Grade</td>
</tr>';

 $subject=$this->Comman->find_examsubjectsnn($students['class_id']); 
 
 $fgj=0;
 $bn=0;
 $cn=100;
 
 foreach($subject as $key=>$name){
	 
	 if($students['class_id']=='23'  && $name['exprint']=="Social Science"){

$html.='<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Social Science</td>';

}else{
	
	$html.='<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; '.$name['exprint'].'</td>';

	
}
$ter=0;
	   foreach($findroleexamtype as $er){ 
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
			  if($er['etype_id']=="1"){ 
		
					
					if($newmarks['marks']!='0' && $newmarks['marks']!='A' ){ 
					
					$weighted=$newmarks['marks']/2;  
					
					$newmaj=round($weighted);
					
$html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmaj.'</td>';
 $ter +=$newmaj;
  } else {
	  
	  $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
	    $ter +=$newmarks['marks'];
	    } 
		
		}else{
			 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			 $ter +=$newmarks['marks'];
			 
			 	}
		
	} else {
		
		$html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		}

}
if($ter!=0){
	$grade=$ter*100/100; 


	 if ($grade > 90 && $grade < 101)
	$ss="A*";
	elseif ($grade == 90)
	$ss="A";
elseif ($grade > 80  && $grade < 90)
	$ss="A";
	elseif ($grade == 80)
	$ss= "B";
elseif ($grade > 70  && $grade < 80)
	$ss= "B";
	elseif ($grade == 70)
$ss= "C";
elseif ($grade > 60 && $grade < 70)
	$ss="C";
	elseif ($grade == 60)
$ss="D";
elseif ($grade > 50  &&  $grade < 60)
	$ss="D";
	
	elseif ($grade == 50)
	$ss="E";
elseif ($grade > 40 && $grade < 50)
	$ss="E";
elseif ($grade == 40)
	$ss= "F";	
elseif ($grade > 30 && $grade < 40)
	$ss= "F";
	else
	$ss="U";
	
	

} else {
	$ss="U";
	
}

 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$ter.'</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$ss.'</td>';

$html.='</tr>';
$fgj+=$ter;
$bn+=$cn;

} 

if($fgj!=0){
	$grade1=$fgj*100/$bn; 


	if ($grade1 > 90 && $grade1 < 101)
	$ss1="A*";
	elseif ($grade1 == 90)
	$ss1="A";
elseif ($grade1 > 80  && $grade1 < 90)
	$ss1="A";
	elseif ($grade1 == 80)
	$ss1= "B";
elseif ($grade1 > 70  && $grade1 < 80)
	$ss1= "B";
	elseif ($grade1 == 70)
$ss1= "C";
elseif ($grade1 > 60 && $grade1 < 70)
	$ss1="C";
	elseif ($grade1 == 60)
$ss1="D";
elseif ($grade1 > 50  &&  $grade1 < 60)
	$ss1="D";
	
	elseif ($grade1 == 50)
	$ss1="E";
elseif ($grade1 > 40 && $grade1 < 50)
	$ss1="E";
elseif ($grade1 == 40)
	$ss1= "F";	
elseif ($grade1 > 30 && $grade1 < 40)
	$ss1= "F";
	else
	$ss1="U";
	
	
	
	
	
	

} else {
	$ss1="U";
}


$html.='<tr>
<td width="73%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; " align="left">&nbsp; Overall Marks & Grade</td>

<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; border-bottom:1px solid #000; line-height:15px;" align="center">'.$fgj.'</td>

<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; border-bottom:1px solid #000; line-height:15px;" align="center">'.$ss1.'</td>
</tr>
</table>
<br><br>
<table width="100%">

<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:13px; font-weight:bold; text-transform:uppercase;">Co-Scholastic Areas:</h2></td>
</tr>
</table>';




$workingdaysid=$this->Comman->findcoscholsubjectt("Working Days",$students['class_id']);

$daysAttendedsid=$this->Comman->findcoscholsubjectt("Days Attended",$students['class_id']);

$artid=$this->Comman->findcoscholsubjectt("Art Education",$students['class_id']);

$actid=$this->Comman->findcoscholsubjectt("Activity(Dance/Music/Yoga)",$students['class_id']);


$phyid=$this->Comman->findcoscholsubjectt("Physical Education",$students['class_id']);


$workingdaysid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$workingdaysid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$daysAttendeds=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$daysAttendedsid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$artidsid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$artid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$actideds=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$actid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$phyidsid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$phyid['id'],$students['stud_id'],$students['student']['acedmicyear']);


if($workingdaysid['marks']){   

 
	$WorkingDays=$workingdaysid['marks'];
	

}else{
	
		$WorkingDays="-";
	
}





if($daysAttendeds['marks']){   

 
	$daysAttended=$daysAttendeds['marks'];
	

}else{
	
		$daysAttended="-";
	
}



if($artidsid['marks']){   

 
	$artidsidr=$artidsid['marks'];
	

}else{
	
		$artidsidr="-";
	
}


if($actideds['marks']){   

 
	$actidedsr=$actideds['marks'];
	

}else{
	
		$actidedsr="-";
	
}

if($phyidsid['marks']){   

 
	$phyidsidr=$phyidsid['marks'];
	

}else{
	
		$phyidsidr="-";
	
}
$html.='<table width="100%">
<tr>
<td style="border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">


<table width="100%">



<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; Art Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; '.$artidsidr.'
</td>
<td  style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; Working Days
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;  border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; '.$WorkingDays.'
</td>


</tr>


<tr>
<td style="height:15px;  font-weight:bold; line-height:15px;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; Activity (Dance/Music/Yoga/Drama)
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; '.$actidedsr.'
</td>

<td  style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; Days Attended
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;   border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; '.$daysAttended.'
</td>

</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #000; " width="30%">
&nbsp; Physical Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #000; " width="20%">
&nbsp; '.$phyidsidr.'
</td>



</tr>






</table>
</td>
</tr>
</table>
<br><br>

<table width="100%">
<tr>
<td width="60%" align="left" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">&nbsp; 

<table width="100%" cellspacing="7" style="font-size:11px;">
<tr><td width="100%"><b>Remarks:</b></td></tr>
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%" style=" border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%"></td></tr>

</table>
  </td>

<td width="40%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">
<table width="100%">
<tr>
<td width="1%"></td>
<td width="31%" align="left" style=" font-weight:bold; font-size:9px; ">Marks-Range</td>
<td width="1%"></td>
<td width="16%" align="left" style=" font-size:9px; font-weight:bold; border-right:1px solid #000;">Grade</td>
<td width="2%"></td>
<td width="33%" align="left" style=" font-weight:bold; font-size:9px;">Co-Scholastic</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-weight:bold; font-size:9px;">Grade</td>
<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="31%" align="left" style="font-size:8px;">&nbsp;&nbsp;91-100</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000; font-size:8px;">A*</td>
<td width="2%"></td>
<td width="35%" align="left" rowspan="3" style="font-size:8px;">Very Good</td>
<td width="1%" rowspan="3"></td>
<td width="12%" align="left" rowspan="3" style="font-size:8px;">A</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="31%" align="left"style="font-size:8px;">&nbsp;&nbsp;81-90</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000; font-size:8px;">A</td>
<td width="2%"></td>



<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="31%" align="left" style="font-size:8px;">&nbsp;&nbsp;71-80</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000; font-size:8px;">B</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="31%" align="left" style="font-size:8px;">&nbsp;&nbsp;61-70</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000;font-size:8px;">C</td>
<td width="2%"></td>
<td width="35%" align="left" rowspan="3" style="font-size:8px;">Good</td>
<td width="1%"></td>
<td width="12%" align="left" rowspan="3" style="font-size:8px;">B</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="31%" align="left" style="font-size:8px;">&nbsp;&nbsp;51-60</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000;font-size:8px;">D</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="31%" align="left" style="font-size:8px;">&nbsp;&nbsp;41-50</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000; font-size:8px;">E</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="31%" align="left" style="font-size:8px;">&nbsp;&nbsp;31-40</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000;font-size:8px;">F</td>
<td width="2%"></td>
<td width="35%" align="left" style="font-size:8px;">Fair</td>
<td width="1%"></td>
<td width="12%" align="left" style="font-size:8px;">C</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="31%" align="left" style="font-size:8px;">&nbsp;&nbsp;30 & Below</td>
<td width="1%"></td>
<td width="16%" align="left" style="border-right:1px solid #000; font-size:8px;">U</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>


</table>
</td>
</tr>
</table>
<br><br>




<table width="100%" style="font-size:11px;">
<tr><br>
<td width="25%" align="left" style="line-height:15px; font-weight:bold;" >
Date
</td>

<td width="25%" align="center" style="line-height:15px; font-weight:bold;" >
Class Teacher 
</td>

<td width="25%" align="center" style="line-height:15px; font-weight:bold;" >
Coordinator
</td>

<td width="25%" align="right" style="line-height:15px; font-weight:bold;" >
Principal
</td>
</tr>


</table>
 
 
</body>
</html>';
//echo $html; die;
$pdf->SetFont('times', '', 10, '', 'false');
$pdf->WriteHTML($html, true, false, true, false, '');


}

ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
?>
