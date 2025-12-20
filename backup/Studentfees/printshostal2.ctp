<?php 
class xtcpdf extends TCPDF {
}
 
   $this->set('pdf', new TCPDF('P','mm','A4'));
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
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html.='</head>
<body>
<table width="100%">
<tr>
<td width="33.3333%"></td>
<td width="33.3333%" align="center">Sri Sai Shikshan Sansthan</td>
<td width="33.3333%" align="right"><table width="100%">
<tr>
<td width="70%"></td>';


$bank=$this->Comman->findbank($studentfees['bank_id']);
if($studentfees['mode']!='Cash'){ 

$html='<td width="30%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">Cheque</a></td>';

}else{
	
$html='<td width="30%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">Cash</a></td>';	
	
	
	
}
$html='</tr>
</table></td>
</tr>
<tr>
<td colspan="3" align="center"><img src="images/L_58839.gif" alt="" border="0" style=" width: 700%; display:block;">
</td>
</tr>

<tr>
<td colspan="3" align="center">Affiliated C.B.S.E. Delhi</td>
</tr>

<tr>
<td>&nbsp; <span style="text-align:left; display:inline-block;">Vishwamitra Marg, Defence Colony <br> &nbsp; Sirsi Road, Jaipur (Rajasthan) 302012</span></td>
<td></td>
<td align="right"><span>Ph. No.: 2246189, 2357844</span> &nbsp;  &nbsp; </td>
</tr>
</table>
<br><br>
<table width="100%" cellspacing="0">
<tr>
<th colspan="4" style=" line-height:22px;font-weight:bold; text-align:center; font-size:16px; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; " height="40px">
Reciept Session:'.$studentfees['acedmicyear'].'
</th>
</tr>

<tr>
<td width="20%" style=" line-height:20px; height:20px;border-left:1px solid #000;">&nbsp; Receipt No.</td>
<td width="40%" style="line-height:20px; height:20px;">:&nbsp; '.$studentfees['id'].'</td>
<td width="12%" style="line-height:20px; height:20px;">Date</td>
<td width="28%" style="line-height:20px; height:20px;border-right:1px solid #000;">:&nbsp; '.date('d-m-Y',strtotime($studentfees['paydate'])).'&nbsp;</td>
</tr>
<tr>
<td width="20%" style="line-height:20px; height:20px;border-left:1px solid #000;">&nbsp; Name</td>
<td width="40%" style="line-height:20px; height:20px;"><p  style="text-transform:uppercase;">: '.$students['fee_submittedby'].'</p></td>
<td width="12%" style="line-height:20px; height:20px;">Class</td>
<td width="28%" style="line-height:20px; height:20px;border-right:1px solid #000; text-transform:uppercase;">:&nbsp; '.$students['class']['title'].'</td>
</tr>
<tr>';

$n="Pupil's Name";
$html='<td width="20%" style="border-left:1px solid #000;line-height:20px; height:20px;">&nbsp;'.$n.' </td>
<td width="40%" style="text-transform:uppercase;line-height:20px; height:20px;">:&nbsp;'.$students['fname'].' '.$students['middlename'].' '.$students['lname'].'</td>
<td width="12%" style="line-height:20px; height:20px;">SR No.</td>
<td width="28%" style="border-right:1px solid #000;line-height:20px; height:20px;">:&nbsp; '.$students['id'].'</td>
</tr>

<tr>
<td colspan="4" style="padding:0px; ">
<table cellspacing="0" width="100%">
<tr>
<td width="12%" style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; S.No.</td>
<td width="60%"  style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; Particulars</td>
<td width="28%"  style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; text-align:right;">Amount &nbsp; &nbsp; </td>
</tr>';


$count=1; $fees=0; $j=0; foreach($feeheads as $key=>$iteam){
 $rt=$this->Comman->findfeeheadsamount($students['class_id'],$students['acedmicyear'],$iteam['id']);  
 if($studentfees['quarter']=='Quater1'){
	 
	 $fees=$rt[0]['qu1_fees'];
 }elseif($studentfees['quarter']=='Quater2'){
	 
	 $fees=$rt[0]['qu2_fees'];
	 
	 }elseif($studentfees['quarter']=='Quater3'){
	 
	 $fees=$rt[0]['qu3_fees'];
	 }else{
		 
		 $fees=$rt[0]['qu4_fees'];
		 }


$j+=$fees;
if($fees){ 

$html.='

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">'.$count++.'</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  '.$iteam['name'].'</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">'.number_format($fees,2).' &nbsp; &nbsp; </td>
</tr>'; 
}

}



$html.='<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>
<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>
<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right; border-top:1px solid #000;" colspan="2">Total Fees Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right; border-top:1px solid #000;">'.number_format($j,2).' &nbsp; &nbsp; </td>
</tr>


<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(+)Late Fees Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
</tr>

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Due Amount Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
</tr>';

$discount_fees=$studentfees['discount'];
if($discount_fees>0){
	$netamount =$j/100*$discount_fees; $remain=$j-$netamount;
	$html.='
<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Discount: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">'.number_format($netamount,2).' &nbsp; &nbsp; </td>
</tr>';


}

	$html.='<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Additonal Discount (if any): &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp;&nbsp;  </td>
</tr>';



if($remain!=''){ 
$html.='<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">'.number_format($remain,2).' &nbsp; &nbsp;  </td>
</tr>';
}else{
	
$html.='<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">'.number_format($j,2).'&nbsp; &nbsp;  </td>
</tr>';	
	
	
}
$html.='<tr>
<td colspan="3" style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000;">&nbsp;  
Twenty Thousand Only 
</td>
</tr>

<tr>
<td colspan="3" style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">';

$bank=$this->Comman->findbank($studentfees['bank_id']);
if($studentfees['mode']!='Cash'){ 

$html='&nbsp; <span>Paid by Chq.No.: '.$studentfees['cheque_no'].' Dt:'.date('d-m-Y',strtotime($studentfees['paydate'])).' '.$bank['name'].'<br>';


}
$html='&nbsp;  Next Due on 10, Apr after Due Date Rs. 0 per day fine will be charged. Amount once deposited will not be refunded<br> &nbsp; Remarks:
</span>
</td>
</tr>

<tr>
<td colspan="3" style="text-align:right;line-height:20px; height:20px;">
Recievers Signature &nbsp;  &nbsp; 
</td>
</tr>
 </table>
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
