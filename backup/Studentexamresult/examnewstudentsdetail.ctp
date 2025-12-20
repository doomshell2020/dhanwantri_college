<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
   <h1>Upload New Students Result</h1>
     <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL;?>studentexamresult/examcontrolview"><i class="fa fa-home"></i>Home</a></li>
</ol>
    </section>

    <!-- Main content -->
    <section class="content">
     <div class="row"  >
		     <?  echo $this->Flash->render();  ?>
<?   $rolepresent= $this->request->session()->read('Auth.User.role_id');
?>
        <div class="col-xs-12">
          
  <div class="box" >
            <div class="box-header">
       
<div class="box-header with-border">
		
        
          <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
    
            <i class="fa fa-search" aria-hidden="true"></i> <strong>Student Name: </strong><b style="color:red;"><? echo $students[0]['fname']." ".$students[0]['middlename']." ".$students[0]['lname']; ?></b> | <strong>Class Name : </strong><? echo $students[0]['class']['title']; ?> | <strong>Section Name : </strong><? echo $students[0]['section']['title']; ?>  | <strong>Academic Year : </strong><? echo $students[0]['acedmicyear']; ?> </span>
            
            
     </div>


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
          <div class="box-body" >
          
         
	
                    <table class="table table-bordered table-striped" >
                
  
 <thead>
	 	
    <tr>
<th>#</th>
<th>Subject Name</th>

<? foreach ($examtypes  as $keys){
    $termm=$keys['termf'];
    $e_type_id=explode(',',$keys['e_type_id']);
       foreach($e_type_id as $e=>$j){         
    $stcounr=$this->Comman->findexamner2($students[0]['class']['id'],$j,$termm);
    if($stcounr['name']){  echo "<th>".$stcounr['name']." (".$stcounr['maxnumber'].")</th>"; 
		 } } } ?>

</tr>
 </thead>

                <tbody id="example2">
	<?php   echo $this->Form->create('Studentexamresultss',array('class'=>'form-horizontal','enctype' => 'multipart/form-data','validate')); ?>
					 <input type="hidden" name="exam_id" value="<? echo $examtypes[0]['id']; ?>">
	
					<input type="hidden" name="class_id" value="<? echo $students[0]['class']['id']; ?>" >
              
                 <input type="hidden" name="sect_id" value="<? echo $students[0]['section']['id'] ?>" >
                 			<input type="hidden" name="stud_id" value="<? echo $students[0]['id']; ?>" >

   <?php
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		
			$clid=['12','13','15','17','20','22','26','27'];
	if(!in_array($students[0]['class']['id'],$clid)){
		$subject=$this->Comman->findsubjecttoexam($examtypes[0]['id'],$students[0]['class']['id']);  
		$subject2=$this->Comman->findsubjecttoexam2($examtypes[0]['id'],$students[0]['class']['id']);  
		
	}else{

		foreach($ssstotal as $rt=>$er){
		$subject2[]=$this->Comman->findsubjecttoexam2l($examtypes[0]['id'],$students[0]['class']['id'],$er);  
		
	}

		
	}
	


		if(isset($subject) && !empty($subject)){ 
		

		foreach ($subject  as $works){ ?>
			
		
				 
		
		<tr>
			<td><? echo $counter; ?></td>
			
			<td><b><? echo $works['exam_subject']['exprint']; ?> :</b></td>
		
		<? foreach ($examtypes  as $keys){
    $termm=$keys['termf'];
    $e_type_id=explode(',',$keys['e_type_id']);
       foreach($e_type_id as $e=>$j){         
    $stcounr=$this->Comman->findexamner2($students[0]['class']['id'],$j,$termm);
    if($stcounr['name']){ ?> 
		<td><input type="text" placeholder=" Enter <? echo $stcounr['name']; ?> Result" required="required" name="subjecresult[]"> 
		<input type="hidden" name="etype_id[]" value="<? echo $j; ?>">
		<input type="hidden" name="subject_id[]" value="<? echo $works['exam_subject']['id']; ?>">
		<input type="hidden" name="term[]" value="<? echo $termm; ?>">
		</td>
		 <? } } } ?>
</tr>
		<?php $counter++; } }else if(isset($subject2) && !empty($subject2)){ 
		

		foreach ($subject2  as $works){ ?>
		
		<tr>
			<td><? echo $counter; ?></td>
			
			<td><b><? echo $works['exprint']; ?> :</b></td>
		
		<? foreach ($examtypes  as $keys){
    $termm=$keys['termf'];
    $e_type_id=explode(',',$keys['e_type_id']);
       foreach($e_type_id as $e=>$j){         
    $stcounr=$this->Comman->findexamner2($students[0]['class']['id'],$j,$termm);
    if($stcounr['name']){ ?> <td><input type="text" placeholder=" Enter <? echo $stcounr['name']; ?> Result" required="required" name="subjecresult-<? echo $stcounr['id']; ?>-<? echo $works['id']; ?>" > 
		<input type="hidden" name="etype_id[]" value="<? echo $j; ?>">
		<input type="hidden" name="subject_id[]" value="<? echo $works['id']; ?>">
		</td> <?
		 } } } ?>
  
  
              
		
                </tr>
		<?php $counter++; } }else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
               
              
                <?php
                
                if(isset($subject) && !empty($subject)){ 
                 echo $this->Form->submit('Upload', array('class' => 'btn btn-info pull-right','style'=>'margin-right: 10px;', 'title' => 'Add'));  }else if(isset($subject2) && !empty($subject2)){ 
                 echo $this->Form->submit('Upload', array('class' => 'btn btn-info pull-right','style'=>'margin-right: 10px;', 'title' => 'Add'));  } ?> 
                  <?php echo $this->Form->end(); ?>
  </tbody>


              </table>
              
              
         
    <script>
      $(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".globalmodalclasssection").click(function(event){

  $('.modal-content').html('');
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

      });
  }); 
</script>
        
   
            

            
          </div>
          <!-- /.box-body -->
          
      
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->
  </div>
