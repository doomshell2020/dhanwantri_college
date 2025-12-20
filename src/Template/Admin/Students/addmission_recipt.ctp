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
<td width="100%"  align="center" style="line-height:25px;"><b>RECEIPT 
SESSION : '.$students['acedmicyear'].' </b><br><b>(Admission Fee)</b></td>
</tr>
</table>



<table width="100%">
<tr>
<td width="15%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Receipt No.</b></td>
<td width="5%">:</td>
<td width="40%">'.$students['id'].'</td>

<td width="15%"><b>&nbsp;&nbsp;Date </b></td>
<td width="5%">:</td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.date('d-m-Y',strtotime($students['created'])).'</td>

</tr>
<tr>
<td width="15%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Name</b></td>
<td width="5%">:</td>
<td width="40%">'.$students['fname'].' '.$students['middlename'].' '.$students['lname'].'</td>
<td ><b>&nbsp;&nbsp;Class</b></td>
<td width="5%">:</td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">'.$students['class']['title'].'</td>
</tr>
<tr>
<td style="border-left: 1px solid #d1d1d1;" ><b>&nbsp;&nbsp;';
$pei="Board";
$html.=$pei.'</b></td>
<td width="5%">:</td>
<td width="40%">'.$brd['name'].'</td>
<td ><b>&nbsp;&nbsp;Sr No.</b></td>
<td width="5%">:</td>
<td width="20%" style="border-right: 1px solid 
#d1d1d1;">'.$students['id'].'</td>
</tr>
<tr>
<td width="100%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"><b>Fees Details</b></td>
</tr>
</table>
<table width="100%" style="border-left:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">
<tr>
<td width="1%"></td>
<th align="center" width="6%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>S.No.</b></th>
<th align="left" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>Particulars</b></th>
<th align="right" width="44%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>Amount</b></th>
<td width="1%"></td>
</tr>';
$total=$admissionfee+$devlopfee+$cautionfee;
$html.='<tr>
<td width="1%"></td>
<td align="center" width="6%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;">1.</td>
<td align="left" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;">Admission Fee</td>
<td align="right" width="44%" style="border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;">'.number_format($admissionfee,2).'</td>
<td width="1%"></td>
</tr>';

$html.='<tr>
<td width="1%"></td>
<td align="center" width="6%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;">2.</td>
<td align="left" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;">Devlopment Fee</td>
<td align="right" width="44%" style="border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;">'.number_format($devlopfee,2).'</td>
<td width="1%"></td>
</tr>';


$html.='<tr>
<td width="1%"></td>
<td align="center" width="6%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;">3.</td>
<td align="left" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;">Caution Fee</td>
<td align="right" width="44%" style="border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;">'.number_format($cautionfee,2).'</td>
<td width="1%"></td>
</tr>';

$html.='<tr>
<td width="1%"></td>
<td align="center" width="6%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  height:20px; line-height:21px;"></td>
<td align="right" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>Total Fees Rs.</b></td>
<td align="right" width="44%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;  height:20px; line-height:21px;"><b>'.number_format($total,2).'</b></td>
<td width="1%"></td>
</tr>';

$html.='</table>';

$html.='
<table width="100%">

<tr>
<td width="100%" align="center" style="line-height:20px;   border-left:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"></td>
</tr>
<tr>

<td width="70%" align="center" style="line-height:20px; border-left:1px solid #d1d1d1;border-bottom:1px solid #d1d1d1; "></td><td width="30%" align="center" style="line-height:20px; solid #d1d1d1; border-bottom:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">Receivers Signature</td>
</tr></table>
';	

$html.='
</body>
</html>';
//echo $html; die;
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Receipt');
exit;
?>
