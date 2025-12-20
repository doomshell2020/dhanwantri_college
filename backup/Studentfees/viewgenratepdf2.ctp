<?php 
class xtcpdf extends TCPDF {
 
}
 
   $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
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
<td width="15%" style="border-bottom: 1px solid #d1d1d1;border-top: 1px solid #d1d1d1; border-left: 1px solid #d1d1d1; height:50px;"><img src="images/L_58839.gif" alt="" border="0" style=" width: 700%; display:block;"></td>
<td width="85%" style=" border-bottom: 1px solid #d1d1d1; border-top: 1px solid #d1d1d1; border-right: 1px solid #d1d1d1;  height:50px;">
<b style="font-size:18px; text-align:left;">Rudrasoftech</b><br>
B-56, First Floor, Sardar Patel Mall, Nr. Diamond Mill, Nikol Gam Road, Bapunagar, Ahmedabad-382350,<br>Gujrat, India
</td>
</tr>

<tr>
<td width="100%"  align="center" style="line-height:20px;"><b>Fees Receipt</b><br></td>
</tr>
</table>

<table width="100%">
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Student No.:</b></td>
<td width="20%">3</td>
<td width="20%"></td>
<td width="20%"><b>Receipt Date:</b></td>
<td width="20%" style="border-right: 1px solid #d1d1d1;">08/03/2017</td>
</tr>
<tr>
<td width="20%" style="border-left: 1px solid #d1d1d1;"><b>&nbsp;&nbsp;Name:</b></td>
<td width="20%">Corey Anderson</td>
<td style="border-right: 1px solid #d1d1d1;" colspan="3"></td>
</tr>

<tr>
<td style="border-left: 1px solid #d1d1d1;" width="20%"><b>&nbsp;&nbsp;Course:</b></td>
<td width="20%">Preschool</td>
<td style="border-right: 1px solid #d1d1d1;" colspan="3"></td>
</tr>

<tr>
<td style="border-left: 1px solid #d1d1d1;" width="20%"><b>&nbsp;&nbsp;Batch:</b></td>
<td width="20%">Kindergarten1</td>
<td width="20%"></td>
<td width="20%"><b>Section:</b></td>
<td style="border-right: 1px solid #d1d1d1;" width="20%">KG1-Section1</td>
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
<td align="center" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">School Fees</td>
<td align="center" width="40%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">7000.00</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td align="center" width="10%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">2</td>
<td align="center" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">Exam Fees</td>
<td align="center" width="40%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;">1000.00</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td align="center" width="10%" style="border-left:1px solid #d1d1d1; border-top:1px solid #d1d1d1;   border-bottom:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"></td>
<td align="center" width="48%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;"><b>Total Fees</b></td>
<td align="center" width="40%" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;"><b>8000.00</b></td>
<td width="1%"></td>
</tr>

</table>

<table width="100%">
<tr>
<td width="100%" align="left" style="line-height:20px; border-left:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;"><b>&nbsp;&nbsp;Fees Details</b></td>
</tr>
</table>

<table width="100%" style="   border-left:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;   border-right:1px solid #d1d1d1;">
<br>
<tr>
<td width="1%"></td>
<td width="5%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-left:1px solid #d1d1d1;"><b>#</b></td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Receipt<br>No.</b></td>
<td width="18%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Payment Date</b></td>
<td width="15%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Payment<br>Type</b></td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Payment<br>Mode</b></td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Cheque<br>No.</b></td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Bank<br>Name</b></td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Bank<br>Branch</b></td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;"><b>Amount</b></td>
<td width="1%"></td>

</tr>

<tr>
<td width="1%"></td>
<td width="5%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1; border-bottom:1px solid #d1d1d1;  border-left:1px solid #d1d1d1;">1</td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">35</td>
<td width="18%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">08/03/2017</td>
<td width="15%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">Genral</td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">Cash</td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">-</td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">-</td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">(not set)</td>
<td width="10%" align="center" style=" border-top:1px solid #d1d1d1; border-right:1px solid #d1d1d1;  border-bottom:1px solid #d1d1d1;">1000.00</td>
<td width="1%"></td>

</tr>
<tr>
<td colspan="11" style="height:15px"></td>
</tr>
</table>
</body>
</html>';
//echo $html ; die;
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
