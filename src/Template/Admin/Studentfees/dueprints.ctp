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
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';

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
iDS PRIME
</small><br>
<span style="display:block; color:#000; font-size|:10px;">A3 Mall Road Near Radhey Bakers,
Vidhyadhar Nagar, Jaipur 
Pincode: 302039
+91-0141-3222221
9414431944</span>
<br><br>
<span style="display:block; color:#000; font-size|:10px;">Phone No.:&nbsp;0141-2469323</span><br>
<span style="display:block; color:#000; font-size|:10px;">Email id.:&nbsp;admin@gmail.com</span><br>
<span style="display:block; color:#000; font-size|:10px;">Website:&nbsp;http://schoolerp-jpr.in/</span>
</td>
</tr>

<tr>
<td width="100%"  align="center" style="line-height:20px;"><b>Fees Receipt</b><br>( Previous Due Fees )</td>
</tr>
</table>

<table width="100%">
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Student ID :</b></td>
<td width="20%">'.$stdnt['student_id'].'</td>
<td width="20%"></td>
<td width="20%"><b>Receipt No. :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$stdnt['id'].'</td>

</tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Name:</b></td>
<td width="20%">'.$stdnt['student']['fname'].' '.$stdnt['student']['middlename'].' '.$stdnt['student']['lname'].'</td>
<td width="20%"></td>
<td width="20%"><b>Payment Date :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$stdnt['paydate'].'</td>

</tr>



<tr>
<td style="border-left: 1px solid #d1d1d1;" width="20%"><b>&nbsp;&nbsp;Father name:</b></td>
<td width="20%">'.$stdnt['student']['fathername'].'</td>
<td width="20%"></td>
<td width="20%"></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;"></td>

</tr>


<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"><b>Fees Details</b></td>
</tr>
</table>

<table width="100%" style="   border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">

<tr>
<td width="1%"></td>
<th align="center" width="10%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>#</b></th>
<th align="center" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Fees Detail</b></th>
<th align="center" width="40%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Amount</b></th>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td align="center" width="10%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">1</td>
<td align="center" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">Previous Due Fees</td>
<td align="center" width="40%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">'.$stdnt['due_fees'].'</td>
<td width="1%"></td>
</tr>



<tr>
<td width="1%"></td>
<td align="center" width="10%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"></td>
<td align="center" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;"><b>Total Fees</b></td>
<td align="center" width="40%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;"><b>'.$stdnt['due_fees'].'</b></td>
<td width="1%"></td>
</tr>

</table>';

if($stdnt['mode']!='Cash'){ 

$html.='
<table width="100%">
<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"></td>
</tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Mode:</b></td>
<td width="20%">'.$stdnt['mode'].'</td>
<td width="20%"></td>
<td width="20%"><b>&nbsp;&nbsp;Challan No. :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$stdnt['challan_no'].'</td>

</tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Bank:</b></td>
<td width="20%" >'.$stdnt['bank']['name'].'</td>


<td width="20%"></td>
<td ><b>&nbsp;&nbsp;Cheque No.:</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$stdnt['cheque_no'].'</td><td width="20%"></td>

</tr>


<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1; "></td>
</tr>

<tr>
<td width="70%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;border-bottom:1px solid #d1d1d1; "></td><td width="30%" align="center" style="line-height:20px; solid #d1d1d1; border-bottom:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">Received by</td>
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
<td width="20%">'.$stdnt['mode'].'</td>
<td width="20%"></td>
<td width="20%"><b>Challan No. :</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$stdnt['challan_no'].'</td></tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1; "><b>&nbsp;&nbsp;Bank:</b></td>
<td width="80%"  style="border-right:1px solid #d1d1d1;" >'.$stdnt['bank']['name'].'</td>';

$html.='</tr>
<tr>
<td width="100%" align="center" style="line-height:20px;   border-left:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"></td>
</tr>
<tr>
<td width="70%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;border-bottom:1px solid #d1d1d1; "></td><td width="30%" align="center" style="line-height:20px; solid #d1d1d1; border-bottom:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">Received by</td>
</tr></table>
';	
	
}




$html.='
</body>
</html>';
//echo $html; die;
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Receipt');
exit;
?>



?>
