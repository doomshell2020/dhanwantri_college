<?php
if ($dbname=='palaceschool') {
$this->element('palaceschool_certificates/palaceschool_bonafide_certificate_pdf');
}else{
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
if (trim($student['gender']) == "Male" || $student['gender'] == "M") {
    $g1 = "Master";
    $g2 = "S/o";
    $g3 = "He";
    $g4 = "His";
} else if (trim($student['gender']) == "Female" || $student['gender'] == "F") {
    $g1 = "Miss";
    $g2 = "D/o";
    $g3 = "She";
    $g4 = "Her";
}
$father_name = $student['fathername'];
$cc_issue_date = date('d-m-Y', strtotime($student['date_issue']));
$session = $student['acedmicyear'];
$class = $student['class']['title'];
$charctercertificate = $student['charctercertificate'];
$temp = str_replace(array('{logo}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($sitesetting['logo'], $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);
$html = '<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Result</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html .= '</head>
<body>';
$html .= $temp;
$html .= '<table  border="0"  align="center">
<hr>
<tr style="line-height:60px;">
<td style="text-align:left;font-size:10px;" width="30%" align="left"><b>Admission No.:- ' . $student['enroll'] . '
</b></td>
<td style="text-align:center;" width="40%" align="center"></td>
<td style="text-align:right;font-size:11px;" width="30%" align="right"><b>Date:
- ' . date('d-m-Y') . '</b></td></tr>
<tr style="line-height:20px;">
 <td align="center" colspan="8" style="font-size:17px;" ><b><u>Bonafide Certificate</u></b></td>
   </tr>
<tr>
<p align="left" style="font-size:16px;line-height:30px;">
Certify that ' . $g1 . ' <b>' . ucwords(strtolower($name)) . '</b> ' . $g2 . ' <b>' . ucwords(strtolower($father_name)) . '
</b> has been a bonafide student of this school. ' . $g3 . ' was a regular student  of Class <b>(' . $class . ')</b> of this school during session <b>' . $session . '</b>. ' . $g4 . ' conduct and character as recorded by the school discipline committee has been satisfactory.
</p>
</tr>
<br>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%"></td>
</tr>
<tr>
<td style="color:#000; font-size:12px; text-align:left; height:25px;" width="100%"><b>PRINCIPAL</b></td>
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

}