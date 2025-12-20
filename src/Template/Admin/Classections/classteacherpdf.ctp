<?php 
class xtcpdf extends TCPDF {
 
}


 //$subject=$this->Comman->findexamsubjectsresult($students['id'],$students['section']['id'],$students['acedmicyear']);

   $this->set('pdf', new TCPDF('P','mm','A4'));
$pdf = new TCPDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();



$pdf->SetFont('', '', 9, '', 'false');
//pr($t_enquiry); die;
$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html .= '</head>
<body>';
    $temp = str_replace(array('{logo}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($sitesetting['logo'], $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);

    $html .= $temp;


    $html .= '<table width="100%" border="1" align="center">
<tr>

 <td align="center" colspan="5" ><b>Class Teachers / Co-Class Teachers List</b> 
</td>
    
    </tr>
<tr>
    <th align="center" style="width:5%;">&nbsp;<b>S.No</b></th>
    <th align="left" style="width:20%;" >&nbsp;<b>Teacher Name</b></th>
    <th align="left" style="width:27%;" >&nbsp;<b>Mobile</b></th>
    <th align="left" style="width:10%;" >&nbsp;<b>Password</b></th>
    <th align="left" style="width:18%;">&nbsp;<b>Type</b></th>
    <th align="left" style="width:12%;">&nbsp;<b>Class</b></th>
    <th align="left" style="width:8%;">&nbsp;<b>Section</b></th>
    </tr>
   ';
    
  
$counter=1;
       // pr($t_enquiry); die;
    if(isset($t_enquiry) && !empty($t_enquiry)){ 
    foreach($t_enquiry as $service){  //pr($service); 
    $dt=$this->Comman->findapass($service['employee']['id']);
 
                $html.='<tr>
    <td align="center" style="width:5%;">&nbsp;'.$counter++.'</td>
    <td align="left" style="width:20%;" >&nbsp;'.ucwords(strtolower($service['employee']['fname'])).' '.ucwords(strtolower($service['employee']['middlename'])).' '.ucwords(strtolower($service['employee']['lname'])).'</td> <td align="left" style="width:27%;" >&nbsp;'.$service['employee']['mobile'].'</td><td align="left" style="width:10%;" >&nbsp;'.$dt['confirm_pass'].'</td>';
    if($service['teacher_type']=='1'){
    $html.='<td align="left" style="width:18%;">&nbsp;Class Teacher</td>';
  }else{
    $html.='<td align="left" style="width:18%;">&nbsp;Co-Class Teacher</td>';
  }
    $html.='<td align="left" style="width:12%;">&nbsp;&nbsp;'.ucfirst($service['class']['title']).'</td>
    <td align="left" style="width:8%;">&nbsp;&nbsp;'.ucfirst($service['section']['title']).'</td>
                
</tr>';
  } }else{
    
    $html.='<tr>
    <td colspan="10" style="text-align:center;">NO Data Available</td>
    </tr>';
   }  
       
     
$html.='</table>
</body>
</html>';

$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
