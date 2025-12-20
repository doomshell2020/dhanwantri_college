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
<body style="color:#333;">

<table width="100%">

<tr><td style="text-align:center"><img src="images/L_58839.gif" alt="" border="0" style=" width: 700%; display:block;"></td></tr>
<tr><td style="text-align:center; font-size:10px; color: #000; font-style:italic;"><p style="text-transform:capitalize;">affilited to centeral board of secondary education , delhi , affilitaion no : 1730236<br>
vishwamitra marg , sirsi road , jaipur-302012 | phone:0141-2246189, 2357844 | fax:2245602<br>
e-mail:info@sanskarjaipur.com | website:www.sanskarjaipur.com
</p></td></tr>
</table>

<table width="100%">
<tr><td colspan="5" align="center"><h1 style="font-size:20px;">PROGRESS REPORT</h1></td></tr>

<tr style=" line-height:20px;"><td colspan="5" align="center"><h3 style="font-size:16px;">Session 2017-2018</h3></td></tr>

<tr style=" line-height:20px;">
<td width="20%" rowspan="4" style="text-align:center; line-height:100px;"><img src="images/L_58839.gif" alt="" border="0" style=" width: 700%; display:block;"></td>
<td width="15%" style="font-weight:bold;">Name:</td>
<td width="30%">SHANTANU KUMAR DUDI</td>
<td width="15%" style="font-weight:bold;">Class:</td>
<td width="20%">X1-SCIENCE-F</td>
</tr>
<tr style=" line-height:20px;">

<td width="15%" style="font-weight:bold;">Mothers name:</td>
<td width="30%">USHA RANI DUDI</td>
<td width="15%" style="font-weight:bold;">House</td>
<td width="20%">RIG</td>
</tr>
<tr style=" line-height:20px;">

<td width="15%" style="font-weight:bold;">Fathers name:</td>
<td width="30%">CHANDRA PRAKESH DUDI</td>
<td width="15%" style="font-weight:bold;">Date of Birth</td>
<td width="20%">08/09/2001</td>
</tr>
<tr style=" line-height:20px;">

<td width="15%" style="font-weight:bold;">Reg No:</td>
<td width="30%">5854</td>
<td width="15%" style="font-weight:bold;">Roll No</td>
<td width="20%">11208</td>
</tr>


</table>


<h2 style=" line-height:20px; text-align:center;">SCHOLASTIC PROGRESS</h2>

<table width="100%" border="1px;" style="text-align:center; line-height:20px;">
<tr>
<td width="5%"  height="30px" rowspan="2" style="font-weight:bold;"><div style="line-height:10px;">s.</div><div style="line-height:5px;">No</div></td>
<td width="18%"  height="30px" rowspan="2" style="font-weight:bold;">SUBJECT</td>
<td width="6%" height="30px" rowspan="2" style="font-weight:bold;">
<div style="line-height:20px;">IA-1</div><div style="line-height:0px;"> 50</div></td>
<td width="14%"  height="30px" height="30px"style="font-weight:bold;"><div style="line-height:20px;">SAM-1</div><div style="line-height:0px;"> 100</div></td>
<td width="8%" height="30px" rowspan="2" style="font-weight:bold;"><div style="line-height:20px;">TOTAL</div><div style="line-height:0px;"> 150</div></td>
<td width="6%" height="30px" rowspan="2" style="font-weight:bold;"><div style="line-height:20px;">IA-2</div><div style="line-height:0px;"> 50</div></td>
<td width="14%"  height="30px" style="font-weight:bold;"><div style="line-height:20px;">SAM-2</div><div style="line-height:0px;"> 100</div></td>
<td width="8%"  height="30px"rowspan="2" style="font-weight:bold;"><div style="line-height:20px;">TOTAL</div><div style="line-height:0px;"> 150</div></td>
<td width="15%"  height="30px" rowspan="2" style="font-weight:bold;"><div style="line-height:20px;">GRAND TOTAL</div><div style="line-height:0px;">300</div></td>
<td width="6%"  height="30px" rowspan="2" style="font-weight:bold;">%</td>

</tr>
<tr>


<td><table><tr><td style="border-right:1px solid #000;">Th</td> <td>pr</td></tr></table></td>


<td><table><tr><td style="border-right:1px solid #000;">Th</td> <td>pr</td></tr></table></td>

</tr>

<tr>
<td >1</td>
<td  style="font-weight:bold;">English Core</td>
<td >20</td>
<td><table><tr><td style="border-right:1px solid #000;">30</td> <td>13</td></tr></table></td>
<td>63</td>
<td>20</td>
<td><table><tr><td style="border-right:1px solid #000;">41</td> <td>14</td></tr></table></td>
<td>75</td>
<td>138</td>
<td>46</td>

</tr>

<tr>
<td >1</td>
<td style="font-weight:bold;">Physics</td>
<td >20</td>
<td><table><tr><td style="border-right:1px solid #000;">30</td> <td>13</td></tr></table></td>
<td>63</td>
<td>20</td>
<td><table><tr><td style="border-right:1px solid #000;">41</td> <td>14</td></tr></table></td>
<td>75</td>
<td>138</td>
<td>46</td>

</tr>


<tr>
<td >1</td>
<td style="font-weight:bold;">Chemistry</td>
<td >20</td>
<td><table><tr><td style="border-right:1px solid #000;">30</td> <td>13</td></tr></table></td>
<td>63</td>
<td>20</td>
<td><table><tr><td style="border-right:1px solid #000;">41</td> <td>14</td></tr></table></td>
<td>75</td>
<td>138</td>
<td>46</td>

</tr>

<tr>
<td >1</td>
<td style="font-weight:bold;">Mathematic</td>
<td >20</td>
<td><table><tr><td style="border-right:1px solid #000;">30</td> <td>13</td></tr></table></td>
<td>63</td>
<td>20</td>
<td><table><tr><td style="border-right:1px solid #000;">41</td> <td>14</td></tr></table></td>
<td>75</td>
<td>138</td>
<td>46</td>

</tr>

<tr>
<td >1</td>
<td style="font-weight:bold;">Physical Education</td>
<td >20</td>
<td><table><tr><td style="border-right:1px solid #000;">30</td> <td>13</td></tr></table></td>
<td>63</td>
<td>20</td>
<td><table><tr><td style="border-right:1px solid #000;">41</td> <td>14</td></tr></table></td>
<td>75</td>
<td>138</td>
<td>46</td>

</tr>


<tr>

<td colspan="2" style="font-weight:bold;">TOTAL</td>
<td ></td>
<td><table><tr><td style="border-right:1px solid #000;"></td> <td></td></tr></table></td>
<td>290</td>
<td></td>
<td><table><tr><td style="border-right:1px solid #000;"></td> <td></td></tr></table></td>
<td>237</td>
<td>516</td>
<td></td>

</tr>

<tr>

<td colspan="2" style="font-weight:bold;">TOTAL%</td>
<td ></td>
<td><table><tr><td style="border-right:1px solid #000;"></td> <td></td></tr></table></td>
<td>29%</td>
<td></td>
<td><table><tr><td style="border-right:1px solid #000;"></td> <td></td></tr></table></td>
<td>23%</td>
<td>51%</td>
<td></td>

</tr>


<tr>

<td colspan="2" style="font-weight:bold;">ATTENDANCE</td>
<td ></td>
<td><table><tr><td style="border-right:1px solid #000;"></td> <td></td></tr></table></td>
<td>100/110</td>
<td></td>
<td><table><tr><td style="border-right:1px solid #000;"></td> <td></td></tr></table></td>
<td>100/108</td>
<td>200/218</td>
<td></td>

</tr>



</table>
<br><br> <br><br>

<table width="100%" border="1px">
<tr><td colspan="3" height="70px" style=" text-align:left; line-height:25px; font-size:12px; font-weight:bold;">&nbsp;&nbsp;REMARKS:</td></tr>
<tr><td colspan="3" height="30px" style=" text-align:left; line-height:25px; font-size:12px;font-weight:bold;">&nbsp;&nbsp;FINAL RESULT:</td></tr>
<tr>
<td style=" text-align:center;line-height:15px; font-size:10px;">&nbsp;Class Teacher Signature</td>
<td style=" text-align:center;line-height:15px; font-size:10px;">&nbsp;Principal Signature</td>
<td style=" text-align:center;line-height:15px; font-size:10px;">&nbsp;Parent Signature</td>
</tr>
<tr>
<td height="20px" style=" text-align:left;"></td>
<td height="20px" style=" text-align:left;"></td>
<td height="20px" style=" text-align:left;"></td>
</tr>

</table>
<p style=" text-align:left; font-weight:bold;">Date:</p>

</body>
</html>';
//echo $html; die;
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
