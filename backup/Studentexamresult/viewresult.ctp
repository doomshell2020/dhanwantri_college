<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
 
    <section class="content-header">
      <h1>
        <? echo $examname; ?> Exam Result 
       
      </h1>
                 <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i>Home</a></li>

<li class="active">Students Result</li>
        </ol>
      
    </section>

    <!-- Main content -->
    <section class="content">
     <?php /* ?>
     <div class="row">
        <div class="col-xs-12">
          
  <div class="box">

       
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">Search Student</h3>
      
            </div>
    
            <!-- /.box-header -->
<?php echo $this->Flash->render(); ?>
            <div class="box-body">
    

<div class="manag-stu">
  
<script inline="1">
//<![CDATA[
$(document).ready(function () {
$("#TaskAdminCustomerForm").bind("submit", function (event) {
$.ajax({
async:true,
 data:$("#TaskAdminCustomerForm").serialize(),
 dataType:"html", 

success:function (data, textStatus) {

$("#example2").html(data);}, 
type:"POST", 
url:"<?php echo SITE_URL; ?>admin/studentexamresult/search"});
return false;
});
});
//]]>
</script>
   <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


  
  
  
  
  
  <div class="form-group">
    
   
 <div class="col-sm-3">

      <input type="text" class="form-control" name="enroll" placeholder="Enter Gr.No Or Student ID">
    </div>
    
    
 <div class="col-sm-3">

      <input type="text" class="form-control" name="fname" placeholder="Enter Student First Name">
    </div>   
     <!--<div class="col-sm-3">
 <label>Grade</label>
       <select class="form-control" name="is_pass">
<option value=""></option>
<option value="1">Pass</option>
<option value="0">Fail</option>
</select>
   </div>  -->
    <div class="col-sm-2" style="top: 0px;">
      <button type="submit" class="btn btn-success">Search</button>
       <button type="reset" class="btn btn-primary">Reset</button>
    </div>
  </div>
     <?php
echo $this->Form->end();
?>   
  
</div>
        
        </div>
        
          </div>
          *   </div>  </div><?php */ ?>
    
    
    
    
    
    
      <div class="row"  >
        <div class="col-xs-12">
          
  <div class="box" >
        <div class="box-header with-border">
        
          <span class="text-muted" style="padding-left:10px;font-size:15px;">
    
      <strong>Class Name : </strong><?php echo $classname; ?> | <strong>Section Name : </strong><?php echo $sectionname; ?> | <strong>Exam : </strong><?php echo $examname; ?> | <strong>Academic Year : <?php echo $acedamicyear; ?> </strong>  </span>
        </div>
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title"> View Students <?php echo $examname; ?> List </h3>
<?  $rolepresent= $this->request->session()->read('Auth.User.role_id');     	if($rolepresent=='3'){  ?>

<p class="text-right btn-view-group">
  <a class="btn btn-primary" href="<? echo SITE_URL; ?>admin/studentexamresult/exportresultpdf/<?php echo $examid; ?>/<? echo $section; ?>/<? echo $class_id; ?>/<? echo $subjec; ?>" target="blank"><i class="fa 
  fa-file-pdf-o"></i> Print Result</a>
  </p>
<? } 

	if($rolepresent=='4' || $rolepresent=='13'){  ?>

<p class="text-right btn-view-group">
  <a class="btn btn-primary" href="<? echo SITE_URL; ?>admin/studentexamresult/exportresult/<?php echo $examid; ?>/<? echo $section; ?>/<? echo $class_id; ?>" target="blank"><i class="fa 
  fa-file-pdf-o"></i> Export Excel</a>
  </p>
<? } ?>

   <?php echo $this->Flash->render(); ?>
            </div>
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
       
            <!-- /.box-header -->
            <!-- form start -->
               <div class="box-body">
          <div class="box-body" style="overflow-x:auto;" >
			  
			  <? $roleid=$this->request->session()->read('Auth.User.role_id');
     if($roleid=='4'  || $roleid=='13'  || $roleid=='1'){ ?>
              <table id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
      <th>#</th>
     <th> Sr. No.</th>
 <th>Name</th>
<? 
$findroleexamtype=$this->Comman->findeexamtsype($examid,$section,$class_id);

$studentsubject=$this->Comman->fsubjectonly($examid,$section,$class_id);


   if(isset($studentsubject) && !empty($studentsubject)){ 
	   
	    foreach($findroleexamtype as $er){  
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
		foreach($studentsubject as $works){ ?>
			<th><?php echo $findetypname[0]['name']."-".$works['exam_subject']['exprint']; ?></th>
			<?	
		} }
	} ?>
      
    <?php $roleid=$this->request->session()->read('Auth.User.role_id');
     if($roleid=='1'){ ?>
     <th>Result Status</th>
  <?php } ?>
    </tr>
 </thead>
                <tbody id="example2">
    <?php $page = $this->request->params['paging']['Students']['page'];
    $limit = $this->request->params['paging']['Students']['perPage'];
    $counter = ($page * $limit) - $limit + 1; 
    if(isset($students) && !empty($students)){ 
    foreach($studentsda as $work){
    ?>
                <tr>
               <td><?php echo $counter;?></td>
   
      <td><?php echo $work['student']['enroll']; ?></td>
 
      <td><?php echo ucwords(strtolower($work['student']['fname']))." ".ucwords(strtolower($work['student']['middlename']))." ".ucwords(strtolower($work['student']['lname'])); ?></td>
   <? 
   
    if(isset($studentsubject) && !empty($studentsubject)){ 
		

		 foreach($findroleexamtype as $ers){
			 
			   
			  $findetypnasme=$this->Comman->findsubjectstotalssnames2($ers['etype_id']);
			  
			//  pr( $findetypnasme); 
		$studentexamresult=$this->Comman->fsubjectmarks($examid,$work['student']['id'],$section,$class_id,$ers['etype_id']);

			   
		foreach($studentexamresult as $works){ 
			
		
    ?>

		
		
			
		<? if($findetypnasme[0]['id']=="1"){ 
			?>
				<td  <? if($works['marks']=='0' || $works['marks']=='A' ){ 
					?>style="color:red;"<? } ?>><b><?php 
					
					if($works['marks']!='0' && $works['marks']!='A' ){ 
					
					$weighted=$works['marks']/2;  
					echo round($weighted);   }else{
						
						echo $works['marks'];
						
						} ?></b></td>
		<?	
		}else{
					?>
				<td  <? if($works['marks']=='0' || $works['marks']=='A' ){ 
					?>style="color:red;"<? } ?>><b><?php 
					
					if($works['marks']!='0' && $works['marks']!='A' ){ 
					
				
				echo $works['marks'];   }else{
						
						echo $works['marks'];
						
						} ?></b></td>
		<?	
			
			
		}
  } }  } ?>
             
    
                </tr>
                <script>
$(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $("#globalModal<?php echo $work['student']['id']; ?>").click(function(event){

 
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

        });
    }); 
</script>
  <div class="modal" id="globalModal<?php echo $work['student']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="loader">
                                <div class="es-spinner">
                                    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                
    <?php $counter++;} }else{ ?>
    <tr>
    <td>NO Data Available</td>
    </tr>
    <?php } ?>  
                </tbody>
                
              </table>
        
        
    <?   }else if($roleid=='3'){    ?>
		
		   <table id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
      <th>#</th>
     <th> Sr.No.</th>
 <th>Name</th>
<? 

$findroleexamtype=$this->Comman->findroleexamtype($examid,$section,$class_id);



	$st=$this->Comman->findsubjectopt($class_id,$section);

		
				

if($subjecname){
	
	$studentsubject=$this->Comman->fsubjectonlyteachers2($examid,$section,$class_id,$subjecname);
	
}else{
	
	$studentsubject=$this->Comman->fsubjectonlyteachers($examid,$section,$class_id);
	
}





   if(isset($studentsubject) && !empty($studentsubject)){
	   
	   
	   
	   foreach($findroleexamtype as $er){  
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
		   

		foreach($studentsubject as $works){ 
			?>
			<th><?php echo $findetypname[0]['name']."-".$works['exam_subject']['exprint']; ?></th>
			<? if($findetypname[0]['id']=="1"){   ?>
				
				<th><?php echo 
				$findetypname[0]['name']."-".$works['exam_subject']['exprint']."<br>(Weighted marks)"; ?></th>
				<? } 	
		} }
		
		
	}else{
		
		if(in_array("65",$st) || in_array("70",$st) || in_array("71",$st)){
					
			if($class_id=="10"){
						$rh='29';
						$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
						
							$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
						
					
						
					}
					
					
					if($class_id=="11"){
						$rh='38';
							$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
						
					}
				}else if(in_array("66",$st) || in_array("67",$st) || in_array("68",$st)){
					if($class_id=="10"){
						$rh='28';
						$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
					}
					
					
					if($class_id=="11"){
						$rh='37';
							$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
						
					}
					
				}
				//pr($studentsubjects);
				
				$findroleexamtype2=$this->Comman->findroleexamtype2($examid,$section,$class_id);
				if(isset($studentsubjects) && !empty($studentsubjects)){
	   
	   
	   
	   foreach($findroleexamtype2 as $er){  
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
		   

		foreach($studentsubjects as $works){ 
			?>
			<th><?php echo $findetypname[0]['name']."-".$works['exam_subject']['exprint']; ?></th>
			<? if($findetypname[0]['id']=="1"){   ?>
				
				<th><?php echo 
				$findetypname[0]['name']."-".$works['exam_subject']['exprint']."<br>(Weighted marks)"; ?></th>
				<? } 	
		} }
		
		
	}
		

		
		} ?>
      
    <?php $roleid=$this->request->session()->read('Auth.User.role_id');
     if($roleid=='1'){ ?>
     <th>Result Status</th>
  <?php } ?>
    </tr>
 </thead>
                <tbody id="example2">
    <?php $page = $this->request->params['paging']['Students']['page'];
    $limit = $this->request->params['paging']['Students']['perPage'];
    $counter = ($page * $limit) - $limit + 1; 
    if(isset($students) && !empty($students)){ 
		
		
    foreach($studentsda as $work){
    ?>
                <tr>
             
   <?
   
   
   $st=$this->Comman->findsubjectopt($class_id,$section);
			
			
				
    if(isset($studentsubject) && !empty($studentsubject)){ 
		$g=0;
		$ert='0';
		 foreach($findroleexamtype as $ers){
			 
			  $findetypnasme=$this->Comman->findsubjectstotalssnames2($ers['etype_id']);
			
			if($subjecname){
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers2($examid,$work['student']['id'],$section,$class_id,$ers['etype_id'],$subjecname);	
	
}else{
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers($examid,$work['student']['id'],$section,$class_id,$ers['etype_id']);	
	
}
			 if(!empty($studentexamresult)){
		 
			 	foreach($studentexamresult as $works){ 
							$ert=$works['marks'];
					
						}
						
			if($g==0 ){
    ?>

		  <td><?php echo $counter++;?></td>
   
      <td><?php echo $work['student']['enroll']; ?></td>
 
      <td><?php echo ucwords(strtolower($work['student']['fname']))." ".ucwords(strtolower($work['student']['middlename']))." ".ucwords(strtolower($work['student']['lname'])); ?></td>
		<? $g++;} 
		foreach($studentexamresult as $works){ 
			 ?>
	
			<td  <? if($works['marks']=='0' || $works['marks']=='A' ){ ?>style="color:red;"<? } ?>><b><?php echo $works['marks']; ?></b></td>
		<? if($ers['etype_id']=="1"){ 
			?>
				<td  <? if($works['marks']=='0' || $works['marks']=='A' ){ 
					?>style="color:red;"<? } ?>><b><?php 
					
					if($works['marks']!='0' && $works['marks']!='A' ){ 
					
					$weighted=$works['marks']/2;  
					echo round($weighted);   }else{
			
						echo $works['marks'];
						
						} ?></b></td>
		<?	
		}
  } } } }else{
	  $gs=0;
	
	  $ert='0';
	  
	  	 foreach($findroleexamtype2 as $ers){
			 
			  $findetypnasme=$this->Comman->findsubjectstotalssnames2($ers['etype_id']); 
	  
	   if(in_array("65",$st) || in_array("70",$st) || in_array("71",$st)){
					
			if($class_id=="10"){
						$rh='29';
						$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
						foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
						
						
						
					}
					
					
					if($class_id=="11"){
						$rh='38';
							$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
					foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
						
					}
				}else if(in_array("66",$st) || in_array("67",$st) || in_array("68",$st)){
					if($class_id=="10"){
						$rh='28';
						$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
						foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
					
					}
					
					
					if($class_id=="11"){
						$rh='37';
							$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
							foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
					
						
					}
					
				}
	   if(!empty($studentexamresults)){
	 if($gs==0){
    ?>

		  <td><?php echo $counter++;?></td>
   
      <td><?php echo $work['student']['enroll']; ?></td>
 
      <td><?php echo ucwords(strtolower($work['student']['fname']))." ".ucwords(strtolower($work['student']['middlename']))." ".ucwords(strtolower($work['student']['lname'])); ?></td>
		<? $gs++;} 
	  
	  	foreach($studentexamresults as $works){ 
			?>
			<td  <? if($works['marks']=='0' || $works['marks']=='A' ){ ?>style="color:red;"<? } ?>><b><?php echo $works['marks']; ?></b></td>
		<? if($ers['etype_id']=="1"){ 
			?>
				<td  <? if($works['marks']=='0' || $works['marks']=='A' ){ 
					?>style="color:red;"<? } ?>><b><?php 
					
					if($works['marks']!='0' && $works['marks']!='A' ){ 
					
					$weighted=$works['marks']/2;  
					echo round($weighted);   }else{
						
						echo $works['marks'];
						
						} ?></b></td>
		<?	
		}
  }  }
	  
	  
	  
	  
	} } ?>
             
    
                </tr>
                <script>
$(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $("#globalModal<?php echo $work['student']['id']; ?>").click(function(event){

 
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

        });
    }); 
</script>
  <div class="modal" id="globalModal<?php echo $work['student']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="loader">
                                <div class="es-spinner">
                                    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                
    <?php } }else{ ?>
    <tr>
    <td>NO Data Available</td>
    </tr>
    <?php } ?>  
                </tbody>
                
              </table>
        
        
		
		
		
		<? } ?> 
            

            
          </div>
          <!-- /.box-body -->
          
           <div class="box-footer">
 

      <?php
        $ststatus=$this->Comman->showestudentexamstatus($examid,$section); 
               {
                $stdstus=$ststatus[0]['status']; 
               
         $roleid=$this->request->session()->read('Auth.User.role_id');
     if($roleid=='3' && $stdstus=='N'){
     
      echo $this->Html->link('Save & Finalize', [
          'action' =>'save_finalize/'.$examid.'/'.$section,
           Y     
      ],['class'=>'btn btn-default pull-right']);  } ?>


       <?php
 
         $roleid=$this->request->session()->read('Auth.User.role_id');
     if($roleid=='1' && $stdstus=='Y'){
     
      echo $this->Html->link('Drop Result', [
          'action' =>'drop_result/'.$examid.'/'.$section,
           N    
      ],['class'=>'btn btn-default pull-right']);  } }?>


       
      </div>
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>




