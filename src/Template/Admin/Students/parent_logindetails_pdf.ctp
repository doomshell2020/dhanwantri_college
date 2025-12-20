<?php 
class xtcpdf extends TCPDF {
}
 //$subject=$this->Comman->findexamsubjectsresult($students['id'],$students['section']['id'],$students['acedmicyear']);

   $this->set('pdf', new TCPDF('P','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
//$pdf->setHeaderMargin(0);

// set margins
//$//pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
 $pdf->SetAutoPageBreak(TRUE, 32);
//$pdf->SetMargins(0, 25, 0, true);

$pdf->SetFont('', '', 8, '', 'true');
TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);

$i=1;




$html .='
<h3 style="text-align:center;">Parent Login Details</h3>
<table cellspacing="0" cellpadding="7" style="font-size:9px;">
  <thead>
    <tr>

      <th width="10%" style="border:1px solid #333; border-right:none;"><strong>S.No</strong></th>
      <th width="17%" style="border:1px solid #333; border-right:none;"><strong>Student Name</strong></th>
      <th width="20%" style="border:1px solid #333; border-right:none;"><strong>Father Name</strong></th>
      <th width="20%" style="border:1px solid #333; border-right:none;"><strong>Mobile</strong></th>
      <th width="13%" style="border:1px solid #333; border-right:none;"><strong>Password</strong></th>
      <th width="10%" style="border:1px solid #333; border-right:none;"><strong>Class</strong></th>
      <th width="10%" style="border:1px solid #333; border-right:none;"><strong>Section</strong></th>
    </tr>
    <tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>

  </tr>

  </thead>
  <tbody>';
  foreach($parentpdf as $value){
    $html .='
    <tr>
      <th width="10%" style="border:1px solid #333; border-right:none;">'.$i.'</th>
      <td width="17%" style="border:1px solid #333; border-right:none;">'.$value['fname'].'</td>
      <td width="20%" style="border:1px solid #333; border-right:none;">'.$value['fathername'].'</td>
      <td width="20%" style="border:1px solid #333; border-right:none;">'.$value['mobile'].'</td>
      <td width="13%" style="border:1px solid #333; border-right:none;">'.$value['password'].'</td>
      <td width="10%" style="border:1px solid #333; border-right:none;">'.$value['classtitle'].'</td>
      <td width="10%" style="border:1px solid #333; border-right:none;">'.$value['sectiontitle'].'</td>
    </tr>
    
    <tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>

  </tr>
    
    ';
    $i++;
   }

$html .='
  </tbody>
</table>';




$pdf->writeHTMLCell(0, 0, '', '', utf8_encode($html), 0, 1, 0, true, '', true);
//$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Parent Login Details.pdf');
exit;
?>