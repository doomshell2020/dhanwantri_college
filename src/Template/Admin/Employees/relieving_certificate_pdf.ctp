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

/*++++++++++++++++++++++++++++++++++++++++++
**      Processing data for pdf view
**++++++++++++++++++++++++++++++++++++++++++
*/
$name = $student['fname'].' ';

if( !empty( $student['middlename'] ) )
	$name .= $student['middlename'].' ';

$name .= $student['lname'];


$dateapplication=date('d M Y',strtotime($student['date_application']));
$relevingdate=date('d M Y',strtotime($student['relevingdate']));



$html='<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Result</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html.='</head>
<body>
<table width="100%" align="left">
<tr>
<td style="text-align:left" width="50%" >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/logo.png" alt="" border="0" style="display:block;" 
width="130px" height="60px;"><br>
<span style="display:block; color:#000; font-size:8px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>(An ISO 
9001:2000 Certified School)<br>Affiliated to CBSE Delhi (Affiliation 
no.1730236)</u></span>
</td>

<td style="text-align:left;" width="50%" align="right"><br><br>
Vishwamitra Marg, Near Hanuman Nagar 
Ext.,<br>&nbsp;&nbsp;&nbsp;&nbsp;Sirsi Road, Jaipur-302012&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
Phone 
 : &nbsp;2246189,2357844 &nbsp;&nbsp;&nbsp;&nbsp;Fax :-  
0141-2245602<br>&nbsp;&nbsp;&nbsp;&nbsp;Email 
: <u>
info@sanskarjaipur.com,</u><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Website : www.sanskarjaipur.com
</td>


</tr>




</table>


<table  border="0"  align="center">
<hr>
<tr style="line-height:60px;">

<td style="text-align:left;font-size:12px;" width="30%" align="left"><b>No. :'.$session.' / '.$student['sno'].'
</b></td>
<td style="text-align:center;" width="40%" align="center"></td>
<td style="text-align:right;font-size:12px;" width="30%" align="right"><b>Date: 
- '.date('d-m-Y').'</b></td>

   </tr> 
  
<tr style="line-height:40px;">
<td style="text-align:left;font-size:12px;" width="30%" align="left"></td>
<td style="text-align:center;font-size:17px;" width="40%" align="center"><b><u>OFFICE ORDER</u></b></td>
 
<td style="text-align:right;font-size:12px;" width="30%" align="right"></td>

 
   </tr> 
<tr>
<p align="left" style="font-size:13px;line-height:22px;">This has reference to Mr./Mrs. <b>'.ucwords(strtolower($name)).'</b> letter of resignation dated <b>'.$dateapplication.'</b> ,We would like to inform you that your resignation is hereby accepted and you are being relieved in the afternoon / forenoon of <b>'.$relevingdate.'</b>.<br>
Your Contribution to the school organization and its success will always be appreciated ,Wish you all the best in your future endeavours.
</p>
</tr>
<br>

<br><br>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%"></td>
</tr>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%"></td>
</tr>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="80%"><b>PRINCIPAL</b></td>
<td style="color:#000; font-size:12px; text-align:center; height:25px;" width="20%"><b>RECEIVED</b></td>
</tr>

<p align="left" style="font-size:13px;line-height:30px;"> Copy issued for the information and necessary proceeding.

</p>
<ul style="font-size:11px;line-height:15px;"><li>Mr./Mrs. <b>'.ucwords(strtolower($name)).'</b> handling over the charge to Mr./Mrs. Deepika Banerjee / Alok Saxena for submitting <br><b> NO DUES CERTIFICATE</b> to Office.</li>
<li>The Principle</li>
<li>The Director (Finance)</li>
<li>Establishment Section</li>
<li>Accounts Section</li>
<li>Mrs. Deepika Banerjee</li>
<li>Mr. Alok Saxena</li>

</ul>

</table>


</div>

</body>
</html>';
$pdf->SetFont('times', '', 10, '', 'false');
$pdf->WriteHTML($html);
ob_end_clean();
echo $pdf->Output('Office_Order.pdf');

exit();

?>
