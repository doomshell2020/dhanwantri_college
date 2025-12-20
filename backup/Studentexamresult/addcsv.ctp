<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
	 <h1>Exam Result Upload CSV </h1>
		                 <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>studentexamresult/addcsv"><i class="fa fa-home"></i>Home</a></li>

<li class="active">Upload CSV </li>
	      </ol>
            
		      <div id="imagePreview" style="
    position: absolute;
    z-index: 9;
    left: 0;
    right: 0;
    text-align: center;
    top: 0px;
    margin-top: 88px;
"></div>
	    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		
        
          <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
    
      <strong>Class Name : </strong><?php echo $classname; ?> | <strong>Section Name : </strong><?php echo $sectionname; ?> | <strong>Exam Name: </strong><?php echo $examname; ?> | <strong>Academic Year : </strong><?php echo $acedamicyear; ?>  | <strong>Subject  To Be Upload:</strong> <?php echo $subjectname; ?>   </span>
     </div>
	<?  $etype=explode(',',$e_type_id); $nametype=$this->Comman->findsubjectstotalssnames2($etype[0]); ?>
	
	
	
	
<a href="<?php echo SITE_URL; ?>admin/studentexamresult/export/<?php echo $exid; ?>/<?php echo $sectionid; ?>/<? echo $e_type_id; ?>/<? echo $class_id; ?>/<?php echo $subjec; ?>"> &nbsp; &nbsp;Click Here For Download <span style="color:red;"><? echo $nametype[0]['examname']; ?></span> CSV Format</a>
		   
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

 
          
		<?php echo $this->Form->create($classes, array(
                       'class'=>'form-horizontal',
			'id' => 'sevice_form',
			'type'=>'file',
             'enctype' => 'multipart/form-data',
              'validate')); 
                     	
                     	$rolepresent=$this->request->session()->read('Auth.User.role_id');     
                     	 $clodates=strtotime(date('Y-m-d',strtotime($resultuploadlast_date))); $currentdoates=strtotime(date('Y-m-d'));
      if($clodates>=$currentdoates && $rolepresent=='3'){  ?>
		   
		      <div class="box-body">
				  
		        <div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Upload CSV</label>

		          <div class="col-sm-10">
			<?php echo $this->Form->input('file',array('class'=>'form-control','onchange'=>'return fileValidation()','type'=>'file','required', 'id'=>'title','label' =>false)); ?>
		           <input type="hidden" name="exid" value="<?php echo $exid; ?>">
		           <input type="hidden" name="query" value="<?php echo $query; ?>">
		            <input type="hidden" name="sect_id" value="<?php echo $sectionid; ?>">
		              <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
		              <input type="hidden" name="subj" value="<?php echo $subjec; ?>">
		          </div>
		        </div>
		        
<script>
function fileValidation(){
    var fileInput = document.getElementById('title');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.csv)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .csv only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}


$(function() { //shorthand document.ready function
    $('#sevice_form').on('submit', function(e) { //use on if jQuery 1.7+
		                document.getElementById('imagePreview').innerHTML = '<img  style="width: 508px;" src="https://www.heysimports.co.za/site-images/loading.gif"/>';
       
    });
});
</script>
		      <!-- /.form group -->
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
		     
			 <?php  
				if(isset($classes['id'])){
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Upload','style'=>'margin-top: -33px;')
				); }else{ 
				echo $this->Form->submit(
				    'Upload', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Upload','style'=>'margin-top: -33px;')
				);
				}
		       ?>
		      </div>
		      <!-- /.box-footer -->
		  <?php echo $this->Form->end();   }else{     ?>
			        <div class="box-body">
				  
		        <div class="form-group">
		          <span style="padding-left:16px;color:red;">Last Upload Date Has Been Expired,Please Contact Your Exam Coordinator !!! </span>
			   </div>
			    </div>
			  <? } ?>
		  
		 
		  
		
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->

    
    <?
  $findrolesexamtype=$this->Comman->findroleexamtype($examid,$section,$class_id);

    if(isset($findrolesexamtype) && !empty($findrolesexamtype)){ ?>
      <div class="row"  >
        <div class="col-xs-12">
          
  <div class="box" >
        
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title"> View Students <?php echo $examname; ?> List </h3>
<?  $rolepresent= $this->request->session()->read('Auth.User.role_id');     	if($rolepresent=='3'){   ?>

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
			 if($roleid=='4'  || $roleid=='13'  || $roleid=='1'){ 
		 
		  ?>
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

		
		
			
		<? if($findetypnasme[0]['id']=="1" || $findetypnasme[0]['id']=="26"){ 
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
		
		   <table  class="table table-bordered table-striped" >
                
  
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
			<? if($findetypname[0]['id']=="1"  || $findetypname[0]['id']=="26"){   ?>
				
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
			<? if($findetypname[0]['id']=="1"  || $findetypname[0]['id']=="26"){   ?>
				
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

if(empty($studentexamresult)){
		if($subjecname){
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers21($examid,$work['student']['id'],$section,$class_id,$ers['etype_id'],$subjecname);	
	
}else{
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers212($examid,$work['student']['id'],$section,$class_id,$ers['etype_id']);	
	
}
	
	
	
	
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
		<? if($ers['etype_id']=="1" || $ers['etype_id']=="26"){ 
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
		<? if($ers['etype_id']=="1" || $ers['etype_id']=="26"){ 
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
        
        
		
		
		
		<? }  ?> 
            

            
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
    
    <!-- /.content -->
  </div>
<? } ?>
  </section>




