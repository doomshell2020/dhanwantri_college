<?php if ($student['request_status'] == 'N' || $student['request_status'] == '') { //pr($student);die;
   ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-file-pdf-o"></i>Certificate Approvales <?php echo $student['fname'] . " " . $student['middlename'] . " " . $student['lname']; ?> (<?php echo $student['enroll']; ?>)
   </h4>
</div>
<?php echo $this->Form->create($student, array('class' => 'form-horizontal')); ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <div class="col-sm-12">
               <label>Description</label>
               <?php
                  echo $this->Form->input('description', array('class' => 'form-control', 'type' => 'textarea', 'label' => false));
                  ?>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
   <?php
      echo $this->Form->submit(
      	'Submit',
      	array('class' => 'btn btn-info pull-left', 'style' => 'margin-right: 10px;')
      );
      
      ?>
</div>
<?php echo $this->Form->end(); ?>
<?php } else { ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-file-pdf-o"></i>Certificate Approvales <?php echo $student['fname'] . " " . $student['middlename'] . " " . $student['lname']; ?> (<?php echo $student['enroll']; ?>)
   </h4>
</div>
<?php echo $this->Form->create($student, array('class' => 'form-horizontal')); ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <div class="col-sm-12">
               <h1 style="text-align: center;">Your request is under process</h1>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<?php } ?>