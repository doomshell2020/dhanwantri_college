<?php 
$mpdf = new \Mpdf\Mpdf();
$mpdf->setAutoFooterMargin = false;
$mpdf->autoLangToFont = true;


 
// set margins
$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title>';


$html.='</head>
<body >

<table width="100%" align="center">
<tr>
<td style="text-align:left" width="30%" >

<img src="'.SITE_URL.'images/cbse-logo.png" alt="" border="0" style="display:block; " height="80px" width="80px">
</td>

<td style="text-align:center;" width="40%" align="center">
<img src="'.SITE_URL.'images/logo.png" alt="" border="0" style="display:block;" width="200px" height="100px;">
</td>

<td style="text-align:right; line-height:60px;" width="30%" align="right">';
$filename2 = WWW_ROOT.'stu/'.$students['student']['enroll'].'.JPG';

if (file_exists($filename2)) {



$html.='<img src="'.SITE_URL.'stu/'.$students['student']['enroll'].'.JPG"  border="0" style="display:inline-block; height:80px; width:80px">';
}else{
if($students['gender']=="Male"){ 

$html.='<img src="'.SITE_URL.'stu/male.png"   border="0" style="display:inline-block; height:80px; width:80px">';

}else{


$html.='<img src="'.SITE_URL.'stu/female.png"  border="0" style="display:inline-block; height:80px; width:80px">';

}






}




$html.='</td>
</tr>
</table>
<table width="100%">
<tr>

<td width="100%" align="center" style="vertical-align:-100px;">
<p style="color:#000; text-align:center; font-size:10px;"> Affiliation No : 1730236<br>
Vishwamitra Marg , Hanuman Nagar Ext, Sirsi Road , Jaipur-302012<br>
<i>E-Mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com</i><br>
 <i>Phone:0141-2246189, 2357844 | Fax:2245602</i></p>
</td>

</tr>
<br>
<tr>
<td colspan="5" align="center">
<h2 style="font-weight:400; font-size:18px;">
ACADEMIC SESSION: '.$students['student']['acedmicyear'].'<br>
 REPORT CARD
</h2>
</td>
</tr>
</table>
<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%" style="border-top:1px solid #000; border-left:1px solid #000;  border-bottom:1px solid #000; border-right:1px solid #000;">
<table width="100%" style="font-size:11px;">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; ';
$studentn="Student's Name";

$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; Class / House
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase; border-bottom:1px solid #a8a8a8;  " width="30%">
&nbsp; '.$classt['title'].' - '.$sect['title'].' /'.ucwords(strtolower($fhosue['name'])).'
</td>

</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; ';
$studentn="Father's Name";
$html.=$studentn.' 
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; Date of Birth
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-bottom:1px solid #a8a8a8; " width="30%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8;" width="20%">
&nbsp; ';
$studentn="Mother's Name";
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8;" width="20%">
&nbsp; Admission No.
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase;  border-right:1px solid #000" width="30%">
&nbsp; '.$students['student']['enroll'].'
</td>
</tr>
</table>

</td>

</tr>

</table>

<br><br>
<table width="100%">
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">Scholastic Areas:</h2></td>
</tr>
</table>
<table width="100%" >';


$findroleexamtype=$this->Comman->findeexamtsype2s($students['sect_id'],$students['class_id']);
$html.='<tr style="font-size:12px;">
<td width="24%" style="border-top:1px solid #000; border-left:1px solid #000;  height:38px; line-height:38px;  border-right:1px solid #000;  font-weight:bold; " align="center">&nbsp; Subject Name</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Periodic<br>Test<br>(10)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Notebook<br>Submission<br>(5)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Subject<br>Enrichment<br>(5)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">First Term<br>Examination<br>(80)</td>
<td width="8%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Total<br>(100)</td>
<td width="8%" style="border-top:1px solid #000;height:38px; line-height:38px;  font-weight:bold; border-right:1px solid #000;" align="center">&nbsp;Grade</td>
</tr>';
 $subject=$this->Comman->find_examsubjectsnn($students['class_id']); 
   foreach($subject as $key=>$name){
	 
	
	 
	 if($students['student']['is_lc']=='Y'){
	
	 
		if($name['exprint']=='Sanskrit'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		if($students['class_id']=='9' && $students['sect_id']=='9'){
	
	 
			if($name['exprint']=='French'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		}
		
		
		
		if($students['class_id']=='9' && $students['sect_id']=='10'){
	
	 
			if($name['exprint']=='French'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		}  
		
		if($students['class_id']=='9' && $students['sect_id']=='11'){
	
	 
			if($name['exprint']=='Sanskrit'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
		if($students['class_id']=='9' && $students['sect_id']=='13'){
	
	 
			if($name['exprint']=='Sanskrit'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
			if($students['class_id']=='9' && $students['sect_id']=='14'){
	
	 
			if($name['exprint']=='Sanskrit'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		}
		
		
 
}
 foreach($subject as $key=>$name){
	 

	   
$html.='<tr style="font-size:12px;"> 
<td width="24%" style="border-top:1px solid #000;border-bottom:1px solid #000; border-left:1px solid 
#000; height:15px; line-height:15px; border-right:1px solid #000; " 
align="center">&nbsp; '.$name['exprint'].'</td>';

$ter=0;
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks1($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id']);
if($newmarks['marks']!=''){
			  if($er['etype_id']=="1"){ 
		
					
					if($newmarks['marks']!='0' && $newmarks['marks']!='A' ){ 
					
					$weighted=$newmarks['marks']/2;  
					
					$newmaj=round($weighted);
					
					 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">'.$newmaj.'</td>';
			 
		
			 $ter +=$newmaj;
			 
				
					
					 }else{
						
			
						 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
	
						  $ter +=$newmarks['marks'];
						  
					
						
						} 
		
		}else{
					
					 	 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			 
			
			 $ter +=$newmarks['marks'];
			 
		
			
		}
		
	}else{
			 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">--</td>';
		
		
	}

}

if($ter!=0){
	$grade=$ter*100/100; 


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
	
	

}else{
		$ss="E";
	
}
	

 $html.='<td  style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">'.$ter.'</td>
<td  style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">'.$ss.'</td>';
$html.='</tr>';

} 




$workingdaysid=$this->Comman->findcoscholsubjectt("Working Days",$students['class_id']);

$daysAttendedsid=$this->Comman->findcoscholsubjectt("Days Attended",$students['class_id']);

$wrkeduid=$this->Comman->findcoscholsubjectt("Work Education",$students['class_id']);
$artid=$this->Comman->findcoscholsubjectt("Art Education",$students['class_id']);

$actid=$this->Comman->findcoscholsubjectt("Discipline",$students['class_id']);


$phyid=$this->Comman->findcoscholsubjectt("Health & Physical Education",$students['class_id']);


$workingdaysid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$workingdaysid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$daysAttendeds=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$daysAttendedsid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$workeduids=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$wrkeduid['id'],$students['stud_id'],$students['student']['acedmicyear']);


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



if($workeduids['marks']){   

 
	$workeduidsr=$workeduids['marks'];
	

}else{
	
		$workeduidsr="-";
	
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

$html.='</table>
<br><br>
<table width="100%">

<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">Co-Scholastic Areas:</h2></td>
</tr>
</table>

<table width="100%" border="1px">
<tr>
<td width="50%">
<table width="100%" style="font-size:11px;">
<tr>
<td style="height:15px;  font-weight:bold; line-height:15px;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="70%">
&nbsp; Work Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%" align="center">
&nbsp; '.$workeduidsr.'
</td>



</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="70%">
&nbsp; Art Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%" align="center">
&nbsp; '.$artidsidr.'
</td>



</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="70%">
&nbsp; Health & Physical Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%" align="center">
&nbsp; '.$phyidsidr.'
</td>



</tr>


<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; " width="70%">
&nbsp; Discipline
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; " width="30%" align="center">
&nbsp; '.$actidedsr.'
</td>



</tr>

</table>
</td>
<td width="50%">
<table width="100%" cellpadding="5">
<tr>
<td  style="height:30px;line-height:15px;  font-weight:bold;  text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="70%">
&nbsp; Working Days
</td>

<td style="height:30px; line-height:15px; text-transform:uppercase;  border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; '.$WorkingDays.'
</td></tr>

<tr>
<td  style="height:30px; line-height:15px;  font-weight:bold;text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #000;" width="70%">
&nbsp; Days Attended
</td>

<td  style="height:30px;line-height:15px; text-transform:uppercase;  border-bottom:1px solid #000;" width="30%">
&nbsp; '.$daysAttended.'
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
<td width="33%" align="left" style=" font-weight:bold; font-size:9px; ">Marks-Range</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-size:9px; font-weight:bold; border-right:1px solid #000;">Grade</td>
<td width="2%"></td>
<td width="33%" align="left" style=" font-weight:bold; font-size:9px;">Co-Scholastic</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-weight:bold; font-size:9px;">Grade</td>
<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;91-100</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">A1</td>
<td width="2%"></td>
<td width="35%" align="left" rowspan="3" style="font-size:8px;">Outstanding</td>
<td width="1%" rowspan="3"></td>
<td width="12%" align="left" rowspan="3" style="font-size:8px;">A</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left"style="font-size:8px;">&nbsp;&nbsp;81-90</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">A2</td>
<td width="2%"></td>



<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;71-80</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">B1</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;61-70</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">B2</td>
<td width="2%"></td>
<td width="35%" align="left" rowspan="3" style="font-size:8px;">Very Good</td>
<td width="1%"></td>
<td width="12%" align="left" rowspan="3" style="font-size:8px;">B</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;51-60</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">C1</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;41-50</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">C2</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;33-40</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">D</td>
<td width="2%"></td>
<td width="35%" align="left" style="font-size:8px;">Fair</td>
<td width="1%"></td>
<td width="12%" align="left" style="font-size:8px;">C</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;32 & Below</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">E</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>


</table>
</td>
</tr>
</table>


<table width="100%" style="font-size:11px;">
<tr><br><br><br>
<td width="33.333%" align="left" style="line-height:15px; font-weight:bold;" >
<b>Date</b>
</td>

<td width="33.333%" align="center" style="line-height:15px; font-weight:bold;" >
<b>Class Teacher </b>
</td>

<td width="33.333%" align="right" style="line-height:15px; font-weight:bold;" >
<b>Principal</b> 
</td>
</tr>


</table>

 
</body>
</html>';


$mpdf->SetDefaultFont('freesans');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

?>
