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
$sitesetting['logo']=SITE_URL."images/".$db."schoolidsprime.png";
$mesg = str_replace(array('{logo}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($sitesetting['logo'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);

$html = '<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Result</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html .= '</head>
<body>';
$html .= $mesg;
$html .= '</body>
</html>';
$pdf->SetFont('times', '', 10, '', 'false');
$pdf->WriteHTML($html);
ob_end_clean();
echo $pdf->Output('Result');

exit();