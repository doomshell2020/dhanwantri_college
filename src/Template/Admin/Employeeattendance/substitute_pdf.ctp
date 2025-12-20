<?php
class xtcpdf extends TCPDF
{
}

define("MAJOR", 'Rupees Only');
define("MINOR", '');

// create new PDF document
$pdf = new TCPDF('PDF_PAGE_ORIENTATION', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 1);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once dirname(__FILE__) . '/lang/eng.php';
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('', '', 7, '', 'false');

$pdf->SetMargins(5, 2, 5, true);

// add a page
$pdf->AddPage('P', 'A5');
//$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');

$html .= '
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Substitute Report</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';

$date1 = date('d-m-Y', strtotime($date));

$html .= '</head>
<body>
<h2 style="text-align:center; margin-bottom:30px">SUBSTITUTE REPORT(' . $date1 . ')</h2>
<table width="100%" cellspacing="0" >
<tr style="padding-top:15px;">
<th width="7%" style="border:1px solid #000; height:15px; text-align:center; "><b>Sr.No.</b></th>
<th width="7%" style="border:1px solid #000; height:15px; text-align:center;"><b>Class</b></th>
<th width="7%" style="border:1px solid #000; height:15px; text-align:center;"><b>Section</b></th>
<th width="7%" style="border:1px solid #000; height:15px; text-align:center;"><b>Period</b></th>
<th width="20%" style="border:1px solid #000; height:15px; text-align:center;"><b>Name</b></th>
<th width="20%" style="border:1px solid #000; height:15px; text-align:center;"><b>Substitutes Name</b></th>
<th width="20%" style="border:1px solid #000;  height:15px; text-align:center;"><b>SIGN</b></th>
</tr>';
// $timetab = $this->Comman->timetable_id();
$count = 1;
foreach ($sub_det as $chk_sub) {
    $oldEmp_det = $this->Comman->findempname($chk_sub['old_empid']);
    $newEmp_det = $this->Comman->findempname($chk_sub['new_empid']);
    $class = $this->Comman->findclass123($chk_sub['class_id']);
    $section = $this->Comman->findsection123($chk_sub['sec_id']);
    $period = $this->Comman->ttId($chk_sub['timetable_id']);
    $html .= '<tr>
    <td style="border:1px solid #000; height:15px; text-align:center;">' . $count . '</td>
    <td style="border:1px solid #000; height:15px; text-align:center;">' . $class['title'] . '</td>
    <td style="border:1px solid #000; height:15px; text-align:center;">' . $section['title'] . '</td>
    <td style="border:1px solid #000; height:15px; text-align:center;">' . $period['name'] . '</td>
    <td style="border:1px solid #000; height:15px; text-align:center;">' . strtoupper($oldEmp_det['fname']) . "\x20" . strtoupper($oldEmp_det['middlename']) . strtoupper($oldEmp_det['lname']) . '</td>
    <td style="border:1px solid #000; height:15px; text-align:center;">' . strtoupper($newEmp_det['fname']) . "\x20" . strtoupper($newEmp_det['middlename']) . strtoupper($newEmp_det['lname']) . '</td>
    <td style="border:1px solid #000; height:15px; text-align:center;"></td>
    </tr>';
    $count++;
}


$html .= '
 </table>
</body>
</html>';

$pdf->writeHTML($html, true, 0, true, 0);
//ob_end_clean();

// write some JavaScript code
// force print dialog
$js .= 'print(true);';

// set javascript
$pdf->IncludeJS($js);
$pdf->Output('substitute_report.pdf');
exit;