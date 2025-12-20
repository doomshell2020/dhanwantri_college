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
<title>Result</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html.='</head>
<body style="font-family:"trebuchet MS",Arial,Helvetica,sans-serif;">
<table width="100%" border="0" >
<tr>
<td width="10%" style="border-right:none; text-align:left">
<img src="images/L_58839.gif" alt="" border="0" style="width: 700%; display:block; ">
</td>
<td align="left" style="border-left:none;" width="80%">
<small style="display:block; color:#000; font-size:10px;">
<b>Sanskar School</b>
</small><br>
<small style="display:block; color:#000; font-size:8px;"> Affiliated to CBSE,Delhi<br>
 Vishwamitra Marg, Defence Colony<br> Sirsi Road, Jaipur(Rajasthan) 302012</small>
<br>
<span style="display:block; color:#000; font-size|:10px;"> Ph. No.:&nbsp;0141 - 2246189,2357844</span><br>


<br>
</td>
</tr>
</table>


<table width="100%" border="1" align="center">
<tr>

 <td align="center" colspan="5" ><b>Class Teachers </b> 
</td>
    
    </tr>
<tr>
 <th align="center" style="width:5%;">&nbsp;<b>S.No</b></th>
    <th align="left" style="width:20%;" >&nbsp;<b>Teacher Name</b></th>
        <th align="left" style="width:29%;" >&nbsp;<b>User Name</b></th>
        <th align="left" style="width:9%;" >&nbsp;<b>Password</b></th>
    <th align="left" style="width:12%;">&nbsp;<b>Type</b></th>
    <th align="left" style="width:17%;">&nbsp;<b>Class</b></th>
    <th align="left" style="width:8%;">&nbsp;<b>Section</b></th>
    
    </tr>
   ';
    
  
$counter=1;
        
    if(isset($t_enquiry) && !empty($t_enquiry)){ 
    foreach($t_enquiry as $service){  //pr($service); 
    
                $html.='<tr>
                <td align="center" style="width:5%;">&nbsp;'.$counter++.'</td>
    <td align="left" style="width:20%;" >&nbsp;'.ucwords(strtolower($service['employee']['fname'])).' '.ucwords(strtolower($service['employee']['middlename'])).' '.ucwords(strtolower($service['employee']['lname'])).'</td> <td align="left" style="width:29%;" >&nbsp;'.$service['employee']['username'].'</td><td align="left" style="width:9%;" >&nbsp;12345</td>';
    if($service['teacher_type']=='1'){
    $html.='<td align="left" style="width:12%;">&nbsp;Class Teacher</td>';
  }else{
    $html.='<td align="left" style="width:18%;">&nbsp;Co-Class Teacher</td>';
  }
    $html.='<td align="left" style="width:17%;">&nbsp;&nbsp;'.ucfirst($service['class']['title']).'</td>
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
