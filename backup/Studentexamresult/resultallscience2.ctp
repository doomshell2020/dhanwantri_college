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
if($students['class_id']=='17' || $students['class_id']=='20' || $students['class_id']=='22'){	
	$arr=['12','13','15'];
	if(in_array($students['class_id'],$arr)){
		$pdf->AddPage();
		
	}

$html.='<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';

$html.='</head><body>
<table width="100%">
<tr>
<td style="text-align:left" width="30%">
<?php /*<img src="images/schoolaward.png" alt="" border="0" style="display:inline-block;">*/ ?>

<img src="images/cbse-logo.png" alt="" border="0" style="display:inline-block; width:80px; height:80px;">
</td>
<td width="40%" align="center">
<img src="images/logo.png" alt="" border="0" style="display:block; width:200px; height:100px; vertical-align:bottom;" >

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
<tr>

<td width="100%" align="center" style="vertical-align:-100px;">
<p style="color:#000; text-align:center; font-size:10px;"> Affiliation No : 1730236<br>
Vishwamitra Marg , Hanuman Nagar Ext, Sirsi Road , Jaipur-302012<br>
<i>E-Mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com</i><br>
 <i>Phone:0141-2246189, 2357844 | Fax:2245602</i></p>
</td>

</tr>
<br><br>
<tr>
<td colspan="5" align="center" width="100%">
<h2 style="line-height:10px; font-size:22px;">
PROGRESS REPORT
</h2>
<p style="line-height:5px; font-size:15px;"><b>PRE BOARD EXAMINATION</b></p>
<h3 style="line-height:5px; font-size:16px;">
SESSION: '.$students['student']['acedmicyear'].'<br><br><br><br><br>
</h3>
</td>
</tr>
</table>

<table width="100%">

<tr>

<td width="100%">
<table width="100%">
<tr style="font-size:10px;">

<td style="height:15px; line-height:15px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; Name:
</td>



<td style="height:15px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>


<td style="height:15px; line-height:15px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Class:";
$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
$html.=$studentn.'

</td>


<td style="height:15px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.$classt['title'].' - '.$sect['title'].'
</td>


</tr>

<tr tyle="font-size:10px;">

<td style="height:15px; line-height:15px;   text-transform:uppercase;  font-weight:bold; font-size:10px;" width="20%">
&nbsp; ';
$studentn="Mother's Name:";
$html.=$studentn.'
</td>

<td style="height:15px;  font-size:10px;line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>
<td style="height:15px; font-size:10px; line-height:15px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; House:
</td>

<td style="height:15px; line-height:15px; font-size:10px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($fhosue['name'])).'
</td>


</tr>

<tr tyle="font-size:11px;">

<td style="height:15px; line-height:15px; font-size:10px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name:";
$html.=$studentn.'
</td>

<td style="height:15px; line-height:15px; font-size:10px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:15px; line-height:15px;font-size:10px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Date of Birth:
</td>

<td style="height:15px; line-height:15px; font-size:10px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp;&nbsp;'.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>
</tr>


<tr tyle="font-size:11px;">
<td style="height:15px; line-height:15px; font-size:10px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Admission No.:
</td>

<td style="height:15px; line-height:15px;font-size:10px; text-transform:uppercase;" width="30%">
&nbsp; '.$students['student']['enroll'].'
</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
</tr>



</table>

</td>

</tr>

</table>
<br><br><br>
<table width="100%">
<tr>
<td align="left"><h2 style=" text-align:center; font-size:16px; font-weight:bold;  text-transform:uppercase;">SCHOLASTIC PROGRESS</h2></td>
</tr>
</table>
<br><br>
<table width="100%" cellpadding="2px">
<tr style="font-size:12px;">
<td width="12%" style="border-top:1px solid #000; border-left:1px solid #000; text-align:center;  height:38px; line-height:20px;  border-right:1px solid #000;  font-weight:bold; " align="center" >&nbsp; S.No.</td>
<td width="35%" style="border-top:1px solid #000;  text-transform:uppercase; height:38px; line-height:20px;  font-weight:bold;  border-right:1px solid #000;" align="center" >&nbsp; SUBJECTS</td>

<td width="15%" style="border-top:1px solid #000; font-weight:bold;  border-right:1px solid #000; line-height:20px;" align="center" >Th</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000; line-height:20px;" align="center">Pr</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000; line-height:20px;" align="center" >TOTAL<br>100</td>

<td width="11%" style="border-top:1px solid #000; height:38px; line-height:20px;  font-weight:bold; border-right:1px solid #000;" align="center" >%</td>


</tr>';


$rt=array();
$ert=array();
$cnt=1;
$cnt2=0;
$total=0;
  $subjects=array();                  $rt=explode(',',$students['student']['comp_sid']);
foreach($rt as $hhj=>$studett){
                   
    $subject=$this->Comman->findsubjectsubs2($studett);
    
   $subjects[]=$this->Comman->find_examsubjectsnn2s($students['class_id'],$subject['name']);   
   
    
}


foreach ($subjects as $key => $row)
{
    $vc_array_name[$key] = $row['sort'];
}
array_multisort($vc_array_name, SORT_ASC, $subjects);


$etype_id=38;
$findroleexamtype=$this->Comman->findeexamtsype3ss($students['sect_id'],$students['class_id'],$students['term'],$etype_id);


  foreach($subjects as $key=>$name){
   if($name['exprint']=="English"){
	  $name['exprint']="English Core"; 
	   
   }
   
   
   if($name['exprint']=="Psychology_M"){
	  $name['exprint']="Psychology"; 
	   
   }
$html.='<tr style="font-size:12px;">
<td width="12%" style="border-top:1px solid #000; text-align:center; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  " align="center">&nbsp; '.$cnt++.'.</td>
<td width="35%" style="border-top:1px solid #000; font-weight:bold;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"> '.$name['exprint'].'</td>';

$cnt2++;
$ter=0;
$grade=0;
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			
			 $ter +=$newmarks['marks'];
			 
	
	
}else{
			 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}
$er2['etype_id']=16;
$prnewmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er2['etype_id'],$name['id'],$students['term']);
if($prnewmarks['marks']!=''){
		 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$prnewmarks['marks'].'</td>';
			
			 $ter +=$prnewmarks['marks'];
			 
	
	
}else{
			 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
if($ter!=0){
	$grade=$ter*100/100; 
	$grade=number_format($grade);
	
}else{
	
	$grade='0';
}

$total +=$ter;

$html.='<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$ter.'</td>
<td  width="11%"  style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$grade.' %</td>';
$html.='</tr>';

}


$rt2=array();
$ert2=array();
$subjects2=array();
                    $rt2=explode(',',$students['student']['opt_sid']);
foreach($rt2 as $hhj2=>$studett2){
                   
    $subject2=$this->Comman->findsubjectsubs2($studett2);
    
   $subjects2[]=$this->Comman->find_examsubjectsnn2s($students['class_id'],$subject2['name']);   
   
    
}


foreach ($subjects2 as $key2 => $row2)
{
    $vc_array_name2[$key] = $row2['sort'];
}
array_multisort($vc_array_name2, SORT_ASC, $subjects2);




  foreach($subjects2 as $key2=>$name2){
    if($name2['exprint']=="English"){
	  $name2['exprint']="English Core"; 
	   
   }
$html.='<tr style="font-size:12px;">
<td width="12%" style="border-top:1px solid #000; text-align:center; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  " align="center">&nbsp;  '.$cnt++.'.</td>
<td width="35%" style="border-top:1px solid #000; font-weight:bold;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"> '.$name2['exprint'].'</td>';
$cnt2++;
$ter=0;
$grade=0;
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name2['id'],$students['term']);
if($newmarks['marks']!=''){
		 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
			
			 $ter +=$newmarks['marks'];
			 
	
	
}else{
			 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}
$oprer['etype_id']=16;
$oprnewmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$oprer['etype_id'],$name2['id'],$students['term']);
if($oprnewmarks['marks']!=''){
		 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$oprnewmarks['marks'].'</td>';
			
			 $ter +=$oprnewmarks['marks'];
			 
	
	
}else{
			 $html.='<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
if($ter!=0){
	$grades=$ter*100/100;
	$grades=number_format($grades); 
	
}else{
	
	$grades='0';
}
$total +=$ter;
 $html.='<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$ter.'</td>
<td  width="11%"  style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$grades.' %</td>';
$html.='</tr>';

}


if($cnt2!=0){
	$rtdd=$cnt2*100;
	$gradestotal=$total*100/$rtdd;
	$gradestotal=number_format($gradestotal,2); 
	
}else{
	
	$gradestotal='0';
}


$workingdaysid=$this->Comman->findcoscholsubjectt("Working Days",$students['class_id']);

$daysAttendedsid=$this->Comman->findcoscholsubjectt("Days Attended",$students['class_id']);



$workingdaysid=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$workingdaysid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$daysAttendeds=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$daysAttendedsid['id'],$students['stud_id'],$students['student']['acedmicyear']);



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




$html.='<tr style="font-size:12px;">
<td width="47%" style="border-top:1px solid #000; font-size:12px; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; text-align:center;   font-weight:bold;" colspan="2">TOTAL</td>

<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>

<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$total.'</td>
<td width="11%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
</tr>


<tr style="font-size:12px;">
<td width="47%" style="border-top:1px solid #000; font-size:12px; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; text-align:center;  font-weight:bold;" colspan="2">TOTAL%</td>

<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="15%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>

<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$gradestotal.'%</td>
<td width="11%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
</tr>


<tr style="font-size:12px;">
<td width="47%" style="border-top:1px solid #000; border-bottom:1px solid #000; font-size:12px; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; text-align:center;  font-weight:bold;" colspan="2">ATTENDANCE</td>

<td width="15%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="15%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>

<td width="12%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$daysAttended.'/'.$WorkingDays.'</td>
<td width="11%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
</tr>


</table>
<br><br>




<table width="100%">
<tr>';
if($cnt2>5){
$html.='<td width="100%" align="left" height="90px" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; font-weight:bold; line-height:30px; font-size:13px;" >&nbsp; REMARKS :</td>';
}else{
	
	$html.='<td width="100%" align="left" height="100px" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; font-weight:bold; line-height:30px; font-size:13px;" >&nbsp; REMARKS :</td>';
	
}

$html.='</tr>
</table>
</td>
</tr>
</table>


<table width="100%" style="font-size:11px;">
<tr><br><br><br><br>
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


</table>';


$arr2=['17','20','22'];
	if(in_array($students['class_id'],$arr2)){

	
	
	

$physicalsid=$this->Comman->findcoscholsubjectt("Physical & Health Education",$students['class_id']);

$worlexprid=$this->Comman->findcoscholsubjectt("Work Experience",$students['class_id']);

$genstudrid=$this->Comman->findcoscholsubjectt("General Studies",$students['class_id']);
$Regularityid=$this->Comman->findcoscholsubjectt("Regularity",$students['class_id']);
$Punctualityid=$this->Comman->findcoscholsubjectt("Punctuality",$students['class_id']);
$Cleanlinessid=$this->Comman->findcoscholsubjectt("Cleanliness",$students['class_id']);

$Teachersideid=$this->Comman->findcoscholsubjectt("Teachers",$students['class_id']);
$Peerids=$this->Comman->findcoscholsubjectt("Peer Group",$students['class_id']);
$Schoolids=$this->Comman->findcoscholsubjectt("School Activities",$students['class_id']);


$physicalsid2e=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$physicalsid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$worlexpridsid2e=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$worlexprid['id'],$students['stud_id'],$students['student']['acedmicyear']);


$genstudridsid2e=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$genstudrid['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Regularityides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Regularityid['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Punctualityides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Punctualityid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$Cleanlinessides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Cleanlinessid['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Teachersides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Teachersideid['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Peerides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Peerids['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Schoolidee=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Schoolids['id'],$students['stud_id'],$students['student']['acedmicyear']);


if($physicalsid2e['marks']){   

 
	$physicalsid2=$physicalsid2e['marks'];
	

}else{
	
		$physicalsid2="-";
	
}


if($worlexpridsid2e['marks']){   

 
	$worlexpridsid2=$worlexpridsid2e['marks'];
	

}else{
	
		$worlexpridsid2="-";
	
}


if($genstudridsid2e['marks']){   

 
	$genstudridsid2=$genstudridsid2e['marks'];
	

}else{
	
		$genstudridsid2="-";
	
}
if($Regularityides['marks']){   

 
	$Regularityide=$Regularityides['marks'];
	

}else{
	
		$Regularityide="-";
	
}
if($Punctualityides['marks']){   

 
	$Punctualityide=$Punctualityides['marks'];
	

}else{
	
		$Punctualityide="-";
	
}
if($Cleanlinessides['marks']){   

 
	$Cleanlinesside=$Cleanlinessides['marks'];
	

}else{
	
		$Cleanlinesside="-";
	
}
if($Teachersides['marks']){   

 
	$Teachersi=$Teachersides['marks'];
	

}else{
	
		$Teachersi="-";
	
}
if($Peerides['marks']){   

 
	$Peeride=$Peerides['marks'];
	

}else{
	
		$Peeride="-";
	
}
if($Schoolidee['marks']){   

 
	$Schooli=$Schoolidee['marks'];
	

}else{
	
		$Schooli="-";
	
}
$pdf->AddPage();

 
$html.='<table width="100%">

<tr>
<td width="100%" align="center"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">NON ACADEMIC PROGRESS</h2></td>
</tr>
</table><br><br>
 
 <table width="100%" border="1" cellpadding="2px">

<tr>

<td width="50%" align="center" style="font-size:12px;" >
 
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase; font-weight:bold;" >
GRADE
</td>
</tr>
<tr>

<td width="50%" align="center" style="font-size:12px; font-weight:bold;" >
 Physical &amp; Health Education
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$physicalsid2.'
</td>
</tr>

<tr>

<td width="50%" align="center" style="font-size:12px; font-weight:bold;" >
  Work Experience
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$worlexpridsid2.'
</td>
</tr>

<tr>

<td width="50%" align="center" style="font-size:12px; font-weight:bold;" >
 General Studies
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$genstudridsid2.'
</td>
</tr>


</table>
<br><br><br><br>


<table width="100%" border="1" cellpadding="2">

<tr>

<td width="50%" align="center" style="font-size:13px; font-weight:bold;" >
 PERSONALITY TRAITS
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase; font-weight:bold;" >
GRADE
</td>
</tr>
<tr>

<td width="50%" align="left" style="font-size:13px; font-weight:bold;" >
CONDUCT
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >

</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Regularity
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Regularityide.'
</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Punctuality
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Punctualityide.'
</td>
</tr>
<tr>

<td width="50%" align="left" style="font-size:12px;" >
Cleanliness
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Cleanlinesside.'
</td>
</tr>
<tr>

<td width="50%" align="left" style="font-size:13px; font-weight:bold;" >
ATTITUDE TOWARDS
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >

</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Teachers
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Teachersi.'
</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Peer Group
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Peeride.'
</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
School Activities
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Schooli.'
</td>
</tr>
</table>
<br><br><br><br>
 <table width="100%">

<tr>
<td width="100%" align="center"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">NON ACADEMIC PROGRESS</h2></td>
</tr>
</table><br><br>
<table width="100%" align="center">
<tr>
<td width="20%"></td>
<td width="60%">
<table width="100%" align="center" border="1" cellpadding="2">
<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;font-weight:bold;">Grade</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;font-weight:bold;">Marks Range</td>
</tr>
<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">A</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">&nbsp;&nbsp;81-100</td>
</tr>



<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">B</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">61-80</td>
</tr>



<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">C</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">41-60</td>
</tr>



<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">D</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">33-40</td>
</tr>

<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">E</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">0-32</td>
</tr>


</table>


</td>
<td width="20%"></td>




</tr>

</table>
<br><br><br>';

}


$html.='</body>
</html>';
$pdf->SetFont('times', '', 9, '', 'false');
$pdf->WriteHTML($html, true, false, true, false, '');
}else{
	
	
	$arr=['12','13','15'];
	if(in_array($students['class_id'],$arr)){
		//$pdf->AddPage();
		
	}

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
<td style="text-align:left" width="30%">
<?php /*<img src="images/schoolaward.png" alt="" border="0" style="display:inline-block;">*/ ?>

<img src="images/cbse-logo.png" alt="" border="0" style="display:inline-block; width:80px; height:80px;">
</td>
<td width="40%" align="center">
<img src="images/logo.png" alt="" border="0" style="display:block; width:200px; height:100px; vertical-align:bottom;" >

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
<td colspan="5" align="center" width="100%">
<h2 style="line-height:10px; font-size:22px;">
PROGRESS REPORT
</h2>
<h3 style="line-height:5px; font-size:16px;">
SESSION: '.$students['student']['acedmicyear'].'<br><br><br><br><br>
</h3>
</td>
</tr>
</table>

<table width="100%">

<tr>

<td width="100%">
<table width="100%">
<tr style="font-size:10px;">

<td style="height:15px; line-height:15px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; Name:
</td>



<td style="height:15px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>


<td style="height:15px; line-height:15px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Class:";
$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
$html.=$studentn.'

</td>


<td style="height:15px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.$classt['title'].' - '.$sect['title'].'
</td>


</tr>

<tr tyle="font-size:10px;">

<td style="height:15px; line-height:15px;   text-transform:uppercase;  font-weight:bold; font-size:10px;" width="20%">
&nbsp; ';
$studentn="Mother's Name:";
$html.=$studentn.'
</td>

<td style="height:15px;  font-size:10px;line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>
<td style="height:15px; font-size:10px; line-height:15px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; House:
</td>

<td style="height:15px; line-height:15px; font-size:10px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($fhosue['name'])).'
</td>


</tr>

<tr tyle="font-size:11px;">

<td style="height:15px; line-height:15px; font-size:10px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name:";
$html.=$studentn.'
</td>

<td style="height:15px; line-height:15px; font-size:10px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:15px; line-height:15px;font-size:10px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Date of Birth:
</td>

<td style="height:15px; line-height:15px; font-size:10px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp;'.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>
</tr>


<tr tyle="font-size:11px;">
<td style="height:15px; line-height:15px; font-size:10px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Admission No.:
</td>

<td style="height:15px; line-height:15px;font-size:10px; text-transform:uppercase;" width="30%">
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
<td align="left"><h2 style=" text-align:center; font-size:16px; font-weight:bold;  text-transform:uppercase;">SCHOLASTIC PROGRESS</h2></td>
</tr>
</table>
<br><br>
<table width="100%" cellpadding="2px">
<tr style="font-size:12px;">
<td width="7%" style="border-top:1px solid #000; border-left:1px solid #000; text-align:center;  height:38px; line-height:38px;  border-right:1px solid #000;  font-weight:bold; " align="center" rowspan="2">&nbsp; S.No.</td>
<td width="21%" style="border-top:1px solid #000;  text-transform:uppercase; height:38px; line-height:38px;  font-weight:bold;  border-right:1px solid #000;" align="center" rowspan="2">&nbsp; SUBJECTS</td>
<td width="7.5%" style="border-top:1px solid #000;   font-weight:bold;  border-right:1px solid #000;" align="center" rowspan="2">IA-1<br>50</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center" colspan="2">SEM-1 100</td>
<td width="9%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center" rowspan="2">TOTAL<br>150</td>

<td width="7.5%" style="border-top:1px solid #000;   font-weight:bold;  border-right:1px solid #000;" align="center" rowspan="2">IA-2<br>50</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center" colspan="2">SEM-2 100</td>
<td width="9%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center" rowspan="2">TOTAL<br>150</td>

<td width="9%" style="border-top:1px solid #000; height:38px; line-height:15px;  font-weight:bold; border-right:1px solid #000;" align="center" rowspan="2">Grand<br>Total<br>300</td>
</tr>
<tr>
<td width="7.5%" style="border-top:1px solid #000; border-right:1px solid #000; line-height:20px;" align="center" colspan="2">Th</td>
<td width="7.5%" style="border-top:1px solid #000;   border-right:1px solid #000; line-height:20px;" align="center">Pr</td>

<td width="7.5%" style="border-top:1px solid #000; border-right:1px solid #000; line-height:20px;" align="center" colspan="2">Th</td>
<td width="7.5%" style="border-top:1px solid #000;   border-right:1px solid #000; line-height:20px;" align="center">Pr</td>
</tr>';






$scto=0;
$scto1=0;

$rt=array();
$ert=array();
$cnt=1;
$cnt2=0;
$total=0;
  $subjects=array();                  $rt=explode(',',$students['student']['comp_sid']);
foreach($rt as $hhj=>$studett){
                   
    $subject=$this->Comman->findsubjectsubs2($studett);
    
   $subjects[]=$this->Comman->find_examsubjectsnn2s($students['class_id'],$subject['name']);   
   
    
}


foreach ($subjects as $key => $row)
{
    $vc_array_name[$key] = $row['sort'];
}
array_multisort($vc_array_name, SORT_ASC, $subjects);



$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],$students['term']);

$findroleexamtype1=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],'1');

  foreach($subjects as $key=>$name){
   if($name['exprint']=="English"){
	  $name['exprint']="English Core"; 
	   
   }
   
   
   if($name['exprint']=="Psychology_M"){
	  $name['exprint']="Psychology"; 
	   
   }
$html.='<tr style="font-size:12px;">
<td width="7%" style="border-top:1px solid #000; text-align:center; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  " align="center">&nbsp; '.$cnt++.'.</td>
<td width="21%" style="border-top:1px solid #000; font-weight:bold;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"> '.$name['exprint'].'</td>';

$cnt2++;
$ter=0;
$grade=0;
$ter1=0;
  foreach($findroleexamtype1 as $er1){  
		   
		   	
		   
		   
		   $newmarks1=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er1['etype_id'],$name['id'],'1');
if($newmarks1['marks']!=''){
		 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks1['marks'].'</td>';
		
			 $ter1 +=$newmarks1['marks'];
			 
		 
	
	
}else{
			 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}

$html.='<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$ter1.'</td>';



	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
				
			 $ter +=$newmarks['marks'];
			 
			
			 
	
	
}else{
			 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}
if($ter!=0 || $ter1!=0){
	$grade=$ter+$ter1; 
	//$grade=number_format($grade);
	
}else{
	
	$grade='0';
}

$total +=$ter;


$scto +=$ter;
$scto1 +=$ter1;
$html.='<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$ter.'</td>
<td  width="9%"  style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$grade.' </td>';
$html.='</tr>';

}


$rt2=array();
$ert2=array();
$subjects2=array();
                    $rt2=explode(',',$students['student']['opt_sid']);
foreach($rt2 as $hhj2=>$studett2){
                   
    $subject2=$this->Comman->findsubjectsubs2($studett2);
    
   $subjects2[]=$this->Comman->find_examsubjectsnn2s($students['class_id'],$subject2['name']);   
   
    
}


foreach ($subjects2 as $key2 => $row2)
{
    $vc_array_name2[$key2] = $row2['sort'];
}
array_multisort($vc_array_name2, SORT_ASC, $subjects2);




  foreach($subjects2 as $key2=>$name2){
    if($name2['exprint']=="English"){
	  $name2['exprint']="English Core"; 
	   
   }
$html.='<tr style="font-size:12px;">
<td width="7%" style="border-top:1px solid #000; text-align:center; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  " align="center">&nbsp;  '.$cnt++.'.</td>
<td width="21%" style="border-top:1px solid #000; font-weight:bold; font-size:11px;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"> '.$name2['exprint'].'</td>';
$cnt2++;
$ter=0;
$grade=0;



$ter1=0;
  foreach($findroleexamtype1 as $er1){  
		   
		   	
		   
		   
	   $newmarks2=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er1['etype_id'],$name2['id'],'1');
if($newmarks2['marks']!=''){
		 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks2['marks'].'</td>';
			
			 $ter1 +=$newmarks2['marks'];
		
	
	
}else{
			 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}

$html.='<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$ter1.'</td>';
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name2['id'],$students['term']);
if($newmarks['marks']!=''){
		 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$newmarks['marks'].'</td>';
		
			 $ter +=$newmarks['marks'];
		
			 
	
	
}else{
			 $html.='<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}
if($ter!=0 || $ter1!=0){
	$grades=$ter+$ter1;
	//$grades=number_format($grades); 
	
}else{
	
	$grades='0';
}

$scto +=$ter;
$scto1 +=$ter1;

$total +=$ter;
 $html.='<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$ter.'</td>
<td  width="9%"  style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">'.$grades.' </td>';
$html.='</tr>';


}


if($cnt2!=0){
	$rtdd=$cnt2*150;
	$gradestotal=$total*100/$rtdd;
	$gradestotal=number_format($gradestotal,2); 
	
}else{
	
	$gradestotal='0';
}


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


$workingdaysid=$this->Comman->findcoscholsubjectt("Working Days",$students['class_id']);

$daysAttendedsid=$this->Comman->findcoscholsubjectt("Days Attended",$students['class_id']);


$workingdaysid2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$workingdaysid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$daysAttendeds2=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$daysAttendedsid['id'],$students['stud_id'],$students['student']['acedmicyear']);


if($workingdaysid2['marks']){   

 
	$WorkingDayss2=$workingdaysid2['marks'];
	

}else{
	
		$WorkingDayss2="-";
	
}





if($daysAttendeds2['marks']){   

 
	$daysAttended2=$daysAttendeds2['marks'];
	

}else{
	
		$daysAttended2="-";
	
}



$rtdd=$scto1+$scto;
$rtdds=$cnt2*150;
$rtdds2=$cnt2*300;
	$term1to=$scto1*100/$rtdds;
	$term1to=number_format($term1to,2); 
	$term2to=$scto*100/$rtdds;
	$term2to=number_format($term2to,2); 
	$term1to3=$rtdd*100/$rtdds2;
	$term1to3=number_format($term1to3,2); 

$html.='<tr style="font-size:12px;">
<td width="28%" style="border-top:1px solid #000; font-size:12px; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; text-align:center;   font-weight:bold;" colspan="2">TOTAL</td>

<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$scto1.'</td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$scto.'</td>
<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$rtdd.'</td>

</tr>


<tr style="font-size:12px;">
<td width="28%" style="border-top:1px solid #000; font-size:12px; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; text-align:center;   font-weight:bold;" colspan="2">TOTAL %</td>

<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$term1to.'</td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$term2to.'</td>
<td width="9%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$term1to3.'</td>

</tr>


<tr style="font-size:12px;">
<td width="28%" style="border-top:1px solid #000; border-bottom:1px solid #000;font-size:12px; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; text-align:center;   font-weight:bold;" colspan="2">ATTENDANCE</td>

<td width="7.5%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000;border-bottom:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="9%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$daysAttended.'/'.$WorkingDays.'</td>
<td width="7.5%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="7.5%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;height:15px; line-height:15px;" align="center"></td>
<td width="9%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$daysAttended2.'/'.$WorkingDayss2.'</td>
<td width="9%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"></td>

</tr>


</table>
<br><br>




<table width="100%">
<tr>';
if($cnt2>5){
$html.='<td width="100%" align="left" height="90px" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; font-weight:bold; line-height:30px; font-size:13px;" >&nbsp; REMARKS :</td>';
}else{
	
	$html.='<td width="100%" align="left" height="100px" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; font-weight:bold; line-height:30px; font-size:13px;" >&nbsp; REMARKS :</td>';
	
}

$html.='</tr>
</table>
</td>
</tr>
</table><br><br>
<table width="100%">
<tr>';
if($cnt2>5){
$html.='<td width="100%" align="left" height="50px" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; font-weight:bold; line-height:25px; font-size:13px;" >&nbsp; FINAL RESULT :</td>';
}else{
	
	$html.='<td width="100%" align="left" height="50px" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; font-weight:bold; line-height:25px; font-size:13px;" >&nbsp; FINAL RESULT :</td>';
	
}

$html.='</tr>
</table>
</td>
</tr>
</table>';
if($cnt<=6){ 
$html.='<br><br><br><br>';
}else{
	
$html.='<br><br><br>';	
}


$html.='<table width="100%" style="font-size:11px;">
<tr><br><br><br><br><br>
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


</table>';


$arr2=['12','13','15'];
	if(in_array($students['class_id'],$arr2)){

	
	
	

$physicalsid=$this->Comman->findcoscholsubjectt("Physical & Health Education",$students['class_id']);

$worlexprid=$this->Comman->findcoscholsubjectt("Work Experience",$students['class_id']);

$genstudrid=$this->Comman->findcoscholsubjectt("General Studies",$students['class_id']);
$Regularityid=$this->Comman->findcoscholsubjectt("Regularity",$students['class_id']);
$Punctualityid=$this->Comman->findcoscholsubjectt("Punctuality",$students['class_id']);
$Cleanlinessid=$this->Comman->findcoscholsubjectt("Cleanliness",$students['class_id']);
$Disciplineid=$this->Comman->findcoscholsubjectt("Discipline",$students['class_id']);

$Teachersideid=$this->Comman->findcoscholsubjectt("Teachers",$students['class_id']);
$Peerids=$this->Comman->findcoscholsubjectt("Peer Group",$students['class_id']);
$Schoolids=$this->Comman->findcoscholsubjectt("School Activities",$students['class_id']);


$physicalsid2e=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$physicalsid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$worlexpridsid2e=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$worlexprid['id'],$students['stud_id'],$students['student']['acedmicyear']);


$genstudridsid2e=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$genstudrid['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Regularityides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Regularityid['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Punctualityides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Punctualityid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$Cleanlinessides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Cleanlinessid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$Disciplineidides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Disciplineid['id'],$students['stud_id'],$students['student']['acedmicyear']);

$Teachersides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Teachersideid['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Peerides=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Peerids['id'],$students['stud_id'],$students['student']['acedmicyear']);
$Schoolidee=$this->Comman->findcoactivityresultpdf($students['class_id'],$students['sect_id'],"Term2",$Schoolids['id'],$students['stud_id'],$students['student']['acedmicyear']);


if($physicalsid2e['marks']){   

 
	$physicalsid2=$physicalsid2e['marks'];
	

}else{
	
		$physicalsid2="-";
	
}


if($worlexpridsid2e['marks']){   

 
	$worlexpridsid2=$worlexpridsid2e['marks'];
	

}else{
	
		$worlexpridsid2="-";
	
}


if($genstudridsid2e['marks']){   

 
	$genstudridsid2=$genstudridsid2e['marks'];
	

}else{
	
		$genstudridsid2="-";
	
}
if($Regularityides['marks']){   

 
	$Regularityide=$Regularityides['marks'];
	

}else{
	
		$Regularityide="-";
	
}
if($Punctualityides['marks']){   

 
	$Punctualityide=$Punctualityides['marks'];
	

}else{
	
		$Punctualityide="-";
	
}
if($Cleanlinessides['marks']){   

 
	$Cleanlinesside=$Cleanlinessides['marks'];
	

}else{
	
		$Cleanlinesside="-";
	
}
if($Disciplineidides['marks']){   

 
	$Disciplineididess=$Disciplineidides['marks'];
	

}else{
	
		$Disciplineididess="-";
	
}
if($Teachersides['marks']){   

 
	$Teachersi=$Teachersides['marks'];
	

}else{
	
		$Teachersi="-";
	
}
if($Peerides['marks']){   

 
	$Peeride=$Peerides['marks'];
	

}else{
	
		$Peeride="-";
	
}
if($Schoolidee['marks']){   

 
	$Schooli=$Schoolidee['marks'];
	

}else{
	
		$Schooli="-";
	
}
$pdf->AddPage();

 
$html.='<table width="100%">

<tr>
<td width="100%" align="center"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">NON ACADEMIC PROGRESS</h2></td>
</tr>
</table><br><br>
 
 <table width="100%" border="1" cellpadding="2px">

<tr>

<td width="50%" align="center" style="font-size:12px;" >
 
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase; font-weight:bold;" >
GRADE
</td>
</tr>
<tr>

<td width="50%" align="center" style="font-size:12px; font-weight:bold;" >
 Physical &amp; Health Education
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$physicalsid2.'
</td>
</tr>

<tr>

<td width="50%" align="center" style="font-size:12px; font-weight:bold;" >
  Work Experience
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$worlexpridsid2.'
</td>
</tr>

<tr>

<td width="50%" align="center" style="font-size:12px; font-weight:bold;" >
 General Studies
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$genstudridsid2.'
</td>
</tr>


</table>
<br><br><br><br>


<table width="100%" border="1" cellpadding="2">

<tr>

<td width="50%" align="center" style="font-size:13px; font-weight:bold;" >
 PERSONALITY TRAITS
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase; font-weight:bold;" >
GRADE
</td>
</tr>
<tr>

<td width="50%" align="left" style="font-size:13px; font-weight:bold;" >
CONDUCT
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >

</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Regularity
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Regularityide.'
</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Punctuality
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Punctualityide.'
</td>
</tr>
<tr>

<td width="50%" align="left" style="font-size:12px;" >
Cleanliness
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Cleanlinesside.'
</td>
</tr>
<tr>

<td width="50%" align="left" style="font-size:12px;" >
Discipline
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Disciplineididess.'
</td>
</tr>
<tr>

<td width="50%" align="left" style="font-size:13px; font-weight:bold;" >
ATTITUDE TOWARDS
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >

</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Teachers
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Teachersi.'
</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
Peer Group
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Peeride.'
</td>
</tr>

<tr>

<td width="50%" align="left" style="font-size:12px;" >
School Activities
</td>

<td width="50%" align="center" style="font-size:13px; text-transform:uppercase;" >
'.$Schooli.'
</td>
</tr>
</table>
<br><br><br><br>
 <table width="100%">

<tr>
<td width="100%" align="center"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">NON ACADEMIC PROGRESS</h2></td>
</tr>
</table><br><br>
<table width="100%" align="center">
<tr>
<td width="20%"></td>
<td width="60%">
<table width="100%" align="center" border="1" cellpadding="2">
<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;font-weight:bold;">Grade</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;font-weight:bold;">Marks Range</td>
</tr>
<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">A</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">&nbsp;&nbsp;81-100</td>
</tr>



<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">B</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">61-80</td>
</tr>



<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">C</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">41-60</td>
</tr>



<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">D</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">33-40</td>
</tr>

<tr>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">E</td>
<td width="50%" align="center" style="font-size:12px; text-transform:uppercase;">0-32</td>
</tr>


</table>


</td>
<td width="20%"></td>




</tr>

</table>
<br><br><br>';

}


$html.='</body>
</html>';


$pdf->SetFont('times', '', 9, '', 'false');
$pdf->WriteHTML($html, true, false, true, false, '');
	
	
	
	
}

}


ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
?>
