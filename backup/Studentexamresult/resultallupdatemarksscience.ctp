<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Student Update Marks Manager
		      </h1>
	    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title" style="color:green;"><b><?php  echo 'Term-1 Marks For SR. NO.'.$students['student']['enroll'];  ?></b></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

 
          
 <div class="box-body">
				    
 
		     
<?php 

$html.='
<table width="100%" >
<br><br>
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size: 20px; font-weight:bold; text-transform:uppercase;">Student Profile:</h2></td>
</tr>
</table>

<table width="100%">

<tr>

<td width="100%">
<table width="100%">
<tr style="font-size:13px;">

<td style="height:15px; line-height:15px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; Name:
</td>



<td style="height:15px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>


<td style="height:15px; line-height:15px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Class:";
$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
$html.=$studentn.'

</td>


<td style="height:15px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.$classt['title'].' - '.$sect['title'].'
</td>


</tr>

<tr style="font-size:13px;">

<td style="height:15px; line-height:15px;   text-transform:uppercase;  font-weight:bold; font-size:13px;" width="20%">
&nbsp; ';
$studentn="Mother's Name:";
$html.=$studentn.'
</td>

<td style="height:15px;  font-size:13px;line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>
<td style="height:15px; font-size:13px; line-height:15px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; House:
</td>

<td style="height:15px; line-height:15px; font-size:13px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($fhosue['name'])).'
</td>


</tr>

<tr tyle="font-size:13px;">

<td style="height:15px; line-height:15px; font-size:13px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name:";
$html.=$studentn.'
</td>

<td style="height:15px; line-height:15px; font-size:13px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:15px; line-height:15px;font-size:13px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Date of Birth:
</td>

<td style="height:15px; line-height:15px; font-size:13px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp;'.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>
</tr>


<tr tyle="font-size:13px;">
<td style="height:15px; line-height:15px; font-size:13px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Admission No.:
</td>

<td style="height:15px; line-height:15px;font-size:13px; text-transform:uppercase;" width="30%">
&nbsp; '.$students['student']['enroll'].'
</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
</tr>



</table>

</td>

</tr>

</table>
<br><br><br>
<table width="100%">
<tr>
<td align="left"><h2 style=" text-align:center; font-size:16px; font-weight:bold;  text-transform:uppercase;">SCHOLASTIC PROGRESS</h2></td>
</tr>
</table>
<br><br>
<table width="100%" cellpadding="2px">
<tr style="font-size:12px;">
<td width="10%" style="border-top:1px solid #000; border-left:1px solid #000; text-align:center;  height:38px; line-height:38px;  border-right:1px solid #000;  font-weight:bold; " align="center" rowspan="2">&nbsp; S.No.</td>
<td width="28%" style="border-top:1px solid #000;  text-transform:uppercase; height:38px; line-height:38px;  font-weight:bold;  border-right:1px solid #000;" align="center" rowspan="2">&nbsp; SUBJECTS</td>
<td width="12%" style="border-top:1px solid #000;   font-weight:bold;  border-right:1px solid #000;" align="center" rowspan="2">PT-1<br>50</td>
<td width="24%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center" colspan="2">MID TERM 100</td>

<td width="13%" style="border-top:1px solid #000;  font-weight:bold; font-size:12px;  border-right:1px solid #000;height:20px; line-height:20px;" rowspan="2" align="center">&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i><br> Action</td>
</tr>
<tr>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; line-height:20px;" align="center" colspan="1">Th</td>
<td width="12%" style="border-top:1px solid #000;   border-right:1px solid #000; line-height:20px;" align="center">Pr / IA</td>
</tr>';


$rt=array();
$ert=array();
$cnt=1;
$cnt2=0;
$total=0;
  $subjects=array();                  $rt=explode(',',$students['student']['comp_sid']);
foreach($rt as $hhj=>$studett){
                   
    $subject=$this->Comman->findsubjectsubs2($studett);
    
   $subjects[]=$this->Comman->find_examsubjectsnn2s($students['class_id'],$subject['name']);   
   
    
}


foreach ($subjects as $key => $row)
{
    $vc_array_name[$key] = $row['sort'];
}
array_multisort($vc_array_name, SORT_ASC, $subjects);



$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],$students['term']);


  foreach($subjects as $key=>$name){
   if($name['exprint']=="English"){
	  $name['exprint']="English Core"; 
	   
   }
   
   
   if($name['exprint']=="Psychology_M"){
	  $name['exprint']="Psychology"; 
	   
   }
$html.='<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal"  novalidate="novalidate" action="'.SITE_URL.'/admin/studentexamresult/resultallupdatemarksscience/'.$students['class_id'].'/'.$students['sect_id'].'/'.$students['student']['acedmicyear'].'/'.$students['stud_id'].'"><tr style="font-size:12px;">
<td width="10%" style="border-top:1px solid #000; text-align:center; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  " align="center">&nbsp; '.$cnt++.'.</td>
<td width="28%" style="border-top:1px solid #000; font-weight:bold;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"> '.$name['exprint'].'</td>';

$cnt2++;
$ter=0;
$grade=0;
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		 $html.='<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			
			 $ter +=$newmarks['marks'];
			 
	
	
}else{
			 $html.='<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}
if($ter!=0){
	$grade=$ter*100/150; 
	$grade=number_format($grade);
	
}else{
	
	$grade='0';
}

$total +=$ter;

$html.='<td  width="13%" style="padding:2px;border-right:1px solid #000;"
 align="center"><input type="submit" name="submit" value="Update Marks" class="btn btn-default"></td>
';
$html.='</tr></form>';

}


$rt2=array();
$ert2=array();
$subjects2=array();
                    $rt2=explode(',',$students['student']['opt_sid']);
foreach($rt2 as $hhj2=>$studett2){
                   
    $subject2=$this->Comman->findsubjectsubs2($studett2);
    
   $subjects2[]=$this->Comman->find_examsubjectsnn2s($students['class_id'],$subject2['name']);   
   
    
}


foreach ($subjects2 as $key2 => $row2)
{
    $vc_array_name2[$key] = $row2['sort'];
}
array_multisort($vc_array_name2, SORT_ASC, $subjects2);




  foreach($subjects2 as $key2=>$name2){
    if($name2['exprint']=="English"){
	  $name2['exprint']="English Core"; 
	   
   }
$html.='<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal"  novalidate="novalidate" action="'.SITE_URL.'/admin/studentexamresult/resultallupdatemarksscience/'.$students['class_id'].'/'.$students['sect_id'].'/'.$students['student']['acedmicyear'].'/'.$students['stud_id'].'"><tr style="font-size:12px;">
<td width="10%" style="border-top:1px solid #000; text-align:center; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  " align="center">&nbsp;  '.$cnt++.'.</td>
<td width="28%" style="border-top:1px solid #000; font-weight:bold;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"> '.$name2['exprint'].'</td>';
$cnt2++;
$ter=0;
$grade=0;
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name2['id'],$students['term']);
if($newmarks['marks']!=''){
		 $html.='<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			
			 $ter +=$newmarks['marks'];
			 
	
	
}else{
			 $html.='<td width="12%" style="border-top:1px solid #000;  border-right:1px solid #000;height:15px; line-height:15px;" align="center">--</td>';
		
		
	}


}

if($ter!=0){
	$grades=$ter*100/150;
	$grades=number_format($grades); 
	
}else{
	
	$grades='0';
}
$total +=$ter;
 $html.='<td  width="13%" style="padding:2px;border-right:1px solid #000;"
 align="center"><input type="submit" name="submit" value="Update Marks" class="btn btn-default"></td>
';
$html.='</tr></form>';

}



$html.='<tr style="font-size:12px;">
<td width="38%" style="border-top:1px solid #000; font-size:12px;  height:15px; line-height:15px; text-align:center;   font-weight:bold;" colspan="2"></td>

<td width="12%" style="border-top:1px solid #000;   height:15px; line-height:15px;" align="center"></td>
<td width="12%" style="border-top:1px solid #000;  height:15px; line-height:15px;" align="center"></td>
<td width="12%" style="border-top:1px solid #000;   height:15px; line-height:15px;" align="center"></td>
<td width="14%" style="border-top:1px solid #000;   height:15px; line-height:15px;" align="center"></td>

</tr>
</table>
<br><br>';
echo $html; 
?>
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
			<?php
			echo $this->Html->link('Back', [
			    'action' => 'searcharea/'.$students['class_id'].'/'.$students['sect_id'].''
			   
			],['class'=>'btn btn-default']); ?>
		      
			
		      </div>
		      <!-- /.box-footer -->

          </div>
         
     


          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>






