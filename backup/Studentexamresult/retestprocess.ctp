<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
	 <h1>Absent Student Detail</h1>
		                 <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>studentexamresult/examcontrolview"><i class="fa fa-home"></i>Home</a></li>


	      </ol>
            
		      
	    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		
        
       
	


  <? if($examretest) { ?>


	<?php   echo $this->Form->create('Studentexamresultss',array('class'=>'form-horizontal','enctype' => 'multipart/form-data','validate')); ?>

<div class="modal-body">

		<span class="text-muted" style="padding-left:10px;font-size:15px;">
    
      <strong>Class Name : </strong><?php $class= $this->Comman->showclasstitle($examretest[0]['Students__class_id']); echo $class['title']; ?> | <strong>Section Name : </strong><?php  $section= $this->Comman->findsection123($examretest[0]['Students__section_id']); echo $section['title']; ?>   </span>
	<div class="row">
		<div class="col-sm-12">
		<div class="table-responsive" style="overflow-y:auto;">
  <table  class="table table-bordered table-striped">
  
 <thead>
 
  <tr>
     
       <th>Sr.No.</th>
       <th>Name</th>
       
       <? 
        $roleid=$this->request->session()->read('Auth.User.role_id');
       if($roleid=='3'){
       
       $subject=$this->Comman->findsubjecttoexambyteachers($examretest[0]['Studentexamresult__exam_id'],$examretest[0]['Studentexamresult__class_id']); 

 
}else{
	
	$subject=$this->Comman->findsubjecttoexam($examretest[0]['Studentexamresult__exam_id'],$examretest[0]['Studentexamresult__class_id']); 
}



	$findroleexamtype2=$this->Comman->findeexamtsype($examretest[0]['Studentexamresult__exam_id'],$examretest[0]['Studentexamresult__sect_id'],$examretest[0]['Studentexamresult__class_id']);


	   foreach($findroleexamtype2 as $er){  
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
		   

		foreach($subject as $works){ 
			?>
			<th><?php echo $findetypname[0]['name']."-".$works['exam_subject']['exprint']."(".$findetypname[0]['maxnumber'].")"; ?></th>
			<?  	
		} }
		
     ?>
     
</tr>
 </thead>
                <tbody>
               
                <? if(isset($examretest) && !empty($examretest)){ 
               
                foreach ($examretest  as $key){ ?>
                 <tr>
                 
                 
               <td><?php echo $key['Students__enroll'];?></td>
               <td><?php echo ucwords(strtolower($key['Students__fname']));?> <?php echo ucwords(strtolower($key['Students__middlename']));?> <?php echo ucwords(strtolower($key['Students__lname']));?></td>
               
       
                    
           
              <input type="hidden" name="class_id" value="<? echo $key['Studentexamresult__class_id'] ?>" >
              
                 <input type="hidden" name="sect_id" value="<? echo $key['Studentexamresult__sect_id'] ?>" >
                 
                    <input type="hidden" name="exam_id" value="<? echo $key['Studentexamresult__exam_id'] ?>" > 
                    
                  
     
            <? 
              foreach($findroleexamtype2 as $er){   ?>
				  
				
				  
				  
				  
				  <?
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
           
            foreach($subject as $k=>$value){ 
            
            

            $findvlues=$this->Comman->findsubjectvalue($value['exam_subject']['id'],$key['Studentexamresult__class_id'],$key['Studentexamresult__exam_id'],$key['Studentexamresult__stud_id'],$key['Studentexamresult__sect_id'],$er['etype_id']);  ?><td> <? if($findvlues['marks']=='A' || $findvlues['marks']=='' ){ ?>
				<input type="hidden" name="subject_id[]" value="<? echo $value['exam_subject']['id']; ?>" >
				<input type="hidden" name="stud_id[]" value="<? echo $key['Students__id'] ?>" >
				  <input type="hidden" name="etype_id[]" value="<? echo $er['etype_id'] ?>" >
				    <input type="hidden" name="id[]" value="<? echo $findvlues['id']; ?>" >   
                          
                    
                    <?
				
				  echo $this->Form->input('marks[]', array('maxlength'=>'2','type'=>'text','label'=> false, 'value'=>$findvlues['marks'],'id' => 'id', 'style'=>'max-width: 45px;color:red;')); }else{ ?>
					  		<input type="hidden" name="subject_id[]" value="<? echo $value['exam_subject']['id']; ?>" >
					  <input type="hidden" name="stud_id[]" value="<? echo $key['Students__id'] ?>" >
					    <input type="hidden" name="etype_id[]" value="<? echo $er['etype_id'] ?>" >
              <input type="hidden" name="id[]" value="<? echo $findvlues['id']; ?>" >   
            
           <?  echo $this->Form->input('marks[]', array('maxlength'=>'2','type'=>'text','readonly','label'=> false, 'value'=>$findvlues['marks'],'id' => 'id', 'style'=>'max-width: 45px;'));
               }  ?></td> <? } } ?>
               </tr>
                <? } } ?>
                </tbody>
        </table>
        </div>
        </div>
        </div>
        



   
  <?php
				if(isset($students['id'])){
				//echo $this->Form->submit( 'Update',  array('class' => 'btn btn-info pull-left','style'=>'', 'title' => ''));
				 }else{ 
	echo $this->Form->submit('Upload', array('class' => 'btn btn-info pull-right','style'=>'margin-right: 10px;', 'title' => 'Add'));
				}
		       ?> 


 <?php echo $this->Form->end(); ?>
  <? }else{ ?>
        
        <p style="text-align:center;">No Absent Student Detacted</p>
        
        <? } ?>
        
        
         </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


