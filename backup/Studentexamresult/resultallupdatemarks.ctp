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
<td width="100%" >
<table width="100%" style="font-size:11px;" class="table table-bordered table-striped">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Student's Name";

$fhosue=$this->Comman->findhouse($students['student']['h_id']);
$classt=$this->Comman->findclass($students['class_id']);
$sect=$this->Comman->findsectionsss($students['sect_id']);
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fname'])).'&nbsp;'.ucwords(strtolower($students['student']['middlename'])).'&nbsp;'.ucwords(strtolower($students['student']['lname'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Class / House
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.$classt['title'].' - '.$sect['title'].' /'.ucwords(strtolower($fhosue['name'])).'
</td>

</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Father's Name";
$html.=$studentn.' 
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['fathername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Date of Birth
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase; " width="30%">
&nbsp; '.date('d-m-Y',strtotime($students['student']['dob'])).'
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; ';
$studentn="Mother's Name";
$html.=$studentn.'
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; '.ucwords(strtolower($students['student']['mothername'])).'
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  " width="20%">
&nbsp; SR. No.
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; '.$students['student']['enroll'].'
</td>
</tr>
</table>

</td>

</tr>

</table>

<br><br>
<table width="100%">
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size: 20px; font-weight:bold; text-transform:uppercase;">Scholastic Areas:</h2></td>
</tr>
</table>
<table width="100%" >';

$findroleexamtype=$this->Comman->findeexamtsype3s($students['sect_id'],$students['class_id'],$students['term']);
$html.='<tr style="font-size:15px;">
<td width="24%" style="border-top:1px solid #000; border-left:1px solid #000;  height:38px; line-height:38px;  border-right:1px solid #000;  font-weight:bold; " align="center">&nbsp; Subject Name</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Periodic<br>Test<br>(10)<span title="Kindly Enter double for PT Exam Category." style="color:red;">*2</span></td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Notebook<br>Submission<br>(5)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">Subject<br>Enrichment<br>(5)</td>
<td width="15%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center">First Term<br>Examination<br>(80)</td>

<td width="5%" style="border-top:1px solid #000;  font-weight:bold;  border-right:1px solid #000;" align="center"><i class="fa fa-arrow-right" aria-hidden="true"></i><br>Action</td>

</tr>';
 $subject=$this->Comman->find_examsubjectsnn($students['class_id']); 
   foreach($subject as $key=>$name){
	 
	
	 
	 if($students['student']['is_lc']=='Y'){
	
	 
		if($name['exprint']=='Sanskrit'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		if($students['class_id']=='9' && $students['sect_id']=='9'){
	
	 
			if($name['exprint']=='French'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		}
		
		
		
		if($students['class_id']=='9' && $students['sect_id']=='10'){
	
	 
			if($name['exprint']=='French'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		}  
		
		if($students['class_id']=='9' && $students['sect_id']=='11'){
	
	 
			if($name['exprint']=='French'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
		if($students['class_id']=='9' && $students['sect_id']=='13'){
	
	 
			if($name['exprint']=='French'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		} 
		
			if($students['class_id']=='9' && $students['sect_id']=='14'){
	
	 
			if($name['exprint']=='French'){
			
			
			unset($subject[$key]);
			
			
		}
		 
		 
		}
		
		
 
}
 foreach($subject as $key=>$name){
	 

	   
$html.='<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal"  novalidate="novalidate" action="'.SITE_URL.'/admin/studentexamresult/resultallupdatemarks/'.$students['class_id'].'/'.$students['sect_id'].'/'.$students['student']['acedmicyear'].'/'.$students['stud_id'].'">
		   
	<tr style="font-size:16px;"> 
<td width="24%" style="border-top:1px solid #000;border-bottom:1px solid #000; border-left:1px solid 
#000; height:15px; line-height:15px; border-right:1px solid #000; " 
align="center">&nbsp; '.$name['exprint'].'</td>';

$ter=0;
	   foreach($findroleexamtype as $er){  
		   
		   	
		   
		   
		   $newmarks=$this->Comman->fsubjectmarks2($students['stud_id'],$students['sect_id'],$students['class_id'],$er['etype_id'],$name['id'],$students['term']);
if($newmarks['marks']!=''){
			  if($er['etype_id']=="1"){ 
		
					
					if($newmarks['marks']!='0' && $newmarks['marks']!='A' ){ 
					
					$weighted=$newmarks['marks']/2;  
					
					$newmaj=round($weighted);
					
					 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control" name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 
		
			 $ter +=$newmaj;
			 
				
					
					 }else{
						
			
						 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;" class="form-control"  name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
	
						  $ter +=$newmarks['marks'];
						  
					
						
						} 
		
		}else{
					
					 	 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center"><input type="text"  style="color: #000;"  class="form-control"  name="marks['.$newmarks['id'].']" value="'.$newmarks['marks'].'"></td>';
			 
			
			 $ter +=$newmarks['marks'];
			 
		
			
		}
		
	}else{
			 $html.='<td width="15%" style="border-top:1px solid #000;  
			 border-right:1px solid #000; border-bottom:1px solid #000; 
			 height:15px; line-height:15px;" align="center">--</td>';
		
		
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
	

 $html.='
<td  style="padding: 2px; 
 align="center"><input type="submit" name="submit" value="Update Marks" class="btn btn-default"></td>
';
$html.='</tr></form>';

} 


$html.='</table>
<br><br>
';

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






