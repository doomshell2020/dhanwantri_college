<?php
class xtcpdf extends TCPDF
{
}
setlocale(LC_MONETARY, 'en_IN');
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false, true);
$pdf->SetPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->AddPage();
$pdf->SetFont('', '', 9, '', 'false');


$temp = str_replace(array('{logo}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($sitesetting['logo'], $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);
$html .= '
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Result</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html .= '</head>
<body>';
$html .= $temp;
$sessionParts = explode('-', $session[0]);
$shortenedSession = $sessionParts[0] . '-' . substr($session[1], 2);
$html .= '<hr>
<br>
	<h2 style="text-align:center; margin-bottom:0; border:none;">Branch-Wise Monthly Summary Collection Report(' . $shortenedSession . ')</h2>';

$html .= '<table  border="1" align="center" width="100%" cellpadding="2" cellspacing="0" style= "margin:auto">
<tr>
<th style="width:10.1%; padding: 10px;" class="text-center"><b>Branch Name</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>April</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>May</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>June</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>July</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>August</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>September</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>October</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>November</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>December</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>January</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>February</b></th>
<th style="width:7.5%; padding: 10px;" class="text-center"><b>March</b></th>
</tr>';
foreach ($alldata_pdf as $key => $value) {
  $branch_name = explode("_", $key);


  $html .= '<tr>
  <td style="text-align:center;">' . ucfirst($branch_name[1]) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['apr']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['may']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['june']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['july']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['aug']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['sep']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['oct']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['nov']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['dec']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['jan']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['feb']) . '</td>
  <td style="text-align:center;">' . money_format('%!i', $value['mar']) . '</td>
</tr>';
  $april_total += $value['apr'];
  $may_total += $value['may'];
  $june_total += $value['june'];
  $july_total += $value['july'];
  $aug_total += $value['aug'];
  $sep_total += $value['sep'];
  $oct_total += $value['oct'];
  $nov_total += $value['nov'];
  $dec_total += $value['dec'];
  $jan_total += $value['jan'];
  $feb_total += $value['feb'];
  $march_total += $value['mar'];
}
$html .= '<tr>
<td style="color:green">Net Total</td>
<td style="color:green">' . money_format('%!i', $april_total) . '</td>
<td style="color:green">' . money_format('%!i', $may_total) . '</td>
<td style="color:green">' . money_format('%!i', $june_total) . '</td>
<td style="color:green">' . money_format('%!i', $july_total) . '</td>
<td style="color:green">' . money_format('%!i', $aug_total) . '</td>
<td style="color:green">' . money_format('%!i', $sep_total) . '</td>
<td style="color:green">' . money_format('%!i', $oct_total) . '</td>
<td style="color:green">' . money_format('%!i', $nov_total) . '</td>
<td style="color:green">' . money_format('%!i', $dec_total) . '</td>
<td style="color:green">' . money_format('%!i', $jan_total) . '</td>
<td style="color:green">' . money_format('%!i', $feb_total) . '</td>
<td style="color:green">' . money_format('%!i', $march_total) .'</td>
</tr></table>';
// echo $html;die;

$pdf->WriteHTML($html);
ob_end_clean();

echo $pdf->Output('Branch-Wise Monthly Summary Collection Report (' . $shortenedSession . ').pdf');

exit;

