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
$srch=$this->Session->read('search');

//pdf->SetY(-550);
$pdf->SetFont('', '', 9, '', 'false');
if($students['status']=='Y'){ $status="<span class='label label-success'> Active</span>"; } else{ $status= "<span class='label label-primary'> In-Active</span>"; }

$html='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>student-erp</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet"> 
<style>
table, td, th{ border:1px solid #ccc; padding:5px; font-size:14px;}
th{ color:#900;}
tr:nth-child(even){background-color: #f2f2f2}


</style>



 </head>

<body style=" font-family:"Trebuchet MS", Arial, Helvetica, sans-serif">

<div id="pageContainer1" style="width:992px; margin:auto;background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.4);
-moz-box-shadow: 0 0 10px rgba(0,0,0,0.4);
-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.4);
-o-box-shadow: 0 0 10px rgba(0,0,0,0.4); padding:30px;">


<table width="100%" border="0" style="border:none">
<tr border="0" style="border:none">
<td border="0" class="lg" style=" width:10%; border:none"><img src="images/L_58839.gif" alt="logo"></td>

<td border="0" style=" width:90%; font-size:17px; border:none"><strong style=" margin:6px 0; color:#5d5a50;">Sanskar School</strong><br>
<small style="color:#5d5a50; font-weight:400;">Senior Secondary English Medium Co-Educational School<br>
(An ISO 9001 : 2000 Certified School) Affiliated to CBSE, New Delhi, Aff. No. 1730236<br>
117-121, Vishwamitra Marg, Hanuman Nagar Ext., Sirsi Road, Jaipur - 302012
 </small>
</td>
</tr>
</table>
<hr style="color:#ccc">

<table width="100%" style="border:none;">

<tr style="border:none;">
<td style=" width:25%; border:none">';


	 if(!empty($students['file'])){	
				$html.='<img style="height:800%" class="center-block img-circle img-thumbnail profile-img" src="'.SITE_URL.'webroot/uploads/'.$students['file'].'">';
					
					
					 } else {
				$html.='<img style="height:800%" class="center-block img-circle img-thumbnail profile-img" src="'.SITE_URL.'webroot/uploads/no-images.png">';
					 } 
					 
					 $house=$this->Comman->findhouse($students['house_id']);
$html.='</td>
<td style=" width:75%;border:none; font-size:11px;">
<br><br><br>
<strong style="font-weight:bold; color:#900;">Name : </strong>'.ucfirst($students['fname']).'&nbsp;'.ucfirst($students['middlename']).'&nbsp;'.ucfirst($students['lname']).'<br>
<strong style="font-weight:bold; color:#900;">Student ID : </strong>'.$students['id'].'<br>
<strong style="font-weight:bold; color:#900;">Email/Login Id  : </strong>'.$students['username'].'<br>
<strong style="font-weight:bold; color:#900;">Mobile No  : </strong>'.$students['mobile'].'<br>
<strong style="font-weight:bold; color:#900;">Status : </strong>'.$status.'</td>

</tr>

</table>

<!------------------Personal Profile strt------------------------->



<div>
<table style="border:1px solid #ccc; width:100%; text-align:left; margin:10px auto; padding:5px; border-collapse: collapse;">
<tr>
<th colspan="4"  style="background-color:#69C; color:#fff; text-align:center; padding:4px; margin:0; font-size:16px; font-weight:bold; height:28px;">Personal Profile</th>
</tr>
<tr>
<th  style=" font-size:9px;">Gender</th>
<td  style=" font-size:9px;">'.$students['gender'].'</td>
<th  style=" font-size:9px;">Date Of Birth</th>
<td  style=" font-size:9px;">'.$students['dob'].'</td>
</tr>
<tr >
<th  style=" font-size:9px;">Nationality</th>
<td  style=" font-size:9px;">'.$students['nationality'].'</td>
<th  style=" font-size:9px;">Admission Category</th>
<td  style=" font-size:9px;">'.$students['category'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;">Enrollnment No.</th>
<td  style=" font-size:9px;">'.$students['id'].'</td>
<th  style=" font-size:9px;">Bloodgroup</th>
<td  style=" font-size:9px;">'.$students['bloodgroup'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;">Aadhar No.</th>
<td  style=" font-size:9px;">'.$students['adaharnumber'].'</td>
<th  style=" font-size:9px;">Form No</th>
<td  style=" font-size:9px;" >'.$students['formno'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;">Cast</th>
<td  style=" font-size:9px;">'.$students['cast'].'</td>
<th  style=" font-size:9px;">Religion</th>
<td  style=" font-size:9px;">'.$students['religion'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;">House</th>
<td  style=" font-size:9px;">'.$house['name'].'</td>

</tr>

</table></div>

<!------------------Personal Profile ends------------------------->


<!------------------ Academic  Details strt------------------------->
<br>

<div>
<table style="border:1px solid #ccc; width:100%; text-align:left; margin:10px auto; padding:5px; border-collapse: collapse;">
<tr>
<th colspan="7"  style="background-color:#69C; color:#fff; text-align:center; padding:4px; margin:0; font-size:16px; font-weight:bold; height:28px;">Academic Details </th>
</tr>
<tr>
<th  style=" font-size:9px;">Action</th>
<th  style=" font-size:9px;">Enroll No.</th>
<th  style=" font-size:9px;">Academic Year</th>
<th  style=" font-size:9px;">Class</th>

<th  style=" font-size:9px;">Section</th>
<th  style=" font-size:9px;">Completion Status</th>
<th  style=" font-size:9px;">Status</th>
</tr>
<tr>
<td  style=" font-size:9px;">ENROLL</td>
<td  style=" font-size:9px;">'.$students['enroll'].'</td>
<td  style=" font-size:9px;">'.$students['acedmicyear'].'</td>
<td  style=" font-size:9px;">'.$students['class']['title'].'</td>

<td  style=" font-size:9px;">'.$students['section']['title'].'</td>
<td  style=" font-size:9px;"><span class="label label-primary">In Progress</span></td>
<td  style=" font-size:9px;">'.$status.'</td>
</tr>
</table></div>

<!------------------Address Info strt------------------------->

<br>


<table style="border:1px solid #ccc; width:100%; text-align:left; margin:10px auto; padding:5px; border-collapse: collapse;">
<tr>
<th colspan="4"  style="background-color:#69C; color:#fff; text-align:center; padding:4px; margin:0; font-size:16px; font-weight:bold; height:28px;">Address Info </th>
</tr>
<tr>
<th colspan="4"  style=" font-size:9px;">Current Address</th>
</tr>
<tr>
<th  style=" font-size:9px;"> Address</th>
<td colspan="3"  style=" font-size:9px;">'.$address['c_address'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;"> City</th>
<td  style=" font-size:9px;">'.$address['CurCity']['name'].'</td>
<th  style=" font-size:9px;"> State</th>
<td  style=" font-size:9px;">'.$address['CurStates']['name'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;"> Country</th>
<td  style=" font-size:9px;">'.$address['CurCountry']['name'].'</td>
<th  style=" font-size:9px;">Pincode</th>
<td  style=" font-size:9px;">'.$address['c_pincode'].'</td>
</tr>
</table>



<table style="border:1px solid #ccc; width:100%; text-align:left; margin:10px auto; padding:5px; border-collapse: collapse;">
<tr>
<th colspan="4"  style=" font-size:9px;">Permanent Address</th>
</tr>
<tr>
<th  style=" font-size:9px;"> Address</th>
<td colspan="3"  style=" font-size:9px;">'.$address['p_address'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;"> City</th>
<td  style=" font-size:9px;">'.$address['PerCity']['name'].'</td>
<th  style=" font-size:9px;"> State</th>
<td  style=" font-size:9px;">'.$address['PerStates']['name'].'</td>
</tr>
<tr>
<th  style=" font-size:9px;"> Country</th>
<td  style=" font-size:9px;">'.$address['PerStates']['name'].'</td>
<th  style=" font-size:9px;">Pincode</th>
<td  style=" font-size:9px;">'.$address['PerStates']['p_pincode'].'</td>
</tr>



</table>



<!------------------Student Document start------------------------->
<br><br><br><br><br>

<div>
<table style="border:1px solid #ccc; width:100%; text-align:left; margin:10px auto; padding:5px; border-collapse: collapse;">
<tr>
<th colspan="4"  style="background-color:#69C; color:#fff; text-align:center; padding:4px; margin:0; font-size:16px; height:28px; font-weight:bold;">Student Documents</th>
</tr>
<tr>
<th  style=" font-size:9px;">Category</th>
<th  style=" font-size:9px;">Document Details</th>
<th  style=" font-size:9px;">Submited Date</th>
<th  style=" font-size:9px;">Approved/Disapproved</th>


</tr>';
foreach($doc_img as $key=>$iteam){

$html.='<tr>

<td  style=" font-size:9px;">'.$iteam['documentcategory']['categoryname'].'</td>
<td  style=" font-size:9px;">'.$iteam['description'].'</td>
<td  style=" font-size:9px;">'.date('d M Y',strtotime($iteam['created'])).'</td>';

if($iteam['status']=='Y'){

$html.='<td  style=" font-size:9px;">Approved</td>';

}else{
	$html.='<td  style=" font-size:9px;">Approved</td>';
	
}
$html.='</tr>';


}
$html.='</table></div>










<!------------------Student  History start------------------------->
<br><br><br><br><br>

<div>
<table style="border:1px solid #ccc; width:100%; text-align:left; margin:10px auto; padding:5px; border-collapse: collapse;">
<tr>
<th colspan="7"  style="background-color:#69C; color:#fff; text-align:center; padding:4px; margin:0; font-size:16px; height:28px; font-weight:bold;">Student History</th>
</tr>
<tr>
<th  style=" font-size:9px;">Action</th>
<th  style=" font-size:9px;">Enroll No.</th>
<th  style=" font-size:9px;">Academic Year</th>
<th  style=" font-size:9px;">Class</th>

<th  style=" font-size:9px;">Section</th>
<th  style=" font-size:9px;">Completion Status</th>
<th  style=" font-size:9px;">Status</th>
</tr>';
		if(isset($studentshistory) && !empty($studentshistory)){ 
foreach($studentshistory as $key=>$value) {
$html.='<tr>';

if($value['action']=='2'){ 
$html.='<td  style="font-size:9px;">Promoted</td>';


}else{
	$html.='<td  style="font-size:9px;">Passout</td>';
	
} 
$html.='<td  style="font-size:9px;">'.$value['stud_id'].'</td>
<td  style="font-size:9px;">'.$value['acedmicyear'].'</td>
<td  style="font-size:9px;">'.$value['class']['title'].'</td>

<td  style="font-size:9px;">'.$value['section']['title'].'</td>
<td  style="font-size:9px;"><span class="label label-primary">Completed</span></td>
<td  style="font-size:9px;">'.$status.'</td>
</tr>';
}

}else{
	$html.='<tr>
<td colspan="7"  style="font-size:9px; text-align:center">No history Available</td>

</tr>';
	
	
}
$html.='</table></div>

<!------------------Student History ends------------------------->

</div>

</body>
</html>';

$pdf->WriteHTML($html);
ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
