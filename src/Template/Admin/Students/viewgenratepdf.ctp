<?php 
class xtcpdf extends TCPDF {
 
}
 
   $this->set('pdf', new TCPDF($print,'mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
 $pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();


//pdf->SetY(-550);
$pdf->SetFont('', '', 9, '', 'false');


if($print=='L'){ 
$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Student-ID</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html.='</head><body style="font-family:"Trebuchet MS",Arial,Helvetica,sans-serif;">
<table width="100%">
';

$rt=0;
foreach($students as $key=>$value){ 
$html.='<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<tr><td width="50%">
<table width="100%" style="display:inline-block">
<tr style="background-color:#800000;">
<td width="30%" style="color:#fff; font-size:24px; max-width:100%">&nbsp;


<img src="images/IDSPrime-logo.png" alt="" border="0" style=" width: 240%; display:block; line-height:60px;"></td>
<td width="70%" style="text-align:center;"><span style="color:#fff; font-size:14px; line-height:25px; display:block;">Sanskar School</span><br><span style="color:#fff; font-size:10px; display:block; top:10px; line-height:2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student ID -'.$value['id'].'</span></td>
</tr>

<tr>
<td width="32%" style="border-left:1px solid #ccc;  margin-top:50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>';
if(!empty($value['file'])){ 
			$html.=	'&nbsp;&nbsp;<img  src="uploads/'.$value['file'].'" alt="" border="0" style="display:block; text-align:right; width:600%"><br>';
					 } else { 
						$html.='<img  src="uploads/no-images.png" alt="" border="0" style="display:block; text-align:right; width:600%"><br>';
					 }

$html.='<img src="images/principal_signature.png" alt="" border="0" style="display:block; text-align:right; width:900%">
<span style="color:#000; font-size:8px; text-align:center; line-height:10px;">&nbsp;&nbsp;&nbsp;Principal Signature</span>
<br>
</td>

<td width="68%" style="border-right:1px solid #ccc;"><br><br>
<table width="100%">
<tr style="line-height:15px;">
&nbsp;&nbsp;<td width="50%" style="text-align:left">
Name:
</td>
&nbsp;<td width="50%" style="text-align:left">
'.$value['fname'].'
</td>
</tr>
<tr style="line-height:15px;" >
<td width="50%" style="text-align:left">
Father name:
</td>
<td width="50%" style="text-align:left">
';

$ertd=$this->Comman->find_guardianname($value['id']); 
if($value['fathername']){ 
 $lin=explode("\n", wordwrap($value['fathername'],12,"\n"));
	$html.=$lin[0];
	}else if($ertd){ 
		 
		 
		 
		 
		 $lines = explode("\n", wordwrap($ertd[0]['fullname'], 12, "\n"));
		$html.='Mr.'.$lines[0];
		 
		  }else{
			  
			  	$html.='Mr. ----';
			  
			  }
		  
$html.='</td>
</tr>

<tr style="line-height:15px;">
<td width="50%" style="text-align:left">
Date of Birth:
</td>
<td width="50%" style="text-align:left">';
$rt= date('d-m-Y',strtotime($value['dob'])); $validdates= date('d-m-Y',strtotime($validdate)); if($rt!='01-01-1970'){ 
	 $html.= $rt;
	  }else{  
		  
			 $html.= '-- -- ----';  
		  }
$html.= '</td>
</tr>
<tr style="line-height:15px;">
<td width="50%" style="text-align:left">
Class:
</td>
<td width="50%" style="text-align:left">
'.$value['class']['title'].'('.$value['section']['title'].')
</td>
</tr>
<tr style="line-height:15px;">
<td width="50%" style="text-align:left">
Contact No.:
</td>
<td width="50%" style="text-align:left">
'.$value['mobile'].'
</td>
</tr>
<tr style="line-height:15px;">
<td width="50%" style="text-align:left">
Address:
</td>
<td width="50%" style="text-align:left">
';
if($value['address'][0]['p_address']){
	
	$html.=wordwrap($value['address'][0]['p_address'],15,"<br>\n");
	
}else if($value['address'][0]['c_address']){
	$html.=wordwrap($value['address'][0]['c_address'],15,"<br>\n");
	
}else{
	$html.='JAIPUR';
}
$html.='</td>
</tr>
<tr style="line-height:15px;">
<td width="50%" style="text-align:left">
Valid Upto:
</td>
<td width="50%" style="text-align:left">'
.$validdates.'
</td>
</tr>
</table>
</td>
</tr><tr style="background-color:#800000 ; line-height:20px; color:#fff; font-size:8px; text-align:center;"><td colspan="2">Address:-117-121, Vishwamitra Marg, Hanuman Nagar Ext.,Sirsi Road,Jaipur - 302012 
 </td></tr>
</table>
</td></tr>
<br>
<br>
<br>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'; 
} 
$html.='
</table>
</body>
</html>';


 }else{
	 
	 
	 
	 
$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>student-erp</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html.='</head>

<body style="font-family:"Trebuchet MS",Arial,Helvetica,sans-serif;">
<table width="100%">';
$rt=0;
foreach($students as $key=>$value){  $rt++;
$html.='<tr><br><td width="18%"></td>
<td width="35%"><table width="100%" style="display:inline-block">
<tr style="background-color:#800000;">
<td width="30%" style="color:#fff; font-size:24px;">&nbsp;<img src="images/IDSPrime-logo.png" alt="" border="0" style=" width: 240%; display:block; line-height:35px;"></td>
<td width="70%" style="text-align:center;"><span style="color:#fff; font-size:9px; line-height:20px; display:block;">Sanskar School</span><br><span style="color:#fff; font-size:8px; display:block; top:10px; line-height:2px;"> Student ID Session:-'.$value['id'].'</span></td>
</tr>

<tr>

<td colspan="2" style="border-left:1px solid #ccc;border-right:1px solid #ccc;  margin-top:50px;">&nbsp;&nbsp;&nbsp;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
if(!empty($value['file'])){ 
			$html.=	'<img src="uploads/'.$value['file'].'" alt="" border="0" style="display:block; text-align:left; width:600%"><br>';
					 } else { 
						$html.='<img src="uploads/no-images.png" alt="" border="0" style="display:block; text-align:left; width:600%"><br>';
					 }

$html.='
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/principal_signature.png" alt="" border="0" style="display:block; text-align:right; width:600%"><br>
<span style="color:#000; font-size:8px; text-align:center; line-height:10px;">&nbsp;&nbsp;&nbsp;Principal Signature</span>
<br>
</td>
</tr>

<tr>
<td colspan="2" style="border-right:1px solid #ccc; border-left:1px solid #ccc;"><br>
<table width="100%">
<tr style="line-height:12px;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td width="35%" style="text-align:left; font-size:7px;">
Name:
</td>
<td width="50%" style="text-align:left; font-size:7px;">
'.$value['fname'].'
</td>
</tr>
<tr style="line-height:12px;" >
<td width="35%" style="text-align:left; font-size:7px;">
Father name:
</td>
<td width="50%" style="text-align:left; font-size:7px;">';

$ertd=$this->Comman->find_guardianname($value['id']); 
if($value['fathername']){ 
 $lin=explode("\n", wordwrap($value['fathername'],12,"\n"));
	$html.=$lin[0];
	}else if($ertd){ 
		 
		 $lines = explode("\n", wordwrap($ertd[0]['fullname'], 12, "\n"));
		$html.='Mr.'.$lines[0];
		 
		  }else{
			  
			  	$html.='Mr. ----';
			  
			  }
		  
$html.='</td>
</tr>

<tr style="line-height:12px;">
<td width="35%" style="text-align:left; font-size:7px;">
Date of Birth:
</td>
<td width="50%" style="text-align:left; font-size:7px;">
';
$rt= date('d-m-Y',strtotime($value['dob'])); $validdates= date('d-m-Y',strtotime($validdate)); if($rt!='01-01-1970'){ 
	 $html.= $rt;
	  }else{  
		  
			 $html.= '-- -- ----';  
		  }
$html.= '
</td>
</tr>
<tr style="line-height:12px;">
<td width="35%" style="text-align:left; font-size:7px;">
Class:
</td>
<td width="50%" style="text-align:left; font-size:7px;">
'.$value['class']['title'].'('.$value['section']['title'].')
</td>
</tr>
<tr style="line-height:12px;">
<td width="35%" style="text-align:left; font-size:7px;">
Contact No.:
</td>
<td width="50%" style="text-align:left; font-size:7px;">
'.$value['mobile'].'
</td>
</tr>
<tr style="line-height:12px;">
<td width="35%" style="text-align:left; font-size:7px;">
Address:
</td>
<td width="50%" style="text-align:left; font-size:7px;">
';
if($value['address'][0]['p_address']){
	
	$html.=wordwrap($value['address'][0]['p_address'],18,"<br>\n");
	
}else if($value['address'][0]['c_address']){
	$html.=wordwrap($value['address'][0]['c_address'],18,"<br>\n");
	
}else{
	$html.='JAIPUR';
}
$html.='
</td>
</tr>
<tr style="line-height:12px;">
<td width="35%" style="text-align:left; font-size:7px;">
Valid Upto:
</td>
<td width="50%" style="text-align:left; font-size:7px;">
'.$validdates.'
</td>
</tr>
</table><br>
</td>
</tr>

<tr style="background-color:#800000 ; line-height:20px; color:#fff; font-size:6px; text-align:center;"><td colspan="2">Address:117-121, Vishwamitra Marg, Hanuman Nagar Ext., Sirsi Road, Jaipur - 302012. </td></tr>


</table>
</td>

<td width="4%"></td>


</tr><br><br><br><br><br><br><br><br><br><br>'; 


}

$html.='</table>

</body>
</html>';
	 
	 
 }	
$pdf->WriteHTML($html, true, false, true, false, '');

ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
