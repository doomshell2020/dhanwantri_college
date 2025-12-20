<?php 
class xtcpdf extends TCPDF {
 
}




  $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);



//pr($studentsj); die;
foreach($studentsj as $f=>$students){
	
	if(!empty($s_id) && $students['stud_id']!=$s_id){
	continue;
			}
			//pr($students); die;
$pdf->AddPage();

$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html.='</head>


<body>

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


$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);

$html.='</td>
</tr>
</table>
<table width="100%">
<tr>

<td width="100%" align="center" style="vertical-align:-50px;">
<p style="color:#000; text-align:center; font-size:10px; line-height:12px;"> Affiliation No : 1730236<br>
Vishwamitra Marg , Hanuman Nagar Ext, Sirsi Road , Jaipur-302012<br>
<i>E-Mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com</i><br>
 <i>Phone:0141-2246189, 2357844 | Fax:2245602</i></p><br>
</td>

</tr>
<tr>
<td colspan="5" align="center" width="100%">
<h2 style="font-size:18px; font-weight:400; line-height:-10px;">
Report Card</h2>
<p style="line-height:5px; font-size:11px;">(Issued by School as per directives of Central Board of Secondary Education, Delhi)</p>
<h3 style="font-size:14px; font-weight:400; line-height:5px;">
Class :  '.$classt['title'].' - '.$sect['title'].'</h3>
<h4 style="font-size:13px; font-weight:400; line-height:5px;">
Session : '.$students['student']['acedmicyear'].'</h4>
</td>
</tr>
</table>
<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size:14px; font-weight:bold;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%" >
<table width="100%" cellspacing="2px" style="font-size:11px;">
<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Name of Student:
</td>

<td style="height:10px; line-height:12px;text-transform:uppercase;border:1px solid #000;" width="80%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Class:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.$classt['title'].' - '.$sect['title'].'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; House:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.ucwords(strtolower($fhosue['name'])).'
</td>



</tr>
<tr>
<td style="height:10px; line-height:12px; text-transform:capetalize;  font-weight:bold;" width="20%">
&nbsp; Date of Birth:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Admission No:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.$students['student']['enroll'].'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Mother's Name:";
$html.=$studentn.'
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name:";
$html.=$studentn.'
</td>

<td style="height:10px; line-height:12px;text-transform:uppercase;border:1px solid #000;" width="80%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>



</tr>

</table>

</td>

</tr>

</table>
<br><br>
<table width="100%">
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size:14px; font-weight:bold; line-height:30px;">Scholastic Areas:</h2></td>
</tr>
</table>
<table width="100%">
<tr style="font-size:13px; text-transform:capitalize;">
<td width="10%" style="border-top:1px solid #000; border-left:1px solid #000;  height:40px; line-height:40px;  border-right:1px solid #000;  font-weight:bold; " align="center" rowspan="2">&nbsp; S.No.</td>
<td width="30%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000; height:40px; line-height:40px;" align="center" rowspan="2">&nbsp; Subject</td>

<td width="60%" style="border-top:1px solid #000; font-size:14px;  font-weight:bold;  border-right:1px solid #000;height:20px; line-height:20px;" align="center" colspan="2">&nbsp; Mid Term</td>



</tr>


<tr>

<td width="30%" style="border-top:1px solid #000;  font-weight:bold;  font-size:13px; border-right:1px solid #000; height:20px; line-height:20px;" align="center" colspan="2">&nbsp; Maximum Marks</td>
<td width="30%" style="border-top:1px solid #000;  font-weight:bold; font-size:12px;  border-right:1px solid #000;height:20px; line-height:20px;" align="center">&nbsp; Marks Obtained</td>

</tr>';



 $subject=$this->Comman->find_examsubjectsnn($students['class_id']); 
 

  foreach($subject as $key=>$name){

if($students['class_id']=='10' && $students['sect_id']!='14'){
	
	 
		if($name['id']=='26'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
		if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='25'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		

			
			
			
		
		
		if($students['class_id']=='11' && $students['sect_id']!='14'){
		if($name['id']=='34'){
			unset($subject[$key]);
			
			
		}
		
	}
		 if($students['class_id']=='11' && $students['sect_id']=='14'){
		if($name['id']=='33'){
			unset($subject[$key]);
			
			
		}
		 
		}
	 	 
	   }                                                                                                                                      

 $i=1;
 
 
 foreach($subject as $key=>$name){
	 if($students['class_id']=='11' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='34'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		}
		
		
	}
		if($students['class_id']=='10' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="Information Technology";
	}
	
	if($students['class_id']=='11' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="Computer Application";
	}
	 
$html.='<tr style="font-size:12px;">
<td width="10%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  border-bottom:1px solid #000;" align="center">&nbsp; '.$i++.'</td>
<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$name['exprint'].'</td><td width="30%" style="border-top:1px solid #000;  border-bottom:1px solid #000;border-right:1px solid #000; height:15px; line-height:15px;" align="center">80</td>';

$ter=0;
	  	$er['etype_id']='9';
		
		     if($students['class_id']=='11' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='34'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		
		 $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
		
		
		 $newmarkssanskrit=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],'33',$students['term']);
			if($newmarkssanskrit['marks']!=''){
		
					 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarkssanskrit['marks'].'</td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			
			 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		}
		
	}
		
		}else{
			
			   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
			
		}
		
		
	}else{
	 
		  
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
	
}


$html.='</tr>';
}






$html.='</table>
<br><br>

<?php /*
<table width="100%">

<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">Co-Scholastic Areas:</h2></td>
</tr>
</table>

<table width="100%">
<tr>
<td style="border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">
<table width="100%">
<tr>
<td style="height:15px;  font-weight:bold; line-height:15px;   text-transform:uppercase;" width="30%">
&nbsp; Physical & Health Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A2
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase;" width="30%">
Work Experience
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A1
</td>


</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
&nbsp; Genral Studies
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A1
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
Regularity
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A1
</td>


</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
&nbsp; Punctuality
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A1
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase;" width="30%">
Discipline
</td>

<td style="height:15px; line-height:15px; line-height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A1
</td>


</tr>


<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
&nbsp; Cleanliness
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A1
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase;" width="30%">
Teachers
</td>

<td style="height:15px; line-height:15px; line-height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A1
</td>


</tr>



<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
&nbsp; Peer Group
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A2
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase;" width="30%">
School Activities
</td>

<td style="height:15px; line-height:15px; line-height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A2
</td>


</tr>



</table>

</td>
</tr>

</table>
*/ ?>

<table width="100%">
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size:14px; font-weight:bold; line-height:30px; ">Attendance:</h2></td>
</tr>
</table>

<table width="100%" cellpadding="2px">
<tr style="font-weight:bold; font-size:11px;">
<td style="border-top:1px solid #000; border-left:1px solid #000; line-height:20px;border-right:1px solid #000; border-bottom:1px solid #000; width:20%; height:20px; text-align:center;">Term 1</td>';

$workingdaysid=$this->Comman->findcoscholsubjectt("Working Days",$students['class_id']);

$daysAttendedsid=$this->Comman->findcoscholsubjectt("Days Attended",$students['class_id']);

$workingdaysid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$workingdaysid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$daysAttendeds=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term1",$daysAttendedsid['id'],$students['stud_id'],$students['student']['acedmicyear']);

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


$html.='<td style="border-top:1px solid #000;height:20px; text-align:center; line-height:20px;border-right:1px solid #000; border-bottom:1px solid #000; width:40%;">'.$daysAttended.' Out Of '.$WorkingDays.'</td>
<td style="border-top:1px solid #000; height:20px;text-align:center; line-height:20px; border-right:1px solid #000; border-bottom:1px solid #000; width:40%;">Upto 30-09-'.date('Y').'</td>
</tr>
</table>
<br><br>
<table width="100%">
<tr>
<td width="100%" align="left" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">&nbsp; 

<table width="100%" cellspacing="8"style="font-size:11px;">
<tr><td width="100%"><b>Remarks:</b></td></tr>
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%" style=" border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%"></td></tr>
<br><br>

</table>
  </td>
  </tr>
  </table>
  <br><br>

<table width="100%" style="font-size:11px;">
<tr><br><br>
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

$pdf->SetFont('times', '', 9, '', 'false');
$pdf->WriteHTML($html, true, false, true, false, '');

}

ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
?>
