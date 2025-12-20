<div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">
		            <i class="fa fa-plus-square"></i> Siblings Detail</h4>
		        
</div>



<div class="modal-body">
	<div class="row">
		<div class="col-sm-12">
		<div class="table-responsive">
  <table  class="table table-bordered table-striped">
<tbody> 
  
    <tr>
		  <th>S.No</th>
    <th>Sr.No</th>
   
    <th>Student Name</th>
    <th>Class</th>
    <th>Section</th>
        <th>Action</th>
   
    
    </tr>
		       
  	<?php 
   $counter = 1;
		if(isset($students) && !empty($students)){ 
		
		
			foreach($students as $key=>$element) {
			
			
				 $s_id=$element['class_id'];
				 $c_id=$element['section_id'];
		?>
				 <tr>
		 <td><?php echo $counter;  ?></td>
			     <td><?php echo $element['enroll'];  ?></td>
			  
			     <td><?php   $studentname= $element['fname']." ".$element['middlename']." ".$element['lname']; echo $studentname; ?></td>
			      
			       
			   
			
			      <td><?php $class=$this->Comman->findclasses($s_id);
			           
			              echo $class[0]['title'];
			     ?>    </td>
			      <td><?php 
			           $section=$this->Comman->findsections($c_id);
			              echo $section[0]['title'];
			     ?>    </td>
			     <td><a title="Deposit-Fees" href="<?php echo SITE_URL; ?>admin/studentfees/index/<?php echo $element['id']; ?>/<?php echo $element['acedmicyear']; ?>"><img src="<?php echo SITE_URL; ?>images/payment.png"></a></td>
			     
			     
                          </tr>
		<?php $counter++;}
	  } else { ?>
	  
	  <td colspan="8" style="text-align:center;">No Siblings data find</td>   
	  
	  <?	} ?>
                    
         </table>      
      
      <div>      
		
  </div>
 </div>
</div><!--./modal-body-->
<div class="modal-footer">
	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
	 
	
</div><!--./modal-footer-->

