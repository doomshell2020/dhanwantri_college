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

<table width="100%" align="center">
<tr>
<td style="text-align:left" width="30%" >
<img src="images/schoolaward.png" alt="" border="0" style="display:inline-block;">
</td>
<td width="10%"></td>
<td style="text-align:center" width="20%" align="center">
<img src="images/sanskarlogoresult.png" alt="" border="0" style="display:inline-block;">
</td>
<td width="10%"></td>
<td style="text-align:right; line-height:60px;" width="30%" align="right">
<img src="images/cbse-logo.png" alt="" border="0" style="display:inline-block;">
</td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%" align="center">
<p style="color:#7fb1e4; text-align:center; font-size:10px;"> Affiliation No : 1730236<br>
Vishwamitra Marg , Hanuman Nagar Ext, Sirsi Road , Jaipur-302012<br>
E-Mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com<br>
 Phone:0141-2246189, 2357844 | Fax:2245602</p>
</td>
</tr>
<br>
<tr>
<td colspan="5" align="center">
<h2>
Academic Session: 2017-2018<br>
First Term Report Card For  Class 6<sup>th</sup>A
</h2>
</td>
</tr>
</table>
<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:12px; font-weight:bold; text-transform:uppercase;">Student Profile</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="80%" style="border-top:1px solid #000; border-left:1px solid #000;  border-bottom:1px solid #000;">
<table width="100%">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; Sr. No.
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
5669
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
Students Name
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
Vishnu Sharma
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Fathers Name
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
Sunil Sharma
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
Mothers Name
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
Shanti Sharma
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Date of Birth
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
12-08-2016
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
Class/ House
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase;" width="30%">
VI-A/ SAM
</td>
</tr>
</table>

</td>
<td width="20%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; text-align:center;" headers="100px">
<img src="images/banner.png" alt="" border="0" style="display:block; " height="60px" width="60px">
</td>
</tr>

</table>

<br><br>
<table width="100%">
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:12px; font-weight:bold; text-transform:uppercase;">Scholastic Areas</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000;  height:38px; line-height:38px;  border-right:1px solid #000;  font-weight:bold; " align="left">&nbsp; Subject Name</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Periodic<br>Test<br>(10)</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Notebook<br>Submission<br>(5)</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Subject<br>Enrichment<br>(5)</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">First Term<br>Examission<br>(80)</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Marks<br>Obtained<br>(100)</td>
<td width="12%" style="border-top:1px solid #000;  font-weight:bold; border-right:1px solid #000;" align="center">Grade</td>
</tr>

<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; English</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">9</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">64.5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">83.5</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A2</td>
</tr>

<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Hindi</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">9.75</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">71.5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">91.25</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A1</td>
</tr>

<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Mathematics</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">9.75</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">69</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">88.75</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A2</td>
</tr>

<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Science</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">9.13</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">70</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">89.13</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A2</td>
</tr>

<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Social Studies</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">9.75</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">4</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">67</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">85.75</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A2</td>
</tr>

<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Sanskrit</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">9.75</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">78.5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">98.25</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A1</td>
</tr>

<tr>
<td width="28%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Computer Seince</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">10</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">5</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">80</td>
<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">100</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A1</td>
</tr>

<tr>
<td width="76%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  font-weight:bold;" align="left">&nbsp; Genral Knowledge</td>

<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center" colspan="2">A1</td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">A1</td>
</tr>

<tr>
<td width="88%" align="center" style="border-top:1px solid #000;"><h3 style=" font-weight:bold;  height:15px; line-height:15px; text-transform:uppercase; font-size:10px;">Overall Grade</h3></td>


<td width="12%" style="border-top:1px solid #000;  height:15px; font-weight:bold; line-height:15px;" align="center">A2</td>
</tr>
</table>
<br><br>
<table width="100%">

<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:12px; font-weight:bold; text-transform:uppercase;">Co-Scholastic Areas</h2></td>
</tr>
</table>

<table width="100%">
<tr>
<td style="border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">
<table width="100%">
<tr>
<td style="height:15px;  font-weight:bold; line-height:15px;   text-transform:uppercase;" width="30%">
&nbsp; Work Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase;" width="30%">
Working Days
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
91
</td>


</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
&nbsp; Art Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
Days Attended
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
89
</td>


</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
&nbsp; Health & Physical Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase;" width="30%">
Regularly
</td>

<td style="height:15px; line-height:15px; line-height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A
</td>


</tr>


<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase;" width="30%">
&nbsp; Discipline
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase;" width="20%">
A
</td>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase;" width="30%">

</td>

<td style="height:15px; line-height:15px; line-height:15px; line-height:15px; text-transform:uppercase;" width="20%">

</td>


</tr>



</table>

</td>
</tr>

</table>
<br><br>

<table width="100%">
<tr>
<td width="60%" align="left" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">&nbsp; Class Teacher Remarks</td>

<td width="40%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">
<table width="100%">
<tr>
<td width="1%"></td>
<td width="33%" align="left" style=" font-weight:bold;">Marks-Range</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-weight:bold;">Grade</td>
<td width="2%"></td>
<td width="33%" align="left" style=" font-weight:bold;">Marks-Range</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-weight:bold;">Grade</td>
<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left">Outstanding</td>
<td width="1%"></td>
<td width="12%" align="left">A</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left">Outstanding</td>
<td width="1%"></td>
<td width="12%" align="left">A</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left">Outstanding</td>
<td width="1%"></td>
<td width="12%" align="left">A</td>
<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left"></td>
<td width="1%"></td>
<td width="12%" align="left"></td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left"></td>
<td width="1%"></td>
<td width="12%" align="left"></td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left"></td>
<td width="1%"></td>
<td width="12%" align="left"></td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left"></td>
<td width="1%"></td>
<td width="12%" align="left"></td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left">91-100</td>
<td width="1%"></td>
<td width="12%" align="left">A1</td>
<td width="2%"></td>
<td width="35%" align="left"></td>
<td width="1%"></td>
<td width="12%" align="left"></td>
<td width="1%"></td>
</tr>


</table>
</td>
</tr>
</table>


<table width="100%">
<tr><br><br><br><br>
<td width="33.333%" align="center" >
Class Teachers Signature
</td>

<td width="33.333%" align="center" >
Principals Signature
</td>

<td width="33.333%" align="center" >
 Directors Signature
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
