<?php 

class xtcpdf extends TCPDF
{

}

$this->set('pdf', new TCPDF('P', 'mm', 'A4'));
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
$name = $student['fname'] . ' ';

if (!empty($student['middlename'])) {
    $name .= $student['middlename'] . ' ';
}

$name .= $student['lname']; 
if (trim($student['gender']) == "male") {
    $g1 = "Mr.";
    $g2 = "SON";
    $g3 = "his";
} else if (trim($student['gender']) == "female") {
    $g1 = "Ms.";
    $g2 = "DAUGHTER";
    $g3 = "her";
}
$father_name = $student['fathername'];
$cc_issue_date = date('d-m-Y', strtotime($student['date_issue']));
$session = $student['acedmicyear'];
$class = $student['class']['title'];
$charctercertificate = $student['charctercertificate'];
// $temp = str_replace(array('{logo}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($sitesetting['logo'], $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);

$html = '<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Result</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html .= '</head>
<body>';
$html .= '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

$html .= '<table  border="0"  align="center">
<hr>
<tr style="line-height:40px;">

<td style="text-align:left;font-size:10px;" width="30%" align="left"></td>
<td style="text-align:center;" width="40%" align="center"></td>
<td style="text-align:right;font-size:11px;" width="30%" align="right"><b>Date:- ' . date('d-m-Y') . '</b></td>
</tr>
<tr style="line-height:10px;">
 <td align="center" colspan="8" style="font-size:17px;" ><b><u>CHARACTER CERTIFICATE</u></b></td>
   </tr>';

if ($student['board_id'] != 1) {

    $html .= '<tr>
<p align="left" style="font-size:16px;line-height:30px;">This is to certify that <b>' . $g1 . ' ' . ucwords(strtolower($name)) . '</b>' . $g2 . ' <b>' . ucwords(strtolower($father_name)) . '
</b>, appeared for International Baccalaureate Diploma Programme (2017-2019) as a regular student of this school. As per the school records ' . $g3 . ' bears a ' . $charctercertificate . '.
</p>

</tr>';

} else { 
    $html .= '<tr>
<p align="left" style="font-size:16px;line-height:30px;">This is to certify that ' . $g1 . ' <b>' . strtoupper($name). '</b>, ' . $g2 . ' of <b>' . strtoupper($father_name) . ' </b>, was a regular student of our school for the session <b>' . $session . '</b> and passed (<b>CLASS ' . strtoupper($class) . '</b>). During this period at the school ' . $g3 . ' conduct and behavior was ' . $charctercertificate . '.
</p>

</tr>';

}

$html .= '<br>


<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%"></td>
</tr>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%"><b>PRINCIPAL</b></td>
</tr>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%"><b>KIDS CLUB SCHOOL</b></td>
</tr>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%">Mansarovar, Jaipur</td>
</tr>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%">School Code 10979</td>
</tr>

</table>


</div>

</body>
</html>';
$pdf->SetFont('times', '', 10, '', 'false');
$pdf->WriteHTML($html);
ob_end_clean();
echo $pdf->Output('Result');

exit();
