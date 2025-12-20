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
<body style="font-family:"Times New Roman", Times, serif">

<table width="100%" align="center">
<tr>
<td style="text-align:left;line-height:60px;" width="30%" >


<img src="images/cbse-logo.png" alt="" border="0" style="display:block; width:80px; height:80px;">
</td>

<td style="text-align:center;" width="40%" align="center">
<img src="images/logo.png" alt="" border="0" style="display:block; width:200px;" height="100px;">

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

<td width="100%" align="center" style="vertical-align:-50px;">
<p style="color:#000; text-align:center; font-size:10px; line-height:12px;"> Affiliation No : 1730236<br>
Vishwamitra Marg , Hanuman Nagar Ext , Sirsi Road , Jaipur-302012<br>
<i>E-Mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com</i><br>
 <i>Phone:0141-2246189, 2357844 | Fax:2245602</i></p><br>
</td>

</tr>
<tr>
<td colspan="5" align="center" width="100%">

<h2 style="font-size:18px; font-weight:400; line-height:-10px;">ACADEMIC SESSION: '.$students['student']['acedmicyear'].'<br>
</h2>
<h2 style="font-size:18px; font-weight:400; line-height:3px;">
REPORT CARD</h2>
<p style="line-height:5px; font-size:11px;">(Issued by School as per directives of Central Board of Secondary Education, Delhi)</p>

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
<td width="100%" >
<table width="100%" style="font-size:11px;">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Student's Name";

$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Class / House
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase; " width="30%">
&nbsp; '.$classt['title'].' - '.$sect['title'].' /'.ucwords(strtolower($fhosue['name'])).'
</td>

</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name";
$html.=$studentn.' 
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold; " width="20%">
&nbsp; Date of Birth
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase; " width="30%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Mother's Name";
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold; " width="20%">
&nbsp; Admission No.
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase; " width="30%">
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


$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],$students['term']);
$findroleexamtype1=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],'1');
$html.='<tr style="font-size:10px;">
<td width="23%" style="border-top:1px solid #000; border-left:1px solid #000;  height:38px; line-height:38px;  border-right:1px solid #000;  font-weight:bold; " align="center">&nbsp; Subjects</td>
<td width="10%" style="border-top:1px solid #000;  font-weight:bold; height:20px;  line-height:15px; border-right:1px solid #000;" align="center">Term-1<br>(100)</td>
<td width="10%" style="border-top:1px solid #000;  font-weight:bold; height:20px;  line-height:15px; border-right:1px solid #000;" align="center">PT<br>(10)</td>
<td width="10%" style="border-top:1px solid #000;  font-weight:bold; height:20px;  line-height:15px; border-right:1px solid #000;" align="center">NoteBook<br>(5)</td>
<td width="10%" style="border-top:1px solid #000;  font-weight:bold; height:20px;  line-height:15px; border-right:1px solid #000;" align="center">SEA<br>(5)</td>
<td width="10%" style="border-top:1px solid #000;  font-weight:bold; height:20px;  line-height:15px; border-right:1px solid #000;" align="center">Annual<br>(80)</td>
<td width="10%" style="border-top:1px solid #000;  font-weight:bold;height:20px;  line-height:15px;  border-right:1px solid #000;" align="center">Term-2<br>(100)</td>
<td width="9%" style="border-top:1px solid #000;  font-weight:bold; height:20px;  line-height:12px; border-right:1px solid #000;" align="center">Grand Total<br>(100)</td>
<td width="8%" style="border-top:1px solid #000;height:38px; line-height:38px;  font-weight:bold; border-right:1px solid #000;" align="center">&nbsp;Grade</td>
</tr>';
 $subject=$this->Comman->find_examsubjectsnn($students['class_id']); 
   foreach($subject as $key=>$name){
	 
	
	 
	 if($students['student']['is_lc']=='Y'){
	
	 
		if($name['exprint']=='Sanskrit'){
			
			
			unset($subject[$key]);
			
			
		}
		
		if($name['exprint']=='French'){
			
			
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
$esctotal=0;
$cn=0;
 foreach($subject as $key=>$name){
	 
$cn++;
	   
	   if($students['stud_id']=='6245' || $students['stud_id']=='6228' || $students['stud_id']=='3275' || $students['stud_id']=='1846' || $students['stud_id']=='4056' || $students['stud_id']=='2351' ){ 
		   if($name['exprint']=='French'){
	$name['exprint']="Sanskrit /French";	   
	   }
	   }
$html.='<tr style="font-size:12px;"> 
<td width="23%" style="border-top:1px solid #000;border-bottom:1px solid #000; border-left:1px solid 
#000; height:15px; line-height:15px; border-right:1px solid #000; " 
align="center">&nbsp; '.$name['exprint'].'</td>';



$ter1=0;


foreach($findroleexamtype1 as $er1){  
		   
		   	
		  
		   
		   $newmarks1=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er1['etype_id'],$name['id'],'1');
		   
	if($students['stud_id']=='6245' || $students['stud_id']=='6228' || $students['stud_id']=='3275' || $students['stud_id']=='1846' || $students['stud_id']=='4056' || $students['stud_id']=='2351'){ 
		   if($name['id']=='23'){
 $newmarks1=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er1['etype_id'],'22','1');	   
	   }
	   }
		   
		   
if($newmarks1['marks']!=''){
			  if($er1['etype_id']=="1"){ 
		
					
					if($newmarks1['marks']!='0' && $newmarks1['marks']!='A' ){ 
					
					$weighted1=$newmarks1['marks']/2;  
					
					$newmaj1=round($weighted1);
					
			
		
			 $ter1 +=$newmaj1;
			 
				
					
					 }else{
						
			
					
	
						  $ter1 +=$newmarks1['marks'];
						  
					
						
						} 
		
		}else{
					
					 	
			 
			
			 $ter1 +=$newmarks1['marks'];
			 
		
			
		}
		
	}else{
			
		
		
	}

}







 $html.='<td width="10%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">'.$ter1.'</td>';
$ter=0;
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
			  if($er['etype_id']=="26"){ 
		
					
					if($newmarks['marks']!='0' && $newmarks['marks']!='A' ){ 
					
					$weighted=$newmarks['marks']/2;  
					
					$newmaj=round($weighted);
					
					 $html.='<td width="10%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">'.$newmaj.'</td>';
			 
		
			 $ter +=$newmaj;
			 
				
					
					 }else{
						
			
						 $html.='<td width="10%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
	
						  $ter +=$newmarks['marks'];
						  
					
						
						} 
		
		}else{
					
					 	 $html.='<td width="10%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			 
			
			 $ter +=$newmarks['marks'];
			 
		
			
		}
		
	}else{
			 $html.='<td width="10%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">--</td>';
		
		
	}

}




//if($ter1!=0){
	
	$tamoun=$ter+$ter1;
	$testtoal=$tamoun/2; 
	$esctotal +=round($testtoal);
//}

if($testtoal!=0){
	$grade=$testtoal*100/100; 


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
 align="center">'.$ter.'</td><td  style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">'.round($testtoal).'</td>
<td  style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">'.$ss.'</td>';
$html.='</tr>';

} 




$workingdaysidjk=$this->Comman->findcoscholsubjectt("Working Days",$students['class_id']);

$daysAttendedsid=$this->Comman->findcoscholsubjectt("Days Attended",$students['class_id']);

$wrkeduid=$this->Comman->findcoscholsubjectt("Work Education",$students['class_id']);
$artid=$this->Comman->findcoscholsubjectt("Art Education",$students['class_id']);

$actid=$this->Comman->findcoscholsubjectt("Discipline",$students['class_id']);


$phyid=$this->Comman->findcoscholsubjectt("Health & Physical Education",$students['class_id']);


$workingdaysid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$workingdaysidjk['id'],$students['stud_id'],$students['student']['acedmicyear']);

$workingdaysid2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$workingdaysidjk['id'],$students['stud_id'],$students['student']['acedmicyear']);


$daysAttendeds=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$daysAttendedsid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$daysAttendeds2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$daysAttendedsid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$workeduids=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$wrkeduid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$workeduids2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$wrkeduid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$artidsid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$artid['id'],$students['stud_id'],$students['student']['acedmicyear']);


$artidsid2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$artid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$actideds=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$actid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$actideds2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$actid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$phyidsid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$phyid['id'],$students['stud_id'],$students['student']['acedmicyear']);


$phyidsid2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$phyid['id'],$students['stud_id'],$students['student']['acedmicyear']);

if($workingdaysid['marks']){   

 
	$WorkingDays=$workingdaysid['marks'];
	

}else{
	
		$WorkingDays="-";
	
}

if($workingdaysid2['marks']){   

 
	$WorkingDays2s=$workingdaysid2['marks'];
	

}else{
	
		$WorkingDays2s="-";
	
}





if($daysAttendeds['marks']){   

 
	$daysAttended=$daysAttendeds['marks'];
	

}else{
	
		$daysAttended="-";
	
}

if($daysAttendeds2['marks']){   

 
	$daysAttended2=$daysAttendeds2['marks'];
	

}else{
	
		$daysAttended2="-";
	
}



if($workeduids['marks']){   

 
	$workeduidsr=$workeduids['marks'];
	

}else{
	
		$workeduidsr="-";
	
}

if($workeduids2['marks']){   

 
	$workeduidsr2=$workeduids2['marks'];
	

}else{
	
		$workeduidsr2="-";
	
}


if($artidsid['marks']){   

 
	$artidsidr=$artidsid['marks'];
	

}else{
	
		$artidsidr="-";
	
}


if($artidsid2['marks']){   

 
	$artidsidr2=$artidsid2['marks'];
	

}else{
	
		$artidsidr2="-";
	
}


if($actideds['marks']){   

 
	$actidedsr=$actideds['marks'];
	

}else{
	
		$actidedsr="-";
	
}

if($actideds2['marks']){   

 
	$actidedsr2=$actideds2['marks'];
	

}else{
	
		$actidedsr2="-";
	
}

if($phyidsid['marks']){   

 
	$phyidsidr=$phyidsid['marks'];
	

}else{
	
		$phyidsidr="-";
	
}

if($phyidsid2['marks']){   

 
	$phyidsidr2=$phyidsid2['marks'];
	

}else{
	
		$phyidsidr2="-";
	
}

$subjcn=$cn*100;
	$percent=$esctotal*100/$subjcn; 
	
	$tper=number_format((float)$percent, 2, '.', ''); 
	
	
	

if($esctotal!=0){
	$gradetotal=$esctotal*100/$subjcn; 


	  if ($gradetotal > 90 && $gradetotal < 101)
	$sstotal="A1";
	elseif ($gradetotal == 90)
	$sstotal="A2";
elseif ($gradetotal > 80  && $gradetotal < 90)
	$sstotal="A2";
	elseif ($gradetotal == 80)
	$sstotal= "B1";
elseif ($gradetotal > 70  && $gradetotal < 80)
	$sstotal= "B1";
	elseif ($gradetotal == 70)
$sstotal= "B2";
elseif ($gradetotal > 60 && $gradetotal < 70)
	$sstotal="B2";
	elseif ($gradetotal == 60)
$sstotal="C1";
elseif ($gradetotal > 50  &&  $gradetotal < 60)
	$sstotal="C1";
	elseif ($gradetotal == 50)
	$sstotal="C2";
elseif ($gradetotal > 40 && $gradetotal < 50)
	$sstotal="C2";
elseif ($gradetotal == 40)
	$sstotal= "D";	
elseif ($gradetotal > 32 && $gradetotal < 40)
	$sstotal= "D";
	elseif ($gradetotal == 32)
	$sstotal="E";
elseif ($gradetotal > 20 && $gradetotal < 32)
	$sstotal="E";
	elseif ($gradetotal == 20)
	$sstotal="E";
elseif ($gradetotal >= 0 && $gradetotal < 20)
	$sstotal="E";
	
	

}else{
		$sstotal="E";
	
}
$html.=' 
</table>
<br><br>
<table><tr>
<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px; font-size:12px;" align="left">&nbsp; Total Marks : '.$subjcn.'</td>

<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px;font-size:12px;" align="left">&nbsp; Marks Obtained : '.$esctotal.'</td>
<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px;font-size:12px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px;" align="left">&nbsp; Percentage : '.$tper.' </td>
<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; font-size:12px;height:15px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px;" align="left">&nbsp; Overall Grade : '.$sstotal.'</td>


</tr>

</table>
<br><br>
<table width="100%">

<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">Co-Scholastic Areas:</h2></td>
</tr>
</table><br>
<table width="100%">
<tr>
<td style="border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">


<table width="100%">

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="23%">
&nbsp; Areas
</td><td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%" align="center">
&nbsp;  Term-1 Grade
</td><td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%" align="center">
&nbsp; Term-2 Grade
</td><td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%">
&nbsp; Attendance
</td><td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="16%" align="center">
&nbsp; Term-1 
</td><td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #a8a8a8;" width="16%" align="center">
&nbsp; Term-2 
</td></tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="23%">
&nbsp; Work Education
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%" align="center">
&nbsp; '.$workeduidsr.'
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%" align="center">
&nbsp; '.$workeduidsr2.'
</td>
<td  style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%">
&nbsp; Working Days
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="16%" align="center">
&nbsp; '.$WorkingDays.'
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #a8a8a8;" width="16%" align="center">
&nbsp; '.$WorkingDays2s.'
</td>


</tr>


<tr>
<td style="height:15px;  font-weight:bold; line-height:15px;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="23%">
&nbsp; Art Education
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%" align="center">
&nbsp; '.$artidsidr.'
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%" align="center">
&nbsp; '.$artidsidr2.'
</td>

<td  style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="15%">
&nbsp; Days Attended
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase;   border-right:1px solid #a8a8a8;border-bottom:1px solid #a8a8a8;" width="16%" align="center">
&nbsp; '.$daysAttended.'
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase;  border-right:1px solid #000; border-bottom:1px solid #a8a8a8;" width="16%" align="center">
&nbsp; '.$daysAttended2.'
</td>

</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8; " width="23%">
&nbsp; Health & Physical Education
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8; " width="15%" align="center">&nbsp; '.$phyidsidr.'</td>
<td style="height:15px; line-height:15px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8; " width="15%" align="center">&nbsp; '.$phyidsidr2.'</td>



</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #a8a8a8; border-bottom:1px solid #000; " width="23%">
&nbsp; Discipline
</td>
<td style="height:15px; line-height:15px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #000; " width="15%" align="center">&nbsp; '.$actidedsr.'</td>
<td style="height:15px; line-height:15px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #000; " width="15%" align="center">&nbsp; '.$actidedsr2.'</td>

</tr>

</table>
</td>
</tr>
</table>
<br>
<br>
<table width="100%">
<tr>
<td width="60%" align="left" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">&nbsp; 

<table width="100%" cellspacing="7" style="font-size:11px;">
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"><b>Remarks:</b></td></tr>
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%" style=" border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%"  style="border-bottom:1px dotted #a8a8a8;"><b>Final Result:</b></td></tr>
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
</table><br>
<table width="100%" style="font-size:11px;">




<tr></tr>
<tr><br><br><br>
<td width="33.333%" align="left" style="line-height:2px; font-weight:bold;" >
<b>Date</b>
</td>
<td width="33.333%" align="center" style="line-height:2px; font-weight:bold;" >
<b>Class Teacher </b>
</td>

<td width="33.333%" align="right" style="line-height:2px; font-weight:bold;" >
<b>Principal</b> 
</td>
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
