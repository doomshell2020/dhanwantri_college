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
				    
 
		     
<?php $fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);

$html.='<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size: 20px;  font-weight:bold;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%" class="table table-bordered table-striped">
<tr>
<td width="100%" >
<table width="100%" cellspacing="2px" style="font-size:13px;">
<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Name of Student:
</td>

<td style="height:10px; line-height:12px;text-transform:uppercase;border:1px solid #000;" width="80%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Class:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.$classt['title'].' - '.$sect['title'].'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; House:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.ucwords(strtolower($fhosue['name'])).'
</td>



</tr>
<tr>
<td style="height:10px; line-height:12px; text-transform:capetalize;  font-weight:bold;" width="20%">
&nbsp; Date of Birth:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; Admission No:
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.$students['student']['enroll'].'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Mother's Name:";
$html.=$studentn.'
</td>

<td style="height:10px; line-height:12px; text-transform:uppercase;  border:1px solid #000;" width="80%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>



</tr>

<tr>
<td style="height:10px; line-height:12px;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name:";
$html.=$studentn.'
</td>

<td style="height:10px; line-height:12px;text-transform:uppercase;border:1px solid #000;" width="80%">
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
<td align="left"><h2 style="text-transform:uppercase; font-size: 20px;  font-weight:bold; line-height:30px;">Scholastic Areas:</h2></td>
</tr>
</table>
<table width="100%" class="table table-bordered table-striped">
<tr style="font-size:15px; text-transform:capitalize;">
<td width="10%" style="border-top:1px solid #000; border-left:1px solid #000;  height:40px; line-height:40px;  border-right:1px solid #000;  font-weight:bold; font-size:15px;" align="center" rowspan="2">&nbsp; S.No.</td>
<td width="30%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000; height:40px; line-height:40px;" align="center" rowspan="2">&nbsp; Subject</td>

<td width="60%" style="border-top:1px solid #000; font-size:14px;  font-weight:bold;  border-right:1px solid #000;height:20px; line-height:20px;" align="center" colspan="3">&nbsp; Mid Term</td>
</tr><tr>
<td width="25%" style="border-top:1px solid #000;  font-weight:bold;  font-size:13px; border-right:1px solid #000; height:20px; line-height:20px;" align="center" >&nbsp; Maximum Marks</td>
<td width="25%" style="border-top:1px solid #000;  font-weight:bold; font-size:12px;  border-right:1px solid #000;height:20px; line-height:20px;" align="center">&nbsp; Marks Obtained</td>
<td width="10%" style="border-top:1px solid #000;  font-weight:bold; font-size:12px;  border-right:1px solid #000;height:20px; line-height:20px;" align="center">&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i><br> Action</td>

</tr>';

$subject=$this->Comman->find_examsubjectsnn($students['class_id']); 

foreach($subject as $key=>$name){

if($students['class_id']=='10' && $students['sect_id']!='14'){
	
	 
		if($name['id']=='26'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
		if($students['class_id']=='10' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='25'){
			
			
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
	 if($students['class_id']=='11' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='34'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		}
		
		
	}
		if($students['class_id']=='10' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="Information Technology";
	}
	
	if($students['class_id']=='11' && $name['exprint']=="Computer Science"){
		
		$name['exprint']="Computer Application";
	}
	 
$html.='<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal"  novalidate="novalidate" action="'.SITE_URL.'/admin/studentexamresult/resultallupdatemarksixx/'.$students['class_id'].'/'.$students['sect_id'].'/'.$students['student']['acedmicyear'].'/'.$students['stud_id'].'">
<tr style="font-size:16px;">
<td width="10%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000;  border-bottom:1px solid #000;" align="center">&nbsp; '.$i++.'</td>
<td width="30%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-right:1px solid #000; height:15px; line-height:15px;" align="center">'.$name['exprint'].'</td><td width="20%" style="border-top:1px solid #000;  border-bottom:1px solid #000;border-right:1px solid #000; height:15px; line-height:15px;" align="center">80</td>';

$ter=0;
	  	$er['etype_id']='9';
		
		     if($students['class_id']=='11' && $students['sect_id']=='14'){
	
	 
		if($name['id']=='34'){
			
		
		$name['exprint']="Hindi/Sanskrit";	
		
		 $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					 $html.='<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"> <input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
		
		
		 $newmarkssanskrit=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],'33',$students['term']);
			if($newmarkssanskrit['marks']!=''){
		
					 $html.='<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarkssanskrit['id'].']" value="'.$newmarkssanskrit['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			
			 $html.='<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		}
		
	}		
		}else{
			
			   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
			
		}
		
		
	}else{
	 
		  
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
		
					
					 	 $html.='<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 $ter +=$newmarks['marks'];
			
	
		
	}else{
			 $html.='<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">--</td>';
		
		
	}
	
}

$html.='<td  
 align="center"><input type="submit" name="submit" value="Update Marks" class="btn btn-default"></td>
';
$html.='</tr></form>';
}






$html.='</table>
<br><br>';
echo $html; ?>
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






