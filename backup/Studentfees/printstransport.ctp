<?php 
class xtcpdf extends TCPDF {
}
 
   $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
 $pdf->SetPrintHeader(false);
 $pdf->SetPrintFooter(false);
$pdf->AddPage();


//pdf->SetY(-550);
$pdf->SetFont('', '', 9, '', 'false');

$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>student-erp</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html.='</head>

<body style="font-family:"trebuchet MS",Arial,Helvetica,sans-serif;">
<br>
<table width="100%" style="border-left: 1px solid #d1d1d1; border-right: 1px solid #d1d1d1;">
<tr>
<td width="20%" style="border:1px solid #d1d1d1; border-right:none; text-align:center">
<img src="images/L_58839.gif" alt="" border="0" style=" width: 700%; display:block; line-height:-20px;">
</td>
<td align="center" style="border:1px solid #d1d1d1;border-left:none;" width="80%">
<small style="display:block; color:#000; font-size:16px;">
Sanskar School
</small><br>
<span style="display:block; color:#000; font-size|:10px;">Senior Secondary English Medium Co-Educational School<br>
(An ISO 9001 : 2000 Certified School) Affiliated to CBSE, New Delhi, Aff. No. 1730236<br>
117-121, Vishwamitra Marg, Hanuman Nagar Ext., Sirsi Road, Jaipur - 302012</span><br>
<span style="display:block; color:#000; font-size|:10px;">Phone No.:&nbsp;0141 - 2246189,2357844,2245602 </span><br>
<span style="display:block; color:#000; font-size|:10px;">Email id.:&nbsp;info@sanskarjaipur.com</span><br>
<span style="display:block; color:#000; font-size|:10px;">Website:&nbsp;www.sanskarjaipur.com</span>
</td>
</tr>

<tr>
<td width="100%"  align="center" style="line-height:20px;"><b>Transport Fees Receipt</b><br>('.$studentfees['quarter'].')</td>
</tr>
</table>

<table width="100%">
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Student ID :</b></td>
<td width="20%">'.$students['id'].'</td>
<td width="20%"></td>
<td width="20%"><b>Receipt No. :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$studentfees['id'].'</td>

</tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Name:</b></td>
<td width="20%">'.$students['fname'].' '.$students['middlename'].' '.$students['lname'].'</td>

<td width="20%"></td>
<td width="20%"><b>Academic Year :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1; ">'.$students['acedmicyear'].'</td>
</tr>

<tr>
<td style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Class:</b></td>
<td width="20%">'.$students['class']['title'].'</td><td width="20%"></td>
<td width="20%"><b>Section:</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$students['section']['title'].'</td>
</tr>

<tr>
<td style="border-left: 1px solid #d1d1d1;" ><b>&nbsp;&nbsp;Father name:</b></td>
<td width="20%">'.$students['fathername'].'</td>
<td width="20%"></td>
<td width="20%"><b>Payment Date :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.date('d-m-Y',strtotime($studentfees['paydate'])).'</td>

</tr>


<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"><b>Fees Details</b></td>
</tr>
</table>

<table width="100%" style="   border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">

<tr>
<td width="1%"></td>
<th align="right" width="5%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1; height:20px; line-height:21px;"><b>#</b></th>
<th align="right" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>Particulars</b></th>
<th align="right" width="45%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>Amount</b></th>
<td width="1%"></td>
</tr>';


$count=0; $fees=0; $j=0; 
 if($studentfees['quarter']=='Quater1'){
	 
	 $totlefees=$feeheads[0]['qu1_fees'];
 }elseif($studentfees['quarter']=='Quater2'){
	 
	 $totlefees=$feeheads[0]['qu2_fees'];
	 
	 }elseif($studentfees['quarter']=='Quater3'){
	 
	 $totlefees=$feeheads[0]['qu3_fees'];
	 }else{
		 
		 $totlefees=$feeheads[0]['qu4_fees'];
		 }

$html.='<tr>
<td width="1%"></td>
<td align="right" width="5%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;">1</td>
<td align="right" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"> Transport Fees</td>
<td align="right" width="45%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;">'.$totlefees.'</td>
<td width="1%"></td>
</tr>'; 



$html.='<tr>
<td width="1%"></td>
<td align="right" width="5%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"></td>
<td align="right" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>Total Fees</b></td>
<td align="right" width="45%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>'.$totlefees.'</b></td>
<td width="1%"></td>
</tr>';
$discount_fees=$studentfees['discount'];
if($discount_fees>0){
	$netamount =$totlefees/100*$discount_fees; $remain=$totlefees-$netamount;
	$html.='<tr>
<td width="1%"></td>
<td align="right" width="10%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"></td>
<td align="right" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>Net Amount (Discount-'.$discount_fees.'%)</b></td>
<td align="right" width="40%" style="border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>'.number_format($remain).'</b></td>
<td width="1%"></td>
</tr>';	
}
$html.='</table>';



$bank=$this->Comman->findbank($studentfees['bank_id']);

if($studentfees['mode']!='Cash'){ 
$html.='
<table width="100%">
<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"></td>
</tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Mode:</b></td>
<td width="20%">'.$studentfees['mode'].'</td>
<td width="20%"></td>';

if($studentfees['challan_no']!="")
{
$html.='
<td width="20%"><b>&nbsp;&nbsp;Challan No. :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$studentfees['challan_no'].'</td>';
}else { 
	
	$html.='
<td width="20%"></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;"></td>';
	} 
	$html.='
</tr>
<tr>';
if($bank['name'])
{
$html.='
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Bank:</b></td>
<td width="20%" >'.$bank['name'].'</td>';
}else { 
	
	$html.='
<td width="20%" style="border-left: 1px solid #d1d1d1;"></td>
<td width="20%" ></td>';
	}
	$html.='
<td width="20%"></td>
<td ><b>&nbsp;&nbsp;Cheque No :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$studentfees['cheque_no'].'</td><td width="20%"></td>

</tr>


<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"></td>
</tr>

<tr>
<td width="70%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1; border-bottom:1px solid #d1d1d1;  "></td><td width="30%" align="center" style="line-height:20px; solid #d1d1d1; border-bottom:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">Received by</td>
</tr>


</table>
';

}else{
	

$html.='<table width="100%">
<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"></td>
</tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Mode:</b></td>
<td width="20%">'.$studentfees['mode'].'</td>
<td width="20%"></td>';
if($studentfees['challan_no']!="")
{
$html.='
<td width="20%"><b>&nbsp;&nbsp;Challan No. :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$studentfees['challan_no'].'</td>';
}else { 
	
	$html.='
<td width="20%"></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;"></td>';
	} 
	$html.='
</tr>
<tr>';
if($bank['name'])
{
$html.='
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Bank:</b></td>
<td width="20%" >'.$bank['name'].'</td>';
}else { 
	
	$html.='
<td width="20%" style="border-left: 1px solid #d1d1d1;"></td>
<td width="20%" ></td>';
	}
$html.='</tr>
<tr>
<td width="100%" align="center" style="line-height:20px;   border-left:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"></td>
</tr>
<tr>

<td width="70%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1; border-bottom:1px solid #d1d1d1;  "></td><td width="30%" align="center" style="line-height:20px; solid #d1d1d1; border-bottom:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">Received by</td>
</tr></table>
';	
	
	
	
}
$html.='
</body>
</html>';

$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
