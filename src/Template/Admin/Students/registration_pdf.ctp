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
//pr($prospectus_data); die;

$html='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>student-erp</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
 </head>

<body style=" font-family:"Trebuchet MS", Arial, Helvetica, sans-serif">

<div id="pageContainer1" style="width:992px; margin:auto;background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.4);
-moz-box-shadow: 0 0 10px rgba(0,0,0,0.4);
-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.4);
-o-box-shadow: 0 0 10px rgba(0,0,0,0.4); padding:30px;">


<table width="100%" border="0" style="border:none">
<tr border="0" style="border:none">
<td border="0" class="lg" style=" width:10%; border:none"><img src="images/L_58839.gif" alt="logo"></td>

<td border="0" style=" width:90%; font-size:15px; border:none"><strong style=" margin:6px 0; color:#5d5a50;">Sanskar School</strong><br>
<small style="color:#5d5a50; font-weight:400;">Senior Secondary English Medium Co-Educational School<br>
(An ISO 9001 : 2000 Certified School) Affiliated to CBSE, New Delhi, Aff. No. 1730236<br>
117-121, Vishwamitra Marg, Hanuman Nagar Ext., Sirsi Road, Jaipur - 302012
 </small>
</td>
</tr>
</table>
<hr style="color:#ccc">
<br><br>
<p style="font-size:12px; text-align:left;">No. &nbsp;'.$prospectus_data['id'].'</p>
<h2 style="font-size:24px; text-align:center;">APPLICATION FOR REGISTRATION</h2>
<p>To<br>The Principal<br><br>Dear Sir/Madam,<br>Please register my ward on your wating list as per particulars given below , which I certify<br>are true and correct. If my ward is selected, I agree to fully abide by the rules and<br>regulations of the school, Pay the fee in advance and settle any other accounts promptly.</p>

<table width="100%">
<tr>
<td width="75%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">NAME OF THE PUPIL(IN FULL)........................................</td>


</tr>

<tr>
<td width="75%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">CLASS:.................. <b></b></td>

<td width="25%"  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;">SEX: &nbsp;MALE&nbsp;( )&nbsp;&nbsp;&nbsp;&nbsp;FEMALE&nbsp;( ) <b></b></td>
</tr>
<tr>
<td width="50%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">DATE OF BIRTH:.................. <b></b></td>

<td width="50%"  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;">PLACE OF BIRTH:................................. <b></b></td>
</tr>

<tr>
<td width="100%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">DATE OF BIRTH(IN WORDS):.................. <b></b></td>


</tr>

<tr>
<td width="50%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">NATIONALITY:.................. <b></b></td>
<td width="50%"  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;">MOTHER TONGUE:................................. <b></b></td>


</tr>
<tr>
<td width="100%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">FATHERS NAME:.................. <b></b></td>


</tr>
<tr>
<td width="50%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">QUALIFICATION:.................. <b></b></td>
<td width="50%"  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;">OCCUPATION:................................. <b></b></td>


</tr>
<tr>
<td width="100%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">MOTHER/GUARDIANS NAME:.................. <b></b></td>


</tr>
<tr>
<td width="50%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">QUALIFICATION:.................. <b></b></td>
<td width="50%"  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;">OCCUPATION:................................. <b></b></td>


</tr>
<tr>
<td width="100%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">PHONE NUMBER&nbsp;&nbsp;&nbsp;&nbsp;(Mother).................. <b></b></td>


</tr>
<tr>
<td width="100%" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">PHONE NUMBER&nbsp;&nbsp;&nbsp;&nbsp;(Father).................. <b></b></td>


</tr>


</table>








</tr>
</table>
</div>

<!------------------Student History ends------------------------->

</div>

</body>
</html>';

$pdf->WriteHTML($html);
ob_end_clean();
echo $pdf->Output('tc.pdf');

exit();

?>
