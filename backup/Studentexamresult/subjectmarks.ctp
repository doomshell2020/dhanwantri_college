  <?php $roleid=$this->request->session()->read('Auth.User.role_id');
     if($roleid=='3' || $roleid=='4'){ ?>
 <div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">
		            <i class="fa fa-plus-square"></i> View Subjects / Marks </h4>
		        
</div>
 <div class="box-header with-border">
		    
		      <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
		<?php $count=0; foreach($studentexamresult as $work){  $start=$work['exam']['e_start']; $end=$work['exam']['e_end'];?>
			 <?php  } ?>	<strong>Exam Start Date : </strong><?php echo date('d-m-Y',strtotime($start)); ?> | <strong>Exam End Date: </strong><?php echo date('d-m-Y',strtotime($end)); ?> </span>
		    </div>
 <div class="box-body" >
                    <table id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
      <th>Subject</th>
 <th> Marks</th>

<th>Given Marks</th>
     
     
    </tr>
 </thead>
                <tbody id="example2">
		<?php  
		 if(isset($studentexamresult) && !empty($studentexamresult)){ 
		foreach($studentexamresult as $work){ ?>
		<tr>
		<td><?php echo $work['subject']['name']; ?></td>
		<td><?php $totalmarks=0; $totalmarks=$this->Comman->findminimummarks($work['exam_id'],$classid,$work['subject_id']); echo $totalmarks['max_marks']; ?></td>
		
			<td><?php echo $work['marks']; ?></td>
		
		</tr>
		<?php } }else{ ?>
		<tr>
		<td>NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
                
              </table>
<div class="modal-footer">
	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
		 
	
</div><!--./modal-footer-->
 <?php } else {?>
  <div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">
		            <i class="fa fa-plus-square"></i> View Subjects / Marks </h4>
		        
</div>
 <div class="box-header with-border">
		    
		      <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
		<?php $count=0; foreach($studentexamresult as $work){  $start=$work['exam']['e_start']; $end=$work['exam']['e_end'];?>
			 <?php  } ?>	<strong>Exam Start Date : </strong><?php echo date('d-m-Y',strtotime($start)); ?> | <strong>Exam End Date: </strong><?php echo date('d-m-Y',strtotime($end)); ?> </span>
		    </div>
 <div class="box-body" >
                    <table id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
      <th>Subject</th>
 <th> Marks</th>
 <th>Minimum marks</th>
<th>Given Marks</th>
     
     
    </tr>
 </thead>
                <tbody id="example2">
		<?php  
		 if(isset($studentexamresult) && !empty($studentexamresult)){ 
		foreach($studentexamresult as $work){ ?>
		<tr>
		<td><?php echo $work['subject']['name']; ?></td>
		<td><?php $totalmarks=0; $totalmarks=$this->Comman->findminimummarks($work['exam_id'],$work['subject_id']); echo $totalmarks['max_marks']; ?></td>
		<td><?php echo $totalmarks['min_marks']; ?></td>
		<?php if($work['status']=='Y') {?>
			<td><?php echo $work['marks']; ?></td>
		<?php } else { ?>
		<td><?php echo ''; ?></td>
		<?php }?>
		</tr>
		<?php } }else{ ?>
		<tr>
		<td>NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
                
              </table>
<div class="modal-footer">
	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
		 
	
</div><!--./modal-footer-->

 <?php }?>
