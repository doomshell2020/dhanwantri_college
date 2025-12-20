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
		      <h3 class="box-title" style="color:green;"><b><?php  echo 'Term-2 Marks For SR. NO.'.$students['student']['enroll'];  ?></b></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

 
          
 <div class="box-body">
				    
 
		     
<?php $fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
if($students['class_id']=='11'){
$html.='<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size: 20px; font-weight:bold;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%" >
<table width="100%" cellspacing="2px" style="font-size:11px;"  class="table table-bordered table-striped" >
<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Name of Student:
</td>

<td style="height:10px; line-height:12px;text-transform:uppercase;" width="80%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Class:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase; " width="80%">
&nbsp; '.$classt['title'].' - '.$sect['title'].'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; House:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;" width="80%">
&nbsp; '.ucwords(strtolower($fhosue['name'])).'
</td>



</tr>
<tr>
<td style="height:10px; line-height:12px; text-transform:capetalize;  font-weight:bold;" width="20%">
&nbsp; Date of Birth:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase; " width="80%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Admission No:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  " width="80%">
&nbsp; '.$students['student']['enroll'].'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Mother's Name:";
$html.=$studentn.'
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  " width="80%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name:";
$html.=$studentn.'
</td>

<td style="height:10px; line-height:12px;text-transform:uppercase;" width="80%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>



</tr>

</table>

</td>

</tr>

</table>
<br><br>
<table width="100%">
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size: 20px; font-weight:bold; line-height:30px;">Scholastic Areas:</h2></td>
</tr>
</table>
<table width="100%" class="table table-bordered table-striped">
<tr style="font-size:15px; text-transform:capitalize;">
<td width="10%" style="border-top:1px solid #000; border-left:1px solid #000;  height:20px; line-height:20px;  border-right:1px solid #000;  font-weight:bold; " align="center" >&nbsp; S.No.</td>
<td width="30%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000; height:20px; line-height:20px;" align="center" >&nbsp; Subject</td>


<td width="20%" style="border-top:1px solid #000;  font-weight:bold;  font-size:13px; border-right:1px solid #000; height:20px; line-height:20px;" align="center" >&nbsp; Maximum Marks</td>
<td width="20%" style="border-top:1px solid #000;  font-weight:bold; font-size:13px;  border-right:1px solid #000;height:20px; line-height:20px;" align="center">&nbsp; Marks Obtained</td>
<td width="20%" style="border-top:1px solid #000;  font-weight:bold; font-size:12px;  border-right:1px solid #000;height:20px; line-height:20px;" align="center">&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i><br> Action</td>
</tr>';


$subject=$this->Comman->find_examsubjectsnn($students['class_id']); 
 

  foreach($subject as $key=>$name){

if($students['class_id']=='10' && $students['sect_id']!='14'){
	
	 
		if($name['id']=='26'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
		if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='26'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		

			
			
			
		
		
		if($students['class_id']=='11' && $students['sect_id']!='14'){
		if($name['id']=='34'){
			unset($subject[$key]);
			
			
		}
		
	}
		 if($students['class_id']=='11' && $students['sect_id']=='14'){
		if($name['id']=='33'){
			unset($subject[$key]);
			
			
		}
		 
		}
	 	 
	   }                                                                                                                                      

 $i=1;
 
 
 foreach($subject as $key=>$name){
	 if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='25'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		}
		
		
	}
		if($students['class_id']=='10' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="Computer Application";
	}
	
	if($students['class_id']=='11' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="F.I.T.";
	}
	 
$html.='<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal"  novalidate="novalidate" action="'.SITE_URL.'/admin/studentexamresult/resultallupdatemarksixx2/'.$students['class_id'].'/'.$students['sect_id'].'/'.$students['student']['acedmicyear'].'/'.$students['stud_id'].'"><tr style="font-size:12px;">
<td width="10%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  border-bottom:1px solid #000;" align="center">&nbsp; '.$i++.'</td>
<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$name['exprint'].'</td>';

if($name['exprint']=="F.I.T."){ 
$html.='<td width="30%" style="border-top:1px solid #000;  border-bottom:1px solid #000;border-right:1px solid #000; height:15px; line-height:15px;" align="center">40</td>';

}else{
$html.='<td width="30%" style="border-top:1px solid #000;  border-bottom:1px solid #000;border-right:1px solid #000; height:15px; line-height:15px;" align="center">80</td>';	
	
}

$ter=0;
	  	$er['etype_id']='17';
		
		     if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='25'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		
		 $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
		
		
		 $newmarkssanskrit=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],'26',$students['term']);
			if($newmarkssanskrit['marks']!=''){
		
					 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarkssanskrit['id'].']" value="'.$newmarkssanskrit['marks'].'"></td>';
			 $ter +=$newmarkssanskrit['marks'];
			
	
		
	}else{
			
			 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		}
		
	}
		
		}else{
			
			   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
			
		}
		
		
	}else{
	 
		  
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
	
}



 $html.='<td width="16%" 
 align="center"><input type="submit" name="submit" value="Update Marks" class="btn btn-default"></td>
';
$html.='</tr></form>';
}







$html.='</table>
<br><br>';
echo $html; }else{  
	
	
	
 $esctotal=0;

$html.='
<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size: 20px; font-weight:bold;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%">
<table width="100%" style="font-size:11px;"  class="table table-bordered table-striped">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Student's Name :";

$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Class / House :
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.$classt['title'].' - '.$sect['title'].' /'.ucwords(strtolower($fhosue['name'])).'
</td>

</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name :";
$html.=$studentn.' 
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Date of Birth :
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Mother's Name :";
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Admission No. :
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.$students['student']['enroll'].'
</td>
</tr>
</table>

</td>

</tr>

</table>

<table width="100%">
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size: 20px; font-weight:bold; line-height:25px;">Scholastic Areas:</h2></td>
</tr>
</table>

<table width="100%">
<tr style="font-size:15px;">
<td width="20%" style="border-top:1px solid #000; border-left:1px solid #000; height:20px;  line-height:20px;  border-right:1px solid #000;  font-weight:bold; " align="center">&nbsp; Subject Name</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold;height:38px; height:20px;  line-height:20px; border-right:1px solid #000;" align="center">Periodic Test<br>(10)</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold;height:38px; height:20px;  line-height:20px; border-right:1px solid #000;" align="center">Notebook<br>(5)</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold;   height:38px; height:20px;  line-height:20px;border-right:1px solid #000;" align="center">Sub. Enrichment<br>(5)</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold; height:38px; height:20px;  line-height:20px; border-right:1px solid #000;" align="center">Annual Exam<br>(80)</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold; font-size:12px;  border-right:1px solid #000;height:20px; line-height:20px;" align="center">&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i><br> Action</td>
</tr>';


$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],$students['term']);
$findroleexamtype3=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],'3');


 $subject=$this->Comman->find_examsubjectsnn($students['class_id']); 
 

  foreach($subject as $key=>$name){

if($students['class_id']=='10' && $students['sect_id']!='14'){
	
	 
		if($name['id']=='26'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
		if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='26'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		

			
			
			
		
		
		if($students['class_id']=='11' && $students['sect_id']!='14'){
		if($name['id']=='34'){
			unset($subject[$key]);
			
			
		}
		
	}
		 if($students['class_id']=='11' && $students['sect_id']=='14'){
		if($name['id']=='33'){
			unset($subject[$key]);
			
			
		}
		 
		}
	 	 
	   }                                                                                                                                      

 $i=1;
 
 $cn=0;
 foreach($subject as $key=>$name){
	 
	 $cn++;
	 if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='25'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		}
		
		
	}
		if($students['class_id']=='10' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="Computer Application";
	}
	
	if($students['class_id']=='11' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="F.I.T.";
	}
	 
$html.='<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal"  novalidate="novalidate" action="'.SITE_URL.'/admin/studentexamresult/resultallupdatemarksixx2/'.$students['class_id'].'/'.$students['sect_id'].'/'.$students['student']['acedmicyear'].'/'.$students['stud_id'].'"><tr style="font-size:18px;">

<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-left:1px solid 
#000; border-right:1px solid #000; height:15px; font-size:16px; line-height:14px;" align="center">'.$name['exprint'].'</td>';

$ter=0;
		if($students['class_id']=='10' && $name['exprint']!="Computer Application"){
  foreach($findroleexamtype as $er){  

	  	//$er['etype_id']='17';
		
		     if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='25'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		
		 $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
 $html.='<td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
		
		
 $newmarkssanskrit=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],'26',$students['term']);
			if($newmarkssanskrit['marks']!=''){
		
	$html.='<td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarkssanskrit['id'].']" value="'.$newmarkssanskrit['marks'].'"></td>';
			 $ter +=$newmarkssanskrit['marks'];
			
	
		
	}else{
			
			 $html.='<td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		}
		
	}
		
		}else{
			
			   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
			
		}
		
		
	}else{
	 
		  
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
	
}

}

}else{
	
	$efg=1;
	foreach($findroleexamtype3 as $er){  

	  	//$er['etype_id']='17';
		
		     if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='25'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		
		 $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],'3');
if($newmarks['marks']!=''){
		
						if($efg=='1'){ 
					
					 	 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	}else{
			 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
		
	}
			
	
		
	}else{
		
		
		 $newmarkssanskrit=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],'26','3');
			if($newmarkssanskrit['marks']!=''){
		
					if($efg=='1'){ 
					
					 	 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	}else{
			 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
		
	}
			
	
		
	}else{
			
				if($efg=='1'){ 
					
					 	 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;--</td>';
			
			
	}else{
			 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;--</td>';
	
			
		
	}
		}
		
	}
		
		}else{
			
			   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],'3');
if($newmarks['marks']!=''){
		
					
					 	if($efg=='1'){ 
					
					 	 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	}else{
			 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
		
	}
			
	
		
	}else{
				if($efg=='1'){ 
					
					 	 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;--</td>';
			
			
	}else{
			 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;--</td>';
	
			
		
	}
		
	}
			
		}
		
		
	}else{
	 
		  
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],'3');
if($newmarks['marks']!=''){
		if($efg=='1'){ 
					
					 	 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	}else{
			 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;<input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
		
	}
		
	}else{
			if($efg=='1'){ 
					
					 	 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;--</td>';
			
			
	}else{
			 $html.='<td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;--</td>';
	
			
		
	}
		
		
	}
	
}
$efg++;
}
	
	
	
}





if($ter!=0){
	$grade=$ter*100/100; 


	  if ($grade > 90 && $grade < 101)
	$ss="A1";
	elseif ($grade == 90)
	$ss="A2";
elseif ($grade > 80  && $grade < 90)
	$ss="A2";
	elseif ($grade == 80)
	$ss= "B1";
elseif ($grade > 70  && $grade < 80)
	$ss= "B1";
	elseif ($grade == 70)
$ss= "B2";
elseif ($grade > 60 && $grade < 70)
	$ss="B2";
	elseif ($grade == 60)
$ss="C1";
elseif ($grade > 50  &&  $grade < 60)
	$ss="C1";
	elseif ($grade == 50)
	$ss="C2";
elseif ($grade > 40 && $grade < 50)
	$ss="C2";
elseif ($grade == 40)
	$ss= "D";	
elseif ($grade > 32 && $grade < 40)
	$ss= "D";
	elseif ($grade == 32)
	$ss="E";
elseif ($grade > 20 && $grade < 32)
	$ss="E";
	elseif ($grade == 20)
	$ss="E";
elseif ($grade >= 0 && $grade < 20)
	$ss="E";
	
	

}else{
		$ss="E";
	
}

	$esctotal +=$ter;
 $html.='<td width="16%"  style="padding:2px;
 align="center"><input type="submit" name="submit" value="Update Marks" class="btn btn-default"></td>
';
$html.='</tr></form>';


}
$subjcn=$cn*100;

$percent=$esctotal*100/$subjcn; 
	
$tper=number_format((float)$percent, 2, '.', ''); 





if($esctotal!=0){
	$gradetotal=$esctotal*100/$subjcn; 


	  if ($gradetotal > 90 && $gradetotal < 101)
	$sstotal="A1";
	elseif ($gradetotal == 90)
	$sstotal="A2";
elseif ($gradetotal > 80  && $gradetotal < 90)
	$sstotal="A2";
	elseif ($gradetotal == 80)
	$sstotal= "B1";
elseif ($gradetotal > 70  && $gradetotal < 80)
	$sstotal= "B1";
	elseif ($gradetotal == 70)
$sstotal= "B2";
elseif ($gradetotal > 60 && $gradetotal < 70)
	$sstotal="B2";
	elseif ($gradetotal == 60)
$sstotal="C1";
elseif ($gradetotal > 50  &&  $gradetotal < 60)
	$sstotal="C1";
	elseif ($gradetotal == 50)
	$sstotal="C2";
elseif ($gradetotal > 40 && $gradetotal < 50)
	$sstotal="C2";
elseif ($gradetotal == 40)
	$sstotal= "D";	
elseif ($gradetotal > 32 && $gradetotal < 40)
	$sstotal= "D";
	elseif ($gradetotal == 32)
	$sstotal="E";
elseif ($gradetotal > 20 && $gradetotal < 32)
	$sstotal="E";
	elseif ($gradetotal == 20)
	$sstotal="E";
elseif ($gradetotal >= 0 && $gradetotal < 20)
	$sstotal="E";
	
	

}else{
		$sstotal="E";
	
}

$html.='</table>
<br><br>';
echo $html;
 } ?>
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






